<?php 

include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/forms.inc.php';
show_header();

if(isset($_SESSION['id']))
	$user_id = $_SESSION['id'];
else
{
	print "You are not logged in.";
	show_footer();
	exit;
}

if( isset($_POST['submit']) && strcmp($_POST['user_password'], 'jesuisunconninmouflant')!==0 )
{
	if ( strcmp($_POST['user_password'], $_POST['user_password_confirm']) !== 0 )
		show_note ("You entered two different passwords!  Please type the same new password "
					. "in the confirmation box. (<a href=\"{$_SERVER['PHP_SELF']}\">Back</a>)");
						
$sql = "UPDATE user set user_password='{$_POST['user_password']}' "
	. " WHERE user_id='$user_id'";
mysql_query($sql);

$sql = "INSERT INTO `update` ( user_id ) VALUES ('$user_id')";
mysql_query($sql);

$updated = true;
}

$sql = "SELECT user_password FROM user WHERE user_id = '$user_id' ";
$user_password = db_select1($sql);
$user_password = $user_password['user_password'];
?>

<table cellspacing="1">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return valid(this)" name="officerUpdateForm" method="POST">
	<tr>
		<td colspan="2" class="heading" align="center">Change Password</td>
	</tr>
	
	<tr>
		<td>Password: </td>
		<td><?php forms_password(32,"user_password", 'jesuisunconninmouflant') ?></td>
	</tr>
	<tr>
		<td>Re-type Password: </td>
		<td><?php forms_password(32,"user_password_confirm", 'jesuisunconninmouflant') ?></td>
	</tr>
	
	<tr>
		<td colspan="3" align="center"><input type="submit" name="submit" value="Update!"></td>
	</tr>
	<?php if($updated): ?>
	<tr>
		<td colspan="3" align="center"><font color="#00FF00"><b>Update successful.</b></font></td>
	</tr>
	<?php endif; ?>
	
</form> 
</table>

<?php show_footer(); ?>
