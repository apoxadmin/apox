<?php
/*
Plugin Name: Easy Columns
Plugin URI: http://www.patrickfriedl.com/
Version: v2.1.3
Author: <a href="http://www.patrickfriedl.com">Pat Friedl</a>
Description: Easy Columns provides the shortcodes to create a grid system or magazine style columns for laying out your pages just the way you need them.  Using shortcodes for 1/4, 1/2, 1/3, 2/3, 3/4, 1/5, 2/5, and 3/5 columns, you can insert <strong>at least thirty</strong> unique variations of columns on any page and even in posts! Quickly add columns to your pages from the editor with an easy to use "pick n' click" interface! For usage and more information, visit <a href="http://www.patrickfriedl.com" target="_blank">patrickfriedl.com</a>.

Copyright 2013  patrickfriedl.com  (email: support[at]patrickfriedl[dot]com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/

if(!class_exists("EasyColumns")){

	class EasyColumns {

		var $plugin_url;
		var $ez_columns_options_name = 'easycol_options';
		var $ez_columns_options;
		var $options;

		function EasyColumns() { //constructor

			global $post;

			if (!defined('EZC_PLUGIN_NAME'))
				define('EZC_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));
			if (!defined('EZC_PLUGIN_DIR'))
				define('EZC_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . EZC_PLUGIN_NAME);
			if (!defined('EZC_PLUGIN_URL'))
				define('EZC_PLUGIN_URL', WP_PLUGIN_URL . '/' . EZC_PLUGIN_NAME);
			if (!defined('EZC_PLUGIN_VERSION'))
				define('EZC_PLUGIN_VERSION','2.1.1');
			if (!defined('EZC_PLUGIN_TYPE'))
				define('EZC_PLUGIN_TYPE','free');

			// add css to the <head>
			add_action('wp_head', array(&$this, 'add_css'), 100);

			// define OLD column shortcodes
			add_shortcode('wpcol_1half', array(&$this, 'one_half'));
			add_shortcode('wpcol_1half_end', array(&$this, 'one_half_end'));
			add_shortcode('wpcol_1third', array(&$this, 'one_third'));
			add_shortcode('wpcol_1third_end', array(&$this, 'one_third_end'));
			add_shortcode('wpcol_2third', array(&$this, 'two_third'));
			add_shortcode('wpcol_2third_end', array(&$this, 'two_third_end'));
			add_shortcode('wpcol_1quarter', array(&$this, 'one_quarter'));
			add_shortcode('wpcol_1quarter_end', array(&$this, 'one_quarter_end'));
			add_shortcode('wpcol_3quarter', array(&$this, 'three_quarter'));
			add_shortcode('wpcol_3quarter_end', array(&$this, 'three_quarter_end'));
			add_shortcode('wpcol_1fifth', array(&$this, 'one_fifth'));
			add_shortcode('wpcol_1fifth_end', array(&$this, 'one_fifth_end'));
			add_shortcode('wpcol_2fifth', array(&$this, 'two_fifth'));
			add_shortcode('wpcol_2fifth_end', array(&$this, 'two_fifth_end'));
			add_shortcode('wpcol_3fifth', array(&$this, 'three_fifth'));
			add_shortcode('wpcol_3fifth_end', array(&$this, 'three_fifth_end'));
			add_shortcode('wpcol_4fifth', array(&$this, 'four_fifth'));
			add_shortcode('wpcol_4fifth_end', array(&$this, 'four_fifth_end'));
			add_shortcode('wpdiv', array(&$this, 'div'));
			add_shortcode('wpcol_divider', array(&$this, 'add_divider'));
			add_shortcode('wpcol_end_right', array(&$this, 'end_column_right'));
			add_shortcode('wpcol_end_left', array(&$this, 'end_column_left'));
			add_shortcode('wpcol_end_both', array(&$this, 'end_column_both'));

			// define NEW column shortcodes
			add_shortcode('ezcol_1half', array(&$this, 'one_half'));
			add_shortcode('ezcol_1half_end', array(&$this, 'one_half_end'));
			add_shortcode('ezcol_1third', array(&$this, 'one_third'));
			add_shortcode('ezcol_1third_end', array(&$this, 'one_third_end'));
			add_shortcode('ezcol_2third', array(&$this, 'two_third'));
			add_shortcode('ezcol_2third_end', array(&$this, 'two_third_end'));
			add_shortcode('ezcol_1quarter', array(&$this, 'one_quarter'));
			add_shortcode('ezcol_1quarter_end', array(&$this, 'one_quarter_end'));
			add_shortcode('ezcol_3quarter', array(&$this, 'three_quarter'));
			add_shortcode('ezcol_3quarter_end', array(&$this, 'three_quarter_end'));
			add_shortcode('ezcol_1fifth', array(&$this, 'one_fifth'));
			add_shortcode('ezcol_1fifth_end', array(&$this, 'one_fifth_end'));
			add_shortcode('ezcol_2fifth', array(&$this, 'two_fifth'));
			add_shortcode('ezcol_2fifth_end', array(&$this, 'two_fifth_end'));
			add_shortcode('ezcol_3fifth', array(&$this, 'three_fifth'));
			add_shortcode('ezcol_3fifth_end', array(&$this, 'three_fifth_end'));
			add_shortcode('ezcol_4fifth', array(&$this, 'four_fifth'));
			add_shortcode('ezcol_4fifth_end', array(&$this, 'four_fifth_end'));
			add_shortcode('ezdiv', array(&$this, 'div'));
			add_shortcode('ezdiv1', array(&$this, 'div'));
			add_shortcode('ezdiv2', array(&$this, 'div'));
			add_shortcode('ezdiv3', array(&$this, 'div'));
			add_shortcode('ezdiv4', array(&$this, 'div'));
			add_shortcode('ezdiv5', array(&$this, 'div'));
			add_shortcode('ezcol_divider', array(&$this, 'add_divider'));
			add_shortcode('ezcol_end_right', array(&$this, 'end_column_right'));
			add_shortcode('ezcol_end_left', array(&$this, 'end_column_left'));
			add_shortcode('ezcol_end_both', array(&$this, 'end_column_both'));

			// add to tinyMCE, include the window.php file
			add_action('wp_ajax_easycolumns_tinymce', array(&$this,'ajax_tinymce'));
			add_action('init', array(&$this, 'add_tinymce'));
			// add admin menu
			add_action('admin_menu', array(&$this, 'admin_menu'));

			// get the options
			$this->options = $this->get_options();

		} // end function EasyColumns

		function one_half($atts, $content = null) {
			return '<div' . $this->div_atts($atts,'ezcol-one-half') . '>'.$this->strip_autop($content).'</div>';
		}

		function one_half_end($atts, $content = null) {
			return '<div' . $this->div_atts($atts,'ezcol-one-half ezcol-last') . '>'.$this->strip_autop($content).'</div>'.$this->add_divider();
		}

		function one_third($atts, $content = null) {
			return '<div' . $this->div_atts($atts,'ezcol-one-third') . '>'.$this->strip_autop($content).'</div>';
		}

		function one_third_end($atts, $content = null) {
		  return '<div' . $this->div_atts($atts,'ezcol-one-third ezcol-last') . '>'.$this->strip_autop($content).'</div>'.$this->add_divider();
		}

		function two_third($atts, $content = null) {
		  return '<div' . $this->div_atts($atts,'ezcol-two-third') . '>'.$this->strip_autop($content).'</div>';
		}

		function two_third_end($atts, $content = null) {
			return '<div' . $this->div_atts($atts,'ezcol-two-third ezcol-last') . '>'.$this->strip_autop($content).'</div>'.$this->add_divider();
		}

		function one_quarter($atts, $content = null) {
			return '<div' . $this->div_atts($atts,'ezcol-one-quarter') . '>'.$this->strip_autop($content).'</div>';
		}

		function one_quarter_end($atts, $content = null) {
			return '<div' . $this->div_atts($atts,'ezcol-one-quarter ezcol-last') . '>'.$this->strip_autop($content).'</div>'.$this->add_divider();
		}

		function three_quarter($atts, $content = null) {
			return '<div' . $this->div_atts($atts,'ezcol-three-quarter') . '>'.$this->strip_autop($content).'</div>';
		}

		function three_quarter_end($atts, $content = null) {
			return '<div' . $this->div_atts($atts,'ezcol-three-quarter ezcol-last') . '>'.$this->strip_autop($content).'</div>'.$this->add_divider();
		}

		function one_fifth($atts, $content = null) {
			return '<div' . $this->div_atts($atts,'ezcol-one-fifth') . '>'.$this->strip_autop($content).'</div>';
		}

		function one_fifth_end($atts, $content = null) {
			return '<div' . $this->div_atts($atts,'ezcol-one-fifth ezcol-last') . '>'.$this->strip_autop($content).'</div>'.$this->add_divider();
		}

		function two_fifth($atts, $content = null) {
			return '<div' . $this->div_atts($atts,'ezcol-two-fifth') . '>'.$this->strip_autop($content).'</div>';
		}

		function two_fifth_end($atts, $content = null) {
			return '<div' . $this->div_atts($atts,'ezcol-two-fifth ezcol-last') . '>'.$this->strip_autop($content).'</div>'.$this->add_divider();
		}

		function three_fifth($atts, $content = null) {
			return '<div' . $this->div_atts($atts,'ezcol-three-fifth') . '>'.$this->strip_autop($content).'</div>';
		}

		function three_fifth_end($atts, $content = null) {
			return '<div' . $this->div_atts($atts,'ezcol-three-fifth ezcol-last') . '>'.$this->strip_autop($content).'</div>'.$this->add_divider();
		}

		function four_fifth($atts, $content = null) {
			return '<div' . $this->div_atts($atts,'ezcol-four-fifth') . '>'.$this->strip_autop($content).'</div>';
		}

		function four_fifth_end($atts, $content = null) {
			return '<div' . $this->div_atts($atts,'ezcol-four-fifth ezcol-last') . '>'.$this->strip_autop($content).'</div>'.$this->add_divider();
		}

		function div($atts, $content = null) {
			return '<div' . $this->div_atts($atts,'') . '>' . $this->strip_autop($content) . '</div>';
		}

		function add_divider(){
			return '<div class="ezcol-divider"></div>';
		}

		function end_column_left($atts, $content = null) {
		   return '<div class="ezcol-left"></div>';
		}

		function end_column_right($atts, $content = null) {
		   return '<div  class="ezcol-right"></div>';
		}

		function end_column_both($atts, $content = null) {
		   return '<div class="ezcol-both"></div>';
		}

		function div_atts($atts,$col_type) {
			extract(shortcode_atts(array('id' => '','class' => '','style' => ''),$atts));
			$att_str = ' class="ezcol';
			$att_str .= (!empty($col_type))? ' '.$col_type : '';
			$att_str .= (!empty($col_type) && !empty($class))? ' ' : '';
			$att_str .= (!empty($class))? ' '.$class : '';
			$att_str .= '"';
			$att_str .= (!empty($id))? ' id="'.$id.'"' : '';
			$att_str .= (!empty($style))? ' style="'.$style.'"' : '';
			return $att_str;
		}

		function strip_autop($content){
			$content = do_shortcode(shortcode_unautop( $content ));
			$content = preg_replace('#^<\/p>|^<br \/>|<p>$#', '', $content);
			return $content;
		}

		function add_css(){
		?>
			<!-- Easy Columns <?php echo EZC_PLUGIN_VERSION; ?> by Pat Friedl http://www.patrickfriedl.com -->
			<link rel="stylesheet" href="<?php echo EZC_PLUGIN_URL; ?>/css/easy-columns.css" type="text/css" media="screen, projection" />
			<?php if($this->use_custom || !empty($this->options['custom_css'])){ ?>
			<!-- Begin Easy Columns <?php echo EZC_PLUGIN_VERSION; ?> Custom CSS -->
			<style type="text/css">
			<?php if(
					!empty($this->options['quarter_width']) || !empty($this->options['quarter_margin']) ||
					!empty($this->options['onehalf_width']) || !empty($this->options['onehalf_margin']) ||
					!empty($this->options['threequarter_width']) || !empty($this->options['threequarter_margin']) ||
					!empty($this->options['onethird_width']) || !empty($this->options['onethird_margin']) ||
					!empty($this->options['twothird_width']) || !empty($this->options['twothird_margin']) ||
					!empty($this->options['twothird_width']) || !empty($this->options['twothird_margin']) ||
					!empty($this->options['fifth_width']) || !empty($this->options['fifth_margin']) ||
					!empty($this->options['twofifth_width']) || !empty($this->options['twofifth_margin']) ||
					!empty($this->options['threefifth_width']) || !empty($this->options['threefifth_margin']) ||
					!empty($this->options['fourfifth_width']) || !empty($this->options['fourfifth_margin'])
					){
					if(!empty($this->options['quarter_width']) || !empty($this->options['quarter_margin']))
					{
						echo '.ezcol-one-quarter {';
						if(!empty($this->options['quarter_width'])) { echo 'width:'.$this->options['quarter_width'].$this->options['quarter_width_type'].';'; }
						if(!empty($this->options['quarter_margin'])) { echo 'margin-right:'.$this->options['quarter_margin'].$this->options['quarter_margin_type'].';'; }
						echo '}' . "\n";
					}
					if(!empty($this->options['onehalf_width']) || !empty($this->options['onehalf_margin']))
					{
						echo '.ezcol-one-half {';
						if(!empty($this->options['onehalf_width'])) { echo 'width:'.$this->options['onehalf_width'].$this->options['onehalf_width_type'].';'; }
						if(!empty($this->options['>onehalf_margin'])) { echo 'margin-right:'.$this->options['onehalf_margin'].$this->options['onehalf_margin_type'].';'; }
						echo '}' . "\n";
					}
					if(!empty($this->options['threequarter_width']) || !empty($this->options['threequarter_margin']))
					{
						echo '.ezcol-three-quarter {';
						if(!empty($this->options['threequarter_width'])) { echo 'width:'.$this->options['threequarter_width'].$this->options['threequarter_width_type'].';'; }
						if(!empty($this->options['threequarter_margin'])) { echo 'margin-right:'.$this->options['threequarter_margin'].$this->options['threequarter_margin_type'].';'; }
						echo '}' . "\n";
					}
					if(!empty($this->options['onethird_width']) || !empty($this->options['onethird_margin']))
					{
						echo '.ezcol-one-third {';
						if(!empty($this->options['onethird_width'])) { echo 'width:'.$this->options['onethird_width'].$this->options['onethird_width_type'].';'; }
						if(!empty($this->options['onethird_margin'])) { echo 'margin-right:'.$this->options['onethird_margin'].$this->options['onethird_margin_type'].';'; }
						echo '}' . "\n";
					}
					if(!empty($this->options['twothird_width']) || !empty($this->options['twothird_margin']))
					{
						echo '.ezcol-two-third {';
						if(!empty($this->options['twothird_width'])) { echo 'width:'.$this->options['twothird_width'].$this->options['twothird_width_type'].';'; }
						if(!empty($this->options['twothird_margin'])) { echo 'margin-right:'.$this->options['twothird_margin'].$this->options['twothird_margin_type'].';'; }
						echo '}' . "\n";
					}
					if(!empty($this->options['fifth_width']) || !empty($this->options['fifth_margin']))
					{
						echo '.ezcol-one-fifth {';
						if(!empty($this->options['fifth_width'])) { echo 'width:'.$this->options['fifth_width'].$this->options['fifth_width_type'].';'; }
						if(!empty($this->options['fifth_margin'])) { echo 'margin-right:'.$this->options['fifth_margin'].$this->options['fifth_margin_type'].';'; }
						echo '}' . "\n";
					}
					if(!empty($this->options['twofifth_width']) || !empty($this->options['twofifth_margin']))
					{
						echo '.ezcol-two-fifth {';
						if(!empty($this->options['twofifth_width'])) { echo 'width:'.$this->options['twofifth_width'].$this->options['twofifth_width_type'].';'; }
						if(!empty($this->options['twofifth_margin'])) { echo 'margin-right:'.$this->options['twofifth_margin'].$this->options['twofifth_margin_type'].';'; }
						echo '}' . "\n";
					}
					if(!empty($this->options['threefifth_width']) || !empty($this->options['threefifth_margin']))
					{
						echo '.ezcol-three-fifth {';
						if(!empty($this->options['threefifth_width'])) { echo 'width:'.$this->options['threefifth_width'].$this->options['threefifth_width_type'].'; '; }
						if(!empty($this->options['threefifth_margin'])) { echo 'margin-right:'.$this->options['threefifth_margin'].$this->options['threefifth_margin_type'].';'; }
						echo '}' . "\n";
					}
					if(!empty($this->options['fourfifth_width']) || !empty($this->options['fourfifth_margin']))
					{
						echo '.ezcol-four-fifth {';
						if(!empty($this->options['fourfifth_width'])) { echo 'width:'.$this->options['fourfifth_width'].$this->options['fourfifth_width_type'].';'; }
						if(!empty($this->options['fourfifth_margin'])) { echo 'margin-right:'.$this->options['fourfifth_margin'].$this->options['fourfifth_margin_type'].';'; }
						echo '}' . "\n";
					}
				}
				if(!empty($this->options['custom_css'])){ echo $this->options['custom_css'] . "\n";	} ?>
			</style>
			<!-- End Easy Columns <?php echo EZC_PLUGIN_VERSION; ?> Custom CSS -->
			<?php
			} // end if($this->use_custom)
		}// end add_css

		// begin functions for adding plugin to tinyMCE
		function ajax_tinymce() {
			if ( !current_user_can('edit_pages') && !current_user_can('edit_posts') ){
				die(__("You are not allowed to be here"));
			}
			include_once(EZC_PLUGIN_URL.'/tinymce/window.php?');
		}
		function add_tinymce() {
			if(!current_user_can('edit_posts') && ! current_user_can('edit_pages')) {
				return;
			}
			if(get_user_option('rich_editing') == 'true') {
				add_filter('mce_external_plugins', array(&$this, 'add_tinymce_plugin'));
				add_filter('mce_buttons', array(&$this, 'add_tinymce_button'));
			}
		}
		function add_tinymce_plugin($plugin_array) {
			$plugin_array['ezColumns'] = EZC_PLUGIN_URL . '/tinymce/editor_plugin.js';
			return $plugin_array;
		}
		function add_tinymce_button($buttons) {
			array_push($buttons, "separator", 'ezColumns');
			return $buttons;
		}
		// end functions for adding plugin to tinyMCE

		/*
		get plugin options, set plugin options
		*/
		function get_options()
		{
			// default values
			$options = array(
				'use_custom' => false,
				'quarter_width' => '',
				'quarter_width_type' => '%',
				'quarter_margin' => '',
				'quarter_margin_type' => '%',
				'onehalf_width' => '',
				'onehalf_width_type' => '%',
				'onehalf_margin' =>  '',
				'onehalf_type' => '%',
				'threequarter_width' => '',
				'threequarter_width_type' => '%',
				'threequarter_margin' =>  '',
				'threequarter_type' => '%',
				'onethird_width' => '',
				'onethird_width_type' => '%',
				'onethird_margin' =>  '',
				'onethird_margin_type' => '%',
				'twothird_width' => '',
				'twothird_width_type' => '%',
				'twothird_margin' =>  '',
				'twothird_margin_type' => '%',
				'onefifth_width' => '',
				'onefifth_width_type' => '%',
				'onefifth_margin' => '',
				'onefifth_margin_type' => '%',
				'twofifth_width' => '',
				'twofifth_width_type' => '%',
				'twofifth_margin' => '',
				'twofifth_margin_type' => '%',
				'threefifth_width' => '',
				'threefifth_width_type' => '%',
				'threefifth_margin' => '',
				'threefifth_margin_type' => '%',
				'fourfifth_width' => '',
				'fourfifth_width_type' => '%',
				'fourfifth_margin' => '',
				'fourfifth_margin_type' => '%',
				'custom_css' => ''
			);

			// get saved options
			$saved = get_option($this->ez_columns_options_name);

			// assign options
			if(!empty($saved))
			{
				foreach($saved as $key => $option)
				{
					$options[$key] = $option;
				}
			}

			//update options if necessary
			if($saved != $options)
			{
				update_option($this->ez_columns_options_name,$options);
			}

			// return the options
			return $options;
		} // end get_options

		/*
		update options from the admin page
		*/
		function handle_options()
		{
			$this->options = $this->get_options();
			if (isset($_POST['submitted'])) {

				//check security
				check_admin_referer('easycol-nonce');
				$options = array();

				foreach($_POST as $key => $value){
					$options[$key] = $value;
				}
				$this->options = $options;
				$this->options['use_custom'] = (!empty($_POST['use_custom']))? true : false;
				update_option($this->ez_columns_options_name, $this->options);

				echo '<div class="updated fade"><p>Plugin settings saved.</p></div>';
			}

			// URL for form submit, equals our current page
			$action_url = $_SERVER['REQUEST_URI'];

			// include the options page
			include('easy-columns-options.php');
		} // end handle_options

		/*
		add option page for Easy Columns
		*/
		function admin_menu()
		{
			add_options_page('Easy Columns Options', 'Easy Columns', 8, basename(__FILE__), array(&$this, 'handle_options'));
		} // end admin_menu

		/*
		install and initialize the plugin
		*/
		function install()
		{
			// set default options
			$this->options = $this->get_options();
		} // end install

		/*
		uninstall the plugin - removes options
		*/
		function uninstall() {
			delete_option('easycol_options');
		} // end uninstall


	} // end class EasyColumns

} // end if class exists

// initialize the EasyColumns class
if (class_exists("EasyColumns")) {
	$ez_columns = new EasyColumns();
}

// set up actions and filters
if (isset($ez_columns)) {
	if (function_exists('register_uninstall_hook'))
	{
		register_uninstall_hook(__FILE__, array('EasyColumns', 'uninstall'));
	}
}
?>