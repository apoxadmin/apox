<?php /** @version $Id: inc.sidebar.themes.php 972 2011-08-25 18:31:32Z lexx-ua $ */ ?>
<?php 
/** Require RSS lib */
require_once ABSPATH . WPINC . '/class-simplepie.php';
require_once ABSPATH . WPINC . '/class-feed.php';
require_once ABSPATH . WPINC . '/feed.php';

$_theme_rss_url = 'http://thethefly.com/index-themes-rss.php';
$_theme_rss_data = array();
$_theme_rss = new SimplePie();
$_theme_rss->set_feed_url($_theme_rss_url);
$_theme_rss->set_cache_class('WP_Feed_Cache');
$_theme_rss->set_file_class('WP_SimplePie_File');
$_theme_rss->set_cache_duration(apply_filters('wp_feed_cache_transient_lifetime', 43200, $_theme_rss_url));
do_action_ref_array( 'wp_feed_options', array( &$_theme_rss, $_theme_rss_url ) );
$_theme_rss->init();
$_theme_rss->handle_content_type();
if ( !$_theme_rss->error() ) {
	$maxitems = $_theme_rss->get_item_quantity(50);
	$rss_items = $_theme_rss->get_items(0, $maxitems);
	if ($rss_items) {
		$_theme_rss_data = (array) $rss_items;
		
	}
}

if (is_array($_theme_rss_data)) {
?>
<div class="thethe-themes postbox">
  <div class="handlediv" title="<?php _e( 'Click to toggle' ); ?>"><br />
  </div>
  <h3 class="hndle"><span>WP Themes by TheThe Fly</span></h3>
  <div class="inside">
    <p align="center">
<?php
$rand_key = array_rand($_theme_rss_data,4);
foreach ($_theme_rss_data as $k => $_theme_rss_item) {
	if (in_array($k, $rand_key)) {
		$title = $_theme_rss_item->get_title();
		$demo_link_data = $_theme_rss_item->get_item_tags('http://thethefly.com/xmlns/','demo_link');
		$imgsrc = $_theme_rss_item->get_enclosure()->link;
?>
      <a href="<?php print $demo_link_data[0]['data'];?>" target="_blank" title="Click here to view <?php print $title;?> theme live demo!"><img style="border: 1px solid #666; padding:2px;" width="120" border="1" height="" src="<?php print $imgsrc;?>" alt="<?php print $title;?>" title="Click here to view <?php print $title;?> theme live demo!" /></a>
<?php }} ?>
    </p>
    <p> <a href="http://demo.thethefly.com/" target="_blank">Themes Live Demo</a> </p>
  </div>
</div>
<?php }