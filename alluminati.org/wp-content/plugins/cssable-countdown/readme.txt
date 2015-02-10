=== CSSable Countdown ===
Contributors: dmonnier
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=SGK5F3QQASDXS
Tags: countdown, timer, CSS
Requires at least: 2.5
Tested up to: 3.9
Stable tag: 1.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A fully CSS-able jQuery countdown/countup timer available in both widget and shortcode.

== Description ==

A fully CSS-able jQuery countdown/countup timer available in both widget and shortcode.  Based on [jQuery Countdown](http://keith-wood.name/countdown.html "jQuery Countdown by Keith Wood") by Keith Wood.

Features:

* Supports multiple countdowns
* Available as both a widget and a shortcode
* Localization based on your WordPress's installation language
* Timer can be set to count down or count up
* You choose how much information to display from years to seconds
* Option to set expiration message
* Option to redirect to a new URL upon expiry

Most importantly, **YOU have full control over the CSS**!  Every single element can be targeted and manipulated any way you want.  Also works right out of the box with four pre-defined display styles if you don't care to fiddle with the CSS yourself.

== Installation ==

= Minimum Requirements =
Verify that you have the following minimum requirements:

1. WordPress 2.5+
1. PHP 5.1.3+
1. jQuery 2.0.0+

= Installing CSSable Countdown =

1. Upload `CSSable-countdown-widget` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= How do I use the widget? =

Go to `Appearances` > `Widgets` and drag the CSSable Countdown widget where you want it.  Expand the widget to fill out the particulars.

= How do I use the shortcode? =

The shortcode is much more involved than the point-and-click interface of the widget.

The shortcode's minimum syntax is:

`[countdown date="MM/DD/YYYY"]`

You can specify additional options:

* `time` - in `HH:MM:SS` format (make sure you use 24-hour time).  Defaults to `00:00:00`.
* `timezone` - in `±HH:MM` GMT format (e.g. EST is `-5`, India is `+5:30`, etc).  Defaults to your WordPress's GMT offset as defined in `Settings` > `General` > `Timezone`.
* `format` - valid options are any of *case-sensitive* `YOWDHMS`.  Defaults to `ydHMS`.  See [*] below for more information.
 * `Y` - years
 * `O` - months
 * `W` - weeks
 * `D` - days
 * `H` - hours
 * `M` - minutes
 * `S` - seconds
* `significant` - valid options are 1 through 7.  See [+] below for more information.
* `direction` - valid options are `down` and `up`.  Toggles countdown vs. countup timer.  Defaults to `down`.
* `event` - the event description.
* `display` - valid options are `default`, `list`, `text`, `compact`.  Defaults to `default`.  Controls the presentation and basic styling options.
* `expirytext` - plaintext string to display on time expired.

[*] `format` is the powerhouse that controls the digits displaying on the timer.  It is case-sensitive:

* Uppercase values will always display
* Lowercase values will display only if non-zero
* Unspecified values will never display

For example, the default value of `ydHMS` will show you years and days if they're non-zero, but hours, minutes, and seconds will always be shown.  If you didn't care about the time, you could show years, months, and days with just `YMD`.

[+] `significant` controls how many significant digits are displayed.  

Combining `format` with `significant` produces almost any combination of date and time values that you want displayed.

**Note**: you cannot set an expiration URL with the shortcode, since shortcodes are, by definition, parsed after headers are sent.

= I don't want your bare-bones CSS!  How can I disable it completely? =

In your `functions.php` file, add these lines:

`wp_dequeue_style( 'cssable-countdown-style-default' );
wp_dequeue_style( 'cssable-countdown-style-list' );
wp_dequeue_style( 'cssable-countdown-style-text' );`

= How do I add my own CSS? =

In your `functions.php` file, add these lines for every CSS file you're including:

`wp_enqueue_style( 'cssable-countdown-style-YOURNAMEHERE', 'PATH/TO/CUSTOM/CSS/FILE.css' , '', '1.1' );`

* Replace `YOURNAMEHERE` with a unique name so it won't conflict with any other stylesheets.
* Replace `PATH/TO/CUSTOM/CSS/FILE.css` with the path to your CSS file.  It is suggested that you put the CSS file in your themes directory and use WordPress's [`get_stylesheet_directory()`](http://codex.wordpress.org/Function_Reference/get_stylesheet_directory "Function Reference/get_stylesheet_directory()") for your theme instead of giving it an absolute URL.  Ex:

`wp_enqueue_style( 'cssable-countdown-style-YOURNAMEHERE', get_stylesheet_directory() . '/css/YOURCUSTOMFILE.css' , '', '1.1' );`

= What languages are supported? =

Although the admin panel is currently only localized in English, the countdown will automatically take the language you have your WordPress set to.

* Albanian (Gjuha shqipe)
* Arabic (العربية)
* Armenian (Հայերեն)
* Bengali/Bangla (বাংলা)
* Bosnian (Bosanski)
* Bulgarian (български език)
* Burmese (မြန်မာစာ)
* Catalan (Català)
* Chinese/Simplified (简体中文
* Chinese/Traditional (繁體中文)
* Croatian (Hrvatski jezik)
* Czech (Čeština)
* Danish (Dansk)
* Dutch (Nederlands)
* Estonian (eesti keel)
* Farsi/Persian (فارسی)
* Finnish (suomi)
* French (Français)
* Galician (Galego)
* German (Deutsch)
* Greek (Ελληνικά)
* Gujarati (ગુજરાતી)
* Hebrew (עברית
* Hungarian (Magyar)
* Indonesian (Bahasa Indonesia)
* Icelandic (Íslenska)
* Italian (Italiano)
* Japanese (日本語)
* Kannada ( ಕನ್ನಡ )
* Korean (한국어)
* Latvian (Latviešu Valoda)
* Lithuanian (lietuvių kalba)
* Malayalam (മലയാളം)
* Malaysian (Bahasa Melayu)
* Norwegian (Bokmål)
* Polish (Polski)
* Portuguese/Brazilian (Português)
* Romanian (Română)
* Russian (Русский)
* Serbian (српски језик)
* Serbian (srpski jezik)
* Slovak (Slovenčina)
* Slovenian (Slovenščina)
* Spanish (Español)
* Swedish (Svenska)
* Thai (ภาษาไทย)
* Turkish (Türkçe)
* Ukrainian (українська мова)
* Uzbek (O‘zbek tili)
* Vietnamese (Tiếng Việt)
* Welsh (Cymraeg)

== Screenshots ==

1. The complete plug-in with all sections collapsed.
2. The `Period Display` section where you can indicate which time periods you want shown.
3. The `Layout` section where you can apply four pre-defined styles if you're in a hurry.
4. The `Add Text` section where you can enter optional text to be shown with the countdown.
5. The `Expiration Options` section where you can add an expiry text *or* a redirect URL.
6. The `Change Timezone` section where you can change the target timezone for the countdown.
7. The `Advanced Formatting` section where you can enter a format manually and determine the significant options.  Details on use are provided in the readme.

== Changelog ==

= 1.5 =
* [SUPPORT BUGFIX] Fixed languages not applying correctly

= 1.4 =
* [SUPPORT BUGFIX] Fixed shortcode ignoring to the `time` parameter

= 1.3 =
* Fixed `media` property of the various `wp_enqueue_style()`s to default to `'all'` instead of `false`
* Upgraded "tested up to" tag to 3.8.1

= 1.2 =
* Updated SVN to point to the actual location of the js files
* [SUPPORT BUGFIX] Fixed non-responsive dropdowns in widget options due to misplaced JS file
* [SUPPORT BUGFIX] Fixed shortcode not working due to misplaced JS file

= 1.1 =
* Moved `kw-jquery.countdown-1.6.3.php` to `/js/`
* [SUPPORT BUGFIX] Removed anonymous function in `register_widgets()` because they require PHP 5.3+
* [SUPPORT BUGFIX] Fixed non-responsive dropdowns in widget options

= 1.0 =
* Renamed plugin to `CSSable Countdown`
* WordPress plugin directory release
* Added screenshots and title banner

= 0.6 =
* Added slash handling to `expiryText` and `event`

= 0.5 =
* Split the shortcode off to its own file
* Fixed `expiryText` not showing if countdown was already expired on page load
* Fixed all instances of `expiryURL` to `expiryUrl`
* Removed `expiryUrl` option from shortcode since can't redirect after headers have been sent

= 0.4 =
* Improved widget UI by creating sections
* Added basic formatting option
* Added layout type option
* Created timezone and converter functions
* Changed option `compact` to only print if `true`
* Cleaned up files into folders
* Requires PHP 5.1.3+
* Removed `showExpiryTextIfExpired` option

= 0.3 =
* Added localization capabilites
* Added `compact` option
* Fixed shortcode displaying blank date on default configuration
* Fixed shortcode lack of targeting ID when calling as widget [(source)](http://wordpress.stackexchange.com/questions/10917/the-widget-and-widgets-id "(Thread 'the_widget() and widget's ID' at StackExchange)")
* Fixed widget checkboxes not toggling correctly

= 0.2 =
* Added `expiryText` option
* Added `significant` option
* Created `showExpiryTextIfExpired` option

= 0.1 =
* Created plug-in
* Created shortcode capability
* Created widget capability
* Stripped down and reconfigured CSS for maximum styling ability

== Upgrade Notice ==

= 1.5 =
Earlier versions of the plugin will ignore language settings.  Please upgrade if you need a language other than English.

= 1.4 =
Earlier versions of the shortcode will ignore the `time` parameter.  Please upgrade if you use the shortcode.

= 1.3 =
Earlier versions will fail HTML5 validation due to malformed CSS link tag.

= 1.2 =
1.1 doesn't work due to me sucking at SVN.  Please upgrade to make the plugin work.

= 1.0 =
This version is the official release.

== Future Development ==
* Pre-built color schemes
* Upgrade to version 2.0.0
* Admin panel localization