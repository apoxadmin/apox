<?php
include_once 'template.inc.php';
include_once 'assassins.php';

$id = $_SESSION['id'];
$action = $_POST['action'];
$redirect = $_POST['redirect'];
// permissions?
// action = event_add, event_update

if(assassins_admin($id))
{
	if($action=='adduser')
	{
		if(isset($_POST['user'],$_POST['codename']))
			add_user($_POST['user'],$_POST['codename']);
	}	
	if($action=='chuser')
	{
		if(isset($_POST['user'],$_POST['bounty'],$_POST['bank'],$_POST['kill']))
			ch_user($_POST['user'],$_POST['bounty'],$_POST['bank'],$_POST['kill']);
	}		
	if($action=='chtarget')
	{
		if(isset($_POST['user']))
			rand_target($_POST['user']);
	}		
	if($action=='unkill')
	{
		if(isset($_POST['kill']))
			if($_POST['kill'] != "none")
				undo_kill($_POST['kill']);
	}		
	if($action=='addobit')
	{
		if(isset($_POST['kill'],$_POST['story']))
			add_obit($_POST['kill'],$_POST['story']);
	}
	if($action=='startgame')
	{
		startgame();
	}
	if($action=='reset_game'){
		reset_game();
	}
	if($action=='nightly')
	{
		nightly();
	}	
}
if(is_playing($id)) {
	if($action=='reportkill') {
		if(isset($_POST['code'])) {
			if($_POST['code'] != 'Kill Code') {
				check_kill($_POST['code']);
			}
		}
	}
}

?>
<HTML>
<HEAD>
<meta http-equiv="refresh" content="0;url=<?php echo $redirect; ?>">
</HEAD>
</HTML>
