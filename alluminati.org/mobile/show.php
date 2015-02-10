<?php 
include_once dirname(dirname(__FILE__)) . '/include/mobiletemplate.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/forms.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/event.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/signup.inc.php';

if(isset($_GET['id']))
	$event_id = (int)$_GET['id'];
	
if(isset($_SESSION['id']))
	$id = $_SESSION['id'];
	
if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

show_calendarheader();

if($event_id) {
	$modifiable = false;
	
	// if they're admin
	if($class=='admin')
		$modifiable = true;

	$event = event_get($event_id); 
	$shifts = shift_getAll($event_id);

	show_eventDescription($event, $shifts, $modifiable, $class, $id);

	show_shifts($event, $shifts, $class, $id);
	
	// Show comments if logged in
	if(isset($id))
		show_comments($event_id,$id,$class);
		
	// Show signup tool if they're logged in as ExComm
	if($class=='admin')
	{
		// get shifts, if found show signups/attendance
		show_signup($event, $class, $id);
	}
}

show_footer();

//********************************************************************
// helper functions
//********************************************************************

function get_emails($event)
{
	$sql = 'SELECT DISTINCT user_email, user_name AS name '
		. ' FROM event, shift, signup, user '
		. ' WHERE event.event_id = shift.event_id '
        . ' AND shift.shift_id = signup.shift_id '
        . ' AND signup.user_id = user.user_id '
		. " AND event.event_id = '$event'"
		. ' ORDER BY user_name';
		
	$users = db_select($sql);
	
	$to = '';
	foreach($users as $user)
		$to .= '"'.$user['name'].'" <'. $user['user_email'] . '>, ';
	if($to != '')
		$to = substr($to, 0, -2);
		
	return htmlentities($to);
}

function get_chairs($event)
{
	$sql = 'SELECT user_name AS name, class_nick '
		. ' FROM chair, user, class '
		. ' WHERE chair.user_id = user.user_id '
        . ' AND class.class_id = user.class_id '
		. " AND event_id = '$event'"
		. ' ORDER BY user_name';
	$chairs = db_select($sql);
	
	$to = '';
	foreach($chairs as $chair)
		$to .= "<span title=\"{$chair['class_nick']} Class\">"
             . "{$chair['name']}</span>, ";
	if($to != '')
		$to = substr($to, 0, -2);
		
	return $to;
}

function get_interest($event)
{
	$sql = 'SELECT user_name AS name, class_nick '
		. ' FROM interest, user, class '
		. ' WHERE interest.user_id = user.user_id '
        . ' AND class.class_id = user.class_id '
		. " AND event_id = '$event'"
		. ' ORDER BY user_name';
	$interest = db_select($sql);
	
	$to = '';
	foreach($interest as $person)
		$to .= "<span title=\"{$person['class_nick']} Class\">"
             . "{$person['name']}</span>, ";
	if($to != '')
		$to = substr($to, 0, -2);
		
	return $to;
}

function my_interest($user_id, $event_id)
{
	$sql = 'SELECT * FROM interest '
		. " WHERE user_id = '$user_id' "
		. " AND event_id = '$event_id' ";
	
	if(db_select1($sql) === false)
		return false;
	else 
		return true;
}

function show_eventDescription($event, $shifts, $modifiable, $class, $id)
{
    // make a convenient alias
	$event_id = $event['id'];
    
    // evaluate the conditions on which to display certain 
    // information and controls
    $type = ($event['ic']==1?"IC ":"") . $event["type"];
    
    if($event['type']=="Service")
        $c = fourc_get($event_id);
    if($c == "?")
        unset($c);
    
    $date = date('l F jS, Y',$event["date"]);
    $time = date('g:i a',$event["date"]);
    if(strcmp($event["enddate"],$event["date"])!=0)
        $time .= ' - ' . date('g:i a',$event["enddate"]);
    
    $location = str_replace("\n","<br />",$event['location']);
    
	?>
	<table cellspacing="1" style="margin-bottom:-10px;">
	<tr><td class="heading" colspan="4">Event Information</td></tr>
    <tr><th>Name</th><td colspan="3"><?= $event["name"] ?></td></tr> 
    <tr><th>Type</th><td colspan="3"><?= $type ?></td></tr>
    <?php if(isset($c)): ?>
        <tr><th>Four C's</th><td colspan="3"><?= $c; ?></td></tr>
	<?php endif; ?>
    <tr><th>Date</th><td colspan="3"><?= $date ?></td></tr>
    <tr><th>Time</th><td colspan="3"><?= $time ?>
	</td></tr>
    <tr><th>Location</th><td colspan="3"><?= $location ?></td></tr>
<?php
	if ($event['type'] == 'Service' || $event['type'] == 'Fellowship')
		echo '<tr><th>Trip Miles</th><td colspan="3">' . $event['mileage'] .' miles</td></tr>';
?>
	<?php if(count($shifts)!=0 && event_multipleShifts($event)): ?>
	<tr>
		<th>Shifts</th>
		<td colspan="3">
			<?php 
			$shiftCount = 0; // make a new line every now and then
            foreach($shifts as $s)
                echo date('g:i a - ',strtotime($s['start'])), 
                     date('g:i a',strtotime($s['end'])), '<br/>';
			?>
		</td>
	</tr>
    <tr>
        <th>Chair Tools</th>
        <td colspan="3">
        <a href="/event/helper.php?event=<?= $event_id ?>">Chair Signin Sheet</a>
        </td>
    </tr>
	<?php endif; ?>
	<tr><th>Description</th>
    <td colspan="3">
        <?php echo str_replace("\n","<br />",$event['description']) ?>
    </td></tr>
	<?php if ($event['contact'] != '' && isset($class) ): ?>
	<tr><th>Event Contact</th>
    <td colspan="3">
    <?php echo str_replace("\n","<br />",$event['contact']) ?></td></tr>
	<?php endif; 
    if($class && (event_multipleShifts($event))): ?>
			<script type="text/javascript">
			function showEmails()
			{
				document.getElementById('Emails').style.display = 'inline';
				document.getElementById('showEmails').innerHTML = '';
			}
			</script>
			
			<tr><th>Emails</th>
            <td class="black" colspan="3">
				<a href="javascript:showEmails()" id="showEmails">Show Emails</a>
				<div id="Emails" style="display:none;">
					<?php echo get_emails($event_id) ?>
				</div>
			</td>
			</tr>				
	<?php endif; ?>
	<?php if($event['type']=='CAW Hours' || $event['type']=='Fellowship' || 
             ($event['ic']==true && $event['type']!='Service')): ?>
        <tr>
        <th>Chairs</th>
        <td colspan="3">
            <?php $chairlist = get_chairs($event_id); 
            echo $chairlist;
            if($class=='admin')
                echo "<a href=\"/event/chair.php?event=$event_id\">(edit)</a>";
            elseif($class=='user' && $chairlist == '')
            {
                echo '<form method="POST" ',
                     'onSubmit="return confirmDialog();" ',
                     'action="/event/input.php">';
                forms_hiddenInput('addchair',"/mobile/show.php?id=$event_id");
                forms_hidden('event',$event_id);
                forms_submit('Chair', 'Chair');
                echo '</form>';
            }
            ?>
        </td>
        </tr>
	<?php endif; ?>
	
	<!--
	<tr>
		<th>Interest</th>
		<td colspan="3">
			<?php 
			$interestlist = get_interest($event_id); 
			$iAmInterested = my_interest($id, $event_id); 
			?>
			<div id="interest" style="display: none;">
			<?
			if($class=='admin')
				echo "<a href=\"/event/interest.php?event=$event_id\"> (edit interest sheet)</a><br/>";
			elseif($class=='user' && !$iAmInterested)
			{
				echo '<form method="POST" action="/event/input.php">';
				forms_hiddenInput('addinterest',"/event/show.php?id=$event_id");
				forms_hidden('event',$event_id);
				forms_submit('I\'m interested!', 'I\'m interested!');
				echo '</form>';
			}
			elseif($class=='user')
			{
				echo '<form method="POST" action="/event/input.php">';
				forms_hiddenInput('removeinterest',"/event/show.php?id=$event_id");
				forms_hidden('event',$event_id);
				forms_submit('Take me off', 'Take me off');
				echo '</form>';
			}
			echo $interestlist;
			?>
			</div>
			<script type="text/javascript">
			function interest()
			{
				document.getElementById('interest').style.display = 'inline';
				document.getElementById('interestbutton').innerHTML = '';
			}

			</script>
			<a href="javascript:interest()" id="interestbutton">Show Interest Sheet</a>
		</td>
	</tr>
	-->

	<?php if($modifiable): ?>
	<tr>
		<th>Options</th>
			<form name="modifyevent" method="GET" action="/mobile/edit.php"><td>
            <?php forms_hidden("event_id", $event_id); ?>
			<input name="page" type="hidden" value="update">
			<input name="submit" type="submit" value="Modify" />
			</td></form>
		
		
			<form name="deleteevent" method="POST" onSubmit="return confirmDialog();" action="/inputAdmin.php">
			<td <?php echo ($event["type"]!="Service" && $event['ic']!=true)?'rowspan="2"':''?>>
            <?php forms_hidden("event_id", $event_id); ?>
			<?php forms_hiddenInput("eventDelete","mobile/calendar.php") ?>
			<input name="submit" type="submit" value="Delete" />
			</td>
			</form>
				
			<?php if(event_multipleShifts($event)): ?>
			<form name="addshift" method="GET" action="/mobile/shift.php" ><td>
            <?php forms_hidden("event", $event_id); ?>
			<input name="page" type="hidden" value="create">
			<input name="submit" type="submit" value="Add Shift" />
			</td></form>
			<?php endif; ?>
		
	</tr>
	<?php endif; ?>
	</table>
	<br />
<?php 
}

function show_shifts($event, $shifts, $class, $user_id)
{
	include_once dirname(dirname(__FILE__)) . '/include/signup.inc.php';
	$id = $_SESSION['id'];
    if ($event['type']=='Service')
	{
		$signup_days = SIGNUP_DAYS;
		$remove_days = REMOVE_DAYS;
		$modifiable = ($id == USERID_SERVICE || $id == USERID_ADMIN);
	}
	elseif ($event['type']=='Interviews')
	{
		$signup_days = INTERVIEWS_SIGNUP_DAYS;
		$remove_days = INTERVIEWS_REMOVE_DAYS;
		$modifiable = ($class=='admin');
	}
	else {
		$modifiable = ($class=='admin');
	}
	$event_id = $event['id'];
	
	foreach($shifts as $shift):
		$list = signup_getSList($shift['shift']); 
		if($event['type']=='Service' || $event['type']=='Interviews')
		if($event['type']=='Service' || $event['type']=='Interviews')
            $needReplacement = (NOW > strtotime("-$signup_days days",shift_getStamp($shift['shift'])));
		elseif($event['ic']==true)
            $needReplacement = (NOW > shift_getStamp($shift['shift']));
        
        $passed = (NOW > shift_getStamp($shift['shift']));
        
		?>
		<table cellspacing="1" style="margin-bottom:-10px;">
		<tr>
		
			<?php if (event_multipleShifts($event)) { ?>
            
			<td class="heading" colspan="<?php echo ($_SESSION['class']=='admin')?6+show_customfieldcount($event):13; ?>">Shift <?php 
				echo date('g:i a',strtotime($shift['start'])),' - ',
					date('g:i a',strtotime($shift['end'])); 
				if($shift['capacity']!=0) 
					echo ' (Cap: ', $shift['capacity'], ')';
				else
					echo ' (Cap: unlimited)';
                if($shift['name'] != '')
                    echo "<br/>({$shift['name']})";
				?>
			</td>
				
			<?php if($modifiable): ?>
			<form method="GET" action="/event/shift.php">
			<td class="heading">
            <?php forms_hidden("event", $event_id); ?>
            <?php forms_hidden("shift", $shift['shift']); ?>
            <?php forms_hidden("page", "update"); ?>
			<input name="submit" type="submit" value="Modify" />
			</td>
			</form>
			<form method="POST" action="/inputAdmin.php" onSubmit="return confirmDialog();" >
			<td class="heading">
            <?php forms_hidden("shift", $shift['shift']); ?>
            <?php forms_hidden("redirect", "/mobile/show.php?id=$event_id"); ?>
            <?php forms_hidden("action", "shiftDelete"); ?>
			<input name="submit" type="submit" value="Delete" />
			</td>
			</form>
			<?php endif; ?>
			<?php } else { ?>
				
			<td class="heading" colspan="13">Signups
			</td>
			
			<?php } ?>
			
		</tr>
		<?php
			// If there's no one signed up, show a little message saying so
			if(count($list) == 0) { ?>
				<tr>
	            <td class="note" colspan="13">(no one is signed up)</td>
	 			</tr>
			
		<?php }
			// Show headers if event not in the past, or there are people signed up
			if (!$passed || (count($list) > 0)) { ?>
				<tr>
					<th>Name</th>
				    <th>Chair</th>
				    <th>Driving</th>
				    <th>Camera</th>
					<th>Needs Ride</th>
					<?php show_customheaders($event); ?>
		            <th colspan="3">Options</th>
				</tr>
		<?php } 
		$signedup = false;
		$personcount = 1;
		foreach($list as $signup): 
			$waitlisted = $signup['ordering'] > $shift['capacity'] && $shift['capacity'] > 0;
			$nextWaitlisted = $signup['ordering'] == $shift['capacity'] && $shift['capacity'] > 0;
            $dontDisable = ($signup['user'] == $user_id && ($needReplacement == false || $waitlisted)) && !$passed || $modifiable;
            $greyed = ($dontDisable)?'':'disabled';
            $chair_checked = ($signup['chair']=='1')?'checked ':' ';
            $driving_checked = ($signup['driving']=='1')?'checked ':' ';
            $camera_checked = ($signup['camera']=='1')?'checked ':' ';
			$ride_checked = ($signup['ride']=='1')?'checked ':' ';
			if ($signup['user'] == $user_id)
				$signedup = true;
?>
            <tr<?php if($waitlisted) echo ' class="waitlist"'; ?>>
                <td class="black"> 
					<?php 
						if($class=='admin' || $class=='user')
						$currentName = "$personcount) <a href=\"/people/profile.php?user={$signup['user']}\">"
									 . "{$signup['name']}</a>";
						else
							$currentName = "$personcount) {$signup['name']}";
							
						echo $currentName; 
						$personcount++;
					?>
				</td>
			<?php if($dontDisable): ?>
                <form action="/input<?php echo ($modifiable)?'Admin':'' ?>.php" method="POST" onsubmit="return valid(this)">
            <?php endif; ?>
                <td><input name="chair" type="checkbox" value="1" <?= $chair_checked ?><?= $greyed ?> /></td>
                <td><input name="driving" type="checkbox" value="1" <?= $driving_checked ?><?= $greyed ?> /></td>
                <td><input name="camera" type="checkbox" value="1" <?= $camera_checked ?><?= $greyed ?> /></td>
				<td><input name="ride" type="checkbox" value="1" <?= $ride_checked ?><?= $greyed ?> /></td>
			<?php if($dontDisable)
				show_customfields($event,$shift,$signup);
			else
				show_custominfo($event,$shift,$signup);
				if($dontDisable): ?>
                    <td>
                        <?php 
                            forms_hidden("action", "signupdate");
                            forms_hidden("shift", $shift['shift']);
                            forms_hidden("user", $signup['user']);
                            forms_hidden("redirect", "/mobile/show.php?id=$event_id");
                        ?>
							<input type="submit" name="updateme" value="Update" />
					</td>
						</form>
                    <form action="/input<?php echo ($modifiable)?'Admin':'' ?>.php" method="POST" onSubmit="return confirmDialog();" >
						<td>
	                        <?php forms_hidden("action", "unsignup"); ?>
	                        <?php forms_hidden("shift", $shift['shift']); ?>
	                        <?php forms_hidden("redirect", "/mobile/show.php?id=$event_id"); ?>
	                        <?php forms_hidden("user", $signup['user']); ?>
	                        <input type="submit" name="removeme" value="Remove" />
						</td>
                    </form>
                    <?php if (NOW < strtotime("-$remove_days days",shift_getStamp($shift))): ?>
                    <td><form action="/input<?php echo ($modifiable)?'Admin':'' ?>.php" method="POST" onSubmit="return confirmReplace();" >
                        <?php forms_hidden("action", "request_replacement"); ?>
                        <?php forms_hidden("shift", $shift['shift']); ?>
                        <?php forms_hidden("redirect", "/mobile/show.php?id=$event_id"); ?>
                        <?php forms_hidden("user", $signup['user']); ?>
                        <input type="submit" name="request_replaceme" value="<?php echo ($signup['wants_replacement']=='0')?'Request Replacement':'Un-Request Replacement' ?>" />
                    </form></td>
                    <?php endif; ?>
						<?php if($modifiable): ?>
                    <td><form action="/inputAdmin.php" method="POST">
                        <?php 
                        forms_hidden("action", "signupdateorder");
                        forms_hidden("shift", $shift['shift']);
                        forms_hidden("redirect", "/mobile/show.php?id=$event_id");
                        forms_hidden("user", $signup['user']); 
                        ?>
								<input type="text" size="3" name="order" value="<?php echo $signup['ordering'] ?>">
								<input type="submit" name="updateorder" value="Move" />
                    </form>
						<?php 
                        if($signup['wants_replacement'])
                        {
							$month = substr($signup['requested_since'], 5,2);
							$day = substr($signup['requested_since'], 8,2);
							echo "wants replacement as of $month/$day";
						} ?>
                        </td>
                    <?php endif; ?>
                <?php 
                //this button gives you the ability to replace someone.  Only valid if you are not an admin, the
                //event has not happened yet, and you're either waitlisted or not already signed up for that shift
                elseif (isset($user_id) && $signup['user'] != $user_id && !$passed && 
				    $signup['wants_replacement']=='1' && 
                    (!signup_exists($shift['shift'], $user_id) || signup_isWaitlisted($shift['shift'], $user_id)) ): 
                    ?>
                    <td colspan="2">
						<!--
						<form action="/input.php" method="POST" onSubmit="return confirmDialog();" >
	                        <?php forms_hidden("action", "replace"); ?>
	                        <?php forms_hidden("shift", $shift['shift']); ?>
	                        <?php forms_hidden("redirect", "/mobile/show.php?id=$event_id"); ?>
	                        <?php forms_hidden("user", $signup['user']); ?>
	                        <input type="submit" name="replacethem" value="Replace" />						
						</form>
						-->
						<?php
						$month = substr($signup['requested_since'], 5,2);
						$day = substr($signup['requested_since'], 8,2);
						echo "wants replacement as of $month/$day";
						?>
					</td>
                <?php //Creates the button to request a replacement even if there isn't much time to the event
                elseif ( $signup['user'] == $user_id && !$passed && !$waitlisted): ?>
                    <td><form action="/input<?php echo ($class=="admin")?'Admin':'' ?>.php" method="POST" <?php 
						echo ($signup['wants_replacement']=='0') ? 'onSubmit="return confirmReplace();" >' : '>';
                        forms_hidden("action", "request_replacement");
                        forms_hidden("shift", $shift['shift']);
                        forms_hidden("redirect", "/mobile/show.php?id=$event_id");
                        forms_hidden("user", $signup['user']); 
                        ?>
                        <input type="submit" name="request_replaceme" value="<?php echo ($signup['wants_replacement']=='0')?'Request Replacement':'Un-Request Replacement'  ?>" />
                    </form></td>
					<?php else: ?>
                    <td colspan="3"></td>
					<?php endif; ?>
			</tr>
		<?php endforeach;
		
		// Only show following stuff if logged in as normal user
		if ($_SESSION['class'] == 'user') {
			
			// Determine if user should be told that it's too late to sign up
			$tooLateToSignup = false;
			if($event['type'] == 'Service' || $event['type'] == 'Interviews')
			{        			
	            if(NOW > strtotime("-$remove_days days",shift_getStamp($shift['shift'])))
					$tooLateToSignup = true;
			}

			// Show signup row if not already signed up and not too late
			if (!$signedup && !$passed && !$tooLateToSignup) {
?>		
			<form action="/input.php" method="POST" onsubmit="return valid(this)">
			<?php forms_hiddenInput("signup","/mobile/show.php?id=$event_id"); ?>
				<?php if($needReplacement): ?>
	                <tr><td class="note" colspan="13">(it is less than <?=$signup_days?> days to the event, so you will need to find a replacement if you can't go)</td></tr>
				<?php endif; ?>
					<tr <?php if($nextWaitlisted || $waitlisted) echo ' class="waitlist"'; ?>>
						<input name="shift[]" type="hidden" value="<?php echo $shift['shift']?>" checked />
						<td><?php echo "$personcount) You?";?></td>
						<td><input name="chair" type="checkbox" value="1" /></td>
						<td><input name="driving" type="checkbox" value="1" /></td>
						<td><input name="camera" type="checkbox" value="1" /></td>
						<td><input name="ride" type="checkbox" value="1" /></td>
						<?php show_customfields($event, $shift); ?>
						<td><input type="submit" name="signmeup" value="Sign up" /></td>
					</tr>
			</form>
<?php
			}
			if ($tooLateToSignup && !$passed) {
				echo '<tr><td class="note" colspan="13">(it is too late to sign up online, contact SVP\'s to sign up or replace someone)</td></tr>';
			}
		}
?>
		</table><br />
	<?php endforeach;
}

// Determines if custom inputs are required for the passed event, and displays input fields for the passed shift.
function show_customfields($event, $shift, $signup='') {
	$count=show_customfieldcount($event);
	switch ($count) {
		case 0:
			return;
		case 1:
			$textsize = 60;
			break;
		case 2:
			$textsize = 30;
			break;
		case 3:
			$textsize = 20;
			break;
		case 4:
			$textsize = 15;
			break;
		case 5:
			$textsize = 12;
			break;
	}
	if (!empty($signup)) {
		$custom1_text = $signup['custom1'];
		$custom2_text = $signup['custom2'];
		$custom3_text = $signup['custom3'];
		$custom4_text = $signup['custom4'];
		$custom5_text = $signup['custom5'];
	}
	if ($event['custom1'] != '') {
		echo '<td>';
			forms_text_required($textsize, 'custom1',$custom1_text,64);
		echo '</td>';
	}
	if ($event['custom2'] != '') {
		echo '<td>';
			forms_text_required($textsize, 'custom2',$custom2_text,64);
		echo '</td>';
	}
	if ($event['custom3'] != '') {
		echo '<td>';
			forms_text_required($textsize, 'custom3',$custom3_text,64);
		echo '</td>';
	}
	if ($event['custom4'] != '') {
		echo '<td>';
			forms_text_required($textsize, 'custom4',$custom4_text,64);
		echo '</td>';
	}
	if ($event['custom5'] != '') {
		echo '<td>';
			forms_text_required($textsize, 'custom5',$custom5_text,64);
		echo '</td>';
	}
}

// Displays custom info without putting them into fields..
function show_custominfo($event, $shift, $signup='') {
	$count=show_customfieldcount($event);
	if ($count==0)
		return;
	if (!empty($signup)) {
		$custom1_text = $signup['custom1'];
		$custom2_text = $signup['custom2'];
		$custom3_text = $signup['custom3'];
		$custom4_text = $signup['custom4'];
		$custom5_text = $signup['custom5'];
	}
	if ($event['custom1'] != '') {
		echo "<td>$custom1_text</td>";
	}
	if ($event['custom2'] != '') {
		echo "<td>$custom2_text</td>";
	}
	if ($event['custom3'] != '') {
		echo "<td>$custom3_text</td>";
	}
	if ($event['custom4'] != '') {
		echo "<td>$custom4_text</td>";
	}
	if ($event['custom5'] != '') {
		echo "<td>$custom5_text</td>";
	}
}

// Determines if custom inputs are required for the passed event, and displays corresponding headers.
function show_customheaders($event) {
	if ($event['custom1'] != '') {
		echo '<th>'.$event['custom1'].'</th>';
	}
	if ($event['custom2'] != '') {
		echo '<th>'.$event['custom2'].'</th>';
	}
	if ($event['custom3'] != '') {
		echo '<th>'.$event['custom3'].'</th>';
	}
	if ($event['custom4'] != '') {
		echo '<th>'.$event['custom4'].'</th>';
	}
	if ($event['custom5'] != '') {
		echo '<th>'.$event['custom5'].'</th>';
	}
}

function show_customfieldcount($event) {
	$count=0;
	for ($i=1;$i<6;$i++) {
		if (!empty($event['custom'.$i])) {
			$count++;
		}
	}
	return $count;
}

function show_signup($event, $class, $user_id)
{
	if($class=='user'):	
		return;
	elseif($class=='admin'): 
		include_once dirname(dirname(__FILE__)) . '/include/signup.inc.php';
	    if ($event['type']=='Service')
		{
			$signup_days = SIGNUP_DAYS;
			$remove_days = REMOVE_DAYS;
		}
		elseif ($event['type']=='Interviews')
		{
			$signup_days = INTERVIEWS_SIGNUP_DAYS;
			$remove_days = INTERVIEWS_REMOVE_DAYS;
		}
		
		$event_id = $event['id'];
		
		$shiftlist = shift_getAll($event_id);
		
		if(count($shiftlist)==0)
			return;
	
		include_once dirname(dirname(__FILE__)) . '/include/user.inc.php'; 
		include_once dirname(dirname(__FILE__)) . '/include/show.inc.php';
		$userlist = user_getAll(); ?>
		<form action="/inputAdmin.php" method="POST">
		<table cellspacing="0"><tr><td class="nested">
		<table style="width: 100%;" cellspacing="1">
		<?php forms_hiddenInput('signup',"/mobile/show.php?id=$event_id"); ?>
			<tr>
				<td class="heading" colspan="5">Sign Members Up</td>
			</tr>
			<tr>
				<?php if (event_multipleShifts($event)) { ?> 
				<th>Shifts</th>
				<?php } ?> 				
			    <th>Chair</th>
			    <th>Driving</th>
			    <th>Camera</th>
				<th>Needs Ride</th>
			</tr>
			<tr>
				<?php if (event_multipleShifts($event)) { ?> 
				<td>
				<?php foreach($shiftlist as $shift): ?>
					<input name="shift[]" type="checkbox" value="<?php echo $shift['shift']?>" />
					<?php echo date('g:i a',strtotime($shift['start'])),
                               ' - ',
                               date('g:i a',strtotime($shift['end']));
                        if($shift['name'] != '')
                            echo " ({$shift['name']})";
                    ?>
					<br />
				<?php endforeach; ?>
				</td>
				<?php } else {
				foreach($shiftlist as $shift): ?>
					<input name="shift[]" type="hidden" value="<?php echo $shift['shift']?>" checked />
				<?php
                endforeach;
				} ?>
				<td><input name="chair" type="checkbox" value="1" /></td>
				<td><input name="driving" type="checkbox" value="1" /></td>
				<td><input name="camera" type="checkbox" value="1" /></td>
				<td><input name="ride" type="checkbox" value="1" /></td>
			</tr>
		</table>
		</td></tr>
		<tr><td class="nested">
		<?php show_users($userlist); ?>
		</td></tr>
		<tr><td class="nested"><input type="submit" name="signmeup" value="Sign up" /></td></tr>
		</table>
		</form>
	<?php endif;
}

// Shows people's comments on this event!
function show_comments($event_id,$user_id,$class) {
?>
	<div class="general" style="display:table;">
		<div class="boxtop">
			Comments
		</div>
		<div class="boxbody" style="padding:4px;">
		<?php
			$query = "SELECT e.eventcomment_id,e.event_id,e.user_id,e.comment,u.user_name FROM eventcomment e, user u WHERE event_id = $event_id AND e.user_id = u.user_id ORDER BY e.eventcomment_id ASC";
			$result = db_select($query);
			if (count($result) == 0) {
				echo "There are no comments for this event yet.";
			} else {
				// Show each comment line by line
				foreach ($result as $comment) {
					echo '<a href=/people/profile.php?user='.$comment['user_id'].'>'.$comment['user_name'].'</a>: '.$comment['comment'];
						// If comment belongs to current user, or current user is ExComm, allow them to delete comment
						if ($comment['user_id'] == $user_id || $class == 'admin') {
							echo " <a href='/input.php?action=deletecomment&redirect=/mobile/show.php?id=$event_id&eventcomment_id={$comment['eventcomment_id']}'>";
							echo '(delete)</a>';
						}
					echo '<br />';
				}
			}
			// If logged in, show form to post comment
			echo '<form action="/input.php" method="POST">';
				forms_text(23,'comment','',100);
				forms_submit('Comment');
				forms_hidden('redirect',"/mobile/show.php?id=$event_id");
				forms_hidden('action','addcomment');
				forms_hidden('user_id',$user_id);
				forms_hidden('event_id',$event_id);
			echo '</form>';
		?>
		</div>
	</div>
<?php
}
?>
