<?php
include ("database.inc.php");
include ("../tools/jpgraph/src/jpgraph.php");
include ("../tools/jpgraph/src/jpgraph_bar.php");

// Open database
db_open();

// Get kills data
$sql = "SELECT codename, bounty, alive, hiding FROM assassins ORDER BY bounty DESC, alive DESC, codename ASC LIMIT 10";
$result = mysql_query($sql) or die(mysql_error());

$index = 0;
while($line = mysql_fetch_assoc($result)) {
	if ($line['alive'])
		if($line['hiding'])
			$names[$index] = "Someone";
		else $names[$index] = $line['codename'];
	else $names[$index] = $line['codename']." (Dead)";
	$kills[$index] = $line['bounty'];
	$index++;
}
mysql_free_result($result);

// Create the graph. These two calls are always required
$graph = new Graph(600,250,"auto");	
$graph->SetScale("textlin");
$graph->xaxis->SetTickLabels($names);
$graph->xaxis->SetLabelAngle(90);
$graph->xaxis->SetLabelAlign('center','bottom'); 
$graph->xaxis->SetLabelMargin(-15); 
$graph->yaxis->SetLabelFormat('$%d'); 

// Create the bar plot
$bplot = new BarPlot($kills);

// Add bar plot to graph
$graph->Add($bplot);

// Display the graph
$graph->Stroke();
?>
