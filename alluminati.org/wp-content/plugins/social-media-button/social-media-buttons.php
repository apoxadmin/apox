<?php
/*
Plugin Name: Social Media Buttons
Plugin URI: https://wordpress.org/plugins/social-media-button
Description: A WordPress plugin that displays various social media button at Wordpress widgets area to find yourself.
Version: 1.0
Author: Sayful Islam
Author URI: http://sayful.net
Text Domain: smbuttons
Domain Path: /languages/
License: GPLv2 or later
*/
include 'widget.php';

function find_me_plugin_scripts() {
	wp_enqueue_style('find_me_font_awesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css');
}
add_action('init', 'find_me_plugin_scripts');