<?php
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/forms.inc.php';

if(isset($_SESSION['id']))
	$user = $_SESSION['id'];
else
	show_note('You are not logged in.');

if(isset($_SESSION['class']))
	$class = $_SESSION['class'];
	
if(isset($_GET['search']))
{
	$terms = explode(' ',$_GET['search']);
	$search = "";
	foreach($terms as $term)
	{
		$search .= " AND (user_name LIKE '%$term%' OR "
				. " user_address LIKE '%$term%' OR user_aim LIKE '%$term%' OR "
				. " major LIKE '%$term%' OR "
				. " family_name LIKE '%$term%' OR user_cell LIKE '%$term%' OR class_nick LIKE '%$term%') ";
	}
if ( isset( $_GET['sort'] ) )
	$_SESSION['sort'] = $_GET['sort'];
if(isset($_SESSION['sort']))
{
	switch($_SESSION['sort'])
	{
		case 'name': $sort = 'user_name'; break;
		case 'address': $sort = 'user_address'; break;
		case 'cell': $sort = 'user_cell'; break;
	    case 'text': $sort = 'text_type'; break;
		case 'email': $sort = 'user_email'; break;
		case 'aim': $sort = 'user_aim'; break;
		case 'class': $sort = 'user.class_id'; break;
		default: $sort = 'user_name'; break;
	}
	
	$sort = " AND $sort <> '' ORDER BY $sort {$_SESSION['order']}";
}

function userfull_get($search = false, $sort = false)
{
	$query = 'SELECT user_name as name, user_address, user_cell,'
	. ' LEFT(user_email, 27) AS user_email, user_aim, user_id, class_nick '
	. ' FROM user, family, class'
	. ' WHERE (class.class_id = user.class_id) AND (user.family_id = family.family_id)'
	. ' AND (status_id NOT IN ('.STATUS_ADMINISTRATOR.','.STATUS_DEPLEDGE.','.STATUS_DEACTIVATED.')) '
	. ' AND (user_email IS NOT NULL)';
	
	if($search !== false)
		$query .= $search;
	
	if($sort !== false)
		$query .= $sort;
	else
		$query .= ' ORDER BY user_name';

	return db_select($query, "userfull_get()");
}

$userList = array();
	foreach(userfull_get($search, $sort) as $user)
	{
		if(strlen($user['user_cell']) == 10)
		{
			$new_phone = '';
			$new_phone .= '(' . substr($user['user_cell'],0,3) . ')';
			$new_phone .= substr($user['user_cell'],3,3) . '-';
			$new_phone .= substr($user['user_cell'],6);
			$user['user_cell'] = $new_phone;
		}
//		if($class=='user') // simple case, for the user
//		{
			foreach($user as $column => $value)
			{
				$value = htmlentities($value);
				$userList[$user['user_id']][$column] = $value;
			}
//		}
	}
	echo json_encode($userList);
	}
?>
