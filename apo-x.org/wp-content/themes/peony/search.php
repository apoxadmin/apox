<?php
/**
 * @package peony
 */
$left_sidebar = peony_option('left_sidebar_blog_archive');
$right_sidebar = peony_option('right_sidebar_blog_archive');
$sidebar = 'none';

if ($left_sidebar)
    $sidebar = 'left';
	
if ($right_sidebar)
    $sidebar = 'right';
	
if ($left_sidebar && $right_sidebar)
	$sidebar = 'both';

$container = 'container';

get_header();
peony_make_page_title_bar(SEARCH_TITLE_BAR);
?>
<!--Main Area-->
<div class="page-wrap">
<div class="<?php echo $container;?>">
<div class="page-inner row <?php echo peony_get_content_class($sidebar);?>">
<div class="col-main">
<section class="page-main" role="main" id="content">
    <div class="page-content">
        <!--blog list begin-->
        <div class="blog-list-wrap">
        <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('content', 'search'); ?>
        <?php endwhile; ?>
        <?php the_posts_pagination(array( 'mid_size' => 4 )); ?>
        <?php else : ?>
        <?php get_template_part('content', 'none'); ?>
        <?php endif; ?>
        </div><!-- #blog-list-wrap -->
    </div><!-- #page-content -->
    <div class="post-attributes"></div>
</section><!-- #page-main -->
</div><!-- #col-main -->
<?php peony_make_sidebar($sidebar, 'archive'); ?>
</div><!-- #page-inner -->
</div><!-- #container -->
</div><!-- #page-wrap -->

<?php get_footer(); ?>