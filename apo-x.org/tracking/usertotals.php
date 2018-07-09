<?php 
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/forms.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/show.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/user.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/event.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
get_header();
	
if(isset($_SESSION['id']))
	$id = $_SESSION['id'];
	
if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

$temp=user_get($id, 'f');
$temp=$temp['name'];

if($class!="admin")
	show_note('You must be an administrator to access this page.');

function getTotal($user)
{
	$date = NOW; // now
	 $sql = 'SELECT sum( hours ) AS events, sum( projects ) AS p'
        . ' FROM event NATURAL JOIN tracking'
        . " WHERE eventtype_id = '6' AND event_ic = 0 AND user_id = '$user' "
        . " AND event.event_date > " . db_currentClass('start');

	$total = db_select1($sql, "getTracked()");

	$total['events'] += 0;
	$total['p'] += 0;
	
	return $total;

}

function show_eventsTrack($name, $user)
{
	$total = array();
	?>
	<tr id="r<?php echo $user ?>">
		<?php 
			$total = getTotal($user);
			echo "<td><a href=\"/people/myrosterinfo.php?user=$user\">$name</a></td>";
		?>
	</tr>
	<?php 
}

$everyone = user_getAll(); 

show_filter();
?>

<table id="usertable" cellspacing="1">
	<tr>
		<td>Name  </td>
	</tr>
	<?php
	foreach($everyone as $one)
		show_eventsTrack($one['name'], $one['id']);
	?>
</table>

<?php
show_footer();
?>
