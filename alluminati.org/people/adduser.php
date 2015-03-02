<?
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/show.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
get_header();

build_users();

if($_SESSION['class'] == 'admin'||
	$_SESSION['class'] == 'membership' ||
	$_SESSION['class'] == 'WAC' ||
	$_SESSION['class'] == 'pledge parents'):
?>
<script type="text/javascript">

function checkinputs()
{
    var name = document.getElementById('name');
	var email = document.getElementById('email');
    var msg = "Are you sure this is not a duplicate of: \n";
    for(i in users)
    {
        if(users[i].name == name.value)
            msg += "name: " + name.value + 
                   ", class: " + users[i].class + " class\n";
    }
	if(name.value == "<Full name>" || name.value.length == 0 || email.value == "<Email address>" || email.value.length == 0) {
		alert("Name and email address cannot be blank!");
		return false;
	} else if(msg.length > "Are you sure this is not a duplicate of: \n".length)
		return confirm(msg);
	else
		return true;
}

</script>

<form method="POST" onsubmit="return checkinputs();" action="/people/input.php">
<input type="hidden" name="action" value="adduser" />
<input type="hidden" name="redirect" value="/people/adduser.php" />
<table>
    <tr><td class="heading" colspan="5">Add User</td></tr>
    <tr><th>Name</th><th>Email Address</th><th>Family</th><th>Class</th><th></th></tr>
    <tr>
        <td>
            <input id="name" name="name" onclick="this.select()"
                type="text" size="40" value="<Full name>" />
        </td>
        <td>
            <input id="email" name="email" onclick="this.select()"
                type="text" size="40" value="<Email address>" />
        </td>
        <td>
        <select name="family"> 
            <?php
            // Populate drop down menu with families
            $sql = "SELECT family_id, family_name FROM family";
            $result = mysql_query($sql) 
                or die("Query Failed!". mysql_error());	
            while($row = mysql_fetch_array($result))
                echo ("<option value=\"{$row[0]}\">{$row[1]}</option>");
            mysql_free_result($result);
            ?>
        </select>
        </td>
        <td>
        <select name="class">
            <?php
            // Populate drop down menu with pledge classes
            $sql = "SELECT class_id, class_name "
                . " FROM class WHERE class_id > 0 "
                . " ORDER BY class_year desc, class_term asc";
            $result = mysql_query($sql) 
                or die("Query Failed!". mysql_error());	
            while($row = mysql_fetch_array($result))
            {
				echo ("<option value=\"{$row[0]}\"");
				if ( $row[0] == db_currentClass('class_id') )
					echo ' selected';
				echo (">{$row[1]}</option>");
			}
            mysql_free_result($result);
            ?>        
        </select>
        </td>
        <td>
        <input type="submit" value="Add Person" />
        </td>
    </tr>
</table>
</form>
<?php 
else:
	echo 'You don\'t have permission to do that!';
endif;

show_footer();

?>
