<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package krystal
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php krystal_get_page_title(false,false,true,false); ?>
		<div class="content-blog searchpage">
			<div class="content-inner">
				<div class="container">
					<div class="row">
						<?php
			        		if('right'===esc_attr(get_theme_mod('kr_blog_sidebar','right'))) {
			        			?>
									<div class="col-md-9">
										<div id="primary" class="content-area">
											<?php
											if ( have_posts() ) : ?>

												<div class="search-content">
													<h1 class="page-search"><?php printf( __( 'Search Results for: %s', 'krystal' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
												</div><!-- .page-header -->

												<?php
												/* Start the Loop */
												while ( have_posts() ) : the_post();

													/**
													 * Run the loop for the search to output the results.
													 * If you want to overload this in a child theme then include a file
													 * called content-search.php and that will be used instead.
													 */
													get_template_part( 'template-parts/content', 'search' );

												endwhile;

												the_posts_navigation();

											else :

												get_template_part( 'template-parts/content', 'none' );

											endif; ?>
										</div>
									</div>
									<div class="col-md-3">
									<?php get_sidebar('sidebar-1'); ?>
									</div>
								<?php
							}
							else{
								?>
									<div class="col-md-3">
									<?php get_sidebar('sidebar-1'); ?>
									</div>
									<div class="col-md-9">
										<div id="primary" class="content-area">
											<?php
											if ( have_posts() ) : ?>

												<div class="search-content">
													<h1 class="page-search"><?php printf( __( 'Search Results for: %s', 'krystal' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
												</div><!-- .page-header -->

												<?php
												/* Start the Loop */
												while ( have_posts() ) : the_post();

													/**
													 * Run the loop for the search to output the results.
													 * If you want to overload this in a child theme then include a file
													 * called content-search.php and that will be used instead.
													 */
													get_template_part( 'template-parts/content', 'search' );

												endwhile;

												the_posts_navigation();

											else :

												get_template_part( 'template-parts/content', 'none' );

											endif; ?>
										</div>
									</div>									
								<?php
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</main>
</div>

<?php

get_footer();
