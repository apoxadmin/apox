<?php
ini_set( "display_errors", 0);

include_once($_SERVER['DOCUMENT_ROOT'] . '/include/database.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/include/constants.inc.php');
db_open();
include_once($_SERVER['DOCUMENT_ROOT'] . '/include/session.inc.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<script src="/script/bootstrap.min.js"></script>
<script type="text/javascript"></script>
<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
<?php if ( !is_user_logged_in() ){ ?>
 <style>
  #wpadminbar{ display:none; }
</style>
<header>
<nav id='cssmenu'>
<div id="head-mobile"></div>
<div class="button"></div>
<ul>
<?php
  // menu swap
  if($_SESSION['class'] == 'admin') { 
     wp_nav_menu( array(
		 'menu_class'        => 'nav',
		 'menu' => 'Excomm' , 
		 'theme_location' => 'primary',
		 'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
		 'walker' => new wp_bootstrap_navwalker(),
		 'depth' => 2
	 ) );
  }
  elseif(isset($_SESSION['id'])) {
   // if they are logged in
   wp_nav_menu( array( 
	   'menu_class'        => 'nav',
	   'menu' => 'Logged_In' , 
	   'theme_location' => 'primary',
	   'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
	   'walker' => new wp_bootstrap_navwalker(),
	   'depth' => 2
   ) );
  } 
  else {
   // they are not logged in
   wp_nav_menu( array(
		'menu_class'        => 'nav', 
	    'theme_location' => 'primary' ,
	    //'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
		//'walker' => new wp_bootstrap_navwalker(),
		'depth' => 2
   ) );
  }
?>
	</ul></nav></header>		 <?php } ?>
<?php wp_head(); ?>
</head>
			<script>
(function($) {
$.fn.menumaker = function(options) {  
 var cssmenu = $(this), settings = $.extend({
   format: "dropdown",
   sticky: false
 }, options);
 return this.each(function() {
   $(this).find(".button").on('click', function(){
     $(this).toggleClass('menu-opened');
     var mainmenu = $(this).next('ul');
     if (mainmenu.hasClass('open')) { 
       mainmenu.slideToggle().removeClass('open');
     }
     else {
       mainmenu.slideToggle().addClass('open');
       if (settings.format === "dropdown") {
         mainmenu.find('ul').show();
       }
     }
   });
   cssmenu.find('li ul').parent().addClass('has-sub');
multiTg = function() {
     cssmenu.find(".has-sub").prepend('<span class="submenu-button"></span>');
     cssmenu.find('.submenu-button').on('click', function() {
       $(this).toggleClass('submenu-opened');
       if ($(this).siblings('ul').hasClass('open')) {
         $(this).siblings('ul').removeClass('open').slideToggle();
       }
       else {
         $(this).siblings('ul').addClass('open').slideToggle();
       }
     });
   };
   if (settings.format === 'multitoggle') multiTg();
   else cssmenu.addClass('dropdown');
   if (settings.sticky === true) cssmenu.css('position', 'fixed');
resizeFix = function() {
  var mediasize = 760;
     if ($( window ).width() > mediasize) {
       cssmenu.find('ul').show();
     }
     if ($(window).width() <= mediasize) {
       cssmenu.find('ul').hide().removeClass('open');
     }
   };
   resizeFix();
   return $(window).on('resize', resizeFix);
 });
  };
})(jQuery);

(function($){
$(document).ready(function(){
$("#cssmenu").menumaker({
   format: "multitoggle"
});
});
})(jQuery);
/*http://callmenick.com/post/expanding-search-bar-using-css-transitions*/
(function($) {
    "use strict";
  
    var $navbar = $(".nav"),
        y_pos = $navbar.offset().top,
        height = $navbar.height();

    //scroll top 0 sticky
    $(document).scroll(function() {
        var scrollTop = $(this).scrollTop();
        if (scrollTop > 0) {
          $navbar.addClass("sticky");
        } else {
          $navbar.removeClass("sticky");  
        }
    });
    
    //section sticky
    /*$(document).scroll(function() {
        var scrollTop = $(this).scrollTop();
        if ($(window).height() > scrollTop) {
          $navbar.removeClass("sticky");
        } else {
          $navbar.addClass("sticky");  
        }
    });*/

})(jQuery, undefined);

$(".menu").click(function(){
  $("#nav").toggleClass("open");
});

	</script>
<!-- cy -->
	<body>
<div id="container" class="container" >
