<?php 
include_once 'template.inc.php'; 

$myid = $_SESSION['id'];
$myclass = $_SESSION['class'];
$action = $_REQUEST['action'];
if(!isset($_REQUEST['redirect']))
	$redirect = '/retreat/list.php';
else
	$redirect = $_REQUEST['redirect'];

function update_db($user, $sport)
{
	$sql = 'INSERT INTO `athletic_interest`'
	. " VALUES ('$user', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)";
	mysql_query($sql);
	
	//Add updating later
	/*if(!mysql_query($sql))
	{	
		if(mysql_errno()==1062) // duplicate entry
		{
			$sql = "UPDATE `retreat` SET `soccer` = '$a', "
				. " `swimming` = '$b', "
				. " `football` = '$c', "
				. " `ultimate_frisbee` = '$d', "
				. " `tennis` = '$e', "
				. " `badminton` = '$f', "
				. " `basketball` = '$g', "
				. " `running` = '$h', "
				. " `camping` = '$i', "
				. " `fishing` = '$j', "
				. " `hiking` = '$k', "
				. " `cycling` = '$l', "
				. " `working_out` = '$m' "
				. " WHERE `user_id` = '$user'";
			
			mysql_query($sql) or die("1: " . mysql_error());
		}
		else
		{
			die("2: " . mysql_error());
		}*/
		if(is_array($sport))
		{
			foreach($sport as $value)
			{
				$column = $value;
				$sql = "UPDATE `athletic_interest` SET `$column`='1' WHERE `user_id` = $user";
				print $sql;
				mysql_query($sql);
			}
		
		}
		
	}
	


if($action=='update')
{
	update_db($_POST['user'], $_POST['sport']);
}
elseif($action=='delete')
{
	$sql = "DELETE FROM atheltic_interest WHERE user_id = '$myid' LIMIT 1";
	mysql_query($sql);
}

?>
<HTML>
<HEAD>
<meta http-equiv="refresh" content="0;url=<?php echo $redirect ?>">
</HEAD>
</HTML>
