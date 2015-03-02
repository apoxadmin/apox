<?php 
include_once 'template.inc.php';
include_once 'show.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
get_header();

if($_SESSION['class'] != 'admin')
{
	show_note('You must be logged in as excomm to access this page.');
	show_footer();
	exit();
}

?>
<div class="general">
<h3>Office Configuration Pages:</h3>
<!--<a href="pledgeparents/index.php">Pledge Parents</a><br/>-->
<a href="recsecs/index.php">Recording Secretaries</a><br/>
<a href="treasurers/index.php">Finance</a><br/>
</div>

<?php
show_footer();
?>
