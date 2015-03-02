<?php 
include_once 'template.inc.php';
include_once 'assassins.php';

if(isset($_GET['id']))
	$user = $_GET['id'];
	
if(isset($_SESSION['id']))
	$id = $_SESSION['id'];

show_header(); 

?>
<table width="100%">
	<tr>
		<td class="heading" colspan="2">Current Assassins Statistics</td>
	</tr>
	<tr>
		<td colspan=2>
		<table width=100%>
			<tr>
				<th>Top 10 Deadliest Assassins</th>
			</tr>
			<tr>	
				<td align="center"><img src="deadly.php" /></td>
			</tr>
		</table>		
		</td>
	</tr>
	<tr>
		<td colspan=2>
		<table width=100%>
			<tr>
				<th>Top 10 Most Valuable Assassins</th>
			</tr>
			<tr>	
				<td align="center"><img src="value.php" /></td>
			</tr>
		</table>		
		</td>
	</tr>
	<tr>
		<td colspan=2>
		<table width=100%>
			<tr>
				<th>Top 10 Richest Assassins</th>
			</tr>
			<tr>	
				<td align="center"><img src="rich.php" /></td>
			</tr>
		</table>		
		</td>
	</tr>
	<tr>
		<td width=50%>
		<table width=100%>
			<tr>
				<th>Kills by Day of Week</th>
			</tr>
			<tr>	
				<td align="center"><img src="week.php" /></td>
			</tr>
		</table>		
		</td>
		<td width=50%>
		<table width=100%>
			<tr>
				<th>Kills by Weapon</th>
			</tr>
			<tr>	
				<td align="center"><img src="weapon.php" /></td>
			</tr>
		</table>		
		</td>
	</tr>
	<tr>
		<td colspan=2>
		<table width=100%>
			<tr>
				<th>Kills by Time of Day</th>
			</tr>
			<tr>	
				<td align="center"><img src="day.php" /></td>
			</tr>
		</table>		
		</td>
	</tr>
	<tr>
		<td width=50%>
		<table width=100%>
			<tr>
				<th>Chance of Multiple Killers</th>
			</tr>
			<tr>	
				<td align="center"><img src="hunted.php" /></td>
			</tr>
		</table>		
		</td>
		<td width=50%>
		<table width=100%>
			<tr>
				<th>Hours Between Kills</th>
			</tr>
			<tr>	
				<td align="center"><img src="between.php" /></td>
			</tr>
		</table>		
		</td>
	</tr>
	<tr>
		<td colspan=2><a href="index.php">Click here to go back to the main page.</a><?php if(is_playing($id)) { ?> <a href="player.php">Click here for your mission info.</a><?php } ?></td>
	</tr>
</table>
<?php

show_footer(); 
 
?> 

