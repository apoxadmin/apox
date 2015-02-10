<?php

include_once 'template.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

get_header();

$action = $_POST['action'];
$class = $_SESSION['class'];
$files_dir = "/home/alluminati/alluminati.org/files";

if($class != 'admin')
	show_note('You must be logged in as excomm to edit files.');

if($action == 'addtype')
{
	$type = $_POST['newtypename'];
	$desc = htmlentities($_POST['newtypedesc']);
	$sql = "INSERT INTO filetype (name, description) VALUES ('$type', '$desc') ";
	mysql_query($sql) or die('Could not add new type.');
}
elseif($action == 'addfile')
{
	if(!is_numeric($_POST['type']))
		show_note('You seleted an invalid file category.');
		
	$filetype_id = intval($_POST['type']);
	$uploaddir = "$files_dir/$filetype_id/";
	if(!is_dir($uploaddir))
		mkdir($uploaddir, 0777);
	$uploadfile = $uploaddir . basename($_FILES['file']['name']);
	
	if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) 
	{
		chmod($uploadfile, 0777);
		$title = htmlentities($_POST['title']);
		$desc = htmlentities($_POST['filedesc']);
		$filename = $_FILES['file']['name'];
		$sql = "REPLACE INTO file (title, filename, description, filetype_id) "
			. "VALUES ('$title', '$filename', '$desc', '$filetype_id') ";
		mysql_query($sql) or die('Could not add file to database.');
	} 
	else 
	{
		die("File upload failed!\n");
	}
}
elseif($action == 'removefile')
{
	$fn = $_POST['filename'];
	$type = $_POST['type'];
	
	$sql = "DELETE FROM file WHERE "
		. " filename = '$fn' AND filetype_id = '$type' ";
		
	mysql_query($sql);
	rename("$files_dir/$type/$fn", "$files_dir/backups/$fn");
}
else
{
	show_note('Something went wrong, like the file upload was too big. '
	        . 'Ask the webmaster for help!');
}

?>
<html>
<head>
<meta http-equiv="refresh" content="0;url=<?php echo $_POST['redirect'] ?>">
</head>
</html>

