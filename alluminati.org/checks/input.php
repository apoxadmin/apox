<?php

include_once 'template.inc.php';
include_once 'forms.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

$action = $_POST['action'];
$class = $_SESSION['class'];

get_header();

if($class != 'admin')
	show_note('You must be logged in as excomm.');
	?>
	
<form action="/checks/submit.php" method="POST">
New Reimbursement Entry<br/>
To who: <input name="person" type="text" maxlength="50" /><br/>
How much: <input name="amount" type="text" maxlength="6" /><br/>
For what: <input name="reason" type="text" maxlength="50" /><br/>
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

