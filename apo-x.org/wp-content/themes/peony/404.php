<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package peony
 */

global  $allowedposttags;

$sidebar ='none';
$left_sidebar              = esc_attr(peony_option('left_sidebar_404'));
$right_sidebar             = esc_attr(peony_option('right_sidebar_404'));
if ($left_sidebar != '')
    $sidebar = 'left';
if ($right_sidebar != '')
    $sidebar = 'right';
if ($left_sidebar != '' && $right_sidebar != '')
    $sidebar ='both';

$page_id = absint(peony_option('page_404'));
$title   =  __('404 Not Found', 'peony');
$content = __('<h1>OOPS!</h1><p>Can\'t find the page.</p>', 'peony');

if ($page_id  > 0) {
	$query = new WP_Query(array('page_id' => $page_id));
	if ($query->have_posts() ) {
		while ($query->have_posts()) {
			$query->the_post();

			$title   = get_the_title();
			$content = get_the_content();
        }
	}
	wp_reset_postdata();
}

get_header();
peony_make_page_title_bar(PAGE_TITLE_BAR);
?>
<div class="page-wrap">
<div class="container">
<div class="page-inner row <?php echo peony_get_content_class($sidebar);?>">
<div class="col-main">
    <section class="page-main" role="main" id="content">
        <div class="page-content peony_content_404">
            <?php echo  $content;?>
        </div>
        <div class="post-attributes"></div>
    </section>
</div>
<?php peony_make_sidebar($sidebar, 'notfound'); ?>
</div>
</div>  
</div>        
<!-- #primary -->
<?php get_footer(); ?>
