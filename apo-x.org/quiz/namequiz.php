<?php 
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
get_header();

if(isset($_SESSION['id']))
	$user = $_SESSION['id'];
else
{
	print "You are not logged in.";
	show_footer();
	exit;
}

if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

// Seed random generator
mt_srand((double)microtime()*1000000);

// Get info from user db
function user_getname($id,$format)
{ 
	//ipfaeFcPCA
	$select = '';
	if(strstr($format,'i')!=false) $select .= '`user_id` AS id, ';
	if(strstr($format,'p')!=false) $select .= '`user_password` AS password, ';
	if(strstr($format,'f')!=false) $select .= '`user_name` AS name, ';
	if(strstr($format,'a')!=false) $select .= '`user_address` AS address, ';
	if(strstr($format,'e')!=false) $select .= '`user_email` AS email, ';
	if(strstr($format,'F')!=false) $select .= '`family_id` AS family, ';
	if(strstr($format,'c')!=false) $select .= '`class_id` AS class, ';
	if(strstr($format,'P')!=false) $select .= '`user_phone` AS phone, ';
	if(strstr($format,'C')!=false) $select .= '`user_cell` AS cell, ';
	if(strstr($format,'A')!=false) $select .= '`user_aim` AS aim, ';
	$select = trim($select,", ");
	
	$sql = 'SELECT ' . $select . ' FROM `user` WHERE `user_id` = \''. $id . '\'';
	$result = mysql_query($sql) or die("Query Failed!". mysql_error());
	$line = mysql_fetch_assoc($result);
	mysql_free_result($result);
	
	return $line;
}

// Get ID numbers and count
$count=0;
$ids=array();
?>

<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<script language="JavaScript" src="overlib.js"></script> 

<script language="JavaScript">
function autoSubmit()
{
    var formObject = document.forms['theForm'];
    formObject.submit();
}
</script>
<div class="page-header">
  <h1>Namequiz<small> (Hover over a picture for the clue. Click on it to see the name.)</small></h1>
</div>
<table class="table table-condensed table-bordered" >
<tr colspan="4">
<th>
<form name="theForm" method="POST"> 
    <select class="span2"name="pclass" onChange="autoSubmit();">        
        <option value="null"> Select Class</option>
        
        <?php        
        // Populate drop down menu with pledge classes
        $sql2 = "SELECT class_id, class_name FROM class ORDER BY class_year desc, class_term asc";
	$result2 = mysql_query($sql2) or die("Query Failed!". mysql_error());	
        while($row2 = mysql_fetch_array($result2))
        {        
            echo ("<option value=\"{$row2[0]}\">{$row2[1]}</option>");
        }
	mysql_free_result( $result2 );
	?>        
    </select>
</form></th></tr>

<?php
$sql = "SELECT user_id FROM `user` WHERE `class_id` = '{$_POST["pclass"]}' AND status_id NOT IN ("
	.STATUS_ADMINISTRATOR.','.STATUS_DEPLEDGE.')';
$result = mysql_query($sql) or die("Query Failed!". mysql_error());	
while( $row=mysql_fetch_row($result) )
{
	$ids[] = $row[0];
	$count++;
}
mysql_free_result( $result );

// Randomize table
$num = array();
$nbr = mt_rand(0,$count-1);
for($i=0; $i < $count; $i++) {

   while (in_array($nbr, $num)) {
       $nbr = mt_rand(0,$count-1);
   }

   $num[$i] = $nbr;
   $nbr = mt_rand(0,$count-1);
}
?>
</tr>
	<?php 
	$curCount=0;
	while($count-$curCount)
	{
		if($curCount%4==0)
			echo '<tr><td style="text-align:center">';
		else
			echo '<td style="text-align:center">';
		$name = user_getname($ids[$num[$curCount]], 'f');
		$sn = user_getname($ids[$num[$curCount]], 'A');
		echo '<a href="#" onclick="return overlib(\'',$name[name],'','','\', STICKY, CAPTION, \'Name\');" onmouseout="return nd();"><img class=\"profile" src="/images/profiles/', $ids[$num[$curCount]], '.jpg" title="', $sn[aim] ,'" border=0 width=160></a>';
		if($curCount%4==3)
			echo '</td></tr>';
		else
			echo '</td>';
		$curCount++;
	} 
	?>
</table>

<?php show_footer(); ?> 

