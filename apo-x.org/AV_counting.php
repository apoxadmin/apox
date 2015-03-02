<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title>AV Counting</title>
</head>

<body>
<font size ='5'><b><u>Excomm Vote Counting:</u></b>
<br />

<?php
	if(isset($_POST['1_1']))	
	{
		$sumvotes = 0;
		$Avotes = 0;
		$Bvotes = 0;
		$Cvotes = 0;

		for($i=1; $i <= 150; $i++)
		{
			$current = $i.'_1';
			$vote = $_POST[$current];
			
			if($vote == 0)
			{
				$Avotes++;
				$sumvotes++;
			}
			elseif($vote == 1)
			{
				$Bvotes++;	
				$sumvotes++;				
			}
			elseif($vote == 2)
			{
				$Cvotes++;	
				$sumvotes++;				
			}

		}//iterate through rows
		$Apercent = $Avotes/$sumvotes;
		$Bpercent = $Bvotes/$sumvotes;
		$Cpercent = $Cvotes/$sumvotes;
		
		if($Apercent > 0.5)
			echo 'A won';
		elseif($Bpercent > 0.5)
			echo 'B won';
		elseif($Cpercent > 0.5)
			echo 'C won';

		else
		{
			$drop = min($Avotes, $Bvotes, $Cvotes);
			if($drop == $Avotes)
			{
				$lowest = 'A';
				$lowest_index = 0;
			}
			if($drop == $Bvotes)
			{
				$lowest = 'B';
				$lowest_index = 1;
			}
			if($drop == $Cvotes)
			{
				$lowest = 'C';
				$lowest_index = 2;
			}

			echo 'Moving on to first runoff round: dropping '.$lowest;
			echo '<br />';
			runoff($lowest_index);
		}// no one won first round
		
	}//first round
	
function runoff($index)
{
		$sumvotes = 0;
		$Avotes = 0;
		$Bvotes = 0;
		$Cvotes = 0;
		for($i=1; $i <= 150; $i++)
		{
			$current = $i.'_1';
			$vote = $_POST[$current];
			if($vote == $index)
			{
				$current = $i.'_2';
				$vote = $_POST[$current];
			}//if dropped candidate
			
			if($vote == 0)
			{
				$Avotes++;
				$sumvotes++;
			}
			elseif($vote == 1)
			{
				$Bvotes++;	
				$sumvotes++;				
			}
			elseif($vote == 2)
			{
				$Cvotes++;	
				$sumvotes++;				
			}

		}//iterate through rows
		$Apercent = $Avotes/$sumvotes;
		$Bpercent = $Bvotes/$sumvotes;
		$Cpercent = $Cvotes/$sumvotes;
		
		if($Apercent > 0.5)
			echo 'A won';
		elseif($Bpercent > 0.5)
			echo 'B won';
		elseif($Cpercent > 0.5)
			echo 'C won';

}//runoff function
?>

<br />
<form name ="vote" method="post" action="">
<table border=0>
<tr>
	<th> First Choice </th>
	<th> Second Choice </th>
	<th> Third Choice </th>
</tr>
<?php
	$array = array('A','B','C');
	for($i=1; $i <= 150; $i++) //i = rows
	{
		echo "<tr>";
		for($j=1; $j <= 3; $j++) //j = columns
		{
			echo "<td>";
			$html = '<select name="'.$i.'_'.$j.'">';
			$html .= '<option value="100"></option>';
			foreach ($array as $key=>$value) {
				$html .= '<option value='.$key.'>'.$value.'</option>';
			}// for each
			$html .= '</select>';
			echo $html;
			echo "</td>";
		}// fill up row with 3 columns
		echo "</tr>";
	}//make 100 rows
?>
</table>
<input type='submit' />
</form>



</body>

</html>