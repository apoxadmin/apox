<?php
/**
 * Factory Classes
 * @author Flipper Code <hello@flippercode.com>
 * @package Core
 */

if ( ! class_exists( 'AbstractFactoryFlipperCode' ) ) {

	/**
	 * Factory Class Abstract
	 * @author Flipper Code <hello@flippercode.com>
	 * @version 3.0.0
	 * @package Core
	 */
	abstract class AbstractFactoryFlipperCode {
		/**
		 * Abstrct create object
		 * @param  string $object Object Type.
		 * @return object         Return class object.
		 */
		private $modulePrefix;
		private $modulePath;
		abstract public function create_object($object);
	}
}
