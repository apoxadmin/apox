jQuery(document).ready(function($) {
    "use strict";

    $('.peony-section-slider .slide').each(function() {
        $(this).css({ 'min-height': $(window).height() });
    });
	
	// fixed header
    var adminbarHeight = function(){
		
		var stickyTop;
    if ($("body.admin-bar").length) {

        if ($(window).width() < 765) {
            stickyTop = 46;
        } else {
            stickyTop = 32;
        }
    } else {
        stickyTop = 0;
    }
	
	return stickyTop;
	
	}

	var h = 0;
	if($('.top-wrap').length)
		h += $('.top-wrap').outerHeight();
	if($('.page-title-bar').length)
		h += $('.page-title-bar').outerHeight();
	if($('footer').length)
		h += $('footer').outerHeight();
	$('.post-wrap').css({'min-height':($(window).height()-h-adminbarHeight())});
	
    /* sticky header */
    var peony_sticky_header = function() {
        var stickyHeight;
        stickyHeight = adminbarHeight();

        var scrollTop = $(window).scrollTop();
		
		//var show_after_scrolling = $('#header').height()+stickyHeight;
		var show_after_scrolling = $('#header').height()/2;
	
        if (scrollTop >= show_after_scrolling) {
			
					$('.fxd-header').css({ 'top': stickyHeight, 'position': 'fixed','visibility':'visible' });
            		$('#header').css({'visibility':'hidden'});
			
        } else {
					$('#header').css({'visibility':'visible'});
					$('.fxd-header').css({ 'position': 'absolute','visibility':'hidden' });
				
        }
    };
		
		$(window).scroll(function() {
			if ($('.fxd-header').length && peony_params.sticky_header == '1') {
            	peony_sticky_header();
			}
        });

    //string to slug
    var peony_string_to_slug = function(str) {
        str.trim();
        if (typeof str !== 'undefined' && str !== '') {

            str = str.replace(/^\s+|\s+$/g, '');
            str = str.toLowerCase();

            var from = "����?a����?������??����??������???��/_,:;";
            var to = "aaaaeaeeiiiioooouuuunc-------";
            for (var i = 0, l = from.length; i < l; i++) {
                str = str.split(from.charAt(i)).join(to.charAt(i));
            }

            str = str.replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');

        } else {
            str = '';
        }

        return str;
    };
    // page animation
    if ( (peony_params.side_nav.show === 'on' || peony_params.side_nav.show == '1') && $('.mpl-section').length ) {

        $('.scroll-to-top').hide();
        $('.mpl-full-page > p').remove();
        var anchors = [];
        var navTitle = [];
        var i = 0;

        $('section.mpl-section').each(function() {

             if ($(this).parents("section.mpl-section").length > 0) {
                $(this).removeClass("mpl-section");
            } else {

                var sectionID = $(this).attr('id');
				var osectionID = sectionID;
				
				if(!$(this).hasClass('mpl-section-slider'))
                var sectionTitle = $(this).find('h2.mpl-section-title').text();

                if (typeof sectionID !== 'undefined' && sectionID !== '') {
                    sectionID = peony_string_to_slug(sectionID);

                } else {

                    if (typeof sectionTitle !== 'undefined' && sectionTitle !== '') {
                        sectionTitle.trim();
                        sectionID = peony_string_to_slug(sectionTitle);

                    } else {
                        sectionTitle = '';
                    }

                }

                if (typeof sectionID === 'undefined' || sectionID === '')
                    sectionID = 'section-' + (i + 1);
				if (typeof osectionID === 'undefined' || osectionID === '')
				$(this).attr('id', sectionID);

                anchors[i] = sectionID;
                navTitle[i] = sectionTitle;
                i++;

            }

        });

        var navigation = false;

        if ( anchors !== null ) {
            navigation = true;
			var side_nav = '<div class="dotstyle dotstyle-'+peony_params.side_nav.style+'"><ul class="main-nav">';
			var current  = '';
			for( var i = 0; i<anchors.length; i++ ) {
				current  = ''
				if( i == 0 )
				current = 'class="current"';				
				side_nav += '<li '+current+'><a href="#'+anchors[i]+'">'+navTitle[i]+'</a></li>';
			};
			side_nav += '</ul></div>';
			$('body').append(side_nav);
			var side_nav_height  = $('.dotstyle').height();
			$('.dotstyle').css({'margin-top':-(side_nav_height/2)+'px'});
			
        }

    }


    $(".slider-carousel").owlCarousel({
        items: 1,
    });

    $(".peony-gallery-carousel").owlCarousel({
        items: 4,

    });

    $(".peony-blog-carousel").owlCarousel({
        items: peony_params.blog_carousel_col,

    });

    $(document).on("click", ".site-nav-toggle", function() {
        $(".site-nav").animate({ right: "0" });
        $(this).hide();
    });
    $(document).on("click", ".site-nav .close", function() {
        $(".site-nav").animate({ right: "-300px" });
        $(".site-nav-toggle").show();
    });
    $(document).on("click", ".site-nav li.parent a", function() {
        $(this).closest("li").children("ul").slideToggle();
    });

    $('.site-nav > ul').find('li.menu-item-has-children').addClass('parent');
    $('.site-nav > ul li').find('ul.sub-menu').addClass('sub');

    //prettyPhoto
    $("a[rel^='prettyPhoto']").prettyPhoto();
    // gallery lightbox
    $(".gallery .gallery-item a").prettyPhoto({ animation_speed: 'fast', slideshow: 10000, hideflash: true });
    // tool tip
    $('[data-toggle="tooltip"]').tooltip();

    // back to top button
    $('.scroll-to-top').click(function() {

        var peony_main = $('#peony-home-sections #peony-main');
        var previousDestTop = 0;
        var $window = $(window);
        var windowsHeight = $window.height();

        if (peony_main.length) {
            var elemPosition = peony_main.position();

            var position = elemPosition.top;
            var isScrollingDown = elemPosition.top > previousDestTop;
            var sectionBottom = position - windowsHeight + peony_main.outerHeight();

            if (peony_main.outerHeight() > windowsHeight) {
                if (!isScrollingDown) {
                    position = sectionBottom;
                }
            } else if (isScrollingDown || (isResizing && peony_main.is(':last-child'))) {
                position = sectionBottom;
            }

           /* var translate3d = 'translate3d(0px, -' + position + 'px, 0px)';
            peony_main.css({
                '-webkit-transform': translate3d,
                '-moz-transform': translate3d,
                '-ms-transform': translate3d,
                'transform': translate3d
            });*/
        }

        $('html, body').animate({ scrollTop: 0 }, 1000);
        return false;
    });

    // side menu
    $('.site-nav > ul').find('li.menu-item-has-children').addClass('parent');
    $('.site-nav ul li.menu-item-has-children > a').after('<span class="menu-item-toggle"></span>');
    $('.site-nav > ul li').find('ul.sub-menu').addClass('sub');

    $(document).on('click', 'span.menu-item-toggle', function(e) {
        $(this).next('.sub-menu').slideToggle('fast');
    });

    // one page menu
    $(document).on('click', "nav a[href^='#'],.mpl-main-nav a[href^='#'],.dotstyle a[href^='#'],a.scroll", function(e) {

            var stickyHeight;
            stickyHeight = adminbarHeight();

            var selectorHeight = 0;
            if ($('.fxd-header').length)
                selectorHeight = $('.fxd-header').outerHeight();

            var scrollTop = $(window).scrollTop();
            e.preventDefault();
            var id = $(this).attr('href');
            if (typeof $(id).offset() !== 'undefined') {

                var goTo = $(id).offset().top - selectorHeight - stickyHeight + 1;
                $("html, body").animate({ scrollTop: goTo }, 500);
            }
     
    });

    // change navigation active class as the page is scrolling

    var topMenu = $(".main-nav"),
        topMenuHeight = topMenu.outerHeight() + 100,
        // All list items
        menuItems = topMenu.find("a[href^='#']"),
        // Anchors corresponding to menu items
        scrollItems = menuItems.map(function() {
            var item = $($(this).attr("href"));
            if (item.length) { return item; }
        });

    // Bind to scroll
    $(window).scroll(function() {

        // Get container scroll position
        var fromTop = $(this).scrollTop() + topMenuHeight;

        // Get id of current scroll item
        var cur = scrollItems.map(function() {
            if ($(this).offset().top < fromTop)
                return this;
        });
        // Get the id of the current element
        cur = cur[cur.length - 1];
        var id = cur && cur.length ? cur[0].id : "";

        // Set/remove active class
        if (id !== '') {
            menuItems
                .parent().removeClass("active current")
                .end().filter("[href='#" + id + "']").parent().addClass("active current");
        } else {
            menuItems.parent().removeClass("active current");
        }
		
		if ($(document).scrollTop() >= $(document).height() - $(window).height()) {
		menuItems.parent().removeClass("active current");
		menuItems.find(">li:last a[href^='#']").parent('li').addClass("active current");
		
    }
    });

    //woocommerce
    $(document).on('click', '.peony-quantity .minus', function() {
        var qtyWrap = $(this).parent('.quantity');
        var quantity = parseInt(qtyWrap.find('.qty').val(), 10);
        var min_num = parseInt(qtyWrap.find('.qty').attr('min'), 10);
        var max_num = parseInt(qtyWrap.find('.qty').attr('max'), 10);
        var step = parseInt(qtyWrap.find('.qty').attr('step'), 10);
        $('input[name="update_cart"]').removeAttr("disabled");

        if (quantity > min_num) {
            quantity = quantity - step;
            if (quantity > 0)
                qtyWrap.find('.qty').val(quantity);
        }
    });

    $(document).on('click', '.peony-quantity .plus', function() {
        var qtyWrap = $(this).parent('.quantity');
        var quantity = parseInt(qtyWrap.find('.qty').val(), 10);
        var min_num = parseInt(qtyWrap.find('.qty').attr('min'), 10);
        var max_num = parseInt(qtyWrap.find('.qty').attr('max'), 10);
        var step = parseInt(qtyWrap.find('.qty').attr('step'), 10);

        $('input[name="update_cart"]').removeAttr("disabled");

        if (max_num) {
            if (quantity < max_num) {
                quantity = quantity + step;
                qtyWrap.find('.qty').val(quantity);
            }
        } else {
            quantity = quantity + step;
            qtyWrap.find('.qty').val(quantity);
        }
    });
	
	var scrollifyCall = function(){
		
		var stickyHeight;
		var fullheight = $(window).height();
		stickyHeight = adminbarHeight();
		
		
		$('body').css({'margin-top':stickyHeight-1});

/*		$('.mpl-section').each(function(){
								
			});
		
		$(".mpl-fullheight").each(function () {
               $(this).css('height', fullheight-stickyHeight);
				$(this).parents('.mpl-carousel').css('height', fullheight-stickyHeight);
				
            });
		*/
		}
	
	if( $('.peony-fullscreen').length ){
	
	$("html").css("cssText", "margin-top:auto !important;"); 
	$(function() {
		$.scrollify({
			section:".mpl-section",
			sectionName:false,
			//scrollSpeed: 800,
			interstitialSection:"footer",
			afterResize:function(){
				scrollifyCall();
				},
			afterRender:function(){
				scrollifyCall();
				$('body').attr('data-preIndex',0);
				},
			after:function(index){
				$(".mpl-section").removeClass('active');
				$(".mpl-section").removeClass("from-next from-prev");
				$(".mpl-section").eq(index).addClass('active');
				},
			before:function(index){
				var direction,preIndex;
	            preIndex = parseInt($('body').attr('data-preIndex'));
				if (typeof preIndex === 'undefined' || index>preIndex){
					direction = "down";
					}else{
					direction = "up";
			}
			
			$('body').attr('data-preIndex',index);
	
			 var th = $(".mpl-section").eq(index);
				 
			  if (direction == "down")
			  {
				$(th).prev().addClass("from-next");
			  }
			  else if (direction == "up") {
				  $(th).next().addClass("from-prev");
			  }
				},
				
		});
	});
		
	}
	
	
});