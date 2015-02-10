=== Bamboo Columns ===
Contributors: Bamboo Solutions
Donate link: http://www.bamboosolutions.co.uk
Tags: columns, layout, shortcodes
Requires at least: 3.0.1
Tested up to: 4.0
Stable tag: 1.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin provides several shortcodes for organising your content into multi-column layouts. It supports two, three and four column layouts.

== Description ==

This plugin provides several shortcodes for organising your content into multi-column layouts. It supports two, three and four column layouts and allows for content to span multiple columns if required.


Usage

Insert the required shortcodes into your content as follows:

2 column layout:

     [column-half-1]
     First column of content
     [/column-half-1]
     [column-half-2]
     Second column of content
     [/column-half-2]

3 column layout:

     [column-third-1]
     First column of content
     [/column-third-1]
     [column-third-2]
     Second column of content
     [/column-third-2]
     [column-third-3]
     Third column of content
     [/column-third-3]

4 Column layout:

     [column-quarter-1]
     First column of content
     [/column-quarter-1]
     [column-quarter-2]
     Second column of content
     [/column-quarter-2]
     [column-quarter-3]
     Third column of content
     [/column-quarter-3]
     [column-quarter-4]
     Fourth column of content
     [/column-quarter-4]

If you want content to span multiple columns you can combine the shortcodes to create a column spans multiple spaces, for example:

     1 Third / 2 Thirds

     [column-third-1]
     First column of content
     [/column-third-1]
     [column-third-2-3]
     Second column of content that spans the second and third columns
     [/column-third-2-3]

     1 Quarter / 2 Quarters / 1 Quarter

     [column-quarter-1]
     First column of content
     [/column-quarter-1]
     [column-quarter-2-3]
     Second column of content that spans the second and third columns
     [/column-quarter-2-3]
     [column-quarter-4]
     Third column of content that occupies the fourth quarter column
     [/column-quarter-4]

You can also change the background colour of a colour by adding an attribute to the shortcode as follows:

     [column-half-1 background="e8e8e8"]


== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `noodle-columns` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Changelog ==

= 1.2 =
* Rebrand from Noodle to Bamboo

= 1.1 =
* Fixed issue caused by new lines between shortcodes

= 1.0 =
* Initial version.