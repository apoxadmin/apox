<?php 

include_once dirname(dirname(__FILE__)) . '/include/mobiletemplate.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/show.inc.php';

show_rosterheader();

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

$sql = 'SELECT user_name, family_name, class_nick, user_address, '
        . ' user_phone, user_cell, user_email, user_aim, user_password '
        . ' FROM user, class, family '
		. " WHERE user_id = '$user_id' "
		. ' AND user.class_id = class.class_id '
        . " AND user.family_id = family.family_id";
$line = db_select1($sql);

extract($line);

$user_phone = show_phone($user_phone);
$user_cell = show_phone($user_cell);

?>
<div  style="padding-left:35px;"> 
<table cellspacing="1">
	<tr>
		<td colspan="3" class="heading"><?php echo $user_name ?></td>
	</tr>
	<tr>
		<td  rowspan="1" colspan="2"><img style="padding-left:23px;" src="/images/profiles/<?php echo $user_id ?>.jpg" /></td>
	</tr>	
	<tr>
		<td rowspan="1">Address: </td>
		<td><?php echo htmlentities($user_address) ?></td>
	</tr>
	
	<tr class="black">
		<td>Primary Phone: </td>
		<td><?php echo htmlentities($user_cell) ?></td>
	</tr>
<tr class="black">
		<td>Backup Phone: </td>
		<td><?php echo htmlentities($user_phone) ?></td>
	</tr>
	<tr class="black">
		<td>Email: </td>
		<td><a href="mailto:<?php echo htmlentities($user_email) ?>"><?php echo htmlentities($user_email) ?></a></td>
	</tr>
<tr class="black">
		<td>AIM sn: </td>
		<td><img src="http://api.oscar.aol.com/SOA/key=PandorasBoxGoodUntilJan2006/presence/<?php echo htmlentities($user_aim) ?>" /><a href="aim:goim?screenname=<?php echo htmlentities($user_aim) ?>"><?php echo htmlentities($user_aim) ?></a></td>
	</tr>
	<tr>
		<td>Family: </td>
		<td><?php echo $family_name ?></td>
	</tr>
	<tr>
		<td>Class: </td>
		<td><?php echo $class_nick ?></td>
	</tr>
</table>
</div>
<?php show_footer(); ?>
