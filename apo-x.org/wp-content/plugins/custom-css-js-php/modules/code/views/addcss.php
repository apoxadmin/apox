<?php
/**
 * Template for Add & Edit Rules
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
$form->set_header( __( 'CSS Code', WCJP_TEXT_DOMAIN ), $response, __( 'Manage CSS', WCJP_TEXT_DOMAIN ), 'wcjp_managecss_code' );

$form->add_element( 'text', 'data_title', array(
	'lable' => __( 'Title', WCJP_TEXT_DOMAIN ),
	'value' => (isset( $data['data_title'] ) and ! empty( $data['data_title'] )) ? $data['data_title'] : '',
	'desc' => __( 'Give a title to code snippet.', WCJP_TEXT_DOMAIN ),
	'required' => true,
	'placeholder' => __( 'Title', WCJP_TEXT_DOMAIN ),
));


$period_options = array(
	'' => __( 'Shortcode',WCJP_TEXT_DOMAIN ),
	'header' => __( 'wp_head',WCJP_TEXT_DOMAIN ),
	'footer' => __( 'wp_footer',WCJP_TEXT_DOMAIN ),
	);

$form->add_element( 'radio', 'data_cond', array(
	'lable' => __( 'Apply Using', WCJP_TEXT_DOMAIN ),
	'radio-val-label' => $period_options,
	'current' => $data['data_cond'],
	'class' => 'chkbox_class ',
	'desc' => __( 'wp_head and wp_footer are actions. Your theme must have wp_head() before closing head tag or wp_footer() before closing body tag.',WCJP_TEXT_DOMAIN ),
	'default_value' => '',
));

$form->add_element( 'textarea', 'data_source', array(
		'lable' => __( 'Paste css code here', WCJP_TEXT_DOMAIN ),
		'value' => $data['data_source'],
		'desc' => __( 'You can write or paste css code here. No need to add &#60;style&#62; tag. Read about <a target="_blank" href="https://codex.wordpress.org/Plugin_API/Action_Reference/wp_head">wp_head</a> and <a target="_blank" href="https://codex.wordpress.org/Plugin_API/Action_Reference/wp_footer">wp_footer</a> ',WCJP_TEXT_DOMAIN ),
		'textarea_rows' => 10,
		'textarea_name' => 'data_source',
		'class' => 'form-control',
	));

if ( '0' == $data['status'] ) {
	$data['status'] = 'true';
}
$form->add_element( 'checkbox', 'status', array(
	'lable' => __( 'Turn Off', WCJP_TEXT_DOMAIN ),
	'value' => 'true',
	'current' => $data['status'],
	'desc' => __( 'This source code will not be in use if checked. Useful if your code is incomplete and you want to save it. ', WCJP_TEXT_DOMAIN ),
	'class' => 'chkbox_class',
));


$form->add_element( 'submit', 'save_entity_data', array(
	'value' => __( 'Save CSS',WCJP_TEXT_DOMAIN ),
));

$form->add_element( 'hidden', 'operation', array(
	'value' => 'save',
));

$form->add_element( 'hidden', 'data_type', array(
		'value' => 'css',
));

if ( isset( $_GET['doaction'] ) and 'edit' == $_GET['doaction'] ) {

	$form->add_element( 'hidden', 'entityID', array(
		'value' => intval( wp_unslash( $_GET['id'] ) ),
	));
}

$form->render();
