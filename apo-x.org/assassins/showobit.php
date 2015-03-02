<?php 
include_once 'template.inc.php';
include_once 'assassins.php';

if(isset($_GET['id']))
	$user = $_GET['id'];
	
if(isset($_SESSION['id']))
	$id = $_SESSION['id'];

if(isset($_GET['story']))
	$story = get_death_info($_GET['story']);

$killer = get_player_info($story['killer_id']); 
$killed = get_player_info($story['killed_id']);

show_header();

?>
<table width=100%>
	<tr>
		<th><?php echo $killer['codename']." assassinated ".$killed['codename']." at ".date('g:i a \o\n F dS, Y', strtotime($story['obit_time'])); ?></th>
	</tr>
	<tr>
		<td><?php echo $story['obit_story']; ?></td>
	</tr>
</table>	

<?php show_footer(); ?>
