<?php
/**
 * The template for displaying all pages.
 *
 * @package peony
 */
 
get_header();

global $peony_post_meta;

$fullwidth  = isset($peony_post_meta['peony_fullpage'][0])?$peony_post_meta['peony_fullpage'][0]:'';
$fullscreen = isset($peony_post_meta['peony_fullscreen'][0])?$peony_post_meta['peony_fullscreen'][0]:'';

if ($fullwidth == '1' || $fullwidth == 'on' || $fullscreen >0) {
	get_template_part('template','fullwidth');
	exit;
}

$container = 'container';
$sidebar = 'none';
$post_class = '';
$left_sidebar = esc_attr(peony_option('left_sidebar_pages'));
$right_sidebar = esc_attr(peony_option('right_sidebar_pages'));

if ($left_sidebar != '')
	$sidebar = 'left';

if ($right_sidebar != '')
	$sidebar = 'right';

if ($left_sidebar != '' && $right_sidebar != '')
	$sidebar = 'both';



?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php peony_make_page_title_bar(PAGE_TITLE_BAR); ?>
<div class="post-wrap">
	<div class="<?php echo $container;?>">
		<div class="page-inner row <?php echo peony_get_content_class($sidebar);?>">
			<div class="col-main">
				<?php while (have_posts()) : ?>
				<?php the_post(); ?>
				<?php get_template_part('content', 'page'); ?>
				<?php endwhile; ?>
			</div>
		<?php peony_make_sidebar($sidebar, 'page'); ?> 
		</div>
	</div>
</div>
</article>
<?php 
get_footer();