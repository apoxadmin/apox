<?php 
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/forms.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

if($_SESSION['class'] == 'admin')
	$edit = true;

get_header();

function files_get($type)
{
	$sql = "SELECT title, filename FROM file "
		. " WHERE filetype_id = '$type' "
		. " ORDER BY title ASC ";
	return db_select($sql);
}

function types_get()
{
	$sql = "SELECT id, name FROM filetype"
		. " ORDER BY name ASC ";
	return db_select($sql);
}

?>

	<?php if($edit): ?>
	<div class="general">
		<div class="boxtop">Excomm Controls</div>
		<div class="general">
			<ul><li><a href="/download/files.php">Upload Files</a></li><ul>
		</div>
	</div>
	<?php endif; ?>
	
	<?php 
	$types = types_get();
	foreach($types as $type): ?>
		<div class="general">
			<div class="boxtop"><?=$type['name']?></div>
			<div class="general">
				<ul>
				<?php 
				$files = files_get($type['id']);
				foreach($files as $file): ?>
					<li><form action="/download/input.php" onSubmit="return confirmDialog();" method="POST">
					<a href="/files/<?=$type['id'].'/'.$file['filename']?>"><?=$file['title']?></a>					
					<? if($edit)
					{
						forms_hiddenInput('removefile', '/download/');
						forms_hidden('filename', $file['filename']);
						forms_hidden('type', $type['id']);
						echo ' <input type="submit" name="Remove" value="Remove" />';
					} ?>					
					</form></li>
				<?php endforeach; ?>
				</ul>
			</div>
		</div>
	<?php endforeach; ?>

<?php show_footer(); ?> 
