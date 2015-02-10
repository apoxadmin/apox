<?php 
include_once 'template.inc.php';
include_once 'sql.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

get_header(); 

if(isset($_SESSION['id']))
	$user = $_SESSION['id'];
else
	show_note('You are not logged in.');
	
?><div class="general" style="padding: 0px">
<div class="general boxtop"><span class="big">Current Member Statistics</span></div><br/>
<div class="general" style="border-width: 0px;">
These are the top 10 actives and pledges in various categories. 
All information is based on current tracking.<br/><br/>
 
<div class="notice" style="display:table;">
<?php

$most = stats_service();

echo '<div style="float: left; margin: 5px;"><table style="width: 200px" cellspacing="1">';
echo '<tr><td colspan="3" class="heading">Most Service Hours</td></tr>';
echo '<tr><th>Rank</th><th>Name</th><th>Hours</th></tr>';

$rank = 0;
foreach($most as $person)
{
	$rank++;
	
	echo '<tr>';
	echo "<td>$rank</td>";
	echo "<td><span title=\"{$person['class_nick']} Class\">{$person['name']}</span></td>";
	echo "<td>{$person['hours']}</td>";
	echo '</tr>';
}
echo '</table></div>';

$most = stats_events();

echo '<div style="float: left; margin: 5px;"><table style="width: 200px" cellspacing="1">';
echo '<tr><td colspan="3" class="heading">Most Total Events</td></tr>';
echo '<tr><th>Rank</th><th>Name</th><th>Events</th></tr>';

$rank = 0;
foreach($most as $person)
{
	$rank++;
	
	echo '<tr>';
	echo "<td>$rank</td>";
	echo "<td><span title=\"{$person['class_nick']} Class\">{$person['name']}</span></td>";
	echo "<td>{$person['events']}</td>";
	echo '</tr>';
}
echo '</table></div>';


$most = stats_fellowships();

echo '<div style="float: left; margin: 5px;"><table style="width: 200px" cellspacing="1">';
echo '<tr><td colspan="3" class="heading">Most Fellowships</td></tr>';
echo '<tr><th>Rank</th><th>Name</th><th>Events</th></tr>';

$rank = 0;
foreach($most as $person)
{
	$rank++;
	
	echo '<tr>';
	echo "<td>$rank</td>";
	echo "<td><span title=\"{$person['class_nick']} Class\">{$person['name']}</span></td>";
	echo "<td>{$person['events']}</td>";
	echo '</tr>';
}
echo '</table></div>';


$most = stats_chaired();

echo '<div style="float: left; margin: 5px;"><table style="width: 200px" cellspacing="1">';
echo '<tr><td colspan="3" class="heading">Most Chaired Events</td></tr>';
echo '<tr><th>Rank</th><th>Name</th><th>Events</th></tr>';

$rank = 0;
foreach($most as $person)
{
	$rank++;
	
	echo '<tr>';
	echo "<td>$rank</td>";
	echo "<td><span title=\"{$person['class_nick']} Class\">{$person['name']}</span></td>";
	echo "<td>{$person['events']}</td>";
	echo '</tr>';
}
echo '</table></div>';


$most = stats_caw();

echo '<div style="float: left; margin: 5px;"><table style="width: 200px" cellspacing="1">';
echo '<tr><td colspan="3" class="heading">Most CAW Hours</td></tr>';
echo '<tr><th>Rank</th><th>Name</th><th>Hours</th></tr>';

$rank = 0;
foreach($most as $person)
{
	$rank++;
	
	echo '<tr>';
	echo "<td>$rank</td>";
	echo "<td><span title=\"{$person['class_nick']} Class\">{$person['name']}</span></td>";
	echo "<td>{$person['hours']}</td>";
	echo '</tr>';
}
echo '</table></div>';


$most = stats_ic();

echo '<div style="float: left; margin: 5px;"><table style="width: 200px" cellspacing="1">';
echo '<tr><td colspan="3" class="heading">Most IC Events</td></tr>';
echo '<tr><th>Rank</th><th>Name</th><th>Events</th></tr>';

$rank = 0;
foreach($most as $person)
{
	$rank++;
	
	echo '<tr>';
	echo "<td>$rank</td>";
	echo "<td><span title=\"{$person['class_nick']} Class\">{$person['name']}</span></td>";
	echo "<td>{$person['events']}</td>";
	echo '</tr>';
}
echo '</table></div>';


?></div></div></div>
<?php

show_footer(); 
 
?> 

