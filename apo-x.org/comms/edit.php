<?php

include_once 'template.inc.php';
include_once 'forms.inc.php';

show_header('', 'HTMLArea.replaceAll()');

function getComm($name)
{
	$select = "SELECT comm_body, comm_id FROM comm WHERE comm_title = '$name'";
	return db_select1($select);
}

if(isset($_GET['name']))
	$comm = getComm($_GET['name']);
	
if($comm['comm_id']=='')
	$action = 'create';
else
	$action = 'update';

?>
<script type="text/javascript">
   _editor_url = "/tools/htmlarea/";
   _editor_lang = "en";
</script>
<script type="text/javascript" src="/tools/htmlarea/htmlarea.js">
</script>

<form method="POST" action="/comms/input.php">
<? 
forms_hiddenInput($action,'/comms/index.php'); 
forms_hidden('id', $comm['comm_id']);
forms_text(30, 'title', $_GET['name']);
?>
<textarea name="body" style="margin:0;padding:0;width:995px;height:800px;" rows="20" cols="80"><?=$comm['comm_body']?></textarea>
<?php forms_submit('Submit', 'Submit'); ?>
</form>
<?php 

show_footer();

?>