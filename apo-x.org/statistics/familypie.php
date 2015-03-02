<?php
include ("../tools/jpgraph/src/jpgraph.php");
include ("../tools/jpgraph/src/jpgraph_pie.php");
include ("../tools/jpgraph/src/jpgraph_pie3d.php");

$data = array($_GET['r'],$_GET['g'],$_GET['b']);

$graph = new PieGraph(190,150,0.7);
$graph->SetAntialiasing();
$graph->SetFrame(false);

$p1 = new PiePlot3D($data);
$p1->SetSize(0.45);
$p1->SetLabelMargin(0);
$p1->SetSliceColors(array('red','green','blue'));

$graph->Add($p1);
$graph->Stroke();

?>
