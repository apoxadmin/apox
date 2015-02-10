<?php
include_once 'template.inc.php';
include_once 'mail.inc.php';
include_once 'forms.inc.php';

if(isset($_GET['event']))
	$event = $_GET['event'];
	
if(isset($_SESSION['id']))
	$id = $_SESSION['id'];
	
if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

mini_header($class, $id);

if($_GET['done'])
{
	echo '<div class="notice"><center>' 
		. 'Message Sent!<br><br><input type="button" value="close" onClick="window.close()" />'
		. '</center></div>';
	mini_footer();
	die();
}

function get_users($event)
{
	$sql = 'SELECT DISTINCT user_email, user_name AS name '
		. ' FROM event, shift, signup, user '
		. ' WHERE event.event_id = shift.event_id AND shift.shift_id = signup.shift_id AND signup.user_id = user.user_id '
		. " AND event.event_id = '$event'"
		. ' ORDER BY user_name';
		
	return db_select($sql);
}

function get_user($id)
{
	$sql = 'SELECT DISTINCT user_email, user_name AS name '
		. " FROM user WHERE user_id = '$id' ";
		
	return db_select1($sql);
}

$users = get_users($event);

$to = '';
foreach($users as $user)
	$to .= $user['user_email'] . ', ';
if($to != '')
	$to = substr($to, 0, -2);
	
$user = get_user($id);
$from = "${user['name']} <${user['user_email']}>";

?>
<form action="/event/input.php" method="POST">
<?php forms_hiddenInput('mail','/event/mail.php?done=1'); 
forms_hidden('from',$from); ?>
<table cellspacing="1">
	<tr><td class="heading">Send Mail</td></tr>
	<tr><th class="small">To:</th></tr>
	<tr><td class="small">
		<textarea name="to" rows=3 cols=90><?php echo $to ?></textarea>
	</td></tr>
	<tr><th class="small">Subject:</th></tr>
	<tr><td class="small">
			<?php forms_text(95,'subject', ''); ?>
	</td></tr>
	<tr><th class="small">Message:</th></tr>
	<tr><td class="small">
			<textarea name="body" rows=8 cols=90></textarea>
	</td></tr>
	<tr><td><input type="submit" value="Send" /></td></tr>
</table>
</form>

<?php
mini_footer();
?>