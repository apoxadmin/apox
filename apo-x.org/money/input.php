<?php

include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';

$action = $_POST['action'];
$class = $_SESSION['class'];

if ( isset($_POST['re-direct']) )
	$redirect=$_POST['re-direct'];
else if ( is_numeric($_POST['class_id']) )
	$redirect="index.php?term={$_POST['class_id']}";
else
	$redirect='index.php';

if($class != 'admin' && $class != 'finance')
	show_note('You must be logged in as excomm to edit transactions.');


//this gets the correct money_id and account name for the given class
//(if you select a different term from the default, the money_id is wrong)
function move_get_money_id($id, $class)
{
	$sql = "SELECT money_id, money_name FROM money WHERE money_class_id='$class' AND money_name= "
		. " (SELECT money_name FROM money WHERE money_id = '$id' LIMIT 1) LIMIT 1 ";
	$result = db_select1($sql, "move_get_money_id");
	return $result;
}

//picks the right money_id and validates the transaction
function move_verify ()
{
	$from = move_get_money_id($_POST['fromacct'], $_POST['class_id']);
	$to = move_get_money_id($_POST['toacct'], $_POST['class_id']);	
	$result = array('from' => $from['money_id'], 'to' => $to['money_id'],
		'from_name' => $from['money_name'], 'to_name' => $to['money_name']);

	if(!is_numeric($result['from']))
		show_note('You selected an invalid From Account.');
	if(!is_numeric($result['to']))
		show_note('You selected an invalid To Account.');
	if(!is_numeric($_POST['amount']))
		show_note('You entered an invalid amount.');
	if(abs($_POST['amount'])!=$_POST['amount'])
		show_note("You can't enter negative values.");
	if($_POST['memo']=="")
		show_note('You forgot to enter a memo.');
	if($result['from']==$result['to'])
		show_note("You can't transfer to the same account.");
	if(($result['from_name']=='(Fundraisers)' || 
	$result['from_name']=='(Deposits)')&& $result['to_name']!='General Fund')
		show_note("You must put new money into the General Fund.");
	if($result['from_name']=='General Fund' && $result['to_name']=='(Pay Outs)')
		show_note("You can't pay out directly from the General Fund.");
	if($result['to_name']=='(Fundraisers)')
		show_note("You can't pay to a fundraiser.");
	if($result['from_name']=='(Pay Outs)')
		show_note("You can't get money from a pay out.");
	
	return $result;
}

function move_update_balance($fromacct=NULL, $toacct=NULL)
{
	$sql = 'SELECT moveto, SUM(amount) as credit, money_name FROM `moneymoves` '
		. ', money WHERE money_id=moveto ';
		
		if ($fromacct!=NULL && $toacct!=NULL)
			$sql .= "AND (moveto='$fromacct' OR moveto='$toacct')";
		
		$sql .= ' GROUP BY moveto';
		
	$credits = db_select($sql, "fix_balances.credits");
	$len = count($credits);
	
	$sql = 'SELECT movefrom, SUM(amount) as debit, money_name FROM `moneymoves` '
		. ', money WHERE money_id=movefrom ';
		
		if ($fromacct!=NULL && $toacct!=NULL)
			$sql .= "AND (movefrom='$fromacct' OR movefrom='$toacct')";
		
		$sql .= ' GROUP BY movefrom';
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
	
	$sql = "UPDATE money SET money_balance = 0";
	if ($fromacct!=NULL && $toacct!=NULL)
		$sql .= " WHERE money_id IN('$fromacct', '$toacct')";
	
	mysql_query($sql) or die('fix_balances.clear');
	
	if (count($accounts) > 0)
		foreach($accounts as $account)
		{
			$sql = "UPDATE money SET money_balance = '{$account[1]}' "
				. " WHERE money_id = '{$account[0]}' ";
			mysql_query($sql) or die('fix_balances.update');
		}
}

if (isset ($_POST['delete']))
{
	if (isset($_POST['work_on']))
		$work_on = $_POST['work_on'];
		
	$sql = "DELETE FROM moneymoves WHERE moveid='$work_on' ";
	mysql_query($sql) or die('Could not delete transaction.');
		
	move_update_balance ($_POST['toacct'], $_POST['fromacct']);
}
else if($action == 'addmove')
{
	$from=$_POST['fromacct'];
	$to=$_POST['toacct'];
	$amount=$_POST['amount'];
	$memo=htmlentities($_POST['memo']);
	$date = $_POST['year'] ."-". $_POST['month'] ."-". $_POST['day'];
	$class_id = $_POST['class_id'];

	$correct_ids = move_verify();
		
	$sql = "INSERT INTO moneymoves (movefrom, moveto, amount, memo, date, move_class_id) "
		. "VALUES ('{$correct_ids['from']}', '{$correct_ids['to']}', '$amount', '$memo', '$date', '$class_id') ";

	mysql_query($sql) or die('Could not add new transaction.');
	move_update_balance ($correct_ids['from'], $correct_ids['to']);
}
else if ($action == 'editmove')
{
	if (isset($_POST['work_on']))
		$work_on = $_POST['work_on'];
	else show_note('Invalid request! Please tell your <a href="mailto:admin@apo-x.org“>administrative vp</a>!');
	
	$from=$_POST['fromacct'];
	$to=$_POST['toacct'];
	$amount=$_POST['amount'];
	$memo=htmlentities($_POST['memo']);
	$date = $_POST['year'] ."-". $_POST['month'] ."-". $_POST['day'];
	$class_id = $_POST['class_id'];
	$old = db_select1("SELECT * FROM moneymoves WHERE moveid='$work_on' ");
	
	$correct_ids = move_verify();
	
	$sql = "UPDATE moneymoves SET movefrom='{$correct_ids['from']}', moveto='{$correct_ids['to']}', amount='$amount', "
		. "  memo='$memo', date='$date', move_class_id='$class_id' WHERE moveid='$work_on' ";
	mysql_query($sql) or die('Could not edit transaction.');
	
	//first cancel out the old transfer
	move_update_balance ($old['moveto'], $old['movefrom']);
	move_update_balance ($correct_ids['from'], $correct_ids['to']);
}
else if (isset($_GET['fix_balances']))
{	
	move_update_balance();
}

?>
<html>
<head>
<meta http-equiv="refresh" content="0;url=<?php echo $redirect ?>">
</head>
</html>

