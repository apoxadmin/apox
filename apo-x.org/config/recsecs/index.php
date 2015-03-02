<?php
include_once 'template.inc.php';
include_once 'forms.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');


if($_SESSION['class'] == 'admin')
	$edit = true;
else
	show_note('You must be on excomm to modify accounts.');
	
if(isset($_GET['term']))
	$term = $_GET['term'];
else
	$term = 'null';

//list the terms
function getTerms($default='n')
{
	$sql = 'SELECT * FROM class ORDER BY class_start desc, class_year desc, class_term asc';
	$result = db_select($sql, 'Couldn\'t get the list of terms.' . mysql_error());
	
/*	for($i=0; $i<count($result); $i++)
	{
		echo "Term :$default\ni: $i\n\n";
			if($result[$i]['class_id'] == $default)
			$result['selected']=$result[$i];
	}
	
if (!isset($result['selected']))
{
	$result['selected']['class_start']='0000-00-00 00:00:00';
	$result['selected']['isEmpty']=1;
}*/
	
	return $result;
}

$list = getTerms($term);

get_header();

for($i=0; $i<count($list); $i++)	//generate the body of the pull-down menu
{			
	$menu .= "<option value=\"{$list[$i]['class_id']}\"";

	if ($list[$i]['class_id']==$term)
	{
		//if this is the term we want, have it selected
		$menu .= ' selected';
		$thisTerm = $i;	//used to access data about the term later
	}
	$menu .= ">{$list[$i]['class_nick']}</option>\n";
}

//Prepare for the season selection menu
$fallSel = ''; $springSel = '';
if ($list[$thisTerm]['class_term'] == 'Fall')
	$fallSel = ' selected';
else 
	$springSel = ' selected';

if (isset($thisTerm) && $list[$thisTerm]['class_start'] != '0000-00-00 00:00:00')
{
	$start = strtotime($list[$thisTerm]['class_start']);
	$start_date = date('n/j/Y', $start);
	$start_time = date('g:ia', $start);
}
else	//it's either new or a term which hasn't been configured (detected by the class_start)
{
	$start_date = '01/31/1949';
	$start_time = '12:01am';
}
?>
<div class="general">
<form name="data" action="input.php" method="POST" onSubmit="return valid(this);">
<input name="class_id" type="hidden" value="<?= $term ?>">
<table>
<tr><th>Class Name:</th><td>
<?php forms_text(50, 'class_name', $list[$thisTerm]['class_name'], 50) //value can be empty string(new terms)
?>
</td></tr>
<tr><th>Nickname:</th><td><?php forms_text(32, 'class_nick', $list[$thisTerm]['class_nick'], 32) ?></td></tr>
<tr><th>Term Start:</th><td><table>
<tr><td><?php forms_date('class_start',$start_date,'data.class_start') ?><br/>
<b>m/d/yyyy</b></td>
<td><?php forms_time("start_time", $start_time) ?><br/>
ex: <b>6:05pm</b></td></tr></table></td></tr>
<tr><th>Season</th><td> 
<select name="class_term" size="1">
<option value="Fall"<?= $fallSel ?>>Fall</option>
<option value="Spring"<?= $springSel ?>>Spring</option>
</select>
</td></tr>
<tr><th>Mascot:</th><td><?php forms_text(40, 'class_mascot', $list[$thisTerm]['class_mascot'], 40) ?></td></tr>
<tr><th>Spokesperson:</th><td><?php forms_text(40, 'class_spokesperson', $list[$thisTerm]['class_spokesperson'], 40) ?></td></tr>
<tr><td><br></td></tr>
<tr><td align="left"><input type="submit" name="submit" value="Submit"></td>
<td align="right"><input name="confirm_delete" value="Delete" type="submit" onClick="return confirm('Are you sure? This will delete all associated transactions as well.');"><br/>
<br/>
<font size="3"><a href="<?= $_SERVER['PHP_SELF'] ?>">Create New Term</a></font></td></tr>
</form></table>
</div>
<div class="general">
Modify an existing term:<br />
<br />
	<form name="select_class" method="GET" action="<?= $_SERVER['PHP_SELF'] ?>">
	<select name="term" size="1">
			<?php echo $menu; ?>
	</select>
	<?php forms_submit('Select') ?>
	</form>
</div>

<?php
show_footer();
?>
