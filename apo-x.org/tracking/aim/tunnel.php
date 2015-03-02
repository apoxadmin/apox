<?php

if(strpos($_SERVER['HTTP_USER_AGENT'],'AIM/30') === false)
	die('You must be using AIM to access tracking.');

// get everything after the url in the request
$serv_prot = getenv('SERVER_PROTOCOL');
// get rid of the http/x.x part of it
$sans_protocol = str_replace(array(' HTTP/1.0', ' HTTP/1.1'), '', $serv_prot);
// set nick to nick from query string + space + $sans_protocol from above
$sn = $_GET['sn'] . " " . $sans_protocol;
$sn = str_replace(' ','',$sn);
$sn = substr($sn, strpos($sn, '=')+1); 

/*$handle = fsockopen("localhost", 80, $errno, $errstr, 10);
if (!$handle) 
{
	echo "$errstr ($errno)<br/>\n";
	exit();
} 
else {
	$out = "GET /tracking/service/aim.php?sn=$sn HTTP/1.1\r\n";
	$out .= "Host: localhost\r\n";
	$out .= "User-Agent: Jane\r\n";
	$out .= "Connection: Close\r\n\r\n";
	fwrite($handle, $out);
}*/

$handle = fopen("http://localhost/tracking/service/aim.php?sn=$sn", "r");
while (!feof($handle)) {
   $buffer = fgets($handle);
   echo $buffer;
}
fclose($handle);

?> 

