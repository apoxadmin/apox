<?php
/**
 * Call to Action Section for our theme
 * @subpackage Parallel
 * @since Integral 1.0
 */
?>
<?php global $parallel; ?>
<?php if($parallel['calltoaction2-section-toggle']==1) { ?>
<section id="calltoaction2" class="calltoaction2 <?php echo esc_attr($parallel['calltoaction2-custom-class']); ?>">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-8 text-left">
                <?php if ($parallel['calltoaction2-title']) { ?><h2><?php echo esc_html($parallel['calltoaction2-title']); ?></h2><?php } ?>
                <?php if ($parallel['calltoaction2-text']) { ?><p><?php echo wp_kses_post($parallel['calltoaction2-text']); ?></p><?php } ?>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 text-right cta-button">
                <?php if ($parallel['calltoaction2-btn-text']) { ?><a href="<?php echo esc_url($parallel['calltoaction2-btn-url']); ?>" class="btn btn-lg btn-xl btn-secondary"><?php echo esc_html($parallel['calltoaction2-btn-text']); ?></a><?php } ?>
            </div>
        </div>
    </div>
</section><!--parallax2-->
<?php } ?>