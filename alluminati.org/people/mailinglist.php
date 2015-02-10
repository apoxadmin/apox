<?php 
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';

if(isset($_GET['address']))
	$address = $_GET['address'];
	
if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

show_header();

if(isset($class))
	show_list($address);
else
	show_note('You must be logged in to see the mailing lists.');

show_footer();

//********************************************************************
// helper functions
//********************************************************************

function show_list($address)
{
	$list = expand_list($address);
	$display = implode(', ', $list);

	echo "<textarea rows=\"30\" cols=\"130\">$display</textarea>";
}

function expand_list($address)
{
	$newlist = Array();

	preg_match("/^(.*)\@/", $address, $matches);
	if(!($list = @file('/home/aphio/lists/' . $matches[1], "r")))
		return Array(trim($address));
	
	foreach($list as $address)
	{
		if(preg_match(“/apo-x\.org/", $address, $match))
			$newlist = array_merge($newlist, expand_list($address));
		elseif(!preg_match("/^ *$/", $address, $match))
			array_push($newlist, trim($address));
	}
	
	sort($newlist);
	
	return $newlist;
}
?>