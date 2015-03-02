<?php 
include_once 'template.inc.php';
include_once 'assassins.php';

if(isset($_GET['id']))
	$user = $_GET['id'];
	
if(isset($_SESSION['id'])) {
	$id = $_SESSION['id'];
	
if(isset($_SESSION['class']))
	$class = $_SESSION['class'];

show_header();
$myID = $id;

?><div class="general">

<?php if(is_playing($myID)) { 
	$myInfo = get_player_info($myID);
	$myTarget = get_player_info($myInfo['current_target']); ?>
	
	<p>Welcome to Assassins, <?php echo $myInfo['user_name']; ?>!</p>
	<p> Your codename is "<?php echo $myInfo['codename']; ?>."  You have killed <?php echo $myInfo['numkills']; ?> others.</p>
	<?php if($myInfo['alive']) {  ?>
		<p>In the event of your death, give this codeword to your killer: "<?php echo $myInfo['killcode']; ?>".</p>

		<?php if($myInfo['current_target']) { ?>
			<table cellspacing="1">
				<tr>
					<td colspan="3" class="heading">Target Info</td>
				</tr>
				<tr>
					<td rowspan="7"><img src="/images/profiles/<?php echo $myTarget['user_id'] ?>.jpg" /></td>
					<td>Code Name: </td>
					<td><?php echo $myTarget['codename'] ?></td>
				</tr>
				<tr>
					<td>Real Name: </td>
					<td><?php echo $myTarget['user_name'] ?></td>
				</tr>
				<tr>
					<td>Address: </td>
					<td><?php echo htmlentities($myTarget['user_address']) ?></td>
				</tr>
				<tr>
					<td>Primary Phone: </td>
					<td><?php echo htmlentities($myTarget['user_cell']) ?></td>
				</tr>
				<tr>
					<td>Backup Phone: </td>
					<td><?php echo htmlentities($myTarget['user_phone']) ?></td>
				</tr>
				<tr>
					<td>Email: </td>
					<td><a href="mailto:<?php echo htmlentities($myTarget['user_email']) ?>"><?php echo htmlentities($myTarget['user_email']) ?></a></td>
				</tr>
				<tr>
					<td>AIM sn: </td>
					<td><img src="http://api.oscar.aol.com/SOA/key=PandorasBoxGoodUntilJan2006/presence/<?php echo htmlentities($myTarget['user_aim']) ?>" /><a href="aim:goim?screenname=<?php echo htmlentities($myTarget['user_aim']) ?>"><?php echo htmlentities($myTarget['user_aim']) ?></a></td>
				</tr>
			</table>
			<?php if(!before_start()) { ?>
				<form action="input.php" method="POST">
				<input type="hidden" name="action" value="reportkill" />
				<input type="hidden" name="redirect" value="player.php" />
				<table>		
					<tr><th colspan="3">Report Your Kill</th></tr>
					<tr><td><input type="text"  name="code" value="Codeword"/></td>
					<td><input type="submit" value="Check Kill" /></td></tr>
				</table></form>
			<?php }
		}
	}
	else { echo "<p>You've been killed.  Thanks for playing!  Best sure to submit kill stories and decorate your weapon for a chance to still win prizes!<p>"; }}

else {
	?><table cellspacing="1">
		<tr>
			<td>You're not playing.</td>
		</tr> <?php
	if (before_start()) {
		?><tr>
			<td>Would you like to sign up? Talk to Dinh!</td>
		</tr><?php
	} ?>
	</table> <?php
} ?>

<table><tr><td><a href="index.php">Click here to go back to the main page.</a></td></tr></table>

</div>

<?php show_footer(); }

else
	show_note('You are not logged in.'); ?>

