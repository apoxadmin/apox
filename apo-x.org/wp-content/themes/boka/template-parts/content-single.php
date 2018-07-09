<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package boka
 */

$margin[] = 'margin-bottom-30 blog-link';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $margin ); ?>>

	<header class="entry-header margin-bottom-20">
		<?php

		the_title( '<h1 class="entry-title text-capitalize margin-null">', '</h1>' );

		if ( 'post' === get_post_type() && get_theme_mod('meta_single_enable') != 1 ) : ?>

			<div class="entry-meta">
				<?php
				boka_posted_on();
				boka_entry_footer();
				?>
			</div><!-- .entry-meta -->

		<?php endif; ?>

	</header><!-- .entry-header -->

	<?php if ( has_post_thumbnail() && get_theme_mod('featured_image_single_enable') != 1 ) : ?>

		<div class="entry-thumb single-thumb margin-bottom-30">
			<img src="<?php echo get_the_post_thumbnail_url(); ?>" class="img-responsive" />
		</div>

	<?php endif; ?>

	<div class="entry-content article-gap article-wrap">

		<?php

		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'boka' ),
			'after'  => '</div>',
		) );

		?>
		<div class="margin-top-20 overflow">
			<?php
			the_post_navigation();
			?>
		</div>
		<div class="clearfix"></div>
	</div><!-- .entry-content -->

</article><!-- #post-## -->