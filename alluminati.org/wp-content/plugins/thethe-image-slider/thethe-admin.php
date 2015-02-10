<?php
if (!function_exists('TheThe_makeAdminPage')) {
	function TheThe_makeAdminPage(){
		include 'inc/view-about-us.php';
	}
}
function TheTheIS_Style(){
	$x = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));	
	if ( get_bloginfo('version') < 3.3 ) {
		wp_admin_css( 'nav-menu' );
	}	
	wp_deregister_style( 'thethefly-plugin-panel-interface');
	wp_register_style( 'thethefly-plugin-panel-interface', $x.'style/admin/interface.css' );
	wp_enqueue_style( 'thethefly-plugin-panel-interface' );

	wp_enqueue_script( 'postbox');
	wp_enqueue_script( 'post');
	
	wp_deregister_style( 'thethefly-color-picker');
	wp_register_script( 'thethefly-color-picker', $GLOBALS['TheTheIS']['wp_plugin_dir_url'].'style/admin/js/color-picker.js' );
	// Color picker
	wp_enqueue_style( 'farbtastic' );
	wp_enqueue_script( 'thethefly-color-picker' );
	wp_enqueue_script( 'farbtastic', false, array('thethefly-color-picker'));	
	
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_script("jquery-ui-sortable");
	wp_enqueue_script("jquery-ui-draggable");		
	wp_enqueue_style('thickbox');
		
	wp_enqueue_script('thethe-slider-admin-js', $x."style/admin/thethe-image-slider-admin.js");
	wp_enqueue_script('jquery-form');

	wp_enqueue_style('thethe-slider-admin-css', $x.'style/admin/thethe-image-slider-admin.css', false, false, 'screen');
			
}
	function TheTheIS_RegisterPluginLinks($links, $file) {
		$base = $GLOBALS['TheTheIS']['wp_plugin_base_name'];
		if ($file == $base) {
			$links[] = '<a href="admin.php?page=thethe-image-slider&view=sliders">' . __('Settings') . '</a>';
			$links[] = '<a href="http://thethefly.com/support/forum/wordpress-plugins-by-thethe-fly-group3/thethe-image-slider-forum13.0/">' . __('Support') . '</a>';
			$links[] = '<a href="http://thethefly.com/themes/">' . __('Themes') . '</a>';
			$links[] = '<a href="http://thethefly.com/wordpress-tips-tricks-hacks-newsletter/">' . __('Tips & Tricks') . '</a>';			
			$links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=U2DR7CUBZLPFG">' . __('Donate') . '</a>';
		}
		return $links;
	}
/**
 * Add menu to admin page
 */
function TheTheIS_Menu()
{
    global $menu;

    $flag['makebox'] = true;
    if (is_array($menu)) foreach ($menu as $e) {
        if (isset($e[0]) && (in_array($e[0], array('TheThe Fly','TheTheFly')))) {
            $flag['makebox'] = false;
            break;
        }
    }

    if ($flag['makebox']) {
		$icon_url = $GLOBALS['TheTheIS']['wp_plugin_dir_url'].'style/admin/images/favicon.ico';
		// Add a new top-level menu:
		add_menu_page('TheThe Fly', 'TheThe Fly', 'edit_theme_options', 'thethefly', 'TheThe_makeAdminPage',$icon_url, 63);
        // Add a submenu to the top-level menu:
		$panelHookAboutUs = add_submenu_page('thethefly', 'TheThe Fly: About the Club', 'About the Club', 'edit_theme_options', 'thethefly', 'TheThe_makeAdminPage');
    }

    $panelHook = add_submenu_page('thethefly', 'TheThe Image Slider','Image Slider','edit_theme_options','thethe-image-slider','TheTheIS_options');
	add_filter( 'admin_print_styles-' . $panelHookAboutUs, 'TheTheIS_Style');
	add_filter( 'admin_print_styles-' . $panelHook, 'TheTheIS_Style');	
	
	add_filter('plugin_row_meta', 'TheTheIS_RegisterPluginLinks',10,2);	
	
}
/**
 * Function TheTheIS_options
 */
function TheTheIS_options(){
	include 'inc/view-tabs.php';
}