<?php
include_once 'template.inc.php';
include_once 'forms.inc.php';

if($_SESSION['class'] == 'admin')
	$edit = true;
else
	show_note('You must be on excomm to use this page.');
	
if(isset($_GET['function']))
	$function = $_GET['function'];
else
	$function = 'default';

show_header();

echo "<div class=\"general\">\n";

if ($function=='default')
{
?>
<H3>THIS FEATURE IS NOT FINISHED.  You can experiment withh it to see how it works, but it will not submit any
changes.<br/><a href="<?= $_SERVER['PHP_SELF'] ?>?function=usermerge">Merge two users together</a></H3>
<?php
}
else if ($function=='usermerge')
{
	//Begin User merge function
	
	include_once 'user.inc.php';
	include_once 'show.inc.php';
	
	//if we haven't chosen any users yet (this is the first stage)
	if ( !isset($_POST['part']) )
	{
		echo '<H2>Choose at least 2 users to start the merge process. '
		.'<a href="/config/pledgeparents/index.php">(back)</a></H2>'
		." If you're not sure who you're looking for, you can choose as"
		." many people as you want. User information will be displayed so"
		." that you can make sure you're working with the right people"
		." before you merge them.<br/>\n<br/>\n"
		."<form action=\"{$_SERVER['PHP_SELF']}?function=usermerge\" method=\"POST\">\n"
		.'<input type="submit" name="submit" value="Continue" />'
		."<br/>\n<br/>\n";
	
		show_users( user_getAll() );	//display all users to choose from
		
		forms_hidden("function", "usermerge");
		forms_hidden("part", "userMerge2");
		echo '<input type="submit" name="submit" value="Continue" />'
			."\n</form>\n";
	}
	
	//if we -have- chosen some users to get info on
	else if ($_POST['part'] == 'userMerge2' || 
		( $_POST['part'] == 'userMerge3' && count($_POST['user']) != 2) )
	{
		if ( $_POST['part'] == 'userMerge3' && count($_POST['user']) != 2)
		{
			echo "<H2>You didn't select exactly two users.  Please try again.</H2>\n";
			$userlist = explode(',', $_POST['backupUsers']);
		}
		else
		{
			echo "<H2>Select just 2 users to continue the merge process.</H2>\n";
			$userlist = $_POST['user'];
		}
			
		echo "</div>\n<div name=\"users\">"
		. "<form action=\"{$_SERVER['PHP_SELF']}?function=usermerge\" method=\"POST\">\n"
		. '<input type="submit" name="submit" value="Continue" /><br>';
		
		show_profiles($userlist);
		forms_hidden("part", "userMerge3");
		//in case they don't select exactly 2 users, store the list
		forms_hidden("backupUsers", implode(',', $userlist));
		echo '<br>
<input type="submit" name="submit" value="Continue" />
</form>';
	}
	
	//if we've chosen two users and are ready to decide how to merge
	else if ($_POST['part'] == 'userMerge3')
	{
		if ( isset($_POST['new']) && isset($_POST['old']) )
		{
			$new = $_POST['new'];
			$old = $_POST['old'];
		}
		else
		{
			$user1 = $_POST['user'][0];
			$user2 = $_POST['user'][1];
			
			//First figure out which user_id is the old one and which is the new
			//If there's tracking for both accounts, the old account will be 
			//the one which was tracked for the oldest event
			
			$sql = 'SELECT `user_id` FROM `tracking` NATURAL JOIN `event`'
					. "WHERE `user_id` IN ('$user1', '$user2')"
					. 'GROUP BY `user_id` ORDER BY MIN(`event_date`) ASC LIMIT 1';
				
			$old = db_select1($sql, "Error while trying to get the oldest user!");
			
			if ( isset ($old['user_id'] ) )
				$old = $old['user_id'];
			else
				$old = min ($user1, $user2);
				
			if ($user1 == $old)
				$new = $user2;
			else
				$new = $user1;
		}



		// User merge won't change any tables whose name includes a word
		// in this array. I'm not sure why you'd need such a thing, as
		// user merge only touches tables which already have the user table
		// as a foreign key, but it's there just in case.  It would look like
		// this: $dontTouch = array('wiki_%', 'phorum_%'); and be passed as
		// the third argument to db_getForeigners
		
		$tables = db_getForeigners('user', 'user_id');
		?>
		<div class="general">
		<H3>User data for both accounts will be merged into the newest account.<br/>
		This is recognized as the newest account:</H3>

		<form action="<?= $_SERVER['PHP_SELF'] ?>?function=usermerge" method="POST" />
		<input type="submit" value="Not the newest one" />
		<br/>
		<br/>
		<?php
		show_profiles($new, 'New account');
		forms_hidden ("new", $old);
		forms_hidden ("old", $new);
		forms_hidden ("user[]", $new);	//necessary so that the userMerge2 test
		forms_hidden ("user[]", $old);	//won't catch it
		forms_hidden ("part", "userMerge3");
		?>
		<br/>
		<input type="submit" value="Not the newest one" /> </form>
		</div>
		<div class="general">
		<form name="userMerge" action="input.php" method="POST">
		<H2>The following tables need a special decision from you.</H2>
		<H3> Some of the data in these tables will develop duplicates when the old user_id is replaced
		by the new one. This is where you decide what to do with the tuples that will conflict (those that
		don't conflict won't be changed). You can:<br/>
		<br/>
		<code>Keep the tuple with the old user_id<br/>
		Keep the tuple with the new user_id<br/>
		Or delete them both<br/></code>
		  <br>
		  You can see the table comments stored in the database for each listed column's table by mousing over 
		  the row. <i>If you aren't sure about what one of these tables does, PLEASE contact an 
		  older admin to find out BEFORE using this feature!</i></H3><br/>
		
		<table><tr><th>Column</th><th>ON UPDATE</th><th>ON DELETE</th><th><i>Keep Old</i></th>
		<th><i>Keep New</i></th><th>Delete Both</th><th>Keep Both</th></tr>
		<?php
		
		forms_hidden ("new", $new);
		forms_hidden ("old", $old);
		forms_hidden ("part", "userMerge5");
		$secondaries = '';
		$conflicts = array();
		
		foreach ($tables as $tableName => $table)
		{
/*			Here's the plan:
*			If a foreign key pointing to the user table has to be unique (either by being part of the
*			primary key or by inclusion in a UNIQUE() statement), then we need
*			to see whether updating the old user_id in all tuples to the new user_id will create a
*			conflict.  If it does, we need to leave it to the user to decide whether to keep the 
*			old tuple, keep the new tuple, or delete both (only in the case of conflicts).  
*/
			
			//create an array of the names of the columns in each unique constraint, starting
			//with the primary key.
			
			foreach ($table['unique keys'] as $index => $constraint)
			{
				$table['unique keys'][$index]['keyList'] = array();
				$table['unique keys'][$index]['keyList'][] = strtok($constraint['key string'], '`,');
				while ( $table['unique keys'][$index]['keyList'][] = strtok('`,') ) ;	//key definition looks like this: `key1`,`key2`
				//var_dump ($table['unique keys']);
				unset ( $table['unique keys'][$index]['keyList'] [ count($table['unique keys'][$index]['keyList']) - 1 ] );	//the last element is blank
			}

			//this loop will test each constraint for conflicts
			foreach ($table['unique keys'] as $index => $constraint)
			{
				foreach ($constraint['keyList'] as $columnName)
				{
					//if this item in the unique key list is also foreign key pointing to the user table
					if (isset ($table ['keys'][$columnName]))
					{
						//conflicts will be anticipated as follows:
						//look for any tuples which, when updated from the old user_id to the new user_id,
						//would be a duplicate of some tuple which already exists
						$sql = "SELECT * FROM `$tableName` AS a, `$tableName` AS b WHERE \n"
							. " a.$columnName = '$old' AND b.$columnName = '$new' ";
						foreach ($constraint['keyList'] as $field)
						{
							if (strcmp($field, $columnName) !== 0)
							{
								$sql .= " AND a.$field = b.$field ";
							}
						}
						$sql .= ' LIMIT 1 ';
						
						$result = db_select1($sql, 'failed trying to find conflicts', true);
						if ($result)
						{
							//only one entry per column
							if (!isset ($conflicts[$tableName.'.'.$columnName]) )
								$conflicts[$tableName.'.'.$columnName] = 
											array(
													'table' => $tableName,
													'uniqueIndex' => $index,
													'column' => $columnName,
												);
												
							//this string will hold every constraint which has been violated
							//	by this key.
							$conflicts[$tableName.'.'.$columnName]['violations'] .= "@{$constraint['key string']}";
						}
							
					}
					
					/*echo "\nCONFLICT TESTING:\ntable: `$tableName`\nUnique Key: '{$constraint['key string']}'\n"
					. "Column: '$columnName'\n\n"
					. "SQL:\n$sql\n"
					. "Result:\n";
					var_dump($result);*/
				}				
			}
			
			//this stores the keys which reference user.user_id but won't have any conflicts
			foreach ($table['keys'] as $key => $column)
				if (!isset ($conflicts["$tableName.$key"]) )
					$secondaries .= $tableName . '.' . $key . ',';
		}
		
		forms_hidden ('secondary_keys', $secondaries);
		
		foreach ($conflicts as $conflict)
				{
					$column = $conflict['column'];
					$tableName = $conflict['table'];
					$table = &$tables[$tableName];
				
					if ( isset ( $table['comments'] ) )	//"'s would mess up the HTML, so make them '
						$table['comments'] = str_replace( '"', "'", $table['comments']);
						
					echo "<tr title=\"$tableName: {$table['comments']}\"><td>" . $tableName.'.'.$column.'</td><td>'
					.$table['keys'][ $column ]['rule']['update'] . '</td><td>'
					.$table['keys'][ $column ]['rule']['delete'] . '</td><td>';
					
					forms_hidden("violationsBy_`$tableName`$column", $conflict['violations']);
					
					//if the rule is ON DELETE CASCADE, you CAN'T preserve the old account's data
					if ( strcasecmp ($table['keys'][ $column ]['rule']['delete'], 'cascade') !== 0)
						//you're telling input.php which user_id to DELETE
						forms_radio('conflict_`'.$tableName.'`'.$column, $new, 0);
						
					echo '</td><td>';
					
												//you're telling input.php which user_id to DELETE
					forms_radio('conflict_`'.$tableName.'`'.$column, $old, 1);
					echo '</td><td>';
					forms_radio('conflict_`'.$tableName.'`'.$column, 'deleteBoth', 0);
					echo '</td><td>';
					
					//if the rule is ON DELETE CASCADE, you CAN'T preserve the old account's data
					if ( strcasecmp ($table['keys'][ $column ]['rule']['delete'], 'cascade') !== 0)
						forms_radio('conflict_`'.$tableName.'`'.$column, 'keepBoth', 0);
						
					echo '</td><tr>';
					
					//don't want it dealt with as a part of $secondaries
					unset ($tables[$conflict['table']]['keys'][$column]);
				}

		?>
		</table>

		<?php forms_submit("Submit");
		echo "\n</form>\n</div>"; 
	}
	else
	{
		show_note ("Error! Unknown part of function User Merge requested!");
	}
}
?>
</div>
<?php

show_footer();
?>
