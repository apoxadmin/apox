<?php 
include_once dirname(dirname(__FILE__)) . '/include/mobiletemplate.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/forms.inc.php';

if(isset($_SESSION['id']))
	$user = $_SESSION['id'];
else
	show_note('You are not logged in.');

if(isset($_SESSION['class']))
	$class = $_SESSION['class'];
/*
if(isset($_GET['search']))
	$_SESSION['search'] = $_GET['search'];
*/
if(!isset($_SESSION['sort']))
	$_SESSION['sort'] = 'name';
	
if($_SESSION['sort']==$_GET['sort'])
{
	if($_SESSION['order']=='ASC')
		$_SESSION['order'] = 'DESC';
	else
		$_SESSION['order'] = 'ASC';
}
else
{
	$_SESSION['order'] = 'ASC';
	if(isset($_GET['sort']))
		$_SESSION['sort'] = $_GET['sort'];
}

// set search query
if(isset($_GET['search']))
{
	$terms = explode(' ',$_GET['search']);
	foreach($terms as $term)
	{
		$search .= " AND (user_name LIKE '%$term%' OR "
				. " user_address LIKE '%$term%' OR user_aim LIKE '%$term%' OR "
				. " family_name LIKE '%$term%' OR class_nick LIKE '%$term%') ";
	}
}

if(isset($_SESSION['sort']))
{
	switch($_SESSION['sort'])
	{
		case 'name': $sort = 'user_name'; break;
		case 'address': $sort = 'user_address'; break;
		case 'cell': $sort = 'user_cell'; break;
		case 'email': $sort = 'user_email'; break;
		case 'aim': $sort = 'user_aim'; break;
		case 'class': $sort = 'user.class_id'; break;
		default: $sort = 'user_name'; break;
	}
	
	$sort = " AND $sort <> '' ORDER BY $sort {$_SESSION['order']}";
}

function userfull_get($search = false, $sort = false)
{
	$query = 'SELECT user_name as name, user_address, user_cell, '
	. ' LEFT(user_email, 27) AS user_email, user_id'
	. ' FROM user, family, class '
	. ' WHERE (class.class_id = user.class_id) AND (user.family_id = family.family_id) '
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

show_rosterheader();
?>

<script type="text/javascript">

<?php
$sql = 'SELECT user_id, status_id FROM user WHERE status_id NOT IN ('
		.STATUS_ADMINISTRATOR.','.STATUS_DEPLEDGE.','.STATUS_DEACTIVATED.') ';
echo 'users = Array();';
foreach(db_select($sql) as $user)
{
	echo "users.push({id:'{$user['user_id']}', status:{$user['status_id']}});";
}?>

function peopleFilter(filter)
{
	var pledge;
	var element;
	
	document.getElementById("loading").style.display = 'block';
	for(var i=0; i<users.length; i++)
	{
		element = document.getElementById("r"+users[i].id);
		pledge = (users[i].status == <?= STATUS_PLEDGE ?>);
		
		if(element != null)
		{
			if((pledge && filter==1) || (!pledge && filter==2))
				element.style.display = "none";
			else
				element.style.display = "";
		}
	}
	document.getElementById("loading").style.display = 'none';
}
</script>

<form>
	<div class="general" style="width: 35%;">
		<font class="big">Status Filter: </font>
		<select name="filters" onchange="peopleFilter(this.value)" style="margin: 0px; padding: 0px">
			<option value="0" <?php echo ($filterx==0)?'selected':'' ?>>Everyone</option>
			<option value="1" <?php echo ($filterx==1)?'selected':'' ?>>Non-Pledges</option>
			<option value="2" <?php echo ($filterx==2)?'selected':'' ?>>Pledges</option>
		</select>
	</div>
</form>

<div class="general">
	<div style="color:white" class="general boxtop">Search</div>
	<div class="general">
		Find terms in members' name, address, screen name, or pledge class:<br/><br/>
		<div id="rosterbox">
		<form action="/mobile/roster.php" method="GET">
			<?php forms_text('23', 'search', $_GET['search']); ?>
			<br>
			<br>
			<input type="submit" value="Search" />
		</form>
		</div>
	</div>
</div>
<br>
<?php	if (isset($_GET['search'])) { ?>
<table cellspacing="1">
	<tr>
		<th><a href="/mobile/roster.php?sort=name">Name</a></th>
		<th><a href="/mobile/roster.php?sort=address">Address</a></th>
		<th><a href="/mobile/roster.php?sort=cell">Phone</a></th>
		<th><a href="/mobile/roster.php?sort=email">Email</a></th>
	</tr>
	<?php 
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
		
		echo "<tr id=\"r{$user['user_id']}\">"; 
		if($class=='user') // simple case, for the user
		{
			foreach($user as $column => $value)
			{
				$value = htmlentities($value);
				if($column=='name')
					echo "<td class=\"black\"><a  href=\"/mobile/profile.php?user={$user['user_id']}\">$value</a></td>\n";
				elseif($column!='user_id' && $column!='user_aim')
					echo "<td class=\"small\">$value</td>\n";
				elseif($column == 'user_aim')
				{
					echo "<td class=\"black\">";
					if($value != '')
					echo "<a href=\"aim:goim?screenname=$value\">$value</a></td>";
				}  
			}
		}
		elseif($class=='admin') // more complex case
		{
			foreach($user as $column => $value)
				if($column!='user_id')
				{
					if($column!='name')
					{
						$value = htmlentities($value);
						echo "<td class=\"black\">$value</td>\n";
					}
					else
					{
						echo "<td class=\"black\"><a href=\"/people/myrosterinfo.php?user={$user['user_id']}\">$value</a></td>\n";
					}
				}
		}
		echo "</tr>\n";
	} 
	?>
</table>

<?php
}

show_footer(); ?> 

