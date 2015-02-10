<?php 
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) .'/include/show.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

get_header();

if(!$_SESSION['class'])
	show_note('You must be logged in to access this page.');

?>
<div class="general">
<h3>What type of tracking totals are you looking for?</h3>
<a href="/tracking/leadership/totals.php">Leadership</a><br/>
<a href="/tracking/fellowship/totals.php">Fellowship</a><br/>
<a href="/tracking/service/totals.php">Service</a><br/>
<a href="/tracking/meeting/totals.php">Meetings</a><br/>
<a href="/tracking/caw/totals.php">Coho/Academic/Workout Hours</a><br/>
<a href="/tracking/ic/totals.php">IC</a><br/>
<a href="/tracking/comms.php">Committees & Dues</a><br/>
<a href="/tracking/usertotals.php">Total Users</a><br/>
<a href="/tracking/usersuperall.php">Complete Users (doesn't show in roster)</a><br/>
<!-- <a href="/tracking/pictures.php">Pictures</a><br/> -->
</div>

<?php
show_footer();
?>
