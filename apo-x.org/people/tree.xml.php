<?php
	include_once dirname(dirname(__FILE__)) . '/include/database.inc.php';
	db_open();
	
	$lilsql = 'SELECT user.user_id AS user, user_name AS name '
			. "FROM bro, user INNER JOIN class ON user.class_id=class.class_id "
			. "WHERE bro.little = user.user_id AND bro.big = '{$_GET['self']}' "
			. "ORDER BY class.class_year, class.class_term DESC";
	
	$lils = db_select($lilsql);
	
	$bigsql = 'SELECT user.user_id AS user, user_name AS name '
			. "FROM bro, user INNER JOIN class ON user.class_id=class.class_id "
			. "WHERE bro.big = user.user_id AND bro.little = '{$_GET['self']}' "
			. "ORDER BY class.class_year, class.class_term DESC";
	
	$bigs = db_select($bigsql);
	
	$selfsql = 'SELECT user_id AS user, user_name AS name '
			. "FROM user WHERE  user_id = '{$_GET['self']}' ";
	$sql = 'SELECT user_id, user_name, family_name, class_nick, user_address, '
        . ' user_phone, user_cell, user_email, user_aim, user_password '
        . ' FROM user, class, family '
		. " WHERE user_id = '{$_GET['self']}' "
		. ' AND user.class_id = class.class_id '
        . " AND user.family_id = family.family_id";
	$self = db_select1($sql, "self query failed.");
	
    header("Content-type: text/xml");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
?>
<response>
	<bigs>
		<? 
		foreach($bigs as $big)
		{
			echo '<person>';
			echo "<user>{$big['user']}</user>";
			echo "<name>{$big['name']}</name>";
			echo '</person>';
		}
		?>
	</bigs>
	<littles>
		<? 
		foreach($lils as $lil)
		{
			echo '<person>';
			echo "<user>{$lil['user']}</user>";
			echo "<name>{$lil['name']}</name>";
			echo '</person>';
		}
		?>
	</littles>
	<self>
		<?php
            // set default values so blanks don't mess the page up
            foreach($self as $k => $v)
                if($v == "")
                    $self[$k] = "??";
            
            // save some typing by pulling all the values out
            extract($self);

			echo '<person>';
			echo "<user>$user_id</user>";
			echo "<name>$user_name</name>";
		?>
		<address><?= htmlentities($user_address) ?></address>
		<pphone><?php echo htmlentities($user_cell) ?></pphone>
		<bphone><?php echo htmlentities($user_phone) ?></bphone>
		<email><?= htmlentities($user_email) ?></email>
		<aim><?= htmlentities($user_aim) ?></aim>
		<family><?= $family_name ?></family>
		<class><?= $class_nick ?></class>
		</person>
	</self>

</response>
