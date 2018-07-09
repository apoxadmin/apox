<?php
/**
 * Services Section for our theme
 * @subpackage Parallel
 * @since Parallel 1.0
 */
?>
<?php global $parallel; ?>
<?php if($parallel['services-section-toggle']==1) { ?>
<section id="services" class="services <?php echo esc_attr($parallel['services-custom-class']); ?>">
	<div class="container">
		<div class="row">
			<div class="col-md-12 heading">
				<?php if ($parallel['services-title']) { ?><h2 class="title"><?php echo esc_html($parallel['services-title']); ?><span></span></h2><?php } ?>
                <?php if ($parallel['services-subtitle']) { ?><p class="subtitle"><?php echo wp_kses_post($parallel['services-subtitle']); ?></p><?php } ?>
			</div>
			<?php if( isset( $parallel['services-text']) ) { ?>
                <div class="col-md-12">
    				<?php
                        global $post;
                        $post = get_post( $parallel['services-text'] );
                        setup_postdata( $post );
                        the_content();
                        wp_reset_postdata();
                    ?>
                </div>
            <?php } ?>
        </div>
        <?php if ( is_active_sidebar( 'service-widgets' ) ) : ?>
        <div class="row multi-columns-row">
            <?php dynamic_sidebar( 'service-widgets' ); ?>
        </div>
        <?php endif; ?>
	</div>
</section><!--services-->
<?php } ?>