<?php 

include_once 'template.inc.php';
include_once 'session.inc.php';

$myid = $_SESSION['id'];
$myclass = $_SESSION['class'];
$action = $_REQUEST['action'];

function bro_add($big, $little)
{
	$sql = 'REPLACE INTO bro (big, little) '
			. "VALUES ($big, $little) ";
			
	mysql_query($sql) or die('Inserting relationship failed!');
}

function bro_delete($big, $little)
{
	$sql = 'DELETE FROM bro WHERE '
			. " big = '$big' AND little = '$little' ";
			
	mysql_query($sql) or die('Deleting relationship failed!');
}

function user_add($name, $class, $family, $email)
{
    $query = " INSERT INTO user (user_name, family_id, class_id, user_email)"
           . " VALUES ('$name', '$family', '$class', '$email')";
    mysql_query($query) or die("Couldn't add new person =( ".mysql_error());

    $_SESSION['confirmation'] = "$name was added to database.";
}

function autoinvis()
{
	// set all users to invisible
	$sql = 'UPDATE user SET user_hidden=1 WHERE 1';
	mysql_query($sql) or die("Couldn't set all to invisible!");
	
	// check all event tracking for the last 2 years and change all tracked users to visible
	$sql2 = 'SELECT user_id FROM event NATURAL JOIN tracking NATURAL JOIN user WHERE'
		. ' status_id NOT IN ('.STATUS_DEPLEDGE.','.STATUS_DEACTIVATED.') AND'
		. ' event_date > FROM_UNIXTIME(\''.strtotime("-2 years").'\')'
		. ' GROUP BY user_id';
	
	$result = mysql_query($sql2) or die("Couldn't get all tracking!");

	while($line = mysql_fetch_assoc($result))	//create a list of all tracked users
		$trackedUsers .= "{$line['user_id']},";
	$trackedUsers = substr($trackedUsers, 0, -1);
	
	$sql3 = "UPDATE user SET user_hidden=0 WHERE user_id IN ($trackedUsers)";
	mysql_query($sql3) or die("Couldn't set tracked users to visible!");
}

function setstatus($id, $status, $invis)
{
	$sql = "UPDATE user SET status_id='$status' AND user_hidden='$invis' WHERE user_id='$id'";

	mysql_query($sql) or die('Updating user status failed!');

}

db_open();

if($action=='add')
	bro_add($_POST['big'], $_POST['little']);
elseif($action=='delete')
	bro_delete($_POST['big'], $_POST['little']);
elseif($action=='autoinvis')
	autoinvis();
elseif($action=='setstatus')
	setstatus($_POST['id'], $_POST['status'], $_POST['invis']);
elseif($action=='adduser')
    user_add($_POST['name'], $_POST['class'], $_POST['family'], $_POST['email']);

?>
<HTML>
<HEAD>
<meta http-equiv="refresh" content="0;url=<?php echo $_REQUEST['redirect'] ?>">
</HEAD>
</HTML>
