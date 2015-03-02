<?php

include_once 'template.inc.php';

$action = $_POST['action'];
$class = $_SESSION['class'];

if ( isset($_POST['re-direct']) )
	$redirect=$_POST['re-direct'];
else if ( is_numeric($_POST['class_id']) )
	$redirect="index.php?term={$_POST['class_id']}";
else
	$redirect='index.php';

if($class != 'admin')
	show_note('You must be logged in as excomm to set up the term.');

function money_update_balance($class_id)
{
	$sql = 'SELECT moveto, SUM(amount) as credit, money_name FROM `moneymoves` '
		. ", money WHERE money_id=moveto AND money_class_id='$class_id'"
		. ' GROUP BY moveto';
		
	$credits = db_select($sql, "fix_balances.credits");
	$len = count($credits);
	
	$sql = 'SELECT movefrom, SUM(amount) as debit, money_name FROM `moneymoves` '
		. ", money WHERE money_id=movefrom AND money_class_id='$class_id'"
		. ' GROUP BY movefrom';
	$debits = db_select($sql, "fix_balances.debits");
	
	if (count($credits) > 0)
		//create the array of transactions for each accounts, starting with credits
		foreach ($credits as $transaction)
			$accounts[$transaction['moveto']] = array($transaction['moveto'], $transaction['credit']);
	
	if (count($debits) > 0)
		foreach ($debits as $transaction)
		{
			if (!isset($accounts[$transaction['movefrom']]))
				$accounts[$transaction['movefrom']] = array($transaction['movefrom'], 0);
			//set the account to credits - debits
			$accounts[$transaction['movefrom']][1] -= $transaction['debit'];
		}
	
	$sql = "UPDATE money SET money_balance = 0 WHERE money_class_id = '$class_id'";
	
	mysql_query($sql) or die('fix_balances.clear');
	
	if (count($accounts) > 0)
		foreach($accounts as $account)
		{
			$sql = "UPDATE money SET money_balance = '{$account[1]}' "
				. " WHERE money_id = '{$account[0]}' ";
			mysql_query($sql) or die('fix_balances.update');
		}
}


if($action == 'treasurers_copy_accounts')
{
	$sql = 'INSERT INTO money (`money_name`, `money_class_id`, `money_balance`)'
		. " SELECT money_name, {$_POST['copy_to']}, 0 FROM `money` WHERE money_class_id = {$_POST['copy_from']} AND "
		. " money_name NOT IN (SELECT money_name FROM money WHERE money_class_id = {$_POST['copy_to']})";
	
	mysql_query($sql) or die ("Could not copy treasury accounts from {$_POST['copy_from']} to {$_POST['copy_to']}.");
}
else if(isset($_POST['delete_account']))
{
	$account=$_POST['money_id'];
	$sql = "DELETE FROM moneymoves WHERE moveto='$account' OR movefrom='$account'";
	mysql_query($sql) or die ("Could not delete moves for account id '$account'.  " . mysql_error());
	
	$sql = "DELETE FROM money WHERE money_id='$account'";
	mysql_query($sql) or die ("Could not delete account id '$account'.  " . mysql_error());
	money_update_balance($_POST['money_class_id']);
}
/*//delete all accounts for a given class
else if($action == 'delete_all') //no interface for now; considered too volatile
{
	$class = $_POST['class_id'];
	$sql = "DELETE FROM moneymoves WHERE move_class_id='$class'";
	mysql_query($sql) or die ("Could not delete moves for class id '$class'.  " . mysql_error());
	
	$sql = "DELETE FROM money WHERE money_class_id='$class'";
	mysql_query($sql) or die ("Could not delete all accounts for class id '$class'.  " . mysql_error());
}*/
else if(isset($_POST['rename']))
{
	if (strlen($_POST['money_name']) == 0)
		show_note("The account name can't be blank.");
		
	$sql = "UPDATE money SET money_name='{$_POST['money_name']}' WHERE money_id='{$_POST['money_id']}'";
	mysql_query($sql) or die ("Could not rename account id '{$_POST['money_id']}'.  " . mysql_error());
	$redirect=$_POST['re-direct'] . '?work_on=' . $_POST['money_id'];
}
else if(isset($_POST['create']))
{
	$class = $_POST['class_id'];
	
	if (strlen($_POST['money_name']) == 0)
		show_note("The account name can't be blank.");
		
	//make sure that there isn't one with the same name already.
	$sql = 'SELECT * FROM money WHERE '
	. "money_name='{$_POST['money_name']}' AND money_class_id='{$_POST['class_id']}'";
	
	$result = db_select($sql, 'Couldn\'t check existing accounts.');
	if (count($result) == 0)
	{
		$sql = 'INSERT INTO money (money_name, money_balance, money_class_id) '
		. "VALUES ('{$_POST['money_name']}', '0.00', '{$_POST['class_id']}')";
		mysql_query($sql) or die ("Couldn't create account name '{$_POST['money_name']}'." . mysql_error());
	}
} ?>
<html>
<head>
<meta http-equiv="refresh" content="0;url=<?php echo $redirect ?>">
</head>
</html>
