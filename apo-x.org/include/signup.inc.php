<?php

ob_start();

include_once 'constants.inc.php';

//Waitlist weighting points
$GLOBALS['wl_C'] = 0;           //if you're missing the C
$GLOBALS['wl_pledge'] = 0;      //if you're a pledge
$GLOBALS['wl_alumni'] = 0;   //points for being an alumni
$GLOBALS['wl_inactive'] = 0; //points for being inactive
$GLOBALS['wl_hour_limit'] = 0; //you get points for every hour you are under this
$GLOBALS['wl_hourly'] = 0;      //points per hour under hour_limit
$GLOBALS['wl_max'] = $GLOBALS['wl_C'] + $GLOBALS['wl_pledge'] + $GLOBALS['wl_hour_limit'] * $GLOBALS['wl_hourly'];

function signup_getSList($shift)
{
    signup_updateWaitlist($shift);
    
    $sql = 'SELECT u.user_id as user, u.user_name as name, '
            . ' x.signup_chair as chair, x.signup_driving as driving, '
            . ' x.signup_camera as camera, '
			. ' x.signup_ride as ride, '
            . ' x.signup_order as ordering, '
			. ' x.signup_custom1 as custom1, '
			. ' x.signup_custom2 as custom2, '
			. ' x.signup_custom3 as custom3, '
			. ' x.signup_custom4 as custom4, '
			. ' x.signup_custom5 as custom5, '
            . ' x.wants_replacement as wants_replacement, '
            . ' x.replacing as replacing, '
			. ' x.requested_since as requested_since '
            . ' FROM user u, signup x '
            . " WHERE u.user_id = x.user_id AND x.shift_id = $shift"
            . ' order by signup_order asc, chair desc, user_name asc';
            
    $list = db_select($sql, "signup_getSList");
	
    return $list;
}

function signup_updateWaitlist($shift)
{
    $start = time();
    $sql = 'SELECT u.user_id as user, u.user_name as name, '
            . ' x.signup_chair as chair, x.signup_driving as driving, '
            . ' x.signup_camera as camera, '
            . ' x.signup_order as ordering, '
			. ' x.signup_ride as ride, '
            . ' x.wants_replacement as wants_replacement, '
            . ' x.replacing as replacing '
            . ' FROM user u, signup x, shift s '
            . " WHERE u.user_id = x.user_id AND x.shift_id = $shift "
            . " AND x.signup_order > s.shift_capacity AND s.shift_id = $shift "
            . ' ORDER BY signup_order asc, chair desc, user_name asc';

    $result = mysql_query($sql);
    $initial_waitlisted = array();

    while($line = mysql_fetch_assoc($result))	//make the user id the array key
        $initial_waitlisted[$line['user']] = $line;
    
    mysql_free_result($result);


    $waitlisted = $initial_waitlisted;
    
    $sql = "SELECT shift_capacity, fourc_c FROM shift, fourc, event "
            . " WHERE shift_id = $shift"
            . " AND shift.event_id = fourc.event_id LIMIT 1";
            
    $capacity = db_select1($sql);
    $fourc = $capacity['fourc_c'];
    $capacity = $capacity['shift_capacity'];
    
    //quit if there's no waitlist
    if ( (count($waitlisted) == 0) || $capacity == 0)
        return;
    
    //create a field for waitlist rules points, starting at the max
    foreach ($waitlisted as $i => $value)
        $waitlisted[$i]['points'] = $GLOBALS['wl_max'];	
    
    $service = EVENTTYPE_SERVICE;

    $users = "(";
    foreach ($waitlisted as $signup):
        $users = $users . $signup['user'] . ", ";
    endforeach;
    
    $users = substr($users, 0, strlen($users) - 2) . ")";
    
    //This gets an array of signups who DON'T need the C
    
    $sql = 'SELECT DISTINCT user_id FROM tracking, event, fourc '
        . " WHERE tracking.event_id = event.event_id "
        . " AND fourc.event_id = event.event_id AND event.eventtype_id = '$service' "
		. " AND tracking.hours >= 0 " //you don't get the C if you got negative hours
        . " AND fourc_c = '$fourc' AND event.event_date > " . db_currentClass('start') . " AND user_id IN $users";

    $have_c = db_select($sql);


        $sql = 'SELECT user.user_id, SUM(hours) AS hours, status_id ' 
        . ' FROM user, tracking, event '
        . ' WHERE tracking.event_id = event.event_id  '
        . " AND event.eventtype_id = '$service' "
        . " AND event.event_date > " . db_currentClass('start')
        . " AND user.user_id = tracking.user_id AND user.user_id IN $users"
        . ' GROUP BY user.user_id';

    $tracking_data = db_select($sql);
        
    //subtract 5 points for those who already have the C
    foreach ($have_c as $the_user)
        $waitlisted[$the_user['user_id']]['points'] = $GLOBALS['wl_max'] - $GLOBALS['wl_C'];

    //add a point for each hour under 18 they have
    foreach ($tracking_data as $the_user):
        $waitlisted[$the_user['user_id']]['points'] -= $the_user['hours'] * $GLOBALS['wl_hourly'];	//will get negative points which is ok
        
        if ($the_user['status_id'] != STATUS_PLEDGE)	//subtract 3 points if they're not a pledge
            $waitlisted[$the_user['user_id']]['points'] -= $GLOBALS['wl_pledge'];
		if ($the_user['status_id'] == STATUS_ALUMNI)	//add -100 points if they're alumni
            $waitlisted[$the_user['user_id']]['points'] += $GLOBALS['wl_alumni'];
		if ($the_user['status_id'] == STATUS_INACTIVE)	//add -100 points if they're inactive
            $waitlisted[$the_user['user_id']]['points'] += $GLOBALS['wl_inactive'] = -100;
    endforeach;

    
    //sort the waitlist in descending order with respect to points
    //binary insertion sort

    $lo = 0;
    $up = count($waitlisted) - 1;
    $reorder = 0;
    
    

    $waitlisted = array_values($waitlisted);
    
    for ( $i=$lo + 1; $i<=$up; $i++ ) 
    {
        $temparr = $waitlisted[$i];
        
        for ( $l=$lo - 1, $h=$i; $h - $l > 1; ) 
        {
            $j = (int) (($h + $l)/2);
            if ( $temparr['points'] > $waitlisted[$j]['points'] ) $h = $j; else $l = $j;
        }
        for ( $j=$i; $j>$h; $j-- ) 
            $waitlisted[$j] = $waitlisted[$j - 1];
        
        if ($waitlisted[$h] != $temparr)
        {
            $waitlisted[$h] = $temparr;
            $reorder = 1;	//if you have to swap, update the database when done
        }
    }
    
    if ($reorder):
        for ($i = 0; $i < count($waitlisted); $i++):
            $user = $waitlisted[$i]['user'];
            
            if ($initial_waitlisted[$i]['user'] != $user):
                $sql = "UPDATE signup SET signup_order = ('$capacity' + '$i' + 1) "
                . " WHERE shift_id = '$shift' and user_id = '$user' LIMIT 1 ";
                mysql_query($sql) or die("Query failed (update waitlist) =(");
                $waitlisted[$i]['ordering'] = $capacity + 1 + $i;	//this line only needed if function returns list
            endif;
            
            
        endfor;
    endif;
}

function signup_getList($event)
{
    $sql = 'SELECT u.user_id as id, user_name as name,'
            . ' signup_chair as chair, signup_driving as driving,signup_ride as ride, shift_start as start, shift_end as end'
            . ' FROM user u, shift s, signup x'
            . " WHERE u.user_id = x.user_id AND s.shift_id = x.shift_id and s.event_id = $event"
            . ' order by start asc, chair desc, driving desc';
            
    return db_select($sql, "signup_getList");
}


function signup_getSummary($event)
{
/*
	original SQL from before 7/18/2011
	this SQL statement ignores counting people who want to be replaced, and also ignores counting replacements
    $sql = 'SELECT shift_start as start, shift_end as end, shift_name as name,'
            . ' shift_capacity AS cap, count(signup.shift_id) as current '
            . ' FROM shift LEFT JOIN signup '
                . ' ON shift.shift_id = signup.shift_id '
            . " WHERE event_id = '$event' "
            . ' GROUP BY shift.shift_id '
            . ' order by start asc ';
*/
	// revised by Robin Chang (7/18/2011)
	$sql = 'SELECT shift_start as start, shift_end as end, shift_name as name,'
.' shift_capacity AS cap, CASE WHEN SUM( signup.wants_replacement ) > 0'
.' THEN COUNT( signup.user_id ) - SUM( signup.wants_replacement ) + SUM( signup.replacing )'
.' ELSE COUNT( signup.user_id )'
.' END AS current'
.' FROM shift LEFT JOIN signup'
.' ON shift.shift_id = signup.shift_id'
.' WHERE event_id = '.$event
.' GROUP BY shift.shift_id '
.' ORDER BY start ASC';
            
    return db_select($sql, "signup_getList");
}

function shift_getAll($event_id)
{

    $sql = 'SELECT shift_id AS shift, event_id AS event, shift_start AS '
        . ' start, shift_end AS end, shift_capacity AS capacity, '
        . ' shift_name AS name '
        . ' FROM shift '
        . " WHERE event_id = '$event_id' "
        . ' order by shift_start asc';
        
    return db_select($sql);
}

function shift_get($shift_id)
{
    $sql = 'SELECT shift_id AS shift, event_id AS event, shift_start AS'
        . ' start, shift_end AS end, shift_capacity AS capacity, '
        . ' shift_name AS name'
        . ' FROM shift'
        . " WHERE shift_id = '$shift_id'";
        
    return db_select1($sql, "shift_get");
}

function signup_full($shift_id)
{
    $sql = 'SELECT count(*) as cnt, s.shift_capacity as cap '
        . ' FROM signup x, shift s '
        . " WHERE s.shift_id = x.shift_id and s.shift_id = '$shift_id' "
        . " group by shift_capacity";
        
    $line = db_select1($sql);
    
    if(isset($line['cnt']) && $line['cap']!=0)
        return $line['cnt']>=$line['cap'];
    else
        return false;
}

function shift_getStamp($shift_id)
{
    $sql = 'SELECT shift_start AS time, UNIX_TIMESTAMP(event_date) as date '
        . ' FROM shift s, event e '
        . " WHERE shift_id = '$shift_id' and e.event_id = s.event_id ";
        
    $line = db_select1($sql, "shift_getStamp");

    // process line to make it a timestamp starting from shift start time
    return strtotime(date("m/d/Y",$line['date']).' '.$line['time']);
}

function shift_add($event, $start, $end, $capacity, $name)
{
    $query = "INSERT INTO shift(event_id, shift_start, "
        . " shift_end, shift_capacity, shift_name) "
        . " VALUES ('$event', '$start', '$end', '$capacity', '$name')";
    print($query);
    mysql_query($query) or die("Query failed =(");
} 

function shift_update($shift, $event, $start, $end, $capacity, $name)
{
    $query = "UPDATE shift SET shift_id = $shift, "
        . " event_id = $event, "
        . " shift_start = '$start', "
        . " shift_end = '$end', "
        . " shift_capacity = $capacity, "
        . " shift_name = '$name' "
        . " WHERE shift_id = '$shift'"
        . " LIMIT 1 ";
    mysql_query($query) or die("Query failed =(");
} 

function shift_delete($shift)
{
    // delete the signups associated with each shift (bad, cascading)
    $query = "DELETE from signup WHERE shift_id = '$shift' ";
    mysql_query($query) or die("shift_delete failed =(");

    $query = "DELETE from shift WHERE shift_id = $shift LIMIT 1";
    mysql_query($query) or die("shift_delete(2) failed =(");
} 

function signup_getCount($shift)
{
    $getcount = "SELECT signup_order FROM signup WHERE shift_id = $shift";
    $result = mysql_query($getcount) or die("Query Failed (signup_getCount)!");
    $order = mysql_num_rows($result);
    mysql_free_result($result);
    return $order;
}

function signup_getOrder($shift, $user)
{
    $getcount = "SELECT signup_order FROM signup WHERE shift_id = '$shift' and user_id = '$user' ";
    $result = mysql_query($getcount) or die("Query Failed (signup_getOrder)!");
    $line = mysql_fetch_assoc($result);
    $order = $line['signup_order'];
    mysql_free_result($result);
    return $order;
}

function signup_getPositionExists($shift, $position)
{
    $query = "SELECT signup_order FROM signup WHERE shift_id = '$shift' and signup_order = '$position' ";
    $result = mysql_query($query) or die("Query Failed (signup_getPositionExists)!");
    $exists = (mysql_num_rows($result) > 0);
    mysql_free_result($result);
    return $exists;
}
function signup_adjust($order, $adjustment, $shift)
{
    $query = "UPDATE signup SET signup_order = signup_order + '$adjustment' "
        . " WHERE signup_order > '$order' and signup_order > '0' "
        . " and shift_id = '$shift' ";
    mysql_query($query) or die("Query failed (signup_adjust) =(");
}

function signup_add($shift, $user, $chair, $driving, $camera, $ride, $custom1='', $custom2='', $custom3='', $custom4='', $custom5='')
{
    // don't insert if already in; $shift is an array; $user might be an array
    $remove_days = REMOVE_DAYS;
   
    if(!is_array($user)):
    
        foreach($shift as $oneshift):
            
            $query = 'SELECT user_id FROM signup '
            . " WHERE shift_id = '$oneshift' AND wants_replacement > '0' "
            . ' ORDER BY signup_order ASC LIMIT 1';
        
            $replace_us = db_select1($query);    //these people want to be replaced
    
            if(!signup_exists($oneshift,$user)):
                if (isset($replace_us['user_id']) && NOW < strtotime("-$remove_days days",shift_getStamp($oneshift))):
                //if anybody wants to be replaced and it's not too close to the event
                    signup_replace($oneshift, $replace_us['user_id'], $user);
                else:
                    $order = signup_getCount($oneshift) + 1;
            
                    $query = "INSERT INTO signup(shift_id, user_id, "
                           . " signup_chair, signup_driving, signup_camera, signup_ride, signup_order, signup_custom1, signup_custom2, signup_custom3, signup_custom4, signup_custom5) "
                           . " VALUES ('$oneshift', '$user', '$chair', '$driving', '$camera','$ride', '$order', '$custom1', '$custom2', '$custom3', '$custom4', '$custom5')";
                    mysql_query($query) or die("Query failed =(");
                endif;
            endif;
        endforeach;
    else:
        foreach($shift as $oneshift):
            $query = 'SELECT user_id FROM signup '
            . " WHERE shift_id = '$oneshift' AND wants_replacement = 1 "
            . ' ORDER BY signup_order ASC ';
            $replace_us = db_select($query);    //these people want to be replaced
            $i = 0;                             //$i is which user we're going to replace now
            
            $order = signup_getCount($oneshift) + 1;
            
            foreach($user as $u):
                if(!signup_exists($oneshift,$u)):
                    if (isset($replace_us[$i]) && NOW < strtotime("-$remove_days days",shift_getStamp($oneshift))):
                        signup_replace($oneshift, $replace_us[$i]['user_id'], $u);
                        $i++;
                    else:
                        $query = "INSERT INTO signup(shift_id, user_id, "
                            . " signup_chair, signup_driving, signup_camera, signup_ride, signup_order, signup_custom1, signup_custom2, signup_custom3, signup_custom4, signup_custom5) "
                            . " VALUES ('$oneshift', '$u', '$chair', '$driving', '$camera', '$ride','$order', '$custom1', '$custom2', '$custom3', '$custom4', '$custom5')";
                        mysql_query($query) or die("Query failed =(");
                        $order++;
                    endif;
                endif;
            endforeach;
        endforeach;
    endif;
} 

function signup_updateOrder($shift, $user, $order)
{
    $last = signup_getCount($shift);
    $old = signup_getOrder($shift, $user);
    
    if ($order<1)
    {
    	$order=1;
    }
    
    if ($order>$last)
    {
    	$order=$last;
    }

    if (!signup_getPositionExists($shift, $order))
    {
	// since destination doesn't have anyone there, set this user's position to $order without doing anything else
        $query = "UPDATE signup SET signup_order = '$order' "
        . " WHERE shift_id = '$shift' and user_id = '$user' LIMIT 1 ";
        mysql_query($query) or die("Query failed (signup_updateOrder) =(");
    }
    else if ($old < $order)
    {
        // add 1 to everyone's position with position number > $order, making a gap for this user at $order+1
        signup_adjust($order,1,$shift);
        
        // set this user's position to $order+1
        $order = $order+1;
        $query = "UPDATE signup SET signup_order = '$order' "
        . " WHERE shift_id = '$shift' and user_id = '$user' LIMIT 1 ";
        mysql_query($query) or die("Query failed (signup_updateOrder) =(");

        // subtract 1 from everyone's position if they were greater than user's old position (includes user at new position)
        signup_adjust($old,-1,$shift);
    }
    else if($old > $order)
    {
        // add 1 to everyone's position with position number > $order-1, making a gap for this user
        signup_adjust($order-1,1,$shift);
        
        // set this user's position to $order
        $query = "UPDATE signup SET signup_order = '$order' "
        . " WHERE shift_id = '$shift' and user_id = '$user' LIMIT 1 ";
        mysql_query($query) or die("Query failed (signup_updateOrder) =(");

        // subtract 1 from everyone's position if they were greater than user's old position+1 (since we shifted user's old position up too)
        signup_adjust($old+1,-1,$shift);
    }
}

//This --toggles-- wants_replacement
function signup_request_replacement($shift, $user_id)
{
    $signup_days = SIGNUP_DAYS;
    $remove_days = REMOVE_DAYS;
    
    //if somebody's waitlisted, just replace them with the first person waitlisted
    if( !(NOW < strtotime("-$signup_days days",shift_getStamp($shift))) &&
        NOW < strtotime("-$remove_days days",shift_getStamp($shift)) &&
        !signup_isWaitlisted($shift, $user_id)):

        $query = 'SELECT user_id FROM signup NATURAL JOIN shift '
                . " WHERE shift.shift_id = '$shift' "
                . ' AND signup_order = (shift_capacity + 1) LIMIT 1';
        $first_waitlisted = db_select1($query);
        $first_waitlisted = $first_waitlisted['user_id'];
        
        if ($first_waitlisted):
            signup_replace($shift, $user_id, $first_waitlisted);
            return;
        endif;
    
    endif;
	$date = date('Y-m-d',NOW);
        $query = 'UPDATE signup SET wants_replacement = NOT(wants_replacement), '
				. " requested_since = '$date' "
                . " WHERE shift_id = '$shift' AND user_id = '$user_id' LIMIT 1";
        mysql_query($query) or die("Query failed (signup_request_replacement) =(");

}

function signup_replace($shift,$replaced_user,$replacing_user)
{
    $order = signup_getOrder($shift,$replaced_user);
    if (signup_exists($shift, $replacing_user) && !signup_isWaitlisted($shift, $replacing_user))
            return;
    
    if (!signup_exists($shift, $replacing_user))
    {
        $endOfList = signup_getCount($shift) + 1;
        
        $query = 'INSERT INTO signup(shift_id, user_id, signup_order) '
                . " VALUES ('$shift', '$replacing_user', '$endOfList')";
                mysql_query($query) or die("Replace failed =(");
    }
        
    signup_updateOrder($shift, $replacing_user, $order);
    signup_delete($shift, $replaced_user);
    
    $query = "UPDATE signup SET replacing = '$replaced_user' "
            . " WHERE shift_id = '$shift' and user_id = '$replacing_user' LIMIT 1 ";
    mysql_query($query) or die("Query to set variable \'replacing\' failed =(");

    signup_mailAffected($shift, $replaced_user, $replacing_user);
}

// inform affected people of the replacement
function signup_mailAffected($shift, $before_user, $after_user)
{
    // get the names and emails
    $sql = "SELECT user_id, user_email, user_name FROM user WHERE user_id IN ('$before_user', '$after_user') ";
    $people = db_select($sql);

    foreach($people as $person)
    {
        if($person['user_id'] == $before_user)
        {
            $before_name = $person['user_name'];
            $before_email = $person['user_email'];
        }
        else
        {
            $after_name = $person['user_name'];
            $after_email = $person['user_email'];
        }
    }

    // get the event info
    $sql = " SELECT event_name, UNIX_TIMESTAMP(event_date) AS event_date, shift_start "
         . " FROM event NATURAL JOIN shift WHERE shift_id = '$shift'";
    $event = db_select1($sql);
    
    $date = date("m/d/Y", $event['event_date']);
    $time = date("h:ia", strtotime($event['shift_start']));
    $name = $event['event_name'];

    $message = "A signup replacement took place on the Chi website and you were affected!\n\n"
             . "Project: $name\n"
             . "Date and Time: $date at $time\n\n"
             . "$before_name has been replaced with $after_name.\n\n"
             . "If this is a mistake, please email admin@apo-x.org.\n\n"
             . "Thank you!\nThe Website";

	mail("$after_name <$after_email>, $before_name <$before_email>", 
         "Service Project Replacement: $name",
         $message,
         "From: Chi Admin VP <admin@apo-x.org>");
    
    // send email to SVP's notifying them of replacement
    $message = "A signup replacement took place on the Chi website!\n\n"
             . "Project: $name\n"
             . "Date and Time: $date at $time\n\n"
             . "$before_name has been replaced with $after_name.\n\n"
             . "Keep up the good work, Service VP's! =)\nChi website";
    mail("<service@apo-x.org>", 
    "Service Project Replacement: $name",
    $message,
    "From: Chi website <admin@apo-x.org>");

}

function signup_isWaitlisted($shift, $user)
{
    $sql = 'SELECT * FROM signup, shift '
        . " WHERE shift.shift_id = '$shift' AND user_id = '$user' AND signup.shift_id = '$shift' "
        . " AND signup_order > shift_capacity LIMIT 1";
        
    $result = mysql_query($sql) or die("Query Failed (signup_isWaitlisted)!");
    $number = mysql_num_rows($result);
    mysql_free_result($result);
    
    return $number;
}

function signup_update($shift, $user, $chair, $driving, $camera, $ride, $custom1, $custom2, $custom3, $custom4, $custom5)
{
    $query = "UPDATE signup SET signup_chair = '$chair', "
        . " signup_driving = '$driving', signup_camera = '$camera', signup_ride = '$ride', "
		. " signup_custom1 = '$custom1', signup_custom2 = '$custom2', signup_custom3 = '$custom3', signup_custom4 = '$custom4', signup_custom5 = '$custom5'"
        . " WHERE shift_id = '$shift' and user_id = '$user' LIMIT 1 ";
    mysql_query($query) or die("Query failed =(");
} 

function signup_delete($shift, $user)
{
    $order = signup_getOrder($shift,$user);
    
    $query = "DELETE from signup "
        . " WHERE shift_id = $shift and user_id = $user "
        . " LIMIT 1";
    mysql_query($query) or die("Query failed =(");
    
    signup_adjust($order, -1, $shift);
} 

function signup_exists($shift, $user)
{
    $query = "SELECT user_id from signup "
        . " WHERE shift_id = '$shift' and user_id = '$user' ";
    $result = mysql_query($query) or die("Query Failed (signup_exists)!");
    $number = mysql_num_rows($result);

    mysql_free_result($result);
    return ($number>0);
} 

?>
