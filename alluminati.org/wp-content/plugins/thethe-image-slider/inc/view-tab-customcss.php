<?php
include 'inc.boxes.php';
$strValue = get_option('thethe-image-slider-customcss');
$enableCustomCss = get_option('thethe-image-slider-enable-customcss');
$defCustomCss = '.thethe_image_slider {}
.thethe_image_slider_inner{}

.thethe_image_slider ul.thethe-image-slider-slides{}
ul.thethe-image-slider-slides li {}
ul.thethe-image-slider-slides li.show {}
ul.thethe-image-slider-slides li .thethe-image-slider-image{}

.thethe-image-slider-caption{}
	.thethe-image-slider-caption-inner{}
	.thethe-image-slider-caption-black{}
		.thethe-image-slider-caption-black,
		.thethe-image-slider-caption-black a,
		.thethe-image-slider-caption-black a:link,
		.thethe-image-slider-caption-black a:visited{}
	.thethe-image-slider-caption-white{}
		.thethe-image-slider-caption-white, .thethe-image-slider-caption-white a{}
	.thethe-image-slider-caption-gray{}
		.thethe-image-slider-caption-gray, .thethe-image-slider-caption-gray a{}

.thethe-image-slider-controls{}
	.thethe-image-slider-controls-next{}
	.thethe-image-slider-controls-prev{}
	.thethe-image-slider-controls-pause{}

	.thethe-image-slider-controls .thethe-previous,
	.thethe-image-slider-controls .thethe-pause,
	.thethe-image-slider-controls .thethe-next,
	.thethe-image-slider-controls .thethe-play{}
	.thethe-image-slider-controls .thethe-previous{	}
	.thethe-image-slider-controls .thethe-pause{}
	.thethe-image-slider-controls .thethe-play{}

.thethe-image-slider-thumbnails{}
	.thethe-image-slider-thumbnails-thumb{}
	.thethe-image-slider-thumbnails-thumbnails .thethe-image-slider-thumbnails-thumb{}
	.thethe-image-slider-thumbnails-thumbnails .thethe-image-slider-thumbnails-thumb .thumbnail-img{}
	.thethe-image-slider-thumbnails-thumbnails .thethe-image-slider-thumbnails-currentthumb .thumbnail-img,
	.thethe-image-slider-thumbnails-thumbnails .thethe-image-slider-thumbnails-activated .thumbnail-img{}
	.thethe-image-slider-thumbnails-slidenames .thethe-image-slider-thumbnails-thumb{}
	.thethe-image-slider-thumbnails-numbers .thethe-image-slider-thumbnails-thumb{}
	.thethe-image-slider-thumbnails-numbers .thethe-image-slider-thumbnails-currentthumb,
	.thethe-image-slider-thumbnails-numbers .thethe-image-slider-thumbnails-activated{}
	.thethe-image-slider-thumbnails-slidenames .thethe-image-slider-thumbnails-currentthumb,
	.thethe-image-slider-thumbnails-slidenames .thethe-image-slider-thumbnails-activated{}
	.thethe-image-slider-thumbnails-dots .thethe-image-slider-thumbnails-thumb{}
	.thethe-image-slider-thumbnails-currentthumb, .thethe-image-slider-thumbnails-activated{}
	.thethe-image-slider-thumbnailsbottomright{}
	.thethe-image-slider-thumbnailsbottomleft{}
	.thethe-image-slider-thumbnailstopright{}
	.thethe-image-slider-thumbnailstopleft{}
	.thethe-image-slider-thumbnailsunder{}

.thethe-image-slider-loader{}
.thethe-image-slider-progress{}';
$strValue = $strValue ? $strValue : $defCustomCss;
?>
<?php if($_GET['update']){?>

<div class="updated" id="message">
  <p>
    <?php _e('Custom Style Updated.'); ?>
  </p>
</div>
<?php }?>
<div class="thethefly-submit-buttons">
  <input name="submit[]" class="button-primary" value="Save" type="submit" />
  <input name="reset" class="button-secondary" value="Reset To Defaults" type="submit" />  
</div>
<fieldset>
  <div class="wrap">
    <input type="hidden" name="action" value="savecustomcss" />
    <legend>Edit Custom CSS</legend>
    <div class="slideroption">
      <input type="hidden" name="thethe-image-slider-enable-customcss" value="0" />
      <label for="thethe-image-slider-enable-customcss">Enable Custom CSS:</label>&nbsp;<input id="thethe-image-slider-enable-customcss" type="checkbox" <?php echo $enableCustomCss ? 'checked' : '';?> value="1" name="thethe-image-slider-enable-customcss" >
    </div>
    <div class="slideroption">
      <textarea name="thethe-image-slider-customcss" class="thethe-custom-style-area"><?php echo $strValue?></textarea>
    </div>
  </div>
</fieldset>
<div class="thethefly-submit-buttons">
  <input name="submit[]" class="button-primary" value="Save" type="submit" />
  <input name="reset" class="button-secondary" value="Reset To Defaults" type="submit" />  
</div>