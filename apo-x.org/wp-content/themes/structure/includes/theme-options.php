<?php
$settings = get_current_theme().'-options'; // do not change!

$defaults = array( // define our defaults
		'social_twitter' => 1,
		'social_facebook' => 1,
		'social_rss' => 1,
        'social_rss_url' => '/feed/rss/',
		'hp_top_cat' => 1,
		'hp_mid_cat' => 1,
		'hp_mid_num' => 3,
		'hp_top' => 1,
		'slider_num' => 5,
		'slider_cat' => 1,
		'slider_interval' => 5000,
		'hp_side_cat' => 1,
		'hp_side_num' => 3,
		'blog_cat' => 1,
		'blog_cat_num' => 5, 
		'portfolio1_cat' => 1,
		'portfolio1_num' => 6,
		'portfolio2_cat' => 1,
		'portfolio2_num' => 6,
		'portfolio3_cat' => 1,
		'portfolio3_num' => 9,
		'tracking' => '<!--tracking code goes here-->' // <-- no comma after the last option
);

//	push the defaults to the options database,
//	if options don't yet exist there.
add_option($settings, $defaults, '', 'yes');

//	this function registers our settings in the db
add_action('admin_init', 'register_theme_settings');
function register_theme_settings() {
	global $settings;
	register_setting($settings, $settings);
}
//	this function adds the settings page to the menu
add_action('admin_menu', 'add_theme_options_menu');
function add_theme_options_menu() {
	add_menu_page("Organic Themes", "Organic Themes", 'edit_themes', basename(__FILE__), 'theme_settings_admin', "http://www.organicthemes.com/optionsicon.ico");
}

function theme_settings_admin() { ?>
<?php theme_options_css_js(); ?>
<div class="wrap">
<?php
	// display the proper notification if Saved/Reset
	global $settings, $defaults;
	if(ot_option('reset')) {
		echo '<div class="updated fade" id="message"><p>Theme Options <strong>RESET TO DEFAULTS</strong></p></div>';
		update_option($settings, $defaults);
	} elseif($_REQUEST['updated'] == 'true') {
		echo '<div class="updated fade" id="message"><p>Theme Options <strong>SAVED</strong></p></div>';
	}
	// display icon next to page title
	screen_icon('options-general');
?>
	<h2><?php echo get_current_theme() . ' '; _e('Theme Options'); ?></h2>
	<form method="post" action="options.php">
	<?php settings_fields($settings); // important! ?>
	
	<!--left column-->
	<div class="metabox-holder mbleft">
        
        <div class="postbox">
        <h3>Social Links <small>(check to display/hide)</small></h3>
            <div class="inside">
                <p>Twitter:<br />
                <input type="checkbox" name="<?php echo $settings; ?>[social_twitter]" value="1" <?php checked(1, ot_option('social_twitter')); ?> /> <input type="text" name="<?php echo $settings; ?>[social_twitter_url]" value="<?php echo ot_option('social_twitter_url'); ?>" size="25" /> <small><em>(URL)</em></small></p>
                <p>Facebook:<br />
                <input type="checkbox" name="<?php echo $settings; ?>[social_facebook]" value="1" <?php checked(1, ot_option('social_facebook')); ?> /> <input type="text" name="<?php echo $settings; ?>[social_facebook_url]" value="<?php echo ot_option('social_facebook_url'); ?>" size="25" /> <small><em>(URL)</em></small></p>
                <p>RSS:<br />
                <input type="checkbox" name="<?php echo $settings; ?>[social_rss]" value="1" <?php checked(1, ot_option('social_rss')); ?> /> <input type="text" name="<?php echo $settings; ?>[social_rss_url]" value="<?php echo ot_option('social_rss_url'); ?>" size="25" /> <small><em>(URL)</em></small></p>
            </div>
        </div>
        
        <div class="postbox">
		<h3><?php _e("Blog Page Template", 'organicthemes'); ?></h3>
			<div class="inside">
				<p><?php _e("Select the <strong>category</strong> you want displayed on your Blog Template Page", 'organicthemes'); ?>:<br />
    			<?php wp_dropdown_categories(array('selected' => ot_option('blog_cat'), 'name' => $settings.'[blog_cat]', 'orderby' => 'Name' , 'hierarchical' => 1, 'show_option_all' => __("All Categories", 'organicthemes'), 'hide_empty' => '0' )); ?></p>
				
				<p><?php _e("Number of blog posts to show", 'organicthemes'); ?>:<br />
				<input type="text" name="<?php echo $settings; ?>[blog_cat_num]" value="<?php echo ot_option('blog_cat_num'); ?>" size="3" /></p>
			</div>
		</div>
        
        <div class="postbox">
		<h3><?php _e("Analytics Code", 'organicthemes'); ?></h3>
			<div class="inside">
				<p>If you use a service such as <a href="http://www.google.com/analytics/">Google Analytics</a> to track analytics on your site, paste the code below (it will be inserted into the footer):</p>
				<p>
				<textarea name="<?php echo $settings; ?>[tracking]" cols=30 rows=5><?php echo stripslashes(ot_option('tracking')); ?></textarea>
				</p>
			</div>
		</div>
        
	</div>
	<!--end left column-->
	
	<!--right column-->
    
	<div class="metabox-holder mbright">
        
		<div class="postbox">
            <h3><?php _e("Home Page Featured Text and Image", 'organicthemes'); ?></h3>
            <div class="inside">

                <p><?php _e("Select which category to display for the Home Page text banner and featured image. The Post Title will be displayed as the text banner.", 'organicthemes'); ?><br />
                <?php wp_dropdown_categories(array('selected' => ot_option('hp_top_cat'), 'name' => $settings.'[hp_top_cat]', 'orderby' => 'Name' , 'hierarchical' => 1, 'show_option_all' => __("All Categories", 'organicthemes'), 'hide_empty' => '0' )); ?></p>
                
            </div>
        </div>
        
        <div class="postbox">
            <h3><?php _e("Homepage Slider", 'organicthemes'); ?></h3>
            <div class="inside">
                
                <p><?php _e("Select the category you want displayed", 'organicthemes'); ?>:<br />
    			<?php wp_dropdown_categories(array('selected' => ot_option('slider_cat'), 'name' => $settings.'[slider_cat]', 'orderby' => 'Name' , 'hierarchical' => 1, 'show_option_all' => __("All Categories", 'organicthemes'), 'hide_empty' => '0' )); ?></p>
                
                <p><?php _e("Number of Slides to Show", 'organicthemes'); ?>:<br />
				<input type="text" name="<?php echo $settings; ?>[slider_num]" value="<?php echo ot_option('slider_num'); ?>" size="3" /></p>
                
                <p><?php _e("Select the interval for slide transistions (in seconds)", 'organicthemes'); ?><br />
                <select name="<?php echo $settings; ?>[slider_interval]">
                    <option style="padding-right:10px;" value="1000" <?php selected('1000', ot_option('slider_interval')); ?>><?php _e("1", 'organicthemes'); ?></option>
                    <option style="padding-right:10px;" value="2000" <?php selected('2000', ot_option('slider_interval')); ?>><?php _e("2", 'organicthemes'); ?></option>
                    <option style="padding-right:10px;" value="3000" <?php selected('3000', ot_option('slider_interval')); ?>><?php _e("3", 'organicthemes'); ?></option>
                    <option style="padding-right:10px;" value="4000" <?php selected('4000', ot_option('slider_interval')); ?>><?php _e("4", 'organicthemes'); ?></option>
                    <option style="padding-right:10px;" value="5000" <?php selected('5000', ot_option('slider_interval')); ?>><?php _e("5", 'organicthemes'); ?></option>
                    <option style="padding-right:10px;" value="6000" <?php selected('6000', ot_option('slider_interval')); ?>><?php _e("6", 'organicthemes'); ?></option>
                    <option style="padding-right:10px;" value="7000" <?php selected('7000', ot_option('slider_interval')); ?>><?php _e("7", 'organicthemes'); ?></option>
                    <option style="padding-right:10px;" value="8000" <?php selected('8000', ot_option('slider_interval')); ?>><?php _e("8", 'organicthemes'); ?></option>
                    <option style="padding-right:10px;" value="9000" <?php selected('9000', ot_option('slider_interval')); ?>><?php _e("9", 'organicthemes'); ?></option>
                    <option style="padding-right:10px;" value="10000" <?php selected('10000', ot_option('slider_interval')); ?>><?php _e("10", 'organicthemes'); ?></option>
                    <option style="padding-right:10px;" value="12000" <?php selected('12000', ot_option('slider_interval')); ?>><?php _e("12", 'organicthemes'); ?></option>
                    <option style="padding-right:10px;" value="14000" <?php selected('14000', ot_option('slider_interval')); ?>><?php _e("14", 'organicthemes'); ?></option>
                    <option style="padding-right:10px;" value="16000" <?php selected('16000', ot_option('slider_interval')); ?>><?php _e("16", 'organicthemes'); ?></option>
                    <option style="padding-right:10px;" value="18000" <?php selected('18000', ot_option('slider_interval')); ?>><?php _e("18", 'organicthemes'); ?></option>
                    <option style="padding-right:10px;" value="20000" <?php selected('20000', ot_option('slider_interval')); ?>><?php _e("20", 'organicthemes'); ?></option>
                    <option style="padding-right:10px;" value="60000" <?php selected('60000', ot_option('slider_interval')); ?>><?php _e("60", 'organicthemes'); ?></option>
                    <option style="padding-right:10px;" value="999999999" <?php selected('999999999', ot_option('slider_interval')); ?>><?php _e("Hold", 'organicthemes'); ?></option>
                </select></p>

            </div>
        </div>
        
        <div class="postbox">
            <h3><?php _e("Home Page Middle", 'organicthemes'); ?></h3>
            <div class="inside">

                <p><?php _e("Select the category you wish to display within the middle column of the Home Page.", 'organicthemes'); ?><br />
                <?php wp_dropdown_categories(array('selected' => ot_option('hp_mid_cat'), 'name' => $settings.'[hp_mid_cat]', 'orderby' => 'Name' , 'hierarchical' => 1, 'show_option_all' => __("All Categories", 'organicthemes'), 'hide_empty' => '0' )); ?></p>
                
                <p><?php _e("Number of Posts to Show", 'organicthemes'); ?>:<br />
				<input type="text" name="<?php echo $settings; ?>[hp_mid_num]" value="<?php echo ot_option('hp_mid_num'); ?>" size="3" /></p>
                
            </div>
        </div>

        <div class="postbox">
            <h3><?php _e("Homepage Left Side", 'organicthemes'); ?></h3>
            <div class="inside">

                <p><?php _e("Select which <strong>category</strong> to display on the <strong>left side</strong>:", 'organicthemes'); ?><br />
                <?php wp_dropdown_categories(array('selected' => ot_option('hp_side_cat'), 'name' => $settings.'[hp_side_cat]', 'orderby' => 'Name' , 'hierarchical' => 1, 'show_option_all' => __("All Categories", 'organicthemes'), 'hide_empty' => '0' )); ?></p>
                <p><?php _e("Number of Posts to Show", 'organicthemes'); ?>:<br />
				<input type="text" name="<?php echo $settings; ?>[hp_side_num]" value="<?php echo ot_option('hp_side_num'); ?>" size="3" /></p>

            </div>
        </div>
        
        <div class="postbox">
            <h3><?php _e("Portfolio Page Templates", 'organicthemes'); ?></h3>
            <div class="inside">

                <p><?php _e("Select the <strong>category</strong> you wish to display within the <strong>1 column</strong> Portfolio Template Page.", 'organicthemes'); ?><br />
                <?php wp_dropdown_categories(array('selected' => ot_option('portfolio1_cat'), 'name' => $settings.'[portfolio1_cat]', 'orderby' => 'Name' , 'hierarchical' => 1, 'show_option_all' => __("All Categories", 'organicthemes'), 'hide_empty' => '0' )); ?></p>
                
                <p><?php _e("Number of portfolio posts to show", 'organicthemes'); ?>:<br />
				<input type="text" name="<?php echo $settings; ?>[portfolio1_num]" value="<?php echo ot_option('portfolio1_num'); ?>" size="3" /></p>
                
                <p><?php _e("Select the <strong>category</strong> you wish to display within the <strong>2 column</strong> Portfolio Template Page.", 'organicthemes'); ?><br />
                <?php wp_dropdown_categories(array('selected' => ot_option('portfolio2_cat'), 'name' => $settings.'[portfolio2_cat]', 'orderby' => 'Name' , 'hierarchical' => 1, 'show_option_all' => __("All Categories", 'organicthemes'), 'hide_empty' => '0' )); ?></p>
                
                <p><?php _e("Number of portfolio posts to show", 'organicthemes'); ?>:<br />
				<input type="text" name="<?php echo $settings; ?>[portfolio2_num]" value="<?php echo ot_option('portfolio2_num'); ?>" size="3" /></p>
                
                <p><?php _e("Select the <strong>category</strong> you wish to display within the <strong>3 column</strong> Portfolio Template Page.", 'organicthemes'); ?><br />
                <?php wp_dropdown_categories(array('selected' => ot_option('portfolio3_cat'), 'name' => $settings.'[portfolio3_cat]', 'orderby' => 'Name' , 'hierarchical' => 1, 'show_option_all' => __("All Categories", 'organicthemes'), 'hide_empty' => '0' )); ?></p>
                
                <p><?php _e("Number of portfolio posts to show", 'organicthemes'); ?>:<br />
				<input type="text" name="<?php echo $settings; ?>[portfolio3_num]" value="<?php echo ot_option('portfolio3_num'); ?>" size="3" /></p>
                
            </div>
        </div>

		<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Settings', 'organicthemes') ?>" />
		<input type="submit" class="button-highlighted" name="<?php echo $settings; ?>[reset]" value="<?php _e('Reset Settings', 'organicthemes'); ?>" />
		</p>

	</div>
	<!--end right column-->
	
	</form>

</div><!--end .wrap-->
<?php }

// add CSS and JS if necessary
function theme_options_css_js() {
echo <<<CSS

<style type="text/css">
	.metabox-holder { 
		float: left;
		margin: 0; padding: 0 10px 0 0;
	}
	.metabox-holder { 
		float: left;
		margin: 0; padding: 0 10px 0 0;
	}
	.metabox-holder .postbox .inside {
		padding: 0 10px;
	}
	.mbleft {
		width: 300px;
	}
	.mbright {
		width: 480px;
	}
	.catchecklist,
	.pagechecklist {
		list-style-type: none;
		margin: 0; padding: 0 0 10px 0;
	}
	.catchecklist li,
	.pagechecklist li {
		margin: 0; padding: 0;
	}
	.catchecklist ul {
		margin: 0; padding: 0 0 0 15px;
	}
	select {
		margin-top: 5px;
	}
	input {
		margin-top: 5px;
	}
	input[type="checkbox"], input[type="radio"] {
		margin-top: 1px;
	}
</style>

CSS;

echo <<<JS

<script type="text/javascript">
jQuery(document).ready(function($) {
	$(".fade").fadeIn(1000).fadeTo(1000, 1).fadeOut(1000);
});
</script>

JS;
}
?>