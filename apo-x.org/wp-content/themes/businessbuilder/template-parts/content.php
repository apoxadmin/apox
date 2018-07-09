<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package businessbuilder
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php if(has_post_thumbnail()) : ?>
	<div class="entry-thumb">
		<a href="<?php echo esc_url(get_permalink()); ?>"><?php the_post_thumbnail('businessbuilder-full-thumb'); ?></a>
	</div>
<?php endif; ?>
	<header class="entry-header">
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
		
		<?php
		endif; ?>
		<span class="entry-meta"><?php businessbuilder_posted_on(); ?></span>
	</header><!-- .entry-header -->
<?php if(is_single()) : ?>

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

<?php else : ?>
	<div class="entry-content">
		<?php the_excerpt(); ?>
	</div><!-- .entry-content -->

	<div class="entry-more">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php esc_html_e( 'Continue Reading', 'businessbuilder' ); ?></a>
	</div>



<?php endif; ?>


<?php if(is_single()) : ?>

<?php endif; ?>

</article><!-- #post-## -->
