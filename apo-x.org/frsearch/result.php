<?php 
include_once 'database.inc.php';
include_once 'user.inc.php';
db_open();

if(isset($_POST['searchname']))
{
	$testname = strtolower($_POST['searchname']);
	$testname = str_replace(" ","",$testname);
	$testname = str_replace("%20","",$testname);

	$sql = "SELECT user_name AS name, user_password AS password, user_id AS id FROM user WHERE status_id=0 OR status_id=1 OR status_id=8 OR user_id=1520";
	$pledges = db_select($sql);
	foreach($pledges as $pledge)
	{
		$checkname = strtolower($pledge['name']);
		$checkname = str_replace(" ","",$checkname);

		if($checkname==$testname)
		{
			$pinfo = user_get($pledge['id'], 'fF');
		}
	}
}
	
	switch($pinfo['family'])
	{
		case 1:
			$pfamily = "TIGHT";
			break;
		case 2:
			$pfamily = "CLOSE";
			break;
		case 3:
			$pfamily = "LOOSE";
			break;
	}

switch($pinfo['family'])
	{
		case 1:
			$pfamilies = "red";
			break;
		case 2:
			$pfamilies = "Green";
			break;
		case 3:
			$pfamilies = "Blue";
			break;
	}
				
			
?>

<body style="background-color: <?php echo $pfamilies; ?>" >
<div>
<center><font style="color:white; font-size:100px;"> Welcome to <?php echo $pfamily; ?> family!<br/><img src="
<?php
	echo strtolower($pfamily);
	echo 5;
?>.png">
</br></font>
<font style="font-size:100px; color:white;">
 <?php echo $pinfo['name']; ?>
 </font>
</center>
</div>
</body>
</html>
<?php 
// close session first so we can close the db
session_write_close();
db_close();

?> 

