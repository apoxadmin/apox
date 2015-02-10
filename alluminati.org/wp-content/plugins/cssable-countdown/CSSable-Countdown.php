<?php
/*
Plugin Name: CSSable Countdown
Plugin URI: http://wordpress.org/extend/plugins/cssable-countdown/
Author: dmonnier
Author URI: http://wp.dmonnier.com/
Description: A fully CSS-able jQuery countdown/countup timer available in both widget and shortcode.
Version: 1.5
*/
define( 'CURRENT_VERSION', '1.5' );

/*
Based on Keith Wood's "Countdown for jQuery" v1.6.3 (http://keith-wood.name/countdown.html).

Following lines added to the original kw-jquery.countdown-1.6.3.js:

approx 102:
	// Class name for the period label marker.
	_amountLabelClass: 'countdown_label',
	
search for var showFull() approx 527 add before final </span>:
	'<span class="' + plugin._amountLabelClass + '">' +
	(labelsNum ? labelsNum[period] : labels[period]) + '</span>'
*/

require_once( 'includes/functions/build_countdown_args.php' );
require_once( 'includes/functions/print_countdown.php' );
require_once( 'includes/functions/list_of_timezones.php' );
require_once( 'includes/functions/convert_timezone_to_decimal.php' );
require_once( 'includes/functions/generate_layout.php' );
require_once( 'includes/functions/convert_wp_lang_to_valid_language_code.php' );
require_once( 'includes/shortcode.php' );

$list_of_instanced_ids = array();

$countdown_defaults = array(
	'event'		=> '',
	'direction' => 'Down',
	
	'month'		=> date( 'm' ),
	'day'		=> date( 'd' ),
	'year'		=> date( 'Y' ),
	'hour'		=> 0,
	'minutes'	=> 0,
	'seconds'	=> 0,
	'timezone'	=> get_option( 'gmt_offset' ),
	
	// final format to be used in the countdown
	'format'		=> '',
	
	// KBW format
	'kbw_format'	=> '',
	
	// internal formatting options
	'format_years'		=> 'y',
	'format_months'		=> 'o',
	'format_weeks'		=> 'w',
	'format_days'		=> 'd',
	'format_hours'		=> 'h',
	'format_minutes'	=> 'm',
	'format_seconds'	=> 's',
	
	// expiration options
	'expiryText'	=> '',
	'expiryUrl'		=> '',
	'alwaysExpire'	=> true, // false = event only triggers if the counter actively times out
	
	// options from KBW docs
	'significant'	=> -1,
	
	// layout options
	'layout_type'	=> 'default',
	'compact'		=> false,
	'layout'		=> '',
	
	// localization
	'lang'			=> get_bloginfo('language'),
);

$periods = array(	'format_years'		=> 'y',
					'format_months'		=> 'o',
					'format_weeks'		=> 'w',
					'format_days'		=> 'd',
					'format_hours'		=> 'h',
					'format_minutes'	=> 'm',
					'format_seconds'	=> 's');

class CSSable_Countdown_Widget extends WP_Widget
{
    ////////////////////////////////////////////////////////////////
	//	constructor
	////////////////////////////////////////////////////////////////
    function CSSable_Countdown_Widget()
	{		
		$widget_ops = array( 'classname' => 'CSSable_Countdown',
							 'description' => __( 'CSSable countdown/countup widget' ) );
		$this->WP_Widget( 'cssable-countdown', __( 'CSSable Countdown' ), $widget_ops );

		// initialize default values
		global $countdown_defaults;
		$this->defaults = $countdown_defaults;
		
		// verify activation/upgrade option
		/*
			http://make.wordpress.org/core/2010/10/27/plugin-activation-hooks-no-longer-fire-for-updates/
			
			The proper way to handle an upgrade path is to only run an
			upgrade procedure when you need to. Ideally, you would store a
			"version" in your plugin's database option, and then a version
			in the code. If they do not match, you would fire your upgrade
			procedure, and then set the database option to equal the version
			in the code.
		*/
		$db_version = get_option( 'cssable-countdown_version' );
		
		switch ( $db_version )
		{
			// plugin is up-to-date
			case CURRENT_VERSION: break;
			
			// db_version doesn't exist (plugin activation)
			case FALSE:	add_option( 'cssable-countdown_version' , CURRENT_VERSION );
				break;
				
			// db_version is old (upgrade)
			default:	update_option( 'cssable-countdown_version', CURRENT_VERSION );
				break;
		}

		// initialize jQuery
		wp_enqueue_script( 'jquery' );
		
		// initialize javascript
		wp_enqueue_script( 'kw-countdown', plugins_url( 'js/kw-jquery.countdown-1.6.3.js', __FILE__ ), 'jquery', '1.0' );
		
		// initialize localization files
		$kbw_lang = convert_wp_lang_to_valid_language_code( $this->defaults['lang'] );
		
		if ( !empty( $kbw_lang ) )
		{
			wp_enqueue_script( 'countdown-l10n',
									plugins_url( 'langs/jquery.countdown-' . $kbw_lang . '.js', __FILE__ ),
									'cssable-countdown',
									'1.0',
									false);
		}
		
		// initalize frontend CSS
		wp_enqueue_style( 'cssable-countdown-style-default', plugins_url( 'includes/css/ccw-default.css', __FILE__ ), '', '1.1' );
		wp_enqueue_style( 'cssable-countdown-style-list', plugins_url( 'includes/css/ccw-list.css', __FILE__ ), '', '1.1' );
		wp_enqueue_style( 'cssable-countdown-style-text', plugins_url( 'includes/css/ccw-text.css', __FILE__ ), '', '1.1' );
		
		// initialize admin CSS and JS
		function my_enqueue($hook)
		{
			if ( 'widgets.php' != $hook )
			{
				return;
			}
			
			wp_enqueue_style( 'cssable-countdown-admin-style', plugins_url( 'includes/css/ccw-admin.css', __FILE__ ), '', '1.1' );
			wp_enqueue_script( 'cssable-countdown_admin-toggle', plugins_url( 'js/admin-toggle.js', __FILE__ ), 'jquery', '1.0' );
		}
		add_action( 'admin_enqueue_scripts', 'my_enqueue' );
    } // end constructor
	
	////////////////////////////////////////////////////////////////
	//	outputs the HTML of the widget (front end)
	////////////////////////////////////////////////////////////////
    function widget($args, $instance)
	{
		extract( $args );

		$widget_options = wp_parse_args( $instance, $this->defaults );

		echo $before_widget . "\n\n";
		
		echo ( !empty( $title ) ? $before_title . $title . $after_title : '' ) . "\n\n";
		
		include( 'includes/widget.php' );
		
		echo "\n" . $after_widget . "\n";
		
    } // end widget

	////////////////////////////////////////////////////////////////
	//	processes widget options to be saved
	////////////////////////////////////////////////////////////////
    function update($new_instance, $old_instance)
	{				
		// sanity check: month/day/year
		if ( $new_instance['month'] < 1 )	{ $new_instance['month'] = 1; }
		if ( $new_instance['month'] > 12 )	{ $new_instance['month'] = 12; }
		if ( $new_instance['day'] < 1 )		{ $new_instance['day'] = 1; }
		
		// sanity check: timezone
		if ( !isset( $new_instance['timezone'] ) || empty( $new_instance['timezone'] ) )
		{
			$new_instance['timezone'] = 'GMT';
		}
		
		$gmt_tz = list_of_timezones();
		
		if ( !in_array( $new_instance['timezone'], $gmt_tz ) )
		{
			$new_instance['timezone'] = 'GMT';
		}
		
		// sanity check: significant
		if ( $new_instance['significant'] < -1 )	{ $new_instance['significant'] = -1; }
		if ( $new_instance['significant'] > 7 )		{ $new_instance['significant'] = 7; }
		
		// sanity check: addslashes to event
		if ( isset( $new_instance['event'] ))
		{
			$new_instance['event'] = addslashes( $new_instance['event'] );
		}
		
		// sanity check: addslashes to expiryText
		if ( isset( $new_instance['expiryText'] ))
		{
			$new_instance['expiryText'] = addslashes( $new_instance['expiryText'] );
		}
		
		// sanity check: validate expiryUrl
		if ( isset( $new_instance['expiryUrl'] ))
		{
			if ( !filter_var( $new_instance['expiryUrl'], FILTER_VALIDATE_URL ) )
			{
				$new_instance['expiryUrl'] = '';
			}
		}
		
		// sanity check: basic formatting periods
		global $periods;
		$num_never = 0;
		
		foreach ( $periods as $pd => $val )
		{
			switch( $new_instance[$pd] )
			{
				case 'y':
				case 'Y':
				case 'o':
				case 'O':
				case 'w':
				case 'W':
				case 'd':
				case 'D':
				case 'h':
				case 'H':
				case 'm':
				case 'M':
				case 's':
				case 'S':		break;
				case '-1':		$num_never++; break;
				default:		$new_instance[$pd] = strtoupper( $periods[$pd] );
			}
		}
		
		// sanity check: what if all formatting periods are "never show"?
		if ( $num_never == sizeof($periods) )
		{
			$new_instance['format_seconds'] = 'always';
		}
		
		// sanity check: compact and layouts
		if ( $new_instance['layout_type'] != 'compact' )
		{
			$new_instance['compact'] = false;
		}
		
		// sanity check: kbw_format
		if ( !preg_match( '/^[yYoOwWdDhHmMsS]+$/', $new_instance['kbw_format'] ) )
		{
			$new_instance['kbw_format'] = '';
		}
		
		switch ( $new_instance['layout_type'] )
		{
					case 'list':		$new_instance['layout'] = generate_layout( $new_instance );
			break;	case 'text':		$new_instance['layout'] = '';
			break;	case 'compact':		$new_instance['compact'] = true;
			break;	default:			$new_instance['layout_type'] = 'default';
		}
		
        return $new_instance;
    } // end update

	////////////////////////////////////////////////////////////////
	//	outputs the HTML for the admin options (backend)
	////////////////////////////////////////////////////////////////
    function form($instance)
	{
		include( 'includes/form.php' );
	} // end form
}

////////////////////////////////////////////////////////////////
//	register the widget
//
//	11 Feb 2014:
//	Removed anonymous function because they require PHP 5.3+.
//	Resolves support thread "Plugin could not be activated: fatal error"
////////////////////////////////////////////////////////////////
function cssable_countdown_register_widgets()
{
	register_widget( 'CSSable_Countdown_Widget' );
}

add_action( 'widgets_init', 'cssable_countdown_register_widgets' );