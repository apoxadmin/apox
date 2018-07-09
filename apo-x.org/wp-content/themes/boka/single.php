<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package boka
 */

get_header(); ?>

	<main class="article-page">
		<section>
			<div class="container">
				<div class="row">
					<?php if ( get_theme_mod('blog_sidebar_enable','1') ) : ?>
					<div class="col-md-12 col-sm-12 col-xs-12 padding-gap-1 padding-gap-4">
						<?php else: ?>
						<div class="col-md-12 col-sm-12 col-xs-12 padding-gap-1 padding-gap-4">
							<?php endif;

							while ( have_posts() ) : the_post();

								get_template_part( 'template-parts/content-single', get_post_format() );

								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;

							endwhile; // End of the loop.
							?>
						</div>
						<?php
						if ( get_theme_mod('blog_sidebar_enable') ) :
							get_sidebar();
						endif;
						?>
					</div>
				</div>
		</section>
	</main><!-- #main -->
<?php
get_footer();
