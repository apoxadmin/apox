<?php 
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/forms.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/show.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/user.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/event.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

include_once 'sql.php';

get_header();

if($_SESSION['class'] != 'admin')
{
	show_note('You must be logged in as excomm to access this page!');
	exit();
}

function users_get()
{
	$sql = 'SELECT user_id, user_name AS name FROM user '
			. " WHERE user_hidden=0 ORDER BY user_name";
	return db_select($sql);
}

function terms_get()
{
	$sql = "SELECT class_id, class_nick, class_term, class_year, class_start " 
		. "FROM class WHERE class_start != \"0000-00-00 00:00:00\" ORDER BY class_start DESC";
	return db_select($sql);
}

function term_get($id)
{
	$sql = "SELECT class_nick, class_id FROM class WHERE class_id = $id";
	return db_select1($sql);
}
?>

<form action="/tracking/check.php" method="GET">

<select id="whocares" name="user">
	<?php
	if (isset($_GET['user'])) {
		$selected_user_id = $_GET['user'];
	}

	foreach(users_get() as $user) {
		if ($user['user_id'] == $selected_user_id) {
			$selected = "selected=\"selected\"";
		} else {
			$selected = "";
		}
		echo "<option value=\"{$user['user_id']}\" $selected>{$user['name']}</option>\n";
	}
	?>
</select>

<select id="whocares" name="term">
	<?php
	if (isset($_GET['term'])) {
		$selected_class_id = $_GET['term'];
	}

	foreach(terms_get() as $term) {
		if ($term['class_id'] == $selected_class_id) {
			$selected = "selected=\"selected\"";
		} else {
			$selected = "";
		}
		echo "<option value=\"{$term['class_id']}\" $selected>{$term['class_nick']} ({$term['class_term']} {$term['class_year']})</option>\n";
	}
	?>
</select>
<input type="submit" value="Check"/>

</form>

<?php

if(isset($_GET['user']))
	$id=$_GET['user'];

function show_serviceTracking($events, $user)
{
	$total = array();
	?>
	<table class="table table-condensed table-bordered">
	<tr><td class="heading" colspan="10">Service</td></tr>
	<tr>
		<th style="width: 300px">Event</th>
		<th width="10%">Hours</th>
		<th width="10%">Required</th>
		<th width="10%">Projects</th>
		<th width="10%">Chair</th>
		<th width="10%" colspan="4">C </th>
	</tr>
	
	<?php 
	if (count($events) > 0)	//to make it null if no person is selected.
		$total['d'] = 0;
	array_unshift($events,array('date' => '', 'event_name' => 'Starting service requirement', 'h' => -20, 'ppl' => 0, 'mi' => 0, 'event_id' => 0)); // add a dummy event to the beginning of events array for baseline hours requirement
	foreach($events as $event){
		if ($event['h']>0) { // if they got negative hours, add to "additional required hours"
			$total['h'] += $event['h'];
		} else {
			$total['r'] += -1*$event['h'];
		}
		$total['p'] += $event['p'];
		$total['c'] += $event['c'];
		$checked = isset($event['h']) ? 'checked' : '';
		$class  = 'small'; // . $event['fourc_c'];
		$class2 = 'small fourc' . $event['fourc_c'];
		error_reporting(1); // Suppress warning message
		$text = date('m/d/y', $event['date']) . ' ' . $event['event_name'];
		error_reporting(6135);
	?>
		<tr>
			<td class="<?php echo $class ?>">
				<?php echo $text ?>
			</td>
			<td>
				<?php if ($event['h'] > 0) // decide which column to display event hours in
					echo $event['h'] . '</td><td>';
				else
					echo '</td><td>' . -1*$event['h'];
				?>
			</td>
			<td class="<?php echo $class ?>">
				<?php forms_checkbox_disabled("p[{$event['event_id']}]", 1, $event['p']); ?>
			</td>
			<td class="<?php echo $class ?>">
				<?php forms_checkbox_disabled("c[{$event['event_id']}]", 1, $event['c']); ?>
			</td>
			<td colspan="4" class="<?php echo $class2 ?>"><?php echo fourc_get($event['event_id']) ?></td>
		</tr>
	<?php } ?>
	<tr>
		<?php 
			$result = term_get($_GET['term']);
			$term_id = $result['class_id'];			
			$fourc_totals = getCTotal($user, $term_id);
			echo '<td>Total</td>';
			echo "<td>{$total['h']}</td>";
			echo "<td>{$total['r']}</td>";
			echo "<td>{$total['p']}</td>";
			echo "<td>{$total['c']}</td>";
			
			$c[0] = $c[1] = $c[2] = $c[3] = 0;
			foreach($fourc_totals as $fourc_total)
			{
				$c[$fourc_total['fourc_c']] = $fourc_total['C'];
			}
			
			echo "<td class=\"small fourc0\">{$c[0]}</td>";
			echo "<td class=\"small fourc1\">{$c[1]}</td>";
			echo "<td class=\"small fourc2\">{$c[2]}</td>";
			echo "<td class=\"small fourc3\">{$c[3]}</td>";
		?>
	</tr>
	</table>
	<?php 
}

function show_ICTracking($events, $user)
{
	$total = array();
	?>
	<table class="table table-condensed table-bordered">
	<tr><td class="heading" colspan="4">IC</td></tr>
	<tr>
		<th style="width: 300px">Event</th>
		<th>Events </th>
		<th>Chair </th>
		<th width="20%">Driving<br>People/Miles</th>
	</tr>
	
	<?php
	if (count($events) > 0)	//to make it null if no person is selected.
		$total['d'] = 0;
	foreach($events as $event){
		$total['events'] += 1;
		$total['c'] += $event['c'];
		$checked = isset($event['c']) ? 'checked' : '';
		if ($event['ppl'] > 0)	//if they drove somebody
			$total['d'] += 1;
		$class  = 'small'; // . $event['fourc_c'];
		$class2 = 'small fourc' . $event['fourc_c'];
		$class  .= isset($event['c']) ? '' : ' waitlist';
		$class2 .= isset($event['c']) ? '' : 'dark';
		$text = date('m/d/y', $event['date']) . ' ' . $event['event_name'];
	?>
		<tr>
			<td class="<?php echo $class ?>">
				<?php echo $text ?>
			</td>
			<td>1</td>
			<td class="<?php echo $class ?>">
				<?php forms_checkbox("c[{$event['event_id']}]", 1, $event['c']>0) ; ?>
			</td>
			<td class=<?php echo "\"$class\">{$event['ppl']} ppl, {$event['mi']}";
			?> mi </td>
		</tr>
	<?php } ?>
	<tr>
		<?php 
			echo '<td>Total</td>';
			echo "<td>{$total['events']}</td>";
			echo "<td>{$total['c']}</td>";
			echo '<td>';
			if(isset($total['d']))
				echo "{$total['d']} times driving";
			echo '</td>';
		?>
	</tr>
	</table>
	<?php 
}

function show_meetingTracking($events, $user)
{
	$total = array();
	?>
	<table class="table table-condensed table-bordered">
	<tr><td class="heading" colspan="3">Meetings</td></tr>
	<tr>
		<th style="width: 300px">Event</th>
		<th>Credit </th>
		<th>Pin/Letters </th>
	</tr>
	
	<?php foreach($events as $event){
		$total['events'] += $event['h'];
		$total['p'] += $event['p'];
		$checked = isset($event['p']) ? 'checked' : '';
		$class  = 'small'; // . $event['fourc_c'];
		$class2 = 'small fourc' . $event['fourc_c'];
		$class  .= isset($event['p']) ? '' : ' waitlist';
		$class2 .= isset($event['p']) ? '' : 'dark';
		$text = date('m/d/y', $event['date']) . ' ' . $event['event_name'];
		$credit = ($event['h'] == '0.5') ? '0.5' : '1';
	?>
		<tr>
			<td class="<?php echo $class ?>">
				<?php echo $text ?>
			</td>
			<td><?php echo $credit ?></td>
			<td class="<?php echo $class ?>">
				<?php forms_checkbox("p[{$event['event_id']}]", 1, $event['p']>0) ; ?>
			</td>
		</tr>
	<?php } ?>
	<tr>
		<?php 
			echo '<td>Total</td>';
			echo "<td>{$total['events']}</td>";
			echo "<td>{$total['p']}</td>";
		?>
	</tr>
	</table>
	<?php 
}

function show_FellowshipTracking($events, $user)
{
	$total = array();
	?>
	<table class="table table-condensed table-bordered">
	<tr><td class="heading" colspan="4">Fellowship</td></tr>
	<tr>
		<th style="width: 300px">Event</th>
		<th>Events </th>
		<th>Chair </th>
		<th width="20%">Driving<br>People/Miles</th>
	</tr>
	
	<?php 
	if (count($events) > 0)	//to make it null if no person is selected.
		$total['d'] = 0;
	foreach($events as $event){
		$total['events'] += 1;
		$total['c'] += $event['c'];
		$checked = isset($event['c']) ? 'checked' : '';
		if ($event['ppl'] > 0)	//if they drove somebody
			$total['d'] += 1;
		$class  = 'small'; // . $event['fourc_c'];
		$class2 = 'small fourc' . $event['fourc_c'];
		$class  .= isset($event['c']) ? '' : ' waitlist';
		$class2 .= isset($event['c']) ? '' : 'dark';
		$text = date('m/d/y', $event['date']) . ' ' . $event['event_name'];
	?>
		<tr>
			<td class="<?php echo $class ?>">
				<?php echo $text ?>
			</td>
			<td>1</td>
			<td class="<?php echo $class ?>">
				<?php forms_checkbox("c[{$event['event_id']}]", 1, $event['c']>0) ; ?>
			</td>
			<td class=<?php echo "\"$class\">{$event['ppl']} ppl, {$event['mi']}";
			?> mi </td>
		</tr>
	<?php } ?>
	<tr>
		<?php 
			echo '<td>Total</td>';
			echo "<td>{$total['events']}</td>";
			echo "<td>{$total['c']}</td>";
			echo '<td>';
			if(isset($total['d']))
				echo "{$total['d']} times driving";
			echo '</td>';
		?>
	</tr>
	</table>
	<?php 
}

function show_leadershipTracking($events, $user)
{
	$total = array();
	?>
	<table class="table table-condensed table-bordered">
	<tr><td class="heading" colspan="4">Leadership</td></tr>
	<tr>
		<th style="width: 300px">Event</th>
		<th>Credit </th>
		<th>Chair </th>
		<th width="20%">Driving<br>People/Miles</th>
	</tr>
	
	<?php 
	if (count($events) > 0)	//to make it null if no person is selected.
		$total['d'] = 0;
	foreach($events as $event){
		$total['p'] += $event['p'];
		$total['c'] += $event['c'];
		$checked = isset($event['c']) ? 'checked' : '';
		if ($event['ppl'] > 0)	//if they drove somebody
			$total['d'] += 1;
		$class  = 'small'; // . $event['fourc_c'];
		$class2 = 'small fourc' . $event['fourc_c'];
		$class  .= isset($event['c']) ? '' : ' waitlist';
		$class2 .= isset($event['c']) ? '' : 'dark';
		$text = date('m/d/y', $event['date']) . ' ' . $event['event_name'];
	?>
		<tr>
			<td class="<?php echo $class ?>">
				<?php echo $text ?>
			</td>
			<td><?php echo $event['p'] ?></td>
			<td class="<?php echo $class ?>">
				<?php forms_checkbox("p[{$event['event_id']}]", 1, $event['p']>0) ; ?>
			</td>
			<td class=<?php echo "\"$class\">{$event['ppl']} ppl, {$event['mi']}";
			?> mi </td>
		</tr>
	<?php } ?>
	<tr>
		<?php 
			echo '<td>Total</td>';
			echo "<td>{$total['p']}</td>";
			echo "<td>{$total['c']}</td>";
			echo '<td>';
			if(isset($total['d']))
				echo "{$total['d']} times driving";
			echo '</td>';
		?>
	</tr>
	</table>
	<?php 
}

function show_FundraiserTracking($events, $user)
{
	$total = array();
	?>
	<table class="table table-condensed table-bordered">
	<tr><td class="heading" colspan="4">Fundraisers</td></tr>
	<tr>
		<th style="width: 300px">Event</th>
		<th>Events </th>
		<th>Chair </th>
		<th width="20%">Driving<br>People/Miles</th>
	</tr>
	
	<?php 
	if (count($events) > 0)	//to make it null if no person is selected.
		$total['d'] = 0;
	foreach($events as $event){
		$total['events'] += 1;
		$total['c'] += $event['c'];
		$checked = isset($event['c']) ? 'checked' : '';
		if ($event['ppl'] > 0)	//if they drove somebody
			$total['d'] += 1;
		$class  = 'small'; // . $event['fourc_c'];
		$class2 = 'small fourc' . $event['fourc_c'];
		$class  .= isset($event['c']) ? '' : ' waitlist';
		$class2 .= isset($event['c']) ? '' : 'dark';
		$text = date('m/d/y', $event['date']) . ' ' . $event['event_name'];
	?>
		<tr>
			<td class="<?php echo $class ?>">
				<?php echo $text ?>
			</td>
			<td>1</td>
			<td class="<?php echo $class ?>">
				<?php forms_checkbox_disabled("c[{$event['event_id']}]", 1, $event['c']>0) ; ?>
			</td>
			<td class=<?php echo "\"$class\">{$event['ppl']} ppl, {$event['mi']}";
			?> mi </td>
		</tr>
	<?php } ?>
	<tr>
		<?php 
			echo '<td>Total</td>';
			echo "<td>{$total['events']}</td>";
			echo "<td>{$total['c']}</td>";
			echo '<td>';
			if(isset($total['d']))
				echo "{$total['d']} times driving";
			echo '</td>';

		?>
	</tr>
	</table>
	<?php 
}

function show_cawTracking($events, $user)
{
	$total = array();
	?>
	<table class="table table-condensed table-bordered">
	<tr><td class="heading" colspan="4">Coho/Academic/Workout Hours</td></tr>
	<tr>
		<th style="width: 300px">Event</th>
		<th>Events </th>
		<th>Hours </th>
		<th>Chair </th>
	</tr>
	
	<?php foreach($events as $event){
		$total['events'] += 1;
		$total['h'] += $event['h'];
		$total['c'] += $event['c'];
		$checked = isset($event['c']) ? 'checked' : '';
		$class  = 'small'; // . $event['fourc_c'];
		$class2 = 'small fourc' . $event['fourc_c'];
		$class  .= isset($event['c']) ? '' : ' waitlist';
		$class2 .= isset($event['c']) ? '' : 'dark';
		$text = date('m/d/y', $event['date']) . ' ' . $event['event_name'];
	?>
		<tr>
			<td class="<?php echo $class ?>">
				<?php echo $text ?>
			</td>
			<td>1</td>
			<td>
				<?php echo $event['h'] ?>
			</td>
			<td class="<?php echo $class ?>">
				<?php forms_checkbox("c[{$event['event_id']}]", 1, $event['c']>0) ; ?>
			</td>
		</tr>
	<?php } ?>
	<tr>
		<?php 
			echo '<td>Total</td>';
			echo "<td>{$total['events']}</td>";
			echo "<td>{$total['h']}</td>";
			echo "<td>{$total['c']}</td>";
		?>
	</tr>
	</table>
	<?php 
}

function show_commTracking($user)
{
	$sql = 'SELECT credit, details,dues FROM trackingcomm '
			. "WHERE user_id = '$user' ";
			
	$result = db_select1($sql);
	
	$credit = $result['credit'] ? 'yes' : 'no';
	$dues = $result['dues'] ? 'yes' : 'no';
	$details = $result['details'];
	?>
	<table class="table table-condensed table-bordered">
		<tr><td class="heading" colspan="3">Committee & Dues Tracking</td></tr>
		<tr>
			<th style="width: 20px">Credit?</th>
			<th>Dues?</th>
			<th>Details</th>
		</tr>
		<tr>
			<td><?=$credit?></td>
			<td><?=$dues?></td>
			<td><?=$details?></td>
		</tr>
	</table>
	<?php
}

function show_pictureTracking($user)
{
	$sql = 'SELECT value FROM trackinggeneral '
			. "WHERE user_id = '$user' AND `key` = 'pictures' ";
			
	$result = db_select1($sql);
	$pictures = intval($result['value']);
	?>
	<table class="table table-condensed table-bordered">
		<tr><td class="heading">Picture Tracking</td></tr>
		<tr>
			<th style="width: 20px">Pictures</th>
		</tr>
		<tr>
			<td><?=$pictures?> pictures</td>
		</tr>
	</table>
	<?php
}

if(isset($_GET['term'])) {

	$name = user_get($id, 'fl');
	$result = term_get($_GET['term']);
	$term_nick = $result['class_nick'];
	$term_id = $result['class_id'];
	echo "<div class=\"general\" style=\"text-align:center;\"><p class=\"lead\">{$name['name']}'s Tracking for {$term_nick} Term</p></div>";
	$events = getTrackedUser($id, 1, $term_id);
	show_ServiceTracking($events, $id);
	echo '<br/>';
	$events = getTrackedUser($id, 2, $term_id);
	show_FellowshipTracking($events, $id);
	echo '<br/>';
	$events = getTrackedUser($id, 6, $term_id);
	show_MeetingTracking($events, $id);
	echo '<br/>';
	$events = getTrackedUser($id, 7, $term_id);
	show_leadershipTracking($events, $id);
	echo '<br/>';
	$events = getTrackedUser($id, 'ic', $term_id);
	show_ICTracking($events, $id);
	echo '<br/>';
	$events = getTrackedUser($id, 'fundraiser', $term_id);
	show_FundraiserTracking($events, $id);
	echo '<br/>';
	$events = getTrackedUser($id, 9, $term_id);
	show_cawTracking($events, $id);
	echo '<br/>';
	show_commTracking($id);
	echo '<br/>';
	//Picture tracking has been disabled for Fong-Quan term at Bryce's request
	//show_pictureTracking($id);
	//echo '<br/>';
}

show_footer();
?>
