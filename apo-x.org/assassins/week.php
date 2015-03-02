<?php
include ("database.inc.php");
include ("../tools/jpgraph/src/jpgraph.php");
include ("../tools/jpgraph/src/jpgraph_bar.php");

// Open database
db_open();

// Get kills data
$sql = "SELECT DATE_FORMAT(obit_time, '%a') as day, COUNT(obit_id) as numkills FROM assassins_obits GROUP BY DATE_FORMAT(obit_time, '%a') ORDER BY DATE_FORMAT(obit_time, '%w') ASC";
$result = mysql_query($sql) or die(mysql_error());

$index = 0;
$tkills = 0;
while($line = mysql_fetch_assoc($result)) {
	$names[$index] = $line['day'];
	$kills[$index] = $line['numkills'];
	$tkills += $line['numkills'];
	$index++;
}
mysql_free_result($result);

// Change values to percentages
$index--;
while($index) {
	$kills[$index] = round(($kills[$index] / $tkills) * 100);
	$index--;
}

// Create the graph. These two calls are always required
$graph = new Graph(400,250,"auto");	
$graph->SetScale("textlin");
$graph->xaxis->SetTickLabels($names);

// Create the bar plot
$bplot = new BarPlot($kills);
$bplot->value->SetFormat('%2.0f%%');
$bplot->value->Show();

// Add bar plot to graph
$graph->Add($bplot);

// Display the graph
$graph->Stroke();
?>
