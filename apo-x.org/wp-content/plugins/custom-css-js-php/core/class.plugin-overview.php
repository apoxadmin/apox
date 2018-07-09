<?php
/**
 * Flippercode Product Overview Setup Class
 * @author Flipper Code<hello@flippercode.com>
 * @version 1.0.0
 * @package Core
 */

if ( ! class_exists( 'Flippercode_Product_Overview' ) ) {

	/**
	 * FlipperCode Overview Setup Class.
	 * @author Flipper Code<hello@flippercode.com>
	 * @version 1.0.0
	 * @package Core
	 */
	class Flippercode_Product_Overview {

		/**
		 * Store object type
		 * @var  String
		 */
		public $productName;
		/**
		 * Store object type
		 * @var  String
		 */
		public $productSlug;
		/**
		 * Store object type
		 * @var  String
		 */
		public $productTagLine;
		/**
		 * Store object type
		 * @var  String
		 */
		public $productTextDomain;
		/**
		 * Store object type
		 * @var  String
		 */
		public $productIconImage;

		/**
		 * Store product current running version number
		 * @var  String
		 */
		public $productVersion;

		/**
		 * Store product new version
		 * @var  String
		 */
		public $newVersion;

		/**
		 * Store object type
		 * @var  String
		 */
		private $commonBlocks;

		/**
		 * Store object type
		 * @var  String
		 */
		private $productSpecificBlocks;

		/**
		 * Store object type
		 * @var  String
		 */
		private $is_common_block;

		/**
		 * Store Product Overview Markup
		 * @var  String
		 */
		private $productBlocksRendered = 0;

		/**
		 * Store Product Overview Markup
		 * @var  String
		 */
		private $blockHeading;
		/**
		 * Store Product Overview Markup
		 * @var  String
		 */
		private $blockContent;
		/**
		 * Store Current Block Indication Class
		 * @var  String
		 */
		private $blockClass = '';
		/**
		 * Store Product Overview Markup
		 * @var  String
		 */
		private $commonBlockMarkup = '';
		/**
		 * Store Product Overview Markup
		 * @var  String
		 */
		private $pluginSpecificBlockMarkup = '';
		/**
		 * Final Product Overview Markup
		 * @var  String
		 */
		private $finalproductOverviewMarkup = '';
		/**
		 * Purchase Verification For Product
		 * @var  Boolean
		 */
		private $userHasLicense = false;
		/**
		 * Purchase Details For Product
		 * @var  Boolean
		 */
		private $licenseDetails = false;
		/**
		 * Assign all products their i-cards :)
		 * @var  Array
		 */
		private $allProductsInfo = array();
		/**
		 * Store current message
		 * @var  Boolean
		 */
		private $message = '';
		/**
		 * Store current error = '';
		 * @var  Boolean
		 */
		private $error;
		/**
		 * Store product online doc url;
		 * @var  Boolean
		 */
		private $docURL;
		/**
		 * Store product demo url;
		 * @var  Boolean
		 */
		private $demoURL;
		/**
		 * Product Image Path;
		 * @var  Boolean
		 */
		private $productImagePath;
		/**
		 * Load Promotional Products ?;
		 * @var  Boolean
		 */
		private $loadPromotionalProducts;
		/**
		 * Is Update Available ?;
		 * @var  Boolean
		 */
		private $isUpdateAvailable;

		private $multisiteLicence;

		private $productSaleURL;
		
		private $is_premium;

		private $have_premium;

		private $productImageName;

		private $premiumFeatures;
		
		private $productFeaturesMarkup;
		
		private $productBanner;

		function __construct($pluginInfo) {
			
			if(isset($pluginInfo['is_premium']) && $pluginInfo['is_premium'] == 'false'){
				
				$this->commonBlocks = array( 'socialmedia','suggestion-area','newsletter');
				
			}else{
				$this->commonBlocks = array( 'product-activation','product-support','suggestion-area','newsletter','refund-block','extended-support' );
				$this->productTagLine = 'Congratulations on purchasing'. $this->productTagLine.', one of our premium product. With this purchase you will get instant support and assistance from our technical support team. Thank you for showing your trust in us.';
			}
			
			$this->init( $pluginInfo );
			$this->renderOverviewPage();

		}

		function renderOverviewPage() {
			?>
			<div class="product-info" data-current-product=<?php echo $this->productTextDomain; ?> data-current-product-slug=<?php echo $this->productSlug; ?> data-product-version = <?php echo $this->productVersion; ?> data-product-name = "<?php echo $this->productName; ?>" data-ajaxurl=<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>>
			<div class="container">
		        <div class="row product_header">
		            <div class="col-md-1 col-sm-2 col-xs-2 product_header_logo">
						
		                <img src="<?php echo $this->productIconImage; ?>" alt = "Logo">
		            </div>
		            <div class="col-md-8 col-sm-8 col-xs-8 product_header_desc">
		                <div class="product_name"><?php echo $this->productName; ?></div>
		                <div class="product_desc"><?php echo $this->productTagLine; ?></div>  
		            </div>
		            <div class="col-md-2 col-sm-2 col-xs-2 social_media_area">
		             <div class="social-media-links">
                           <a href="https://profiles.wordpress.org/flippercode/" target="_blank"><i class="fa fa-wordpress" aria-hidden="true"></i></a>
                           <a href="https://www.facebook.com/flippercodepvtltd/" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
                           <a href="http://twitter.com/wpflippercode" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                           <a href="https://www.linkedin.com/company/2737561" target="_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
                           <a href="https://plus.google.com/+Flippercode" target="_blank"><i class="fa fa-google-plus-official" aria-hidden="true"></i></a>
                         </div>	     
		            </div>  
		        </div>
				
		        <div class="row">
					 <div class="flexrow">
					 <?php $this->renderBlocks(); ?> 
					 </div>
			    </div>
			</div>
		<?php
		}
        function renderFeatures() {
			?>
			<div class="row features-listing">
		         <div class="flexrow">
				  <div class="header"><h1 style="width:100%;">Features Present In Pro Version Of This Product</h1></div>	 
		          <div class="col-md-5">
				 <?php
		         $featuresList = '';
					 	foreach($this->premiumFeatures as $feature){
					 		$featuresList .= '<div class="row"> 
		                       	<div class="col-md-12 product-feature">
		                       	<i class="fa fa-check"></i>&nbsp;&nbsp;'.$feature.'
		                       	</div>
	                        </div>';
				 }
				echo $featuresList;
		         
		          ?>
		          <div class="row"> 
		              <div class="col-md-2"></div>
		              <div class="col-md-10 product-feature">
		                       	<a href="<?php echo $this->productSaleURL; ?>" class="bluebg likebutton glossy-move" target="_blank">See Full Features <i></i></a>
		              </div>
	              </div> 
		          
		         </div> 
		         <?php 
		         if(!empty($this->productBanner)) { ?>
					 <div class="col-md-7 product-banner">
						 <a href="<?php echo $this->productSaleURL; ?>" target="_blank">
							  <img src="<?php echo $this->productBanner; ?>" class="product-banner-image">
						 </a>
					 </div>
				 <?php }
				 ?>
				</div>
		      </div>
			
			<?php
		} 
		function get_product_slider() {
			
			ob_start();
			?> </div>
					<div class="srow">
							<div class="product-gallery">
							<p>Check out our other feature rich wordpress products crafted with technical expertise and patience.
							&nbsp;<input type="button" class="bluebg" id="hide_promotional_products" name="hide_promotional_products" value="Hide Me" />
							</p>
							</div>
				    	    <div class="product-thumbs">
										<?php
										$i = 0;
										foreach ( $this->allProductsInfo as $key => $productInfo ) {

				                	  	    if ( 'push-notification' == $productInfo['text-domain']
				                	  	  	or 'automatic-updates' == $productInfo['text-domain']
				                	  	  	or 'store-locator' == $productInfo['text-domain'] ) {
												continue;

												// We dont have big images of these product right now so skip for now in slider.
											}
											?>
											 <div class="product-item">
											  <a href="<?php echo $productInfo['url']; ?>" class="l3 thumbnail"><img src="<?php echo $this->productImagePath.$productInfo['img']; ?>" alt="Image" style="max-width:100%;" /></a>
											  </div> 
										<?php
					                	  $i++;
										}
										?>
				            </div><!--/myCarousel-->
			        </div><!--/well-->
			<?php

			$productSlider = ob_get_contents();
			ob_clean();
			return $productSlider;

		}


		function setup_plugin_info($pluginInfo) {

			foreach ( $pluginInfo as $pluginProperty => $value ) {
				$this->$pluginProperty = $value;
			}
			 $this->userHasLicense = get_option( $this->productSlug.'_user_has_license' );
		    $this->loadPromotionalProducts = get_option( $this->productSlug.'_hide_promotional_products' );
		    $this->licenseDetails = get_option( $this->productSlug.'_license_details' );
		    $this->newVersion = unserialize(get_option( $this->productSlug.'_latest_version' ));
			$googlemap = array( 'text-domain' => 'wp-google-map-gold','img' => '1.png','url' => 'http://www.flippercode.com/product/wp-google-map-pro/' );
			$gmap_cf7 = array( 'text-domain' => 'cf7-google-maps','img' => '2.png','url' => 'http://www.flippercode.com/product/cf7-google-maps/' );
			$custom_css_js = array( 'text-domain' => '','img' => '3.png','url' => '' );
			$layers_advance_gmap = array( 'text-domain' => '','img' => '4.png','url' => 'http://www.flippercode.com/product/layers-advanced-google-maps/' );
			$wp_meta_tags_optimisation = array( 'text-domain' => '','img' => '5.png','url' => 'http://codecanyon.net/item/meta-tags-optimization-write-optimized-meta-tags/4915633' );
			$overlaypro = array( 'text-domain' => 'op_lang','img' => '6.png','url' => 'http://www.flippercode.com/product/wp-overlays-pro/' );
			$was_this_helpful = array( 'text-domain' => 'was-this-helpful-pro','img' => '7.png','url' => 'http://www.flippercode.com/product/was-this-helpful/' );
			$word_highlighter = array( 'text-domain' => '','img' => '8.png','url' => '' );
			$wp_custom_emails = array( 'text-domain' => 'wp-custom-emails','img' => '9.png','url' => 'http://www.flippercode.com/product/wordpress-custom-emails/' );
			$display_files = array( 'text-domain' => 'wp-display-files','img' => '10.png','url' => 'http://www.flippercode.com/product/wp-display-files/' );
			$wp_newsletter_pro = array( 'text-domain' => '','img' => '11.png','url' => '' );
			$wppostspro = array( 'text-domain' => 'wp-posts-pro','img' => '12.png','url' => 'http://www.flippercode.com/product/wp-posts-pro/' );
			$wpsecurityquestion = array( 'text-domain' => 'wp-security-questions-pro','img' => '13.png','url' => 'http://www.flippercode.com/product/wp-security-questions/' );
			$useravatar = array( 'text-domain' => 'wp-user-avatar-pro','img' => '14.png','url' => 'http://www.flippercode.com/product/wp-user-avatar/' );
			$pushnotification = array( 'text-domain' => 'wp-push-notifications-pr','img' => '15.png','url' => 'http://codecanyon.net/item/wp-push-notifications-pro/16019774' );
			$automaticUpdates = array( 'text-domain' => 'wp-updates-pro','img' => '16.png','url' => 'http://codecanyon.net/item/automatic-updates-for-premium-plugins-themes/15948773' );
			$storeLocator = array( 'text-domain' => 'wc-store-locator-pro','img' => '17.png','url' => 'http://www.flippercode.com/product/wc-store-locator/' );
			/*
			$pushnotification = array('text-domain' => '','img'=>'3.png','url' =>'');
			$automaticupdates = array('text-domain' => '','img'=>'4.png','url' =>'');
			$storelocator = array('text-domain' => '','img'=>'5.png','url' =>'');
			*/

			$this->allProductsInfo = array(
			'5211638' => $googlemap,
										   '7292195' => $wppostspro,
										   '16019774' => $pushnotification,
										   '15948773' => $automaticUpdates,
										   '15672329' => $storeLocator,
										   '15638832' => $useravatar,
										   '11424356' => $display_files,
										   '9689105' => $gmap_cf7,
										   '8520201' => $overlaypro,
										   '7415852' => $was_this_helpful,
										   '5894819' => $wpsecurityquestion,
										   '5836005' => $wp_custom_emails,
										   '4915633' => $wp_meta_tags_optimisation,
			);

		}

		function get_purchase_verfication_form() {

			// $this->process();
			ob_start();
			?>	
				<div class="purchase-verification-container">
				<div class="row brow"> 
					<div class="col-md-2"><i class="fa fa-key" aria-hidden="true"></i></div>
					<div class="col-md-10"><strong>Product Purchase Key</strong><br>You can find your product key by visiting<a target="_blank" href="http://www.codecanyon.net/downloads" class="purchasekey_link"> Here </a>and click on "Downloads" and find "License certificate and purchase code(text)".		
					 </div>
                </div>
	            <form class="purchase-verification-form" id="purchase-verification-form" name="purchase-verification-form" method="post" action="#">
				<?php wp_nonce_field( 'purchase-verification-request','pv-nonce' ); ?>
	            <!--<div id="profile-img" class="profile-img-card"><?php // echo get_avatar( get_current_user_id()) ?></div>-->
	            <input type="text" id="purchase_code" name="purchase_code"class="form-control" placeholder="Enter Your Purchase Code" required>
	            <div class="purchase-action">
					<input type="button" class="btn-primary" name="purchase-verification-btn" id="purchase-verification-btn" value="Verify Purchase"/>
					<div class="loader purchaseverificationcheck">
								 <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
								 <span class="sr-only">Loading...</span>
					</div>
				</div>			
	            </form>
	            </div>
            <?php
			$form = ob_get_contents();
			ob_clean();
			return $form;
		}

		function get_mailchimp_integration_form() {

			$form = '';

			$form .= '<!-- Begin MailChimp Signup Form -->
<link href="//cdn-images.mailchimp.com/embedcode/slim-10_7.css" rel="stylesheet" type="text/css">
<style type="text/css">
	#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
	/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
	   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
</style>
<div id="mc_embed_signup">
<form action="//flippercode.us10.list-manage.com/subscribe/post?u=eb646b3b0ffcb4c371ea0de1a&amp;id=3ee1d0075d" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
    <div id="mc_embed_signup_scroll">
	<label for="mce-EMAIL">Subscribe to our mailing list</label>
	<input type="email"  name="EMAIL" value="'.get_bloginfo('admin_email').'" class="email" id="mce-EMAIL" placeholder="email address" required>
    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_eb646b3b0ffcb4c371ea0de1a_3ee1d0075d" tabindex="-1" value=""></div>
    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="bluebg check_for_updates_btn"></div>
    </div>
</form>
</div>

<!--End mc_embed_signup-->';
			 return $form;

		}


		function init($pluginInfo) {

			$this->setup_plugin_info( $pluginInfo );

			foreach ( $this->commonBlocks as $block ) {

				switch ( $block ) {
				    case 'product-activation':
				    	if( isset( $this->licenseDetails['valid_upto'] ) ) {
		    				$support_date = strtotime( $this->licenseDetails['valid_upto'] );
		    			}

		    			if( isset( $this->licenseDetails['licence'] ) ) {
		    				$licence_type = '<b>'.$this->licenseDetails['licence'].'</b>';
		    			} else {
		    				$licence_type = '<b>Single Site</b>';
		    			}

						if ( empty( $this->userHasLicense ) ) {
							$this->blockClass = 'red';
							$status = '<i class="fa fa-ban" aria-hidden="true"></i>&nbsp;&nbsp;Not Verified';
						} else {
							$this->blockClass = 'green';
							$status = '<i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;Verified';
						}
						$width = ( ! empty( $this->userHasLicense )) ? 'width:68%' : 'width:55%';
						$this->blockHeading = '<div class="product-activation-area"><h1 class="'.$this->blockClass.'" style="'.$width.'">Product Information</h1>';

						$this->blockHeading .= '<span name="activation_status" class="'.$this->blockClass.'bg" id="activation_status">'.$status.'</span></div>';

						$alreadyVerified = '<div class="row brow p-verified"><div class="col-md-2"><i class="fa fa-check" aria-hidden="true"></i></div><div class="col-md-10"><strong>Purchased Verified</strong><br>Your license type is '.$licence_type.' and support is active until <b>'.date('d F, Y',$support_date).'</b></div></div>';

						$this->blockContent .= '<div class="divs">
					     <div class="verifiy-purchase-info">';

						if ( $this->blockClass == 'green' ) {
							$this->blockContent .= $alreadyVerified; }

						$this->blockContent .= '
                        <div class="row brow">
	                       	<div class="col-md-2"><i class="fa fa-thumbs-up" aria-hidden="true"></i></div>
	                       	<div class="col-md-10"><strong>Ticket Support</strong><br>Direct and dedicated personalised support from our support team <a target="_blank" href="http://www.flippercode.com/forums">here</a>.
	                         </div>
                        </div>';
						if ( empty( $this->userHasLicense ) ) {
						 	$this->blockContent .= '<input type = "button" name = "show-verify-form-info" id="next" class="blue register_plugin_button" value="Verify Purchase Now">';
						}
						$is_update = false;
				    	if( is_array($this->newVersion) and isset($this->newVersion['new_version']) ) {
				    		if( version_compare($this->productVersion, $this->newVersion['new_version'])) {
				    			$is_update = true;
				    		}
				    	}

						$this->blockContent .= '<div class="row brow">
	                       	<div class="col-md-2"><i class="fa fa-arrow-right" aria-hidden="true"></i></div>
	                       	<div class="col-md-10">Installed version :<br><strong>'.$this->productVersion.'</strong>
							<div class="action">';
						if( $is_update  == true) {
							$plugin_status = 'Latest Version Available : <strong>'.$this->newVersion['new_version'].'</strong>';
							$plugin_action = '<span class="orangebg" name="plugin_update_status" id="plugin_update_status"><a class="codecanyon-link" href="http://www.codecanyon.net/downloads" target="_blank"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;&nbsp;Update Available</a></span>';
							$status_class = 'orangebg';
						} else {
							$plugin_status = '';
							$status_class = '';
							$plugin_action = '';
						}
						$this->blockContent .='	<input type="button" class="bluebg check_for_updates_btn" name="bluebg check_for_updates_btn" id="bluebg check_for_updates_btn" value="Check Updates">';
						$this->blockContent .=' <div class="loader updatecheck">
								      <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
								      <span class="sr-only">Loading...</span>
								    </div>
								    <div class="latest_version_availalbe">'.$plugin_status.'</div>
								    <div class="plugin-update-area">
										<span class="'.$status_class.'" name="plugin_update_status" id="plugin_update_status">'.$plugin_action.'</span>
									</div>
								</div>
								</div>
								 </div>
							</div>';

					  	if ( empty( $this->userHasLicense ) ) {

				      		$this->blockContent .= '<div class="verifiy-purchase-form">
					     	'.$this->get_purchase_verfication_form().'
					     	<div class="go_back"><input type = "button" name = "show-verify-form" id="prev" class="blue register_plugin_button" value="Go Back">
					     	</div></div>';
				        }

						$this->blockContent .= '</div>';

						// $this->blockContent = $activationBlock;
				         break;

				    case 'product-updates':

				    	if ( true ) {
				      	    $this->blockClass = 'green';
				      	    $status = '<i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;Plugin Up To Date';
					    } else {
					      	 $this->blockClass = 'orange';
					      	 $status = '<i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;Update Available';
					    }
						// class="'.$this->blockClass.'"
						$this->blockHeading = '<div class="plugin-update-area">
					  <h1 class="full">Plugin Updates</h1>';
						$this->blockHeading .= '<span name="plugin_update_status" id="plugin_update_status"></span></div>';
						$this->blockContent = '
                        <div><br>Installed version :<br><strong>'.$this->productVersion.'</strong><br><div class="action">
                        <input type="button" class="bluebg check_for_updates_btn" name="bluebg check_for_updates_btn" id="bluebg check_for_updates_btn" value="Check Updates">
                          <div class="loader updatecheck">
                             <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
							 <span class="sr-only">Loading...</span>
							</div></div><div class="latest_version_availalbe"></div></div>';
				         break;
				    case 'newsletter':
				         $this->blockHeading = '<h1>Our NewsLetters</h1>';
						$this->blockContent = '
				      <div class="row brow"> 
	                       	<div class="col-md-2"><i class="fa fa-bullhorn" aria-hidden="true"></i></div>
	                       	<div class="col-md-10"><strong>Stay Updated</strong><br>Receive updates on our  new product features and new products effortlessly.		
	                         </div>
                        </div>
                        <div class="row brow"> 
	                       	<div class="col-md-2"><i class="fa fa-thumbs-up" aria-hidden="true"></i></div>
	                       	<div class="col-md-10"><strong>Privacy Ensured</strong><br>We will not share your email addresses in any case.		
	                         </div>
                        </div>';

						$this->blockContent .= $this->get_mailchimp_integration_form();

				    	break;

				    case 'product-support':
				    	 if( $this->have_premium ) {
				    	 	$this->blockHeading = '<h1>Pro Version</h1>';
				    	 } else {
				    	 	$this->blockHeading = '<h1>Product Support</h1>';
				    	 }
				         
						 $this->blockContent = '
				      <div class="row brow"> 
	                       	<div class="col-md-2"><i class="fa fa-file" aria-hidden="true"></i></div>
	                       	<div class="col-md-10"><strong>Online Documentation</strong><br>For our each product we have very well explained starting guide to get you started in matter of minutes.<br><strong><a class="blue get_started_link" href="'.$this->docURL.'" target="_blank"> Get Started</a></strong>
	                         </div>
                        </div>
                        <div class="row brow"> 
	                       	<div class="col-md-2"><i class="fa fa-file-video-o" aria-hidden="true"></i></div>
	                       	<div class="col-md-10"><strong>Online Demo</strong><br>For our each product we have set up demo pages where you can see the plugin in working mode. You can see a working demo before making a purchase.<br><strong><a href="'.$this->demoURL.'" target="_blank" class="blue"> Click Here</a></strong>
	                         </div>
                        </div>';
				        break;
					 case 'socialmedia':
			        	 $this->blockHeading = '<h1>We are Social</h1>';
						 $this->blockContent = '
                        <div>We hold a good presence on social media. You can reach us via following social media links. Stay connected and updated with what we are upto.
                        </div><br>
                        <div class="social-media-links">
                           <a href="https://profiles.wordpress.org/flippercode/" target="_blank"><i class="fa fa-wordpress" aria-hidden="true"></i></a>
                           <a href="https://www.facebook.com/flippercodepvtltd/" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
                           <a href="http://twitter.com/wpflippercode" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                           <a href="https://www.linkedin.com/company/2737561" target="_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
                           <a href="https://plus.google.com/+Flippercode" target="_blank"><i class="fa fa-google-plus-official" aria-hidden="true"></i></a>
                         </div>';
			        break;

			        case 'suggestion-area':
				        $this->blockHeading = '<div class="user-suggestion-area"><h1>Suggestion Box</h1></div>';
						$this->blockContent = '<div class="row brow"> 
	                       	<div class="col-md-2"><i class="fa fa-diamond" aria-hidden="true"></i></div>
	                       	<div class="col-md-10"><strong>Provide Suggestions</strong><br>Provide your valuable suggestions and feedbacks about the product so that we can make it even better for you.		
	                         </div>
                        </div>';

						$this->blockContent .= $this->get_suggestion_form();
			        break;

			        case 'refund-block':
						$this->blockHeading = '<h1>Get Refund</h1>';
						$this->blockContent = '<div class="row brow"> 
	                       	<div class="col-md-2"><i class="fa fa-smile-o" aria-hidden="true"></i></div>
	                       	<div class="col-md-10"><strong>Instant Refund</strong><br>We provide instant support and assistance to our customers with our support system, however you can instantly initiate a refund if you are not satisfied with our product.';
						if ( ! empty( $this->userHasLicense ) ) {

							$this->blockContent .= '<br><br>Please click on the below button to initiate the refund process.<br><br><a target="_blank" class="bluebg button refundbtn" href="http://codecanyon.net/refund_requests/new">Request a Refund</a>';
						} else {
							$this->blockContent .= '<br><br>Please click on the below button to initiate the refund process.<br><br> <span class="verify_first">Verify your purchase to get refund.</span>';

						}

	                       $this->blockContent .= '</div></div>';
					break;
					case 'extended-support':
						$this->blockHeading = '<h1 style="width:100%">Extended Technical Support</h1>';
						$this->blockContent = '<div class="row brow"> 
	                       	<div class="col-md-2"><i class="fa fa-life-ring" aria-hidden="true"></i><br></div>
	                       	<div class="col-md-10"><strong>Real Technical Support</strong><br>We provide technical support for all of our products.You can opt for 6 months support or 1 year support that comes with exciting offers.<br><br>
	                         	<div class="support_btns"><a target="_blank" href="'.esc_url( $this->productSaleURL ).'" name="one_year_support" id="one_year_support" value="" class="blugbg button support">Extend support to 12 months</a>
	                       	    <a target="_blank" href="'.esc_url( $this->multisiteLicence ).'" name="multi_site_licence" id="multi_site_licence" class="blugbg button supportbutton">Get Multiple Site Licence</a></div>

	                         </div>

                    </div>';

					break;

				}
				$info = array( $this->blockHeading,$this->blockContent );

				$this->commonBlockMarkup .= $this->get_block_markup( $info );

			}

		}

		function get_suggestion_form() {

			ob_start(); ?>
         
	         <form name="user-suggestion-form" id="user-suggestion-form" action="#" method="post">
	         <textarea rows="5" name="user-suggestion" required id="user-suggestion" placeholder= "Do you have any suggestions to improve this product ? We'd really like to hear and understand your much valuable suggestions any time."></textarea>
	          <input type="button" class="blue submit-suggestion" name="submit-user-suggestion" id="submit-user-suggestion" name="submit-user-suggestion" value="Submit Suggestion">
	          <div class="loader submitsuggestion">
								 <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
								 <span class="sr-only">Loading...</span>
			  </div>
	          <input type="hidden" name="suggestion-for" value="<?php echo $this->productTextDomain; ?>">
				<?php wp_nonce_field( 'user-suggestion-submitted','uss' ); ?>
	         </form>
	         
			<?php
			$suggestionForm = ob_get_contents();
			ob_clean();

			return $suggestionForm;

		}


		function get_block_markup($blockinfo) {

			$markup = '<div class="col-md-4 blocks">
			                <div class="block-content">
			                    <div class="header">'.$blockinfo[0].'</div>
			                    <div class="body">'.$blockinfo[1].'</div>
			                    <div class="footer"></div>
			                </div>
            		   </div>';

			$this->productBlocksRendered++;
			if ( $this->productBlocksRendered % 3 == 0 ) {
				$markup .= '</div></div><div class="row"><div class="flexrow">'; }
			return $markup;

		}

		function renderBlocks() {

            $this->finalproductOverviewMarkup = '';
               
            if(isset($this->have_premium))
               $this->finalproductOverviewMarkup .= $this->productFeaturesMarkup;
              
			$this->finalproductOverviewMarkup .= $this->commonBlockMarkup.$this->pluginSpecificBlockMarkup;

			if ( empty( $this->loadPromotionalProducts ) ) {
				$this->finalproductOverviewMarkup .= $this->get_product_slider(); }

			echo $this->finalproductOverviewMarkup;

		}

	}



}
