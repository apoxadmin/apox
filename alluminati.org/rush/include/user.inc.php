<?php

include_once 'database.inc.php';

function user_getID($name, $password)
{
	//Catches people attempting to read someone else's password from the My Profile page
	//when the victim forgot to log out.  That page inserts a fake password into the box.
	if ( strcmp($password, 'jesuisunconninmouflant') == 0 )
		show_note ('Oui! Vous &ecirc;tes un connin mouflant! Je voudrais avoir une petite mort dans vous.');
		
	// name can be email, first+last, screen name, or either phone
	$name = strtolower($name);
	$name = str_replace(" ","",$name);
	$name = str_replace("%20","",$name);
	$password = md5( $password );
	
	if(strlen($name)>=1)
	{
		$sql = "SELECT user_id FROM user "
		. " WHERE user_password = '$password' and "
		. " (LOWER(user_email) = '$name' or REPLACE(user_name,' ','') = '$name' "
		. " or LOWER(REPLACE(user_aim,' ','')) = '$name' or user_cell = '$name' ) ";
		
		$id = db_select1($sql, 'Error looking in user table!');
		$id = $id['user_id'];
	}
	
	return $id;
}

function user_validate($name, $password)
{
	// name can be email, first+last, screen name, or either phone
	$name = strtolower($name);
	$name = str_replace(" ","",$name);
	$name = str_replace("%20","",$name);
	$password = md5( $password );
	
	if(strlen($name)>=5)
		$sql = "SELECT user.*, status_name FROM user, status ON user.status_id = status.status_id "
		. " WHERE user_password = '$password' and "
		. " (LOWER(user_email) = '$name' or REPLACE(user_name),' ','') = '$name' "
		. " or LOWER(REPLACE(user_aim,' ','')) = '$name' ) ";
	else
		$sql = 'select 0 from user where 0';
	
	return db_select1($sql);
}

function user_get($id,$format)
{
	//ipfaeFcPCA
	$select = '';
	if(strstr($format,'i')!=false) $select .= '`user_id` AS id, ';
	if(strstr($format,'p')!=false) $select .= '`user_password` AS password, ';
	if(strstr($format,'f')!=false) $select .= '`user_name` AS name, ';
	if(strstr($format,'a')!=false) $select .= '`user_address` AS address, ';
	if(strstr($format,'e')!=false) $select .= '`user_email` AS email, ';
	if(strstr($format,'F')!=false) $select .= '`family_id` AS family, ';
	if(strstr($format,'c')!=false) $select .= '`class_id` AS class, ';
	if(strstr($format,'P')!=false) $select .= '`user_phone` AS phone, ';
	if(strstr($format,'C')!=false) $select .= '`user_cell` AS cell, ';
	if(strstr($format,'A')!=false) $select .= '`user_aim` AS aim, ';
	$select = trim($select,", ");
	
	$sql = 'SELECT ' . $select . ' FROM `user` WHERE `user_id` = \''. $id . '\'';
	
	return db_select1($sql);
}

// separate function because it's called so frequently
function user_getUsername($id)
{ 
	$sql = 'SELECT user_name AS first FROM user '
			. " WHERE  status_id NOT IN (".STATUS_ADMINISTRATOR.','.STATUS_DEPLEDGE.','.STATUS_INACTIVE.','.STATUS_ALUMNI.','.STATUS_ADMINISTRATOR.','.STATUS_DEACTIVATED.") AND user_hidden = '0'  AND user_id = '$id'";
	
	$result = mysql_query($sql) or die("Query Failed!");
	
	$line = mysql_fetch_assoc($result);
	$uname = $line['first'];
	
	mysql_free_result($result);
	
	return $uname;
}

function user_getAll()
{
	$sql = "SELECT user_id as id, user_name "
		. " as name from user where status_id NOT IN (".STATUS_ADMINISTRATOR.','.STATUS_DEPLEDGE.','.STATUS_INACTIVE.','.STATUS_ALUMNI.','.STATUS_ADMINISTRATOR.','.STATUS_DEACTIVATED.") AND user_hidden = '0' "
		. " order by user_name asc";
	
	$result = mysql_query($sql) or die("Query Failed (user_getAll)!". mysql_error());
	
	$users = array();
	while($line = mysql_fetch_assoc($result))
		array_push($users,$line);
	
	mysql_free_result($result);
	
	return $users;
}

function user_getsuperAll()
{
	$sql = "SELECT user_id as id, user_name "
		. " as name from user where status_id NOT IN (".STATUS_ADMINISTRATOR.") AND user_hidden = '0' "
		. " order by user_name asc";
	
	$result = mysql_query($sql) or die("Query Failed (user_getAll)!". mysql_error());
	
	$users = array();
	while($line = mysql_fetch_assoc($result))
		array_push($users,$line);
	
	mysql_free_result($result);
	
	return $users;
}

function user_updateLastLogin($id)
{
	$sql = "UPDATE user SET last_login = NOW() WHERE user_id = '$id' LIMIT 1";
	$result = mysql_query($sql) or die("Query Failed (user_updateLastLogin)!". mysql_error());	
}

?>
