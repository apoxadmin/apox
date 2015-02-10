<?php 
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/show.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/event.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/signup.inc.php';

if(isset($_SESSION['id']))
	$user = $_SESSION['id'];
else
	show_note('You are not logged in.');

if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

if(isset($_GET['event']))
	$event = $_GET['event'];
else
	show_note('You have not selected an event!');

function userfull_get($e)
{
	$query = 'SELECT user_name, user_address, user_phone, user_cell, '
	. ' user_email, user_aim, signup_chair, '
    . ' GROUP_CONCAT(shift.shift_id ORDER BY '
    .   ' shift.shift_start ASC SEPARATOR \';\') AS shift_ids'
	. ' FROM user, (event NATURAL JOIN shift), signup '
	. ' WHERE (signup.user_id = user.user_id) '
    . ' AND (signup.shift_id = shift.shift_id) '
	. ' AND (signup_order <= shift_capacity OR shift_capacity = 0) '
	. " AND event.event_id = '$e' "
    . ' GROUP BY user.user_id '
    . " ORDER BY user_name asc ";

	return db_select($query, "userfull_get()");
}

$details = event_get($event);
$shifts = shift_getAll($event);

$i = 1;
foreach($shifts as $key => $shift)
{
    $shifts[$key]['i'] = $i++;
    $shifts[$key]['start'] = date('g:i a - ',strtotime($shift['start']))
                           . date('g:i a',strtotime($shift['end']));
    $shiftlist .= '<strong>' . $shifts[$key]['i'] . ')</strong> ' 
                . $shifts[$key]['start'] . '<br/>';
    $shiftlookup[$shift['shift']] = $shifts[$key]['i'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Chi Chapter - Chair Signin Sheet</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <meta http-equiv="Pragma" name="Cache-Control" content="no-cache"/>
    <meta http-equiv="Cache-Control" name="Cache-Control" content="no-cache"/>
    <style type="text/css">
        body { font-size: 0.7em; font-family: sans-serif; }
        .small { font-size: 0.8em; font-family: sans-serif; }
        #left { float: left; width: 45%; }
        #right { float: right; width: 45%; }
        #details { border: 2px solid black; padding: 2px; 
                   margin: 2px 0px; font-size: 1.2em; }
        #list {border: 1px solid black; border-spacing: 1px 1px; width: 100%;}
        #list td, #list th { border: 1px solid; }
        #list td.special { border: 1px dotted; text-align:center; }
    </style>
</head>
<body>

<div id="details">
<table id="left">
<tr>
<th>Event:</th><td><?= $details['name'] ?><td>
<?php 
    if(strlen($details[contact]) > 0)
        echo "<tr><th>Contact:</th><td>{$details['contact']}</td></tr>";
?>
<tr>
    <th>Shifts:</th><td><span class="small">
        <?= $shiftlist ?></span></td>
</tr>
<tr><th></th><td></td></tr>
<?php
?>
</table>
<table id="right">
<tr>
<th>Date:</th><td><?= date('l F jS, Y', $details['date']) ?><td>
<tr>
    <th>Location:</th><td><span class="small">
        <?= str_replace("\n", "<br/>", $details['location']) ?></span></td>
</tr>
<tr><th></th><td></td></tr>
<?php
?>
</table>
<div style="clear: both"></div>
</div>

<table id="list">
	<tr>
	<th style="width: 15%;">Name</th>
	<th style="width: 18%;">Address</th>
	<th style="width: 12%;">Phone</th>
	<th style="width: 20%;">Online Info</th>
    <th style="width: 4%;">Shift#</th>
    <th style="width: 4%;">Chair</th>
    <th style="width: 10%;" colspan="2">Drove<br>People/Miles</th>
	<th style="width: 10%;">Time In</th>
	<th style="width: 10%;">Time Out</th>
	</tr>
	<?php 
	foreach(userfull_get($event) as $user)
	{
		extract($user);
		$user_cell = show_phone($user_cell);
		$user_phone = show_phone($user_phone);
        if(0 != strcmp($user_phone, $user_cell))
            $user_cell .= "<br/>$user_phone";
        if($signup_chair > 0)
            $chair = '<img src="/images/check.gif" alt="X" />';
        else
            $chair = '';

        $shifts = array();
        foreach(explode(';', $shift_ids) as $sid)
        $shifts[] = $shiftlookup[$sid];
        $shifts = implode($shifts, ' ');
       
		echo '<tr>'; 

			echo "<td>$user_name</td>\n";
			echo "<td>$user_address</td>\n";
			echo "<td>$user_cell</td>\n";
			echo "<td>$user_email<br/>$user_aim</td>\n";
            echo '<td class="special">',$shifts,'&nbsp;</td>';
            echo '<td class="special">',$chair,'&nbsp;</td>';
            echo '<td class="special">&nbsp;</td>';
			echo '<td class="special">&nbsp;</td>';
            echo '<td class="special">&nbsp;</td>';
            echo '<td class="special">&nbsp;</td>';

		echo '</tr>';
	} 
	?>
</table>
</body>
</html>
