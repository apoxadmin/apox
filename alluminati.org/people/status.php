<?php 
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';

if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

show_header(); 

// permissions?
if($class!="admin")
	show_note('You must be an administrator to access this page.');

function get_users()
{
	$sql = "SELECT user_id as id, user_name "
		. " as name, status_id, user_hidden FROM user "
		. " ORDER BY user_name ASC";
	
	$result = mysql_query($sql) or die("Query Failed (get_users)!". mysql_error());
	
	$users = array();
	while($line = mysql_fetch_assoc($result))
		array_push($users,$line);
	
	mysql_free_result($result);
	
	return $users;
}

function status_getAll()
{
	$query = 'SELECT status_id, status_name FROM status';
	
	return db_select($query);
}

?>

<form action="input.php" method="POST">
	<input type="hidden" name="action" value="autoinvis" />
	<input type="hidden" name="redirect" value="status.php" />
	<input type="submit" value="Auto-Invis" />
	</form>
<table>
<?php 
	foreach(get_users() as $user)
	{ ?>
	<tr>
	<form action="input.php" method="POST">
		<input type="hidden" name="action" value="setstatus" />
		<input type="hidden" name="redirect" value="status.php" />
		<td><input type="hidden" name="id" value="<?php echo $user['id']; ?>" /><?php echo $user['name']; ?></td>
		<td><select name="status">
		<?php 
		$types = status_getAll();
		foreach($types as $line): 
			echo "<option ";
			if($user['status_id']==$line['status_id']) echo "selected ";
			echo "value=\"{$line['status_id']}\">{$line['status_name']}</option>";
		endforeach; ?>
		</select></td>
		<td><select name="invis">
			<option <?php if($user['user_hidden']==0) echo "selected "; ?> value="0">Visible</option>
			<option <?php if($user['user_hidden']==1) echo "selected "; ?> value="1">Invisible</option>			
		</select></td>
		<td><input type="submit" value="Set Status" /></td>
		</form>
		</tr>
	<?php } ?>
</table>
<?php show_footer(); ?> 

