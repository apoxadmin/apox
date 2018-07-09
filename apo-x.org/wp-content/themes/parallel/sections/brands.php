<?php
/**
 * Brands Section for our theme
 * @subpackage Parallel
 * @since Integral 1.0
 */
?>
<?php global $parallel; ?>
<?php if($parallel['brands-section-toggle']==1) { ?>
<section id="brands" class="brands <?php echo esc_attr($parallel['brands-custom-class']); ?>">
	<div class="container">
        <div class="row">
			<div class="col-md-12 heading">			
				<?php if ($parallel['brands-maintitle']) { ?><h2 class="title"><?php echo esc_html($parallel['brands-maintitle']); ?><span></span></h2><?php } ?>
				<?php if ($parallel['brands-subtitle']) { ?><p class="subtitle"><?php echo wp_kses_post($parallel['brands-subtitle']); ?></p><?php } ?>
			</div>
        </div>
        <?php if ( is_active_sidebar( 'brands-widgets' ) ) : ?>
        <div class="row multi-columns-row">
            <?php dynamic_sidebar( 'brands-widgets' ); ?>
		</div>
        <?php endif; ?>
	</div>
</section><!--brands-->
<?php } ?>