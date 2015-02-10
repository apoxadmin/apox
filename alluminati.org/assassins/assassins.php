<?php
include_once 'user.inc.php';

srand((double)microtime()*1000000); 

function add_obit($kill, $story)
{
	$query = 'UPDATE assassins_obits SET obit_story="'.$story.'" WHERE obit_id='.$kill;
	mysql_query($query) or die("Couldn't add obituary =( ". mysql_error());
}

function add_user($user, $codename)
{
	if(!is_playing($user))
	{
		$query = "INSERT INTO assassins(user_id, codename) VALUES ('$user','$codename')";
		mysql_query($query) or die("Couldn't add new assassin =( ". mysql_error());

		pick_killcode($user);
	}
}

function before_start()
{
	$start_time = mktime(0, 0, 0, 5, 6, 2010);

	if(time() >= $start_time)
		return FALSE;
	else
		return TRUE;
}

function ch_user($user, $kill)
{
	if($kill==1)
	{
		kill_user(0, $user, 3);
	}
}

function check_kill($code)
{
	$myInfo = get_player_info($_SESSION['id']);

	$myTarget = get_player_info($myInfo['current_target']);
		if($myTarget['killcode']==$code) {
			kill_user($myInfo['user_id'], $myTarget['user_id'], 0);
		}
		else check_selfdefense($code);
}

function check_selfdefense($code)
{
	$myInfo = get_player_info($_SESSION['id']);

	$sql = "SELECT * FROM assassins WHERE current_target=".$myInfo['user_id'];
	$result = mysql_query($sql) or die("Failed check_selfdefense() ". mysql_error());

	$killerTable = array();
	while($line = mysql_fetch_assoc($result))
		array_push($killerTable,$line);
	mysql_free_result($result);

	foreach($killerTable as $killer)
	{
		if($killer['killcode'] == $code)
		{
			kill_user($myInfo['user_id'], $killer['user_id'], 1);
			new_target($killer['user_id']);
		}		
	}
}

function check_win()
{
	$sql = "SELECT COUNT(user_id) FROM assassins WHERE alive=1 GROUP BY alive ORDER BY alive DESC LIMIT 1";
	$result = mysql_query($sql) or die ("check_win() failed! ".mysql_error());

	$aliveTable = mysql_fetch_assoc($result);

	if($aliveTable['COUNT(user_id)'] == 1)
		return TRUE;
	else return FALSE;
}

function count_killer($tempID)
{
	$sql = "SELECT COUNT(user_id), current_target FROM assassins WHERE alive=1 GROUP BY current_target";
	$result = mysql_query($sql) or die(mysql_error());

	$count = 0;
	while($line = mysql_fetch_assoc($result))
		if($line['current_target'] == $tempID)
			$count = $line['COUNT(user_id)'];
	mysql_free_result($result);

	if($count == 0)
		return 0;
	else if(rand(1,5) == 1)
	{
		$count--;
		return $count;
	}
	else return $count;
}

function get_death_info($deathID)
{
	$sql = 'SELECT * FROM assassins_obits WHERE obit_id='.$deathID;
			
	$result = mysql_query($sql) or die("Query Failed (get_death_info)! ". mysql_error());
	
	$deathsTable = mysql_fetch_assoc($result);
	
	return $deathsTable;
}

function get_deaths()
{
	$sql = 'SELECT * FROM assassins_obits ORDER BY obit_time DESC';
			
	$result = mysql_query($sql) or die("Query Failed (get_deaths)! ". mysql_error());
	
	$deathsTable = array();
	while($line = mysql_fetch_assoc($result))
		array_push($deathsTable,$line);
	
	mysql_free_result($result);
	
	return $deathsTable;
}

function get_yesterdays_deaths()
{
	$sql = 'SELECT * FROM assassins_obits WHERE DATE(obit_time) = DATE_SUB(CURDATE(),INTERVAL 1 DAY) ORDER BY obit_time DESC';
			
	$result = mysql_query($sql) or die("Query Failed (get_deaths)! ". mysql_error());
	
	$deathsTable = array();
	while($line = mysql_fetch_assoc($result))
		array_push($deathsTable,$line);
	
	mysql_free_result($result);
	
	return $deathsTable;
}

function get_high_kills($num)
{
	$sql = 'SELECT codename, numkills, alive FROM assassins ORDER BY numkills DESC, alive DESC, codename ASC LIMIT '.$num;
			
	$result = mysql_query($sql) or die("Query Failed (get_high_kills_i)!". mysql_error());
	
	$highKillsTable = array();
	while($line = mysql_fetch_assoc($result))
		array_push($highKillsTable,$line);
	
	mysql_free_result($result);
	
	return $highKillsTable;
}

function get_player_info($tempID)
{
	$sql = "SELECT * FROM assassins NATURAL JOIN user WHERE user_id='$tempID'";
			
	$result = mysql_query($sql) or die("Query Failed (get_player_info)! ". mysql_error());
	
	return mysql_fetch_assoc($result);
}

function get_player_list()
{
	$sql = 'SELECT user_id, user_name AS realname, codename, numkills, alive, current_target FROM assassins NATURAL JOIN user ORDER BY user_name';
			
	$result = mysql_query($sql) or die("Query Failed (get_player_list)!". mysql_error());
	
	$playerTable = array();
	while($line = mysql_fetch_assoc($result))
		array_push($playerTable,$line);
	
	mysql_free_result($result);
	
	return $playerTable;
}

function assassins_admin($tempID)
{
	$admin = 0;

	if ($tempID == 2913 || $tempID == 13)
	{
		$admin = 1;
	}
	
	return $admin;
}

function is_playing($tempID)
{
	$sql = 'SELECT user_id FROM assassins';

	$result = mysql_query($sql) or die("Query Failed (is_playing())!". mysql_error());
	
	$bin = 0;
	while($line = mysql_fetch_assoc($result))
		if($line['user_id']==$tempID){$bin=1;}
	
	mysql_free_result($result);
	
	return $bin;
}

function kill_user($killer, $killed, $sd)
{
	if($killer)
	{
		$killer_info = get_player_info($killer);
		$killed_info = get_player_info($killed);

		$query = "INSERT INTO assassins_obits(killer_id, killed_id) VALUES (".$killer.", ".$killed.")";
		mysql_query($query) or die("Couldn't kill user =( ". mysql_error());

		$setdead1 = "UPDATE assassins SET numkills=numkills+1 WHERE user_id=".$killer;
		$setdead2 = "UPDATE assassins SET alive=0 WHERE user_id=".$killed;
		mysql_query($setdead1) or die("Couldn't set dead =( ". mysql_error());
		mysql_query($setdead2) or die("Couldn't set dead =( ". mysql_error());
		if($sd) {
			$setdead3 = "UPDATE assassins SET numsdkills+=1 WHERE user_id=".$kill_info['killer_id'];
			mysql_query($setdead1) or die("Couldn't set undead =( ". mysql_error());
		} 
	}
	else
	{
		$killed_info = get_player_info($killed);
		
		$query = "INSERT INTO assassins_obits(killer_id, killed_id) VALUES (".$killer.", ".$killed.")";
		mysql_query($query) or die("Couldn't kill user =( ". mysql_error());

		$setdead = "UPDATE assassins SET alive=0 WHERE user_id=".$killed;
		mysql_query($setdead) or die("Couldn't set dead =( ". mysql_error());	
	}
	new_target($killed);
}

function new_target($tempID)
{
	$sql = "SELECT user_id FROM assassins WHERE current_target=".$tempID;
	$result = mysql_query($sql) or die("new_target() failed! ".mysql_error());

	$killerTable = array();
	while($line = mysql_fetch_assoc($result))
		array_push($killerTable,$line);
	
	mysql_free_result($result);
	
	foreach($killerTable as $killer)
	{
		rand_target($killer['user_id']);
	}
}

function pick_killcode($tempID)
{
	$query = "SELECT word FROM assassins_words ORDER BY RAND() LIMIT 1";
	$result = mysql_query($query) or die("Query Failed (pick_killcode())! ". mysql_error());
	
	$word = mysql_fetch_assoc($result);
	$setword = "UPDATE assassins SET killcode='".$word['word']."' WHERE user_id=".$tempID;
	// $setword = "UPDATE assassins SET killcode='kill' WHERE user_id=".$tempID;

	mysql_query($setword) or die("Couldn't pick word =( ". mysql_error());
}

function rand_killer($tempID)
{
	$query = "SELECT user_id FROM assassins WHERE alive=1 && current_target=".$tempID." ORDER BY RAND() LIMIT 1";
	$result = mysql_query($query) or die("Query Failed (rand_target())! ".mysql_error());
	$killer = mysql_fetch_assoc($result);

	if(rand(1,5) == 1)
		return 0;
	else if($killer['user_id'])
		return $killer['user_id'];
	else return 0;
}

function rand_target($tempID)
{
	if (check_win())
	{
		$sql = "UPDATE assassins SET current_target=1 WHERE user_id='$tempID'";
		mysql_query($sql) or die("Couldn't set new target =( ". mysql_error());
	} else {
		$query = "SELECT user_id FROM assassins WHERE alive=1 ORDER BY ((numkills * RAND()) + RAND()) LIMIT 1";
		$result = mysql_query($query) or die("Query Failed (rand_target())! ".mysql_error());
		$new_target = mysql_fetch_assoc($result);
		$new_target = $new_target['user_id'];

		if($new_target != $tempID)
		{
			$sql = "UPDATE assassins SET current_target='$new_target' WHERE user_id='$tempID'";
			mysql_query($sql) or die("Couldn't set new target =( ". mysql_error());
		}
		else
		{
			rand_target($tempID);
		}
	}
}

function startgame()
{
	foreach(get_player_list() as $player)
	{
		rand_target($player['user_id']);
	}
}

function reset_game(){
	$sql = "TRUNCATE TABLE assassins"; 
	mysql_query($sql);
	$sql = "TRUNCATE TABLE assassins_obits"; 
	mysql_query($sql);
}

function target_name($tempID)
{
	$target = get_player_info($tempID);

	return $target['user_name'];
}

function undo_kill($killID)
{
	$kill_info = get_death_info($killID);

	if($kill_info['killer_id'])
	{
		$killer_info = get_player_info($kill_info['killer_id']);
		$killed_info = get_player_info($kill_info['killed_id']);
		
		$setdead1 = "UPDATE assassins SET numkills-=1 WHERE user_id=".$kill_info['killer_id'];
		$setdead2 = "UPDATE assassins SET alive=1 WHERE user_id=".$kill_info['killed_id'];
		mysql_query($setdead1) or die("Couldn't set undead =( ". mysql_error());
		mysql_query($setdead2) or die("Couldn't set undead =( ". mysql_error());
		if($kill_info['sdkill']) {
			$setdead3 = "UPDATE assassins SET numsdkills-=1 WHERE user_id=".$kill_info['killer_id'];
			mysql_query($setdead1) or die("Couldn't set undead =( ". mysql_error());
		}

		$query = "DELETE FROM assassins_obits WHERE obit_id=".$killID;
		mysql_query($query) or die("Couldn't unkill user =( ". mysql_error());		
	}
	else
	{
		$setdead = "UPDATE assassins SET alive=1 WHERE user_id=".$kill_info['killed_id'];
		mysql_query($setdead) or die("Couldn't set undead =( ". mysql_error());

		$query = "DELETE FROM assassins_obits WHERE obit_id=".$killID;
		mysql_query($query) or die("Couldn't unkill user =( ". mysql_error());
	}
}

function unique_name($codename)
{
	$sql = 'SELECT codename FROM assassins';			
	$result = mysql_query($sql) or die("Query Failed (unique_name)!". mysql_error());
	
	$nameTable = array();
	while($line = mysql_fetch_assoc($result))
		array_push($nameTable,$line);
	mysql_free_result($result);

	$unique = 1;
	foreach($nameTable as $name)
	{
		if($name['codename'] == $codename)
				$unique = 0;
	}
	
	return $unique;
}

function users_get()
{
	$sql = 'SELECT user_id, user_name AS name FROM user '
			. " WHERE status_id NOT IN (2,5,9) ORDER BY user_name";
	return db_select($sql);
}

?>
