<?php
/*
* Takes all ajax FONT requests and thanks to .htaccess file next to it should avoid mod security errors like in admin-ajax.php
*/
define( 'DOING_AJAX', true );
define( 'WP_ADMIN', true );
require_once('../../../../wp-load.php');
/** Load WordPress Administration APIs */
require_once( ABSPATH . 'wp-admin/includes/admin.php' );
/** Load Ajax Handlers for WordPress Core */
//require_once( ABSPATH . 'wp-admin/includes/ajax-actions.php' );
//send_origin_headers();
@header('Access-Control-Allow-Origin: *');
@header( 'Content-Type: text/html; charset=' . get_option( 'blog_charset' ) );
@header( 'X-Robots-Tag: noindex' );
send_nosniff_header();
nocache_headers();
do_action( 'admin_init' );
if (is_user_logged_in())
	do_action( 'wp_ajax_' . $_REQUEST['action'] ); // Authenticated actions
else
	do_action( 'wp_ajax_nopriv_' . $_REQUEST['action'] ); // Non-admin actions
// Default status
die('Memento mori');