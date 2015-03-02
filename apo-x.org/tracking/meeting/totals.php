<?php 
include_once dirname(dirname(dirname(__FILE__))) . '/include/template.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/forms.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/show.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/user.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/event.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
	
if(isset($_SESSION['id']))
	$id = $_SESSION['id'];
	
if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

get_header();

if($class != 'admin')
	show_note('You must be excomm to view this page!');

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
			$total = getTotal($user);
			if($total['events'] > 0){
				echo "<tr id=\"r$user \">";
				echo "<td><a href=\"/tracking/leadership/user.php?user=$user\">$name</a></td>";
				echo "<td>{$total['events']}</td>";
				echo "<td>{$total['c']}</td>";
				echo "<td>{$total['drove']}</td>";
				echo "</tr>";
			}
}

$everyone = user_getAll(); 

show_filter();
?>

<table id="usertable"  class="table table-condensed table-bordered">
	<tr>
		<th>Name  </th>
		<th>Credit</th>
		<th>Pin/Letters </th>
	</tr>
	<?php
	foreach($everyone as $one)
		show_eventsTrack($one['name'], $one['id']);
	?>
</table>

<?php
show_footer();
?>