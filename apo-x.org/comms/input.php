<?php 
include_once 'template.inc.php'; 

$myid = $_SESSION['id'];
$myclass = $_SESSION['class'];
$action = $_REQUEST['action'];
if(!isset($_REQUEST['redirect']))
	$redirect = '/comms/index.php';
else
	$redirect = $_REQUEST['redirect'];

function comm_update($title, $body, $id)
{
	$sql = "UPDATE `comm` SET ".
	" `comm_title` = '$title', comm_body = '$body' "
	. " WHERE comm_id = '$id' ";

	mysql_query($sql);
}

function comm_create($title, $body)
{
	$sql = 'INSERT INTO `comm` ( `comm_title` , `comm_body` ) '
	. " VALUES ('$title', '$body')";

	mysql_query($sql);
}

if($action=='update')
{
	comm_update($_POST['title'], $_POST['body'], $_POST['id']);
}
elseif($action=='create')
{
	comm_create($_POST['title'], $_POST['body']);
}

?>
<HTML>
<HEAD>
<meta http-equiv="refresh" content="0;url=<?php echo $redirect ?>">
</HEAD>
</HTML>
