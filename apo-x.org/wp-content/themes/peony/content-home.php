<?php
$sidebar = 'none';
$blog_list_style = esc_attr(peony_option('blog_list_style'));
$blog_pagination_type = peony_option('blog_pagination_type');
$left_sidebar = esc_attr(peony_option('left_sidebar_blog_archive'));
$right_sidebar = esc_attr(peony_option('right_sidebar_blog_archive'));
if ($left_sidebar !='') 
    $sidebar = 'left';
if ($right_sidebar != '') 
    $sidebar = 'right';
if ($left_sidebar != '' && $right_sidebar != '') 
    $sidebar ='both';
$infinite_scroll = '';
if ($blog_pagination_type == 'infinite_scroll')
    $infinite_scroll = 'peony-infinite-scroll';

peony_make_page_title_bar(POST_LIST_TITLE_BAR);
?>
<div class="page-wrap">
<div class="container">
<div class="page-inner row <?php echo peony_get_content_class($sidebar);?>">
<div class="col-main">
<section class="page-main" role="main" id="content">
<div class="page-content" id="<?php echo $infinite_scroll;?>">
    <!--blog list begin-->
    <?php
        $list_wrap     = '';
        $blog_template = 'article';
        $list_wrap     = $blog_list_style;
        if ($list_wrap == 'blog-aside-image')
            $blog_template = $list_wrap;
		if ($list_wrap == 'blog-grid')
            $blog_template =  'grid';
    ?>
    <div class="blog-list-wrap <?php echo $list_wrap;?>">
    <?php if (have_posts()) : ?>
        <?php /* Start the Loop */ ?>
        <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('content', $blog_template); ?>
        <?php endwhile; ?>
    <?php else : ?>
        <?php get_template_part('content', 'none'); ?>
    <?php endif; ?>
    </div><!-- #blog-list-wrap -->
    <?php the_posts_pagination(array( 'mid_size' => 4 )); ?>
</div><!-- #page-content -->
<div class="post-attributes"></div>
</section><!-- #page-main -->
</div><!-- #col-main -->
<?php peony_make_sidebar($sidebar, 'archive'); ?>
</div><!-- #page-inner -->
</div><!-- #container -->
</div><!-- #page-wrap -->