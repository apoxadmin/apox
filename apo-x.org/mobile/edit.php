<?php 
include_once dirname(dirname(__FILE__)) . '/include/mobiletemplate.inc.php'; // start session and open database
include_once dirname(dirname(__FILE__)) . '/include/show.inc.php';

$page = $_GET['page'];
$event_id = $_GET['event_id'];

if(isset($_GET["date"]))
	$maybeDate = $_GET["date"];
else
	$maybeDate = "";

if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

show_calendarheader();

// must take an array for $maybe
function show_eventModify($new, $maybe)
{ 
	include_once dirname(dirname(__FILE__)) . '/include/event.inc.php';
	include_once dirname(dirname(__FILE__)) . '/include/forms.inc.php';
	// fill maybe with event info
	if($new==false):
		$maybe = event_get($maybe['id']);
		$maybe['time'] = date('g:ia',$maybe['date']);
		$seconds = $maybe['enddate'] - $maybe['date'];
		$minutes = (int)($seconds / 60);
		$hours = (int)($minutes / 60);
		$minutes %= 60;
		if($minutes<10)
			$minutes = '0'.$minutes;
		$maybe['duration'] = $hours . ':' . $minutes;
		$maybe['date'] = date("m/d/Y",$maybe['date']);
		$maybe['c'] = fourC_get($maybe['id']);
	else:
		$maybe['duration'] = '0:00';
		$maybe['description'] = "";
		$maybe['location'] = "";
		$maybe['mileage'] = 0;
		$maybe['contact'] = "";
		$maybe['custom1'] = "";
		$maybe['custom2'] = "";
		$maybe['custom3'] = "";
		$maybe['custom4'] = "";
		$maybe['custom5'] = "";
	endif;
?>
	<form name="event" onsubmit="return valid(this)" 
        method="POST" action="/inputAdmin.php">
	<?php forms_hiddenInput($new?"eventCreate":"eventUpdate", 
                        "mobile/calendar.php"); ?>
	<?php forms_hidden('event_id', $maybe['id']); ?>
	
	<table id="eventTable" cellspacing="1">
	<tr>
		<td class="heading" colspan="3">Edit Event</td>
	</tr>
	<tr>
		<th>Name<br></th>
		<td><?php forms_text_required(30,"name",$maybe['name']); ?></td>
		<td></td>
	</tr>
	<tr>
		<th>Date<br></th>
		<td><?php forms_date('date',$maybe['date'],'event.date') ?></td>
		<td>MM/DD/YYYY<br>eg 09/12/2004</td>
	</tr>
	<tr>
		<th>Time<br></th>
		<td><?php forms_time("time",$maybe['time']) ?></td>
		<td>HH:MM (am|pm)<br>eg 12:34pm</td>
	</tr>
	<tr>
		<th>Duration<br></th>
		<td>
			<?php forms_duration('duration',$maybe['duration']) ?>
		</td>
		<td>H:MM<br>eg 1:30<br>(0:00 is unspecified)</td>
	</tr>
	<tr>
		<th>Location<br></th>
		<td>
			<?php forms_textarea('location',
                    str_replace("\n",'',$maybe['location'])) ?>
		<td>
		</td>
	</tr>
<?php
	if ($new || $maybe['type'] == 'Service' || $maybe['type'] == 'Fellowship')
	{ ?>
	<tr>
		<th>Trip Mileage<br></th>
		<td>
			<?php forms_text(4,"mileage",$maybe['mileage']); ?> miles
		</td>
		<td></td>
	</tr>
<?php
	} else { 
		forms_hidden("mileage",0);
	}
?>
	<tr>
		<script type="text/javascript">
		var oldValue = <?php echo $maybe['typeid']?$maybe['typeid']:'1' ?>;
		function fourC()
		{
			var mySelect = document.getElementById('eventTypeSelect');
			var myTable = document.getElementById('eventTable');
			var row = document.getElementsByName('fourCSelect');
			if(mySelect.value==1) // service
				for (var i = 0; i < row.length; i++) {
					row[i].style.display = 'inline-block';
				}
			else
				for (var i = 0; i < row.length; i++) {
					row[i].style.display = 'none';
				}
		}
		</script>

		<th>Type<br></th>
		<td><select id="eventTypeSelect" size="1" name="type" onchange="fourC()">
		<?php
		$types = eventtype_getAll();
		foreach($types as $line)
		{ 
			$selected = ($maybe['typeid']==$line['id']?'selected':'');
			echo "<option $selected value=\"{$line['id']}\">{$line['name']}</option>";
		} ?>
		</select></td>
		<td></td>
	</tr>
	<tr>
		<th>Four C's</th>
		<td name="fourCSelect">
			<?php forms_radio('c','0', ($maybe['c']=='Chapter')) ?>Chapter
			<?php forms_radio('c','1', ($maybe['c']=='Campus')) ?>Campus
			<?php forms_radio('c','2', ($maybe['c']=='Community')) ?>Community
			<?php forms_radio('c','3', ($maybe['c']=='Country')) ?>Country
		</td>
	</tr>
	<script type="text/javascript">
		fourC();
	</script>
	<tr>
		<th>IC<br></th>
		<td>
			<?php forms_radio('ic', '0', ($maybe['ic']==false) ) ?>No&nbsp;&nbsp;&nbsp;&nbsp;
			<?php forms_radio('ic', '1', ($maybe['ic']==true) ) ?>Yes
		</td>
		<td></td>
	</tr>
	<tr>
		<th>Fundraiser<br></th>
		<td>
			<?php forms_radio('fund', '0', ($maybe['fund']==false) ) ?>No&nbsp;&nbsp;&nbsp;&nbsp;
			<?php forms_radio('fund', '1', ($maybe['fund']==true) ) ?>Yes
		</td>
		<td></td>
	</tr>
	<tr>
		<th>Description<br></th>
		<td>
			<?php forms_textarea('description',str_replace("\n",'',$maybe['description'])) ?>
		</td>
		<td></td>
	</tr>
	<tr>
		<th>Event Contact<br></th>
		<td>
			<?php forms_textarea('contact',str_replace("\n",'',$maybe['contact'])) ?>
		</td>
		<td></td>
	</tr>
	<tr>
		<th>Additional Info</th>
		<td>
			<?php forms_text(50,"custom1",$maybe['custom1']); ?><br />
			<?php forms_text(50,"custom2",$maybe['custom2']); ?><br />
			<?php forms_text(50,"custom3",$maybe['custom3']); ?><br />
			<?php forms_text(50,"custom4",$maybe['custom4']); ?><br />
			<?php forms_text(50,"custom5",$maybe['custom5']); ?>
		</td>
		<td>Additional info you want from people when they sign up.<br />
			eg What time can you leave?<br />
			eg How many passengers can you take?
		</td>
	</tr>
	<tr>
		<th>So Hot Right Now</th>
		<td>
			<?php forms_checkbox('hot',1,($maybe['hot']==1)); ?>
		</td>
		<td>This event is sooo hot right now! (It will be linked from the home page.)
		</td>
	</tr>
	<tr><td class="out">
	<?php 
	forms_submit($new?'Create':'Update', ''); ?>
	</td></tr>
	</table>
	</form>
<?php 
}

// permissions?
if($class!="admin")
	show_note('You must be an administrator to access this page.');

// create or update?
if($page == "update"):
	$defaults = array();
	$defaults['id'] = $event_id;
	show_eventModify(false,$defaults);
elseif($page == "create"):
	$defaults = array();
	$defaults['date'] = $maybeDate;
	show_eventModify(true,$defaults);
endif;

show_footer(); 
?>
