<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package boka
 */

get_header(); ?>
	<main id="main" class="site-main" role="main">
		<section class="error-404 not-found position-relative">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/images/404.jpg" class="img-responsive" alt="404" />
			<div class="content-404 text-center">
				<h1><?php _e( '404', 'boka' ); ?></h1>
				<p><?php _e( 'Oops! This Page Not To Be found!', 'boka' ); ?></p>
			</div>
		</section><!-- .error-404 -->
	</main><!-- #main -->
<?php
get_footer();
