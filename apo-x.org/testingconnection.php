<?php
$test Connection = mysql_connect(‘db.alluminati.org’, ‘alluminati’, ’b3aleader’);
if (!$testConnection) {
die('Error: ' . mysql_error());
}
echo 'Database connection working!';
mysql_close($testConnection);
?>
