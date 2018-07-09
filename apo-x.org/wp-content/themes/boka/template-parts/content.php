<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package boka
 */

$margin[] = 'margin-bottom-30 blog-link';
$sticky_post = '';
if ( is_sticky() ){
	$sticky_post = ' sticky-post';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $margin ); ?>>
	<div class="article-wrap overflow">
		<?php if ( has_post_thumbnail() && get_theme_mod('featured_image_index_enable') != 1 ) : ?>

			<div class="entry-thumb">
				<a href="<?php the_permalink(); ?>">
					<img src="<?php echo get_the_post_thumbnail_url(); ?>" class="img-responsive" />
				</a>
			</div>

		<?php endif; ?>
		<div class="entry-content article-gap">

			<header class="entry-header margin-bottom-30">
				<?php
				the_title( '<h3 class="entry-title margin-null text-capitalize'. $sticky_post .'"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );

				if ( 'post' === get_post_type() && get_theme_mod('meta_index_enable') != 1 ) : ?>
					<div class="entry-meta">
						<?php

						boka_posted_on();
						boka_entry_footer();

						?>
					</div><!-- .entry-meta -->
				<?php endif; ?>
			</header><!-- .entry-header -->

			<?php

			if ( get_theme_mod( 'excerpt_content_enable' ) ){

				the_content();

			} else {

				$excerpt = get_theme_mod('excerpt_lenght', '45');
				//return $excerpt;
				the_excerpt();

				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages : ', 'boka' ),
					'after'  => '</div>',
				) );

				?>
				<div class="clearfix"></div>
				<footer class="entry-footer overflow text-capitalize margin-top-20">
					<a href="<?php echo esc_url( get_permalink() ); ?>" class="read-more"><?php _e( 'read more', 'boka' )?> &rarr;</a>
				</footer><!-- .entry-footer -->
			<?php } ?>
		</div><!-- .entry-content -->
	</div>
</article><!-- #post-## -->
