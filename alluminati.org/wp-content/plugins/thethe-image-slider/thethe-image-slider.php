<?php /** @version 	$Id: thethe-image-slider.php 1055 2011-10-14 14:56:43Z lexx-ua $ */?>
<?php
/*
Plugin Name: TheThe Image Slider
Plugin URI: http://thethefly.com/wp-plugins/thethe-image-slider/
Description: TheThe Image Slider is a WordPress plug-in that provides you with one of the most powerful, the most creative and the most versatile of image sliders built using jQuery.
Version: 1.1.8.1
Author: TheThe Fly
Author URI: http://thethefly.com
License: GNU GPL v2
*/
$TheTheIS = array(
    'wp_plugin_dir' => dirname(__FILE__),
	'wp_plugin_dir_url' => WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)),	
	'wp_plugin_base_name' => plugin_basename(__FILE__),
	'wp_plugin_name' => 'TheThe Image Slider',
	'wp_plugin_version' => '1.1.8.1'
);

if (is_admin()) {
	include('inc/inc.functions.php');
	include('inc/inc.boxes.php');
	require_once('thethe-actions.php');
	require_once $TheTheIS['wp_plugin_dir'] . '/thethe-admin.php';
	add_filter('admin_menu','TheTheIS_Menu');
}else{
	include('inc/inc.boxes.php');	
}

add_action('init', 'thethe_image_slider_init');

define('THETHE_IMAGE_SLIDER_URL', plugin_dir_url(__FILE__));

function thethe_image_slider_head_scripts(){
    wp_deregister_script( 'jquery' );
   	wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js', false, '1.6.4');
    wp_enqueue_script( 'jquery' );
			
	wp_enqueue_script('slider-ui', THETHE_IMAGE_SLIDER_URL.'style/js/thethe-image-slider.js', array('jquery'));
}

function thethe_image_slider_init(){
	if(is_admin()){
		post_type_slider();
		
		$bUpdate = false;
		if(isset($_POST['submit'])){
			switch ($_POST['action']) {
				case 'savecustomcss':
					$bUpdate = _thethe_image_slider_save_customcss();
					break;
				case 'editslider':
					$bUpdate = _thethe_image_slider_edit();
					$_GET['_view'] = 'editslider';
					$_GET['id'] = $_POST['id'];
					if (isset($_POST['submit']['save_and_add_new_slide'])) {
						$_GET['_view'] = 'addnewslide';
					} else if (isset($_POST['submit']['save_and_exit'])) {
						$_GET['_view'] = 'sliders';
					}
					break;
				case 'editslide':
					$bUpdate = _thethe_image_slider_slide_edit();
					$_GET['_view'] = 'editslide';
					$_GET['sid'] = $_POST['sid'];
					if (isset($_POST['submit']['save_and_add_new_slide'])) {
						$_GET['_view'] = 'addnewslide';
					} else if (isset($_POST['submit']['save_and_exit'])) {
						$_GET['_view'] = 'sliders';
						$_POST['id'] = '';						
						$_POST['sid'] = '';
					}
					break;
				case 'reorderslides':
					$bUpdate = _thethe_image_slider_reorder();
					if (isset($_POST['ajax'])){
						die();
					}
					break;
				case 'createslider':
					if (_thethe_image_slider_isExists($_POST['_slider_name'])) {
						global $_thethe_image_slider_error_msg;
						$_thethe_image_slider_error_msg = 'Slider name ['.$_POST['_slider_name'].'] already exists!';
					} else {
					$post_id = _thethe_image_slider_add();
					if ($post_id){
						$_GET['_view'] = 'editslider';
						
						if (isset($_POST['submit']['save_and_add_new_slide'])) {
							$_GET['_view'] = 'addnewslide';
							$_GET['id'] = $post_id;
							$_GET['added'] = true;
							$bUpdate = true;
						} else if (isset($_POST['submit']['save_and_exit'])) {
							$_GET['_view'] = 'sliders';
						} else {
							$_GET['id'] = $post_id;
							$_GET['added'] = true;
							$bUpdate = true;		
						}
					}
					}
					break;
				case 'addnewslide':
					$slide_id = _thethe_image_slider_slide_add();
					if ($slide_id !== false){
						$_GET['_view'] = 'editslide';
						$_GET['sid'] = $slide_id;
						$_GET['added'] = true;
						$bUpdate = true;
					}
					if (isset($_POST['submit']['save_and_add_new_slide'])) {
						$_GET['_view'] = 'addnewslide';
						$_GET['id'] = $_REQUEST['id'];
					} else if (isset($_POST['submit']['save_and_exit'])) {
						$_GET['_view'] = 'sliders';
					}
					break;
			}
		}elseif (isset($_POST['reset'])){
			switch ($_POST['action']) {
				case 'editslider':
					$bUpdate = _thethe_image_slider_edit(true);
					$_GET['_view'] = 'editslider';
					$_GET['id'] = $_POST['id'];
					if (isset($_POST['submit']['save_and_add_new_slide'])) {
						$_GET['_view'] = 'addnewslide';
					} else if (isset($_POST['submit']['save_and_exit'])) {
						$_GET['_view'] = 'sliders';
					}
					break;
				case 'editslide':
					$bUpdate = _thethe_image_slider_slide_edit(true);
					$_GET['_view'] = 'editslide';
					$_GET['sid'] = $_POST['sid'];
					if (isset($_POST['submit']['save_and_add_new_slide'])) {
						$_GET['_view'] = 'addnewslide';
					} else if (isset($_POST['submit']['save_and_exit'])) {
						$_GET['_view'] = 'sliders';
					}
					break;
				case 'savecustomcss':
					$bUpdate = _thethe_image_slider_save_customcss(true);
					break;
			}
		}else{
			if (isset($_GET['view']) && ($_GET['view'] == 'deleteslider')){
				$bUpdate = _thethe_image_slider_delete();
			}
			if (isset($_POST['action']) && $_POST['action'] == 'meta-box-order' && isset($_POST['page']) && $_POST['page'] == 'thethe-image-slider'){
				_thethe_image_slider_slides_order();
			}
		}
		$_GET['update'] = $bUpdate;
		
	}else{
		add_action('wp_print_scripts', "thethe_image_slider_head_scripts");
			
		wp_enqueue_style('slider-ui', THETHE_IMAGE_SLIDER_URL.'style/css/thethe-image-slider.css', false, false, 'screen');
		add_filter( 'wp_head', '_thethe_image_slider_add_customcss');
	}
}

function _thethe_image_slider_add_customcss(){
	if(get_option('thethe-image-slider-enable-customcss') && get_option('thethe-image-slider-customcss')) {
		echo '<!-- TheThe Image Slider v.' . $TheTheIS['wp_plugin_version'] . ' Custom CSS begin //-->' . chr(10);
		echo '<style type="text/css" media="screen">' . chr(10);
		echo stripslashes_deep(get_option('thethe-image-slider-customcss')) . chr(10);
		echo '</style>' . chr(10);
		echo '<!-- TheThe Image Slider Custom CSS end //-->' . chr(10);
	}
}

function post_type_slider() {
	register_post_type( 'thethe-slider',
                array( 
					'labels' => array(
						'name' => _x('TheThe Sliders', 'post type general name'),
					    'singular_name' => _x('TheThe Slider', 'post type singular name'),
					    'add_new' => _x('Add New TheThe Slider', 'book'),
					    'add_new_item' => __('Add New TheThe Slider'),
					    'edit_item' => __('Edit TheThe Slider'),
					    'new_item' => __('New TheThe Slider'),
					    'view_item' => __('View TheThe Slider'),
					    'search_items' => __('Search TheThe Sliders'),
					    'not_found' =>  __('No TheThe Sliders Found'),
					    'not_found_in_trash' => __('No TheThe Sliders found in Trash'), 
					    'parent_item_colon' => '',
					    'menu_name' => 'Sliders'
					),
					'public' => true,
					'show_ui' => false,
					'register_meta_box_cb' =>  'init_metaboxes_thethe_slider',
					'_builtin' => false, // It's a custom post type, not built in!
					'_edit_link' => 'post.php?post=%d',
					'capability_type' => 'post',
					'hierarchical' => false,
					'rewrite' => array("slug" => "thethe-slider"), // Permalinks format
					'supports' => array('')
                	)
    );
	register_taxonomy_for_object_type('thethe-slider', 'thethe-slider');
}

add_shortcode('thethe-image-slider', 'thethe_image_slider_shortcode');
function thethe_image_slider_shortcode($atts, $content = null)
{	
	extract(shortcode_atts(array(
		'name' => 'thethe-image-slider'
	), $atts));
	return get_thethe_image_slider($name);
}
add_shortcode('thethe_image_slider', 'thethe_image_slider_shortcode2');
function thethe_image_slider_shortcode2($atts, $content = null)
{	
	extract(shortcode_atts(array(
		'name' => 'thethe_image_slider'
	), $atts));
	return get_thethe_image_slider($name);
}
function thethe_get_image_path($src) {
    //Call the WordPress Network blog Id Numeral
    global $blog_id;

    // if it's there and greater than 0
    if($blog_id && $blog_id > 0) {

        // Take the presented source file and break apart the query string to get the specific file name
        $imageParts = explode('/files/' , $src);
        if($imageParts[1]) {

            // Assemble the new query string using a Network-Friendly format
            $src = '/blogs.dir/' . $blog_id . '/files/' . $imageParts[1];
        }
    }
    return $src;
}

function get_thethe_image_slider($name){	
	global $g_arrBoxes;
	$nPostID = 0;
	$second_query = new WP_Query( 'name=' . sanitize_title($name) .'&post_type=thethe-slider');
	// The Loop
	while( $second_query->have_posts() ){
		$second_query->the_post();
		$nPostID = get_the_ID();
	}
	wp_reset_postdata();
	if (empty($nPostID)){
		return false;
	}
	$oPost = get_post($nPostID);
	$arrOptions = array();
	foreach ( $g_arrBoxes as $box ) {
		if ($box['type'] == 'select' && !isset($box['keyvalue'])){
			if ($box['name'] != '_slider_paginator_type' && $box['name'] != '_slider_paginator_position'){
				$arrOptions[$box['name']] = $box['values'][get_post_meta($oPost->ID, $box['name'], true)];
			}else{
				$arrOptions[$box['name']] = get_post_meta($oPost->ID, $box['name'], true);
			}
		}else{
			$arrOptions[$box['name']] = get_post_meta($oPost->ID, $box['name'], true);
		}
	}
	$strSlides = get_post_meta($oPost->ID, 'slides', true);	
	$arrSlides = (is_array($arrSlides = @unserialize($strSlides))) ? $arrSlides : array();
	$output = '';
	
	$output .= '<div class="thethe_image_slider '.$arrOptions['_slider_style'].'" id="thethe_image_slider'.$oPost->ID.'" style="width:'.$arrOptions['_slider_width'].'px;">';

	$output .= '<div class="thethe_image_slider_inner" style="width:'.$arrOptions['_slider_width'].'px; height:'.$arrOptions['_slider_height'].'px;">';
	$output .= '<div class="thethe-image-slider-settings">';
	$output .= '<span class="width">'.$arrOptions['_slider_width'].'</span>';
		$slider_loop = $arrOptions['_slider_loop']?'true':'false';
	$output .= '<span class="loop">'.$slider_loop.'</span>
				<span class="pagginator_type">'.$arrOptions['_slider_paginator_type'].'</span>
				<span class="pagginator_position">'.$arrOptions['_slider_paginator_position'].'</span>
				<span class="height">'.$arrOptions['_slider_height'].'</span>';
		$slider_autoplay = $arrOptions['_slider_autoplay']?'true':'false';
		$slider_autoresize = $arrOptions['_slider_autoresize']?'true':'false';
	$output .= '<span class="autoplay">'.$slider_autoplay.'</span>
				<span class="autoresize">'.$slider_autoresize.'</span>
				<span class="trans-time">'.$arrOptions['_slider_trans_time'].'</span>';
		$slider_style = ($arrOptions['_slider_style'] == 'none') ? 'none' : THETHE_IMAGE_SLIDER_URL.'style/skins/'.$arrOptions['_slider_style'];
	$output .= '<span class="skin">'.$slider_style.'</span>
			</div>
			<div class="thethe-image-slider-loader"><div class="thethe-image-slider-progress"></div></div>';

	$output .= '<ul class="thethe-image-slider-slides">';
			foreach ($arrSlides as $i => $slide){
				$output .='<li>';
				$slide_caption = $slide['slide_caption']?'true':'false';
				$output .='	<div class="thethe-image-slider-slide-settings">
				    	<span class="time">'.$slide['delay'].'</span>
				    	<span class="transition">'.$slide['transition'].'</span>
				    	<span class="slide_caption">'.$slide_caption.'</span>
				    	<span class="caption-size">'.$slide['caption_size'].'</span>
				    	<span class="caption-position">'.$slide['caption_position'].'</span>
				    	<span class="caption_opacity">'.$slide['caption_opacity'].'</span>						
				    	<span class="link">'.$slide['url'].'</span>
			    	</div>';
				if ($arrOptions['_slider_autoresize']){
					$image_src = $slide['image'] ? thethe_get_image_path( $slide['image'] ) : THETHE_IMAGE_SLIDER_URL.'style/images/blank.gif';					
					$output .='<img src="'.THETHE_IMAGE_SLIDER_URL . 'timthumb.php?w='.$arrOptions['_slider_width'].'&amp;h='.$arrOptions['_slider_height'].'&amp;zc=1&amp;src='.urlencode($image_src).'" alt="'.$slide['title'].'" class="thethe-image-slider-image"/>';
				}else{
					$image_src = $slide['image'] ? $slide['image'] : THETHE_IMAGE_SLIDER_URL.'style/images/blank.gif';
					
					$output .='<img src="'.$image_src.'" alt="'.$slide['title'].'" class="thethe-image-slider-image"/>';
				}
				$url = str_ireplace(array('http://','https://'), '', $slide['url']);
				$output .= $url ? '<a class="slide-link" href="http://'.$url.'" title="'.$slide['title'].'">&nbsp;</a>' : '';				
				if ($slide['slide_caption']){
					$slideCaptionBgColor = $slide['caption_bg_color'] ? 'style="background:'.$slide['caption_bg_color'].';"' : '';
					$slideCaptionTextColor = $slide['caption_text_color'] ? 'style="color:'.$slide['caption_text_color'].';"' : '';
					$output .='
					<div class="thethe-image-slider-caption thethe-image-slider-caption-'.$slide['caption_position'].' thethe-image-slider-caption-bg thethe-image-slider-caption-'.$slide['caption_style'].'" '.$slideCaptionBgColor.'></div>	
					<div class="thethe-image-slider-caption front thethe-image-slider-caption-'.$slide['caption_position'].' thethe-image-slider-caption-'.$slide['caption_style'].'">
			    						
			    		<div class="thethe-image-slider-caption-inner" '.$slideCaptionTextColor.'>
				    		<div class="thethe-image-slider-caption-text">';
					$output .= $slide['text'];
					$output .='</div>
			    		</div>
			    	</div>';
				}
				$output .='</li>';
			}
	$output .= '</ul>';
		if ($arrOptions['_slider_controls']){
			$output .= '<div class="thethe-image-slider-controls-prev thethe-previous thethe-image-slider-controls" id="thethe_image_slider'.$oPost->ID.'-previous"></div>
					<div class="thethe-image-slider-controls-pause thethe-image-slider-controls thethe-';
			$output .=$arrOptions['_slider_autoplay'] ? 'pause' : 'play';
			$output .='" id="thethe_image_slider'.$oPost->ID.'-pause"></div>
					<div class="thethe-image-slider-controls-next thethe-image-slider-controls thethe-next" id="thethe_image_slider'.$oPost->ID.'-next"></div>';
		}
	$output .= '</div>';
		if ($arrOptions['_slider_paginator']){
			$output .= '<div class="thethe-image-slider-thumbnails thethe-image-slider-thumbnails-'.$arrOptions['_slider_paginator_type'].' thethe-image-slider-thumbnails'.$arrOptions['_slider_paginator_position'].'">';
			foreach ($arrSlides as $i => $slide){
				$output .= '<div class="thethe-image-slider-thumbnails-thumb">';
				if ($arrOptions['_slider_paginator_type'] == 'thumbnails'){
					$image_src = thethe_get_image_path( $slide['image'] );
					$output .= '<div class="thumbnail-img" style="background-image:url('.THETHE_IMAGE_SLIDER_URL. 'timthumb.php?w=40&amp;h=40&amp;zc=1&amp;src='.urlencode($image_src).')" >&nbsp;</div>';
				}elseif ($arrOptions['_slider_paginator_type'] == 'numbers'){
					$output .= $i+1; 
				}elseif ($arrOptions['_slider_paginator_type'] == 'slidenames'){
					$output .= $slide['title'];
				}elseif ($arrOptions['_slider_paginator_type'] == 'dots'){
				}
				$output .='</div>';
			}
			$output .= '</div>';
		}
		if ($arrOptions['_slider_backlink']){
			$output .= '<a class="thethe-backlink" href="http://thethefly.com/wp-plugins/thethe-image-slider/" title="Powered by TheThe Image Slider WordPress Plugin" target="_blank">?</a>';
		}
	$output .='</div>';	
	return $output;
}


?>