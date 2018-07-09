<?php
/**
 * Newsletter Section for our theme
 * @subpackage Parallel
 * @since Parallel 1.0
 */
?>
<?php global $parallel; ?>
<?php if($parallel['newsletter-section-toggle']==1) { ?>
<section id="newsletter" class="newsletter <?php echo esc_attr($parallel['newsletter-custom-class']); ?>">
    <?php if($parallel['newsletter-overlay-toggle']==1) { ?><div class="blacklayer"></div><?php } ?>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <?php if ($parallel['newsletter-title']) { ?><h2><?php echo esc_html($parallel['newsletter-title']); ?></h2><?php } ?>
                    <?php if ($parallel['newsletter-text']) { ?><p><?php echo wp_kses_post($parallel['newsletter-text']); ?></p><?php } ?>
                </div>
                <?php if ($parallel['mailchimp-code']) { ?>
                <div class="col-md-4">
                    <?php echo do_shortcode($parallel['mailchimp-code']); ?>
                </div>
                <?php } ?>
            </div>
        </div>
</section><!--parallax3-->
<?php } ?>