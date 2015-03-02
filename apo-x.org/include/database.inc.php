<?php

include_once 'connection.inc.php';

$database_link = NULL;

/**
 * Open a connection to the database. When in doubt, call it again since it
 * checks if a connection is already open.  By default, it uses the constants
 * set in connection.inc.php to specify the host, but other databases can
 * optionally be referred to, including those on other servers.
 * $name is the name of the database, and $host is the server it's on.
 */
function db_open($name=DB_NAME, $host=DB_HOST, $user=DB_USER, $pass=DB_PASS)
{
    global $database_link;
	
	// is this database already open?
    if($database_link['hostname'] == $host.$name)
        return;
	// close the current connection if a different one is open
	if($database_link['link'] != NULL)
		db_close();
	
	$database_link['hostname'] = $host.$name;
    $database_link['link'] = @mysql_connect($host, $user, $pass)
        or die("Could not connect to host with username: " . mysql_error());
    mysql_select_db($name) 
        or die("Could not select database." . mysql_error());
}
    
//retrieves the class_id and/or class_start date of the current term
//pass as argument 'all' (equivalent to void), 'class_id', or 'start' (the term's start date)
//only executes a database query once
function db_currentClass ($data = 'all')
{
	//only want this to run once
	if ( !isset($GLOBALS['CURRENT_CLASS_DATA']) )
	{
		$sql = 'SELECT class_id, class_name, class_nick, class_term, class_year, class_mascot, class_spokesperson,'
		. " DATE_FORMAT(class.class_start, '%Y%m%d%h%i%s') as start FROM `class`"
		. ' WHERE class_start < NOW() '
		. ' ORDER BY class_start DESC '
		. ' LIMIT 1 ';
		
		$result = db_select1 ( $sql, 'Could not get current class id and start date: '.mysql_error() );
		
		$GLOBALS['CURRENT_CLASS_DATA'] = $result;
	}
	
	if ( strcmp ($data, 'all') === 0 )
		return $GLOBALS['CURRENT_CLASS_DATA'];
	else
		return $GLOBALS['CURRENT_CLASS_DATA'][$data];
}
	
/**
 * You probably don't want to call this explicitly since sessions depend on
 * an open connection. The session may not get saved and it's hard to debug.
 */
function db_close()
{ 
    global $database_link;
    mysql_close($database_link['link']);
    $database_link['link'] = NULL;
	$database_link['hostname'] = NULL;
}

/**
 * This is a helper function to return the results of a query in an array.
 * By default it's an array with named keys but with $array is true it
 * uses numbered keys.
 */
function db_select($query, $where = 'error', $array = false)
{
    $result = mysql_query($query) or die($where . ': ' . mysql_error());

    $rows = array();

    if($array)
        while($line = mysql_fetch_array($result))
            array_push($rows,$line);
    else
        while($line = mysql_fetch_assoc($result))
            array_push($rows,$line);
    
    mysql_free_result($result);
    
    return $rows;
}

/**
 * This is another helper function that returns a single row from a query.
 * The advantage over db_select() is that it returns an array of columns
 * instead of an array of arrays of columns so you can write
 * $result['my_column'] instead of $results[0]['my_column'].
 */
function db_select1($query, $where = 'error', $array = false)
{
    $result = mysql_query($query) or die($where . ': ' . mysql_error());

    if($array)
        $line = mysql_fetch_array($result);
    else
        $line = mysql_fetch_assoc($result);

    mysql_free_result($result);

    return $line;
}

/**
 * This function is used when you don't care if you're overwriting
 * something or creating a new row. I believe recent versions of
 * mysql have a mechanism to do this without all this hackery so
 * this should probably be rewritten or taken out completely.
 */
function db_insertOrUpdate($table, $pairs, $where = 'error')
{
    $insert = "INSERT INTO `$table` ( ";
    $values = " VALUES ( ";
    $update = "UPDATE `$table` SET ";
    foreach($pairs as $column => $value)
    {
        $insert .= " `$column`, ";
        $values .= " '$value', ";
        $update .= " `$column` = '$value', ";
    }

    // cut last commas off
    $insert = substr($insert,0,-2);
    $values = substr($values,0,-2);
    $update = substr($update,0,-2);

    $insertsql .= $values;

    if(!mysql_query($insert))
    {
        if(mysql_errno()==1062) // duplicate entry
        {
            mysql_query($update) or die($where . ': ' . mysql_error());
        }
        else
        {
            die($where . ': ' . mysql_error());
        }

    }
}

// Added by Wylie to make a more universal function to run any type of query.
function db_run_query($query) {
	$result = mysql_query($query)
		or die("Error: " . mysql_error());
		
	$final = array();
	
	if(is_bool($result))
		return;
	
	while($row = mysql_fetch_assoc($result))
		array_push($final, $row);
	
	return $final;
} //db_run_query

/**
 * This prints a nice traceback so debugging bad queries can be
 * so much easier. This should be used more than it currently is.
 */
function db_printError()
{
    $sql = mysql_error();
    $trace = debug_backtrace();
    $function = $trace[2]['function'];
    $line = $trace[2]['line'];
    $file = $trace[2]['file'];
    $args = $trace[2]['args'];

    echo '<h1>Error! Contact the webmaster!</h1>';
    echo "$file, Line $line:<br>";
    echo "$function( ";
    foreach($args as $arg)
        echo "$arg ";
    echo ")<br>";
}

/**
 * This function gets all the columns in the database that use the
 * given column as a foreign key.  $rule is the delete rule and update rule
 * pair -exactly- as you'd see it in the CREATE TABLE definition 
 * (e.g 'ON DELETE RESTRICT ON UPDATE CASCADE').  $dontTouch is an
 * array of table names to ignore; for example array('wiki_%', 'phorum_%')
 * ignores all tables whose names start with 'wiki_' or 'phorum_'.
 *
 * This function's use of regular expressions should become obsolete when
 * we move to MySQL 5.1 because you'll be able to pull update/delete rules
 * straight from the information_schema.
 */
function db_getForeigners($referencedTable='([\w \t]+)', $referencedColumn='([\w \t]+)', $dontTouch=array() )
{
	//this will get all the columns which reference $referencedColumn, but it's
	//ignorant of the ON UPDATE and ON DELETE rules.
	$sql = "SELECT DISTINCT `KEY_COLUMN_USAGE`.`TABLE_NAME`, `TABLE_COMMENT` FROM `KEY_COLUMN_USAGE` "
		. " LEFT OUTER JOIN `TABLES` ON "
			. "`KEY_COLUMN_USAGE`.`TABLE_SCHEMA` = `TABLES`.`TABLE_SCHEMA` AND "
			. "`KEY_COLUMN_USAGE`.`TABLE_NAME` = `TABLES`.`TABLE_NAME` WHERE "
		. " `KEY_COLUMN_USAGE`.`TABLE_SCHEMA`='". DB_NAME ."' AND `REFERENCED_TABLE_SCHEMA`='".DB_NAME."'";
		if ( strcmp ($referencedTable, '([\w \t]+)') != 0 )
			$sql .= " AND `REFERENCED_TABLE_NAME`='$referencedTable'";
		if ( strcmp ($referencedColumn, '([\w \t]+)') != 0 )
			$sql .= " AND `REFERENCED_COLUMN_NAME`='$referencedColumn'";
	
	for ($i=0; $i<count($dontTouch); $i++)	//ignore tables in $dontTouch
		$sql .= " AND TABLE_NAME NOT LIKE '".$dontTouch[$i]."'";

	db_open('information_schema');	//open the information schema database
	$tables = db_select($sql, "Couldn't get table names from information_schema");
	
	db_open();	//open the chapter's database again	

	//this will store all of the foreign keys that access the desired column
	$foreigners = array();
	
	foreach ($tables as $table)	//These tables reference the desired column. $table is a TABLE_NAME
	{
		//These are the primary keys in this table. This is needed for the user merge function.
		//If the foreign key is NOT also a primary key,
		//then you can keep every tuple and only change the foreign key column(s) so that they match.
		//If it's a primary key, you'll have to delete one of the tuples.
		$primaries = array();
		
		//show the table definition of the table
		$sql = "SHOW CREATE TABLE `{$table['TABLE_NAME']}`";
		$show_create_table_res = mysql_query($sql) or die ("Couldn't show table definition for {$table['TABLE_NAME']}.");
		$row = mysql_fetch_row($show_create_table_res);
		mysql_free_result($show_create_table_res);
		
		//this will extract the column name and ON UPDATE / ON DELETE rules for any foreign keys that point
		//to the table/column we're interested in.
		preg_match_all("@
		
			FOREIGN	[ \t]*	KEY[ \t]*	\(	[ \t]*	`(	[\w, \t`]+	)`	[ \t]*		\)	[^\n]+

			REFERENCES	[ \t]+		`$referencedTable`	[ \t]+
								
													\(	[ \t]*	`$referencedColumn`	[ \t]*	\)	[ \t]*
			
			(?:		ON	[ \t]*	(UPDATE|DELETE)		[ \t]*		(CASCADE|RESTRICT|SET [ \t]* NULL|NO [ \t]* ACTION)		)?	[ \t]*
			
			(?:		ON	[ \t]*	(UPDATE|DELETE)		[ \t]*		(CASCADE|RESTRICT|SET [ \t]* NULL|NO [ \t]* ACTION)		)?	@x",		
				
				$row[1], $results, PREG_PATTERN_ORDER);
				
		//for each column found to be a foreign key
		for ($i=0; $i < count ( $results[1]); $i++)
		{
			$rule = array ('update' => 'NO ACTION', 'delete' => 'NO ACTION');	//initialized because ON UPDATE NULL means
			for ($j=2; $j < 6; $j+=2)
			{
				//if the rule we're looking at is ON UPDATE
				if ( strcmp (strtoupper ($results[$j][$i]), 'UPDATE' ) == 0)
					$rule['update'] = $results[$j+1][$i];
				//if the rule we're looking at is ON DELETE
				else if ( strcmp (strtoupper ($results[$j][$i]), 'DELETE' ) == 0)
					$rule['delete'] = $results[$j+1][$i];
			}
		
			// this will look like: $foreigners[tablename][keys][keyname][on update/ on delete rules]
			$foreigners [$table['TABLE_NAME']] ['keys'] [$results[1][$i]]  ['rule'] = $rule;
		}
										
		//Store the table's primary key in $foreigners[tablename]['unique keys'][0]
		preg_match_all("|PRIMARY[ \t]+KEY[ \t]*\((`[^\)]+`)\)|", $row[1], $results, PREG_PATTERN_ORDER);		
		$foreigners [$table['TABLE_NAME']]	['unique keys']['`PRIMARY`']['key string']  =  $results[1][0];
		
		//Now store all unique keys
		preg_match_all("|UNIQUE[ \t]+KEY[ \t]*
												(`[^`]+`) [ \t]*  
													
													\(   ( `[^\)]+` )    \)   |x", 													
			$row[1], $results, PREG_PATTERN_ORDER);
		
		foreach ($results[1] as $i => $constraintName)
			$foreigners [$table['TABLE_NAME']]	['unique keys'] [ $constraintName ] ['key string'] = $results[2][$i];
		
		$foreigners [$table['TABLE_NAME']]['comments'] = $table['TABLE_COMMENT'];	//get the table's comments
	}
	
	return $foreigners;

}

?>
