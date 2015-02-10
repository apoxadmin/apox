<?php
include ("database.inc.php");
include ("../tools/jpgraph/src/jpgraph.php");
include ("../tools/jpgraph/src/jpgraph_bar.php");

// Open database
db_open();

// Get kills data
$sql = "SELECT codename, numkills, alive FROM assassins ORDER BY numkills DESC, alive DESC, codename ASC LIMIT 3";
$result = mysql_query($sql) or die(mysql_error());

$index = 0;
while($line = mysql_fetch_assoc($result)) {
	if ($line['alive'])
		$names[$index] = $line['codename'];
	else $names[$index] = $line['codename']." (Dead)";
	$kills[$index] = $line['numkills'];
	$index++;
}
mysql_free_result($result);

// Create the graph. These two calls are always required
$graph = new Graph(400,250,"auto");	
$graph->SetScale("textlin");
$graph->xaxis->SetTickLabels($names);
$graph->xaxis->SetLabelAngle(90);
$graph->xaxis->SetLabelAlign('center','bottom'); 
$graph->xaxis->SetLabelMargin(-15); 

// Create the bar plot
$bplot = new BarPlot($kills);

// Add bar plot to graph
$graph->Add($bplot);

// Display the graph
$graph->Stroke();
?>
