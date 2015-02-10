<?php 
include_once 'template.inc.php';
include_once 'forms.inc.php';
include_once 'constants.inc.php';

$action = $_GET['action'];
$work_on = $_GET['work_on'];

if(isset($_GET['term']))
	$term = $_GET['term'];
else
	$term = db_currentClass('class_id');

if($_SESSION['class'] == 'admin' || $_SESSION['class'] == 'finance')
	$edit = true;
else if ($action=='edit')
	show_note('You must be on excomm to edit a transaction.');

if(!isset($_SESSION['class']))
	show_note('You must be logged in to view this information.');

show_header();

setlocale(LC_MONETARY, 'en_US');

function moves_get( $account, $class_id = NULL )
{
	if ($class_id===NULL)
		$class_id = db_currentClass('class_id');
	
	$sql = "SELECT * FROM moneymoves "
		. " WHERE (movefrom = '$account' OR moveto = '$account') "
		. " AND move_class_id = '$class_id'"
		. " ORDER BY date, moveid ";
	return db_select($sql);
}

function moves_get1($id)
{
	$sql = "SELECT * FROM moneymoves "
		. " WHERE moveid='$id'";
	return db_select1($sql);
}

function accounts_get( $class_id = NULL )
{
	if ($class_id===NULL)
		db_currentClass('class_id');
	
	$sql = "SELECT * FROM money WHERE money_class_id='$class_id'"
	. " ORDER BY money_id";
	$result = mysql_query($sql) or die ("Couldn't get accounts data of class_id $class_id." . mysql_error());
	$accounts = array();

	while($line = mysql_fetch_assoc($result))	//index $accounts by money_id
		$accounts[$line['money_id']] = $line;

	mysql_free_result($result);
	
	return $accounts;
}

function getTerms()
{
	$sql = "SELECT class_id, class_nick FROM class "
	. " WHERE class_start > '0000-00-00 00:00:00' "
	. "ORDER BY class_start desc";
	return db_select($sql);
}

?>
<script language="javascript">
function validate()
{
	var amount = document.getElementById('amount').value;
	var memo = document.getElementById('memo').value;
	
	if(!amount.match(/[0-9]*\.[0-9]{2}/))
	{
		alert('The amount should be written in the form "1234.56"');
		return false;
	}
	else if(!memo.length)
	{
		alert('The memo length is too short.');
		return false;
	}
}
</script>

<?php 
if ($action != 'edit'): ?>	
<div class="general">Select term:<br/>
	<form method="GET" action="<?= $_SERVER['PHP_SELF'] ?>">
	<select name="term" size="1">
			<?php 
			$list = getTerms();
			foreach($list as $line): 
				echo "<option value=\"{$line['class_id']}\"";
				if ($line['class_id']==$term)
					echo " selected";
				echo ">{$line['class_nick']}</option>";
			endforeach; ?>
	</select>
	<?php forms_submit('Select') ?>
	</form>
</div>
	<?php 
	$accounts = accounts_get($term);
	foreach($accounts as $account): 
		//don't display it if the account name is in parentheses
		if (!($account['money_name'][0] == '(' && $account['money_name'][strlen($account['money_name']) - 1]==')'))
		{
			$cur_balance=0; ?>
			<div class="general"><div class="boxtop"><?=$account['money_name']?></div>
			<div class="general">
			<table>
			<tr><th width=10%>Date</th><th width=15%>Debit</th><th width=15%>Credit</th><th>Memo</th></tr>
			<?php 
			$moves = moves_get($account['money_id'], $term);
			$count = count($moves);

			foreach($moves as $move)
			{
				$count--;
				if($account['money_id']==$move['moveto'])
				{
					$name = $accounts[$move['movefrom']]['money_name'];
					$cur_balance += $move['amount']; ?>
					<tr>
						<td><?php echo $move['date']; ?></td>
						<td></td>
						<td class="addend">+ <?php echo money_format('%.2n',$move['amount']); ?></td>
						<td><?php echo "(From: ";
				}
				else
				{
					$name = $accounts[$move['moveto']]['money_name'];
					$cur_balance -= $move['amount']; ?>
					<tr>
						<td><?php echo $move['date']; ?></td>
						<td class="addend">- <?php echo money_format('%.2n',$move['amount']); ?></td>
						<td></td>
						<td><?php echo "(To: ";
				}
				echo $name.")<br/>\n";
				if ($edit)
					echo "<a href=\"index.php?action=edit&work_on={$move['moveid']}&term=$term\">";
				echo $move['memo']; 
				if ($edit) echo '</a>';
					?></td>
					</tr>
				<tr>
					<?php if($cur_balance >= 0)
					{ ?>
						<td></td>
						<td></td>
						<td <?php if($count==0) { ?> class="total" <?php } else { ?> class="sum" <?php } ?>>
						<?php echo money_format('%.2n',$cur_balance); ?></td>
						<td></td>
					<?php }
					else
					{ ?>
						<td></td>
						<td <?php if($count==0) { ?> class="total" <?php } else { ?> class="sum" <?php } ?>>
						<?php echo money_format('%.2n',$cur_balance); ?></td>
						<td></td>
						<td></td>
					<?php } ?>
				</tr>
			<?php }

			if((abs($cur_balance - $account['money_balance']) > 0.001))
			{ ?>
				<tr><td colspan=4><H2>Error! <?= money_format('%.2n',$cur_balance); ?> != <?= money_format('%.2n',$account['money_balance']); ?>! Tell your webmaster!</H2></td></tr>
			<?php }
			  ?>
			</table>
			</div>
			</div>
		<?php }
	endforeach; 
	endif; ?>
	
	
	<?php if($edit)	//New / Edit Transaction box
	{ 
	
			//Set the defaults
		if ($action=='edit')
		{
			$move = moves_get1($work_on);
			if (!isset($move['date']))
				show_note("That transaction does not exist.");
			$month = date('n', strtotime($move['date']));
			$day = date('j', strtotime($move['date']));
			$year = date('Y', strtotime($move['date']));
			$from = $move['movefrom'];
			$to = $move['moveto'];
			$amount = $move['amount'];
			$memo = $move['memo'];
			$class_id = $move['move_class_id'];
		}
		else
		{
			$month = date('n');
			$day = date('j');
			$year = date('Y');
			$from = "none";
			$to = "none";
			$amount;
			$memo = "";
			$class_id = $term;
		}
	
	$accounts = accounts_get($term);
	?>
		<div class="general">
		<form action="/money/input.php" method="POST" onSubmit="return validate()">
		<h3>
		<?php 
			if ($action == 'edit')
			{	
				forms_hiddenInput('editmove', '/money/index.php'); ?>
				<input name="work_on" type=hidden value="<?= $work_on ?>">Edit
	<?php	}
			else 
			{
				echo "New";
				forms_hiddenInput('addmove', '/money/index.php');
			}
		?> Transaction</h3>

		<table><tr>
			<th>Date:</th><td>
				<select name="month">
				<?php for($i=1; $i<13; $i++) {
					echo "<option ";
					if($month==$i) echo "selected ";
					echo "value=\"{$i}\">{$i}</option>"; } ?>
				</select>
				<select name="day">
				<?php for($i=1; $i<32; $i++) {
					echo "<option ";
					if($day==$i) echo "selected ";
					echo "value=\"{$i}\">{$i}</option>"; } ?>
				</select>
				<select name="year">
				<?php for($i=(date('Y')-1); $i<(date('Y')+2); $i++) {
					echo "<option ";
					if(date('Y')==$i) echo "selected ";
					echo "value=\"{$i}\">{$i}</option>"; } ?>
				</select>
			</td>
		</tr>
		<tr>
			<th>From Account:</th><td>
				<select id="fromacct" name="fromacct">
				<option value="none">Choose an account...</option>
				<?php foreach($accounts as $account): ?>
					<option value="<?php echo $account['money_id'] . "\"";
					if ($account['money_id'] == $from) 
						echo ' selected ';
					?>><?=$account['money_name']?></option>

				<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<th>To Account:</th><td>
				<select id="toacct" name="toacct">
				<option value="none">Choose an account...</option>
				<?php foreach($accounts as $account): ?>
					<option value="<?php echo $account['money_id'] . "\"";
					if ($account['money_id'] == $to) 
						echo ' selected ';
					?>><?=$account['money_name']?></option>
				<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<th>Amount:</th><td><input id="amount" type="input" name="amount" value="<?= $amount ?>"/></td>
		</tr>
		<tr>
			<th>Memo:</th><td><textarea id="memo" cols="50" rows="4" name="memo" ><?= $memo ?></textarea></td>
		</tr>
		<tr>
			<th>Class:</th><td>
			<select name="class_id" size="1">
			<?php 
			$list = getTerms();
			foreach($list as $line): 
				echo "<option value=\"{$line['class_id']}\"";
				if ($line['class_id']==$term)
					echo " selected";
				echo ">{$line['class_nick']}</option>";
			endforeach; ?>
	</select>
			</td>
		</tr>
		<tr>
			<td align="left"><?php if ($action=='edit') echo '<input name="delete" type="submit" value="Delete" onClick="return confirmDialog();" />'; ?>
			</td><td align="right"><input type="submit" value="<?php echo ($action=='edit')?'Edit':'Add'; ?> Transaction" /></td>
		</tr></table>
		</form>
		</div>
	<?php } ?>

<br/><br/><br/>

<?php show_footer(); ?> 
