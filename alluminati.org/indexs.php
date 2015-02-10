

<html>
<head>
<meta http-equiv="Refresh" content="0; url=home.php">
</head>
<body>
<?php
if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') 
|| strstr($_SERVER['HTTP_USER_AGENT'],'iPod')) 

{ 

  header('Location:/mobile');

  exit();

}
?>
</body>
</html>
