<?php
/**
 * WP_CustomCode_Pro class file.
 * @package Core
 * @author Flipper Code <hello@flippercode.com>
 * @version 2.0.3
 */

/*
Plugin Name: Custom css-js-php
Plugin URI: http://www.flippercode.com/
Description:  Write custom code for php, html, javascript or css and insert in to your theme using shortcode, actions or filters.
Author: flippercode
Author URI: http://www.flippercode.com/
Version: 2.0.3
Text Domain: wce
Domain Path: /lang/
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( 'You are not allowed to call this page directly.' );
}

if ( ! class_exists( 'WP_CustomCode_Pro' ) ) {

	/**
	 * Main plugin class
	 * @author Flipper Code <hello@flippercode.com>
	 * @package Core
	 */
	class WP_CustomCode_Pro
	{
		/**
		 * List of Modules.
		 * @var array
		 */
		private $modules = array();

		/**
		 * Intialize variables, files and call actions.
		 * @var array
		 */
		public function __construct() {
			$this->_define_constants();
			$this->_load_files();
			register_activation_hook( __FILE__, array( $this, 'plugin_activation' ) );
			register_deactivation_hook( __FILE__, array( $this, 'plugin_deactivation' ) );
			add_action( 'plugins_loaded', array( $this, 'load_plugin_languages' ) );
			add_action( 'init', array( $this, '_init' ) );
			add_action( 'wp_ajax_wcjp_ajax_call',array( $this, 'wcjp_ajax_call' ) );
			add_action( 'wp_ajax_nopriv_wcjp_ajax_call', array( $this, 'wcjp_ajax_call' ) );
			add_action( 'wp_head', array( $this, 'wce_inline_code_header_footer' ), 500 );
			add_action( 'wp_footer', array( $this, 'wce_inline_code_header_footer' ), 500 );
			add_shortcode( 'wce_code', array( $this, 'wce_editor_inline_code' ) );

		}
		/**
		 * Call PHP Script.
		 * @param  string $script_source PHP Source Code.
		 */
		public function wce_call_php_script( $script_source ) {

			if ( strpos( $script_source, 'php' ) > 0 ) {
				echo  eval( "?>{$script_source}" );
			} else { 		echo  eval( "{$script_source}" ); }

		}
		/**
		 * Get function name used in the source code.
		 * @param  string $script_source source code.
		 * @return string                function name.
		 */
		public function get_function_name( $script_source ) {

			$func_name = array();

			preg_match_all( '/function[\s\n]+(\S+)[\s\n]*\(/', $script_source, $matches );

			if ( $matches[1] ) {
				$func_name = $matches[1]; }

			return $func_name;

		}
		/**
		 * Call actions or filter according to backend settings.
		 */
		public function wce_run_filter_action_hooks() {

			global $wpdb;

			if ( defined( 'DISABLE_WCE' ) ) {
				return; }

			$action_filters = $wpdb->get_results( 'SELECT * FROM '.WCJP_TBL_CODES." WHERE data_cond IN( 'filter', 'action') AND status = 1" );

			if ( empty( $action_filters ) ) {
				return; }

			foreach ( $action_filters as $hook ) {

				$wp_func_name = '';

				if ( empty( $hook->data_source ) ) {
					continue; }

				if ( empty( $hook->tag_name ) ) {
					continue; }

				if ( $hook->data_cond == 'filter' ) {

					$wp_func_name = 'add_filter'; } else if ( $hook->data_cond == 'action' ) {

					$wp_func_name = 'add_action';
					} else { continue; }

					$functions = $this->get_function_name( $hook->data_source );

					if ( empty( $functions ) ) {
						continue; }

					$this->wce_call_php_script( $hook->data_source );

					foreach ( $functions as $func_name ) {

						if ( function_exists( $func_name ) ) {

							if ( $hook->accept_args > 1 ) {

								$wp_func_name( $hook->tag_name, $func_name , 10 , $hook->accept_args ); } else {
								$wp_func_name( $hook->tag_name, $func_name ); }
						}
					}
			}

		}
		/**
		 * Print CSS or JS code in wp_head or wp_footer.
		 * @param  array $atts Arguments.
		 */
		public function wce_editor_inline_code($atts) {
			global $wpdb;

			if ( defined( 'DISABLE_WCE' ) ) {
				return false;
			}
			$id = $atts['id'];

			if ( ! $id ) {
				return false; }

			$row = $wpdb->get_row( 'SELECT * FROM '.WCJP_TBL_CODES.' WHERE id='. $id.' AND status = 1' );

			if ( empty( $row->data_source ) ) {
				return false; }

			$script_source = trim( $row->data_source );
			ob_start();

			switch ( $row->data_type ) {

				case 'css'  :

					echo <<<EOT
<style type="text/css">
{$script_source}
</style>
EOT;
			break;

				case 'js'  :

					$script_source = htmlspecialchars_decode( $script_source );

					echo <<<EOT
<script type="text/javascript">
{$script_source}
</script>
EOT;

			break;

				case 'php' :

					eval( "?>{$script_source}" );

			break;

			}

			return ob_get_clean();

		}
		/**
		 * Call required wp_head or wp_footer function.
		 */
		public function wce_inline_code_header_footer() {

			global $wpdb;

			$filter_by = '';

			if ( current_filter() == 'wp_head' ) {

				$filter_by = 'header'; }

			if ( current_filter() == 'wp_footer' ) {

				$filter_by = 'footer'; }

			if ( empty( $filter_by ) ) {

				return; }

			$scripts_source = $wpdb->get_results( $wpdb->prepare( 'SELECT id FROM '.WCJP_TBL_CODES.' WHERE data_cond= %s', $filter_by ) );

			if ( ! $scripts_source ) {
				return;
			}

			foreach ( $scripts_source as $source ) {
				echo do_shortcode( '[wce_code id="'.$source->id.'"]' );
			}

		}
		/**
		 * Ajax Call
		 */
		function wcjp_ajax_call() {

			check_ajax_referer( 'wcjp-call-nonce', 'nonce' );
			$operation = sanitize_text_field( wp_unslash( $_POST['operation'] ) );
			$value = wp_unslash( $_POST );
			$selected = wp_unslash( $_POST['selected_value'] );
			if ( 'wcjp_load_template' == $operation ) {
				$obj = new FlipperCode_Layout();
				echo json_encode( $obj->wcjp_load_template( $value ) );
			} else if ( 'get_next_posts' == $operation ) {
				$obj = new FlipperCode_Layout();
				echo $obj->wcjp_load_posts( $value );
			} else if ( isset( $operation ) ) {
				$this->$operation($value,$selected);
			}
			exit;
		}

		/**
		 * Call WordPress hooks.
		 */
		function _init() {
			global $wpdb;
			add_action( 'admin_menu', array( $this, 'create_menu' ) );
			if ( ! is_admin() ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'wcjp_frontend_scripts' ) );
				$this->wce_run_filter_action_hooks();
			}
		}

		/**
		 * Eneque scripts at frontend.
		 */
		function wcjp_frontend_scripts() {

			$scripts = array();
			wp_enqueue_script( 'jquery' );

			$scripts[] = array(
			'handle'  => 'wcjp-frontend',
			'src'   => WCJP_JS.'frontend.js',
			'deps'    => array(),
			);

			$where = apply_filters( 'wcjp_script_position', true );
			if ( $scripts ) {
				foreach ( $scripts as $script ) {
					wp_enqueue_script( $script['handle'], $script['src'], $script['deps'], '', $where );
				}
			}

			$get_data = get_option( 'blogpost_settings' );
			$wcjp_js_lang = array();
			$wcjp_js_lang['ajax_url'] = admin_url( 'admin-ajax.php' );
			$wcjp_js_lang['nonce'] = wp_create_nonce( 'wcjp-call-nonce' );
			$wcjp_js_lang['confirm'] = __( 'Are you sure to delete item?',WCJP_TEXT_DOMAIN );
			wp_localize_script( 'wcjp-frontend', 'settings_obj', $wcjp_js_lang );
			$frontend_styles = array(
			'overlay_settings_style' => WCJP_CSS.'frontend.css',
			);

			if ( $frontend_styles ) {
				foreach ( $frontend_styles as $frontend_style_key => $frontend_style_value ) {
					wp_enqueue_style( $frontend_style_key, $frontend_style_value );
				}
			}
		}

		/**
		 * Process slug and display view in the backend.
		 */
		function processor() {

			$return = '';
			if ( isset( $_GET['page'] ) ) {
				$page = sanitize_text_field( wp_unslash( $_GET['page'] ) );
			} else {
				$page = 'wcjp_view_overview';
			}

			$pageData = explode( '_', $page );

			if ( 'wcjp' != strtolower( $pageData[0] ) ) {
				return;
			}
			$obj_type = $pageData[2];
			$obj_operation = $pageData[1];

			if ( count( $pageData ) < 3 ) {
				die( 'Cheating!' );
			}

			try {
				if ( count( $pageData ) > 3 ) {
					$obj_type = $pageData[2].'_'.$pageData[3];
				}

				$factoryObject = new WCJP_Controller();
				$viewObject = $factoryObject->create_object( $obj_type );
				$viewObject->display( $obj_operation );

			} catch (Exception $e) {
				echo wcjp_Template::show_message( array( 'error' => $e->getMessage() ) );

			}

		}

		/**
		 * Create backend navigation.
		 */
		function create_menu() {

			global $navigations;

			$pagehook1 = add_menu_page(
				__( 'CSS-JS-PHP', WCJP_TEXT_DOMAIN ),
				__( 'CSS-JS-PHP', WCJP_TEXT_DOMAIN ),
				'wcjp_admin_overview',
				WCJP_SLUG,
				array( $this,'processor' )
			);

			if ( current_user_can( 'manage_options' )  ) {
				$role = get_role( 'administrator' );
				$role->add_cap( 'wcjp_admin_overview' );
			}

			$this->load_modules_menu();

			add_action( 'load-'.$pagehook1, array( $this, 'wcjp_backend_scripts' ) );

		}

		/**
		 * Read models and create backend navigation.
		 */
		function load_modules_menu() {

			$modules = $this->modules;
			$pagehooks = array();
			if ( is_array( $modules ) ) {
				foreach ( $modules as $module ) {

					$object = new $module;
					if ( method_exists( $object,'navigation' ) ) {

						if ( ! is_array( $object->navigation() ) ) {
							continue;
						}

						foreach ( $object->navigation() as $nav => $title ) {

							if ( current_user_can( 'manage_options' ) && is_admin() ) {
								$role = get_role( 'administrator' );
								$role->add_cap( $nav );

							}

							$pagehooks[] = add_submenu_page(
								WCJP_SLUG,
								$title,
								$title,
								$nav,
								$nav,
								array( $this,'processor' )
							);

						}
					}
				}
			}

			if ( is_array( $pagehooks ) ) {

				foreach ( $pagehooks as $key => $pagehook ) {
					add_action( 'load-'.$pagehooks[ $key ], array( $this, 'wcjp_backend_scripts' ) );
				}
			}

		}

		/**
		 * Eneque scripts in the backend.
		 */
		function wcjp_backend_scripts() {

			wp_enqueue_style( 'wp-color-picker' );
			$wp_scripts = array( 'jQuery', 'wp-color-picker', 'jquery-ui-datepicker','jquery-ui-slider' );

			if ( $wp_scripts ) {
				foreach ( $wp_scripts as $wp_script ) {
					wp_enqueue_script( $wp_script );
				}
			}

			$scripts = array();

			$scripts[] = array(
			'handle'  => 'wcjp-backend-bootstrap',
			'src'   => WCJP_JS.'bootstrap.min.js',
			'deps'    => array(),
			);
			$scripts[] = array(
			'handle'  => 'wcjp-backend',
			'src'   => WCJP_JS.'backend.js',
			'deps'    => array(),
			);
			if ( $scripts ) {
				foreach ( $scripts as $script ) {
					wp_enqueue_script( $script['handle'], $script['src'], $script['deps'] );
				}
			}
			$get_data = get_option( 'blogpost_settings' );
			$wcjp_js_lang = array();
			$wcjp_js_lang['ajax_url'] = admin_url( 'admin-ajax.php' );
			$wcjp_js_lang['nonce'] = wp_create_nonce( 'wcjp-call-nonce' );
			$wcjp_js_lang['confirm'] = __( 'Are you sure to delete item?',WCJP_TEXT_DOMAIN );
			wp_localize_script( 'wcjp-backend', 'settings_obj', $wcjp_js_lang );

			$admin_styles = array(
			'flippercode-bootstrap' => WCJP_CSS.'bootstrap.min.flat.css',
			'wcjp-backend-style' => WCJP_CSS.'backend.css',
			);

			if ( $admin_styles ) {
				foreach ( $admin_styles as $admin_style_key => $admin_style_value ) {
					wp_enqueue_style( $admin_style_key, $admin_style_value );
				}
			}

		}

		/**
		 * Load plugin language file.
		 */
		function load_plugin_languages() {

			load_plugin_textdomain( WCJP_TEXT_DOMAIN, false, WCJP_FOLDER.'/lang/' );
		}
		/**
		 * Call hook on plugin activation for both multi-site and single-site.
		 * @param  boolean $network_wide IS network activated?.
		 */
		function plugin_activation($network_wide = null) {

			if ( is_multisite() && $network_wide ) {
				global $wpdb;
				$currentblog = $wpdb->blogid;
				$activated = array();
				$sql = "SELECT blog_id FROM {$wpdb->blogs}";
				$blog_ids = $wpdb->get_col( $wpdb->prepare( $sql, null ) );

				foreach ( $blog_ids as $blog_id ) {
					switch_to_blog( $blog_id );
					$this->wcjp_activation();
					$activated[] = $blog_id;
				}

				switch_to_blog( $currentblog );
				update_site_option( 'op_activated', $activated );

			} else {
				$this->wcjp_activation();
			}
		}
		/**
		 * Call hook on plugin deactivation for both multi-site and single-site.
		 * @param  boolean $network_wide IS network activated?.
		 */
		function plugin_deactivation($network_wide) {

			if ( is_multisite() && $network_wide ) {
				global $wpdb;
				$currentblog = $wpdb->blogid;
				$activated = array();
				$sql = "SELECT blog_id FROM {$wpdb->blogs}";
				$blog_ids = $wpdb->get_col( $wpdb->prepare( $sql, null ) );

				foreach ( $blog_ids as $blog_id ) {
					switch_to_blog( $blog_id );
					$this->wcjp_deactivation();
					$activated[] = $blog_id;
				}

				switch_to_blog( $currentblog );
				update_site_option( 'op_activated', $activated );

			} else {
				$this->wcjp_deactivation();
			}
		}

		/**
		 * Perform tasks on plugin deactivation.
		 */
		function wcjp_deactivation() {

		}

		/**
		 * Perform tasks on plugin deactivation.
		 */
		function wcjp_activation() {

			global $wpdb;

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

			$modules = $this->modules;
			$pagehooks = array();

			if ( is_array( $modules ) ) {
				foreach ( $modules as $module ) {
					$object = new $module;
					if ( method_exists( $object,'install' ) ) {
						$tables[] = $object->install();
					}
				}
			}

			if ( is_array( $tables ) ) {
				foreach ( $tables as $i => $sql ) {
					dbDelta( $sql );
				}
			}

		}

		/**
		 * Define all constants.
		 */
		private function _define_constants() {

			global $wpdb;

			if ( ! defined( 'WCJP_SLUG' ) ) {
				define( 'WCJP_SLUG', 'wcjp_view_overview' );
			}

			if ( ! defined( 'WCJP_VERSION' ) ) {
				define( 'WCJP_VERSION', '2.0.3' );
			}

			if ( ! defined( 'WCJP_TEXT_DOMAIN' ) ) {
				define( 'WCJP_TEXT_DOMAIN', 'wce' );
			}

			if ( ! defined( 'WCJP_FOLDER' ) ) {
				define( 'WCJP_FOLDER', basename( dirname( __FILE__ ) ) );
			}

			if ( ! defined( 'WCJP_DIR' ) ) {
				define( 'WCJP_DIR', plugin_dir_path( __FILE__ ) );
			}

			if ( ! defined( 'WCJP_CORE_CLASSES' ) ) {
				define( 'WCJP_CORE_CLASSES', WCJP_DIR.'core/' );
			}
			
			if ( ! defined( 'WCJP_PLUGIN_CLASSES' ) ) {
				define( 'WCJP_PLUGIN_CLASSES', WCJP_DIR.'classes/' );
			}

			if ( ! defined( 'WCJP_CONTROLLER' ) ) {
				define( 'WCJP_CONTROLLER', WCJP_CORE_CLASSES );
			}

			if ( ! defined( 'WCJP_CORE_CONTROLLER_CLASS' ) ) {
				define( 'WCJP_CORE_CONTROLLER_CLASS', WCJP_CORE_CLASSES.'class.controller.php' );
			}

			if ( ! defined( 'WCJP_MODEL' ) ) {
				define( 'WCJP_MODEL', WCJP_DIR.'modules/' );
			}

			if ( ! defined( 'WCJP_URL' ) ) {
				define( 'WCJP_URL', plugin_dir_url( WCJP_FOLDER ).WCJP_FOLDER.'/' );
			}

			if ( ! defined( 'FC_CORE_URL' ) ) {
				define( 'FC_CORE_URL', plugin_dir_url( WCJP_FOLDER ).WCJP_FOLDER.'/core/' );
			}

			if ( ! defined( 'WCJP_INC_URL' ) ) {
				define( 'WCJP_INC_URL', WCJP_URL.'includes/' );
			}

			// if ( ! defined( 'WCJP_VIEWS_PATH' ) ) {
			// 	define( 'WCJP_VIEWS_PATH', WCJP_CLASSES.'view' );
			// }

			if ( ! defined( 'WCJP_CSS' ) ) {
				define( 'WCJP_CSS', WCJP_URL.'/assets/css/' );
			}

			if ( ! defined( 'WCJP_JS' ) ) {
				define( 'WCJP_JS', WCJP_URL.'/assets/js/' );
			}

			if ( ! defined( 'WCJP_IMAGES' ) ) {
				define( 'WCJP_IMAGES', WCJP_URL.'/assets/images/' );
			}

			if ( ! defined( 'WCJP_FONTS' ) ) {
				define( 'WCJP_FONTS', WCJP_URL.'fonts/' );
			}

			if ( ! defined( 'WCJP_TBL_CODES' ) ) {
				define( 'WCJP_TBL_CODES', $wpdb->prefix.'wce_editor_content' );
			}

		}

		/**
		 * Load all required core classes.
		 */
		private function _load_files() {
			
			$coreInitialisationFile = plugin_dir_path( __FILE__ ).'core/class.initiate-core.php';
			if ( file_exists( $coreInitialisationFile ) ) {
			   require_once( $coreInitialisationFile );
			}
			
			//Load Plugin Files	
			$plugin_files_to_include = array('wcjp-controller.php',
											 'wcjp-model.php');
				
			
			foreach ( $plugin_files_to_include as $file ) {

				if(file_exists(WCJP_PLUGIN_CLASSES . $file))
				require_once( WCJP_PLUGIN_CLASSES . $file ); 
			}
			
			// Load all modules.
			$core_modules = array( 'overview','code' );
			if ( is_array( $core_modules ) ) {
				foreach ( $core_modules as $module ) {

					$file = WCJP_MODEL.$module.'/model.'.$module.'.php';
					if ( file_exists( $file ) ) {
						include_once( $file );
						$class_name = 'wcjp_Model_'.ucwords( $module );
						array_push( $this->modules, $class_name );
					}
				}
			}
		}
	}
}

new WP_CustomCode_Pro();
