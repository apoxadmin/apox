<?php
include 'inc.boxes.php';
include 'inc.fields.sliderfields.php';
$post = array();
$strSlides = '';
if(@$bUpdate){
$post = get_post($post_id);
$strSlides = get_post_meta($post_id, 'slides', true);
?>
	<div class="updated" id="message"><p><?php _e('Post published.'); ?></p></div>
<?php }?>
<?php 
global $_thethe_image_slider_error_msg;
if (isset($_thethe_image_slider_error_msg)) {?>
<div class="updated" id="message"><p><?php _e($_thethe_image_slider_error_msg); ?>.</p></div>
<?php } ?>
<fieldset class="allwidth">
  <legend>Main Settings</legend>
  <div class="addform">
  	<input type="hidden" name="action" value="createslider" /> 
	<?php	
	set_html_post($post);
	$oQuery = new WP_Query( 'post_type=thethe-slider');
	$nCount = $oQuery->post_count;
	foreach ($g_arrBoxes as $box){
		echo sp_field_start();
		if ($box['name'] == '_slider_name'){
			$box['default'] = 'Slider' . ($nCount + 1);
		}
		echo field_html( $box );
		echo sp_field_end();
	}?>
  </div>
</fieldset>