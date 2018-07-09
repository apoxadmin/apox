<?php

class WDSControllerSliders_wds {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function __construct() {
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function execute() {
    $task = WDW_S_Library::get('task');
    $id = WDW_S_Library::get('current_id', 0);
    $message = WDW_S_Library::get('message');
    echo WDW_S_Library::message_id($message);
    if (method_exists($this, $task)) {
      check_admin_referer('nonce_wd', 'nonce_wd');
      $this->$task($id);
    }
    else {
      $this->display();
    }
  }

  public function display() {
    require_once WD_S_DIR . "/admin/models/WDSModelSliders_wds.php";
    $model = new WDSModelSliders_wds();

    require_once WD_S_DIR . "/admin/views/WDSViewSliders_wds.php";
    $view = new WDSViewSliders_wds($model);
    $view->display();
  }

  public function add() {
    require_once WD_S_DIR . "/admin/models/WDSModelSliders_wds.php";
    $model = new WDSModelSliders_wds();

    require_once WD_S_DIR . "/admin/views/WDSViewSliders_wds.php";
    $view = new WDSViewSliders_wds($model);
    $view->edit(0);
  }

  public function edit() {
    require_once WD_S_DIR . "/admin/models/WDSModelSliders_wds.php";
    $model = new WDSModelSliders_wds();

    require_once WD_S_DIR . "/admin/views/WDSViewSliders_wds.php";
    $view = new WDSViewSliders_wds($model);
    $id = ((isset($_POST['current_id']) && esc_html(stripslashes($_POST['current_id'])) != '') ? esc_html(stripslashes($_POST['current_id'])) : 0);
    $view->edit($id);
  }

  public function save() {
    $page = WDW_S_Library::get('page');
    WDW_S_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'display', 'message' => 1), admin_url('admin.php')));
  }

  public function apply() {
    $this->save_slider_db();
    $this->save_slide_db();
    $this->edit();
  }

  public function save_slider_db() {
    global $wpdb;
    if (get_option("wds_theme_version")) {
      $allow = FALSE;
    }
    else {
      $allow = TRUE;
    }
    $slider_id = (isset($_POST['current_id']) ? (int) $_POST['current_id'] : 0);
    $slider_data = (isset($_POST['slider_data']) ? stripslashes($_POST['slider_data']) : '');
    $params_array = json_decode($slider_data, TRUE);
    $del_slide_ids_string = (isset($params_array['del_slide_ids_string']) ? substr(esc_html(stripslashes($params_array['del_slide_ids_string'])), 0, -1) : '');
    if ($del_slide_ids_string) {
      $wpdb->query('DELETE FROM ' . $wpdb->prefix . 'wdsslide WHERE id IN (' . $del_slide_ids_string . ')');
    }
    $name = ((isset($params_array['name'])) ? esc_html(stripslashes($params_array['name'])) : '');
    $published = ((isset($params_array['published'])) ? (int) esc_html(stripslashes($params_array['published'])) : 1);
    $full_width = ((isset($params_array['full_width'])) ? (int) esc_html(stripslashes($params_array['full_width'])) : 0);
    $spider_uploader = ((isset($params_array['spider_uploader'])) ? (int) esc_html(stripslashes($params_array['spider_uploader'])) : 0);
    $width = ((isset($params_array['width'])) ? (int) esc_html(stripslashes($params_array['width'])) : 800);
    $height = ((isset($params_array['height'])) ? (int) esc_html((stripslashes($params_array['height']))) : 300);
    $bg_fit = ((isset($params_array['bg_fit'])) ? esc_html(stripslashes($params_array['bg_fit'])) : 'cover');
    $align = ((isset($params_array['align'])) ? esc_html(stripslashes($params_array['align'])) : 'center');
    $effect = ((isset($params_array['effect'])) ? esc_html(stripslashes($params_array['effect'])) : 'fade');
    $time_intervval = ((isset($params_array['time_intervval'])) ? (int) esc_html(stripslashes($params_array['time_intervval'])) : 5);
    $autoplay = ((isset($params_array['autoplay'])) ? (int) esc_html(stripslashes($params_array['autoplay'])) : 1);
    $shuffle = ((isset($params_array['shuffle'])) ? (int) esc_html(stripslashes($params_array['shuffle'])) : 0);
    $music = ((isset($params_array['music'])) ? (int) esc_html(stripslashes($params_array['music'])) : 0);	
    $music_url = ((isset($params_array['music_url'])) ? esc_html(stripslashes($params_array['music_url'])) : '');
    $music_url = str_replace(site_url(), '{site_url}', $music_url);
    $preload_images = ((isset($params_array['preload_images'])) ? (int) esc_html(stripslashes($params_array['preload_images'])) : 1);
    $background_color = ((isset($params_array['background_color'])) ? esc_html(stripslashes($params_array['background_color'])) : '000000');
    $background_transparent = ((isset($params_array['background_transparent'])) ? esc_html(stripslashes($params_array['background_transparent'])) : 100);
    $glb_border_width = ((isset($params_array['glb_border_width'])) ? (int) esc_html(stripslashes($params_array['glb_border_width'])) : 0);
    $glb_border_style = ((isset($params_array['glb_border_style'])) ? esc_html(stripslashes($params_array['glb_border_style'])) : 'none');	
    $glb_border_color = ((isset($params_array['glb_border_color'])) ? esc_html(stripslashes($params_array['glb_border_color'])) : '000000');
    $glb_border_radius = ((isset($params_array['glb_border_radius'])) ? esc_html(stripslashes($params_array['glb_border_radius'])) : '');
    $glb_margin = ((isset($params_array['glb_margin'])) ? (int) esc_html(stripslashes($params_array['glb_margin'])) : 0);
    $glb_box_shadow = ((isset($params_array['glb_box_shadow'])) ? esc_html(stripslashes($params_array['glb_box_shadow'])) : '');
    $image_right_click = ((isset($params_array['image_right_click'])) ? (int) esc_html(stripslashes($params_array['image_right_click'])) : 0);
    $layer_out_next = ((isset($params_array['layer_out_next'])) ? (int) esc_html(stripslashes($params_array['layer_out_next'])) : 0);
    $prev_next_butt = ((isset($params_array['prev_next_butt'])) ? (int) esc_html(stripslashes($params_array['prev_next_butt'])) : 1);	
    $play_paus_butt = ((isset($params_array['play_paus_butt'])) ? (int) esc_html(stripslashes($params_array['play_paus_butt'])) : 0);
    $navigation = ((isset($params_array['navigation'])) ? esc_html(stripslashes($params_array['navigation'])) : 'hover');
    $rl_butt_style = ((isset($params_array['rl_butt_style'])) ? esc_html(stripslashes($params_array['rl_butt_style'])) : 'fa-angle');
    $rl_butt_size = ((isset($params_array['rl_butt_size'])) ? (int) esc_html(stripslashes($params_array['rl_butt_size'])) : 40);
    $pp_butt_size = ((isset($params_array['pp_butt_size'])) ? (int) esc_html(stripslashes($params_array['pp_butt_size'])) : 40);	
    $butts_color = ((isset($params_array['butts_color'])) ? esc_html(stripslashes($params_array['butts_color'])) : '000000');
    $butts_transparent = ((isset($params_array['butts_transparent'])) ? (int) esc_html(stripslashes($params_array['butts_transparent'])) : 100);
    $hover_color = ((isset($params_array['hover_color'])) ? esc_html(stripslashes($params_array['hover_color'])) : 'FFFFFF');
    $nav_border_width = ((isset($params_array['nav_border_width'])) ? (int) esc_html(stripslashes($params_array['nav_border_width'])) : 0);
    $nav_border_style = ((isset($params_array['nav_border_style'])) ? esc_html(stripslashes($params_array['nav_border_style'])) : 'none');
    $nav_border_color = ((isset($params_array['nav_border_color'])) ? esc_html(stripslashes($params_array['nav_border_color'])) : 'FFFFFF');	
    $nav_border_radius = ((isset($params_array['nav_border_radius'])) ? esc_html(stripslashes($params_array['nav_border_radius'])) : '20px');
    $nav_bg_color = ((isset($params_array['nav_bg_color'])) ? esc_html(stripslashes($params_array['nav_bg_color'])) : 'FFFFFF');
    $bull_position = ((isset($params_array['bull_position'])) ? esc_html(stripslashes($params_array['bull_position'])) : 'bottom');
    if (isset($params_array['enable_bullets']) && (esc_html(stripslashes($params_array['enable_bullets'])) == 0)) {
      $bull_position = 'none';
    }
    $bull_style = ((isset($params_array['bull_style']) && $allow) ? esc_html(stripslashes($params_array['bull_style'])) : 'fa-square-o');
    $bull_size = ((isset($params_array['bull_size']) && $allow) ? (int) esc_html(stripslashes($params_array['bull_size'])) : 20);
    $bull_color = ((isset($params_array['bull_color']) && $allow) ? esc_html(stripslashes($params_array['bull_color'])) : 'FFFFFF');	
    $bull_act_color = ((isset($params_array['bull_act_color']) && $allow) ? esc_html(stripslashes($params_array['bull_act_color'])) : 'FFFFFF');
    $bull_margin = ((isset($params_array['bull_margin']) && $allow) ? (int) esc_html(stripslashes($params_array['bull_margin'])) : 3);
    $film_pos = ((isset($params_array['film_pos'])) ? esc_html(stripslashes($params_array['film_pos'])) : 'none');
    if (isset($params_array['enable_filmstrip']) && (esc_html(stripslashes($params_array['enable_filmstrip'])) == 0)) {
      $film_pos = 'none';
    }
    $film_thumb_width = ((isset($params_array['film_thumb_width'])) ? (int) esc_html(stripslashes($params_array['film_thumb_width'])) : 100);
    $film_thumb_height = ((isset($params_array['film_thumb_height'])) ? (int) esc_html(stripslashes($params_array['film_thumb_height'])) : 50);
    $film_bg_color = ((isset($params_array['film_bg_color'])) ? esc_html(stripslashes($params_array['film_bg_color'])) : '000000');	
    $film_tmb_margin = ((isset($params_array['film_tmb_margin'])) ? (int) esc_html(stripslashes($params_array['film_tmb_margin'])) : 0);
    $film_act_border_width = ((isset($params_array['film_act_border_width'])) ? (int) esc_html(stripslashes($params_array['film_act_border_width'])) : 0);
    $film_act_border_style = ((isset($params_array['film_act_border_style'])) ? esc_html(stripslashes($params_array['film_act_border_style'])) : 'none');
    $film_act_border_color = ((isset($params_array['film_act_border_color'])) ? esc_html(stripslashes($params_array['film_act_border_color'])) : 'FFFFFF');
    $film_dac_transparent = ((isset($params_array['film_dac_transparent'])) ? (int) esc_html(stripslashes($params_array['film_dac_transparent'])) : 50);	
    $built_in_watermark_type = (isset($params_array['built_in_watermark_type']) ? esc_html(stripslashes($params_array['built_in_watermark_type'])) : 'none');
    $built_in_watermark_position = (isset($params_array['built_in_watermark_position']) ? esc_html(stripslashes($params_array['built_in_watermark_position'])) : 'middle-center');
    $built_in_watermark_size = (isset($params_array['built_in_watermark_size']) ? esc_html(stripslashes($params_array['built_in_watermark_size'])) : 15);
    $built_in_watermark_url = (isset($params_array['built_in_watermark_url']) ? esc_html(stripslashes($params_array['built_in_watermark_url'])) : '');
    $built_in_watermark_url = str_replace(site_url(), '{site_url}', $built_in_watermark_url);
    $built_in_watermark_text = (isset($params_array['built_in_watermark_text']) ? esc_html(stripslashes($params_array['built_in_watermark_text'])) : 'web-dorado.com');
    $built_in_watermark_opacity = (isset($params_array['built_in_watermark_opacity']) ? esc_html(stripslashes($params_array['built_in_watermark_opacity'])) : 70);
    $built_in_watermark_font_size = (isset($params_array['built_in_watermark_font_size']) ? esc_html(stripslashes($params_array['built_in_watermark_font_size'])) : 20);
    $built_in_watermark_font = (isset($params_array['built_in_watermark_font']) ? esc_html(stripslashes($params_array['built_in_watermark_font'])) : '');
    $built_in_watermark_color = (isset($params_array['built_in_watermark_color']) ? esc_html(stripslashes($params_array['built_in_watermark_color'])) : 'FFFFFF');
    $css = (isset($params_array['css']) ? htmlspecialchars_decode((stripslashes($params_array['css'])), ENT_QUOTES) : '');
    $timer_bar_type = (isset($params_array['timer_bar_type']) ? esc_html(stripslashes($params_array['timer_bar_type'])) : 'top');
    if (isset($params_array['enable_time_bar']) && (esc_html(stripslashes($params_array['enable_time_bar'])) == 0)) {
      $timer_bar_type = 'none';
    }
    $timer_bar_size = (isset($params_array['timer_bar_size']) ? esc_html(stripslashes($params_array['timer_bar_size'])) : 5);
    $timer_bar_color = (isset($params_array['timer_bar_color']) ? esc_html(stripslashes($params_array['timer_bar_color'])) : 'BBBBBB');
    $timer_bar_transparent = (isset($params_array['timer_bar_transparent']) ? esc_html(stripslashes($params_array['timer_bar_transparent'])) : 50);
    $stop_animation = ((isset($params_array['stop_animation'])) ? (int) esc_html(stripslashes($params_array['stop_animation'])) : 0);
    $right_butt_url = (isset($params_array['right_butt_url']) ? esc_html(stripslashes($params_array['right_butt_url'])) : '');
    $right_butt_url = str_replace(site_url(), '{site_url}', $right_butt_url);
    $left_butt_url = (isset($params_array['left_butt_url']) ? esc_html(stripslashes($params_array['left_butt_url'])) : '');
    $left_butt_url = str_replace(site_url(), '{site_url}', $left_butt_url);
    $right_butt_hov_url = (isset($params_array['right_butt_hov_url']) ? esc_html(stripslashes($params_array['right_butt_hov_url'])) : '');
    $right_butt_hov_url = str_replace(site_url(), '{site_url}', $right_butt_hov_url);
    $left_butt_hov_url = (isset($params_array['left_butt_hov_url']) ? esc_html(stripslashes($params_array['left_butt_hov_url'])) : '');
    $left_butt_hov_url = str_replace(site_url(), '{site_url}', $left_butt_hov_url);
    $rl_butt_img_or_not = (isset($params_array['rl_butt_img_or_not']) ? esc_html(stripslashes($params_array['rl_butt_img_or_not'])) : 'style');
    $bullets_img_main_url = (isset($params_array['bullets_img_main_url']) ? esc_html(stripslashes($params_array['bullets_img_main_url'])) : '');
    $bullets_img_main_url = str_replace(site_url(), '{site_url}', $bullets_img_main_url);
    $bullets_img_hov_url = (isset($params_array['bullets_img_hov_url']) ? esc_html(stripslashes($params_array['bullets_img_hov_url'])) : '');
    $bullets_img_hov_url = str_replace(site_url(), '{site_url}', $bullets_img_hov_url);
    $bull_butt_img_or_not = (isset($params_array['bull_butt_img_or_not']) ? esc_html(stripslashes($params_array['bull_butt_img_or_not'])) : 'style');
    $play_paus_butt_img_or_not = (isset($params_array['play_paus_butt_img_or_not']) ? esc_html(stripslashes($params_array['play_paus_butt_img_or_not'])) : 'style');
    $play_butt_url = (isset($params_array['play_butt_url']) ? esc_html(stripslashes($params_array['play_butt_url'])) : '');
    $play_butt_url = str_replace(site_url(), '{site_url}', $play_butt_url);
    $play_butt_hov_url = (isset($params_array['play_butt_hov_url']) ? esc_html(stripslashes($params_array['play_butt_hov_url'])) : '');
    $play_butt_hov_url = str_replace(site_url(), '{site_url}', $play_butt_hov_url);
    $paus_butt_url = (isset($params_array['paus_butt_url']) ? esc_html(stripslashes($params_array['paus_butt_url'])) : '');
    $paus_butt_url = str_replace(site_url(), '{site_url}', $paus_butt_url);
    $paus_butt_hov_url = (isset($params_array['paus_butt_hov_url']) ? esc_html(stripslashes($params_array['paus_butt_hov_url'])) : '');
    $paus_butt_hov_url = str_replace(site_url(), '{site_url}', $paus_butt_hov_url);
    $start_slide_num = ((isset($params_array['start_slide_num'])) ? (int) stripslashes($params_array['start_slide_num']) : 1);
    $effect_duration = ((isset($params_array['effect_duration'])) ? (int) stripslashes($params_array['effect_duration']) : 800);
    $carousel = 0;
    $carousel_image_counts = 7;
    $carousel_image_parameters = 0.85;
    $carousel_fit_containerWidth = 0;
    $carousel_width = 1000;
    $parallax_effect = 0;
    $mouse_swipe_nav = ((isset($params_array['mouse_swipe_nav'])) ? (int) esc_html(stripslashes($params_array['mouse_swipe_nav'])) : 0);
    $bull_hover = ((isset($params_array['bull_hover'])) ? (int) esc_html(stripslashes($params_array['bull_hover'])) : 1);
    $touch_swipe_nav = ((isset($params_array['touch_swipe_nav'])) ? (int) esc_html(stripslashes($params_array['touch_swipe_nav'])) : 1);
    $mouse_wheel_nav = ((isset($params_array['mouse_wheel_nav'])) ? (int) esc_html(stripslashes($params_array['mouse_wheel_nav'])) : 0);
    $keyboard_nav = ((isset($params_array['keyboard_nav'])) ? (int) esc_html(stripslashes($params_array['keyboard_nav'])) : 0);
    $possib_add_ffamily = ((isset($params_array['possib_add_ffamily'])) ? esc_html(stripslashes($params_array['possib_add_ffamily'])) : '');
    $show_thumbnail = ((isset($params_array['show_thumbnail'])) ? (int) esc_html(stripslashes($params_array['show_thumbnail'])) : 0);
    $thumb_size = ((isset($params_array['thumb_size'])) ? esc_html(stripslashes($params_array['thumb_size'])) : '0.3');
    $fixed_bg = ((isset($params_array['fixed_bg'])) ? (int) esc_html(stripslashes($params_array['fixed_bg'])) : 0);
    $smart_crop = ((isset($params_array['smart_crop'])) ? (int) esc_html(stripslashes($params_array['smart_crop'])) : 0);
    $crop_image_position = ((isset($params_array['crop_image_position'])) ? esc_html(stripslashes($params_array['crop_image_position'])) : 'middle-center');
    $javascript = ((isset($params_array['javascript'])) ? $params_array['javascript'] : '');
    $carousel_degree = ((isset($params_array['carousel_degree'])) ? (int) esc_html(stripslashes($params_array['carousel_degree'])) : 0);
    $carousel_grayscale = ((isset($params_array['carousel_grayscale'])) ? (int) esc_html(stripslashes($params_array['carousel_grayscale'])) : 0);
    $carousel_transparency = ((isset($params_array['carousel_transparency'])) ? (int) esc_html(stripslashes($params_array['carousel_transparency'])) : 0);
    $bull_back_act_color = ((isset($params_array['bull_back_act_color'])) ? esc_html(stripslashes($params_array['bull_back_act_color'])) : '000000');
    $bull_back_color = ((isset($params_array['bull_back_color'])) ? esc_html(stripslashes($params_array['bull_back_color'])) : 'CCCCCC');
    $bull_radius = ((isset($params_array['bull_radius'])) ? esc_html(stripslashes($params_array['bull_radius'])) : '20px');
    $possib_add_google_fonts = ((isset($params_array['possib_add_google_fonts'])) ? (int) esc_html(stripslashes($params_array['possib_add_google_fonts'])) : 0);
    $possib_add_ffamily_google = ((isset($params_array['possib_add_ffamily_google'])) ? esc_html(stripslashes($params_array['possib_add_ffamily_google'])) : '');
    $slider_loop = ((isset($params_array['slider_loop'])) ? (int) esc_html(stripslashes($params_array['slider_loop'])) : 1);
    $hide_on_mobile = ((isset($params_array['hide_on_mobile'])) ? (int) esc_html(stripslashes($params_array['hide_on_mobile'])) : 0);
    $twoway_slideshow = ((isset($params_array['twoway_slideshow'])) ? (int) esc_html(stripslashes($params_array['twoway_slideshow'])) : 0);
    $data = array(
      'name' => $name,
      'published' => $published,
      'full_width' => $full_width,
      'width' => $width,
      'height' => $height,
      'bg_fit' => $bg_fit,
      'align' => $align,
      'effect' => $effect,
      'time_intervval' => $time_intervval,
      'autoplay' => $autoplay,
      'shuffle' => $shuffle,
      'music' => $music,
      'music_url' => $music_url,
      'preload_images' => $preload_images, 
      'background_color' => $background_color,
      'background_transparent' => $background_transparent,
      'glb_border_width' => $glb_border_width,
      'glb_border_style' => $glb_border_style,
      'glb_border_color' => $glb_border_color,
      'glb_border_radius' => $glb_border_radius,
      'glb_margin' => $glb_margin,
      'glb_box_shadow' => $glb_box_shadow,
      'image_right_click' => $image_right_click,
      'prev_next_butt' => $prev_next_butt,	
      'play_paus_butt' => $play_paus_butt,
      'navigation' => $navigation,
      'rl_butt_style' => $rl_butt_style,
      'rl_butt_size' => $rl_butt_size,
      'pp_butt_size' => $pp_butt_size,	
      'butts_color' => $butts_color,
      'butts_transparent' => $butts_transparent,
      'hover_color' => $hover_color,
      'nav_border_width' => $nav_border_width,
      'nav_border_style' => $nav_border_style,
      'nav_border_color' => $nav_border_color,
      'nav_border_radius' => $nav_border_radius,
      'nav_bg_color' => $nav_bg_color,
      'bull_position' => $bull_position,
      'bull_style' => $bull_style,
      'bull_size' => $bull_size,
      'bull_color' => $bull_color,
      'bull_act_color' => $bull_act_color,
      'bull_margin' => $bull_margin,
      'film_pos' => $film_pos,
      'film_thumb_width' => $film_thumb_width,
      'film_thumb_height' => $film_thumb_height,
      'film_bg_color' => $film_bg_color,
      'film_tmb_margin' => $film_tmb_margin,
      'film_act_border_width' => $film_act_border_width,
      'film_act_border_style' => $film_act_border_style,
      'film_act_border_color' => $film_act_border_color,
      'film_dac_transparent' => $film_dac_transparent,	
      'built_in_watermark_type' => $built_in_watermark_type,
      'built_in_watermark_position' => $built_in_watermark_position,
      'built_in_watermark_size' => $built_in_watermark_size,
      'built_in_watermark_url' => $built_in_watermark_url,
      'built_in_watermark_text' => $built_in_watermark_text,
      'built_in_watermark_opacity' => $built_in_watermark_opacity,		
      'built_in_watermark_font_size' => $built_in_watermark_font_size,
      'built_in_watermark_font' => $built_in_watermark_font,
      'built_in_watermark_color' => $built_in_watermark_color,
      'css' => $css,
      'timer_bar_type' => $timer_bar_type,
      'timer_bar_size' => $timer_bar_size,
      'timer_bar_color' => $timer_bar_color,
      'timer_bar_transparent' => $timer_bar_transparent,
      'layer_out_next' => $layer_out_next,
      'spider_uploader' => $spider_uploader,
      'stop_animation' => $stop_animation,
      'right_butt_url' => $right_butt_url,
      'left_butt_url' => $left_butt_url,
      'right_butt_hov_url' => $right_butt_hov_url,
      'left_butt_hov_url' => $left_butt_hov_url,
      'rl_butt_img_or_not' => $rl_butt_img_or_not,
      'bullets_img_main_url' => $bullets_img_main_url,
      'bullets_img_hov_url' => $bullets_img_hov_url,
      'bull_butt_img_or_not' => $bull_butt_img_or_not,
      'play_paus_butt_img_or_not' => $play_paus_butt_img_or_not,
      'play_butt_url' => $play_butt_url,
      'play_butt_hov_url' => $play_butt_hov_url,
      'paus_butt_url' => $paus_butt_url,
      'paus_butt_hov_url' => $paus_butt_hov_url,
      'start_slide_num' => $start_slide_num,
      'effect_duration' => $effect_duration,
      'carousel' => $carousel,
      'carousel_image_counts' => $carousel_image_counts,
      'carousel_image_parameters' => $carousel_image_parameters,
      'carousel_fit_containerWidth' => $carousel_fit_containerWidth,
      'carousel_width' => $carousel_width,
      'parallax_effect' => $parallax_effect,
      'mouse_swipe_nav' => $mouse_swipe_nav,
      'bull_hover' => $bull_hover,
      'touch_swipe_nav' => $touch_swipe_nav,
      'mouse_wheel_nav' => $mouse_wheel_nav,
      'keyboard_nav' => $keyboard_nav,
      'possib_add_ffamily' => $possib_add_ffamily,
      'show_thumbnail' => $show_thumbnail,
      'thumb_size' => $thumb_size,
      'fixed_bg' => $fixed_bg,
      'smart_crop' => $smart_crop,
      'crop_image_position' => $crop_image_position,
      'javascript' => $javascript,
      'carousel_degree' => $carousel_degree,
      'carousel_grayscale' => $carousel_grayscale,
      'carousel_transparency' => $carousel_transparency,
      'bull_back_act_color' => $bull_back_act_color,
      'bull_back_color' => $bull_back_color,
      'bull_radius' => $bull_radius,
      'possib_add_google_fonts' => $possib_add_google_fonts,
      'possib_add_ffamily_google' => $possib_add_ffamily_google,
      'slider_loop' => $slider_loop,
      'hide_on_mobile' => $hide_on_mobile,
      'twoway_slideshow' => $twoway_slideshow,
    );

    if (!$slider_id) {
      $save = $wpdb->insert($wpdb->prefix . 'wdsslider', $data);
      $_POST['current_id'] = (int) $wpdb->insert_id;
    }
    else {
      $save = $wpdb->update($wpdb->prefix . 'wdsslider', $data, array('id' => $slider_id));
    }
    if ($save !== FALSE) {
      return 1;
    }
    else {
      return 2;
    }
  }

  public function save_slide_db() {
    global $wpdb;
    $slider_id = (isset($_POST['current_id']) ? (int) $_POST['current_id'] : 0);
    if (!$slider_id) {
      $slider_id = $wpdb->get_var('SELECT MAX(id) FROM ' . $wpdb->prefix . 'wdsslider');
    }
    if (get_option("wds_theme_version")) {
      $allow = FALSE;
    }
    else {
      $allow = TRUE;
    }
    $slides_data = (isset($_POST['slides']) ? $_POST['slides'] : array());
    foreach ($slides_data as $slide_data) {
      $params_array = json_decode(stripslashes($slide_data), TRUE);
      $slide_id = (isset($params_array['id']) ? $params_array['id'] : 0);
      if ($slide_id) {
        $del_layer_ids_string = (isset($params_array['slide' . $slide_id . '_del_layer_ids_string']) ? substr(esc_html(stripslashes($params_array['slide' . $slide_id . '_del_layer_ids_string'])), 0, -1) : '');
        if ($del_layer_ids_string) {
          $wpdb->query('DELETE FROM ' . $wpdb->prefix . 'wdslayer WHERE id IN (' . $del_layer_ids_string . ')');
        }
        $title = ((isset($params_array['title' . $slide_id])) ? esc_html(stripslashes($params_array['title' . $slide_id])) : '');
        $type = ((isset($params_array['type' . $slide_id])) ? esc_html(stripslashes($params_array['type' . $slide_id])) : '');
        $order = ((isset($params_array['order' . $slide_id])) ? esc_html(stripslashes($params_array['order' . $slide_id])) : '');
        $published = ((isset($params_array['published' . $slide_id])) ? esc_html(stripslashes($params_array['published' . $slide_id])) : '');
        $target_attr_slide = ((isset($params_array['target_attr_slide' . $slide_id])) ? esc_html(stripslashes($params_array['target_attr_slide' . $slide_id])) : 0);
        $link = ((isset($params_array['link' . $slide_id])) ? esc_html(stripslashes($params_array['link' . $slide_id])) : (($type == 'video') ? 0 : ''));
        $image_url = ((isset($params_array['image_url' . $slide_id])) ? esc_html(stripslashes($params_array['image_url' . $slide_id])) : '');
        $image_url = str_replace(site_url(), '{site_url}', $image_url);
        $thumb_url = ((isset($params_array['thumb_url' . $slide_id])) ? esc_html(stripslashes($params_array['thumb_url' . $slide_id])) : '');
        $thumb_url = str_replace(site_url(), '{site_url}', $thumb_url);
        if (strpos($slide_id, 'pr') !== FALSE) {
          $save = $wpdb->insert($wpdb->prefix . 'wdsslide', array(
            'slider_id' => $slider_id,
            'title' => $title,
            'type' => $type,
            'order' => $order,
            'published' => $published,
            'link' => $link,
            'image_url' => $image_url,
            'thumb_url' => $thumb_url,
            'target_attr_slide' => $target_attr_slide,
            'youtube_rel_video' => 0,
            'video_loop' => 0,
          ));
          if ($allow) {
            $slide_id_pr = $wpdb->get_var('SELECT MAX(id) FROM ' . $wpdb->prefix . 'wdsslide');
            $this->save_layer_db($slide_id, $slide_id_pr, $params_array);
          }
        }
        else {
          $save = $wpdb->update($wpdb->prefix . 'wdsslide', array(
            'slider_id' => $slider_id,
            'title' => $title,
            'type' => $type,
            'order' => $order,
            'published' => $published,
            'link' => $link,
            'image_url' => $image_url,
            'thumb_url' => $thumb_url,
            'target_attr_slide' => $target_attr_slide,
          ), array('id' => $slide_id));
          if ($allow) {
            $this->save_layer_db($slide_id, $slide_id, $params_array);
          }
        }
      }
    }
  }

  public function save_layer_db($slide_id, $slide_id_pr, $params_array) {
    global $wpdb;
    $layer_ids_string = (isset($params_array['slide' . $slide_id . '_layer_ids_string']) ? esc_html(stripslashes($params_array['slide' . $slide_id . '_layer_ids_string'])) : '');
    $layer_id_array = explode(',', $layer_ids_string);
    foreach ($layer_id_array as $layer_id) {
      if ($layer_id) {
        $prefix = 'slide' . $slide_id . '_layer' . $layer_id;
        $json_string = (isset($params_array[$prefix . '_json']) ? $params_array[$prefix . '_json'] : '');
        $params_array_layer = json_decode($json_string, TRUE);
        $title = ((isset($params_array_layer['title'])) ? esc_html(stripslashes($params_array_layer['title'])) : '');
        $type = ((isset($params_array_layer['type'])) ? esc_html(stripslashes($params_array_layer['type'])) : '');
        $depth = ((isset($params_array_layer['depth'])) ? esc_html(stripslashes($params_array_layer['depth'])) : '');
        $text = ((isset($params_array_layer['text'])) ? stripcslashes($params_array_layer['text']) : '');
        $link = ((isset($params_array_layer['link'])) ? esc_html(stripslashes($params_array_layer['link'])) : '');
        $target_attr_layer = ((isset($params_array_layer['target_attr_layer'])) ? esc_html(stripslashes($params_array_layer['target_attr_layer'])) : 0);
        $left = ((isset($params_array_layer['left'])) ? esc_html(stripslashes($params_array_layer['left'])) : '');
        $top = ((isset($params_array_layer['top'])) ? esc_html(stripslashes($params_array_layer['top'])) : '');
        $start = ((isset($params_array_layer['start'])) ? esc_html(stripslashes($params_array_layer['start'])) : '');
        $end = ((isset($params_array_layer['end'])) ? esc_html(stripslashes($params_array_layer['end'])) : '');
        $published = ((isset($params_array_layer['published'])) ? esc_html(stripslashes($params_array_layer['published'])) : '');
        $color = ((isset($params_array_layer['color'])) ? esc_html(stripslashes($params_array_layer['color'])) : '');
        $size = ((isset($params_array_layer['size'])) ? esc_html(stripslashes($params_array_layer['size'])) : '');
        $ffamily = ((isset($params_array_layer['ffamily'])) ? esc_html(stripslashes($params_array_layer['ffamily'])) : '');
        $fweight = ((isset($params_array_layer['fweight'])) ? esc_html(stripslashes($params_array_layer['fweight'])) : '');
        $padding = ((isset($params_array_layer['padding'])) ? esc_html(stripslashes($params_array_layer['padding'])) : '');
        $fbgcolor = ((isset($params_array_layer['fbgcolor'])) ? esc_html(stripslashes($params_array_layer['fbgcolor'])) : '');
        $transparent = ((isset($params_array_layer['transparent'])) ? esc_html(stripslashes($params_array_layer['transparent'])) : '');
        $border_width = ((isset($params_array_layer['border_width'])) ? esc_html(stripslashes($params_array_layer['border_width'])) : '');
        $border_style = ((isset($params_array_layer['border_style'])) ? esc_html(stripslashes($params_array_layer['border_style'])) : '');
        $border_color = ((isset($params_array_layer['border_color'])) ? esc_html(stripslashes($params_array_layer['border_color'])) : '');
        $border_radius = ((isset($params_array_layer['border_radius'])) ? esc_html(stripslashes($params_array_layer['border_radius'])) : '');
        $shadow = ((isset($params_array_layer['shadow'])) ? esc_html(stripslashes($params_array_layer['shadow'])) : '');
        $image_url = ((isset($params_array_layer['image_url'])) ? esc_html(stripslashes($params_array_layer['image_url'])) : '');
        $image_url = str_replace(site_url(), '{site_url}', $image_url);
        $image_width = ((isset($params_array_layer['image_width'])) ? esc_html(stripslashes($params_array_layer['image_width'])) : '');
        $image_height = ((isset($params_array_layer['image_height'])) ? esc_html(stripslashes($params_array_layer['image_height'])) : '');
        $image_scale = ((isset($params_array_layer['image_scale'])) ? esc_html(stripslashes($params_array_layer['image_scale'])) : '');
        $alt = ((isset($params_array_layer['alt'])) ? esc_html(stripslashes($params_array_layer['alt'])) : '');
        $imgtransparent = ((isset($params_array_layer['imgtransparent'])) ? esc_html(stripslashes($params_array_layer['imgtransparent'])) : '');
        $social_button = ((isset($params_array_layer['social_button'])) ? esc_html(stripslashes($params_array_layer['social_button'])) : '');
        $hover_color = ((isset($params_array_layer['hover_color'])) ? esc_html(stripslashes($params_array_layer['hover_color'])) : '');
        $layer_effect_in = ((isset($params_array_layer['layer_effect_in'])) ? esc_html(stripslashes($params_array_layer['layer_effect_in'])) : ''); 
        $layer_effect_out = ((isset($params_array_layer['layer_effect_out'])) ? esc_html(stripslashes($params_array_layer['layer_effect_out'])) : '');
        $duration_eff_in = ((isset($params_array_layer['duration_eff_in'])) ? esc_html(stripslashes($params_array_layer['duration_eff_in'])) : 3);
        $duration_eff_out = ((isset($params_array_layer['duration_eff_out'])) ? esc_html(stripslashes($params_array_layer['duration_eff_out'])) : 3);

        $hotp_width = ((isset($params_array_layer['hotp_width'])) ? esc_html(stripslashes($params_array_layer['hotp_width'])) : '');
        $hotp_fbgcolor = ((isset($params_array_layer['hotp_fbgcolor'])) ? esc_html(stripslashes($params_array_layer['hotp_fbgcolor'])) : '');
        $hotp_border_width = ((isset($params_array_layer['hotp_border_width'])) ? esc_html(stripslashes($params_array_layer['hotp_border_width'])) : '');
        $hotp_border_style = ((isset($params_array_layer['hotp_border_style'])) ? esc_html(stripslashes($params_array_layer['hotp_border_style'])) : '');
        $hotp_border_color = ((isset($params_array_layer['hotp_border_color'])) ? esc_html(stripslashes($params_array_layer['hotp_border_color'])) : '');
        $hotp_border_radius = ((isset($params_array_layer['hotp_border_radius'])) ? esc_html(stripslashes($params_array_layer['hotp_border_radius'])) : '');
        $hotp_text_position = ((isset($params_array_layer['hotp_text_position'])) ? esc_html(stripslashes($params_array_layer['hotp_text_position'])) : '');
        $google_fonts = ((isset($params_array_layer['google_fonts'])) ? esc_html(stripslashes($params_array_layer['google_fonts'])) : 0);
        $add_class = ((isset($params_array_layer['add_class'])) ? esc_html(stripslashes($params_array_layer['add_class'])) : '');
        $layer_callback_list = ((isset($params_array_layer['layer_callback_list'])) ? esc_html(stripslashes($params_array_layer['layer_callback_list'])) : '');
        $hover_color_text = ((isset($params_array_layer['hover_color_text'])) ? esc_html(stripslashes($params_array_layer['hover_color_text'])) : '');
        $text_alignment = ((isset($params_array_layer['text_alignment'])) ? esc_html(stripslashes($params_array_layer['text_alignment'])) : 'center');
        $link_to_slide = ((isset($params_array_layer['link_to_slide'])) ? (int) esc_html(stripslashes($params_array_layer['link_to_slide'])) : 0);
        $align_layer = ((isset($params_array_layer['align_layer'])) ? (int) esc_html(stripslashes($params_array_layer['align_layer'])) : 0);
        $static_layer = ((isset($params_array_layer['static_layer'])) ? (int) esc_html(stripslashes($params_array_layer['static_layer'])) : 0);
        if ($title) {
          if (strpos($layer_id, 'pr_') !== FALSE) {
            $save = $wpdb->insert($wpdb->prefix . 'wdslayer', array(
              'slide_id' => $slide_id_pr,
              'title' => $title,
              'type' => $type,
              'depth' => $depth,
              'text' => $text,
              'link' => $link,
              'left' => $left,
              'top' => $top,
              'start' => $start,
              'end' => $end,
              'published' => $published,
              'color' => $color,
              'size' => $size,
              'ffamily' => $ffamily,
              'fweight' => $fweight,
              'padding' => $padding,
              'fbgcolor' => $fbgcolor,
              'transparent' => $transparent,
              'border_width' => $border_width,
              'border_style' => $border_style,
              'border_color' => $border_color,
              'border_radius' => $border_radius,
              'shadow' => $shadow,
              'image_url' => $image_url,
              'image_width' => $image_width,
              'image_height' => $image_height,
              'image_scale' => $image_scale,
              'alt' => $alt,
              'imgtransparent' => $imgtransparent,
              'social_button' => $social_button,
              'hover_color' => $hover_color,
              'layer_effect_in' => $layer_effect_in,
              'layer_effect_out' => $layer_effect_out,
              'duration_eff_in' => $duration_eff_in,
              'duration_eff_out' => $duration_eff_out,
              'target_attr_layer' => $target_attr_layer,
              'hotp_width' => $hotp_width,
              'hotp_fbgcolor' => $hotp_fbgcolor,
              'hotp_border_width' => $hotp_border_width,
              'hotp_border_style' => $hotp_border_style,
              'hotp_border_color' => $hotp_border_color,
              'hotp_border_radius' => $hotp_border_radius,
              'hotp_text_position' => $hotp_text_position,
              'google_fonts' => $google_fonts,
              'add_class' => $add_class,
              'layer_video_loop' => 0,
              'youtube_rel_layer_video' => 0,
              'hotspot_animation' => 0,
              'layer_callback_list' => $layer_callback_list,
              'hotspot_text_display' => 0,
              'hover_color_text' => $hover_color_text,
              'text_alignment' => $text_alignment,
              'link_to_slide' => $link_to_slide,
              'align_layer' => $align_layer,
              'static_layer' => $static_layer,
            ));
          }
          else {
            $save = $wpdb->update($wpdb->prefix . 'wdslayer', array(
              'title' => $title,
              'type' => $type,
              'depth' => $depth,
              'text' => $text,
              'link' => $link,
              'left' => $left,
              'top' => $top,
              'start' => $start,
              'end' => $end,
              'published' => $published,
              'color' => $color,
              'size' => $size,
              'ffamily' => $ffamily,
              'fweight' => $fweight,
              'padding' => $padding,
              'fbgcolor' => $fbgcolor,
              'transparent' => $transparent,
              'border_width' => $border_width,
              'border_style' => $border_style,
              'border_color' => $border_color,
              'border_radius' => $border_radius,
              'shadow' => $shadow,
              'image_url' => $image_url,
              'image_width' => $image_width,
              'image_height' => $image_height,
              'image_scale' => $image_scale,
              'alt' => $alt,
              'imgtransparent' => $imgtransparent,
              'social_button' => $social_button,
              'hover_color' => $hover_color,
              'layer_effect_in' => $layer_effect_in,
              'layer_effect_out' => $layer_effect_out,
              'duration_eff_in' => $duration_eff_in,
              'duration_eff_out' => $duration_eff_out,
              'target_attr_layer' => $target_attr_layer,
              'hotp_width' => $hotp_width,
              'hotp_fbgcolor' => $hotp_fbgcolor,
              'hotp_border_width' => $hotp_border_width,
              'hotp_border_style' => $hotp_border_style,
              'hotp_border_color' => $hotp_border_color,
              'hotp_border_radius' => $hotp_border_radius,
              'hotp_text_position' => $hotp_text_position,
              'google_fonts' => $google_fonts,
              'add_class' => $add_class,
              'layer_callback_list' => $layer_callback_list,
              'hover_color_text' => $hover_color_text,
              'text_alignment' => $text_alignment,
              'link_to_slide' => $link_to_slide,
              'align_layer' => $align_layer,
              'static_layer' => $static_layer,
            ), array('id' => $layer_id));
          }
        }
      }
    }
  }

  public function set_watermark() {
    global $wpdb;
    $slider_id = WDW_S_Library::get('current_id', 0);
    if (!$slider_id) {
      $slider_id = $wpdb->get_var('SELECT MAX(id) FROM ' . $wpdb->prefix . 'wdsslider');
    }

    $slider_images = $wpdb->get_col($wpdb->prepare('SELECT image_url FROM ' . $wpdb->prefix . 'wdsslide WHERE `slider_id`="%d"', $slider_id));
    $slider = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'wdsslider WHERE `id`="%d"', $slider_id));

    switch ($slider->built_in_watermark_type) {
      case 'text': {
        foreach ($slider_images as $slider_image) {
          if ($slider_image) {
            $slider_image = str_replace('{site_url}', site_url(), $slider_image);
            $slider_image_dir = str_replace(site_url() . '/', ABSPATH, $slider_image);
            $last_slash_pos = strrpos($slider_image_dir, '/') + 1;
            $dest_dir = substr($slider_image_dir, 0, $last_slash_pos);
            $image_name = substr($slider_image_dir, $last_slash_pos);
            $new_image = $dest_dir . '.original/' . $image_name;
            if (!is_dir($dest_dir . '.original')) {
              mkdir($dest_dir . '.original', 0777);
            }
            if (!file_exists($new_image)) {
              copy($slider_image_dir, $new_image);
            }
            $this->set_text_watermark($slider_image_dir, $slider_image_dir, $slider->built_in_watermark_text, $slider->built_in_watermark_font, $slider->built_in_watermark_font_size, '#' . $slider->built_in_watermark_color, $slider->built_in_watermark_opacity, $slider->built_in_watermark_position);
          }
        }
        break;
      }
      case 'image': {
        foreach ($slider_images as $slider_image) {
          if ($slider_image) {
            $slider_image = str_replace('{site_url}', site_url(), $slider_image);
            $slider_image_dir = str_replace(site_url() . '/', ABSPATH, $slider_image);
            $last_slash_pos = strrpos($slider_image_dir, '/') + 1;
            $dest_dir = substr($slider_image_dir, 0, $last_slash_pos);
            $image_name = substr($slider_image_dir, $last_slash_pos);
            $new_image = $dest_dir . '.original/' . $image_name;
            if (!is_dir($dest_dir . '.original')) {
              mkdir($dest_dir . '.original', 0777);
            }
            if (!file_exists($new_image)) {
              copy($slider_image_dir, $new_image);
            }
            $slider->built_in_watermark_url = str_replace('{site_url}', site_url(), $slider->built_in_watermark_url);
            $watermark_image_dir = str_replace(site_url() . '/', ABSPATH, $slider->built_in_watermark_url);
            $this->set_image_watermark($slider_image_dir, $slider_image_dir, $watermark_image_dir, $slider->built_in_watermark_size, $slider->built_in_watermark_size, $slider->built_in_watermark_position);
          }
        }
        break;
      }
      default: {
        break;
      }
    }
  }

  public function reset_watermark() {
    global $wpdb;
    $slider_id = WDW_S_Library::get('current_id', 0);
    if (!$slider_id) {
      $slider_id = $wpdb->get_var('SELECT MAX(id) FROM ' . $wpdb->prefix . 'wdsslider');
    }
    $slider_images = $wpdb->get_col($wpdb->prepare('SELECT image_url FROM ' . $wpdb->prefix . 'wdsslide WHERE `slider_id`="%d"', $slider_id));
    foreach ($slider_images as $slider_image) {
      if ($slider_image) {
        $slider_image = str_replace('{site_url}', site_url(), $slider_image);
        $slider_image_dir = str_replace(site_url() . '/', ABSPATH, $slider_image);
        $last_slash_pos = strrpos($slider_image_dir, '/') + 1;
        $dest_dir = substr($slider_image_dir, 0, $last_slash_pos);
        $image_name = substr($slider_image_dir, $last_slash_pos);
        $new_image = $dest_dir . '.original/' . $image_name;
        if (file_exists($new_image)) {
          copy($new_image, $slider_image_dir);
        }
        else {
          // For 1.0.1 version.
          $last_dot_pos = strrpos($slider_image_dir, '.');
          $base_name = substr($slider_image_dir, 0, $last_dot_pos);
          $ext = substr($slider_image_dir, strlen($base_name));
          $new_image = $base_name . '-original' . $ext;
          if (file_exists($new_image)) {
            copy($new_image, $slider_image_dir);
          }
        }
      }
    }
  }

  public function reset() {
    global $wpdb;
    $slider_id = WDW_S_Library::get('current_id', 0);
    if (!$slider_id) {
      $slider_id = $wpdb->get_var('SELECT MAX(id) FROM ' . $wpdb->prefix . 'wdsslider');
    }

    require_once WD_S_DIR . "/admin/models/WDSModelSliders_wds.php";
    $model = new WDSModelSliders_wds();

    require_once WD_S_DIR . "/admin/views/WDSViewSliders_wds.php";
    $view = new WDSViewSliders_wds($model);
    echo WDW_S_Library::message('Changes must be saved.', 'wd_error');
    $view->edit($slider_id, TRUE);
  }
  public function duplicate() {
    $slider_id = WDW_S_Library::get('current_id', 0);
    $new_slider_id = $this->duplicate_tables($slider_id);
    require_once WD_S_DIR . "/admin/models/WDSModelSliders_wds.php";
    $model = new WDSModelSliders_wds();
    require_once WD_S_DIR . "/admin/views/WDSViewSliders_wds.php";
    $view = new WDSViewSliders_wds($model);
    echo WDW_S_Library::message('Item Succesfully Duplicated.', 'wd_updated');
    $view->edit($new_slider_id);
  }

  public function duplicate_all($id) {
    global $wpdb;
    $flag = FALSE;
    $sliders_ids_col = $wpdb->get_col('SELECT id FROM ' . $wpdb->prefix . 'wdsslider');
    foreach ($sliders_ids_col as $slider_id) {
      if (isset($_POST['check_' . $slider_id])) {
        $flag = TRUE;
        $this->duplicate_tables($slider_id);
      }
    }
    if ($flag) {
      echo WDW_S_Library::message('Items Succesfully Duplicated.', 'wd_updated');
    }
    else {
      echo WDW_S_Library::message('You must select at least one item.', 'wd_error');
    }
    $this->display();
  }

  public function duplicate_tables($slider_id, $new_slider_name = "") {
    global $wpdb;
    if ($slider_id) {
      $slider_row = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'wdsslider where id="%d"', $slider_id));
    }  
    if ($slider_row) {
      $name = $new_slider_name ? $new_slider_name : $slider_row->name;
      $save = $wpdb->insert($wpdb->prefix . 'wdsslider', array(
        'name' => $name,
        'published' => $slider_row->published,
        'full_width' => $slider_row->full_width,
        'width' => $slider_row->width,
        'height' => $slider_row->height,
        'bg_fit' => $slider_row->bg_fit,
        'align' => $slider_row->align,
        'effect' => $slider_row->effect,
        'time_intervval' => $slider_row->time_intervval,
        'autoplay' => $slider_row->autoplay,
        'shuffle' => $slider_row->shuffle,
        'music' => $slider_row->music,
        'music_url' => $slider_row->music_url,
        'preload_images' => $slider_row->preload_images,
        'background_color' => $slider_row->background_color,
        'background_transparent' =>$slider_row-> background_transparent,
        'glb_border_width' => $slider_row->glb_border_width,
        'glb_border_style' => $slider_row->glb_border_style,
        'glb_border_color' => $slider_row->glb_border_color,
        'glb_border_radius' => $slider_row->glb_border_radius,
        'glb_margin' => $slider_row->glb_margin,
        'glb_box_shadow' => $slider_row->glb_box_shadow,
        'image_right_click' => $slider_row->image_right_click,
        'prev_next_butt' => $slider_row->prev_next_butt,	
        'play_paus_butt' => $slider_row->play_paus_butt,
        'navigation' => $slider_row->navigation,
        'rl_butt_style' => $slider_row->rl_butt_style,
        'rl_butt_size' => $slider_row->rl_butt_size,
        'pp_butt_size' => $slider_row->pp_butt_size,	
        'butts_color' => $slider_row->butts_color,
        'butts_transparent' => $slider_row->butts_transparent,
        'hover_color' => $slider_row->hover_color,
        'nav_border_width' => $slider_row->nav_border_width,
        'nav_border_style' => $slider_row->nav_border_style,
        'nav_border_color' => $slider_row->nav_border_color,
        'nav_border_radius' => $slider_row->nav_border_radius,
        'nav_bg_color' => $slider_row->nav_bg_color,
        'bull_position' => $slider_row->bull_position,
        'bull_style' => $slider_row->bull_style,
        'bull_size' => $slider_row->bull_size,
        'bull_color' => $slider_row->bull_color,
        'bull_act_color' => $slider_row->bull_act_color,
        'bull_margin' => $slider_row->bull_margin,
        'film_pos' => $slider_row->film_pos,
        'film_thumb_width' => $slider_row->film_thumb_width,
        'film_thumb_height' => $slider_row->film_thumb_height,
        'film_bg_color' => $slider_row->film_bg_color,
        'film_tmb_margin' => $slider_row->film_tmb_margin,
        'film_act_border_width' => $slider_row->film_act_border_width,
        'film_act_border_style' => $slider_row->film_act_border_style,
        'film_act_border_color' => $slider_row->film_act_border_color,
        'film_dac_transparent' => $slider_row->film_dac_transparent,	
        'built_in_watermark_type' => $slider_row->built_in_watermark_type,
        'built_in_watermark_position' => $slider_row->built_in_watermark_position,
        'built_in_watermark_size' => $slider_row->built_in_watermark_size,
        'built_in_watermark_url' => $slider_row->built_in_watermark_url,
        'built_in_watermark_text' => $slider_row->built_in_watermark_text,
        'built_in_watermark_opacity' => $slider_row->built_in_watermark_opacity,		
        'built_in_watermark_font_size' => $slider_row->built_in_watermark_font_size,
        'built_in_watermark_font' => $slider_row->built_in_watermark_font,
        'built_in_watermark_color' => $slider_row->built_in_watermark_color,
        'css' => $slider_row->css,
        'timer_bar_type' => $slider_row->timer_bar_type,
        'timer_bar_size' => $slider_row->timer_bar_size,
        'timer_bar_color' => $slider_row->timer_bar_color,
        'timer_bar_transparent' => $slider_row->timer_bar_transparent,
        'layer_out_next' => $slider_row->layer_out_next,
        'spider_uploader' => $slider_row->spider_uploader,
        'stop_animation' => $slider_row->stop_animation,
        'right_butt_url' => $slider_row->right_butt_url,
        'left_butt_url' => $slider_row->left_butt_url,
        'right_butt_hov_url' => $slider_row->right_butt_hov_url,
        'left_butt_hov_url' => $slider_row->left_butt_hov_url,
        'rl_butt_img_or_not' => $slider_row->rl_butt_img_or_not,
        'bullets_img_main_url' => $slider_row->bullets_img_main_url,
        'bullets_img_hov_url' => $slider_row->bullets_img_hov_url,
        'bull_butt_img_or_not' => $slider_row->bull_butt_img_or_not,
        'play_paus_butt_img_or_not' => $slider_row->play_paus_butt_img_or_not,
        'play_butt_url' => $slider_row->play_butt_url,
        'play_butt_hov_url' => $slider_row->play_butt_hov_url,
        'paus_butt_url' => $slider_row->paus_butt_url,
        'paus_butt_hov_url' => $slider_row->paus_butt_hov_url,
        'start_slide_num' => $slider_row->start_slide_num,
        'effect_duration' => $slider_row->effect_duration,
        'carousel' => $slider_row->carousel,
        'carousel_image_counts' => $slider_row->carousel_image_counts,
        'carousel_image_parameters' => $slider_row->carousel_image_parameters,
        'carousel_fit_containerWidth' => $slider_row->carousel_fit_containerWidth,
        'carousel_width' => $slider_row->carousel_width,
        'parallax_effect' => $slider_row->parallax_effect,
        'carousel_degree' => $slider_row->carousel_degree,
        'carousel_grayscale' => $slider_row->carousel_grayscale,
        'carousel_transparency' => $slider_row->carousel_transparency,
        'bull_back_act_color' => $slider_row->bull_back_act_color,
        'bull_back_color' => $slider_row->bull_back_color,
        'bull_radius' => $slider_row->bull_radius,
        'smart_crop' => $slider_row->smart_crop,
        'crop_image_position' => $slider_row->crop_image_position,
        'possib_add_google_fonts' => $slider_row->possib_add_google_fonts,
        'possib_add_ffamily' => $slider_row->possib_add_ffamily,
        'possib_add_ffamily_google' => $slider_row->possib_add_ffamily_google,
        'slider_loop' => $slider_row->slider_loop,
        'bull_hover' => $slider_row->bull_hover,
        'show_thumbnail' => $slider_row->show_thumbnail,
        'thumb_size' => $slider_row->thumb_size,
        'hide_on_mobile' => $slider_row->hide_on_mobile,
        'twoway_slideshow' => $slider_row->twoway_slideshow,
        'mouse_swipe_nav' => $slider_row->mouse_swipe_nav,
        'touch_swipe_nav' => $slider_row->touch_swipe_nav,
        'mouse_wheel_nav' => $slider_row->mouse_wheel_nav,
        'keyboard_nav' => $slider_row->keyboard_nav,
      ));
      $new_slider_id = $wpdb->get_var('SELECT MAX(id) FROM ' . $wpdb->prefix . 'wdsslider');

      $slider_slides = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'wdsslide where slider_id="%d"', $slider_id));
      if ($slider_slides) {
        foreach ($slider_slides as $single_slide) {
          $save = $wpdb->insert($wpdb->prefix . 'wdsslide', array(
            'slider_id' => $new_slider_id,
            'title' => $single_slide->title,
            'type' => $single_slide->type,
            'order' => $single_slide->order,
            'published' => $single_slide->published,
            'link' => $single_slide->link,
            'image_url' => $single_slide->image_url,
            'thumb_url' => $single_slide->thumb_url,
            'target_attr_slide' => $single_slide->target_attr_slide,
            'youtube_rel_video' => $single_slide->youtube_rel_video,
            'video_loop' => $single_slide->video_loop,
          ));
          $new_slide_id = $wpdb->get_var('SELECT MAX(id) FROM ' . $wpdb->prefix . 'wdsslide');
          $slider_layer = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'wdslayer where slide_id="%d"', $single_slide->id));
          if ($slider_layer) {
            foreach ($slider_layer as $layer_id) {
              if ($layer_id) {
                $save = $wpdb->insert($wpdb->prefix . 'wdslayer', array(
                  'slide_id' => $new_slide_id,
                  'title' => $layer_id->title,
                  'type' => $layer_id->type,
                  'depth' => $layer_id->depth,
                  'text' => $layer_id->text,
                  'link' => $layer_id->link,
                  'left' => $layer_id->left,
                  'top' => $layer_id->top,
                  'start' => $layer_id->start,
                  'end' => $layer_id->end,
                  'published' => $layer_id->published,
                  'color' => $layer_id->color,
                  'size' => $layer_id->size,
                  'ffamily' => $layer_id->ffamily,
                  'fweight' => $layer_id->fweight,
                  'padding' => $layer_id->padding,
                  'fbgcolor' => $layer_id->fbgcolor,
                  'transparent' => $layer_id->transparent,
                  'border_width' => $layer_id->border_width,
                  'border_style' => $layer_id->border_style,
                  'border_color' => $layer_id->border_color,
                  'border_radius' => $layer_id->border_radius,
                  'shadow' => $layer_id->shadow,
                  'image_url' => $layer_id->image_url,
                  'image_width' => $layer_id->image_width,
                  'image_height' => $layer_id->image_height,
                  'image_scale' => $layer_id->image_scale,
                  'alt' => $layer_id->alt,
                  'imgtransparent' => $layer_id->imgtransparent,
                  'social_button' => $layer_id->social_button,
                  'hover_color' => $layer_id->hover_color,
                  'layer_effect_in' => $layer_id->layer_effect_in,
                  'layer_effect_out' => $layer_id->layer_effect_out,
                  'duration_eff_in' => $layer_id->duration_eff_in,
                  'duration_eff_out' => $layer_id->duration_eff_out,
                  'target_attr_layer' => $layer_id->target_attr_layer,
                  'hotp_width' => $layer_id->hotp_width,
                  'hotp_fbgcolor' => $layer_id->hotp_fbgcolor,
                  'hotp_border_width' => $layer_id->hotp_border_width,
                  'hotp_border_style' => $layer_id->hotp_border_style,
                  'hotp_border_color' => $layer_id->hotp_border_color,
                  'hotp_border_radius' => $layer_id->hotp_border_radius,
                  'hotp_text_position' => $layer_id->hotp_text_position,
                  'google_fonts' => $layer_id->google_fonts,
                  'add_class' => $layer_id->add_class,
                  'layer_video_loop' => $layer_id->layer_video_loop,
                  'youtube_rel_layer_video' => $layer_id->youtube_rel_layer_video,
                  'hotspot_animation' => $layer_id->hotspot_animation,
                  'layer_callback_list' => $layer_id->layer_callback_list,
                  'hotspot_text_display' => $layer_id->hotspot_text_display,
                  'hover_color_text' => $layer_id->hover_color_text,
                  'text_alignment' => $layer_id->text_alignment,
                  'link_to_slide' => $layer_id->link_to_slide,
                  'align_layer' => $layer_id->align_layer,
                  'static_layer' => $layer_id->static_layer,
                ));
              }
            }
          }
        }
      }
    }
    return $new_slider_id;
  }

  function bwg_hex2rgb($hex) {
    $hex = str_replace("#", "", $hex);
    if (strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    }
    else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
    }
    $rgb = array($r, $g, $b);
    return $rgb;
  }

  function bwg_imagettfbboxdimensions($font_size, $font_angle, $font, $text) {
    $box = @ImageTTFBBox($font_size, $font_angle, $font, $text) or die;
    $max_x = max(array($box[0], $box[2], $box[4], $box[6]));
    $max_y = max(array($box[1], $box[3], $box[5], $box[7]));
    $min_x = min(array($box[0], $box[2], $box[4], $box[6]));
    $min_y = min(array($box[1], $box[3], $box[5], $box[7]));
    return array(
      "width"  => ($max_x - $min_x),
      "height" => ($max_y - $min_y)
    );
  }

  function set_text_watermark($original_filename, $dest_filename, $watermark_text, $watermark_font, $watermark_font_size, $watermark_color, $watermark_transparency, $watermark_position) {
    $original_filename = htmlspecialchars_decode($original_filename, ENT_COMPAT | ENT_QUOTES);
    $dest_filename = htmlspecialchars_decode($dest_filename, ENT_COMPAT | ENT_QUOTES);

    $watermark_transparency = 127 - ((100 - $watermark_transparency) * 1.27);
    list($width, $height, $type) = getimagesize($original_filename);
    $watermark_image = imagecreatetruecolor($width, $height);

    $watermark_color = $this->bwg_hex2rgb($watermark_color);
    $watermark_color = imagecolorallocatealpha($watermark_image, $watermark_color[0], $watermark_color[1], $watermark_color[2], $watermark_transparency);
    $watermark_font = WD_S_DIR . '/fonts/' . $watermark_font;
    $watermark_font_size = ($height * $watermark_font_size / 500);
    $watermark_position = explode('-', $watermark_position);
    $watermark_sizes = $this->bwg_imagettfbboxdimensions($watermark_font_size, 0, $watermark_font, $watermark_text);

    $top = $height - 5;
    $left = $width - $watermark_sizes['width'] - 5;
    switch ($watermark_position[0]) {
      case 'top':
        $top = $watermark_sizes['height'] + 5;
        break;
      case 'middle':
        $top = ($height + $watermark_sizes['height']) / 2;
        break;
    }
    switch ($watermark_position[1]) {
      case 'left':
        $left = 5;
        break;
      case 'center':
        $left = ($width - $watermark_sizes['width']) / 2;
        break;
    }
    @ini_set('memory_limit', '-1');
    if ($type == 2) {
      $image = imagecreatefromjpeg($original_filename);
      imagettftext($image, $watermark_font_size, 0, $left, $top, $watermark_color, $watermark_font, $watermark_text);
      imagejpeg ($image, $dest_filename, 100);
      imagedestroy($image);  
    }
    elseif ($type == 3) {
      $image = imagecreatefrompng($original_filename);
      imagettftext($image, $watermark_font_size, 0, $left, $top, $watermark_color, $watermark_font, $watermark_text);
      imageColorAllocateAlpha($image, 0, 0, 0, 127);
      imagealphablending($image, FALSE);
      imagesavealpha($image, TRUE);
      imagepng($image, $dest_filename, 9);
      imagedestroy($image);
    }
    elseif ($type == 1) {
      $image = imagecreatefromgif($original_filename);
      imageColorAllocateAlpha($watermark_image, 0, 0, 0, 127);
      imagecopy($watermark_image, $image, 0, 0, 0, 0, $width, $height);
      imagettftext($watermark_image, $watermark_font_size, 0, $left, $top, $watermark_color, $watermark_font, $watermark_text);
      imagealphablending($watermark_image, FALSE);
      imagesavealpha($watermark_image, TRUE);
      imagegif($watermark_image, $dest_filename);
      imagedestroy($image);
    }
    imagedestroy($watermark_image);
    @ini_restore('memory_limit');
  }

  function set_image_watermark($original_filename, $dest_filename, $watermark_url, $watermark_height, $watermark_width, $watermark_position) {
    $original_filename = htmlspecialchars_decode($original_filename, ENT_COMPAT | ENT_QUOTES);
    $dest_filename = htmlspecialchars_decode($dest_filename, ENT_COMPAT | ENT_QUOTES);
    $watermark_url = htmlspecialchars_decode($watermark_url, ENT_COMPAT | ENT_QUOTES);

    list($width, $height, $type) = getimagesize($original_filename);
    list($width_watermark, $height_watermark, $type_watermark) = getimagesize($watermark_url);

    $watermark_width = $width * $watermark_width / 100;
    $watermark_height = $height_watermark * $watermark_width / $width_watermark;
        
    $watermark_position = explode('-', $watermark_position);
    $top = $height - $watermark_height - 5;
    $left = $width - $watermark_width - 5;
    switch ($watermark_position[0]) {
      case 'top':
        $top = 5;
        break;
      case 'middle':
        $top = ($height - $watermark_height) / 2;
        break;
    }
    switch ($watermark_position[1]) {
      case 'left':
        $left = 5;
        break;
      case 'center':
        $left = ($width - $watermark_width) / 2;
        break;
    }
    @ini_set('memory_limit', '-1');
    if ($type_watermark == 2) {
      $watermark_image = imagecreatefromjpeg($watermark_url);        
    }
    elseif ($type_watermark == 3) {
      $watermark_image = imagecreatefrompng($watermark_url);
    }
    elseif ($type_watermark == 1) {
      $watermark_image = imagecreatefromgif($watermark_url);      
    }
    else {
      return false;
    }

    $watermark_image_resized = imagecreatetruecolor($watermark_width, $watermark_height);
    imagecolorallocatealpha($watermark_image_resized, 255, 255, 255, 127);
    imagealphablending($watermark_image_resized, FALSE);
    imagesavealpha($watermark_image_resized, TRUE);
    imagecopyresampled ($watermark_image_resized, $watermark_image, 0, 0, 0, 0, $watermark_width, $watermark_height, $width_watermark, $height_watermark);
        
    if ($type == 2) {
      $image = imagecreatefromjpeg($original_filename);
      imagecopy($image, $watermark_image_resized, $left, $top, 0, 0, $watermark_width, $watermark_height);
      if ($dest_filename <> '') {
        imagejpeg ($image, $dest_filename, 100); 
      } else {
        header('Content-Type: image/jpeg');
        imagejpeg($image, null, 100);
      };
      imagedestroy($image);  
    }
    elseif ($type == 3) {
      $image = imagecreatefrompng($original_filename);
      imagecopy($image, $watermark_image_resized, $left, $top, 0, 0, $watermark_width, $watermark_height);
      imagealphablending($image, FALSE);
      imagesavealpha($image, TRUE);
      imagepng($image, $dest_filename, 9);
      imagedestroy($image);
    }
    elseif ($type == 1) {
      $image = imagecreatefromgif($original_filename);
      $tempimage = imagecreatetruecolor($width, $height);
      imagecopy($tempimage, $image, 0, 0, 0, 0, $width, $height);
      imagecopy($tempimage, $watermark_image_resized, $left, $top, 0, 0, $watermark_width, $watermark_height);
      imagegif($tempimage, $dest_filename);
      imagedestroy($image);
      imagedestroy($tempimage);
    }
    imagedestroy($watermark_image);
    @ini_restore('memory_limit');
  }

  public function delete($id) {
    global $wpdb;
    $query = $wpdb->prepare('DELETE FROM ' . $wpdb->prefix . 'wdsslider WHERE id="%d"', $id);
    if ($wpdb->query($query)) {
      $query_image = $wpdb->prepare('DELETE t1.*, t2.* FROM ' . $wpdb->prefix . 'wdsslide as t1 LEFT JOIN ' . $wpdb->prefix . 'wdslayer as t2 ON t1.id=t2.slide_id WHERE t1.slider_id="%d"', $id);
      $wpdb->query($query_image);
      echo WDW_S_Library::message('Item Succesfully Deleted.', 'wd_updated');
    }
    else {
      echo WDW_S_Library::message('Error. Please install plugin again.', 'wd_error');
    }
    $this->display();
  }
  
  public function delete_all() {
    global $wpdb;
    $flag = FALSE;
    $sliders_ids_col = $wpdb->get_col('SELECT id FROM ' . $wpdb->prefix . 'wdsslider');
    foreach ($sliders_ids_col as $slider_id) {
      if (isset($_POST['check_' . $slider_id]) || isset($_POST['check_all_items'])) {
        $flag = TRUE;
        $query = $wpdb->prepare('DELETE FROM ' . $wpdb->prefix . 'wdsslider WHERE id="%d"', $slider_id);
        $wpdb->query($query);
        $query_image = $wpdb->prepare('DELETE t1.*, t2.* FROM ' . $wpdb->prefix . 'wdsslide as t1 LEFT JOIN ' . $wpdb->prefix . 'wdslayer as t2 ON t1.id=t2.slide_id WHERE t1.slider_id="%d"', $slider_id);
        $wpdb->query($query_image);
      }
    }
    if ($flag) {
      echo WDW_S_Library::message('Items Succesfully Deleted.', 'wd_updated');
    }
    else {
      echo WDW_S_Library::message('You must select at least one item.', 'wd_error');
    }
    $this->display();
  }

  public function publish($id) {
    global $wpdb;
    $save = $wpdb->update($wpdb->prefix . 'wdsslider', array('published' => 1), array('id' => $id));
    if ($save !== FALSE) {
      echo WDW_S_Library::message('Item Succesfully Published.', 'wd_updated');
    }
    else {
      echo WDW_S_Library::message('Error. Please install plugin again.', 'wd_error');
    }
    $this->display();
  }
  
  public function publish_all() {
    global $wpdb;
    $flag = FALSE;
    if (isset($_POST['check_all_items'])) {
      $wpdb->query('UPDATE ' .  $wpdb->prefix . 'wdsslider SET published=1');
      $flag = TRUE;
    }
    else {
      $sliders_ids_col = $wpdb->get_col('SELECT id FROM ' . $wpdb->prefix . 'wdsslider');
      foreach ($sliders_ids_col as $slider_id) {
        if (isset($_POST['check_' . $slider_id])) {
          $flag = TRUE;
          $wpdb->update($wpdb->prefix . 'wdsslider', array('published' => 1), array('id' => $slider_id));
        }
      }
    }
    if ($flag) {
      echo WDW_S_Library::message('Items Succesfully Published.', 'wd_updated');
    }
    else {
      echo WDW_S_Library::message('You must select at least one item.', 'wd_error');
    }
    $this->display();
  }

  public function unpublish($id) {
    global $wpdb;
    $save = $wpdb->update($wpdb->prefix . 'wdsslider', array('published' => 0), array('id' => $id));
    if ($save !== FALSE) {
      echo WDW_S_Library::message('Item Succesfully Unpublished.', 'wd_updated');
    }
    else {
      echo WDW_S_Library::message('Error. Please install plugin again.', 'wd_error');
    }
    $this->display();
  }
  
  public function unpublish_all() {
    global $wpdb;
    $flag = FALSE;
    if (isset($_POST['check_all_items'])) {
      $wpdb->query('UPDATE ' .  $wpdb->prefix . 'wdsslider SET published=0');
      $flag = TRUE;
    }
    else {
      $sliders_ids_col = $wpdb->get_col('SELECT id FROM ' . $wpdb->prefix . 'wdsslider');
      foreach ($sliders_ids_col as $slider_id) {
        if (isset($_POST['check_' . $slider_id])) {
          $flag = TRUE;
          $wpdb->update($wpdb->prefix . 'wdsslider', array('published' => 0), array('id' => $slider_id));
        }
      }
    }
    if ($flag) {
      echo WDW_S_Library::message('Items Succesfully Unpublished.', 'wd_updated');
    }
    else {
      echo WDW_S_Library::message('You must select at least one item.', 'wd_error');
    }
    $this->display();
  }
  
  public function merge_sliders($id) {
     global $wpdb;
     $flag = FALSE;
     $check_sliders = array();
     $sliders_names = array();
     $sliders_ids_col = $wpdb->get_results('SELECT id, name FROM ' . $wpdb->prefix . 'wdsslider ORDER BY id');
     $name = "Merged sliders of ";
     foreach ($sliders_ids_col as $slider_id) {
       if (isset($_POST['check_' . $slider_id->id])) {
         $check_sliders[] = $slider_id->id;
         $sliders_names[] = $slider_id->name;
       }
     }
     if (count($check_sliders) > 1) {
       $name .= implode(",",$sliders_names);
       $last_slider_id = $check_sliders[count($check_sliders) - 1];
       $new_slider_id = $this->duplicate_tables($last_slider_id, $name);
       $max_order = $wpdb->get_var($wpdb->prepare('SELECT MAX(`order`) FROM ' . $wpdb->prefix . 'wdsslide WHERE slider_id="%d"',$new_slider_id));
       array_pop($check_sliders);
       $this->insert_slides($new_slider_id, $check_sliders, $max_order);
       $flag = TRUE;
       echo WDW_S_Library::message('The selected items are merged as a new slider.', 'wd_updated');
     }
     else {
       echo WDW_S_Library::message('You should select at least 2 sliders to merge them.', 'wd_error');
     }
     $this->display();
  }

  public function insert_slides($slider_id, $check_sliders, $max_order) {
    global $wpdb;
    if ($slider_id) {
      $slides = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'wdsslide WHERE slider_id In ('.implode(",", $check_sliders).')'); 
    }       
    if ($slides) {
      foreach ($slides as $single_slide) {
        $max_order++;
        $save = $wpdb->insert($wpdb->prefix . 'wdsslide', array(
          'slider_id' => $slider_id,
          'title' => $single_slide->title,
          'type' => $single_slide->type,
          'order' => $max_order,
          'published' => $single_slide->published,
          'link' => $single_slide->link,
          'image_url' => $single_slide->image_url,
          'thumb_url' => $single_slide->thumb_url,
          'target_attr_slide' => $single_slide->target_attr_slide,
          'youtube_rel_video' => $single_slide->youtube_rel_video,
          'video_loop' => $single_slide->video_loop,
        ));
        $new_slide_id = $wpdb->get_var('SELECT MAX(id) FROM ' . $wpdb->prefix . 'wdsslide');
        $slider_layer = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'wdslayer where slide_id="%d"', $single_slide->id));
        if ($slider_layer) {
          foreach ($slider_layer as $layer_id) {
            if ($layer_id) {
              $save = $wpdb->insert($wpdb->prefix . 'wdslayer', array(
                'slide_id' => $new_slide_id,
                'title' => $layer_id->title,
                'type' => $layer_id->type,
                'depth' => $layer_id->depth,
                'text' => $layer_id->text,
                'link' => $layer_id->link,
                'left' => $layer_id->left,
                'top' => $layer_id->top,
                'start' => $layer_id->start,
                'end' => $layer_id->end,
                'published' => $layer_id->published,
                'color' => $layer_id->color,
                'size' => $layer_id->size,
                'ffamily' => $layer_id->ffamily,
                'fweight' => $layer_id->fweight,
                'padding' => $layer_id->padding,
                'fbgcolor' => $layer_id->fbgcolor,
                'transparent' => $layer_id->transparent,
                'border_width' => $layer_id->border_width,
                'border_style' => $layer_id->border_style,
                'border_color' => $layer_id->border_color,
                'border_radius' => $layer_id->border_radius,
                'shadow' => $layer_id->shadow,
                'image_url' => $layer_id->image_url,
                'image_width' => $layer_id->image_width,
                'image_height' => $layer_id->image_height,
                'image_scale' => $layer_id->image_scale,
                'alt' => $layer_id->alt,
                'imgtransparent' => $layer_id->imgtransparent,
                'social_button' => $layer_id->social_button,
                'hover_color' => $layer_id->hover_color,
                'layer_effect_in' => $layer_id->layer_effect_in,
                'layer_effect_out' => $layer_id->layer_effect_out,
                'duration_eff_in' => $layer_id->duration_eff_in,
                'duration_eff_out' => $layer_id->duration_eff_out,
                'target_attr_layer' => $layer_id->target_attr_layer,
                'hotp_width' => $layer_id->hotp_width,
                'hotp_fbgcolor' => $layer_id->hotp_fbgcolor,
                'hotp_border_width' => $layer_id->hotp_border_width,
                'hotp_border_style' => $layer_id->hotp_border_style,
                'hotp_border_color' => $layer_id->hotp_border_color,
                'hotp_border_radius' => $layer_id->hotp_border_radius,
                'hotp_text_position' => $layer_id->hotp_text_position,
                'google_fonts' => $layer_id->google_fonts,
                'add_class' => $layer_id->add_class,
                'layer_video_loop' => $layer_id->layer_video_loop,
                'youtube_rel_layer_video' => $layer_id->youtube_rel_layer_video,
                'hotspot_animation' => $layer_id->hotspot_animation,
                'layer_callback_list' => $layer_id->layer_callback_list,
                'hotspot_text_display' => $layer_id->hotspot_text_display,
                'hover_color_text' => $layer_id->hover_color_text,
              ));
            }
          }
        }
      }
    }
    return $slider_id;
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Getters & Setters                                                                  //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Private Methods                                                                    //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}