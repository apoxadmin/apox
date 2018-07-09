<?php 
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/show.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

get_header();

if(!$_SESSION['class'])
{
	show_note('You must be logged in to access this page.');
	show_footer();
	exit();
}

?>
<div class="page-header">
  <h1>Tracking<small> What type of events are you tracking?</small></h1>
</div>
<div class="btn-group">
  <a href="/tracking/leadership/event.php"><button class="btn">Leadership</button></a>
  <a href="/tracking/fellowship/event.php"><button class="btn">Fellowship</button></a>
  <a href="/tracking/service/event.php"><button class="btn">Service</button></a>
  <a href="/tracking/meeting/event.php"><button class="btn">Meetings</button></a>
  <a href="/tracking/caw/event.php"><button class="btn">Fundraiser</button></a>
  <a href="/tracking/ic/event.php"><button class="btn">IC</button></a>
  <a href="/tracking/comms.php"><button class="btn">Committee Tracking</button></a>
  <!--<a href="/tracking/pictures.php"><button class="btn">Picture Tracking</button></a>-->
</div>

<?php
show_footer();
?>
