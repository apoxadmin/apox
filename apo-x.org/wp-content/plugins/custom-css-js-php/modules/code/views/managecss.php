<?php
/**
 * Class wcjp_CSS_Table File
 * @author Flipper Code <hello@flippercode.com>
 * @package Core
 */

if ( class_exists( 'WP_List_Table_Helper' ) and ! class_exists( 'wcjp_CSS_Table' ) ) {

	/**
	 * Class wcjp_CSS_Table to display rules for manage.
	 * @author Flipper Code <hello@flippercode.com>
	 * @package Core
	 */
	class wcjp_CSS_Table extends WP_List_Table_Helper {
		/**
		 * Intialize class constructor.
		 * @param array $tableinfo Rules Table Informaiton.
		 */
		public function __construct($tableinfo) {
			parent::__construct( $tableinfo );
		}
			/**
			 * Output for Data Condition column.
			 * @param array $item Code Row.
			 */
			public function column_data_cond($item) {

			if ( '' == $item->data_cond ) {
				echo __( 'Shortcode',WCJP_TEXT_DOMAIN );
			} else if ( 'header' == $item->data_cond ) {
				echo __( 'wp_head()',WCJP_TEXT_DOMAIN );
			} else if ( 'footer' == $item->data_cond ) {
				echo __( 'wp_footer()',WCJP_TEXT_DOMAIN );
			}

			}

			/**
			 * Output for Data Status column.
			 * @param array $item Code Row.
			 */
			public function column_status($item) {

				if ( 1 == $item->status ) {
					echo __( 'Enabled', WCJP_TEXT_DOMAIN );
				} else {
					echo __( 'Disabled', WCJP_TEXT_DOMAIN );
				}

			}

			/**
			 * Output for Data Shortcode column.
			 * @param array $item Code Row.
			 */
			public function column_shortcode($item) {

				echo '[wce_code id='.$item->id.']';

			}
	}


	global $wpdb;
	$columns   = array( 'data_title' => __( 'Title',WCJP_TEXT_DOMAIN ), 'data_cond' => __( 'Apply Using',WCJP_TEXT_DOMAIN ), 'status' => __( 'Status',WCJP_TEXT_DOMAIN ), 'shortcode' => __( 'Shortcode',WCJP_TEXT_DOMAIN ) );
	$sortable  = array( 'data_title','data_cond' );
	$tableinfo = array(
	'table' => WCJP_TBL_CODES,
	'sql' => 'select id,data_title, data_cond, status from '.WCJP_TBL_CODES.' where data_type="css"',
	'textdomain' => WCJP_TEXT_DOMAIN,
	'singular_label' => 'code',
	'plural_label' => 'code',
	'admin_listing_page_name' => 'wcjp_managecss_code',
	'admin_add_page_name' => 'wcjp_addcss_code',
	'primary_col' => 'id',
	'columns' => $columns,
	'sortable' => $sortable,
	'per_page' => 200,
	'actions' => array( 'edit','delete' ),
	'col_showing_links' => 'data_title',
	);
	return new wcjp_CSS_Table( $tableinfo );

}
?>
