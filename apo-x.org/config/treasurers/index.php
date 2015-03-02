<?php 
include_once 'template.inc.php';
include_once 'forms.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
//list the terms
function getTerms($default_term)
{
	$sql = "SELECT class_id, class_nick FROM class "
	. " WHERE class_start > '0000-00-00 00:00:00' "
	. "ORDER BY class_start desc";
	return db_select($sql);
}

//get account names, balances, and the number of transactions they're in
function getAccounts($class, $justOne=0)
{
	$sql = 'SELECT money_id, money_name, money_balance FROM money'
		. " WHERE money_class_id='$class' ORDER BY money_name";	
	$result = mysql_query($sql) or die ("Couldn't list accounts of class_id $class." . mysql_error());
	
	$accounts = array();
	while($line = mysql_fetch_assoc($result))
	{
		$line['transactions'] = 0;
		$accounts[$line['money_id']] = $line;
	}
	
	mysql_free_result($result);
	
	//get the number of transactions each account is involved in
	$sql = 'SELECT money_id, count(*) as transactions FROM money, moneymoves'
		. " WHERE money_class_id='$class' AND (money_id = movefrom OR money_id = moveto)"
		. 'GROUP BY money_id';
	$counts = db_select($sql, "Couldn't get transaction counts for class_id $class.");
	
	for ($i=0; $i<count($counts); $i++)
		$accounts[$counts[$i]['money_id']] ['transactions'] = $counts[$i]['transactions'];

	return $accounts;
}

function get1Account($money_id)
{
	$sql = "SELECT money_id, money_name, money_balance, money_class_id, class_nick FROM money, class"
		. " WHERE money_id = '$money_id' AND class_id=money_class_id ";
	return db_select1($sql, "Couldn't get account $money_id.");
}

if(isset($_GET['term']))
	$term = $_GET['term'];
else
	$term = db_currentClass('class_id');

if($_SESSION['class'] == 'admin')
	$edit = true;
else
	show_note('You must be on excomm to modify accounts.');

get_header();

if (!isset($_GET['work_on'])):
?>
<div class="general">
Choose a term to create accounts for:<br />
<br />
	<form method="GET" action="<?= $_SERVER['PHP_SELF'] ?>">
	<select name="term" size="1">
			<?php 
			$list = getTerms($term);
			$copyFrom=0;
			for($i=0; $i<count($list); $i++)
			{
				echo "<option value=\"{$list[$i]['class_id']}\"";
				if ($list[$i]['class_id']==$term)
				{
					//if this is the term we want, have it selected
					echo " selected";
					$thisTerm = $list[$i]['class_nick'];
					if ($i<(count($list) - 1)) //copy account names from previous term
						$copyFrom = $list[$i+1]['class_id'];
				}
				echo ">{$list[$i]['class_nick']}</option>";
			} ?>
	</select>
	<?php forms_submit('Select') ?>
	</form>
</div>
<div class="general">
<h2>Create accounts for money tracking</h2>
<hr>
<h1><?= $thisTerm ?></h1><br/>
<?php
	$accounts = getAccounts($term);
	if (count($accounts)):	//if there's at least one account
?>
<table><tr><th>Name</th><th>Transactions</th><th>Balance</th></tr>
<?php	
	
		foreach($accounts as $account)
		{
			echo "<tr><td><a href=\"{$_SERVER['PHP_SELF']}?work_on={$account['money_id']}\">"
			. "{$account['money_name']}</a></td>"
			. "<td>{$account['transactions']}</td><td>{$account['money_balance']}</td>"
			. "</tr>\n";
		}
?>
</table>
</form>

<?php else: ?>

<h3>No existing accounts.</h3>
<?php endif; ?>
<form action="input.php" method="POST">
<input name="money_name" value="" size="25" maxlength="45">
 <input name="create" value="Add account" type="submit">
<input name="class_id" type="hidden" value="<?= $term ?>">
<input type="hidden" name="re-direct" value="<?= $_SERVER['PHP_SELF'] . "?term=$term" ?>">
<input type="hidden" name="action" value="create">
</form>
<hr>
<form method="POST" action="input.php">
<h3>Copy account names from: <h3>
	<select name="copy_from" size="1">
			<?php 
			$list = getTerms($term);
			foreach($list as $line): 
				echo "<option value=\"{$line['class_id']}\"";
				if ($line['class_id']==$copyFrom)
					echo " selected";
				echo ">{$line['class_nick']}</option>\n";
			endforeach; ?>
	</select>
	<input type="hidden" name="action" value="treasurers_copy_accounts">
	<input type="hidden" name="copy_to" value="<?= $term ?>">
	<input type="hidden" name="re-direct" value="<?= $_SERVER['PHP_SELF'] . "?term=$term" ?>">
	<?php forms_submit('Copy') ?>
</form>
</div>

<?php
else: 
$account=get1Account($_GET['work_on']);
if (!isset($account['money_name']))
	show_note("That account does not exist.");
?>
<div class="general">
<h3>Edit account</h3><a href="<?= $_SERVER['PHP_SELF'] . "?term={$account['money_class_id']}" ?>"> (back)</a><br/><br/>
<table>
<form action="input.php" method="POST">
<tr><th>Name:</th><td><input name="money_name" value="<?= $account['money_name'] ?>" size="25" maxlength="45"></td>
<td align="right"><input name="rename" value="Rename" type="submit"></td></tr>
<tr><th>Balance:</th><td><?= $account['money_balance'] ?></td></tr>
<tr><th>Class:</th><td><?= $account['class_nick'] ?></td></tr>
<tr><td></td><td></td><td align="right">
<input name="delete_account" value="Delete" type="submit" onClick="return confirm('Are you sure? This will delete all associated transactions as well.');"></td></tr>
<input type="hidden" name="money_id" value="<?= $_GET['work_on'] ?>">
<input type="hidden" name="money_class_id" value="<?= $account['money_class_id'] ?>">
<input type="hidden" name="re-direct" value="<?= $_SERVER['PHP_SELF'] . "?term={$account['money_class_id']}" ?>">
</form>
</table>
</div>

<?php
endif;
?>
<?php
show_footer();
?>
