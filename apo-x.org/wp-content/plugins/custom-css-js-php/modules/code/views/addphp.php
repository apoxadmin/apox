<?php
/**
 * Template for Add & Edit PHP Code
 * @author  Flipper Code <hello@flippercode.com>
 * @package Core
 */

if ( isset( $_REQUEST['_wpnonce'] ) ) {

	$nonce = sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) );

	if ( ! wp_verify_nonce( $nonce, 'wpgmp-nonce' ) ) {

		die( 'Cheating...' );

	} else {
		$data = $_POST;
	}
}
global $wpdb;
$modelFactory = new WCJP_Model();
$rule_obj = $modelFactory->create_object( 'code' );
if ( isset( $_GET['doaction'] ) and 'edit' == $_GET['doaction'] and isset( $_GET['id'] ) ) {
	$rule_obj = $rule_obj->fetch( array( array( 'id', '=', intval( wp_unslash( $_GET['id'] ) ) ) ) );
	$data = (array) $rule_obj[0];
} elseif ( ! isset( $_GET['doaction'] ) and isset( $response['success'] ) ) {
	// Reset $_POST object for antoher entry.
	unset( $data );
}
$form  = new FlipperCode_HTML_Markup();
$form->set_header( __( 'PHP Code', WCJP_TEXT_DOMAIN ), $response, __( 'Manage CSS', WCJP_TEXT_DOMAIN ), 'wcjp_managecss_code' );

$form->add_element( 'text', 'data_title', array(
	'lable' => __( 'Title', WCJP_TEXT_DOMAIN ),
	'value' => (isset( $data['data_title'] ) and ! empty( $data['data_title'] )) ? $data['data_title'] : '',
	'desc' => __( 'Give a title to code snippet.', WCJP_TEXT_DOMAIN ),
	'required' => true,
	'placeholder' => __( 'Title', WCJP_TEXT_DOMAIN ),
));


$period_options = array(
	'' => __( 'Shortcode',WCJP_TEXT_DOMAIN ),
	'action' => __( 'WP Action',WCJP_TEXT_DOMAIN ),
	'filter' => __( 'WP Filter',WCJP_TEXT_DOMAIN ),
	);

$form->add_element( 'radio', 'data_cond', array(
	'lable' => __( 'Apply Using', WCJP_TEXT_DOMAIN ),
	'radio-val-label' => $period_options,
	'current' => $data['data_cond'],
	'class' => 'chkbox_class ',
	'default_value' => '',
));

if ( isset( $data['data_cond'] ) and '' != $data['data_cond'] ) {
	$show = 'true';
} else {
	$show = 'false';
}

$form->add_element( 'text', 'tag_name', array(
	'lable' => __( 'Action/Filter Name', WCJP_TEXT_DOMAIN ),
	'value' => (isset( $data['tag_name'] ) and ! empty( $data['tag_name'] )) ? $data['tag_name'] : '',
	'desc' => __( 'Write wordpress action or filter name. Available <a href="https://codex.wordpress.org/Plugin_API/Action_Reference" >Actions</a> and <a href="https://codex.wordpress.org/Plugin_API/Filter_Reference" >filters</a>.', WCJP_TEXT_DOMAIN ),
	'required' => true,
	'show' => $show,
));


$form->add_element( 'textarea', 'data_source', array(
		'lable' => __( 'Paste php code here', WCJP_TEXT_DOMAIN ),
		'value' => $data['data_source'],
		'desc' => __( 'You can write or paste php code here. You need to use &#60;&#63;php tag. ',WCJP_TEXT_DOMAIN ),
		'textarea_rows' => 10,
		'textarea_name' => 'data_source',
		'class' => 'form-control',
		'required' => true,
	));

$form->add_element( 'submit', 'save_entity_data', array(
	'value' => __( 'Save PHP',WCJP_TEXT_DOMAIN ),
));

$form->add_element( 'hidden', 'operation', array(
	'value' => 'save',
));

$form->add_element( 'hidden', 'data_type', array(
		'value' => 'php',
));

if ( isset( $_GET['doaction'] ) and 'edit' == $_GET['doaction'] ) {

	$form->add_element( 'hidden', 'entityID', array(
		'value' => intval( wp_unslash( $_GET['id'] ) ),
	));
}

$form->render();
