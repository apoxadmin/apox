/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
		wp.customize( 'header_bg_color', function( value ) {
		value.bind( function( to ) {
			$( 'header#masthead' ).css( {
				'background-color':to
			});
		} );
	} );
		wp.customize( 'header_title_color', function( value ) {
		value.bind( function( to ) {
			$( '.site-title' ).css( {
				'color':to
			});
		} );
	} );
		wp.customize( 'header_tagline_color', function( value ) {
		value.bind( function( to ) {
			$( 'p.site-description' ).css( {
				'color':to
			});
		} );
	} );
		wp.customize( 'header_button_divider_color', function( value ) {
		value.bind( function( to ) {
			$( '.button-divider' ).css( {
				'background-color':to
			});
		} );
	} );
		wp.customize( 'header_button_color', function( value ) {
		value.bind( function( to ) {
			$( '.header-button' ).css( {
				'border-color':to
			});
		} );
	} );
		wp.customize( 'header_button_color', function( value ) {
		value.bind( function( to ) {
			$( '.header-button' ).css( {
				'color':to
			});
		} );
	} );
		wp.customize( 'navigation_background_color', function( value ) {
		value.bind( function( to ) {
			$( '#site-navigation .menu li, #site-navigation .menu .sub-menu, #site-navigation .menu .children, nav#site-navigation' ).css( {
				'background':to
			});
		} );
	} );
		wp.customize( 'navigation_link_color', function( value ) {
		value.bind( function( to ) {
			$( 'div#top-search a, div#top-search a:hover, div#top-search a, div#top-search a:hover, #site-navigation .menu li a, #site-navigation .menu li a:hover, #site-navigation .menu li a:active, #site-navigation .menu > li.menu-item-has-children > a:after, #site-navigation ul.menu ul a, #site-navigation .menu ul ul a, #site-navigation ul.menu ul a:hover, #site-navigation .menu ul ul a:hover' ).css( {
				'color':to
			});
		} );
	} );
		wp.customize( 'navigation_link_color', function( value ) {
		value.bind( function( to ) {
			$( '.m_menu_icon' ).css( {
				'background-color':to
			});
		} );
	} );
		wp.customize( 'navigation_social_link_color', function( value ) {
		value.bind( function( to ) {
			$( '#top-social a, #top-social a:hover, #top-social a:active, #top-social a:focus, #top-social a:visited' ).css( {
				'color':to
			});
		} );
	} );
		wp.customize( 'topwidgets_headline_color', function( value ) {
		value.bind( function( to ) {
			$( '.top-widgets h1, .top-widgets h2, .top-widgets h3, .top-widgets h4, .top-widgets h5, .top-widgets h6' ).css( {
				'color':to
			});
		} );
	} );
		wp.customize( 'topwidgets_text_color', function( value ) {
		value.bind( function( to ) {
			$( '.top-widgets p, .top-widgets, .top-widgets li, .top-widgets ol, .top-widgets cite' ).css( {
				'color':to
			});
		} );
	} );
		wp.customize( 'topwidgets_link_color', function( value ) {
		value.bind( function( to ) {
			$( '.top-widgets ul li a, .top-widgets a, .top-widgets a:hover, .top-widgets a:visited, .top-widgets a:focus, .top-widgets a:active, .top-widgets ol li a, .top-widgets li a, .top-widgets .menu li a, .top-widgets .menu li a:hover, .top-widgets .menu li a:active, .top-widgets .menu li a:focus' ).css( {
				'color':to
			});
		} );
	} );
		wp.customize( 'blogpage_category_color', function( value ) {
		value.bind( function( to ) {
			$( '.blog .entry-cate a' ).css( {
				'color':to
			});
		} );
	} );
		wp.customize( 'blogpage_headline_color', function( value ) {
		value.bind( function( to ) {
			$( '.blog h2.entry-title a' ).css( {
				'color':to
			});
		} );
	} );
		wp.customize( 'blogpage_date_color', function( value ) {
		value.bind( function( to ) {
			$( '.blog time.entry-date' ).css( {
				'color':to
			});
		} );
	} );
		wp.customize( 'blogpage_text_color', function( value ) {
		value.bind( function( to ) {
			$( '.blog .nav-next a:before, .blog .nav-previous a:before, .blog .posts-navigation a, .blog .entry-content, .blog .entry-content p' ).css( {
				'color':to
			});
		} );
	} );

		wp.customize( 'blogpage_border_color', function( value ) {
		value.bind( function( to ) {
			$( '.blog #primary article.post' ).css( {
				'border-color':to
			});
		} );
	} );
		wp.customize( 'postpage_date', function( value ) {
		value.bind( function( to ) {
			$( '.single-post .comment-metadata time, .page .comment-metadata time, .single-post time.entry-date.published, .page time.entry-date.published, .single-post .posted-on a, .page .posted-on a' ).css( {
				'color':to
			});
		} );
	} );
		wp.customize( 'postpage_headline', function( value ) {
		value.bind( function( to ) {
			$( '.single-post #main th, .page #main th, .single-post .entry-cate a h2.entry-title, .single-post h1.entry-title, .page h2.entry-title, .page h1.entry-title, .single-post #main h1, .single-post #main h2, .single-post #main h3, .single-post #main h4, .single-post #main h5, .single-post #main h6, .page #main h1, .page #main h2, .page #main h3, .page #main h4, .page #main h5, .page #main h6' ).css( {
				'color':to
			});
		} );
	} );
		wp.customize( 'postpage_headline', function( value ) {
		value.bind( function( to ) {
			$( '.comments-title:after' ).css( {
				'background':to
			});
		} );
	} );
		wp.customize( 'postpage_link', function( value ) {
		value.bind( function( to ) {
			$( '.post #main .nav-next a:before, .single-post #main .nav-previous a:before, .page #main .nav-previous a:before, .single-post #main .nav-next a:before, .single-post #main a, .page #main a' ).css( {
				'color':to
			});
		} );
	} );
		wp.customize( 'postpage_text', function( value ) {
		value.bind( function( to ) {
			$( '.page #main, .page #main p, .page #main th,.page .comment-form label, .single-post #main, .single-post #main p, .single-post #main th,.single-post .comment-form label' ).css( {
				'color':to
			});
		} );
	} );

		wp.customize( 'postpage_category', function( value ) {
		value.bind( function( to ) {
			$( '.single-post #main .entry-cate a, .page #main .entry-cate a' ).css( {
				'color':to
			});
		} );
	} );
		wp.customize( 'postpage_border', function( value ) {
		value.bind( function( to ) {
			$( '.single-post .comment-content, .page .comment-content, .single-post .navigation.post-navigation, .page .navigation.post-navigation, .single-post #main td, .page #main td,  .single-post #main th, .page #main th, .page #main input[type="url"], .single-post #main input[type="url"],.page #main input[type="text"], .single-post #main input[type="text"],.page #main input[type="email"], .single-post #main input[type="email"], .page #main textarea, .single-post textarea' ).css( {
				'border-color':to
			});
		} );
	} );
		wp.customize( 'topwidgets_border_color', function( value ) {
		value.bind( function( to ) {
			$( '.top-widget-wrapper' ).css( {
				'border-color':to
			});
		} );
	} );
		wp.customize( 'footer_background', function( value ) {
		value.bind( function( to ) {
			$( '.footer-widgets-wrapper' ).css( {
				'background':to
			});
		} );
	} );
		wp.customize( 'footer_headline', function( value ) {
		value.bind( function( to ) {
			$( '.footer-widgets-wrapper h1, .footer-widgets-wrapper h2, .footer-widgets-wrapper h3, .footer-widgets-wrapper h4, .footer-widgets-wrapper h5, .footer-widgets-wrapper h6' ).css( {
				'color':to
			});
		} );
	} );
		wp.customize( 'footer_text', function( value ) {
		value.bind( function( to ) {
			$( '.footer-widget-single, .footer-widget-single p, .footer-widgets-wrapper p, .footer-widgets-wrapper' ).css( {
				'color':to
			});
		} );
	} );
		wp.customize( 'footer_link', function( value ) {
		value.bind( function( to ) {
			$( '.footer-widgets-wrapper  ul li a, .footer-widgets-wrapper li a,.footer-widgets-wrapper a,.footer-widgets-wrapper a:hover,.footer-widgets-wrapper a:active,.footer-widgets-wrapper a:focus, .footer-widget-single a, .footer-widget-single a:hover, .footer-widget-single a:active' ).css( {
				'color':to
			});
		} );
	} );
		wp.customize( 'footer_border', function( value ) {
		value.bind( function( to ) {
			$( '.footer-widget-single h3, .footer-widgets .search-form input.search-field' ).css( {
				'border-color':to
			});
		} );
	} );
		wp.customize( 'footer_copyright_background', function( value ) {
		value.bind( function( to ) {
			$( 'footer .site-info' ).css( {
				'background':to
			});
		} );
	} );

		wp.customize( 'footer_copyright_text', function( value ) {
		value.bind( function( to ) {
			$( 'footer .site-info' ).css( {
				'color':to
			});
		} );
	} );

		wp.customize( 'blogpage_button_color', function( value ) {
		value.bind( function( to ) {
			$( '.blog .entry-more a, .blog .entry-more a:hover' ).css( {
				'background':to
			});
		} );
	} );
		wp.customize( 'blogpage_button_color', function( value ) {
		value.bind( function( to ) {
			$( '.blog .entry-more a:hover' ).css( {
				'background':to
			});
		} );
	} );
		wp.customize( 'postpage_button', function( value ) {
		value.bind( function( to ) {
			$( '.page .comment-form input.submit, .single-post .comment-form input.submit,.single-post .comment-form input.submit:hover, .page .comment-form input.submit:hover' ).css( {
				'background':to
			});
		} );
	} );
		wp.customize( 'mobile_site_name_color', function( value ) {
		value.bind( function( to ) {
			$( '.mobile-site-name a' ).css( {
				'color':to
			});
		} );
	} );
		wp.customize( 'top_widgets_title_color', function( value ) {
		value.bind( function( to ) {
			$( '.top-widgets-wrapper h3' ).css( {
				'color':to
			});
		} );
	} );
		wp.customize( 'top_widgets_text_color', function( value ) {
		value.bind( function( to ) {
			$( '.top-widgets-wrapper p, .top-widgets-wrapper, .top-widgets-wrapper .textwidget, .top-widgets-wrapper li' ).css( {
				'color':to
			});
		} );
	} );

		wp.customize( 'top_widgets_link_color', function( value ) {
		value.bind( function( to ) {
			$( '.top-widgets-wrapper a, .top-widgets-wrapper .menu li a' ).css( {
				'color':to
			});
		} );
	} );


} )( jQuery );

