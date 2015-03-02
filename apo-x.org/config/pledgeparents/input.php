<?php
/*
*	If you want to write your own handler for user merges with a given table,
*	include the name of that table in the "dontTouch" array when db_getForeigners
*	is called, and call your own handler.  Say you wanted to ignore the wiki tables, 
*	phorum tables, and the tracking table.  You'd change this:
*	$tables = db_getForeigners('user', 'user_id');
*
*	to this:
*
*	$tables = db_getForeigners('user', 'user_id', array('wiki_%', 'phorum_%', 'tracking') );
*
*	The % is a wildcard in SQL which catches the various tables which start with 'wiki_' and 
*	'phorum_'.  If at all possible, you should append any UPDATE or DELETE queries generated
*	by your handler to the variable $sql, which will include all of the updates/deletes in
*	a transaction.
*/
include_once 'template.inc.php';

$class = $_SESSION['class'];

if ( isset($_POST['re-direct']) )
	$redirect=$_POST['re-direct'];
else
	$redirect='index.php';
	
	$redirect = ''; //FOR DEBUGGING
	print_r($_POST);
	echo "\n----(end \$_POST)----\n";

if($class != 'admin')
	show_note('You must be logged in as excomm to use this page.');

if ($_POST['part'] == 'userMerge5')
{
	//deal with foreign keys which didn't have conflicts
	//(this catches most of them)
	$secondary_keys = explode (',', $_POST['secondary_keys']);
	unset ($_POST['secondary_keys']);
	$new = $_POST['new'];
	$old = $_POST['old'];
	$sql = '';
	
	print_r($secondary_keys);
	
	foreach ($secondary_keys as $pair)
	{
		if ($pair != '')
		{	$tableName = strtok ($pair, '.');
			$key = strtok ('*');
			$sql .=  "UPDATE `$tableName` SET `$key`='$new' "
				. "WHERE `$key`='$old';\n";
				
			/*//mysql_query($sql);
			//$error = mysql_errno();
			
			if ($error != 0)
			{
				switch ($error)
				{
					//duplicate entry
					case 1062:
					echo "\nSQL: $sql\nError: '".mysql_error()."'\n";
					break;
					
					default:
					echo "\nSQL: $sql\nError: '$error'\n";
				}
			}*/
		}
	}
	
	$tables = db_getForeigners('user', 'user_id');
	$postVars = array_keys($_POST);
	$conflicts = array();	$violations = array();
	
	foreach ($postVars as $key)
	{
		if ( strpos($key, 'conflict_`') === 0 )
		//this branch records the decision made in the last page of user merge
		{
			$temp = strtok($key, '`');
			$table = strtok('`');
			$column = strtok('`'); //should grab till the end of the line
			$decision = $_POST[$key];
			
			$conflicts[$table.'.'.$column] ['conflict']= 
			array (
						'table' => $table,
						'column' => $column,
						'decision' => $decision
				);
		}
		
		//this branch attends to unique keys that will get violated by updating
		//the old user_id to the new.
		else if ( strpos($key, 'violationsBy_`') === 0 )
		{
			$temp = strtok($key, '`');
			$table = strtok('`');
			$column = strtok('`'); //should grab till the end of the line
			$uniques = $_POST[$key];
			
			$conflicts[$table.'.'.$column] ['constraints'] = array();
			
			//for EACH unique constraint
			for ($constraint = strtok ($uniques, '@'); $constraint !== false;
					$constraint = strtok ('@') )
			{
				//foreign keys that point to user_id in this constraint
				$userID_fkeys = array();
				//keys in this constraint which DON'T point to user_id
				$constraintKeys = array();
				
				//get each column name in the constraint
				for($constraintColumn = strtok($constraint, '`,'); $constraintColumn !== false;
						$constraintColumn = strtok('`,') )
				{
					//if it points to user.user_id and the ON UPDATE rule is CASCADE,
					//add it to this list
					if ( 0 === strcasecmp(
							$tables[$table]['keys'][$constraintColumn]['rule']['update'], 'cascade') 
						)
						$userID_fkeys[$constraintColumn] = $constraintColumn;
					else
						//add it to the list of keys in this constraint which
						//aren't foreign keys pointing to user_id
						$constraintKeys[] = $constraintColumn;
				}
											
				//conflicts will be anticipated as follows:
				//look for any tuples which, when updated from the old user_id to the new user_id,
				//would be a duplicate of some tuple which already exists (in that the current unique
				//constraint is violated)
				$testsql = "SELECT a.* FROM `$table` AS a, `$table` AS b WHERE 1 \n";
				
				//use this to ignore any tuple which has all fkeys already holding $new
				$unchanging = '';
				//use this to ignore the a=b case
				$samenessString = '';
				foreach ( $userID_fkeys as $fkey )
				{
					$testsql .= " AND ( a.$fkey = '$old' OR a.$fkey = '$new' ) "
								. "AND b.$fkey = '$new'\n";
					$unchanging .= "AND a.$fkey = '$new' ";
					$samenessString .= "AND a.$fkey = b.$fkey ";
				}
				$testsql .= " AND NOT (  (1 $unchanging ) OR (1 $samenessString ) ) ";
				
				foreach ($constraintKeys as $field)
				{
					//if (strcmp($field, $column) !== 0)
						$testsql .= " AND a.$field = b.$field ";
				}
				
				echo "\nConflict Scanning: $constraint for `$table`.`$column`\nSQL:\n$testsql\n\n";
				echo "Fkeys:\n";
				print_r ($userID_fkeys);
				echo "\nConstraintKeys:\n";
				print_r ($constraintKeys);
				$result = db_select($testsql, "Error finding conflicts involving `$table`.`$column`: ".mysql_error() );
				
				echo "Result:\n";
				print_r($result);
				
				//it's only worth adding to the list if any conflicts exist
				if ( count($result) > 0 )
					$conflicts[$table.'.'.$column] ['constraints'] [] = 
					
										array( 'keys' => $constraintKeys,
												'uid_fkeys' => $userID_fkeys,
												'conflict_tuples' => $result
											);
				
			}
			
			
		}
		
	}
	
	echo "STINKER:\n";
	print_r ($conflicts);
	
	foreach($conflicts as $conflict)
	{
		switch ($conflict['conflict']['decision'])
		{
			//delete both sets of records
			case "deleteBoth":
				$sql .= "DELETE FROM `$table` WHERE `$column` = '$old';\n"
					. "DELETE FROM `$table` WHERE `$column` = '$new';\n";
			break;
			
			//don't do anything
			case "keepBoth":
			break;
			
			//this should catch when a user_id is passed instead of deleteBoth or keepBoth
			//$decision specifies which user_id to delete
			default:
				$sql .= "DELETE FROM `$table` WHERE `$column` = '$decision';\n";
			break;
		}
	}
	
	echo "\n\nSQL:\n$sql\n";
	
	//mysql_query($sql) or die('user merge (dealing with primaries)' . mysql_error());
	
	//Finally, delete the user from the user table.
	$sql = "start transaction;\n" . $sql
	. "DELETE FROM `user` WHERE `user_id` = '$old';"
	. "INSERT INTO `user_merged` (`old`, `new`) VALUES ('$old', '$new');\n"
	. 'commit;';
	//mysql_query($sql) or die('user merge (delete old user from user table)' . mysql_error());
	echo "SQL:\n$sql\n";
}

?>
<html>
<head>
<?php if($redirect!='')//DEBUGGING
		echo '<meta http-equiv="refresh" content="0;url=' . $redirect . '">'; 
?>
</head>
</html>
