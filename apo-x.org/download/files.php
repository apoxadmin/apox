<?php 
include_once 'template.inc.php';
include_once 'forms.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

$sql = 'SELECT id, name, description FROM filetype ORDER BY name asc';
$types = db_select($sql);

get_header(); 

if($_SESSION['class'] != 'admin')
{
	show_note('You must be logged in as excomm to edit files.');
}

?>
<div class="general">
<!-- The data encoding type, enctype, MUST be specified as below -->
<form enctype="multipart/form-data" action="/download/input.php" method="POST">
	<?php forms_hiddenInput('addfile', '/download/index.php'); ?>
    <h3>Upload File</h3>
    <table>
    <tr>
    	<th>File</th><td><input id="file" name="file" type="file" /></td>
    </tr>
    <tr>
    	<th>Title</th><td><input type="text" id="title" name="title" size="40" maxlength="128"/></td>
	</tr>
	<tr>
		<th>Description</th><td><?php forms_textarea("filedesc"); ?></td>
	</tr>
    <tr>
    	<th>Type</th><td>
		<select id="type" name="type" onChange="document.getElementById('changetypes').style.display = (this.value == 'add' ? 'block':'none')">
		<option value="none">Choose a type...</option>
		<?php foreach($types as $type): ?>
			<option value="<?=$type['id']?>"><?=$type['name']?></option>
		<?php endforeach; ?>
		<option value="add">Modify Types...</option>
		</select>
		</td>
	</tr>
	<tr>
		<th></th><td><input type="submit" value="Send File" /></td>
	</tr>
	</table>
</form>
</div>


<div id="changetypes" class="general" style="display: none;">
<form action="/download/input.php" method="POST">
	<?php
	forms_hiddenInput('changetypes','/download/index.php');
	
	$onChange = 'document.getElementById(\'newtype\').style.display = (this.value == \'add\' ? \'block\':\'none\'); '
				. 'document.getElementById(\'oldtype\').style.display = (this.value == \'add\' ? \'none\':\'block\');';
	
	echo "<select name=\"type\" onChange=\"$onChange\">";
	echo '<option value="none">Choose a type...</option>';
	foreach($types as $type)
	{
		echo "<option value=\"{$type['id']}\">{$type['name']}</option>";
	}
	echo '<option value="add">Add new type...</option>';
	echo '</select>';
	?>
</form>

	<br/>
	<form action="/download/input.php" method="POST">
	<div id="newtype" class="notice" style="display: none;">
	<?php forms_hiddenInput('addtype','/download/index.php'); ?>
	<label for="newtypename">New type: </label>
	<input id="newtypename" name="newtypename" type="text" size="16" maxlength="32" />
	<br/>
	<label for="newtypedesc">Description: </label>
	<?php forms_textarea("newtypedesc"); ?>
	<br/>
	<input type="submit" value="Add Type" />
	</div>
	</form>
	
	<form action="/download/input.php" method="POST">
	<div id="oldtype" class="notice" style="display: none;">
	<?php forms_hiddenInput('removetype','/download/index.php'); ?>
	<input type="submit" value="Remove Type" />
	</div>
	</form>

</div>
</div>
<?php
show_footer();
?>
