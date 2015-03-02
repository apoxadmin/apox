<?php 
include_once 'template.inc.php';

show_header(); 

if(isset($_SESSION['id']))
	$user = $_SESSION['id'];
else
	show_note('You are not logged in.');
	

function user_getPledges()
{
	$sql = "SELECT user_id as id, user_name "
		. " as name from user "
		. " WHERE status_id = 1"
		. " order by user_name asc";
	
	$result = mysql_query($sql) or die("Query Failed (user_getAll)!". mysql_error());
	
	$users = array();
	while($line = mysql_fetch_assoc($result))
		array_push($users,$line);
	
	mysql_free_result($result);
	
	return $users;
}


function show_usersx()
{
	$users = user_getPledges();
?>
	<table cellspacing="1">
	<?
	$COLS = 3;
	$ROWS = ceil(count($users)/3.0);
	
	// as long as there are at least 2 people then only the 3rd column can be invalid
	for($i=0;$i<$ROWS;$i++): ?>
		<tr>
			<td class="small" colspan="2">
				<?php echo $users[$i]['id']?> <?php echo $users[$i]['name']?>
			</td>
			<td class="small" colspan="2">
				<?php echo $users[$i+$ROWS]['id']?> <?php echo $users[$i+$ROWS]['name']?>
			</td>
			<td class="small" colspan="2">
			<?php if(isset($users[$i+2*$ROWS])): ?>
				<?php echo $users[$i+2*$ROWS]['id']?> <?php echo $users[$i+2*$ROWS]['name']?>
			<?php endif; ?>
			</td>
		</tr>
	<?php endfor; ?>
	<?php if($even!=0){ ?></tr><?php } ?>
	</table>
	<?php 
}

show_usersx();

show_footer(); ?> 

