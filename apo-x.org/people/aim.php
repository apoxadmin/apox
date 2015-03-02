<?php 
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';

if(isset($_SERVER['HTTP_USER_AGENT']))
	die('You must use AIM to access your tracking.');
	
$sn = $_GET['sn'];

$sql = "SELECT user_id as id FROM user WHERE user_aim = '$sn' ";
$id = db_select1($sql) or die('the screen name you\'re using isn\'t in the roster');

// set search query
if(isset($_GET['search']))
{
	$terms = explode(' ',$_GET['search']);
	foreach($terms as $term)
	{
		$search .= " AND (user_name LIKE '%$term%' OR "
				. " user_address LIKE '%$term%' OR user_aim LIKE '%$term%' OR "
				. " family_name LIKE '%$term%' OR SUBSTRING_INDEX(class_name, ' ', -1) LIKE '%$term%') ";
	}
}

function userfull_get($search)
{
	$query = 'SELECT user_name as name, user_address, user_phone, user_cell, '
	. ' user_email, user_aim, family_name, user_id, SUBSTRING_INDEX(class_name, \' \', -1) AS class_name '
	. ' FROM user, family, class '
	. ' WHERE (class.class_id = user.class_id) AND (user.family_id = family.family_id) '
	. ' AND user_hidden=0 ';
	
	$query .= $search;
	$query .= ' ORDER BY user_name';

	return db_select($query, "userfull_get()");
}

$results = userfull_get($search);
if(count($results) > 3)
{
	echo "your search returned too many results, try being more specific";
	exit();
}
elseif(count($results) == 0)
{
	echo "your search didn't give any results";
	exit();
}

echo '<font size="-2" face="courier new"><hr>';

foreach($results as $user)
{
	extract($user);

	if(strlen($user_cell) == 10)
	{
		$new_phone = '';
		$new_phone .= '(' . substr($user_cell,0,3) . ')';
		$new_phone .= substr($user_cell,3,3) . '-';
		$new_phone .= substr($user_cell,6);
		$user_cell = $new_phone;
	}
	
	if(strlen($user['user_phone']) == 10)
	{
		$new_phone = '';
		$new_phone .= '(' . substr($user_phone,0,3) . ')';
		$new_phone .= substr($user_phone,3,3) . '-';
		$new_phone .= substr($user_phone,6);
		$user_phone = $new_phone;
	}
	
	$user_email = "<a href=\"mailto:$user_email\">$user_email</a>";
	$user_aim = "<a href=\"aim:goim?screenname=$user_aim\">$user_aim</a>";
	
	echo "Name: $name<br>";
	echo "Address: $user_address<br>";
	echo "Home Phone: $user_phone<br>";
	echo "Cell Phone: $user_cell<br>";
	echo "Email: $user_email<br>";
	echo "Screen Name: $user_aim<br>";
	echo "Family: $family_name<br>";
	echo "Class: $class_name<br>";
	echo "<hr>";
} 

echo '</font>';

?>

