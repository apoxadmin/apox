<?php
/**
 * Class: wcjp_Model_Overview
 * @author Flipper Code <hello@flippercode.com>
 * @version 2.0.0
 * @package Core
 */

if ( ! class_exists( 'wcjp_Model_Overview' ) ) {

	/**
	 * Overview model for Plugin Overview.
	 * @package Core
	 * @author Flipper Code <hello@flippercode.com>
	 */
	class wcjp_Model_Overview extends FlipperCode_Model_Base {
		/**
		 * Intialize Backup object.
		 */
		function __construct() {
		}
		/**
		 * Admin menu for Settings Operation
		 */
		function navigation() {
			return array(
			'wcjp_how_overview' => __( 'How to Use', WCJP_TEXT_DOMAIN ),
			);
		}
	}
}
