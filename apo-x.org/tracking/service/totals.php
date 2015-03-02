<?php 
include_once dirname(dirname(dirname(__FILE__))) . '/include/template.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/forms.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/show.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/user.inc.php';
include_once dirname(dirname(dirname(__FILE__))) . '/include/event.inc.php';
include_once '../sql.php';
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
	 $sql = 'SELECT sum( hours ) AS h, sum( projects ) AS p, sum( chairs ) AS c'
        . ' FROM event NATURAL JOIN tracking'
        . " WHERE eventtype_id = 1 AND user_id = '$user' "
        . " AND event.event_date > " . db_currentClass('start');

	$total = db_select1($sql, "getTracked()");

	$sql = 'SELECT count( * ) AS drove'
        . ' FROM event NATURAL JOIN tracking WHERE passengers > 0'
        . " AND eventtype_id = '1' AND user_id = '$user' "
        . " AND event.event_date > " . db_currentClass('start');

	$temp = db_select1($sql, "getTracked()");
	$total['drove'] = $temp['drove'];

	$total['h'] += 0;
	$total['p'] += 0;
	$total['c'] += 0;
	
	return $total;

}

function show_eventsTrack($name, $user)
{
	$total = array();
	?>
		<?php 
			$total = getTotal($user);
			if( $total['h'] > 0 || $total['p'] > 0){
				echo "<tr id=\"r<?php echo $user ?>\">";
				$fourc_totals = getCTotal($user, db_currentClass('class_id'));
				echo "<td><a href=\"/tracking/service/user.php?user=$user\">$name</a></td>";
				echo "<td>{$total['h']}</td>";
				echo "<td>{$total['p']}</td>";
				echo "<td>{$total['c']}</td>";
				echo "<td>{$total['drove']}</td>";
				
				$c[0] = $c[1] = $c[2] = $c[3] = 0;
				foreach($fourc_totals as $fourc_total)
				{
					$c[$fourc_total['fourc_c']] = $fourc_total['C'];
				}
				
				echo "<td class=\"small fourc0\">{$c[0]}</td>";
				echo "<td class=\"small fourc1\">{$c[1]}</td>";
				echo "<td class=\"small fourc2\">{$c[2]}</td>";
				echo "<td class=\"small fourc3\">{$c[3]}</td>";
				echo "</tr>";
			}
		?>
	<?php 
}

$everyone = user_getAll(); 

show_filter();
?>

<table id="usertable" class="table table-condensed table-bordered">
	<tr>
		<th width="50%">Name  </th>
		<th width="10%">Hours </th>
		<th width="10%">Projects</th>
		<th width="10%">Chair </th>
		<th width="20%">Times Driving</th>
		<th width="10%" colspan="4">C's</th>
	</tr>
	<?php
	foreach($everyone as $one)
		show_eventsTrack($one['name'], $one['id']);
	?>
</table>

<?php
show_footer();
?>
