<?php
/**
 * Class: wcjp_Model_Code
 * @author Flipper Code <hello@flippercode.com>
 * @package Core
 * @version 2.0.0
 */

if ( ! class_exists( 'wcjp_Model_Code' ) ) {

	/**
	 * Code model for CRUD operation.
	 * @package Core
	 * @author Flipper Code <hello@flippercode.com>
	 */
	class wcjp_Model_Code extends FlipperCode_Model_Base
	{
		/**
		 * Validations on code properies.
		 * @var array
		 */
		public $validations = array(
		'data_title' => array( 'req' => 'Please enter title.' ),
		'data_source' => array( 'req' => 'Please enter source code.' ),

		);
		/**
		 * Intialize rule object.
		 */
		public function __construct() {
			$this->table = WCJP_TBL_CODES;
			$this->unique = 'id';
		}
		/**
		 * Admin menu for CRUD Operation
		 * @return array Admin meny navigation(s).
		 */
		public function navigation() {

			return array(
			'wcjp_addcss_code' => __( 'Add CSS', WCJP_TEXT_DOMAIN ),
			'wcjp_managecss_code' => __( 'Manage CSS', WCJP_TEXT_DOMAIN ),
			'wcjp_addjs_code' => __( 'Add JS', WCJP_TEXT_DOMAIN ),
			'wcjp_managejs_code' => __( 'Manage JS', WCJP_TEXT_DOMAIN ),
			'wcjp_addphp_code' => __( 'Add PHP', WCJP_TEXT_DOMAIN ),
			'wcjp_managephp_code' => __( 'Manage PHP', WCJP_TEXT_DOMAIN ),
			);

		}
		/**
		 * Install table associated with Code entity.
		 * @return string SQL query to install wce_editor_content table.
		 */
		public function install() {

			global $wpdb;
			$sql = 'CREATE TABLE '.$wpdb->prefix.'wce_editor_content (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `data_title` varchar(100) NOT NULL,
			  `data_type` varchar(30) NOT NULL,
			  `data_source` longtext NOT NULL,
			  `data_cond` varchar(60) NOT NULL,
			  `tag_name` varchar(100) NOT NULL,
              `accept_args` int(11) NOT NULL,
              `status` tinyint(1) NOT NULL DEFAULT "1",
			   PRIMARY KEY (`id`)
              )';

			return $sql;
		}
		/**
		 * Get Rule(s)
		 * @param  array $where  Conditional statement.
		 * @return array         Array of Rule object(s).
		 */
		public function fetch($where = array()) {

			$objects = $this->get( $this->table, $where );

			if ( isset( $objects ) ) {
				return $objects;
			}
		}

		/**
		 * Add or Edit Operation.
		 */
		public function save() {
			$data = array();
			$entityID = '';
			if ( isset( $_REQUEST['_wpnonce'] ) ) {
				$nonce = sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) ); }

			if ( isset( $nonce ) and ! wp_verify_nonce( $nonce, 'wpgmp-nonce' ) ) {

				die( 'Cheating...' );

			}

			$this->verify( $_POST );

			if ( is_array( $this->errors ) and ! empty( $this->errors ) ) {
				$this->throw_errors();
			}

			if ( isset( $_POST['entityID'] ) ) {
				$entityID = intval( wp_unslash( $_POST['entityID'] ) );
			}

			if ( $entityID > 0 ) {
				$where[ $this->unique ] = $entityID;
			} else {
				$where = '';
			}

			$data['data_title'] = sanitize_text_field( wp_unslash( $_POST['data_title'] ) );
			$data['data_source'] = wp_unslash( $_POST['data_source'] );
			$data['data_type'] = sanitize_text_field( wp_unslash( $_POST['data_type'] ) );
			$data['data_cond'] = sanitize_text_field( wp_unslash( $_POST['data_cond'] ) );
			$data['tag_name'] = sanitize_text_field( wp_unslash( $_POST['tag_name'] ) );
			if ( isset( $_POST['status'] ) ) {
				$data['status'] = 0;
			} else {
				$data['status'] = 1;
			}

			$result = FlipperCode_Database::insert_or_update( $this->table, $data, $where );

			if ( false === $result ) {
				$response['error'] = __( 'Something went wrong. Please try again.',WCJP_TEXT_DOMAIN );
			} elseif ( $entityID > 0 ) {
				$response['success'] = __( 'Code updated successfully',WCJP_TEXT_DOMAIN );
			} else {
				$response['success'] = __( 'Code added successfully.',WCJP_TEXT_DOMAIN );
			}
			return $response;
		}

		/**
		 * Delete rule object by id.
		 */
		public function delete() {
			if ( isset( $_GET['id'] ) ) {
				$id = intval( wp_unslash( $_GET['id'] ) );
				$connection = FlipperCode_Database::connect();
				$this->query = $connection->prepare( "DELETE FROM $this->table WHERE $this->unique='%d'", $id );
				return FlipperCode_Database::non_query( $this->query, $connection );
			}
		}

	}
}
