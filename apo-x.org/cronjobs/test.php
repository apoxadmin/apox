<?php

// Test email

	// Add include path, needed in cronjobs because it uses a different php.ini which doesn't have our include folder
	$path = '/iotaphi/iotaphi.org/include';
	set_include_path(get_include_path() . PATH_SEPARATOR . $path);

	$email = 'isaacliao@gmail.com';
	$subject = 'Test Email';
    $message = 'Hellos! Here, have a <a href="google.com">link</a>!';
    $headers  = 'From: The Chi Robot <admin@apo-x.org>' . "\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    mail($email, $subject, $message, $headers);
	echo "Sent email!\n";
	//echo ini_set('doc_root', '/home/iotaphi/iotaphi.org/include');
	//echo get_cfg_var('cfg_file_path');
	//echo get_include_path();
	//print_r($_SERVER);
?>