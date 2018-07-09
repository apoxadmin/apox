<?php
/**
 * Controller class
 * @author Flipper Code<hello@flippercode.com>
 * @version 3.0.0
 * @package Posts
 */

if ( ! class_exists( 'WCJP_Controller' ) ) {

	/**
	 * Controller class to display views.
	 * @author: Flipper Code<hello@flippercode.com>
	 * @version: 3.0.0
	 * @package: Maps
	 */

	class WCJP_Controller extends Flippercode_Factory_Controller{


		function __construct() {

			parent::__construct(WCJP_MODEL,'WCJP_Model_');

		}

	}
	
}
