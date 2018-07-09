<?php

	/**
	 *  Load All Core Initialisation class
	 *  @package Core
	 *  @author Flipper Code <hello@flippercode.com>
	 */

	if ( ! class_exists( 'FlipperCode_Initialise_Core' ) ) {


		 class FlipperCode_Initialise_Core {

			private $corePath;
			private $productInfo;
			private $productPrefix;
			private $welcomeWindowTitle;
			private $welcomeWindowContent;
				
		 	public function __construct() {
                
                
                $this->_init();
                $this->_load_core_files();
		 		$this->_register_flippercode_globals();
		 		$this->_register_product_pointers();
		 		
	 	    }
	 	    
	 	    public function _init() {
				
				$currentPage = explode('_',$_GET['page']);
				$this->productPrefix = $currentPage[0];
				
				$this->corePath = FC_CORE_URL.'core-assets/';
				$this->welcomeWindowTitle = 'Get Started - ';
				
				switch ($this->productPrefix) {
					case 'wop' :
					$this->welcomeWindowTitle = (defined(WOP_VERSION)) ? 'WP Overlays Pro' : 'WP Overlays';
					break;
					case 'wth' :
					$this->welcomeWindowTitle = (defined(WOP_VERSION)) ? 'Was This helpful Pro' : 'Was This helpful';
					break;
					case 'mto' :
					$this->welcomeWindowTitle = (defined(MTO_VERSION)) ? 'Meta Tags Optimisation Pro' : 'Meta Tags Optimisation';
					break;
					case 'wh' :
					$this->welcomeWindowTitle .= 'Word Highlighter';
					break;
					case 'wpp' :
					$this->welcomeWindowTitle = (defined(WPP_VERSION)) ? 'WP Post Pro' : 'WP Post Master';
					break;
					case 'wcjp' :
					$this->welcomeWindowTitle .= 'Wp Custom CSS Javascript PHP';
					break;
					case 'wpgmp' :
					$this->welcomeWindowTitle = (defined(WPGMP_VERSION)) ? 'WP Google Map Pro' : 'WP Google Map';
					break;
					case 'wsq' :
					$this->welcomeWindowTitle = (defined(WPSQ_VERSION)) ? 'WP Security Questions Pro' : 'WP Security Questions';
					break;
					case 'lagmp' :
					$this->welcomeWindowTitle .= 'WP Layers Advance Google Map';
					break;
					case 'wce' :
					$this->welcomeWindowTitle .= 'WP Custom Emails';
					break;
					case 'cf7gm' :
					$this->welcomeWindowTitle .= 'WP CF7 Google Map';
					break;
					case 'wpdf' :
					$this->welcomeWindowTitle .= 'WP Display File';
					break;
					case 'wppnp' :
					$this->welcomeWindowTitle .= 'WP Push Notification Pro';
					break;
					case 'wupp' :
					$this->welcomeWindowTitle .= 'WP Updates Pro';
					break;
					
				}
				
                $this->welcomeWindowContent = 'Please click on the above link to get started. We have set up step by step tutorials for our users to get started in a minutes.';
                $this->productInfo = array('wop','wth','mto','wh','wpp','wcjp','wpgmp','wsq','lagmp','wce','cf7gm','wpdf','wppnp','wupp');
				
			}

		 	public function _register_flippercode_globals() {

		 		/*Register Hooks that we want for every product to work */

		 		// Register method to hide promotional product from overview page of current product.
		 		add_action( 'wp_ajax_hide_promotional_products',array( $this, 'hide_promotional_products' ) );
		 		add_action( 'wp_ajax_check_products_updates',array( $this, 'check_products_updates' ) );
		 		add_action( 'wp_ajax_verify_envanto_purchase',array( $this, 'verify_envanto_purchase' ) );
		 		add_action( 'wp_ajax_submit_user_suggestion',array( $this, 'submit_user_suggestion' ) );
		 		add_action( 'admin_enqueue_scripts', array($this,'load_products_common_resources') );
		 		
		  	}
		  	
		  	public function _register_product_pointers() {
				
				foreach($this->productInfo as $productprefix) {
					add_action( 'admin_enqueue_scripts', array($this,'load_product_pointers'));	
					add_filter( 'flippercode-product-pointer-toplevel_page_'.$productprefix.'_view_overview', array($this,'register_product_pointer') );
				}
				
			}
		  	
			function register_product_pointer( $p ) {
				
				$p[$this->productPrefix] = array(
					'target' => '.get_started_link',
					'options' => array(
						'content' => sprintf( '<h3> %s </h3> <p> %s </p>',
							__( $this->welcomeWindowTitle ,'plugindomain'),
							__( $this->welcomeWindowContent,'plugindomain')
						),
						'position' => array( 'edge' => 'top', 'align' => 'left' )
					)
				);
				
				return $p;
			}
		  	
		  	function load_product_pointers( $hook_suffix ) {
 
				//echo 'manish'.$hook_suffix;  
				if ( get_bloginfo( 'version' ) < '3.3' )
					return;
			 
				$screen = get_current_screen();
				$screen_id = $screen->id;
			 	$pointers = apply_filters( 'flippercode-product-pointer-' . $screen_id, array() );
			 	
			 	//echo '<pre>'; print_r($pointers);	
			 
				if ( ! $pointers || ! is_array( $pointers ) )
				   return;
			 
				$dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
				$valid_pointers =array();
			 
				
				foreach ( $pointers as $pointer_id => $pointer ) {
			 
					if ( in_array( $pointer_id, $dismissed ) || empty( $pointer )  || empty( $pointer_id ) || empty( $pointer['target'] ) || empty( $pointer['options'] ) )
					continue;
			 
					$pointer['pointer_id'] = $pointer_id;
			 		$valid_pointers['pointers'][] =  $pointer;
				}
			 
				if ( empty( $valid_pointers ) )
					return;
			 
				$valid_pointers['ajaxurl'] = admin_url('admin-ajax.php');
				wp_enqueue_style( 'wp-pointer' );
			    wp_enqueue_script( 'fc-product-pointer', $this->corePath.'js/productsintro.js', array( 'wp-pointer' ) );
			 	wp_localize_script( 'fc-product-pointer', 'fcProductPointers', $valid_pointers );
			}


		 	function load_products_common_resources($hook) {


				if (strpos($hook, 'view_overview') !== false) {

					// One of our product's overview page. Load necessary resources on this page only.
					
					wp_enqueue_style( 'font_awesome_minimised', $this->corePath. '/css/font-awesome.min.css' );// We have used icons on page
					wp_enqueue_style( 'product_common_style', $this->corePath. '/css/backend-core.css' );//For Overview page Styling
					wp_enqueue_style( 'bootstrap_flat_style', $this->corePath. '/css/bootstrap.min.flat.css' );//For Overview page Styling
					wp_enqueue_script( 'product_common_script', $this->corePath . '/js/backend-core.js' );//For Overview page custom events
					wp_enqueue_script( 'bootstrap_script', $this->corePath . '/js/bootstrap.min.js' ); //For Bootstrap product Slider

				}


			}

			function is_localhost() {

				$isLocalhost = ($_SERVER['SERVER_NAME']!= 'localhost') ? true : false;
				return $isLocalhost;
			}

		 	function submit_user_suggestion() {

				$current_user = wp_get_current_user();
				if (isset( $_POST['action'] )
				&& $_POST['action'] == 'submit_user_suggestion'
				&& isset( $_POST['uss'] )
				&& wp_verify_nonce($_POST['uss'],'user-suggestion-submitted')
				)
				{
					$data = $_POST;
					$current_user = wp_get_current_user();
					$sitename = get_bloginfo('name');
					$username = $current_user->user_nicename;
					$siteURL = get_bloginfo('url');
					$siteadminemail = get_bloginfo('admin_email');
					$suggestion = sanitize_text_field($data['suggestion']);
					$suggestionfor = sanitize_text_field($data['suggestionfor']);
					$url = 'http://plugins.flippercode.com/wunpupdates/';
					$bodyargs = array( 'wunpu_action' => 'submit-suggestion',
									   'username' =>   $username,
									   'sitename' =>   $sitename,
									   'siteurl' =>    urlencode($siteURL),
									   'useremail' =>  $siteadminemail,
									   'suggestion' => $suggestion,
									   'suggestion_for' => $suggestionfor);
					$args = array('method' => 'POST', 'timeout' => 45, 'body' => $bodyargs );
					$response = wp_remote_post($url,$args);
					if ( is_wp_error( $response ) ) {
					$result = array('status' => '0','error' => $response->get_error_message()) ;
					} else {
					$result = array('status' => '1','submission_saved' => $response['body']);
					echo $response['body'];

					}
				 }else {
					echo 'failed';
				}

				exit;

			}
		 	function verify_envanto_purchase() {


			if (isset($_POST['action']) and $_POST['action'] == 'verify_envanto_purchase' and isset( $_POST['pvn'] ) && wp_verify_nonce($_POST['pvn'], 'purchase-verification-request') )
	        {

				$submitData = $_POST;
				$url = 'http://plugins.flippercode.com/wunpupdates/';

				$bodyargs = array( 'wunpu_action' => 'verify-purchase',
								'purchasekey' => wp_unslash($submitData['purchasekey']),
								'ip' => $_SERVER['REMOTE_ADDR'],
								'site_url' => urlencode(site_url()),
								'currentTextDomain' => $submitData['current_text_domain'],
								'admin_email' => get_bloginfo('admin_email'));
				$args = array('method' => 'POST', 'timeout' => 45, 'body' => $bodyargs );

				$response = wp_remote_post($url,$args);

				if ( is_wp_error( $response ) ) {
				$result = array('status' => '0','error' => $response->get_error_message()) ;
				} else {
				   $valid_purchase = (array) json_decode($response['body']);

				   if($response['response']['code'] == '200') {

						   $result = array('status' => '1','purchase_verified' => $valid_purchase['status']);
						   if(  $valid_purchase['status'] == 'true') {
							   update_option( $submitData['current_text_domain'].'_user_has_license', 'yes' );
							   update_option( $submitData['current_text_domain'].'_license_key', $submitData['purchasekey'] );
							   update_option( $submitData['current_text_domain'].'_license_details', $valid_purchase );
						   }
			   	    } else {

					   $result = array('status' => '0','purchase_verified' => $valid_purchase['status'],'error' => 'Sorry! Server cannot be reached right now.');
				   }

				}
				echo json_encode($result);
				exit;

		 	}

		   }

		   public function check_products_updates() {

				$url = 'http://plugins.flippercode.com/wunpupdates/';
				$plugin = wp_unslash($_POST['productslug']);
		 		$bodyargs = array( 'wunpu_action' => 'updates',
		 						   'plugin' => $plugin,
		 						   'get_info' => 'version',
		 						   );

		 		$args = array('method' => 'POST', 'timeout' => 45, 'body' => $bodyargs );
     	 		$response = wp_remote_post($url,$args);
     	 		$response = (array) unserialize($response['body']);
     	 		if ( is_wp_error( $response ) ) {
				   $summary = array('status' => '0','error' => $response->get_error_message()) ;
				} else {

				 update_option( $plugin.'_latest_version', serialize($response) );

				 $version = trim($response['new_version'], '"');
				 $summary = array('status' => '1','latestversion' => wp_unslash(trim($version))) ;
				}

		 		echo json_encode($summary);
		 		exit;

		 	}


		 	public function hide_promotional_products() {

		 		if(isset($_POST['productname']) and !empty($_POST['productname']))
		 		update_option($_POST['productname'].'_hide_promotional_products','yes');
		 		//echo '<pre>'; print_r($_POST); exit;

		 	}

		 	public function _load_core_files() {

		 		$corePath  = plugin_dir_path( __FILE__ );
				$coreFiles = array(
					'class.tabular.php',
					'class.template.php',
					'abstract.factory.php',
					'class.controller-factory.php',
					'class.model-factory.php',
					'class.controller.php',
					'class.model.php',
					'class.validation.php',
					'class.database.php',
					'class.importer.php',
					'class.plugin-overview.php',
				);

				/**
				 *  Load All Core Initialisation class from core folder
				 */
				foreach ( $coreFiles as $file ) {

					if ( file_exists( $corePath.$file ) ) {
					    	require_once( $corePath.$file );
				    }
				}


		 	}

		 }

	}

    return new FlipperCode_Initialise_Core();

