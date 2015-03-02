<?php 
include_once 'template.inc.php';
include_once 'forms.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

if(isset($_GET['id']))
	$user = $_GET['id'];

if(isset($_SESSION['id']))
	$id = $_SESSION['id'];

if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

get_header();


function getList()
{
	$sql = 'SELECT id, person, amount, reason, status '
        . ' FROM checks';

	$table = db_select($sql, "getList()");
	
	return $table;
}

$list = getList(); 
?>

<div class="general">
<center>
<h1>Reimbursement Checks</h1>
</center>
</div>

<table cellspacing="1">
	<tr><td class="heading" colspan="5"></td></tr>
	<tr>
		<th>ID</th>
    <th>Name</th>
    <th>Amount</th>
		<th>For what</th>
    <th>Status</th>
	</tr>
	<?php foreach($list as $line): ?>
		<tr>
		<?php 
		$num_columns = count($line);
		for ($i = 1; $i <= $num_columns; $i++) {
		    $column = array_shift($line);
					echo "<td>" . $column . "</td>";
					}
		?>
		</tr>
	<?php 
	endforeach;
	?>
</table>
<?php
if($class == 'admin')
	{
	?>
<form action="/checks/edit.php" method="POST">
ID to edit: <input name="ID" type="text" maxlength="6" /><br/>
<?php
forms_submit('Edit'); 
}
?>
</div>
<?php show_footer();?>