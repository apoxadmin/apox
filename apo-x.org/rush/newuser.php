<?php

include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/forms.inc.php';

get_header();

if($_SESSION['class'] == 'admin'||
	$_SESSION['class'] == 'membership' ||
	$_SESSION['class'] == 'WAC' ||
	$_SESSION['class'] == 'pledge parents'):

$currentterm = db_currentClass('start');
?>

<form method="post" action="input.php">
		<label> Name: </td><td> <input type="text" name="name" required><br /> </label>
		<sub>(e.g. John Smith)</sub><br />
	       <label> Address: </td><td><input type="text" name="address" required ><br /> </label>
		<sub>(e.g. One Shields Avenue)</sub><br />
		<label> Phone Number: </td><td><input type="text" name="phone" pattern='\d{3}\d{3}\d{4}'/><br /> </label>
		<sub>(e.g. 5556667777)</sub><br />
		<label> Email: </td><td><input type="text" name="email" required ><br /> </label>
		<sub>(e.g. user@sample.com)</sub><br />
		<label> Password: </td><td><input type="password" name="password" required><br /> </label>
		<sub>(Your password must be at least 8 characters in length)</sub><br />
		<label> Repeat Password: </td><td><input type="password" name="password2" required><br /> </label>
		<input type="submit" /> 
</form>

<?php
else:
	echo 'You don\'t have permission to do that!';
endif;

 show_footer(); ?>
