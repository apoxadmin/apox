<?php 
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/forms.inc.php';

show_header($_SESSION['class'], $_SESSION['id']); 

?>

<div class="general" style="width: 45%; padding: 0px">
<div class="general" style="background: #B55; border-width: 0px 0px 1px 0px; margin: 0px;"><font class="big">Display</font></div><br/>
<div class="general" style="border-width: 0px;">
Show these in the results:<br/>
<form action="/people/input.php" method="POST">
<table><tr><td>
<?php 
$options = array('name','address','phones','email','aim','family','class');

$count = 0;
foreach($options as $column)
{
	echo '<input id="display'.$column.'" name="display[]" checked type="checkbox" value="'.$column.'"/>';
	echo '<label for="display'.$column.'">'.$column.'</label>';
	echo '<br/>';
	$count++;
	if($count == round(count($options)/2))
		echo '</td><td>';
}
?>
</td></tr></table>
<div style="align: right; text-align: right; margin: 10px">
<input type="submit" value="Save Display Settings" />
</div>
</form>

</div>
</div>

<?php
show_footer();
?>
