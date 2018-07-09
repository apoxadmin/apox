<?php
/**
 * Project Single Section for our theme
 
 * @subpackage Parallel
 * @since Parallel 1.0
 */
?>
<?php global $parallel; ?>
<?php if($parallel['gallery-section-toggle']==1) { ?>
<section id="gallery" class="gallery <?php echo esc_attr($parallel['gallery-custom-class']); ?>">
	<div class="container">
		<div class="row">
            <div class="col-md-12 heading">			
				<?php if ($parallel['gallery-title']) { ?><h2 class="title"><?php echo esc_html($parallel['gallery-title']); ?><span></span></h2><?php } ?>
                <?php if ($parallel['gallery-subtitle']) { ?><p class="subtitle"><?php echo wp_kses_post($parallel['gallery-subtitle']); ?></p><?php } ?>
			</div>
		</div>
	</div>
	<?php if( isset( $parallel['gallery-gallery']) ) { ?>
	<div class="container-fluid">
		<div class="row multi-columns-row no-gutter">
		<?php 
		    global $parallel;
		    $myGalleryIDs = explode(',', $parallel['gallery-gallery']);
		    foreach($myGalleryIDs as $myPhotoID):
		        $photoArray = parallel_wp_get_attachment($myPhotoID);
		    ?>
		        <a href="<?php echo wp_get_attachment_url( $myPhotoID ); ?>" class="<?php echo esc_attr($parallel['gallery-layout']); ?> lightbox">
		            <?php echo wp_get_attachment_image( $myPhotoID, 'parallel-gallery-thumbnails' ); ?>
		    	</a>
		<?php endforeach; ?>
		</div>
	</div>
	<?php } ?>
</section><!--slider-->
<?php } ?>