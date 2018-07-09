<?php 

include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once 'sql.php';
include_once dirname(dirname(__FILE__)) . '/include/forms.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/user.inc.php';

show_header();

if(isset($_SESSION['id']))
	$id = $_SESSION['id'];
	
if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

$temp=user_get($id, 'f');
$temp=$temp['name'];

if($class!="admin")
	show_note('You must be an administrator to access this page.');

$everyone = getGeneralTracking('pictures');
/*
?>
<form action="/tracking/input.php" method="POST">
<?php 
forms_hiddenInput('setgeneraltracking', '/tracking/pictures.php'); 
forms_hidden('key', 'pictures'); 
?>
<table>
	<tr><td class="heading" colspan="3">Pictures Submitted</td></tr>
	<tr><th>Name</th><th>Pictures</th></tr>
	<?php
	foreach($everyone as $person)
	{
		extract($person);
		echo "<tr><td>";
		forms_hidden('user[]', $user_id);
		echo "<span title=\"$class_nick Class\">$name</span></td><td>";
		forms_text(5, "value[$user_id]", $value);
		echo "</td></tr>";
	}
	?>
	<tr><td colspan="3"><?php forms_submit('Update', 'Update') ?></td></tr>
</table>
</form>
<?php */
show_note("Picture tracking has been disabled for now--contact the admins if you'd like it back.");
show_footer();
?>
