<?php
include 'inc.boxes.php';
include 'inc.fields.sliderfields.php';
$post = get_post($_GET['id']);
if($_GET['update']){?>
	<?php if ($_GET['added']){?>
		<div class="updated" id="message"><p><?php _e('Slide published.'); ?></p></div>
	<?php }else{?>
		<div class="updated" id="message"><p><?php _e('Slide updated.'); ?></p></div>
	<?php }?>
<?php }?>
<fieldset class="allwidth">
  <div class="addform">
  	<input type="hidden" name="action" value="addnewslide" /> 
  	<input type="hidden" name="id" value="<?php echo $_GET['id']?>" /> 
  	<?php 
		$strSlides = get_post_meta($_GET['id'], 'slides', true);
		$arrSlides = (is_array($arrSlides = @unserialize($strSlides))) ? $arrSlides : array();
		$nCount = count($arrSlides);
		foreach ($g_arrSliderProperties as $title => $properties){?>
  		<h3><?php echo $title?></h3>
  		<?php foreach ($properties as $propery){
			echo sp_field_start();
			if ($propery['name'] == 'title'){
				$propery['default'] = 'Slide' . ($nCount+1);
			}
			echo field_html( $propery );
			echo sp_field_end();
  		}?>
  	<?php }?>
  </div>
</fieldset>
