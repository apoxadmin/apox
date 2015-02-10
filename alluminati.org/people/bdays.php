<?php
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

get_header();

if(isset($_SESSION['id']))
	$user_id = $_SESSION['id'];
else
{
	show_note ("You are not logged in.");
	show_footer();
	exit;
}
$admin = true;

echo '<div class="general">These are the birthdays in the next two months:<br/><br/>';
if($admin) {
	$sql = "SELECT user_name, user_bday, status_name FROM user NATURAL JOIN status WHERE status_id IN (1,3,4,6,7,8)";
	$result = mysql_query($sql) or die(mysql_error());

	$today = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
	$onemonth = mktime(0, 0, 0, date("m")+1, date("d"), date("Y"));
	$twomonth = mktime(0, 0, 0, date("m")+2, date("d"), date("Y"));

	$index = 0;
	while($row = mysql_fetch_array($result)) {
		$birthdate = explode("-", $row['user_bday']);
		$birthday = mktime(0, 0, 0, $birthdate[1], $birthdate[2], date("Y"));
		if($today <= $birthday && $birthday <= $twomonth)
			$list[$index] = array("date" => $birthday, "name" => $row['user_name'], "status" => $row['status_name']);
			$index++;
	}

	sort($list);

	foreach($list as $person) {
		echo "(".$person['status'].") ".$person['name']."'s birthday is on ".date('l, F j', $person['date']).".<br/>";
	}
	echo '</div>';
	show_footer();
}
else {
	print "You are not logged in.</div>";
	show_footer();
}

?>