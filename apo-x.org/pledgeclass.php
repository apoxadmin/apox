<?php 
include_once 'include/template.inc.php';

get_header(); 

?>


<p><b>Pledge Classes</b></p>
<?php
/*
*	I got this code from a friend and was working on this so we could learn how PHP and MySQL interact on the site.
*	The idea is to automatically pull information from the class table rather than re-write the history
*	page every term.
*	We need to put Greek Letters and Namesakes columns in the database for this code to be useful.  I guess
*	we'll also need to make a historian page at config/historians/ as well, where they can write
*	this information for future terms.
*
*/
//First, we want to get class info from the database
//Second, we want to lay out the structure of the table
//Finally, we want to iterate through the class info to flesh out the table


$sql = "SELECT class_name, class_term, class_year, class_mascot, class_spokesperson " 
	. "FROM `class` ORDER BY class_year DESC, class_term ASC";

$result = db_select ($sql, 'OMG we died trying to get class info.  Carry on, sweet brother, carry on.' . mysql_error()  );
array_shift($result); // Remove first "question mark" class from results

?>
<table cellpadding="5" cellspacing="5">
<tr>
	<th>Namesake</th>
	<th>Term</th>
	<th>Class Mascot</th>
	<th>Class President</th>
</tr>


<?php

$i=0;
foreach ($result as $index => $term)
{
	echo "
	<tr";
		if ($i % 2  ==  0)	//alternate row colors
			echo ' class="waitlist"';
	echo ">
		<td>{$term['class_name']}</td>
		<td>{$term['class_term']} {$term['class_year']}</td>
		<td>     {$term['class_mascot']}</td>
		<td> {$term['class_spokesperson']}</td>
	</tr>
"	;
$i++;
}

?>