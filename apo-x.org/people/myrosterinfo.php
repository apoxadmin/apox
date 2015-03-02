
<?php 

include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/forms.inc.php';
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
if($class=='admin')
{
	if(isset($_GET['user']))
		$user_id = (int)$_GET['user'];
	/*else
		show_note('No user selected!');*/
}

function class_getAll()
{
	$query = 'SELECT class_id, class_name FROM class ORDER BY class_year DESC, class_term ASC';
	return db_select($query);
}

function shirt_getAll()
{
	$query = 'SELECT shirt_id, shirt_size FROM shirt';
	return db_select($query);
}

function style_getAll()
{
	$query = 'SELECT style_id, style_name FROM style';
	return db_select($query);
}

if(isset($_POST['submit']))
{
    extract($_POST);

    $sql = "UPDATE user SET user_address= '$user_address', ";
    if(isset($family_id)) 
        $sql .= " family_id = '$family_id', ";
    if(isset($class_id)) 
        $sql .= " class_id = '$class_id', ";
	//prevent people from deciding that they are too sexy for a shirt
	//(excomm can still do this to people)
	if( $shirt_id != 0 || $class == 'admin' )
		$sql .= " shirt_id = '$shirt_id', ";
    $sql .= " user_phone = '$user_phone', user_cell = '$user_cell', "
		  . " user_email = '$user_email', user_aim = '$user_aim', "
		  . " user_bday = CONCAT($year,'-',$month,'-',$day), style_id = '$style_id'";
	
    if($class != 'admin' && strcmp($user_password, '1234567890')!==0 )
	{
		if ( strcmp($user_password, $user_password_confirm) == 0 )
			$sql .= " , user_password = '$user_password' ";
		else
			show_note ("You entered two different passwords!  Please type the same new password "
						. "in the confirmation box. (<a href=\"{$_SERVER['PHP_SELF']}\">Back</a>)");
	}

    $sql .= " WHERE user_id = '$user_id'";
    mysql_query($sql);

    $sql = "INSERT INTO `update` ( user_id ) VALUES ('$user_id')";
    mysql_query($sql);

    ?>
	<html>
	<head>
	<meta http-equiv="refresh" content="0;url=<?= $_SERVER['PHP_SELF']."?user=$user_id&updated=true"; ?>">
	</head>
	</html>
	<?php
}

$sql = ' SELECT user_name, family_id, class_id, user_address, user_phone, user_cell, '
     . ' user_email, user_aim, user_password, EXTRACT(YEAR FROM user_bday) AS bday_year, '
     . ' EXTRACT(MONTH FROM user_bday) AS bday_month, EXTRACT(DAY FROM user_bday) AS bday_day, shirt_id, style_id '
     . " FROM user WHERE user_id = '$user_id' ";
$line = db_select1($sql);

extract($line);

?>

<table cellspacing="1">
<form action="<?= $_SERVER['PHP_SELF']."?user=$user_id"; ?>" onsubmit="return valid(this)" method="POST">
	<tr>
		<td colspan="3" class="heading" align="center">My Roster Info</td>
	</tr>
	<tr>
		<td rowspan="12"><img src="/images/profiles/<?php echo $user_id; ?>.jpg" width="333" height="500" /></td>
		<td>Name: </td>
		<td><?php echo $user_name;?> </td>
	</tr>
	<tr>
		<td>Local Address: </td>
		<td><?php forms_text(32,"user_address",$user_address); ?></td>
	</tr>
	<tr>
		<td>Primary Phone: </td>
		<td><?php forms_phone("user_cell",$user_cell) ?></td>
	</tr>
	<tr>
		<td>Back-up Phone: </td>
		<td><?php forms_phone("user_phone",$user_phone) ?></td>
	</tr>
	<tr>
		<td>E-mail: </td>
		<td><?php forms_text(32,"user_email",$user_email) ?></td>
	</tr>
	<tr>
		<td>AIM: </td>
		<td><?php forms_text(16,"user_aim",$user_aim) ?></td>
	</tr>
	<tr>
		<td>Birthday: </td>
		<td>
		<select name="month">
		<?php for($i=1; $i<13; $i++) {
			echo "<option ";
			if($bday_month==$i) echo "selected ";
			echo "value=\"{$i}\">{$i}</option>"; } ?>
		</select>
		<select name="day">
		<?php for($i=1; $i<32; $i++) {
			echo "<option ";
			if($bday_day==$i) echo "selected ";
			echo "value=\"{$i}\">{$i}</option>"; } ?>
		</select>
		<select name="year">
		<?php for($i=1970; $i<2010; $i++) {
			echo "<option ";
			if($bday_year==$i) echo "selected ";
			echo "value=\"{$i}\">{$i}</option>"; } ?>
		</select>
		</td>
	</tr>
	<tr>
		<td>T-Shirt Size: </td>
		<td>
		<select size="1" name="shirt_id">
		<?php 
		$types = shirt_getAll();
		foreach($types as $line): 
			echo "<option ";
			if($shirt_id==$line['shirt_id']) echo "selected ";
			echo "value=\"{$line['shirt_id']}\">{$line['shirt_size']}</option>";
		endforeach; ?>
		</select>
		</td>
	<tr>
		<!-- Disabled for now.	
		<td>Website Style: </td>
		<td>
		<select size="1" name="style_id">
		<?php 
		$types = style_getAll();
		foreach($types as $line): 
			echo "<option ";
			if($style_id==$line['style_id']) echo "selected ";
			echo "value=\"{$line['style_id']}\">{$line['style_name']}</option>";
		endforeach; ?>
		</select>
		</td>
		-->
	<?php
		
		if($class != 'admin')
	{
		?>
	</tr>
	<tr>
		<td>Password: </td>
	<td><?php forms_password(32,"user_password", '1234567890') ?></td>
	</tr>
	<tr>
		<td>Re-type Password: </td>
	<td><?php forms_password(32,"user_password_confirm", '1234567890') ?></td>
	</tr>
	<?php 
	}	
	if($class=="admin"): ?>
	<tr>
		<td>Family: </td>
		<td>
		<select size="1" name="family_id">
		<?php
		$families = Array(0 => '?', 1=> 'Alpha', 2=> 'Phi', 3 => 'Omega');
		foreach($families as $key => $value): 
			echo "<option ";
			if($family_id==$key) echo "selected ";
			echo "value=\"$key\">$value</option>";
		endforeach; ?>
		</select>
		</td>
	</tr>
	<tr>
		<td>Class: </td>
		<td>
		<select size="1" name="class_id">
		<?php 
		$types = class_getAll();
		foreach($types as $line): 
			echo "<option ";
			if($class_id==$line['class_id']) echo "selected ";
			echo "value=\"{$line['class_id']}\">{$line['class_name']}</option>";
		endforeach; ?>
		</select>
		</td>
	<?php endif; ?>
	<tr>
		<td colspan="3" align="center"><input type="submit" name="submit" value="Update!"></td>
	</tr>
	<?php if($_GET['updated']): ?>
	<tr>
		<td colspan="3" align="center"><font color="#00FF00"><b>Update successful.</b></font></td>
	</tr>
	<?php endif; ?>
	
</form> 
</table>

<?php show_footer(); ?>