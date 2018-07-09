<?

include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/user.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');


if(isset($_SESSION['id']))
$id = $_SESSION['id'];

if(isset($_SESSION['class']))
$class = $_SESSION['class'];

// tight = 1, close = 2, loose = 3
$family = intval($_GET['family']);

// check for invalid input, and default to tight family
if($family < 1 || $family > 3)
	$family = 1;

// get a list of people in a specific family
function users_getByFamily($family_id)
{
	$sql = 'SELECT user_id, user_name AS name, class_id '
			. ' FROM user WHERE '
			. " family_id = '$family_id' "
            . ' AND (status_id NOT IN ('.STATUS_ADMINISTRATOR.','.STATUS_DEPLEDGE
			. ')) ORDER BY user_name';
	return db_select($sql);
}

// get all the class names and their internal IDs
function class_getAll()
{
	$sql = 'SELECT class_id, class_name FROM class '
        . ' ORDER BY class_year DESC, class_term ASC ';
	return db_select($sql);
}

// start building up the javascript code
$script = "<script language=\"JavaScript\">\n"
			. "var users = Array();\n";

foreach(users_getByFamily($family) as $user)
{
	extract($user);
	$script .= "users.push({user: $user_id, name: '$name', "
             . " class_id: $class_id });\n";
}

$script .= '

function filter(class_id, bro)
{
	var html = "<label for=\"select"+bro+"\">"+bro+
        " bro:</label><select id=\"select"+bro+"\" name=\""+bro+"\">\n";

	for(var i=0; i<users.length; i++)
	{
		if(class_id == 0 || users[i].class_id == class_id)
			html += "<option value=\"" + users[i].user + "\">" + 
                    users[i].name + "</option>";
	}

	html += "</select>\n";

	document.getElementById(bro).innerHTML = html;
	
	Set_Cookie("bro_"+bro+"_class",class_id,false);
}

</script>

';

$bigclass = intval($_COOKIE['bro_big_class']);
$littleclass = intval($_COOKIE['bro_little_class']);
show_calhead($script, "filter($bigclass,'big'); filter($littleclass,'little')");

// $temp=user_get($id, 'f');
if($class!="admin")
	show_note('You must be admin vp to access this page.');
?>
    
<div class="general" style="width: 100px">
Family:
<select onChange=
    "window.location = '/people/lineedit.php?family=' + this.value">
<option value="1" <?= $family==1?'selected':''?>>Alpha</option>
<option value="2" <?= $family==2?'selected':''?>>Phi</option>
<option value="3" <?= $family==3?'selected':''?>>Omega</option>
</select>
</div>
<div style="height: 50px">
<div class="general" style="width:240px; float: left;">
	<label for="whocaresbig">Big Class Filter:</label>
	<select id="whocaresbig" name="whocaresbig" 
        onChange="filter(this.value, 'big')">
		<?php
		echo "<option value=\"0\">all classes</option>\n";
		foreach(class_getAll() as $class)
		{
			$selected = ($bigclass == $class['class_id'])?'selected':'';
			echo "<option value=\"{$class['class_id']}\" $selected>",
                 "{$class['class_name']}</option>\n";
		}
		?>
	</select>
</div>
<div class="general" style="width:240px; float: left;">
	<label for="whocareslittle">Little Class Filter:</label>
	<select id="whocareslittle" name="whocareslittle" 
        onChange="filter(this.value, 'little')">
		<?php
		echo "<option value=\"0\">all classes</option>\n";
		foreach(class_getAll() AS $class)
		{
			$selected = ($littleclass == $class['class_id'])?'selected':'';
			echo "<option value=\"{$class['class_id']}\" $selected>",
                 "{$class['class_name']}</option>\n";
		}
		?>
	</select>
</div>
</div>
<form action="/people/input.php" method="POST">
<input type="hidden" name="action" value="add" />
<input type="hidden" name="redirect" 
    value="/people/lineedit.php?family=<?php echo $family ?>" />
<div style="height: 50px">
<div id="big" class="general" style="width: 240px; float: left;"></div>
<div id="little" class="general" style="width: 240px; float: left;"></div>
<div class="general" style="float: left;">
    <input type="submit" name="submit" value="Add Relationship" /></div>
</div>
</form>

<div>
	<table cellspacing="1">
		<tr><th>Big</th><th>Lil</th><th>Options</th></tr>
		<?php 
			$sql = 'SELECT b.user_name AS big, b.user_id AS b_id, '
				. ' l.user_name AS little, l.user_id AS l_id, '
                . ' cb.class_nick AS b_c, cl.class_nick AS l_c '
				. ' FROM bro, (user b NATURAL JOIN class cb), '
                .   ' (user l NATURAL JOIN class cl) '
				. ' WHERE b.user_id = bro.big AND l.user_id = bro.little '
				. " AND b.family_id = '$family' "
				. ' ORDER BY b.user_name';
		
			foreach(db_select($sql) as $bro)
			{
                $big = "{$bro['big']} ({$bro['b_c']})";
                $lil = "{$bro['little']} ({$bro['l_c']})";
            
				echo "<tr><form action=\"/people/input.php\" method=\"POST\">",
                "<td>$big</td><td>$lil</td>";
				?><td>
					<input type="hidden" name="action" value="delete" />
					<input type="hidden" name="redirect" 
                        value="/people/lineedit.php?family=<?= $family ?>" />
					<input type="hidden" name="big" 
                        value="<?php echo $bro['b_id'] ?>"/>
					<input type="hidden" name="little" 
                        value="<?php echo $bro['l_id'] ?>"/>
					<input type="submit" name="submit" 
                        value="Remove" style="margin: 0px; padding: 0px; " />
				</td></form></tr><?php
			}
		?>
	</table>
</div>

<?php
show_footer();

?>
