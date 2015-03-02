<?php 
/**
* Plugin Name: Top 25 Social Icons
* Version: 2.0.0
* Description: Add Social Icons in your wordpress site. you can Share your Social Networks' profile withe users. Multi Color tooltips and also manage the Size of the  Social Icons.  You can easily Manage the social icon Images. Following Social Networks are added:Facebook, Twitter, Pinterest, Youtube, Google+, Digg, Reddit, LinkedIn, Instagram, Flicker, Dribble, Email, InstaGram, Vimeo, YELP, Tumblar, StumbleUpon, Skype, Evernote, Github, RSS, MySpace, Forrst, Deviantart, Last.fm, Xing
* Author:  Vyas Dipen
* Author URI: http://vyasdipen.wordpress.com/
*Plugin URI:http://vyasdipen.wordpress.com/


*/

 
add_action('wp_enqueue_scripts', 'add_scripts');

add_action('admin_menu', 'menu_admin_type');

add_action('admin_init', 'register_toptwenfive_settings');
 
function menu_admin_type() {
add_submenu_page( 'options-general.php', 'Top 25 Social Icons -  Manage Options', 'Top25 Social Icons', 'manage_options', 'top25-social-icons', 'toptwenfive_backend_sub_menu' ); 
//add_submenu_page( 'options-general.php', 'Top 25 Social Icons -  Manage Options', 'Top25 Social Icons', 'manage_options', 'top25-social-icons', toptwenfive_backend_sub_menu );

} 


function toptwenfive_backend_sub_menu(){

include('admin/options.php');

}
   
  
function register_toptwenfive_settings(){    
	register_setting( 'toptwenfive-setting-items', 'tooltips' );
	register_setting( 'toptwenfive-setting-items', 'color-tips' );
	register_setting( 'toptwenfive-setting-items', 'imgw' );
	register_setting( 'toptwenfive-setting-items', 'imgh' );
	register_setting( 'toptwenfive-setting-items', 'targetlinks' ); 
	register_setting( 'toptwenfive-setting-items', 'images-type' );
	
} 

function add_scripts(){  

if( !is_admin() ){
if(get_option('images-type') == 'circle48'){ $ttps = '-48';}
if(get_option('images-type') == 'square48'){ $ttps = '-s48';}
if(get_option('images-type') == 'circle64'){ $ttps = '-64';}
wp_enqueue_style('Toptwenfive-social-icons',plugins_url('css/toptwenfive.css',__FILE__));

$col = get_option('color-tips'); $tp = get_option('tooltips');




if($tp == '1'){

		 wp_enqueue_style('Toptwenfive-social-tool-icons',plugins_url('css/tips/'.$col.'/'.$col.$ttps.'.css',__FILE__));

			   }

  				}
}

/*-------  Widget Code -------*/
function shortcode_socialicons($atts){
extract( shortcode_atts( array(
		'title' => '',
		'image_type' => '',
		'url' => '',
		'new_tab' => ''
	), $atts ) );
	
$title= strtolower($title);
if(!$url){$url = '#';}		
if($title == 'dribbble'){$title = 'dribble';}
if($new_tab == 'yes'){$newtab = 'target="_blank"';}else{$newtab = "";}
$social_content .= '<a class="top25icons" href="'.$url.'" data-tool="'. $title .'" '.$newtab.'>';
$plugin_url = plugins_url( 'images' , __FILE__ );

$img_url = $plugin_url .'/'. $image_type.'/'.$title.'.png';
$social_content .= '<img src="'.$img_url.'" alt="'. $title .'"/>';
$social_content .= '</a>';

return $social_content;
}

add_shortcode( 'top_25', 'shortcode_socialicons' );
add_filter('widget_text', 'do_shortcode'); 


/**
 * Add admin notices
 */
/**
 * Add user meta value when Dismiss link is clicked
 */
/**
 * Add admin notices
 */

function top25_admin_notices() {
	global $current_user;
	$userid = $current_user->ID;
	global $pagenow;
	
	// This notice will only be shown in General Settings page
	 
	
	// Only show this notice if user hasn't already dismissed it
	// Take a good look at "Dismiss" link href attribute
	if ( !get_user_meta( $userid, 'top_25_error_notice' ) ) {
		echo '<div class="updated" style="border:3px solid #000000;border-radius:10px;-webkit-border-radius:3px solid red;clear:both;  text-spacing:20px; color:#000000; padding:7px; margin:0.5em auto 0.5em auto; vertical-align:middle;text-transform: capitalize;color:black;">
				<p style="font-size:18px;text-spacing:20px;">Thank You For Using Top25 Social Icons. If You Like This Plugin Then Please Consider <a style="font-size:18px; border-bottom: 1px dashed;color:#65B6BA;font-weight:bold;" href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=vyasdipen%40live%2ecom&lc=US&item_name=Vyas%20Diepn%20Donation&no_note=0&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest" title="vyasdipen@live.com">Paypal Donation
				<a style="display:block;margin-top:10px;font-size:15px;color:red;"href="?dismiss_me=yes">Dismiss this Notice</a></p>
			</div>';
	}
}
add_action( 'admin_notices', 'top25_admin_notices' );
 
 
 /**
 * Add user meta value when Dismiss link is clicked
 */

function top_25dismiss_admin_notice() {
	global $current_user;
	$userid = $current_user->ID;
	
	// If "Dismiss" link has been clicked, user meta field is added
	if ( isset( $_GET['dismiss_me'] ) && 'yes' == $_GET['dismiss_me'] ) {
		add_user_meta( $userid, 'top_25_error_notice', 'yes', true );
	}
}
add_action( 'admin_init', 'top_25dismiss_admin_notice' );
 
 
 
 
 
 
 
 
 
 
 
 
 

include('admin/widget.php');