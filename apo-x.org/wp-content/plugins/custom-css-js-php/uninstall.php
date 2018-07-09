<?php 

if(!defined('WP_UNINSTALL_PLUGIN')) {
  die('You are not allowed to call this page directly.');
}

global $wpdb;

$wpdb->query("DROP TABLE ".$wpdb->prefix."wce_editor_content");

?>