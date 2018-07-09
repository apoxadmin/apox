<?php

include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';

$new_pass = md5($_POST['password']);
$new_pass2 = md5($_POST['password2']);

$sql = "SELECT class_id FROM class ORDER BY class_id DESC";
$returned = db_select1($sql);
$class_id = $returned['class_id'];
$email = $_POST['email'];


if($new_pass != $new_pass2)
{
	echo "Your password's do not match. <br/>";
	echo "<a href='newuser.php'>Back to Registration</a>";
	exit;
} //if passwords aren't the same

if(!filter_var( $email, FILTER_VALIDATE_EMAIL )){

	echo "Invalid email detected, please input a valid email.";
	echo "<a href='newuser.php'>Back to Registration</a>";
	exit;
}//if email not valid

$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$currentterm = db_currentClass('start');
$status_id = 1;
$sql = "INSERT INTO user (user_password, user_name, user_address, user_cell, user_email, class_id, style_id, status_id) VALUES ('$new_pass', '$name', '$address', '$phone', '$email','$class_id', 6, '$status_id')";

mysql_query($sql) or die('Could not add user.'.mysql_error());

header("Location:/rush/newuser.php");
?>


//$result = filter_var( 'bob@example.com', FILTER_VALIDATE_EMAIL );