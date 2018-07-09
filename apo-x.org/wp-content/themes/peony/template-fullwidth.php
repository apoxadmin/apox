<?php

get_header(); 

global  $post, $peony_post_meta;

$layout = esc_attr(peony_option('layout'));
$fullscreen = isset($peony_post_meta['peony_fullscreen'][0])?$peony_post_meta['peony_fullscreen'][0]:'';

$wrapper = '';
$body_class = '';

if ($layout == 'boxed')
	$wrapper .= ' wrapper-boxed container ';

$body_class .= ' homepage peony';
$skin = peony_option('skin');

if ($skin == '1')
	$body_class .= ' dark';

$main_class = 'page-content';
$main_class .= ' peony-fullpage';

if ($fullscreen > 0)
$wrapper .= ' peony-fullscreen';

?>
<div class="peony-fullpage-wrapper wrapper <?php echo $wrapper;?>">
	<?php peony_make_page_title_bar(PAGE_TITLE_BAR); ?>
	<div id="peony-home-sections">
		<div role="main" id="peony-main" <?php post_class($main_class); ?>>
		<?php while (have_posts()) : ?>
		<?php the_post(); ?>
		<?php the_content(); ?>
		<?php endwhile; ?>
		</div>
	</div>
</div>
<?php
get_footer();