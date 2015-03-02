<?php

include_once 'template.inc.php';
include_once 'forms.inc.php';
	
if(isset($_GET['id']))
	$user = $_GET['id'];

if(isset($_GET['action']))
  $action = $_GET['action'];

if(isset($_SESSION['id']))
	$id = $_SESSION['id'];
	
if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

function get_info($user)
{
	$sql = "SELECT user.user_name , "
		. " soccer, swimming, football, ultimate_frisbee, "
		. " tennis, badminton, basketball, running, camping,"
		. " fishing, hiking, cycling, working_out"
        . " FROM user NATURAL JOIN athletic_interest WHERE user.user_id = '$user' ";
 

	$table = db_select1($sql, "get_info()",true);
	
	return $table;
}

function user_getAllx()
{
	$sql = "SELECT user_id as id, user_name "
		. " as name from user WHERE user_hidden=0 "
		. " order by user_name asc";
	
	return db_select($sql, 'user_getAll');
}

show_header();

if(!isset($class))
{
	echo 'You must log in first!';
	show_footer();
	exit();
}

// don't let users modify whatever they want
if($class=='user')
	$user = $id;

if($class=='admin' && !isset($user))
{
	$users = user_getAllx();
?>
	<table cellspacing="1">
	<?
	$COLS = 3;
	$ROWS = ceil(count($users)/3.0);
	
	// as long as there are at least 2 people then only the 3rd column can be invalid
	for($i=0;$i<$ROWS;$i++):
		$a = $users[$i];
		$b = $users[$i+$ROWS];
		$c = $users[$i+2*$ROWS];
		?>
		<tr>
			<td class="small" colspan="2">
				<?php echo "<a href=\"/retreat/add.php?id={$a['id']}\">{$a['name']}</a>" ?>
			</td>
			<td class="small" colspan="2">
				<?php echo "<a href=\"/retreat/add.php?id={$b['id']}\">{$b['name']}</a>" ?>
			</td>
			<td class="small" colspan="2">
			<?php if(isset($users[$i+2*$ROWS])): ?>
				<?php echo "<a href=\"/retreat/add.php?id={$c['id']}\">{$c['name']}</a>" ?>
			<?php endif; ?>
			</td>
		</tr>
	<?php endfor; ?>
	<?php if($even!=0){ ?></tr><?php } ?>
	</table>
	<?php 
}
else
{
	// get the row if there is one
	$line = get_info($user);

	// set it to nothing if it's not made yet
	if($line == null)
		$line = array();
	
	if ($action == 'edit')
    echo "<form action=\"/retreat/function.php?action=update\" method=\"POST\">'";
  else
    echo "<form action=\"/retreat/function.php\" method=\"POST\">'";
    
	forms_hiddenInput('update','/retreat/list.php') ?>
	<?php forms_hidden('user',$user) ?>
	<table cellspacing="1">
		<tr><td class="heading" colspan="2">I am interested in the following</td></tr>
		<tr>
			<th>Soccer</th>
			<td>
			<input type="checkbox" name="sport[]" value="soccer">
			</td>
		</tr>
		<tr>
			<th>Swimming</th>
			<td>
			<input type="checkbox" name="sport[]" value="swimming">
			</td>
		</tr>
				<tr>
			<th>Football</th>
			<td>
			<input type="checkbox" name="sport[]" value="football">
			</td>
		</tr>
				<tr>
			<th>Ultimate Frisbee</th>
			<td>
			<input type="checkbox" name="sport[]" value="ultimate_frisbee">
			</td>
		</tr>
				<tr>
			<th>Tennis</th>
			<td>
			<input type="checkbox" name="sport[]" value="tennis">
			</td>
		</tr>
				<tr>
			<th>Badminton</th>
			<td>
			<input type="checkbox" name="sport[]" value="badminton">
			</td>
		</tr>
				<tr>
			<th>Basketball</th>
			<td>
			<input type="checkbox" name="sport[]" value="basketball">
			</td>
		</tr>
				<tr>
			<th>Running</th>
			<td>
			<input type="checkbox" name="sport[]" value="running">
			</td>
		</tr>
				<tr>
			<th>Camping</th>
			<td>
			<input type="checkbox" name="sport[]" value="camping">
			</td>
		</tr>
				<tr>
			<th>Fishing</th>
			<td>
			<input type="checkbox" name="sport[]" value="fishing">
			</td>
		</tr>
				<tr>
			<th>Hiking</th>
			<td>
			<input type="checkbox" name="sport[]" value="hiking">
			</td>
		</tr>
				<tr>
			<th>Cycling</th>
			<td>
			<input type="checkbox" name="sport[]" value="cycling">
			</td>
		</tr>
				<tr>
			<th>Working Out</th>
			<td>
			<input type="checkbox" name="sport[]" value="working_out">
			</td>
		</tr>
		<tr>
		<td colspan="3"><?php forms_submit('Update'); ?></td>
		</tr>
	</table>
	</form>

	<?php
}

show_footer();

?>
