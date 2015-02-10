=== WP Easy Columns ===
Contributors: Pat Friedl
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=donations&business=T8V954QPLEW2J
Tags: columns, column, grid layout, box, boxes, feature box, layout, magazine, page, posts, magazine columns, magazine layout, float div
Requires at least: 2.7
Tested up to: 3.9
Stable tag: 2.1.3

Easy Columns provides the shortcodes to create a grid system or magazine style columns for laying out your pages (or even posts!) just the way you need them.

== Description ==

= What is Easy Columns? =
Easy Columns provides the shortcodes to create a grid system or magazine style columns for laying out your pages or posts on demand.

= Available Columns =
Using the shortcodes, you can get any combination of 1/4, 1/2, 1/3, 2/3, 3/4, 1/5, 2/5, 3/5 and 4/5 columns. You can insert <strong>at least thirty</strong> unique variations of columns on any page or post.

= Easy to Use =
Quickly add columns to your pages from the editor with an easy to use "pick n' click" interface. BEst of all, Easy Columns works with ANY theme!

= Example =
To create content with 3 columns, you would use the shortcodes like this:

[ezcol_1third]this is column 1[/ezcol_1third]
[ezcol_1third]this is column 2[/ezcol_1third]
[ezcol_1third_end]this is column 3[/ezcol_1third_end]

The result are 3 columns about 33% in width of their container.

== Installation ==

1. Upload `wp-ez-columns` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. You can customize your columns in the settings menu under Settings > Easy Columns
4. Use any of the following shortcodes in your posts or pages:
   Available Shortcodes:

   = 1/4 columns =
   [ezcol_1quarter id="" class="" style=""][/ezcol_1quarter]
   [ezcol_1quarter_end id="" class="" style=""][/ezcol_1quarter_end]

   = 1/2 columns =
   [ezcol_1half id="" class="" style=""][/ezcol_1half]
   [ezcol_1half_end id="" class="" style=""][/ezcol_1half_end]

   = 3/4 columns =
   [ezcol_3quarter id="" class="" style=""][/ezcol_3quarter]
   [ezcol_3quarter_end id="" class="" style=""][/ezcol_3quarter_end]

   = 1/3 columns =
   [ezcol_1third id="" class="" style=""][/ezcol_1third]
   [ezcol_1third_end id="" class="" style=""][/ezcol_1third_end]

   = 2/3 columns =
   [ezcol_2third id="" class="" style=""][/ezcol_2third]
   [ezcol_2third_end id="" class="" style=""][/ezcol_2third_end]

   = 1/5 columns =
   [ezcol_1fifth id="" class="" style=""][/ezcol_1fifth]
   [ezcol_1fifth_end id="" class="" style=""][/ezcol_1fifth_end]

   = 2/5 columns =
   [ezcol_2fifth id="" class="" style=""][/ezcol_2fifth]
   [ezcol_2fifth_end id="" class="" style=""][/ezcol_2fifth_end]

   = 3/5 columns =
   [ezcol_3fifth id="" class="" style=""][/ezcol_3fifth]
   [ezcol_3fifth_end id="" class="" style=""][/ezcol_3fifth_end]

   = 4/5 columns =
   [ezcol_4fifth id="" class="" style=""][/ezcol_4fifth]
   [ezcol_4fifth_end id="" class="" style=""][/ezcol_4fifth_end]

   = Special columns =
   [ezdiv id="" class="" style=""][/ezdiv]
   (easily create DIVs in your content without editing HTML)

   = Additional shortcodes =
   [ezcol_divider] (clears all floats and creates a 2px high, 100% width div)
   [ezcol_end_left] (clears left float)
   [ezcol_end_right] (clears right float)
   [ezcol_end_both] (clears both)

   **Be sure to insert the "_end" column shortcode for your last column!**

== Frequently Asked Questions ==

= Is This Plugin Supported? =
Yes. Just send an email, and I'd be happy to help

= How can I customize the columns? =
You can edit the wp-ez-columns.css file to customize the layouts. Be sure to back up the CSS before testing!

= Can I put anything in the columns? =
Yes, as long as the content isn't larger than the column, otherwise the CSS will break and cause line breaks.

= What good are columns? =
Columns can be used in CMS layouts, as feature boxes, in magazine layouts and **squeeze page layouts** - it's only limited by your imagination.

= Can You Create a Pro Version With Multiple Column Styles? =
Maybe! If you want that feature, send me an email. I get enough emails and I'll do it!

== Screenshots ==

1. The Easy Columns settings page.
2. The Easy Columns Visual Editor in Page/Post edit.

== Upgrade Notice ==

Upgrade normally via your Wordpress admin -> Plugins panel.

== Changelog ==

= 2.1.3 =
* Fixed error with WP 3.9 tinyMCE shortcode insertion
* Deleting the plugin no longer throws an error

= 2.1.2 =
* Changed the tinyMCE window to load wp-load.php instead of wp-config.php
* Added jQuery to tinyMCE window
* Added class input to column selection - applies a CSS class name to all the columns you insert
* Added better styling to the options page
* Fixed the custom CSS not rendering issue - Easy Columns options will now render.
* Added a Custom CSS option to the options page - style columns with custom classes or use the base classes!
* Changed ezcol-divider class to be height: 0 margin: 0
* Should have any uninstall hook erros fixed

= 2.1.1 =
* Added parent class to keep content max-wisth at 100% to prevent overflow
* fixed fractional display of text in columns (removed CSS3 text enhancements)
* Added full integration for responsive design at 768 and 480 pixel widths - now 100% responsive!
* More code optimization and tweaking

= 2.1 =
* Upgraded visual editor window to WP 3.6 compliance
* Updated styles in the visual editor
* Streamlined/optimized code
* Updated CSS to auto-hyphenate long words to they conform to columns widths
* Migrated shortcodes from 'wpcol_' to 'ezcol_' (no worries, it's backwards compatible)

= 2.0 =
* Upgraded visual editor window to WP 3.2 compliance
* Completely reworked visual editor interface
* Added additional "pick n click" column combinations

= 1.2.1 =
* Added 4/5 column support
* Added custom CSS logic for the 1/5-4/5 columns
* Updated and simplified the visual editor

= 1.2 =
* Additional shortcodes added. Please upgrade!

= 1.2 =
* Added Support for 1/5, 2/5 and 3/5 columns.

= 1.1 =
* Updated the shortcodes to clean up the WordPress &quot;Auto P&quot; functions that cause gaps, etc.

= 1.0 =
* New code