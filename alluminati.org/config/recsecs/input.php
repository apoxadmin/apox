<?php

include_once 'template.inc.php';

$action = $_POST['action'];
$class = $_SESSION['class'];

if ( isset($_POST['re-direct']) )
	$redirect=$_POST['re-direct'];
else if ( $_POST['class_id'] != 'null' )
	$redirect="index.php?term={$_POST['class_id']}";
else
	$redirect='index.php';

if($class != 'admin')
	show_note('You must be logged in as excomm to set up the term.');

if (isset($_POST['submit']))
{
	$start = strtotime("{$_POST['class_start']} {$_POST['start_time']}");
	$year = date("Y", $start);
	$class_start = date("Y-m-d H:i:s", $start);
	
	if ($_POST['class_id']!='null') //updating existing entry
	{
		$sql = "UPDATE `class` SET class_name='{$_POST['class_name']}', class_nick='{$_POST['class_nick']}', "
		. "class_term='{$_POST['class_term']}', class_year='$year', class_start='$class_start', "
		. "class_mascot='". mysql_real_escape_string($_POST['class_mascot'])	//some class mascots have SQL unsafe characters
		."', class_spokesperson='{$_POST['class_spokesperson']}' "
		. "WHERE class_id='{$_POST['class_id']}'";
		mysql_query($sql) or die('Term update failed! ' . mysql_error());
	}
	else //creating a new entry
	{
		$sql = "INSERT INTO `class` (`class_name`, `class_nick`, `class_term`, `class_year`, `class_start`, "
		. " `class_mascot`, `class_spokesperson`) "
		. "VALUES ('{$_POST['class_name']}', '{$_POST['class_nick']}', '{$_POST['class_term']}', "
		. "'$year', '$class_start', '" . mysql_real_escape_string($_POST['class_mascot'])	//some class mascots have SQL unsafe characters
		. "', '{$_POST['class_spokesperson']}')";
		mysql_query($sql) or die('Term creation failed! ' . mysql_error());
	}
}
else if(isset($_POST['confirm_delete']))
{
	$redirect = '';
	show_header(); ?>
<div class="general">
Are you sure you want to delete <b><?= $_POST['class_name'] ?></b> term?  It will also erase all money tracking for that period.<br/>
<b>This cannot be undone!</b>
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
<table>
<tr><td align="left"><input name="cancel_delete" type="submit" value="Cancel"></td>
<td align="right"><input name="delete_account" type="submit" value="Delete" onClick="return confirm('Really delete this entire term?');"></td></tr>
</table>
<input name="class_id" type="hidden" value="<?= $_POST['class_id'] ?>">
</form>
</div>
<?php
	show_footer();
}
else if(isset($_POST['delete_account']))
{
	$sql = "DELETE FROM class WHERE class_id='{$_POST['class_id']}' LIMIT 1";
	mysql_query($sql) or die('Term deletion failed! ' . mysql_error());
}

?>
<html>
<head>
<?php if($redirect!='')
		echo '<meta http-equiv="refresh" content="0;url=' . $redirect . '">'; ?>
</head>
</html>
