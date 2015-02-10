<?php 
include_once 'template.inc.php';
include_once 'sql.php';

show_header(); 

?>
<ul style="padding: 0px; margin: 0px; float: left; width: 100%; border: 0px; display: block;">
<li class="general tab" style="float: left;"><span class="big"><a href="/statistics/index.php">Member Statistics</a></span></li>
<li class="general tab" style="float: left;"><span class="big"><a href="/statistics/family.php">Family Statistics</a></span></li>
</ul>
<div class="general" style="padding: 0px; margin: 0px; float: left;">
<div class="general boxtop"><span class="big">Current Family Statistics</span></div><br/>
<div class="general" style="border-width: 0px;">
These are graphs of the totals for each family. All information is based
 on current tracking.<br/><br/>
 
<div id="user" class="notice" style="height: 600px;">
<?php

/*$most = stats_family_capita();
$r = $most[0]['events'];
$g = $most[1]['events'];
$b = $most[2]['events'];*/

$most = stats_family_events();
$r = $most[0]['events'];
$g = $most[1]['events'];
$b = $most[2]['events'];

echo '<div style="float: left; margin: 5px;"><table style="width: 150px" cellspacing="1">';
echo '<tr><td class="heading">Most Total Events</td></tr><tr><td>';
echo "<img src=\"/statistics/familypie.php?r=$r&g=$g&b=$b\">";
echo '</td></tr></table></div>';


$most = stats_family_service();
$r = $most[0]['hours'];
$g = $most[1]['hours'];
$b = $most[2]['hours'];

echo '<div style="float: left; margin: 5px;"><table style="width: 150px" cellspacing="1">';
echo '<tr><td class="heading">Most Service Hours</td></tr><tr><td>';
echo "<img src=\"/statistics/familypie.php?r=$r&g=$g&b=$b\">";
echo '</td></tr></table></div>';


$most = stats_family_fellowship();
$r = $most[0]['events'];
$g = $most[1]['events'];
$b = $most[2]['events'];

echo '<div style="float: left; margin: 5px;"><table style="width: 150px" cellspacing="1">';
echo '<tr><td class="heading">Most Fellowships</td></tr><tr><td>';
echo "<img src=\"/statistics/familypie.php?r=$r&g=$g&b=$b\">";
echo '</td></tr></table></div>';


$most = stats_family_chaired();
$r = $most[0]['events'];
$g = $most[1]['events'];
$b = $most[2]['events'];

echo '<div style="float: left; margin: 5px;"><table style="width: 150px" cellspacing="1">';
echo '<tr><td class="heading">Most Chaired Events</td></tr><tr><td>';
echo "<img src=\"/statistics/familypie.php?r=$r&g=$g&b=$b\">";
echo '</td></tr></table></div>';


$most = stats_family_caw();
$r = $most[0]['hours'];
$g = $most[1]['hours'];
$b = $most[2]['hours'];

echo '<div style="float: left; margin: 5px;"><table style="width: 150px" cellspacing="1">';
echo '<tr><td class="heading">Most CAW Hours</td></tr><tr><td>';
echo "<img src=\"/statistics/familypie.php?r=$r&g=$g&b=$b\">";
echo '</td></tr></table></div>';


$most = stats_family_ic();
$r = $most[0]['events'];
$g = $most[1]['events'];
$b = $most[2]['events'];

echo '<div style="float: left; margin: 5px;"><table style="width: 150px" cellspacing="1">';
echo '<tr><td class="heading">Most IC Events</td></tr><tr><td>';
echo "<img src=\"/statistics/familypie.php?r=$r&g=$g&b=$b\">";
echo '</td></tr></table></div>';


$most = stats_family_forum();
$r = $most[0]['posts'];
$g = $most[1]['posts'];
$b = $most[2]['posts'];

echo '<div style="float: left; margin: 5px;"><table style="width: 150px" cellspacing="1">';
echo '<tr><td class="heading">Most Forum Posts</td></tr><tr><td>';
echo "<img src=\"/statistics/familypie.php?r=$r&g=$g&b=$b\">";
echo '</td></tr></table></div>';

?></div></div></div>
<?php

show_footer(); 
 
?> 

