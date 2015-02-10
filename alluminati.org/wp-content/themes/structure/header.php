<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="distribution" content="global" />
<meta name="robots" content="follow, all" />
<meta name="language" content="en" />
<meta name="verify-v1" content="7XvBEj6Tw9dyXjHST/9sgRGxGymxFdHIZsM6Ob/xo5E=" />

<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
<link rel="Shortcut Icon" href="<?php echo bloginfo('template_url'); ?>/images/favicon.ico" type="image/x-icon" />

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_enqueue_script("jquery"); ?>
<?php wp_head(); ?>

<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/superfish/superfish.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/superfish/hoverIntent.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.anythingslider.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/swfobject.js"></script>

<script type="text/javascript"> 
	var $j = jQuery.noConflict();
	$j(document).ready(function() { 
		$j('.menu').superfish(); 
	});
</script>

<script type="text/javascript">
	var $j = jQuery.noConflict();
	$j(function(){
		$j('#slider1').anythingSlider({
			width           : 620,
			height          : 440,
			delay           : <?php echo ot_option('slider_interval'); ?>,
			resumeDelay     : 10000,
			startStopped    : false,
			autoPlay        : true,
			autoPlayLocked  : false,
			easing          : "swing",
			onSlideComplete : function(slider){
				// alert('Welcome to Slide #' + slider.currentPage);
			}
		});
		$j(".feature_video").hover(function(){
		    $j('#slider1').data('AnythingSlider').startStop(false); // this stops the slideshow
		});
		$j(".arrow").click(function(){
		    $j('#slider1').data('AnythingSlider').startStop(true); // this starts the slideshow
		});
	});
</script>

<script type="text/javascript"> 
	var $j = jQuery.noConflict();
	$j(document).ready(function () {
		$j('#homeslider iframe').each(function() {
			var url = $j(this).attr("src")
			$j(this).attr("src",url+"&amp;wmode=Opaque")
		});
	});
</script>

</head>

<body <?php if(function_exists('body_class')) body_class(); ?>>

<div id="wrap">

    <div id="header">
    
        <div class="headerleft">
            <p id="title"><a href="<?php bloginfo('url'); ?>/" title="Home"><?php bloginfo('name'); ?></a></p>
        </div>
        
        <div class="headerright">
            <?php $search_text = "Search Here"; ?> 
            <form method="get" id="searchformheader" action="<?php bloginfo('home'); ?>/"> 
            <input type="text" value="<?php echo $search_text; ?>" name="s" id="searchbox" onblur="if (this.value == '') {this.value = '<?php echo $search_text; ?>';}"  
            onfocus="if (this.value == '<?php echo $search_text; ?>') {this.value = '';}" /> 
            <input type="hidden" id="searchsubmit" /> 
            </form>
            
            <div id="navicons">
            	<?php if(ot_option('social_rss') == 1) { ?><a href="<?php echo ot_option('social_rss_url'); ?>" target="_blank"><img class="navicon" src="<?php bloginfo('template_url'); ?>/images/rss_icon.png" title="RSS Feed" alt="RSS" /></a><?php } else { } ?>
            	<?php if(ot_option('social_facebook') == 1) { ?><a href="<?php echo ot_option('social_facebook_url'); ?>" target="_blank"><img class="navicon" src="<?php bloginfo('template_url'); ?>/images/facebook_icon.png" title="Facebook" alt="Facebook" /></a><?php } else { } ?>
                <?php if(ot_option('social_twitter') == 1) { ?><a href="<?php echo ot_option('social_twitter_url'); ?>" target="_blank"><img class="navicon" src="<?php bloginfo('template_url'); ?>/images/twitter_icon.png" title="Twitter" alt="Twitter" /></a><?php } else { } ?>
            </div>
            
        </div>
    
    </div>
    
    <div id="navbar">
		<?php if ( function_exists('wp_nav_menu') ) { // Check for 3.0+ menus
		wp_nav_menu( array( 'title_li' => '', 'depth' => 4, 'container_class' => 'menu' ) ); }
		else {?>
		<ul class="menu"><?php wp_list_pages('title_li=&depth=4'); ?></ul>
		<?php } ?>
    </div>
    
    <div style="clear:both;"></div>