=== Font - official webfonts plugin of Fonts For Web. NO CODING! Just click & change font size, color and font face visually!  ===
Contributors: killerdeveloper
Donate link: http://fontsforweb.com/
Tags: fonts, web fonts, font, fonts plugin, typekit, google webfont, TinyMCE plugin, ajax, webfonts
Requires at least: 2.8.0
Tested up to: 4.4
Stable tag: 7.5.1
Finally official* web fonts plugin for wordpress. CLICK ON ANYTHING TO CHANGE IT(see screenshots)! Then change color, size and font face using sliders and color picker!
== Description ==
Finally official web fonts plugin for wordpress. No need for any coding at all! How? This plugin has an unique method of recognizing of what you click at!

Isn't that natural to just click on something, drag it, choose color from color picker, use slider to change the size and do other modifications visually?

All other plugins were telling me to write a CSS rule and make changes in admin panel without seeing the effect. That wasn't the way it should work for a normal person. Even for me, a developer, making changes by coding and not seeing it gives me reults far from perfection. It's important to see what's changing as you look at the page, and then fine tune it to get a perfect result.

That's why I created this plugin. To be able to see the size change as I drag the slider, and see color change as I use the color picker. To be able to see how the new font face looks like after selecting it from the list.
See the 1 image tutorial [how to use this wordpress fonts plugin](http://wordpress.org/extend/plugins/font/screenshots/ "how to use this wordpres fonts plugin")

There are two modes:
Mode 1 - click on any element:
1. When being logged in as admin go to your home page, or any other page
2. Clic on "font settings" from the top bar and then on "Pick an element from the page"
3. Click on anything you want and name it
4. Change color, size and font face from over 1000 available or upload your own fonts
5. Save

Mode 2 - select a portion of text:
1. Go to the post editing page where you edit your posts and pages
2. Clic on "font settings" from the top bar
3. Select any portion of text. Can be a paragraph, one word or even a signle letter.
4. Change color, size and font face from over 1000 available or upload your own fonts
5. Update your post

Notice:
Always read each font's readme to make sure if it's free for your purposes! SOME fonts are free only for non commercial use, and some, probably just few need a small fee even for personal use.
*Font is an official plugin of FontsFontWeb.com. Over 1000 free web fonts to choose from!
You'll need an API key to convert and store your own fonts on FontsForWeb.com server for commercial purposes.

== Installation ==
Easy way
1. Go to your dashboard > plugin > add > upload
2. Choose downloaded plugin zip file and upload
3. Activate plugin
Alternative way
1. Download and unzip `Font.zip` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to text editor
== Frequently Asked Questions ==
== Screenshots ==
1. General rules editing
1. Post editing - select and apply styles
== Changelog ==
= 5.00 =
Completely redesigned! Fixes fonts list not loading bug and introduces many other changes and improvements.
= 5.1 =
UPDATE! Fixed bug related to not applied font changes. New visual indication for mouseover when selecting items. Related items are now also highlighted. Few other minor fixes.
= 5.11 =
Like on facebook
= 5.12 =
Quick bugfix to prevent ttf file not found error
= 5.13 =
Fixed saving on overly restrictive hostings
= 5.14 =
Important compatibility fix for new ajax handling file
= 5.15 =
Drag things and change their position
= 5.16 =
Fixed plugin crashing and no fonts' list displaying
= 5.17 =
Added 3D text feature
Click to select item
A few bugfixes
A few compatibility improvements
= 5.18 =
IE9 and 10 now displaying all fonts correctly. Added WOFF formats.
= 5.19 =
Fixed "PICK ELEMENT" fatal error, other minor improvements
= 5.20 =
No more silent crashes. Shows an error instead.
New Like/Dislike buttons and contact form.
= 5.21 =
Pick element much more precise
Cancel selecting mode button
Key entry of selector
= 5.22 =
Legacy wordpress compatibility 3.1 but not fully
3.3.1 full support
Small selecting tool tweaks
= 5.23 =
Added reset button
= 5.24 =
Disabled errors
= 5.25 =
Added version number when requesting js or css to make sure the latest files are downloaded. 
Browsers were serving cached old versions disregarding the update.
= 6.00 =
Moved main functions to thin top bar to reduce space taken
= 6.1 =
Compatibility fixes and errors on save shown instead of silent failure
= 6.11 =
Alerts when no selection made to give some guidance to the user
= 6.12 =
Added mime types htaccess for webfonts
= 6.13 =
Alert on api key error, and a new description. 
New rules in htaccess for compatibility.
= 6.14 =
Font files folder is now created by script not unpacked when installing.
= 6.15 =
Wordpress in subdirectory support added. This should fix saving problems on affected websites.
= 6.16 =
Fixed error of ajax error message
"Font settings" can be only seen by admin not by any editor anymore
"Save button" blinks after being clicked and becomes disabled what prevents from second clicking and losing settings
= 6.17 =
Removed facebook api support, like button was dropped long time ago
Fade-in on first run
= 6.18 =
Connection check and error message displayed when can't connect
= 7.0 =
The biggest update and bug fixes compilation for "Font" plugin ever!

-Completely new "effects" window with 3d text
-New design, during work bar moved on top of admin bar to save space
-warning when using an old browser which does not support effects and advanced options
-notice when using very old Wordpress version
-When the plugin is used for the very first time, only one button is shown to pick up an element and start the journey
-Prevention of accidently leaving the page before saving changes

Fixed:
	-warning instead of silent crash when file saving is disabled on user's server
	-deleting multiple presets is not causing problems any more
	-In selection mode when cancelling, a prompt window is not showing in a loop any more

-Lots of other improvements and bug fixes for better overall user experience

= 7.1 =
Compatibility mode, which makes the plugin work even when some poorly written plugin is breaking jQuery
Minor bug fixes
= 7.1.1 =
-Compatibility update for some restrictive hosting providers. 
	-Ajax calls only to built in ajax PHP script
	-TinyMCE editor styles stored in a CSS file instead of pointing to PHP which generates CSS
-htaccess file compatibility improved
= 7.1.2 =
-htaccess compatibility issue fix
-css compatibity improvements
= 7.1.3 =
-htaccess mod
= 7.1.4 =
-Compatibility update with 3 alternative Ajax proxies
= 7.1.5 =
-Support for the latest fonts browser. Now blocked for older versions.
-Like Yes/No button is back
= 7.1.6 =
-Fixed the problem with changes sometimes not being saved in post/page editing modes
-Fixed version number in toolbar from hardcoded to be taken from variable
-Numerous improvements for applying settings in post/page editing view
= 7.1.7 =
-Selecting mode bug fixes
-Fixed pick an element button weird behaviour
-Added WP Super Cache support(fixes bug with changes not being shown)
= 7.1.8 =
-Now compatibility mode runs if no "on" detected
-fixed jCarousel conflict with other jCarousels
-fixed crashing on undefined jQuery.browser
= 7.1.9 =
-Fixed launching compatibility mode when jQuery completely overwritten
= 7.2.0 =
-Fixed conflicted function name
-Added activation tab
= 7.3.0 =
-Fixed sustainging values when changing preset
-Refreshed design to be more flat
-Minor tweaks here and there
-added current font preview
= 7.3.1 =
-Fixed startup error
= 7.4 =
-Fixed lack of zindex
-Added style presets
= 7.5 =
-Styles compacted
-Styles bar doesn't show too early
-Fixed bug with selection disappearing periodically
-Removed fading animations
-Added x button for easier preset removing
= 7.5.1 =
-Fixed PHP vulnerability

== Upgrade Notice ==
= 5.00 =
Completely redesigned! Fixes fonts list not loading bug and introduces many other changes and improvements.
= 5.1 =
UPDATE! Fixed bug related to not applied font changes. New visual indication for mouseover when selecting items. Related items are now also highlighted. Few other minor fixes.
= 5.11 =
Like on facebook
= 5.12 =
Quick bugfix to prevent ttf file not found error
= 5.13 =
Fixed saving on overly restrictive hostings
= 5.14 =
Important compatibility fix for new ajax handling file
= 5.15 =
Drag things and change their position
= 5.16 =
Fixed plugin crashing and no fonts' list displaying
= 5.17 =
Added 3D text feature
Click to select item
A few bugfixes
A few compatibility improvements
= 5.18 =
IE9 and 10 now displaying all fonts correctly. Added WOFF formats.
= 5.19 =
Fixed "PICK ELEMENT" fatal error, other minor improvements
= 5.20 =
No more silent crashes. Shows an error instead.
New Like/Dislike buttons and contact form.
= 5.21 =
Pick element much more precise
Cancel selecting mode button
Key entry of selector
= 5.22 =
Legacy wordpress compatibility 3.1 but not fully
3.3.1 full support
Small selecting tool tweaks
= 5.23 =
Added reset button
= 5.24 =
Disabled errors
= 5.25 =
Added version number when requesting js or css to make sure the latest files are downloaded. 
Browsers were serving cached old versions disregarding the update.
= 6.00 =
Moved main functions to thin top bar to reduce space usage
= 6.1 =
Compatibility fixes and errors on save shown instead of silent failure
= 6.11 =
Alerts when no selection made to give some guidance to the user
= 6.12 =
Added mime types htaccess for webfonts
= 6.13 =
Alert on api key error, and a new description. 
New rules in htaccess for compatibility.
= 6.14 =
Font files folder is now created by script not unpacked when installing.
= 6.15 =
Wordpress in subdirectory support added. This should fix saving problems on affected websites.
= 6.16 =
Fixed error of ajax error message
"Font settings" can be only seen by admin not by any editor anymore
"Save button" blinks after being clicked and becomes disabled what prevents from second clicking and losing settings
= 6.17 =
Removed facebook api support, like button was dropped long time ago
Fade-in on first run
= 6.18 =
Connection check and error message displayed when can't connect
= 7.0 =
The biggest update and bug fixes compilation for "Font" plugin ever!
= 7.1 =
Compatibility mode, which makes the plugin work even when some poorly written plugin is breaking jQuery
Minor bug fixes

-Completely new "effects" window with 3d text
-New design, during work bar moved on top of admin bar to save space
-warning when using an old browser which does not support effects and advanced options
-notice when using very old Wordpress version
-When the plugin is used for the very first time, only one button is shown to pick up an element and start the journey
-Prevention of accidently leaving the page before saving changes

Fixed:
	-warning instead of silent crash when file saving is disabled on user's server
	-deleting multiple presets is not causing problems any more
	-In selection mode when cancelling, a prompt window is not showing in a loop any more

-Lots of other improvements and bug fixes for better overall user experience

= 7.1.1 =
-Compatibility update for some restrictive hosting providers. 
	-Ajax calls only to built in ajax PHP script
	-TinyMCE editor styles stored in a CSS file instead of pointing to PHP which generates CSS
-htaccess file compatibility improved
= 7.1.2 =
-htaccess compatibility issue fix
-css compatibity improvements
= 7.1.3 =
-htaccess mod
= 7.1.4 =
-Compatibility update with 3 alternative Ajax proxies
= 7.1.5 =
-Support for the latest fonts browser. Now blocked for older versions.
-Like Yes/No button is back
= 7.1.6 =
-Fixed the problem with changes sometimes not being saved in post/page editing modes
-Fixed version number in toolbar from hardcoded to be taken from variable
-Numerous improvements for applying settings in post/page editing view
= 7.1.7 =
-Selecting mode bug fixes
-Fixed pick an element button weird behaviour
-Added WP Super Cache support(fixes bug with changes not being shown)
= 7.1.8 =
-Now compatibility mode runs if no "on" detected
-fixed jCarousel conflict with other jCarousels
-fixed crashing on undefined jQuery.browser
= 7.1.9 =
-Fixed launching compatibility mode when jQuery completely overwritten
= 7.2.0 =
-Fixed conflicted function name
-Added activation tab
= 7.3.0 =
-Fixed sustainging values when changing preset
-Refreshed design to be more flat
-Minor tweaks here and there
-added current font preview
= 7.3.1 =
-Fixed startup error
= 7.4 =
-Fixed lack of zindex
-Added style presets
= 7.5 =
-Styles compacted
-Styles bar doesn't show too early
-Fixed bug with selection disappearing periodically
-Removed fading animations
-Added x button for easier preset removing
= 7.5.1 =
-Fixed PHP vulnerability

== Arbitrary section ==
== Source ==
Here's a link to [FontsForWeb.com](http://FontsForWeb.com/ "Free webfonts ready to use on your page")