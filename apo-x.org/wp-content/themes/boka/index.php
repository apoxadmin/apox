<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package boka
 */

get_header(); ?>

	<main class="home-page woocommerce">
		<section class="banner">
			<div class="container">
				<div class="row">
					<?php if ( get_theme_mod( 'blog_layout', 'default' ) == 'default' ) : ?>
					<div class="col-md-9 col-sm-8 col-xs-12 padding-gap-1 padding-gap-4">
						<?php else: ?>
						<div class="col-md-12 col-sm-12 col-xs-12 padding-gap-1 padding-gap-4 <?php echo get_theme_mod( 'blog_layout' ); ?>">
							<?php endif; ?>
							<div class="masonry-wrap">
								<?php
								if ( have_posts() ) :

								/* Start the Loop */
								while ( have_posts() ) : the_post();

									/*
                                     * Include the Post-Format-specific template for the content.
                                     * If you want to override this in a child theme, then include a file
                                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                                     */
									get_template_part( 'template-parts/content', get_post_format() );

								endwhile;
								?>
							</div>
						<?php
						if ( class_exists( 'WooCommerce' ) ) :
							woocommerce_pagination();
						else:
							the_posts_navigation();
						endif;
						else :

							get_template_part( 'template-parts/content', 'none' );
						endif;

						?>
						</div>
						<?php
						if ( get_theme_mod( 'blog_layout', 'default' ) == 'default' ) :
							get_sidebar();
						endif;
						?>
					</div>
				</div>
		</section>
	</main><!-- #main -->

<?php
get_footer();