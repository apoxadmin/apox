<?php
/*
Plugin Name: .PHP on PAGES
Plugin URI: http://wphelpline.com/php-to-pages-plugin.php
Description: Adds .PHP to pages. you can follow us on twitter @wphelpline
Author: Himanshu Parashar
Version: 1.3
Author URI: http://wphelpline.com
*/

add_action('init', 'PHP_page_permalink', -1);
register_activation_hook(__FILE__, 'active');
register_deactivation_hook(__FILE__, 'deactive');


function PHP_page_permalink() {
	global $wp_rewrite;
 if ( !strpos($wp_rewrite->get_page_permastruct(), '.html')){
		$wp_rewrite->page_structure = $wp_rewrite->page_structure . '.php';
 }
}
add_filter('user_trailingslashit', 'no_page_slash',66,2);
function no_page_slash($string, $type){
   global $wp_rewrite;
	if ($wp_rewrite->using_permalinks() && $wp_rewrite->use_trailing_slashes==true && $type == 'page'){
		return untrailingslashit($string);
  }else{
   return $string;
  }
}

function active() {
	global $wp_rewrite;
	if ( !strpos($wp_rewrite->get_page_permastruct(), '.html')){
		$wp_rewrite->page_structure = $wp_rewrite->page_structure . '.php';
 }
  $wp_rewrite->flush_rules();
}	
	function deactive() {
		global $wp_rewrite;
		$wp_rewrite->page_structure = str_replace(".html","",$wp_rewrite->page_structure);
		$wp_rewrite->flush_rules();
	}
?>