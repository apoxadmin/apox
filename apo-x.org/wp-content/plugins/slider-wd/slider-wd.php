<?php

/**
 * Plugin Name: Slider WD
 * Plugin URI: https://web-dorado.com/products/wordpress-slider-plugin.html
 * Description: This is a responsive plugin, which allows adding sliders to your posts/pages and to custom location. It uses large number of transition effects and supports various types of layers.
 * Version: 1.1.63
 * Author: WebDorado
 * Author URI: https://web-dorado.com/
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

define('WD_S_NAME', plugin_basename(dirname(__FILE__))); 
define('WD_S_DIR', WP_PLUGIN_DIR . "/" . WD_S_NAME);
define('WD_S_URL', plugins_url(WD_S_NAME));

define('WD_S_VERSION', '1.1.63');

function wds_use_home_url() {
  $home_url = str_replace("http://", "", home_url());
  $home_url = str_replace("https://", "", $home_url);
  $pos = strpos($home_url, "/");
  if ($pos) {
    $home_url = substr($home_url, 0, $pos);
  }
  $site_url = str_replace("http://", "", WD_S_URL);
  $site_url = str_replace("https://", "", $site_url);
  $pos = strpos($site_url, "/");
  if ($pos) {
    $site_url = substr($site_url, 0, $pos);
  }
  return $site_url != $home_url;
}

if (wds_use_home_url()) {
  define('WD_S_FRONT_URL', home_url("wp-content/plugins/" . plugin_basename(dirname(__FILE__))));
}
else {
  define('WD_S_FRONT_URL', WD_S_URL);
}

$upload_dir = wp_upload_dir();
$WD_S_UPLOAD_DIR = str_replace(ABSPATH, '', $upload_dir['basedir']) . '/slider-wd';

// Plugin menu.
function wds_options_panel() {
  add_menu_page('Slider WD', 'Slider WD', 'manage_options', 'sliders_wds', 'wd_sliders', WD_S_URL . '/images/wd_slider.png');

  $sliders_page = add_submenu_page('sliders_wds', 'Sliders', 'Sliders', 'manage_options', 'sliders_wds', 'wd_sliders');
  add_action('admin_print_styles-' . $sliders_page, 'wds_styles');
  add_action('admin_print_scripts-' . $sliders_page, 'wds_scripts');

  $global_options_page = add_submenu_page('sliders_wds', 'Global Options', 'Global Options', 'manage_options', 'goptions_wds', 'wd_sliders');
  add_action('admin_print_styles-' . $global_options_page, 'wds_styles');
  add_action('admin_print_scripts-' . $global_options_page, 'wds_scripts');

  add_submenu_page('sliders_wds', 'Get Pro', 'Get Pro', 'manage_options', 'licensing_wds', 'wds_licensing');
  add_submenu_page('sliders_wds', 'Featured Plugins', 'Featured Plugins', 'manage_options', 'featured_plugins_wds', 'wds_featured');
  add_submenu_page('sliders_wds', 'Featured Themes', 'Featured Themes', 'manage_options', 'featured_themes_wds', 'wds_featured_themes'); 

  add_submenu_page('sliders_wds', 'Demo Sliders', 'Demo Sliders', 'manage_options', 'demo_sliders_wds', 'wds_demo_sliders'); 

  $uninstall_page = add_submenu_page('sliders_wds', 'Uninstall', 'Uninstall', 'manage_options', 'uninstall_wds', 'wd_sliders');
  add_action('admin_print_styles-' . $uninstall_page, 'wds_styles');
  add_action('admin_print_scripts-' . $uninstall_page, 'wds_scripts');
}
add_action('admin_menu', 'wds_options_panel');

function wd_sliders() {
  if (function_exists('current_user_can')) {
    if (!current_user_can('manage_options')) {
      die('Access Denied');
    }
  }
  else {
    die('Access Denied');
  }
  require_once(WD_S_DIR . '/framework/WDW_S_Library.php');
  $page = WDW_S_Library::get('page');
  if (($page != '') && (($page == 'sliders_wds') || ($page == 'uninstall_wds') || ($page == 'WDSShortcode') || ($page == 'goptions_wds'))) {
    require_once(WD_S_DIR . '/admin/controllers/WDSController' . (($page == 'WDSShortcode') ? $page : ucfirst(strtolower($page))) . '.php');
    $controller_class = 'WDSController' . ucfirst(strtolower($page));
    $controller = new $controller_class();
    $controller->execute();
  }
}

function wds_licensing() {
  if (function_exists('current_user_can')) {
    if (!current_user_can('manage_options')) {
      die('Access Denied');
    }
  }
  else {
    die('Access Denied');
  }
  wp_register_style('wds_licensing', WD_S_URL . '/licensing/style.css', array(), WD_S_VERSION);
  wp_print_styles('wds_licensing');
  require_once(WD_S_DIR . '/licensing/licensing.php');
}

function wds_featured() {
  if (function_exists('current_user_can')) {
    if (!current_user_can('manage_options')) {
      die('Access Denied');
    }
  }
  else {
    die('Access Denied');
  }
  require_once(WD_S_DIR . '/featured/featured.php');
  wp_register_style('wds_featured', WD_S_URL . '/featured/style.css', array(), WD_S_VERSION);
  wp_print_styles('wds_featured');
  spider_featured('slider_wd');
}

function wds_featured_themes() {
  if (function_exists('current_user_can')) {
    if (!current_user_can('manage_options')) {
      die('Access Denied');
    }
  }
  else {
    die('Access Denied');
  }
  require_once(WD_S_DIR . '/featured/featured_themes.php');
  wp_register_style('wds_featured_themes', WD_S_URL . '/featured/themes_style.css', array(), WD_S_VERSION);
  wp_print_styles('wds_featured_themes');
  spider_featured_themes('slider_wd');
}

function wds_demo_sliders() {
  if (function_exists('current_user_can')) {
    if (!current_user_can('manage_options')) {
      die('Access Denied');
    }
  }
  else {
    die('Access Denied');
  }
  require_once(WD_S_DIR . '/demo_sliders/demo_sliders.php');
  wp_register_style('wds_demo_sliders', WD_S_URL . '/demo_sliders/style.css', array(), WD_S_VERSION);
  wp_print_styles('wds_demo_sliders');
  spider_demo_sliders();
}

function wds_frontend() {
  require_once(WD_S_DIR . '/framework/WDW_S_Library.php');
  $page = WDW_S_Library::get('action');
  if (($page != '') && ($page == 'WDSShare')) {
    require_once(WD_S_DIR . '/frontend/controllers/WDSController' . ucfirst($page) . '.php');
    $controller_class = 'WDSController' . ucfirst($page);
    $controller = new $controller_class();
    $controller->execute();
  }
}

add_action('wp_ajax_WDSPreview', 'wds_preview');
function wds_ajax() {
  if (function_exists('current_user_can')) {
    if (!current_user_can('manage_options')) {
      die('Access Denied');
    }
  }
  else {
    die('Access Denied');
  }
  require_once(WD_S_DIR . '/framework/WDW_S_Library.php');
  $page = WDW_S_Library::get('action');
  if ($page != '' && (($page == 'WDSShortcode'))) {
    require_once(WD_S_DIR . '/admin/controllers/WDSController' . ucfirst($page) . '.php');
    $controller_class = 'WDSController' . ucfirst($page);
    $controller = new $controller_class();
    $controller->execute();
  }
}

function wds_shortcode($params) {
  $params = shortcode_atts(array('id' => 0), $params);
  ob_start();
  wds_front_end($params['id']);
  if ( is_admin() ) {
    // return ob_get_clean();
  }
  else {
    return str_replace(array("\r\n", "\n", "\r"), '', ob_get_clean());
  }
}
add_shortcode('wds', 'wds_shortcode');

function wd_slider($id) {
  echo wds_front_end($id);
}

$wds = 0;
function wds_front_end($id, $from_shortcode = 1) {
  require_once(WD_S_DIR . '/frontend/controllers/WDSControllerSlider.php');
  $controller = new WDSControllerSlider();
  global $wds;
  $controller->execute($id, $from_shortcode, $wds);
  $wds++;
  return;
}

function wds_preview() {
  require_once(WD_S_DIR . '/framework/WDW_S_Library.php');
  $page = WDW_S_Library::get('action');
  if ($page != '' && $page == 'WDSPreview') {
    wp_print_scripts('jquery');
    wp_register_script('wds_jquery_mobile', WD_S_URL . '/js/jquery.mobile.js', array(), WD_S_VERSION);
    wp_print_scripts('wds_jquery_mobile');
    wp_register_style('wds_frontend', WD_S_URL . '/css/wds_frontend.css', array(), WD_S_VERSION);
    wp_print_styles('wds_frontend');
    wp_register_style('wds_effects', WD_S_URL . '/css/wds_effects.css', array(), WD_S_VERSION);
    wp_print_styles('wds_effects');
    wp_register_style('wds_font-awesome', WD_S_URL . '/css/font-awesome/font-awesome.css', array(), '4.6.3');
    wp_print_styles('wds_font-awesome');
    wp_register_script('wds_frontend', WD_S_URL . '/js/wds_frontend.js', array(), WD_S_VERSION);
    wp_print_scripts('wds_frontend');
    global $wpdb;
    $rows = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "wdslayer ORDER BY `depth` ASC");
    $font_array = array();
    foreach ($rows as $row) {
      if (isset($row->google_fonts) && ($row->google_fonts == 1) && ($row->ffamily != "") && !in_array($row->ffamily, $font_array)) {
        $font_array[] = $row->ffamily;
      }
    }
    $query = implode("|", $font_array);
    if ($query != '') {
    ?>
      <link id="wds_googlefonts" media="all" type="text/css" href="https://fonts.googleapis.com/css?family=<?php echo $query . '&subset=greek,latin,greek-ext,vietnamese,cyrillic-ext,latin-ext,cyrillic'; ?>" rel="stylesheet">
    <?php
    }
    $id =  WDW_S_Library::get('slider_id');
    ?>
    <div class="wds_preview_cont1">
      <div class="wds_preview_cont2">
        <?php
    wds_front_end($id, 0);
        ?>
      </div>
    </div>
    <?php
  }
  die();
}

function wds_media_button($context) {
  global $pagenow;
  if (in_array($pagenow, array('post.php', 'page.php', 'post-new.php', 'post-edit.php', 'admin-ajax.php'))) {
    $context .= '
      <a onclick="tb_click.call(this); wds_thickDims(); return false;" href="' . add_query_arg(array('action' => 'WDSShortcode', 'TB_iframe' => '1'), admin_url('admin-ajax.php')) . '" class="wds_thickbox button" style="padding-left: 0.4em;" title="Select slider">
        <span class="wp-media-buttons-icon wds_media_button_icon" style="vertical-align: text-bottom; background: url(' . WD_S_URL . '/images/wd_slider.png) no-repeat scroll left top rgba(0, 0, 0, 0);"></span>
        Add Slider WD
      </a>';
  }
  return $context;
}
add_filter('media_buttons_context', 'wds_media_button');

// Add the Slider button to editor.
add_action('wp_ajax_WDSShortcode', 'wds_ajax');

function wds_admin_ajax() {
  ?>
  <script>
    var wds_thickDims, wds_tbWidth, wds_tbHeight;
    wds_tbWidth = 400;
    wds_tbHeight = 200;
    wds_thickDims = function() {
      var tbWindow = jQuery('#TB_window'), H = jQuery(window).height(), W = jQuery(window).width(), w, h;
      w = (wds_tbWidth && wds_tbWidth < W - 90) ? wds_tbWidth : W - 40;
      h = (wds_tbHeight && wds_tbHeight < H - 60) ? wds_tbHeight : H - 40;
      if (tbWindow.size()) {
        tbWindow.width(w).height(h);
        jQuery('#TB_iframeContent').width(w).height(h - 27);
        tbWindow.css({'margin-left': '-' + parseInt((w / 2),10) + 'px'});
        if (typeof document.body.style.maxWidth != 'undefined') {
          tbWindow.css({'top':(H-h)/2,'margin-top':'0'});
        }
      }
    };
  </script>
  <?php
}
add_action('admin_head', 'wds_admin_ajax');

// Add images to Slider.
add_action('wp_ajax_wds_UploadHandler', 'wds_UploadHandler');
add_action('wp_ajax_addImage', 'wds_filemanager_ajax');

// Upload.
function wds_UploadHandler() {
  require_once(WD_S_DIR . '/framework/WDW_S_Library.php');
  WDW_S_Library::verify_nonce('wds_UploadHandler');
  require_once(WD_S_DIR . '/filemanager/UploadHandler.php');
}

function wds_filemanager_ajax() { 
  if (function_exists('current_user_can')) {
    if (!current_user_can('manage_options')) {
      die('Access Denied');
    }
  }
  else {
    die('Access Denied');
  }
  global $wpdb;
  require_once(WD_S_DIR . '/framework/WDW_S_Library.php');
  $page = WDW_S_Library::get('action');
  if (($page != '') && (($page == 'addImage') || ($page == 'addMusic'))) {
    WDW_S_Library::verify_nonce($page);
    require_once(WD_S_DIR . '/filemanager/controller.php');
    $controller_class = 'FilemanagerController';
    $controller = new $controller_class();
    $controller->execute();
  }
}
// Slider Widget.
if (class_exists('WP_Widget')) {
  require_once(WD_S_DIR . '/admin/controllers/WDSControllerWidgetSlideshow.php');
  add_action('widgets_init', create_function('', 'return register_widget("WDSControllerWidgetSlideshow");'));
}

// Activate plugin.
function wds_activate() {
  global $wpdb;
  wds_install();
  if (!$wpdb->get_var("SELECT * FROM " . $wpdb->prefix . "wdsslider")) {
    $wpdb->insert(
      $wpdb->prefix . 'wdsslider', 
      array(
        'id' => 1,
        'name' => 'Default slider',
        'published' => 1,
        'full_width' => 0,
        'width' => 800,
        'height' => 300,
        'bg_fit' => 'cover',
        'align' => 'center',
        'effect' => 'none',
        'time_intervval' => 5,
        'autoplay' => 1,
        'shuffle' => 0,
        'music' => 0,
        'music_url' => '',
        'preload_images' => 1,
        'background_color' => '000000',
        'background_transparent' => 100,
        'glb_border_width' => 0,
        'glb_border_style' => 'none',
        'glb_border_color' => 'FFFFFF',
        'glb_border_radius' => '',
        'glb_margin' => 0,
        'glb_box_shadow' => '',
        'image_right_click' => 0,
        'layer_out_next' => 1,
        'prev_next_butt' => 1,
        'play_paus_butt' => 0,
        'navigation' => 'hover',
        'rl_butt_style' => 'fa-angle',
        'rl_butt_size' => 40,
        'pp_butt_size' => 40,
        'butts_color' => 'FFFFFF',
        'butts_transparent' => 100,
        'hover_color' => 'CCCCCC',
        'nav_border_width' => 0,
        'nav_border_style' => 'none',
        'nav_border_color' => 'FFFFFF',
        'nav_border_radius' => '20px',
        'nav_bg_color' => 'FFFFFF',
        'bull_position' => 'bottom',
        'bull_style' => 'fa-square-o',
        'bull_size' => 20,
        'bull_color' => 'FFFFFF',
        'bull_act_color' => 'FFFFFF',
        'bull_margin' => 3,
        'film_pos' => 'none',
        'film_thumb_width' => 100,
        'film_thumb_height' => 50,
        'film_bg_color' => '000000',
        'film_tmb_margin' => 0,
        'film_act_border_width' => 0,
        'film_act_border_style' => 'none',
        'film_act_border_color' => 'FFFFFF',
        'film_dac_transparent' => 50,
        'timer_bar_type' => 'none',
        'timer_bar_size' => 5,
        'timer_bar_color' => 'FFFFFF',
        'timer_bar_transparent' => 50,
        'built_in_watermark_type' => 'none',
        'built_in_watermark_position' => 'middle-center',
        'built_in_watermark_size' => 15,
        'built_in_watermark_url' => WD_S_URL . '/images/watermark.png',
        'built_in_watermark_text' => 'web-dorado.com',
        'built_in_watermark_font_size' => 20,
        'built_in_watermark_font' => '',
        'built_in_watermark_color' => 'FFFFFF',
        'built_in_watermark_opacity' => 70,
        'css' => '',
        'stop_animation' => 0,
        'spider_uploader' => 0,
        'right_butt_url' => WD_S_URL . '/images/arrow/arrow11/1/2.png',
        'left_butt_url' => WD_S_URL . '/images/arrow/arrow11/1/1.png',
        'right_butt_hov_url' => WD_S_URL . '/images/arrow/arrow11/1/4.png',
        'left_butt_hov_url' => WD_S_URL . '/images/arrow/arrow11/1/3.png',
        'rl_butt_img_or_not' => 'style',
        'bullets_img_main_url' => WD_S_URL . '/images/bullet/bullet1/1/1.png',
        'bullets_img_hov_url' => WD_S_URL . '/images/bullet/bullet1/1/2.png',
        'bull_butt_img_or_not' => 'style',
        'play_butt_url' => WD_S_URL . '/images/button/button4/1/1.png',
        'paus_butt_url' => WD_S_URL . '/images/button/button4/1/3.png',
        'play_butt_hov_url' => WD_S_URL . '/images/button/button4/1/2.png',
        'paus_butt_hov_url' => WD_S_URL . '/images/button/button4/1/4.png',
        'play_paus_butt_img_or_not' => 'style',
        'start_slide_num' => 1,
        'effect_duration' => 800,
        'carousel' => 0,
        'carousel_image_counts' => 7,
        'carousel_image_parameters' => '0.85',
        'carousel_fit_containerWidth' => 0,
        'carousel_width' => 1000,
        'parallax_effect' => 0,
        'mouse_swipe_nav' => 0,
        'bull_hover' => 1,
        'touch_swipe_nav' => 1,
        'mouse_wheel_nav' => 0,
        'keyboard_nav' => 0,
        'possib_add_ffamily' => '',
        'show_thumbnail' => 0,
        'thumb_size' => '0.2',
        'fixed_bg' => 0,
        'smart_crop' => 0,
        'crop_image_position' => 'center center',
        'javascript' => '',
        'carousel_degree' => 0,
        'carousel_grayscale' => 0,
        'carousel_transparency' => 0,
        'bull_back_act_color' => '000000',
        'bull_back_color' => 'CCCCCC',
        'bull_radius' => '20px',
        'possib_add_google_fonts' => 0,
        'possib_add_ffamily_google' => '',
        'slider_loop' => 1,
        'hide_on_mobile' => 1,
        'twoway_slideshow' => 0,
      )
    );
  }
  if (!$wpdb->get_var("SELECT * FROM " . $wpdb->prefix . "wdsslide")) {
    $wpdb->query('INSERT INTO `' . $wpdb->prefix . 'wdsslide` VALUES(1, 1, "Slide 1", "image", "' . WD_S_URL . '/demo/1.jpg", "' . WD_S_URL . '/demo/1-150x150.jpg", 1, "", 1, 0, 0, 0)');
    $wpdb->query('INSERT INTO `' . $wpdb->prefix . 'wdsslide` VALUES(2, 1, "Slide 2", "image", "' . WD_S_URL . '/demo/2.jpg", "' . WD_S_URL . '/demo/2-150x150.jpg", 1, "", 2, 0, 0, 0)');
    $wpdb->query('INSERT INTO `' . $wpdb->prefix . 'wdsslide` VALUES(3, 1, "Slide 3", "image", "' . WD_S_URL . '/demo/3.jpg", "' . WD_S_URL . '/demo/3-150x150.jpg", 1, "", 3, 0, 0, 0)');
  }
}
register_activation_hook(__FILE__, 'wds_activate');

function wds_install() {
  $version = get_option("wds_version");
  $new_version = WD_S_VERSION;
  if ($version && version_compare($version, $new_version, '<')) {
    require_once WD_S_DIR . "/sliders-update.php";
    wds_update($version);
    update_option("wds_version", $new_version);
  }
  elseif (!$version) {
    require_once WD_S_DIR . "/sliders-insert.php";
    wds_insert();
    add_option("wds_theme_version", '1.0.0', '', 'no');
    add_option("wds_version", $new_version, '', 'no');
    add_option("wds_version_1.0.46", 1, '', 'no');
  }
}
if (!isset($_GET['action']) || $_GET['action'] != 'deactivate') {
  add_action('admin_init', 'wds_install');
}

// Plugin styles.
function wds_styles() {
  wp_admin_css('thickbox');
  wp_enqueue_style('wds_tables', WD_S_URL . '/css/wds_tables.css', array(), WD_S_VERSION);
  wp_enqueue_style('wds_tables_640', WD_S_URL . '/css/wds_tables_640.css', array(), WD_S_VERSION);
  wp_enqueue_style('wds_tables_320', WD_S_URL . '/css/wds_tables_320.css', array(), WD_S_VERSION);
  require_once(WD_S_DIR . '/framework/WDW_S_Library.php');
  $google_fonts = WDW_S_Library::get_google_fonts();
  for ($i = 0; $i < count($google_fonts); $i = $i + 150) {
    $fonts = array_slice($google_fonts, $i, 150);
    $query = implode("|", str_replace(' ', '+', $fonts));
    $url = 'https://fonts.googleapis.com/css?family=' . $query . '&subset=greek,latin,greek-ext,vietnamese,cyrillic-ext,latin-ext,cyrillic';
    wp_enqueue_style('wds_googlefonts_' . $i, $url, null, null);
  }
}

// Plugin scripts.
function wds_scripts() {
  wp_enqueue_media();
  wp_enqueue_script('thickbox');
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-ui-sortable');
  wp_enqueue_script('jquery-ui-draggable');
  wp_enqueue_script('jquery-ui-tooltip');
  wp_enqueue_script('wds_admin', WD_S_URL . '/js/wds.js', array(), WD_S_VERSION);
  wp_enqueue_script('jscolor', WD_S_URL . '/js/jscolor/jscolor.js', array(), '1.3.9');
  wp_enqueue_style('wds_font-awesome', WD_S_URL . '/css/font-awesome/font-awesome.css', array(), '4.6.3');
  wp_enqueue_style('wds_effects', WD_S_URL . '/css/wds_effects.css', array(), WD_S_VERSION);
  wp_enqueue_style('wds_tooltip', WD_S_URL . '/css/jquery-ui-1.10.3.custom.css', array(), WD_S_VERSION);
  require_once(WD_S_DIR . '/framework/WDW_S_Library.php');
  wp_localize_script('wds_admin', 'wds_objectGGF', WDW_S_Library::get_google_fonts());
}

function wds_front_end_scripts() {
  global $wpdb;
  $rows = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "wdslayer ORDER BY `depth` ASC");
  $font_array = array();
  foreach ($rows as $row) {
    if (isset($row->google_fonts) && ($row->google_fonts == 1) && ($row->ffamily != "") && !in_array($row->ffamily, $font_array)) {
      $font_array[] = $row->ffamily;
	  }
  }
  $query = implode("|", $font_array);
  if ($query != '') {
    $url = 'https://fonts.googleapis.com/css?family=' . $query . '&subset=greek,latin,greek-ext,vietnamese,cyrillic-ext,latin-ext,cyrillic';
  }

  $wds_register_scripts = get_option("wds_register_scripts");

  if (!$wds_register_scripts) {
    wp_enqueue_script('wds_jquery_mobile', WD_S_FRONT_URL . '/js/jquery.mobile.js', array('jquery'), WD_S_VERSION);

    wp_enqueue_script('wds_frontend', WD_S_FRONT_URL . '/js/wds_frontend.js', array('jquery'), WD_S_VERSION);
    wp_enqueue_style('wds_frontend', WD_S_FRONT_URL . '/css/wds_frontend.css', array(), WD_S_VERSION);
    wp_enqueue_style('wds_effects', WD_S_FRONT_URL . '/css/wds_effects.css', array(), WD_S_VERSION);

    wp_enqueue_style('wds_font-awesome', WD_S_FRONT_URL . '/css/font-awesome/font-awesome.css', array(), '4.6.3');
    if ($query != '') {
      wp_enqueue_style('wds_googlefonts', $url, null, null);
    }
  }
  else {
    wp_register_script('wds_jquery_mobile', WD_S_FRONT_URL . '/js/jquery.mobile.js', array('jquery'), WD_S_VERSION);

    wp_register_script('wds_frontend', WD_S_FRONT_URL . '/js/wds_frontend.js', array('jquery'), WD_S_VERSION);
    wp_register_style('wds_frontend', WD_S_FRONT_URL . '/css/wds_frontend.css', array(), WD_S_VERSION);
    wp_register_style('wds_effects', WD_S_FRONT_URL . '/css/wds_effects.css', array(), WD_S_VERSION);

    wp_register_style('wds_font-awesome', WD_S_FRONT_URL . '/css/font-awesome/font-awesome.css', array(), '4.6.3');
    if ($query != '') {
      wp_register_style('wds_googlefonts', $url, null, null);
    }
  }
}
add_action('wp_enqueue_scripts', 'wds_front_end_scripts');

// Languages localization.
function wds_language_load() {
  load_plugin_textdomain('wds', FALSE, basename(dirname(__FILE__)) . '/languages');
}
add_action('init', 'wds_language_load');

if (is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX)) {
	include_once(WD_S_DIR . '/sliders-notices.php');
  new WDS_Notices();
}

function wds_get_sliders() {
  global $wpdb;
  $results = $wpdb->get_results("SELECT `id`,`name` FROM `" . $wpdb->prefix . "wdsslider`", OBJECT_K);
  $sliders = array();
  foreach ($results as $id => $slider) {
    $sliders[$id] = isset($slider->name) ? $slider->name : '';
  }
  return $sliders;
}
?>