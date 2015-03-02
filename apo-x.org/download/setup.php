<pre><?php

// script to create file management table in the database
include_once 'database.inc.php';

db_open();

$sql = 'SELECT * FROM file';
echo $sql,"\n";
$result = mysql_query($sql);

if(mysql_errno()==1146) // table doesnt exist
{
	$sql = 'CREATE TABLE file ( '
		. ' title VARCHAR(128) NOT NULL, '
		. ' filename VARCHAR(64) NOT NULL, '
		. ' description BLOB NOT NULL, '
		. ' filetype_id INT NOT NULL, '
		. ' PRIMARY KEY (filename, filetype_id) '
		. ' ) TYPE = innodb ';
		
	mysql_query($sql) or die('error: ' . mysql_error());
	
	echo "Table `file` is now set up.\n";
}
else
{
	echo "Table `file` has already been set up.\n";
}


$sql = 'SELECT * FROM filetype';
echo $sql,"\n";
$result = mysql_query($sql);

if(mysql_errno()==1146) // table doesnt exist
{
	$sql = 'CREATE TABLE filetype ( '
		. ' name VARCHAR(32) NOT NULL, '
		. ' id INT NOT NULL AUTO_INCREMENT, '
		. ' description BLOB NOT NULL, '
		. ' PRIMARY KEY (id) '
		. ' ) TYPE = innodb ';
		
	mysql_query($sql) or die('error: ' . mysql_error());
	
	echo "Table `filetype` is now set up.\n";
}
else
{
	echo "Table `filetype` has already been set up.\n";
}

db_close();


// reference query
/*
CREATE TABLE `awdwaa` (
`moo` INT NOT NULL AUTO_INCREMENT ,
`bah` TIMESTAMP NOT NULL ,
`la` VARCHAR( 255 ) NOT NULL ,
`lala` INT DEFAULT '3',
PRIMARY KEY ( `moo` )
);
*/

?></pre>
