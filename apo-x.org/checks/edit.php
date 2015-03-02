<?php

include_once 'template.inc.php';
include_once 'forms.inc.php';
include_once 'database.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

$action = $_POST['action'];
$class = $_SESSION['class'];

get_header();
if($class != 'admin')
	show_note('You must be logged in as excomm.');

	
function set_values($ID)
{
	$person = mysql_result(mysql_query(sprintf("SELECT person FROM checks WHERE id='%s'",$ID)),0);
	$amount = mysql_result(mysql_query(sprintf('SELECT amount FROM checks WHERE id=%s',$ID)),0);
	$reason = mysql_result(mysql_query(sprintf('SELECT reason FROM checks WHERE id=%s',$ID)),0);
	$status = mysql_result(mysql_query(sprintf('SELECT status FROM checks WHERE id=%s',$ID)),0);
    $values = array("person" => $person, "amount" => $amount, "reason" => $reason, "status" => $status);
	return $values;
}
$value_array = set_values($_POST["ID"]);
	?>
	

	
<form action="/checks/submit.php?action=update" method="POST">
Edit Reimbursement Entry<br/>
ID: <input name="ID" type="text" maxlength="50" value= <? echo $_POST["ID"] ?> disabled="disabled" /><br/>
To who: <input name="person" type="text" maxlength="50" value= <? echo $value_array["person"] ?> /><br/>
How much: <input name="amount" type="text" maxlength="6" value= <? echo $value_array["amount"] ?>  /><br/>
For what: <input name="reason" type="text" maxlength="50" value= <? echo $value_array["reason"] ?>  /><br/>
Status: <select name="status">
  <option value="Received">Received</option>
  <option value="Processing">Processing</option>
  <option value="Declined">Declined</option>
  <option value="Ready">Ready for Pickup</option>
  <option value="Deposited">Check Deposited</option>
</select><br/>	
<?php forms_submit('Submit'); ?>
</div>
<?
show_footer();?>
	