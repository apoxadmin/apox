<?php
include ("database.inc.php");
include ("../tools/jpgraph/src/jpgraph.php");
include ("../tools/jpgraph/src/jpgraph_bar.php");

// Open database
db_open();

// Get kills data
$sql = "SELECT DATE_FORMAT(obit_time, '%H') as hour, COUNT(obit_id) as numkills FROM assassins_obits GROUP BY DATE_FORMAT(obit_time, '%H') ORDER BY DATE_FORMAT(obit_time, '%H') ASC";
$result = mysql_query($sql) or die(mysql_error());

$index = 0;
$tkills = 0;
while($line = mysql_fetch_assoc($result)) {
	$names[$index] = $line['hour'];
	$kills[$index] = $line['numkills'];
	$tkills += $line['numkills'];
	$index++;
}
mysql_free_result($result);

$index = 0;
for($i = 0; $i < 24; $i++)
{
	$names2[$i] = $i;
	if($names[$index] == $i)
	{
		$kills2[$i] = round(($kills[$index] / $tkills) * 100);
		$index++;
	}
	else $kills2[$i] = 0;
}

// Create the graph. These two calls are always required
$graph = new Graph(400,250,"auto");	
$graph->SetScale("textlin");
$graph->xaxis->SetTickLabels($names2);

// Create the bar plot
$bplot = new BarPlot($kills2);
$bplot->value->SetFormat('%2.0f%%');
$bplot->value->Show();

// Add bar plot to graph
$graph->Add($bplot);

// Display the graph
$graph->Stroke();
?>
