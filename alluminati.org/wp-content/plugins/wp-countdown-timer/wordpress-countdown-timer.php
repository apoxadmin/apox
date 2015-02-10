<?php
/**
 *
 * @package   Wordpress_Countdown_Timer
 * @author    Your Name <jcalder@leadgenix.com>
 * @license   GPL-2.0+
 * @link      http://leadgenix.com
 * @copyright 2014 Leadgenix
 *
 * @wordpress-plugin
 * Plugin Name:       Wordpress Countdown Timer
 * Plugin URI:        leadgenix.com
 * Description:       Wordpress plugin to add a countdown timer to your website.
 * Version:           1.0.0
 * Author:            Jordan Calder
 * Author URI:        leadgenix.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

//PLUGIN CLASS FILE
require_once( plugin_dir_path( __FILE__ ) . 'public/class-countdown-timer.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */
register_activation_hook( __FILE__, array( 'Wordpress_Countdown_Timer', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Wordpress_Countdown_Timer', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'Wordpress_Countdown_Timer', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	add_action( 'admin_init', 'register_countdown_settings' );
	require_once( plugin_dir_path( __FILE__ ) . 'admin/wordpress-countdown-timer-admin.php' );
	add_action( 'plugins_loaded', array( 'Wordpress_Countdown_Timer_Admin', 'get_instance' ) );
	
}

function register_countdown_settings() {
  register_setting( 'myoption-group', 'countdown-timer-date' );
  add_settings_section('plugin_main', 'Main Settings', 'plugin_section_text', 'wordpress-countdown-timer');
  add_settings_field('plugin_text_string', 'Date', 'plugin_setting_string', 'wordpress-countdown-timer', 'plugin_main');
} 

function plugin_section_text() {
	echo '<p>Set the date that you would like to count down to.</p>';
}

function plugin_setting_string() {
	$options = get_option('countdown-timer-date');
	echo "<input id='plugin_text_string' name='countdown-timer-date' type='datetime-local' value='".get_option('countdown-timer-date')."' />";
}

function countdown_timer_shortcode(){
	$date_to = get_option('countdown-timer-date');
	$date_from = date('m/d/Y h:i:s');
	//echo $date_from."<br/>";
	//echo $date_to;die;
	$date_to = new DateTime($date_to);
	$date_from = new DateTime($date_from);
	$date_diff = $date_from->diff($date_to,false);
	//var_dump($date_diff);die;
	$go="<div class='wp-count-down'>";
	if($date_diff->invert ){
		$go .= "<span>The countdown has already ended!</span>";
	}else{
		$year = $date_diff->y;
		$month = $date_diff->m;
		$day = $date_diff->d;
		$hour = $date_diff->h;
		$minutes = $date_diff->i;
		$seconds = $date_diff->s;
		if(count_digit($year) < 2){
			$year = "0".$year;
		}
		if(count_digit($month) < 2){
			$month = "0".$month;
		}
		if(count_digit($day) < 2){
			$day = "0".$day;
		}
		if(count_digit($hour) < 2){
			$hour = "0".$hour;
		}
		if(count_digit($minutes) < 2){
			$minutes = "0".$minutes;
		}
		if(count_digit($seconds) < 2){
			$seconds = "0".$seconds;
		}
		$go	.= "<table border='0'>";
		$go	.= "<tr>";
		$go	.= "<td id='6'>".$year."</td>";
		$go	.= "<td id='5'>".$month."</td>";
		$go	.= "<td id='4'>".$day."</td>";
		$go	.= "<td id='3'>".$hour."</td>";
		$go	.= "<td id='2'>".$minutes."</td>";
		$go	.= "<td id='1'>".$seconds."</td>";
		$go .= "</tr>";
		$go .= "<tr><th>Years</th><th>Months</th><th>Days</th><th>Hours</th><th>Minutes</th><th>Seconds</th></tr></table>";
	}
	$go.="</div>";
	return $go;
}
add_shortcode( 'countdown', 'countdown_timer_shortcode' );

function count_digit($number) 
{ 
    $digit = 0; 
    do 
    { 
        $number /= 10; 
        $number = intval($number); 
        $digit++;    
    }while($number!=0); 
    return $digit; 
} 