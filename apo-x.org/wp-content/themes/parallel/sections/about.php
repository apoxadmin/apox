<?php
/**
 * About Section for our theme
 
 * @subpackage Parallel
 * @since Parallel 1.0
 */
?>
<?php global $parallel; ?>
<?php if($parallel['about-section-toggle']==1) { ?>
<section id="about" class="about <?php echo esc_attr($parallel['about-custom-class']); ?>">
	<div class="container">
		<div class="row">
			<div class="col-md-12 heading">
				<?php if ($parallel['about-title']) { ?><h2 class="title"><?php echo esc_html($parallel['about-title']); ?><span></span></h2><?php } ?>
                <?php if ($parallel['about-subtitle']) { ?><p class="subtitle"><?php echo wp_kses_post($parallel['about-subtitle']); ?></p><?php } ?>
			</div>
			<?php if( isset( $parallel['about-text']) ) { ?>
			<div class="col-md-12">
                <?php
					global $post;
					$post = get_post( $parallel['about-text'] );
					setup_postdata( $post );
					the_content();
					wp_reset_postdata();
				?>
			</div>
			<?php } ?>
		</div>
	</div>
</section><!--about-->
<?php } ?>