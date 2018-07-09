
<?php 
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/forms.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/show.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/user.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/event.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
include_once 'sql.php';
get_header();
if(isset($_SESSION['id']))
	$id = $_SESSION['id'];
	else
{
	print "
	
	<div id='content'> 
	<br>
	Sorry bro, you are not a member, uh, eh, maybe you are! 
	<br>
	If you're a new member or if you want to reset your password:  <a href='http://www.apo-x.org/forgetful/index.php'>Click Here</a> Jolly Good!
	";
	show_footer(); 
	exit;
}
if(isset($_SESSION['id']))
	$id = $_SESSION['id'];
	
if(isset($_SESSION['class']))
	$class = $_SESSION['class'];
	
if(!isset($_GET['term']))
	$_GET['term'] = db_currentClass('class_id');

// global variable for cool reqs (Robin)
$totals = array();

if ( isset( $id ) )
{
$query = "SELECT status_id FROM user WHERE user_id=".$id;
$result = mysql_query( $query );
$row = mysql_fetch_array( $result );
$status = $row[0];

// random events
								$baseUrl = "../event/show.php?id=";
								$query = "SELECT e.event_id
FROM event e
INNER JOIN shift sh ON e.event_id = sh.event_id
INNER JOIN signup s ON s.shift_id = sh.shift_id
WHERE (sh.shift_capacity>(
SELECT CASE count(s2.wants_replacement)
WHEN count(s2.wants_replacement) > 0 THEN count(s2.user_id)-count(s2.wants_replacement)
ELSE COUNT( s.user_id )
END people
FROM signup s2
INNER JOIN shift sh2 ON s2.shift_id = sh2.shift_id
WHERE s.shift_id = s2.shift_id
GROUP BY s2.shift_id)
OR sh.shift_capacity=0)
AND eventtype_id IN (1,4)
AND event_date > CURRENT_TIMESTAMP
GROUP BY sh.shift_id
ORDER BY event_date LIMIT 0,10";
								$result = mysql_query( $query );
								$i = 0;
								$results = array();
							while ( $row = mysql_fetch_array( $result ) )
							{
								$results[$i++] = $row[0];
							}
								$serviceLink = $baseUrl . $results[rand(0,$i-1)];
								$query = "SELECT e.event_id
FROM event e
INNER JOIN shift sh ON e.event_id = sh.event_id
INNER JOIN signup s ON s.shift_id = sh.shift_id
WHERE (sh.shift_capacity>(
SELECT CASE count(s2.wants_replacement)
WHEN count(s2.wants_replacement) > 0 THEN count(s2.user_id)-count(s2.wants_replacement)
ELSE COUNT( s.user_id )
END people
FROM signup s2
INNER JOIN shift sh2 ON s2.shift_id = sh2.shift_id
WHERE s.shift_id = s2.shift_id
GROUP BY s2.shift_id)
OR sh.shift_capacity=0)
AND eventtype_id=2
AND event_date > CURRENT_TIMESTAMP
GROUP BY sh.shift_id
ORDER BY event_date LIMIT 0,10";
								$result = mysql_query( $query );
								$i = 0;
								$results = array();
							while ( $row = mysql_fetch_array( $result ) )
							{
								$results[$i++] = $row[0];
							}
								$fellowshipLink = $baseUrl . $results[rand(0,$i-1)];
								$query = "SELECT e.event_id
FROM event e
INNER JOIN shift sh ON e.event_id = sh.event_id
INNER JOIN signup s ON s.shift_id = sh.shift_id
WHERE (sh.shift_capacity>(
SELECT CASE count(s2.wants_replacement)
WHEN count(s2.wants_replacement) > 0 THEN count(s2.user_id)-count(s2.wants_replacement)
ELSE COUNT( s.user_id )
END people
FROM signup s2
INNER JOIN shift sh2 ON s2.shift_id = sh2.shift_id
WHERE s.shift_id = s2.shift_id
GROUP BY s2.shift_id)
OR sh.shift_capacity=0)
AND event_date > CURRENT_TIMESTAMP
GROUP BY sh.shift_id
ORDER BY event_date LIMIT 0,10";
								$result = mysql_query( $query );
								$i = 0;
								$results = array();
							while ( $row = mysql_fetch_array( $result ) )
							{
								$results[$i++] = $row[0];
							}
								$allLink = $baseUrl . $results[rand(0,$i-1)];

// end of the cool reqs edits done up here.
// going back to the past (up to the ExtJS component area)

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
<style type="text/css">
.upcoming a {
	color: #147DF4;
	display: block;
}
.upcoming a:hover {
	color: #0000FF;
}
</style>

<div id="content">

<div id="dashboard" style="height: 500px; width:1058px;">
</div>
<br>
<form action="/tracking/mine.php" method="GET">

<select id="whocares" name="term">
	<?php
	if (isset($_GET['term'])) {
		if ( $_GET['term'] > 0 )	// let's just make sure they have a valid term (and not some kind of SQL injection)
			$selected_class_id = $_GET['term'];
		else
			$selected_class_id = db_currentClass('class_id');
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
<div id="upcoming" class="x-hide-display">
<?php                           // Show next 10 events and color by type
                                        $query = 'SELECT event_id,event_name,eventtype_id FROM event WHERE event_date > NOW() ORDER BY event_date ASC LIMIT 10';
                                        $result = db_select($query);
                                        foreach ($result as $event) {
											$event['event_name'] = htmlentities($event['event_name'], ENT_QUOTES);
											echo '<p class="et'.$event['eventtype_id'].'"><a href="/event/show.php?id='.$event['event_id'].'">'.$event['event_name'].'</a></p>';
                                        }
?></div>
<div id="announcements" class="x-hide-display">
<?php
	// merging the home.php page with the requirements
 $sql = 'SELECT author, subject, body, message_id, datestamp FROM phorum_messages '
        . ' WHERE forum_id = \'7\' AND parent_id = \'0\' ORDER BY datestamp DESC LIMIT 3';

    $headlines = db_select($sql);
    foreach($headlines as $headline)
    {
        $headline['body'] = str_replace("\n","<br/>",$headline['body']);
//		$headline['body'] = str_replace('"' , '&quot;' , $headline['body'] );
		$headline['subject'] = htmlentities($headline['subject'], ENT_QUOTES);
		$headline['author'] = htmlentities($headline['author'], ENT_QUOTES);
		$body = $headline['body'];
        echo "<div class='general'>";
        echo "<div class='boxtop'>";
        echo "<font class='big'><a href='/forums/read.php?7,".$headline['message_id']."'>".$headline['subject']."</a></span>";
        echo "<span style='color: black' class='author' style='margin-left: 6px'> posted by ".$headline['author']."</span>";
        echo '</div>';
        echo "<p class='newsbody'>".$body."</p>";
		// timestamp
		echo "<span class='date'>".date('m-d-Y H:i:s',$headline['datestamp'])."</span>";
        echo '</div>';
    }
?>
</div>
<div id="recent" class="x-hide-display">
<script src='http://feeds.feedburner.com/AlphaPhiOmega-ChiChapter' type='text/javascript'></script>
</div>
<br>

<?php
	//Picture Tracking has been disabled for Fong-Quan term at Bryce's request.
	//show_pictureTracking($id);
	//echo '<br/>';
	
	//echo "<div class=\"general\" style=\"text-align:center;\"><h3>{$name['name']}</h3></div>";
// requirements here

// added in a requirement table (1/19/2012 @ 1:36 AM T___________T (robin) )
$sql = "SELECT * FROM requirements WHERE class_id=" . $selected_class_id . " AND status_id = " . $status;
$result = mysql_query( $sql );
if ( mysql_num_rows( $result ) > 0 )
{
	$row = mysql_fetch_array( $result );
	$fellowReq = $row["fellowship"];
	$leadershipReq = $row["leadership"];
	$cawReq = $row["caw"];
	$meetingReq = $row["meeting"];
	$serviceReq = $row["service"];
	$fundReq = $row["fundraiser"];
	$ICReq = $row["IC"];
} else {
	$fellowReq = 4;
	if ( $status==STATUS_PLEDGE )
		$leadershipReq = 3;
	else
		$leadershipReq = 4;
	$meetingReq = 9;
	$cawReq = 20;
	$serviceReq = 20; // this is the base hours
	$fundReq = 1;
	$ICReq = 2;
}
?>


    <link rel="stylesheet" type="text/css" href="http://www.apo-x.org/extjs/resources/css/ext-all.css" />
    <link rel="stylesheet" type="text/css" href="http://www.apo-x.org/extjs/shared/example.css" />
    <script type="text/javascript" src="http://www.apo-x.org/extjs/ext-all.js"></script>
	<style type="text/css">
	.left {
		padding: 10px;
	}
	.left div {
		line-height: 16px;
	}
	</style>
	<script type="text/javascript">
	Ext.require('Ext.chart.*');
Ext.require(['Ext.Window', 'Ext.fx.target.Sprite', 'Ext.layout.container.Fit']);
Ext.onReady(function () {
	Ext.define('ServiceTracking', {
		extend: 'Ext.data.Model',
		fields: [ 'date' , 'event' , {
			name: 'hours' ,
			type: 'float' } , {
			name: 'required' ,
			type: 'float' } , {
			name: 'projects' , 
			type: 'int' } , 'chair' , 'c' ]
	});
	var storeServiceTracking = Ext.create('Ext.data.Store',{
		model: 'ServiceTracking',
		data: [ <?php
	// service tracking list via ExtJS grid
	// took the show_serviceTracking function
	// and stripped its HTML tag outputs
	$result = term_get($_GET['term']);
	$term_id = $result['class_id'];
	$events = getTrackedUser($id, 1, $term_id);
	class Event {
		public $date, $type, $event, $hours, $required, $credit, $chair, $c, $people, $miles , $letters;
	}
	$allEvents = array();
	if (count($events) > 0)	//to make it null if no person is selected.
		$total['d'] = 0;
	array_unshift($events,array('date' => '', 'event_name' => 'Starting service requirement', 'h' => -$serviceReq, 'ppl' => 0, 'mi' => 0, 'event_id' => 0)); // add a dummy event to the beginning of events array for baseline hours requirement
	$i=0;
	$total['h'] = 0;
	$total['r'] = 0;
	$total['p'] = 0;
	$total['c'] = 0;
	foreach($events as $event){
		if ($event['h']>0) { // if they got negative hours, add to "additional required hours"
			$total['h'] += $event['h'];
		} else {
			$total['r'] += -1*$event['h'];
		}
		$total['p'] += $event['p'];
		$total['c'] += $event['c'];
		if ( $i++ > 1 )
			echo ' , ';
		else
			if ( $i==1 )
				continue;
		error_reporting(1); // Suppress warning message
		$date = date('m/d/y', $event['date']);
		$text = htmlentities( $event['event_name'] , ENT_QUOTES );
		$temp = new Event();
		$temp->date = $date;
		$temp->event = $text;
		$temp->type = "Service";
		$temp->hours = $event['h'];
		$temp->required = $event['r'];
		$temp->c = fourc_get($event['event_id']);
		$temp->chair = $event['c'];
		$temp->credit = '';
		$temp->people = '';
		$temp->miles = '';
		array_push( $allEvents , $temp );
	?>{ date: '<?php echo $date;?>', event: '<?php echo $text ?>' , <?php if ($event['h'] > 0) // decide which column to display event hours in
				{
					echo "hours: '".$event['h']."' , ";
					echo "required: '0'";
				} else {
					echo "hours: '0' , ";
					echo "required: '".$event['r']."'";
				} ?> , projects: '<?php echo $event['p']; ?>' , chair: '<?php if( $event['c']> 0 ) echo 'yes'; else echo 'no'?>' , c: '<?php echo fourc_get($event['event_id']); ?>' }
	<?php } 
			$totals['serviceHours']=$total['h'];
			$totals['serviceHoursReq']=$total['r'];
			$fourc_totals = getCTotal($id, $term_id);
			$totalService = $total;
			
			$c[0] = $c[1] = $c[2] = $c[3] = 0;
			foreach($fourc_totals as $fourc_total)
			{
				$c[$fourc_total['fourc_c']] = $fourc_total['C'];
			} ?>]
	});
	Ext.define('FellowshipTracking', {
		extend: 'Ext.data.Model',
		fields: [ 'date' , 'event' , 'chair' , {
			name: 'people' ,
			type: 'int' } , {
			name: 'miles' ,
			type: 'int' } ]
	});
	var storeFellowshipTracking = Ext.create('Ext.data.Store',{
		model: 'FellowshipTracking',
		data: [<?
	// fellowshipTracking
	$events = getTrackedUser($id, 2, $term_id);
	$i = 0;
	$total['events'] = 0;
	$total['c'] = 0;
	if (count($events) > 0)	//to make it null if no person is selected.
		$total['d'] = 0;
	foreach($events as $event){
		$total['events'] += 1;
		$total['c'] += $event['c'];
		if ( $i++ > 0 )
			echo ' , ';
		error_reporting(1); // Suppress warning message
		if ($event['ppl'] > 0)	//if they drove somebody
			$total['d'] += 1;
		$date = date('m/d/y', $event['date']);
		$text = htmlentities( $event['event_name'] , ENT_QUOTES );
		$temp = new Event();
		$temp->date = $date;
		$temp->event = $text;
		$temp->type = "Fellowship";
		$temp->hours = '';
		$temp->required = '';
		$temp->credit = '';
		$temp->c = '';
		$temp->chair = $event['c'];
		$temp->people = $event['ppl'];
		$temp->miles = $event['mi'];
		array_push( $allEvents , $temp );
	?> { date: '<?php echo $date; ?>' , event: '<?php echo $text; ?>' , chair: '<?php if( $event['c']> 0 ) echo 'yes'; else echo 'no'?>' , people: '<?php echo $event['ppl'];?>' , miles: '<?php echo $event['mi'];?>' }
	<?php }
		$totalFellowship = $total;
		$totals['fellowships'] = $total['events'];
		?>]
	});
	Ext.define('MeetingTracking', {
		extend: 'Ext.data.Model',
		fields: [ 'date' , 'event' , {
			name: 'credit' ,
			type: 'int' } ,
			'letters' ]
	});
	var storeMeetingTracking = Ext.create('Ext.data.Store',{
		model: 'MeetingTracking',
		data: [ <?
	// meetingTracking
	$events = getTrackedUser($id, 6, $term_id);
	$total = array();
	$i = 0;
	$total['events'] = 0;
	$total['c'] = 0;
	foreach($events as $event){
		if ( $i++ > 0 )
			echo " , ";
		$total['events'] += $event['h'];
		$total['p'] += $event['p'];
		$date = date('m/d/y', $event['date']);
		$text = htmlentities( $event['event_name'] , ENT_QUOTES );
		$credit = ($event['h'] == '0.5') ? '0.5' : '1';
		$temp = new Event();
		$temp->date = $date;
		$temp->event = $text;
		$temp->type = "Meeting";
		$temp->hours = '';
		$temp->required = '';
		$temp->credit = $credit;
		$temp->c = '';
		$temp->chair = '';
		$temp->people = '';
		$temp->miles = '';
		$temp->letters = $event['p'];
		array_push( $allEvents , $temp );
	?>{ date: '<?php echo $date;?>' , event: '<?php echo $text; ?>' , credit: '<?php echo $credit; ?>' , letters: '<?php if( $event['p']> 0 ) echo 'no'; else echo 'yes';?>' }
	<?php }
			$totalMeeting = $total;
			$totals['meetings'] = $total['events'];
		?>]
	});
	Ext.define('LeadershipTracking', {
		extend: 'Ext.data.Model',
		fields: [ 'date' , 'event' , {
			name: 'credit' ,
			type: 'float' } , 'chair' , {
			name: 'people' ,
			type: 'int' } , {
			name: 'miles' ,
			type: 'int' } ]
	});
	var storeLeadershipTracking = Ext.create('Ext.data.Store',{
		model: 'LeadershipTracking',
		data: [ <?
	$events = getTrackedUser($id, 7, $term_id);
	$total = array();
	$i = 0;
	$total['events'] = 0;
	$total['c'] = 0;
	foreach($events as $event){
		if ( $i++ > 0 )
			echo " , ";
		$total['events'] += $event['h'];
		$total['p'] += $event['p'];
		$total['c'] += $event['c'];
		if ($event['ppl'] > 0)	//if they drove somebody
			$total['d'] += 1;
		$date = date('m/d/y', $event['date']);
		$text = htmlentities( $event['event_name'] , ENT_QUOTES );
		$temp = new Event();
		$temp->date = $date;
		$temp->event = $text;
		$temp->type = "Leadership";
		$temp->hours = '';
		$temp->required = '';
		$temp->credit = $event['p'];
		$totals['leadership']+=$temp->credit;
		$temp->c = '';
		$temp->chair = $event['c'];
		$temp->people = $event['ppl'];
		$temp->miles = $event['mi'];
		$temp->letters = $event['p'];
		array_push( $allEvents , $temp );
	?>{ date: '<?php echo $date;?>' , event: '<?php echo $text; ?>' , credit: '<?php echo $temp->credit; ?>' , chair: '<?php if( $event['c']> 0 ) echo 'yes'; else echo 'no'?>' , people: '<?php echo $event['ppl']>0;?>' , miles: '<?php echo $event['mi'];?>' }
	<?php 
	}
		$totalLeadership = $total;
//		$totals['leadership'] = $total['p'];
		if ( $totals['leadership']=='' )
			$totals['leadership']=0;
		?>]
	});
	Ext.define('ICTracking', {
		extend: 'Ext.data.Model',
		fields: [ 'date' , 'event' , 'chair' , {
			name: 'people' ,
			type: 'int' } , {
			name: 'miles' ,
			type: 'int' } ]
	});
	var storeICTracking = Ext.create('Ext.data.Store',{
		model: 'ICTracking',
		data: [<?
	$events = getTrackedUser($id, 'ic', $term_id);
	$total = array();
	$total['events'] = 0;
	$total['c'] = 0;
	$i = 0;
	foreach($events as $event){
		$total['events'] += 1;
		$total['c'] += $event['c'];
		if ($event['ppl'] > 0)	//if they drove somebody
			$total['d'] += 1;
		if ( $i++ > 0 )
			echo " , ";
		$date = date('m/d/y', $event['date']);
		$text = htmlentities( $event['event_name'] , ENT_QUOTES );
		$temp = new Event();
		$temp->date = $date;
		$temp->event = $text;
		$temp->type = "IC";
		$temp->hours = '';
		$temp->required = '';
		$temp->credit = '';
		$temp->c = '';
		$temp->chair = $event['c'];
		$temp->people = $event['ppl'];
		$temp->miles = $event['mi'];
		$temp->letters = '';
		array_push( $allEvents , $temp );
	?>{ date: '<?php echo $date;?>' , event: '<?php echo $text; ?>' , chair: '<?php if( $event['c']> 0 ) echo 'yes'; else echo 'no'?>' , people: '<?php echo $event['ppl']>0;?>' , miles: '<?php echo $event['mi'];?>' }
	<?php }
			$totalIC = $total;
			$totals['IC'] = $total['events'];
		?>]
	});
	Ext.define('FundraiserTracking', {
		extend: 'Ext.data.Model',
		fields: [ 'date' , 'event' , 'chair' , {
			name: 'people' ,
			type: 'int' } , {
			name: 'miles' ,
			type: 'int' } ]
	});
	var storeFundraiserTracking = Ext.create('Ext.data.Store',{
		model: 'FundraiserTracking',
		data: [ <?
	$events = getTrackedUser($id, 'fundraiser', $term_id);
	$total = array();
	$i = 0;
	$total['events'] = 0;
	$total['c'] = 0;
	if (count($events) > 0)	//to make it null if no person is selected.
		$total['d'] = 0;
	foreach($events as $event){
		$total['events'] += 1;
		$total['c'] += $event['c'];
		if ($event['ppl'] > 0)	//if they drove somebody
			$total['d'] += 1;
		if ( $i++ > 0 )
			echo " , ";
		$date = date('m/d/y', $event['date']);
		$text = htmlentities( $event['event_name'] , ENT_QUOTES );
		$temp = new Event();
		$temp->date = $date;
		$temp->event = $text;
		$temp->type = "Fundraiser";
		$temp->hours = '';
		$temp->required = '';
		$temp->credit = '';
		$temp->c = '';
		$temp->chair = $event['c'];
		$temp->people = $event['ppl'];
		$temp->miles = $event['mi'];
		$temp->letters = '';
		array_push( $allEvents , $temp );
	?>{ date: '<?php echo $date;?>' , event: '<?php echo $text; ?>' , chair: '<?php if( $event['c']> 0 ) echo 'yes'; else echo 'no'?>' , people: '<?php echo $event['ppl']>0;?>' , miles: '<?php echo $event['mi'];?>' }
	<?php }
			$totalFundraiser = $total;
			$totals['fundraiser'] = $total['events'];
		?>]
	});
	Ext.define('CAWTracking', {
		extend: 'Ext.data.Model',
		fields: [ 'date' , 'event' , {
			name: 'hours',
			type: 'float' }, 'chair' ]
	});
	var storeCAWTracking = Ext.create('Ext.data.Store',{
		model: 'CAWTracking',
		data: [ <?
	$events = getTrackedUser($id, 9, $term_id);
	$total = array();
	$i = 0;
	$total['events'] = 0;
	$total['h'] = 0;
	$total['c'] = 0;
	if (count($events) > 0)	//to make it null if no person is selected.
		$total['d'] = 0;
	foreach($events as $event){
		if ( $i++ > 0 )
			echo ' , ';
		$total['events'] += 1;
		$total['h'] += $event['h'];
		$total['c'] += $event['c'];
		$date = date('m/d/y', $event['date']);
		$text = htmlentities( $event['event_name'] , ENT_QUOTES );
		$temp = new Event();
		$temp->date = $date;
		$temp->type = "CAW";
		$temp->event = $text;
		$temp->hours = $event['h'];
		$temp->required = '';
		$temp->credit = '';
		$temp->c = '';
		$temp->chair = $event['c'];
		$temp->people = '';
		$temp->miles = '';
		$temp->letters = '';
		array_push( $allEvents , $temp );
	?> { date: '<?php echo $date;?>' , event: '<?php echo $text; ?>' , hours: '<?php echo $event['h'];?>' , chair: '<?php if( $event['c']> 0 ) echo 'yes'; else echo 'no'?>' }
	<?php }
			$totalCAW = $total;
		$totals['caw'] = $total['h'];
		?>]
	});
	Ext.define('AllTracking', {
		extend: 'Ext.data.Model',
		fields: [
		'date' , 'type' , 'event' , {
			name: 'hours' ,
			type: 'float' } , {
			name: 'required' ,
			type: 'float'}, {
			name: 'credit' ,
			type: 'int' } , 'c' , {
			name: 'chair' , 
			type: 'int' } , {
			name: 'people' , 
			type: 'int' } , {
			name: 'miles' ,
			type: 'int' } , {
			name: 'letters',
			type: 'int' }
		]
	});
	var storeAllTracking = Ext.create('Ext.data.Store',{
		model: 'AllTracking',
		data: <?php
			echo json_encode( $allEvents ); ?>,
		storeId: 'allTracking',
		groupField: 'type'
	});
	Ext.define('Upcoming' , {
		extend: 'Ext.data.Model',
		fields: [ 'date' , 'type' , 'event' , 'link' ]
	});
	var storeUpcoming = Ext.create('Ext.data.Store' , {
		model: 'Upcoming',
		data: <?php
			// custom query (Robin)
			// we should really create a super_query function
			// that validates it before going in...
			$query = "SELECT event_name AS event, event_id AS id, eventtype_name AS type, event_date AS date FROM event e INNER JOIN eventtype et ON e.eventtype_id=et.eventtype_id WHERE event_id IN ( SELECT event_id FROM shift WHERE shift_id IN (SELECT shift_id FROM signup WHERE user_id=".$id.") ) AND event_date > CURRENT_TIMESTAMP ORDER BY event_date";
			$result = mysql_query( $query );
			class UpcomingEvent {
				public $date, $type, $event , $link;
			}
			$upcoming = array();
			$i = 0;
			while ( $row = mysql_fetch_assoc( $result ) )
			{
				$i++;
				$temp = new UpcomingEvent();
				$temp->date = substr( $row['date'] , 0 , 10 );
				$name = $row['event'];
				if ( strlen( $name ) > 25 )
					$name = substr( $name , 0 , 25 ) . "...";
				$temp->event = htmlentities( $name , ENT_QUOTES );
				$temp->type = $row['type'];
				$temp->link = "<span class='upcoming'><a href='http://www.apo-x.org/event/show.php?id=".$row['id']."' target='_blank'>Go To Event</a></span>";
				array_push( $upcoming , $temp );
			}
			if ( $i == 0 )
			{
				$temp = new UpcomingEvent();
				$temp->date = 'right';
				$temp->event = 'If you are seeing this,';
				$temp->type = 'Alert';
				$temp->link = '';
				array_push( $upcoming , $temp );
				$temp = new UpcomingEvent();
				$temp->date = 'now';
				$temp->event = 'you are not signed up for any upcoming events!';
				$temp->type = 'Alert';
				$temp->link = '';
				array_push( $upcoming , $temp );
			}
			echo json_encode($upcoming);
		?>
	});
	Ext.define('mod1',{
		extend: 'Ext.data.Model',
		fields: [
			{ name: 'name' , type: 'string' },
			{ name: 'WellRounded' , type: 'int' }
		],
	});
	Ext.define('req1',{
		extend: 'Ext.data.Model',
		fields: [
			{ name: 'fellowship' , type: 'int' },
			{ name: 'meeting' , type: 'int' },
			{ name: 'leadership' , type: 'float' },
			{ name: 'hours' , type: 'int' },
			{ name: 'service' , type: 'int' },
			{ name: 'fundraiser' , type: 'int' }
		]
	});
	var store1 = new Ext.data.Store({
		model: 'mod1',
		data: [
			{ name: 'service', WellRounded: 20, you: 0 },
			{ name: 'leadership', WellRounded: 20 , you: 0 },
			{ name: 'fellowship', WellRounded: 20 , you: 0 }
		]
	});
	var store2 = new Ext.data.Store({
		model: 'req1',
		data: [
			{ fellowship: <?
			if ( $totals['fellowships'] > $fellowReq )
				echo $fellowReq;
			else
				echo $totals['fellowships'];
			?> , meeting: <?
			if ( $totals['meetings'] > $meetingReq )
				echo $meetingReq;
			else
				echo $totals['meetings'];
			?> , leadership: <?
			if ( $totals['leadership'] > $leadershipReq )
				echo $leadershipReq;
			else
				echo $totals['leadership'];
			?> , hours: <?
			if ( $totals['caw'] > $cawReq )
				echo $cawReq;
			else
				echo $totals['caw'];
			?> , service: <?
			if ( $totals['serviceHours'] > $totals['serviceHoursReq'])
				echo $totals['serviceHoursReq'];
			else
				echo $totals['serviceHours'];
			?> , fundraiser: <?
			if ( $totals['fundraiser'] > $fundReq )
				echo $fundReq;
			else
				echo $totals['fundraiser']; ?> }
		]
	});
    var win = Ext.create('Ext.Window', {
        width: Ext.get("dashboard").getWidth(),
		height: Ext.get("dashboard").getHeight(),
        hidden: false,
        shadow: false,
        maximizable: false,
		closable: false,
		draggable: false,
		resizable: false,
		renderTo: Ext.get("dashboard"),
		constrain: true,
        style: 'overflow: hidden;',
		title: "<?php
	$name = user_get($id, 'fl');
	$result = term_get($_GET['term']);
	$term_nick = $result['class_nick'];
	echo "{$name['name']}'s Tracking for {$term_nick} Term"; ?>",
		activeItem: 1,
        layout: {
			type: 'card'
		},
		highlight: true,
		tbar: [{
			toggleGroup: 'toolbar',
			enableToggle: true,
			text: 'Cardinal Principles',
			handler: function() {
				this.ownerCt.ownerCt.getLayout().setActiveItem(0);
				store2.loadData([{ fellowship: 0 , meeting: 0 , leadership: 0 , hours: 0 }]);
				store1.loadData([ 
					{ name: 'service', WellRounded: 20, you: <? echo $totals['serviceHours']; ?> },
					{ name: 'leadership', WellRounded: 20 , you: <? echo $totals['leadership']+$totals['meetings']; ?> },
					{ name: 'fellowship', WellRounded: 20 , you: <? echo $totals['fellowships']; ?> }
				]);
			}
		},{
			toggleGroup: 'toolbar',
			enableToggle: true,
			pressed: true,
			text: 'Dashboard',
			handler: function() {
				this.ownerCt.ownerCt.getLayout().setActiveItem(1);
				store2.loadData([
					{ fellowship: <?
					if ( $totals['fellowships'] > $fellowReq )
						echo $fellowReq;
					else
						echo $totals['fellowships'];
					?> , meeting: <?
					if ( $totals['meetings'] > $meetingReq )
						echo $meetingReq;
					else
						echo $totals['meetings'];
					?> , leadership: <?
					if ( $totals['leadership'] > $leadershipReq )
						echo $leadershipReq;
					else
						echo $totals['leadership'];
					?> , hours: <?
					if ( $totals['caw'] > $cawReq )
						echo $cawReq;
					else
						echo $totals['caw'];
					?> , service: <?
					if ( $totals['serviceHours'] > $serviceReq )
						echo $serviceReq;
					else
						echo $totals['serviceHours'];
					?> , fundraiser: <?
					if ( $totals['fundraiser'] > $fundReq )
						echo $fundReq;
					else
						echo $totals['fundraiser']; ?> }
				]);
				store1.loadData([ 
					{ name: 'service', WellRounded: 20, you: 0 },
					{ name: 'leadership', WellRounded: 20 , you: 0 },
					{ name: 'fellowship', WellRounded: 20 , you: 0 }
				]);
			}
		},{
			toggleGroup: 'toolbar',
			enableToggle: true,
			text: 'News',
			handler: function() {
				this.ownerCt.ownerCt.getLayout().setActiveItem(10);
			}
		},{
			toggleGroup: 'toolbar',
			enableToggle: true,
			text: 'Committee and All',
			handler: function() {
				this.ownerCt.ownerCt.getLayout().setActiveItem(9);
			}
		},{
			toggleGroup: 'toolbar',
			enableToggle: true,
			text: 'Service',
			handler: function() {
				this.ownerCt.ownerCt.getLayout().setActiveItem(2);
			}
		},{
			toggleGroup: 'toolbar',
			enableToggle: true,
			text: 'Fellowship',
			handler: function() {
				this.ownerCt.ownerCt.getLayout().setActiveItem(3);
			}
		},{
			toggleGroup: 'toolbar',
			enableToggle: true,
			text: 'Meeting',
			handler: function() {
				this.ownerCt.ownerCt.getLayout().setActiveItem(4);
			}
		},{
			toggleGroup: 'toolbar',
			enableToggle: true,
			text: 'Leadership',
			handler: function() {
				this.ownerCt.ownerCt.getLayout().setActiveItem(5);
			}
		},{
			toggleGroup: 'toolbar',
			enableToggle: true,
			text: 'IC',
			handler: function() {
				this.ownerCt.ownerCt.getLayout().setActiveItem(6);
			}
		},{
			toggleGroup: 'toolbar',
			enableToggle: true,
			text: 'Fundraiser', // CAW
			handler: function() {
				this.ownerCt.ownerCt.getLayout().setActiveItem(8);
			}
		}],
        items: [{
			activeItem: 0,
            id: 'chartCmp',
            xtype: 'chart',
            style: 'background:#fff',
            theme: 'Category2',
			animate: {
				easing: 'ease',
				duration: 1000
			},
            store: store1,
            insetPadding: 20,
            legend: {
                position: 'right'
            },
            axes: [{
                type: 'Radial',
                position: 'radial',
                label: {
                    display: true
                }
            }],
            series: [{
                type: 'radar',
                xField: 'name',
                yField: 'WellRounded',
                showInLegend: true,
                showMarkers: true,
                markerConfig: {
                    radius: 5,
                    size: 5
                },
                style: {
                    'stroke-width': 2,
                    fill: '#ff0000',
					opacity: 0.2
                }
            },{
                type: 'radar',
                xField: 'name',
                yField: 'you',
                showInLegend: true,
                showMarkers: true,
                markerConfig: {
                    radius: 5,
                    size: 5
                },
                style: {
                    'stroke-width': 2,
                    fill: 'none'
                }
            }]
        },{
			layout: {
				type: 'hbox',
				align: 'stretch'
			},
			border: 0,
			items: [{
					flex: 2,
					layout: {
						type: 'hbox',
						align: 'stretch'
					},
					border: 0,
					items: [{
						flex: 1,
						layout: {
							type: 'vbox',
							align: 'stretch'
						},
						border: 0,
						items: [{
							bodyPadding: '5px',
							xtype: 'gridpanel',
							title: 'Your Upcoming Events',
							flex: 3,
							border: 0,
							store: storeUpcoming,
							columns: [{
								text: 'Date' ,
								sortable: true,
								dataIndex: 'date',
								flex: 1
							},{
								text: 'Type' ,
								sortable: true,
								dataIndex: 'type',
								flex: 1
							},{
								text: 'Event' ,
								sortable: true,
								dataIndex: 'event',
								flex: 2
							},{
								text: 'Link' ,
								sortable: true,
								dataIndex: 'link',
								flex: 1
							}]
						},{
							border: 0,
							flex: 1,
							xtype: 'panel',
							title: "I'm Feeling Lucky!",
							layout: {
								type: 'hbox',
								align: 'stretch'
							},
							items: [{
								flex: 1,
								xtype: 'button',
								text: 'for Service',
								listeners: {
									click: function() {
										window.location = "<?php echo $serviceLink; ?>";
									}
								}
							},{
								flex: 1,
								xtype: 'button',
								text: 'for Fellowship',
								listeners: {
									click: function() {
										window.location = "<?php echo $fellowshipLink; ?>";
									}
								}
							},{
								flex: 1,
								xtype: 'button',
								text: 'for All Events',
								listeners: {
									click: function() {
										window.location = "<?php echo $allLink; ?>";
									}
								}
							}]
						}]
					}]
				},{
				flex: 2,
				title: 'Requirements',
				layout: {
					type: 'vbox',
					align: 'stretch'
				},
				border: 0,
				items: [
					{
						flex: 2,
						layout: {
							type: 'hbox',
							align: 'stretch'
						},
						border: 0,
						items: [
						{
							id: 'serviceGauge',
							xtype: 'chart',
							style: 'background:#fff',
							animate: {
								easing: 'ease',
								duration: 750
							},
							store: store2,
							insetPadding: 10,
							flex: 1,
							axes: [{
								type: 'Gauge',
								position: 'gauge',
								minimum: 0,
								maximum: <? echo $totals['serviceHoursReq']; ?>,
								steps: <? echo round($totals['serviceHoursReq']/2); ?>,
								margin: -10,
								title: 'Service Hours'
							}],
							series: [{
								type: 'gauge',
								field: 'service',
								donut: 50,
								colorSet: ['#147DF4', '#ddd']
							}]
						},{
							id: 'fellowshipGauge',
							xtype: 'chart',
							style: 'background:#fff',
							animate: {
								easing: 'ease',
								duration: 1000
							},
							store: store2,
							insetPadding: 10,
							flex: 1,
							axes: [{
								type: 'Gauge',
								position: 'gauge',
								minimum: 0,
								maximum: <? echo $fellowReq ?>,
								steps: <? echo $fellowReq ?>,
								margin: -10,
								title: 'Fellowships Attended'
							}],
							series: [{
								type: 'gauge',
								field: 'fellowship',
								donut: 50,
								colorSet: ['#9DF410', '#ddd']
							}]
						}
						]
					},{
						flex: 2,
						layout: {
							type: 'hbox',
							align: 'stretch'
						},
						border: 0,
						items: [
						{
							id: 'leadershipGauge',
							xtype: 'chart',
							style: 'background:#fff',
							animate: {
								easing: 'ease',
								duration: 1750
							},
							store: store2,
							insetPadding: 10,
							flex: 1,
							axes: [{
								type: 'Gauge',
								position: 'gauge',
								minimum: 0,
								maximum: <? echo $leadershipReq?>,
								steps: <? echo $leadershipReq?>,
								margin: -10,
								title: 'Leadership Hours'
							}],
							series: [{
								type: 'gauge',
								field: 'leadership',
								donut: 50,
								colorSet: ['#F49D10', '#ddd']
							}]
						},{
							id: 'hoursGauge',
							xtype: 'chart',
							style: 'background:#fff',
							animate: {
								easing: 'ease',
								duration: 2500
							},
							store: store2,
							insetPadding: 10,
							flex: 1,
							axes: [{
								type: 'Gauge',
								position: 'gauge',
								minimum: 0,
								maximum: <? echo $cawReq; ?>,
								steps: <? echo $cawReq/2; ?>,
								margin: -10,
								title: 'Fundraiser Amount'
							}],
							series: [{
								type: 'gauge',
								field: 'hours',
								donut: 50,
								colorSet: ['#1FD1DE', '#ddd']
							}]
						}
						]
					},{
						flex: 2,
						layout: {
							type: 'hbox',
							align: 'stretch'
						},
						border: 0,
						items: [{
							id: 'meetingGauge',
							xtype: 'chart',
							style: 'background:#fff',
							animate: {
								easing: 'ease',
								duration: 3250
							},
							store: store2,
							insetPadding: 10,
							flex: 1,
							axes: [{
								type: 'Gauge',
								position: 'gauge',
								minimum: 0,
								maximum: <? echo $meetingReq; ?>,
								steps: <? echo $meetingReq; ?>,
								margin: -10,
								title: 'Meetings Attended'
							}],
							series: [{
								type: 'gauge',
								field: 'meeting',
								donut: 50,
								colorSet: ['#9D10F4', '#ddd']
							}]
						},{
							id: 'ICGauge',
							xtype: 'chart',
							style: 'background:#fff',
							animate: {
								easing: 'ease',
								duration: 4000
							},
							store: store2,
							insetPadding: 10,
							flex: 1,
							axes: [{
								type: 'Gauge',
								position: 'gauge',
								minimum: 0,
								maximum: <? echo $ICReq; ?>,
								steps: <? echo $ICReq; ?>,
								margin: -10,
								title: 'Interchapter'
							}],
							series: [{
								type: 'gauge',
								field: 'interchapter',
								donut: 50,
								colorSet: ['#F4F010', '#ddd']
							}]
						}]
					}]
				}]
			},{
					flex: 1,
					layout: {
						type: 'hbox',
						align: 'stretch'
					},
					items: [{
						xtype: 'panel',
						flex: 1,
						title: 'Totals',
						html: '<?php
			echo "<div class=\"left\"><div>Hours: {$totals['serviceHours']}</div>";
			echo "<div>Required: {$totalService['r']}</div>";
			echo "<div>Projects: {$totalService['p']}</td>";
			echo "<div>Projects: {$totalService['c']}</td></tr></table>";
			echo "<div>Chapter: {$c[0]}</div>";
			echo "<div>Campus: {$c[1]}</div>";
			echo "<div>Community: {$c[2]}</div>";
			echo "<div>Country: {$c[3]}</div>";
			echo "<table><tr><td class=\"small fourc0\">{$c[0]}</td>";
			echo "<td class=\"small fourc1\">{$c[1]}</td>";
			echo "<td class=\"small fourc2\">{$c[2]}</td>";
			echo "<td class=\"small fourc3\">{$c[3]}</td></tr></table>";
		?>',
					},{
						xtype: 'gridpanel',
						flex: 5,
						store: storeServiceTracking,
						features: [{
							ftype: 'summary',
							hideGroupedHeader: true
						}],
						columns: [{
							text: 'Date' ,
							sortable: true,
							dataIndex: 'date'
						},{
							text: 'Event' ,
							sortable: true,
							dataIndex: 'event',
							flex: 1,
							summaryType: 'count',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '(' + value + ' Events)' : '(1 Event)');
							}
						},{
							text: 'Hours',
							sortable: true,
							dataIndex: 'hours',
							summaryType: 'sum',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '(' + value + ' Hours)' : '(1 Hour)');
							}
						},{
							text: 'Required',
							sortable: true,
							dataIndex: 'required',
							summaryType: 'sum',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '(' + value + ' Hours Required)' : '(1 Hour Required)');
							}
						},/*{
							text: 'Projects',
							sortable: true,
							dataIndex: 'projects',
							summaryType: 'sum',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '(' + value + ' Projects)' : '(1 Project)');
							}
						},*/{
							text: 'Chaired',
							sortable: true,
							dataIndex: 'chair'
						},{
							text: 'C',
							sortable: true,
							dataIndex: 'c'
						}]
					}]
				},{
					flex: 1,
					layout: {
						type: 'hbox',
						align: 'stretch'
					},
					items: [{
						xtype: 'panel',
						flex: 1,
						title: 'Totals',
						html: '<?php
			echo "<div class=\"left\"><div>Events: {$totalFellowship['events']}</div>";
			echo "<div>Chaired: {$totalFellowship['c']}</div>";
			if( $totalFellowship['d'] > 0 )
				echo "<div>{$totalFellowship['d']} times driving</div>";
			if ($totalFellowship['ppl'] > 0 )
				echo "<div>Drove {$totalFellowship['ppl']} people</div>";
			echo "</div>";
		?>',
					},{
						xtype: 'gridpanel',
						flex: 5,
						store: storeFellowshipTracking,
						features: [{
							ftype: 'summary',
							hideGroupedHeader: true
						}],
						columns: [{
							text: 'Date' ,
							sortable: true,
							dataIndex: 'date'
						},{
							text: 'Event' ,
							sortable: true,
							dataIndex: 'event',
							flex: 1,
							summaryType: 'count',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '(' + value + ' Events)' : '(1 Event)');
							}
						},{
							text: 'Chaired',
							sortable: true,
							dataIndex: 'chair'
						},{
							text: 'People Driven',
							sortable: true,
							dataIndex: 'people',
							summaryType: 'sum',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '(' + value + ' People Driven)' : '(1 Person Driven)');
							}
						},{
							text: 'Miles Drove',
							sortable: true,
							dataIndex: 'miles',
							summaryType: 'sum',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '(' + value + ' Miles)' : '(1 Mile)');
							}
						}]
					}]
				},{
					flex: 1,
					layout: {
						type: 'hbox',
						align: 'stretch'
					},
					items: [{
						xtype: 'panel',
						flex: 1,
						title: 'Totals',
						html: '<?php
			echo "<div class=\"left\"><div>Events: {$totalMeeting['events']}</div><div>";
			if ( $status==STATUS_PLEDGE )
				echo "Pin";
			else
				echo "Letters";
			echo ": {$totalMeeting['p']}</div></div>";
		?>',
					},{
						xtype: 'gridpanel',
						flex: 5,
						store: storeMeetingTracking,
						features: [{
							ftype: 'summary',
							hideGroupedHeader: true
						}],
						columns: [{
							text: 'Date' ,
							sortable: true,
							dataIndex: 'date'
						},{
							text: 'Event' ,
							sortable: true,
							dataIndex: 'event',
							flex: 1,
							summaryType: 'count',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '(' + value + ' Events)' : '(1 Event)');
							}
						},{
							text: 'Credit',
							sortable: true,
							dataIndex: 'credit',
							summaryType: 'sum',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '(' + value + ' Credits)' : '(1 Credit)');
							}
						},{
							text: 'Pin/Letters',
							sortable: true,
							dataIndex: 'letters'
						}]
					}]
				},{
					flex: 1,
					layout: {
						type: 'hbox',
						align: 'stretch'
					},
					items: [{
						xtype: 'panel',
						flex: 1,
						title: 'Totals',
						html: '<?php
			echo "<div class=\"left\"><div>Credit: ".$totals['leadership']."</div>";
			echo "<div>Chaired: {$totalLeadership['c']}</div>";
			if(isset($totalLeadership['d']))
				echo "<div>{$totalLeadership['d']} times driving</div>";
			echo "</div>";
		?>',
					},{
						xtype: 'gridpanel',
						flex: 5,
						store: storeLeadershipTracking,
						features: [{
							ftype: 'summary',
							hideGroupedHeader: true
						}],
						columns: [{
							text: 'Date' ,
							sortable: true,
							dataIndex: 'date'
						},{
							text: 'Event' ,
							sortable: true,
							dataIndex: 'event',
							flex: 1,
							summaryType: 'count',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '(' + value + ' Events)' : '(1 Event)');
							}
						},{
							text: 'Credit',
							sortable: true,
							dataIndex: 'credit',
							summaryType: 'sum',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 0) ? '(' + value + ' Credits)' : '(1 Credit)');
							}
						},{
							text: 'Chaired',
							sortable: true,
							dataIndex: 'chair'
						},{
							text: 'People Driven',
							sortable: true,
							dataIndex: 'people',
							summaryType: 'sum',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '(' + value + ' People Driven)' : '(1 Person Driven)');
							}
						},{
							text: 'Miles Drove',
							sortable: true,
							dataIndex: 'miles',
							summaryType: 'sum',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '(' + value + ' Miles)' : '(1 Mile)');
							}
						}]
					}]
				},{
					flex: 1,
					layout: {
						type: 'hbox',
						align: 'stretch'
					},
					items: [{
						xtype: 'panel',
						flex: 1,
						title: 'Totals',
						html: '<?php
			echo "<div class=\"left\"><div>Events: {$totalIC['events']}</div>";
			echo "<div>Chaired: {$totalIC['c']}</div>";
			if(isset($totalIC['d']))
				echo "<div>{$totalIC['d']} times driving</div>";
			echo "</div>";
		?>',
					},{
						xtype: 'gridpanel',
						flex: 5,
						store: storeICTracking,
						features: [{
							ftype: 'summary',
							hideGroupedHeader: true
						}],
						columns: [{
							text: 'Date' ,
							sortable: true,
							dataIndex: 'date'
						},{
							text: 'Event' ,
							sortable: true,
							dataIndex: 'event',
							flex: 1,
							summaryType: 'count',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '(' + value + ' Events)' : '(1 Event)');
							}
						},{
							text: 'Chaired',
							sortable: true,
							dataIndex: 'chair'
						},{
							text: 'People Driven',
							sortable: true,
							dataIndex: 'people',
							summaryType: 'sum',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '(' + value + ' People Driven)' : '(1 Person Driven)');
							}
						},{
							text: 'Miles Drove',
							sortable: true,
							dataIndex: 'miles',
							summaryType: 'sum',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '(' + value + ' Miles)' : '(1 Mile)');
							}
						}]
					}]
				},{
					flex: 1,
					layout: {
						type: 'hbox',
						align: 'stretch'
					},
					items: [{
						xtype: 'panel',
						flex: 1,
						title: 'Totals',
						html: '<?php
			echo "<div class=\"left\"><div>Events: {$totalFundraiser['events']}</div>";
			echo "<div>Chaired: {$totalFundraiser['c']}</div>";
			if(isset($totalFundraiser['d']))
				echo "<div>{$totalFundraiser['d']} times driving</div>";
			echo "</div>";
		?>',
					},{
						xtype: 'gridpanel',
						flex: 5,
						store: storeFundraiserTracking,
						features: [{
							ftype: 'summary',
							hideGroupedHeader: true
						}],
						columns: [{
							text: 'Date' ,
							sortable: true,
							dataIndex: 'date'
						},{
							text: 'Event' ,
							sortable: true,
							dataIndex: 'event',
							flex: 1,
							summaryType: 'count',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '(' + value + ' Events)' : '(1 Event)');
							}
						},{
							text: 'Chaired',
							sortable: true,
							dataIndex: 'chair'
						},{
							text: 'People Driven',
							sortable: true,
							dataIndex: 'people',
							summaryType: 'sum',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '(' + value + ' People Driven)' : '(1 Person Driven)');
							}
						},{
							text: 'Miles Drove',
							sortable: true,
							dataIndex: 'miles',
							summaryType: 'sum',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '(' + value + ' Miles)' : '(1 Mile)');
							}
						}]
					}]
				},{
					flex: 1,
					layout: {
						type: 'hbox',
						align: 'stretch'
					},
					items: [{
						xtype: 'panel',
						flex: 1,
						title: 'Totals',
						html: '<?php
			echo "<div class=\"left\"><div>Events: {$total['events']}</div>";
			echo "<div>Amount: {$total['h']}</div>";
			echo "<div>Chaired: {$total['c']}</div></div>";
		?>',
					},{
						xtype: 'gridpanel',
						flex: 5,
						store: storeCAWTracking,
						features: [{
							ftype: 'summary',
							hideGroupedHeader: true
						}],
						columns: [{
							text: 'Date' ,
							sortable: true,
							dataIndex: 'date'
						},{
							text: 'Event' ,
							sortable: true,
							dataIndex: 'event',
							flex: 1,
							summaryType: 'count',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '(' + value + ' Events)' : '(1 Event)');
							}
						},{
							text: 'Amount',
							sortable: true,
							dataIndex: 'hours',
							summaryType: 'sum',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '($' + value + ')' : '(1 Hour)');
							}
						},{
							text: 'Chaired',
							sortable: true,
							dataIndex: 'chair'
						}]
					}]
				},{
					flex: 1,
					xtype: 'panel',
					layout: {
						type: 'hbox',
						align: 'stretch'
					},
					items: [{
						xtype: 'panel',
						flex: 1,
						title: 'Committee & Dues',
						html:'<?php
	$sql = 'SELECT credit, dues, details FROM trackingcomm '
			. "WHERE user_id = '$id' ";
			
	$result = db_select1($sql);
	
	$credit = $result['credit'] ? 'yes' : 'no';
	$dues = $result['dues'] ? 'yes' : 'no';
	$details = $result['details'];
	?><div class=\"left\"><div>Comm Credit: <?=$credit?></div><div>Details: <?=$details?></div><div>Dues: <?=$dues?></div></div>'
					},{
						xtype: 'gridpanel',
						flex: 5,
						store: storeAllTracking,
						frame: false,
						autoScroll: true,
						style: "overflow-y: auto",
						features: [{
							groupHeaderTpl: '{name} ({rows.length} Event{[values.rows.length > 1 ? "s" : ""]})',
							ftype: 'groupingsummary',
							hideGroupedHeader: true
						}],
						columns: [{
							text: 'Date' ,
							sortable: true,
							dataIndex: 'date',
							flex: 2
						},<?php/*
						{
							text: 'Type',
							sortable: true,
							dataIndex: 'type',
							flex: 2
						},
						*/?>{
							text: 'Event' ,
							sortable: true,
							dataIndex: 'event',
							flex: 4,
							summaryType: 'count',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '(' + value + ' Events)' : '(1 Event)');
							}
						},{
							text: 'Hours',
							sortable: true,
							dataIndex: 'hours',
							flex: 2,
							summaryType: 'sum',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '(' + value + ' Hours)' : '1 Hour');
							}
						},{
							text: 'Required',
							sortable: true,
							dataIndex: 'required',
							flex: 2,
							summaryType: 'sum',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '(' + value + ' +Hours)' : '1 +Hour');
							}
						},{
							text: 'Credit',
							sortable: true,
							dataIndex: 'credit',
							flex: 1,
							summaryType: 'sum',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '(' + value + ' Credit)' : '1 Credit');
							}
						},{
							text: 'Chaired',
							sortable: true,
							dataIndex: 'chair',
							flex: 1,
							summaryType: 'sum',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '(' + value + ' Chaired)' : 'Chaired Once');
							}
						},{
							text: '<?php if ( $status==STATUS_PLEDGE )
								echo "Pin";
							else
								echo "Letters";
							?>',
							sortable: true,
							dataIndex: 'letters',
							flex: 1,
							summaryType: 'sum',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return '(' + value + ' <?php if ( $status==STATUS_PLEDGE )
								echo "Pin";
							else
								echo "Letters";
							?>)';
							}
						},{
							text: 'C',
							sortable: true,
							dataIndex: 'c',
							flex: 2
						},{
							text: 'People',
							sortable: true,
							dataIndex: 'people',
							flex: 1,
							summaryType: 'sum',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '(' + value + ' People)' : '1 Person');
							}
						},{
							text: 'Miles',
							sortable: true,
							dataIndex: 'miles',
							flex: 1,
							summaryType: 'sum',
							summaryRenderer: function(value, summaryData, dataIndex) {
								return ((value === 0 || value > 1) ? '(' + value + ' Miles)' : '1 Mile');
							}
						}]
					}]
				},{
					flex: 1,
					layout: {
						type: 'hbox',
						align: 'stretch'
					},
					items: [{
						xtype: 'panel',
						flex: 2,
						title: 'Upcoming Events',
						contentEl: "upcoming",
						autoScroll: true,
						bodyPadding: '10px',
					},{
						xtype: 'panel',
						flex: 4,
						title: 'Announcements',
						contentEl: "announcements",
						autoScroll: true
					},{
						xtype: 'panel',
						flex: 1,
						title: 'Recent Forum Posts',
						contentEl: 'recent',
						autoScroll: true,
						bodyPadding: '10px',
					}]
				}
			]
    });
});
	</script>
	<style type="text/css">
	table {
		margin: 0;
	}
	.x-grid-row-summary  .x-grid-cell {
		border: 0;
	}
	.x-grid-cell {
		font-size: 9px;
		font-family: Verdana;
	}
	.upcoming a:link, .upcoming a:visited, .upcoming a:active , .recent a:link, .recent a:visited, .recent a:active {
		display: block;
		font-size: 11px;
	}
	
	</style>
</div>
</div>
</div>
<?php
}	
?>

</div>
<?php show_footer(); ?>
