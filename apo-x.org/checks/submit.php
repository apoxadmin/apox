<?php

include_once 'template.inc.php'; 
include_once 'database.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

<?php get_header(); ?>

$myid = $_SESSION['id'];
$myclass = $_SESSION['class'];
$action = $_REQUEST['action'];
if(isset($_GET['action']))
  $action = $_GET['action'];

if(!isset($_REQUEST['redirect']))
	$redirect = '/checks/list.php';
else
	$redirect = $_REQUEST['redirect'];
	
if ($action = 'update')
{
	$sql = 'UPDATE checks'
	. " SET person = '$_POST[person]', amount = '$_POST[amount]', reason = '$_POST[reason]', status = '$_POST[status]' WHERE id = '$_POST[ID]'";
	mysql_query($sql);
}
else
{
	$sql = 'INSERT INTO checks (person, amount, reason, status)'
	. " VALUES ('$_POST[person]','$_POST[amount]','$_POST[reason]','$_POST[status]')";
	mysql_query($sql);
}
	?>
	
	
<HTML>
<HEAD>
<meta http-equiv="refresh" content="0;url=<?php echo $redirect ?>">
</HEAD>
</HTML>
