=== Font Customizer ===
Contributors: nikeo
Author URI: http://www.themesandco.com
Plugin URI: http://www.themesandco.com
Donate link: http://www.themesandco.com#footer
Tags: Google font, font, typography, WordPress customizer, WordPress, WordPress fonts
Requires at least: 3.4
Tested up to: 3.9.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Play with beautiful Google and web safe fonts, live from the WordPress Customizer.

== Description ==

**Make beautiful Google font combinations and apply awesome CSS3 effects to any WordPress themes.** Preview everything right from the WordPress customizer before publishing live. Cross browser compatible, fast and easy, the Font Customizer is the ultimate plugin for typography lovers.

=  Plugin Features =
All settings are done from the WordPress customizer in live preview [(screenshots here)](http://wordpress.org/plugins/font-customizer/screenshots/), which makes this plugin easy as breeze and a really enjoyable experience to use.

* **Compatible with any WordPress theme**
* **Cross Browser Compatible** (Tested in all major browsers)
* **Live preview is integrated into the WordPress Customizer with a beautiful user interface**
* Customize main body font, links, headings, blockquotes
* Select among 650 + Google and websafe fonts in live preview
* Apply 40+ CSS3 effect like 3D, shadows, emboss, outline, neons...
* Style CSS properties : color, hover color, font size, line height, font weight...
* Reset controls to default settings (one by one or all at once)

= Recommended Google fonts combinations =
The Font Customizer plugin allows you to easily combine fonts on your website. It is important to choose the right Google typography pairings for headings and paragraphs in order to catch your reader's attention.
Below, you'll find some well known examples of Google fonts that worked very well together.

* Lobster + Droid Sans [(more pairings)](http://www.google.com/fonts/specimen/Lobster#pairings)
* Bitter + Source Sans Pro [(more pairings)](http://www.google.com/fonts/specimen/Bitter#pairings)
* Dancing Script & EB Garamond [(more pairings)](https://www.google.com/fonts/specimen/Dancing+Script#pairings)
* Dosis + Open Sans [(more pairings)](https://www.google.com/fonts/specimen/Dosis#pairings)
* Fjalla One + Open Sans [(more pairings)](https://www.google.com/fonts/specimen/Fjalla+One#pairings)
* Lato + Grand [(more pairings)](https://www.google.com/fonts/specimen/Lato#pairings)
* Oswald + Droid [(more pairings)](https://www.google.com/fonts/specimen/Oswald#pairings)


= Performance =
The Font Customizer plugin has been developped with performance in mind. All stylesheets and scripts in front and back end are minified.
The generated stylesheets with the custom fonts settings are written in head section the following way :

1. The Google font families are requested very early in head to avoid any Flash of Unstyled Content (FOUC) in any browsers
2. The plugin uses the best recommended practices to optimize Google fonts load time in your webpages [(learn more about the Google Fonts API)](https://developers.google.com/fonts/docs/developer_api)
3. The CSS properties are loaded after your main stylesheet

To improve php performances, all settings, once saved in the customizer, are stored as database options (cached by WordPress when get_option is called) into the database : default settings, custom settings, Google fonts.


= Translations =
The plugin is [translation ready](http://codex.wordpress.org/Translating_WordPress), the default .mo and .po files are inluded in /lang.


= For Developers =
This plugin offers a **modular structure based on a comprehensive hook’s API** [(learn more about WordPress filters and actions)](http://codex.wordpress.org/Plugin_API) and it uses the **bests WordPress coding standards** which makes the Font Customizer **very easily extensible**, without ever needing to modify the core structure.


= Credits =

* [RequireJS](http://github.com/jrburke/requirejs) 2.1.14 by The Dojo Foundation, MIT or new BSD license
* [iCheck v1.0.1](http://git.io/arlzeA) by Damir Sultanov , MIT Licensed
* [Selecter v3.0.9](http://formstone.it/selecter/) by Formstone , MIT Licensed 
* [Stepper v3.0.5](http://formstone.it/stepper/) by Formstone , MIT Licensed


= Selection of font resources =

**General resources**

* [Choosing Types Principles](http://ilovetypography.com/2008/04/04/on-choosing-type/)
* [Four techniques for combining fonts](http://www.typography.com/email/2010_03/index_tw.htm)
* [8 tips Combining typefaces](http://www.adobe.com/inspire/2013/12/tips-typefaces.html)
* [Rules for beautiful typography](http://ilovetypography.com/2008/02/28/a-guide-to-web-typography/)
* [Principles for beautiful Typography](http://www.sitepoint.com/article/principles-beautiful-typography/)
* [The Noodle Incident’s CSS and Text](http://www.thenoodleincident.com/tutorials/css/index.html#text)
* [W3 Schools: CSS Fonts](http://www.w3schools.com/css/css_font.asp)
* [About.com’s Web Design (CSS): What is a Font](http://webdesign.about.com/cs/webdesignfonts/a/aa051903a.htm)
* [The Noodle Incident’s Tutorial on Typography](http://www.thenoodleincident.com/tutorials/typography/index.html)
* [HTMLHelp’s Font Properties](http://www.htmlhelp.com/reference/css/font/)
* [HTML Source: Text Formating](http://www.yourhtmlsource.com/text/textformattinglist.html)
* [University of Minnesota Creative Standards Guide: Text and Fonts](http://webdepot.umn.edu/csguide/design_b.html)
* [About.com’s Web Design: How Many Fonts are Too Many](http://desktoppub.about.com/library/nosearch/bl-fewerfonts.htm)
* [Thinking with Type](http://www.thinkingwithtype.com/)

**Font Size Resources**

* [W3c’s Care With Font Size](http://www.w3.org/2003/07/30-font-size)
* [CSS A List Apart: Size Matters](http://www.alistapart.com/stories/sizematters/)
* [BIG BAER Explains CSS Font-Size](http://www.bigbaer.com/css_tutorials/css_font_size.htm)
* [MIS: Using Relative Font Sizes](http://www.miswebdesign.com/resources/articles/using-relatve-font-sizes.html)
* [WebDevRes: CSS Font Size Control and Recommendations](http://www.wilk4.com/webdevres/fontcss3.htm)

**Font Troubleshooting**

* [Internet Explorer Font Sizing Bugs](http://css-discuss.incutio.com/?page=BrowserBugs)
* [Internet Explorer Font Size Inheritance](http://archivist.incutio.com/viewlist/css-discuss/33917)

== Installation ==

1. Install the plugin right from your WordPress admin in plugins > Add New
1-bis. Download the plugin, unzip the package and upload it to your /wp-content/plugins/ directory
2. Activate the plugin
3. Open the WordPress Customizer in Appearance > Customize
3-bis. Click on settings in admin > plugins, in the Font Customizer plugin links.
4. Click the Font Customizer section
4. Play with beautiful fonts!


== Screenshots ==

1. Font Customizer section opened in the WordPress Customizer
2. Details of the body font controls
3. Fonts picker
4. CSS3 effects picker
5. Integration with the Twenty Fourteen WordPress theme


== Changelog ==

= 1.0 : July 1, 2014 =
* First offical release!