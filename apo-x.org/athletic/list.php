<?php 
include_once 'template.inc.php';
include_once 'forms.inc.php';

if(isset($_GET['id']))
	$user = $_GET['id'];

if(isset($_SESSION['id']))
	$id = $_SESSION['id'];

if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

show_header();


function getSport($sport)
{
	$sql = 'SELECT user.user_name as name, user.user_phone as number, user.user_id as id'
        . " FROM user NATURAL JOIN athletic_interest WHERE athletic_interest.$sport = 1";

	$list = db_select($sql, "getSport");
	
	return $list;
}
$sports = array("soccer", "swimming", "football", "ultimate_frisbee", "tennis", "badminton", "basketball", "running", "camping", "fishing", "hiking", "cycling", "working_out");
?>

<div class="general">
<center>
<h1>Athletic Interest Sheet</h1>
</center>
</div>
<table border="0"	cellspacing="0">
<?php
foreach($sports as $key => $value)
{
	if(!($key % 2))
	{
		echo '<tr border="0" valign="top"><td>';
	}//if 2 tables in line, new line
	else
	{
		echo "<td>";
	}//if not 2 tables, just add table next to it
	$list = getSport($value);
?>

<table cellspacing="0" border="0"	>
<tr>
<th colspan="2"><?php echo ucwords($value); ?></th>
</tr>
<tr>
	<th> Name </th>
	<th> Number </th>
</tr>
<?php foreach($list as $data)
{
?>
	<tr>
	<td> 
<?php	$currentName = "<a href=\"/people/profile.php?user={$data['id']}\">"
									 . "{$data['name']}</a>";
			echo $currentName;
	?>
	</td>
	<td>
	<?php $phone = $data['number'];
				echo $phone;
	?>
	</td>
	</tr>
	</td>
<?php
if($key % 2)
	echo "</tr>";
	} //cycle through names
	echo "</table>";
}//cycle through sports
echo "</table>";

$currentName = "<a href=\"/people/profile.php?user={$id}\">"
									 . "{$id}</a>";
?>
<form action="/atheltic/function.php" method="POST">
<table border="0" cellspacing="0">
<tr>
	<th>Name</th>
	<th>Soccer</th>
	<th>Swimming</th>
	<th>Football</th>
	<th>Ultimate Frisbee</th>
	<th>Tennis</th>
	<th>Badminton</th>
	<th>Baskteball</th>
	<th>Running</th>
	<th>Camping</th>
	<th>Fishing</th>
	<th>Hiking</th>
	<th>Cycling</th>
	<th>Working Out</th>
</tr>
<tr>
	<td> <?php echo $currentName; ?> </td>

<?php
echo $id;
echo $id;
echo $id;
echo $id;
foreach($sports as $value)
	{
	$sql = "SELECT '$value' FROM `athletic_interest` WHERE `user_id` = '$id'";
	$result = db_select($sql);
	if($result[0] == 0)
		echo '<td> <input type="checkbox" name ="$sport_array[]" value="$value" CHECKED </td>';
	else
		echo '<td> <input type="checkbox" name ="$sport_array[]" value="$value" </td>';
	} //end looping through sports
?>

</table>
<?php forms_submit('Update'); ?>
</form>	
	<?php
show_footer();
?>
