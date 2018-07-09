<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package boka
 */
$margin[] = 'padding-gap-6';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $margin ); ?>>
	<div class="article-wrap  overflow">
		<?php if ( has_post_thumbnail() && get_theme_mod('featured_image_index_enable') != 1 ) : ?>

			<div class="entry-thumb">
				<a href="<?php the_permalink(); ?>">
					<img src="<?php echo get_the_post_thumbnail_url(); ?>" class="img-responsive" />
				</a>
			</div>

		<?php endif; ?>
		<div class="entry-summary article-gap">
			<header class="entry-header margin-bottom-30 search-title">
				<?php the_title( sprintf( '<h2 class="entry-title margin-null text-capitalize"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

				<?php if ( 'post' === get_post_type() ) : ?>
					<div class="entry-meta">
						<?php boka_posted_on(); ?>
					</div><!-- .entry-meta -->
				<?php endif; ?>
			</header><!-- .entry-header -->
			<?php
			the_excerpt();
			?>
			<div class="clearfix"></div>
			<footer class="entry-footer overflow text-capitalize margin-top-20">
				<a href="<?php echo esc_url( get_permalink() ); ?>" class="read-more"><?php _e( 'read more', 'boka' )?> &rarr;</a>
			</footer><!-- .entry-footer -->
		</div><!-- .entry-summary -->
	</div>
</article><!-- #post-## -->
