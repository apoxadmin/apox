<?php
/**
 * Class: wpp_Model_Shortcode
 * @author Flipper Code <hello@flippercode.com>
 * @version 2.0.0
 * @package Core
 */

if ( ! class_exists( 'wpp_Model_Shortcode' ) ) {

	/**
	 * Shortcode model to display output on frontend.
	 * @package Core
	 * @author Flipper Code <hello@flippercode.com>
	 */
	class wpp_Model_Shortcode extends FlipperCode_Model_Base {
		/**
		 * Intialize Shortcode object.
		 */
		function __construct() {
		}
		/**
		 * Admin menu for Settings Operation
		 * @return array Admin menu navigation(s).
		 */
		function navigation() {
			return array();
		}
	}
}
