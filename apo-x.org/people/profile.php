<?php 

include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/show.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');




get_header();

if(isset($_SESSION['id']))
	$user_id = $_SESSION['id'];
else
{
	print "You are not logged in.";
	show_footer();
	exit;
}

$class = $_SESSION['class'];

if(isset($_GET['user']))
	$user_id = (int)$_GET['user'];

if ( $user_id <= 0 )
{
	print "That person doesn't exist.";
	show_footer();
	exit;
}
$sql = 'SELECT user_name, family_name, class_nick, user_address,'
        . ' user_phone, user_cell, user_email, user_aim, user_password, major'
        . ' FROM user, class, family'
		. " WHERE user_id = '$user_id' "
		. ' AND user.class_id = class.class_id '
        .  ' AND user.family_id = family.family_id' ;
$line = db_select1($sql);
if ( !is_array( $line ) )
{
	print "That person doesn't exist.";
	show_footer();
	exit;
}

extract($line);

$user_phone = show_phone($user_phone);
$user_cell = show_phone($user_cell);

?>

<table class="table table-condensed table-bordered">
	<tr>
		<td colspan="3" class="heading"><?php echo $user_name ?></td>
	</tr>
	<tr>
		<td rowspan="10"><img src="/images/profiles/<?php echo $user_id; ?>.jpg" width="333" height="500" /></td>
		<td>Address: </td>
		<td><?php echo $user_address ?></td>
	</tr>
	<tr>
		<td>Primary Phone: </td>
		<td><?php echo htmlentities($user_cell) ?></td>
	</tr>
	<tr>
		<td>Email: </td>
		<td><a href="mailto:<?php echo htmlentities($user_email) ?>"><?php echo htmlentities($user_email) ?></a></td>
	</tr>
	 <tr>
		<td>Family: </td>
		<td><?php echo $family_name ?></td>
	</tr> 
	<tr>
		<td>Class: </td>
		<td><?php echo $class_nick ?></td>
	</tr>
	<tr>
		<td>Major: </td>
		<td><?php echo $major ?></td>
	</tr>
</table>

<?php show_footer(); ?>
