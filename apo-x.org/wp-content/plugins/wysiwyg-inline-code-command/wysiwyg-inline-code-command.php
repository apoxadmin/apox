<?php
/*
Plugin Name: WYSIWYG Inline Code Command
Plugin URI: http://wordpress.org/extend/plugins/wysiwyg-inline-code-command/
Description: Add a command to the visual editor to mark text as inline code
Version: 2.0
Author: Peter Williams
Author URI: http://newton.cx/~peter/
License: GPL2

    Copyright 2011, 2012, 2013 Peter Williams (email: peter@newton.cx)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function wicc_tinymce_activate() {
    global $pagenow;

    if (!current_user_can ('edit_posts') && !current_user_can ('edit_pages'))
	return;

    if (get_user_option('rich_editing') != 'true')
	return;

    if (in_array ($pagenow, array('post.php', 'post-new.php', 'page.php', 'page-new.php'))) {
	add_filter ('mce_external_plugins', 'wicc_tinymce_addplugin' );
	add_filter ('mce_buttons', 'wicc_tinymce_registerbutton' );
    }
}

function wicc_tinymce_addplugin ($plugin_array) {
    $plugin_array['wicc'] = plugins_url ('wicc-mce-plugin.php', __FILE__);
    return $plugin_array;
}

function wicc_tinymce_registerbutton ($buttons) {
    array_push ($buttons, 'separator', 'wicc');
    return $buttons;
}

add_action ('init', 'wicc_tinymce_activate');
?>