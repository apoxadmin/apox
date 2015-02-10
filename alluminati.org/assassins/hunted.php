<?php
include ("database.inc.php");
include ("../tools/jpgraph/src/jpgraph.php");
include ("../tools/jpgraph/src/jpgraph_bar.php");

// Open database
db_open();

// Get kills data
$sql = "SELECT COUNT(user_id) FROM assassins WHERE alive=1 GROUP BY current_target";
$result = mysql_query($sql) or die(mysql_error());

$huntTable = array();
while($line = mysql_fetch_assoc($result))
	array_push($huntTable,$line);
mysql_free_result($result);

$huntTable2[0] = 0;
$huntTable2[1] = 0;
$huntTable2[2] = 0;
foreach($huntTable as $hunted)
{
	switch($hunted['COUNT(user_id)'])
	{
		case 1:
			$huntTable2[0]++;
			break;
		case 2:
			$huntTable2[1]++;
			break;
		default:
			$huntTable2[2]++;
			break;
	}
}
$total = $huntTable2[0] + $huntTable2[1] + $huntTable2[2];
$huntTable2[0] = round(($huntTable2[0] / $total) * 100);
$huntTable2[1] = round(($huntTable2[1] / $total) * 100);
$huntTable2[2] = round(($huntTable2[2] / $total) * 100);
$names[0] = "1";
$names[1] = "2";
$names[2] = "3+";

// Create the graph. These two calls are always required
$graph = new Graph(400,250,"auto");	
$graph->SetScale("textlin");
$graph->xaxis->SetTickLabels($names);
$graph->yaxis->SetLabelFormat('%2.0f%%'); 

// Create the bar plot
$bplot = new BarPlot($huntTable2);
$bplot->value->SetFormat('%2.0f%%');
$bplot->value->Show();

// Add bar plot to graph
$graph->Add($bplot);

// Display the graph
$graph->Stroke();
?>
