<?php
/**
 * Contact Section for our theme
 
 * @subpackage Parallel
 * @since Parallel 1.0
 */
?>
<?php global $parallel; ?>
<?php if($parallel['contact-section-toggle']==1) { ?>
<section id="contact" class="contact <?php echo esc_attr($parallel['contact-custom-class']); ?>">
<div class="container">
	<div class="row">
		<div class="col-md-12 heading">
			<?php if ($parallel['contact-title']) { ?><h2 class="title"><?php echo esc_html($parallel['contact-title']); ?><span></span></h2><?php } ?>
            <?php if ($parallel['contact-subtitle']) { ?><p class="subtitle"><?php echo wp_kses_post($parallel['contact-subtitle']); ?></p><?php } ?>
		</div>
		<?php if($parallel['contact-text']) { ?>
        <div class="col-md-12 margin-bottom-50">			
			<?php
				global $post;
				$post = get_post( $parallel['contact-text'] );
				setup_postdata( $post );
				the_content();
				wp_reset_postdata();
			?>
		</div>
        <?php } ?>
        <?php if($parallel['contact-info-toggle']==1) { ?>
		<div class="col-md-12 margin-bottom-50">
				<?php if ($parallel['contact-phone']) { ?>
				<div class="col-sm-4 col-md-4 col-lg-4 text-center">
					<p><span class="fa fa-phone fa-3x"></span></p>
					<p><?php echo esc_html($parallel['contact-phone']); ?></p>
				</div>
				<?php } ?>
				<?php if ($parallel['contact-address']) { ?>
				<div class="col-sm-4 col-md-4 col-lg-4 text-center">
					<p><span class="fa fa-home fa-3x"></span></p>
					<p><?php echo wp_kses_post(str_replace("\n", "<br>", $parallel['contact-address'])); ?></p>
				</div>
				<?php } ?>
				<?php if ($parallel['contact-email']) { ?>
				<div class="col-sm-4 col-md-4 col-lg-4 text-center">
					<p><span class="fa fa-envelope fa-3x"></span></p>
					<p><?php echo esc_html($parallel['contact-email']); ?></p>
				</div>
				<?php } ?>
		</div>
		<?php } ?>
		<?php if ($parallel['contact-form-code']) { ?>
        <div class="col-md-12">
			<?php echo do_shortcode(wp_kses_post($parallel['contact-form-code'])); ?>
		</div>
        <?php } ?>
	</div>
</div>
</section><!--contact-->
<?php } ?>