<?php

function forms_text($size, $name, $default = '', $maxlength = -1)
{
	if ($maxlength == -1) $maxlength=$size;
	echo "<input name=\"$name\" type=\"text\" id=\"text\" size=\"$size\" maxlength=\"$maxlength\" value=\"$default\" />\n";
}

function forms_text_required($size, $name, $default = '', $maxlength = -1)
{
	if ($maxlength == -1) $maxlength=$size;
	echo "<input name=\"$name\" type=\"text\" id=\"text_required\" size=\"$size\" maxlength=\"$maxlength\" value=\"$default\" />\n";
}

function forms_password($size, $name, $default = '')
{
	echo "<input name=\"$name\" type=\"password\" id=\"text\" size=\"$size\" maxlength=\"$size\" value=\"$default\" />\n";
}

function forms_checkbox($name, $value, $checked = false)
{
	if($checked)
		echo "<input name=\"$name\" type=\"checkbox\" checked value=\"$value\" />";
	else
		echo "<input name=\"$name\" type=\"checkbox\" value=\"$value\" />";
}

function forms_checkbox_disabled($name, $value, $checked = false)
{
	if($checked)
		echo "<input name=\"$name\" type=\"checkbox\" checked disabled value=\"$value\" />";
	else
		echo "<input name=\"$name\" type=\"checkbox\" disabled value=\"$value\" />";
}

function forms_radio($name, $value, $checked, $disabled = false)
{
	if ($disabled)
		$disabled = 'disabled';
	else
		$disabled = '';
	if($checked)
		echo "<input name=\"$name\" type=\"radio\" checked $disabled value=\"$value\" />";
	else
		echo "<input name=\"$name\" type=\"radio\" $disabled value=\"$value\" />";
}

function forms_textarea($name, $default = '')
{
	echo "<textarea name=\"$name\" id=\"textarea\" rows=5 cols=50>$default</textarea>";
}

function forms_date($name, $default, $form)
{
	echo "<input name=\"$name\" type=\"text\" size=\"10\" id=\"date\" maxlength=\"10\" value=\"$default\" />\n"; 
	?>
	<script language="JavaScript" type="text/javascript" SRC="/script/cal.js"> </script>
	<script language="JavaScript" type="text/javascript">
	<!--!
	var cal = new CalendarPopup("calendardiv");
	cal.setDateFormat('MM/dd/yyyy');
	cal.setParseDateFormat('M/d/y');
	var asapDate = new Date();
	var today = new Date();
	var nextYear = new Date(today.getTime() + 365*24*60*60*10000);
	var lastYear = new Date(today.getTime() - 365*24*60*60*1000);
	cal.setDateRange(lastYear, nextYear);
	cal.setTimeout(25000);
	document.write(cal.getStyles());
	document.write('<a onClick="cal.select(document.forms.<?php echo $form ?>,0,0,\'anchor0\',-1, false, 1, false); return false;" ' +
	'name="anchor0" id="anchor0">' +
	'<img src="/images/calendar.gif" width="34" height="21" alt="Click this calendar to choose a date." />' +
	'</a>');
	//-->
	</script>
	<?php 
}

function forms_time($name, $default = '')
{
	echo "<input name=\"$name\" type=\"text\" id=\"time\" size=\"7\" maxlength=\"7\" value=\"$default\" />\n";
}

function forms_time2($name, $default = '')
{
	echo "<select name=\"{$name}h\" size=\"1\"/>\n";
	for($i=1; $i<=12; $i++)
		echo "<option value=\"$i\">$i</option>";
	echo "</select>\n";
	echo "<select name=\"{$name}m\" size=\"1\"/>\n";
	for($i=0; $i<=55; $i+=5)
	{
		if($i<10)
			$i = '0' . $i;
		echo "<option value=\"$i\">$i</option>";
	}
	echo "</select>\n";
	echo "<select name=\"{$name}ampm\" size=\"1\"/>\n";
	echo "<option value=\"am\">am</option>";
	echo "<option value=\"pm\">pm</option>";
	echo "</select>\n";
}

function forms_phone($name, $default = '')
{
	echo "<input name=\"$name\" type=\"text\" id=\"phone\" size=\"10\" maxlength=\"10\" value=\"$default\" />\n";
}

function forms_capacity($name, $default = '')
{
	echo "<input name=\"$name\" type=\"text\" id=\"capacity\" size=\"3\" maxlength=\"3\" value=\"$default\" />\n";
}

function forms_decimal($name, $default = '', $size = 3)
{
	echo "<input name=\"$name\" type=\"text\" id=\"decimal\" size=\"$size\" maxlength=\"5\" value=\"$default\" />\n";
}

function forms_duration($name, $default = '')
{
	echo "<input name=\"$name\" type=\"text\" id=\"duration\" size=\"5\" maxlength=\"5\" value=\"$default\" />\n";
}

// helper to output the two most used POST inputs, action and redirect
function forms_hiddenInput($action, $redirect)
{
	echo "<input type=\"hidden\" name=\"action\" value=\"$action\" />\n";
	echo "<input type=\"hidden\" name=\"redirect\" value=\"$redirect\" />\n";
}

function forms_hidden($name, $value)
{
	echo "<input type=\"hidden\" name=\"$name\" value=\"$value\" />\n";
}

function forms_submit($value)
{
	echo "<input name=\"submit\" class=\"btn\" type=\"submit\" value=\"$value\" />\n";
}

?>
