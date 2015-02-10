<?php
include_once 'template.inc.php';
include_once 'assassins.php';	

if(isset($_GET['id']))
	$event = $_GET['id'];
	
if(isset($_SESSION['id'])) {
	$id = $_SESSION['id'];
	
if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

show_header();

if(assassins_admin($id)){ ?>
	<table width=100%>
	<?php $playerlist = get_player_list(); ?>
		<tr>
			<td colspan=9 class="heading">Current Stats</td>
		</tr>
		<tr>
			<th>Name</th>
			<th>Codename</th>
			<th>Alive?</th>
			<th>Kills</th>
			<th>Target</th>
		</tr>
	<?php	foreach($playerlist as $ass) { ?>
		<tr>
			<td><?php echo $ass['realname']; ?></td>
			<td><?php echo $ass['codename']; ?></td>
			<td><?php if($ass['alive']) {echo "Alive";}
				else {echo "Dead";} ?></td>
			<td><?php echo $ass['numkills']; ?></td>
			<td><?php if($ass['alive']) {echo target_name($ass['current_target']); } ?></td>
		</tr>
	<?php } ?>
	</table>
	<form action="input.php" method="POST">
		<input type="hidden" name="action" value="adduser" />
		<input type="hidden" name="redirect" value="admin.php" />
		<table>		
			<tr><td colspan="3" class="heading">Add Player</td></tr>
			<tr><td><select name="user">
				<option value="none">Select a player...</option>
				<?php
				foreach(users_get() as $u)
				{
					if(!is_playing($u['user_id']))
						echo "<option value=\"{$u['user_id']}\">{$u['name']}</option>\n";
				} ?>
				</select></td>
			<td><input type="text"  name="codename" value="Codename"/></td>
			<td><input type="submit" value="Add Player" /></td></tr>
		</table></form>
	<form action="input.php" method="POST">
		<input type="hidden" name="action" value="chuser" />
		<input type="hidden" name="redirect" value="admin.php" />
		<table>		
			<tr><td colspan="5" class="heading">Change Player</td></tr>
			<tr><td><select name="user">
				<option value="none">Select a player...</option>
				<?php
				foreach(get_player_list() as $p)
					echo "<option value=\"{$p['user_id']}\">{$p['realname']}</option>\n";
				?>
				</select></td>
			<td><select name="kill">
				<option value="none">Kill User?</option>
				<option value="1">Kill</option>
				</select></td>
			<td><input type="submit" value="Change Player" /></td></tr>
		</table></form>
	<form action="input.php" method="POST">
		<input type="hidden" name="action" value="chtarget" />
		<input type="hidden" name="redirect" value="admin.php" />
		<table>		
			<tr><td colspan="3" class="heading">Change Target</td></tr>
			<tr><td><select name="user">
				<option value="none">Select a player...</option>
				<?php
				foreach(get_player_list() as $p)
					echo "<option value=\"{$p['user_id']}\">{$p['realname']}</option>\n";
				?>
				</select></td>
			<td><input type="submit" value="Change Target" /></td></tr>
		</table></form>
	<form action="input.php" method="POST">
		<input type="hidden" name="action" value="unkill" />
		<input type="hidden" name="redirect" value="admin.php" />
		<table>		
			<tr><td colspan="3" class="heading">Undo Kill</td></tr>
			<tr><td><select name="kill">
				<option value="none">Select a kill...</option>
				<?php
				foreach(get_deaths() as $k)
				{
					if($k['killer_id'] == 0)
						$killer_name = "God";
					else { $killer_name = get_player_info($k['killer_id']);
						$killer_name = $killer_name['codename']; }
					$killed_name = get_player_info($k['killed_id']);
						$killed_name = $killed_name['codename'];
					if($k['weapon_id'] != 5)
						echo "<option value=\"{$k['obit_id']}\">{$killer_name} killed {$killed_name}</option>\n";
					else echo "<option value=\"{$k['obit_id']}\">{$killer_name} revived {$killed_name}</option>\n";
				}
				?>
				</select></td></tr>
			<td><input type="submit" value="Undo Kill" /></td></tr>
		</table></form>
	<form action="input.php" method="POST">
		<input type="hidden" name="action" value="addobit" />
		<input type="hidden" name="redirect" value="admin.php" />
		<table>		
			<tr><td colspan="3" class="heading">Add Obituary</td></tr>
			<tr><td><select name="kill">
				<option value="none">Select a kill...</option>
				<?php
				foreach(get_deaths() as $k)
				{
					if($k['killer_id'] == 0)
						$killer_name = "God";
					else { $killer_name = get_player_info($k['killer_id']);
						$killer_name = $killer_name['codename']; }
					$killed_name = get_player_info($k['killed_id']);
						$killed_name = $killed_name['codename'];
					if($k['weapon_id'] != 5)
						echo "<option value=\"{$k['obit_id']}\">{$killer_name} killed {$killed_name}</option>\n";
					else echo "<option value=\"{$k['obit_id']}\">{$killer_name} revived {$killed_name}</option>\n";
				}
				?>
				</select></td></tr>
			<tr><td><textarea name="story" rows="5" cols="75"></textarea></td></tr>
			<td><input type="submit" value="Add Obituary" /></td></tr>
		</table></form>
	<form action="input.php" method="POST">
		<input type="hidden" name="action" value="startgame" />
		<input type="hidden" name="redirect" value="admin.php" />
		<table>
			<tr><td class="heading">Start Game</td></tr>
			<tr><td><input type="submit" value="Start" /></td></tr>
	</table></form>
	<form action="input.php" method="POST">
		<input type="hidden" name="action" value="reset_game" />
		<input type="hidden" name="redirect" value="admin.php" />
		<table>
			<tr><td class="heading">Reset all Data</td></tr>
			<tr><td><input type="submit" value="Reset" /></td></tr>
	</table></form>
	<table>
		<tr><th colspan=2>E-Mails</th></tr>
		<?php
			$playerlist = get_player_list();
			$alivelist = "";
			$deadlist = "";
			foreach($playerlist as $player) {
				$info = get_player_info($player['user_id']);
				if($info['alive']) { $alivelist .= $info['user_email'].', '; }
				else { $deadlist .= $info['user_email'].', '; }
			}
			?>
		<tr><td>Alive</td><td><?php echo $alivelist; ?></td></tr>
		<tr><td>Dead</td><td><?php echo $deadlist; ?></td></tr>
<?php }
else
	echo "You're not an admin.";

show_footer();	}

else
	show_note('You are not logged in.'); ?>
