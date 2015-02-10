<?php
include 'inc.boxes.php';
include 'inc.fields.sliderfields.php';
$post = get_post($_GET['id']);
$strSlides = get_post_meta($post->ID, 'slides', true);
if($_GET['update']){?>
	<?php if ($_GET['added']){?>
		<div class="updated" id="message"><p><?php _e('Slider published.'); ?></p></div>
	<?php }else{?>
		<div class="updated" id="message"><p><?php _e('Slider updated.'); ?></p></div>
	<?php }?>
<?php }?>
<fieldset class="allwidth">
  <legend>Main Settings</legend>
  <div class="addform">
  	<input type="hidden" name="action" value="editslider" /> 
  	<input type="hidden" name="id" value="<?php echo $_GET['id']?>" /> 
	<?php
	set_html_post($post);
	foreach ($g_arrBoxes as $box){
		echo sp_field_start();
		echo field_html( $box );
		echo sp_field_end();
	}?>
  </div>
</fieldset>
