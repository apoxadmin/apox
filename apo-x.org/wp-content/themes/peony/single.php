<?php
/**
 * The template for displaying all single posts.
 *
 * @package peony
 */

$sidebar ='none';
$left_sidebar  = esc_attr(peony_option('left_sidebar_blog_posts'));
$right_sidebar = esc_attr(peony_option('right_sidebar_blog_posts'));

if ($left_sidebar != '')
	$sidebar = 'left';

if ($right_sidebar != '')
	$sidebar = 'right';

if ($left_sidebar != '' && $right_sidebar != '')
	$sidebar = 'both';

get_header();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php peony_make_page_title_bar(POST_TITLE_BAR); ?>
<div class="post-wrap">
<div class="container">
<div class="post-inner row <?php echo peony_get_content_class($sidebar);?>">
<div class="col-main">
<?php while (have_posts()) : the_post(); ?>
    <?php get_template_part('content', 'single'); ?>
<?php endwhile; ?>
</div>
<?php peony_make_sidebar($sidebar, 'post'); ?>
</div>
</div>
</div>
</article>
<?php get_footer(); ?>