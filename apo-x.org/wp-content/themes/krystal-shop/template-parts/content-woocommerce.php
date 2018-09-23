<?php
/**
 * Template part for displaying woocommerce content in page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package krystal-shop
 */

?>

<div class="container">
	<div class="row">
		<?php 
			if("right" === esc_attr(get_theme_mod( 'kr_shop_styles','right' ))) {
				?>
					<div class="col-md-8">
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<div class="entry-content">
								<div class="woocommerce">
									<?php
										woocommerce_content();						
									?>
								</div>					
							</div><!-- .entry-content -->				
						</article><!-- #post-## -->
					</div>
					<div class="col-md-3 col-md-offset-1">
						<div class="woo-sidebar">
							<div class="entry-content">
								<div class="woocommerce">
									<?php get_sidebar('woosidebar'); ?>
								</div>
							</div>
						</div>
					</div>
				<?php
			}
			else if("left" === esc_attr(get_theme_mod( 'kr_shop_styles','right' ))) {
				?>
					<div class="col-md-3">
						<div class="woo-sidebar">
							<div class="entry-content">
								<div class="woocommerce">
									<?php get_sidebar('woosidebar'); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-8 col-md-offset-1">
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<div class="entry-content">
								<div class="woocommerce">
									<?php
										woocommerce_content();						
									?>
								</div>					
							</div><!-- .entry-content -->				
						</article><!-- #post-## -->
					</div>
				<?php
			}
			else{
				?>
					<div class="col-md-12">
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<div class="entry-content">
								<div class="woocommerce">
									<?php
										woocommerce_content();						
									?>
								</div>					
							</div><!-- .entry-content -->				
						</article><!-- #post-## -->
					</div>
				<?php		
			}
		?>
	</div>
</div>


