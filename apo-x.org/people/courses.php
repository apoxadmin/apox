<?php 
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/forms.inc.php';

if(isset($_SESSION['id']))
	$user = $_SESSION['id'];
else
	show_note('You are not logged in.');

if(isset($_POST['course'])) {
	$course = $_POST['course'];
	$quarter = 'Fall';
	$year = 2008;
	$sql = "INSERT INTO course (user_id, course_desc, quarter, year) VALUES ($user, '$course', '$quarter', $year)";
	$result = mysql_query($sql) or die("Query failed =(");
}

if(isset($_POST['delete'])) {
	$course_id = $_POST['course_id'];
	$sql = "DELETE FROM course WHERE course_id=$course_id";
	$result = mysql_query($sql) or die("Query failed =(");
}
	
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

if(isset($_SESSION['sort']))
{
	switch($_SESSION['sort'])
	{
		case 'name': $sort = 'user_name'; break;
		case 'course': $sort = 'course_desc'; break;
		case 'quarter': $sort = 'quarter'; break;
		case 'year': $sort = 'year'; break;
		default: $sort = 'user_name'; break;
	}
	
	$sort = " AND $sort <> '' ORDER BY $sort {$_SESSION['order']}";
}

function userfull_get($sort = false)
{
	$query = 'SELECT user.user_name as name, course.course_desc, course.quarter, course.year, user.user_id, course.course_id'
	. ' FROM user, course'
	. ' WHERE (user.user_id = course.user_id) '
	. ' AND (status_id NOT IN ('.STATUS_ADMINISTRATOR.','.STATUS_DEPLEDGE.','.STATUS_DEACTIVATED.')) ';
	
	if($sort !== false)
		$query .= $sort;
	else
		$query .= ' ORDER BY user_name';
	return db_select($query, "userfull_get()");
}

show_header();
?>

<script type="text/javascript">

<?php
$sql = "SELECT course_desc, quarter, year FROM course WHERE user_id = {$_SESSION['id']}";
$my_courses = db_select($sql);
$sql = 'SELECT course_id, course_desc, quarter, year FROM course';
echo 'courses = Array();';
foreach(db_select($sql) as $course)
{
	if (empty($my_courses))
		$match=0;
	else
		$match=0;
		foreach($my_courses as $mycourse) {
			if ($match==1 || ($course['quarter']==$mycourse['quarter'] && $course['year']==$mycourse['year'] && strcasecmp(strtr($course['course_desc'],array(' ' => '')),strtr($mycourse['course_desc'],array(' ' => '')))==0))
				$match=1;
		}
	echo "courses.push({id:'{$course['course_id']}', quarter:\"{$course['quarter']}\", year:{$course['year']}, match:$match});";
}?>

function peopleFilter(filter)
{
	var match;
	var element;
	
	document.getElementById("loading").style.display = 'block';
	for(var i=0; i<courses.length; i++)
	{
		element = document.getElementById("r"+courses[i].id);
		match = (courses[i].match);
		
		if(element != null)
		{
			if(match==0 && filter==0)
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
		<font class="big">Show: </font>
		<select name="filters" onchange="peopleFilter(this.value)" style="margin: 0px; padding: 0px">
			<option value="0">People in My Classes</option>
			<option value="1" selected>Everyone</option>
		</select>
	</div>
</form>

<div class="general">
	<div class="general boxtop">Add a Class</div>
	<div class="general">
		Enter the three-letter department and number of a class that you're taking (i.e. NPB 101):<br/><br/>
		<form action="/people/courses.php" method="POST">
			<?php forms_text('10','course'); ?>
			<input type="submit" value="Submit" />
		</form>
	</div>
</div>
<table cellspacing="1">
	<tr>
		<th><a href="/people/courses.php?sort=name">Name</a></th>
		<th><a href="/people/courses.php?sort=course">Class</a></th>
		<th><a href="/people/courses.php?sort=quarter">Quarter</a></th>
		<th><a href="/people/courses.php?sort=year">Year</a></th>
	</tr>
	<?php 
	foreach(userfull_get($sort) as $course)
	{
		
		echo "<tr id=\"r{$course['course_id']}\">"; 

		foreach($course as $column => $value)
		{
			$value = htmlentities($value);
			if($column=='name')
				echo "<td class=\"small\"><a href=\"/people/profile.php?user={$course['user_id']}\">$value</a></td>\n";
			elseif($column=='user_id') {
				if ($_SESSION['id']==$value)
					echo "<td class=\"nomargin nopadding\"><form action=\"courses.php\" method=\"post\" class=\"nomargin nopadding\"><input type=\"hidden\" name=\"course_id\" value=\"{$course['course_id']}\"/><input type=\"submit\" name=\"delete\" value=\"Delete\" /></form></td>";				
			} elseif($column=='course_id') {
			}
			else
				echo "<td class=\"small\">$value</td>\n";				
		}
		echo "</tr>\n";
	} 
	?>
</table>

<?php show_footer(); ?> 
