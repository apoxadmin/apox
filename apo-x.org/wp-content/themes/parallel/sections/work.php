<?php
/**
 * Work Section for our theme
 * @subpackage Parallel
 * @since Parallel 1.0
 */
?>
<?php global $parallel; ?>
<?php if($parallel['work-section-toggle']==1) { ?>
<section id="work" class="work <?php echo esc_attr($parallel['work-custom-class']); ?>">
	<div class="container">
		<div class="row">
			<div class="col-md-12 heading">
                <?php if ($parallel['work-title']) { ?><h2 class="title"><?php echo esc_html($parallel['work-title']); ?><span></span></h2><?php } ?>
                <?php if ($parallel['work-subtitle']) { ?><p class="subtitle"><?php echo wp_kses_post($parallel['work-subtitle']); ?></p><?php } ?>
			</div>
            <?php if( isset( $parallel['work-text']) ) { ?>
			<div class="col-md-12">
                <?php
                    global $post;
                    $post = get_post( $parallel['work-text'] );
                    setup_postdata( $post );
                    the_content();
                    wp_reset_postdata();
                ?>
			</div>
            <?php } ?>
		</div>
	</div>
</section><!--work-->
<?php } ?>