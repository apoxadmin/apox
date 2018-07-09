/**
 * Main scripts file
 *
 * @package Hestia
 */

/* global jQuery */
/* global Hammer */

jQuery( document ).ready(
	function ($) {

		$.material.init();

		var window_width = $( window ).width();

		// Activate the Tooltips
		$( '[data-toggle="tooltip"], [rel="tooltip"]' ).tooltip();

		// Activate bootstrap-select
		$( '.select' ).dropdown(
			{
				'dropdownClass': 'dropdown-menu',
				'optionClass': ''
			}
		);

		// Active Carousel
		if ( $( 'body.rtl' ).length === 0 ) {
			$( '.carousel' ).carousel(
				{
					interval: 10000
				}
			);
			// RTL
		} else {
			$( '.carousel' ).carousel(
				{
					interval: 10000
				}
			);
			$( '.carousel-control.left' ).click(
				function(){
					$( '.carousel' ).carousel( 'next' );
				}
			);
			$( '.carousel-control.right' ).click(
				function(){
					$( '.carousel' ).carousel( 'prev' );
				}
			);
		}

		if (typeof Hammer !== 'undefined') {
			var hammerLeft = 'swipeleft',
			hammerRight    = 'swiperight';
			// RTL
			if ( $( 'body.rtl' ).length !== 0 ) {
				hammerLeft  = 'swiperight';
				hammerRight = 'swipeleft';
			}

			// Add swipe support on carousel
			if ( $( '#carousel-hestia-generic' ).length !== 0 ) {
				var hestiaCarousel = document.getElementById( 'carousel-hestia-generic' );
				Hammer( hestiaCarousel ).on(
					hammerLeft, function () {
						$( '.carousel' ).carousel( 'next' );
					}
				);
				Hammer( hestiaCarousel ).on(
					hammerRight, function () {
						$( '.carousel' ).carousel( 'prev' );
					}
				);
			}
		}
		var transparent = true;

		if ($( '.navbar-color-on-scroll' ).length !== 0) {

			var navbarHome   = $( '.navbar-color-on-scroll' ),
			headerWithTopbar = 0;

			if ( navbarHome.hasClass( 'header-with-topbar' ) ) {
				headerWithTopbar = 40;
			}

			$( window ).on(
				'scroll', debounce(
					function () {
						if ($( document ).scrollTop() > headerWithTopbar) {
							if (transparent) {
								transparent = false;
								navbarHome.removeClass( 'navbar-transparent' );
								navbarHome.addClass( 'navbar-not-transparent' );
							}
						} else {
							if ( ! transparent) {
								transparent = true;
								navbarHome.addClass( 'navbar-transparent' );
								navbarHome.removeClass( 'navbar-not-transparent' );
							}
						}
					}, 17
				)
			);
		}

		// Check if header has topbar and add extra class
		var navbar        = $( '.navbar' ),
		navbarScrollPoint = 0;

		function checkNavbarScrollPoint() {
			if ( $( '.navbar-header' ).length !== 0 ) {

				// Window width bigger or equal with 768px
				if (getWidth() >= 768) {
					if (typeof $( '.navbar-header' ).offset() !== 'undefined') {
						navbarScrollPoint = $( '.navbar-header' ).offset().top + $( '.navbar-header' ).height(); // Distance from top to the bottom of the logo
					}

					// Check if topbar is active when navbar is left aligned
					if ( $( '.hestia_left.header-with-topbar' ).length !== 0 || $( '.full-screen-menu.header-with-topbar' ).length !== 0 ) {
						navbarScrollPoint = 40;
					}

					// Window width less than 768px
				} else {
					// Check if topbar is active
					if ($( '.header-with-topbar' ).length !== 0) {
						navbarScrollPoint = 40; // Topbar height
						// Topbar disabled
					} else {
						navbarScrollPoint = 0;
					}
				}
			}
		}
		checkNavbarScrollPoint();

		// On screen resize recalculate navbarScrollPoint
		$( window ).resize(
			function () {
				checkNavbarScrollPoint();
			}
		);

		// On screen scroll add scroll-related class
		$( window ).on(
			'scroll', function () {
				if ($( document ).scrollTop() >= navbarScrollPoint) {
					navbar.addClass( 'navbar-scroll-point' );
				} else {
					navbar.removeClass( 'navbar-scroll-point' );
				}
			}
		);

		if (window_width >= 768) {
			var big_image = $( '.header-filter[data-parallax="active"]' );
			if (big_image.length !== 0) {
				$( window ).on(
					'scroll', debounce(
						function () {
							if (isElementInViewport( big_image )) {
								var oVal = ($( window ).scrollTop() / 3);
								big_image.css(
									{
										'transform': 'translate3d(0,' + oVal + 'px,0)',
										'-webkit-transform': 'translate3d(0,' + oVal + 'px,0)',
										'-ms-transform': 'translate3d(0,' + oVal + 'px,0)',
										'-o-transform': 'translate3d(0,' + oVal + 'px,0)'
									}
								);
							}
						}, 4
					)
				);
			}
		}

		function debounce(func, wait, immediate) {
			var timeout;
			return function () {
				var context = this,
				args        = arguments;
				clearTimeout( timeout );
				timeout = setTimeout(
					function () {
						timeout = null;
						if ( ! immediate) {
							func.apply( context, args );
						}
					}, wait
				);
				if (immediate && ! timeout) {
					func.apply( context, args );
				}
			};
		}

		function isElementInViewport(elem) {
			var $elem = $( elem );

			// Get the scroll position of the page.
			var viewportTop    = $( window ).scrollTop();
			var viewportBottom = viewportTop + $( window ).height();

			// Get the position of the element on the page.
			var elemTop    = Math.round( $elem.offset().top );
			var elemBottom = elemTop + $elem.height();

			return ((elemTop < viewportBottom) && (elemBottom > viewportTop));
		}

		/* Smooth Scroll */
		var verifiedNavHeight;
		verifiedNavHeight = verifyNavHeight();

		// Verify again on resize
		$( window ).resize(
			function () {
				verifiedNavHeight = verifyNavHeight();
			}
		);

		function verifyNavHeight() {
			var navHeight;
			if (window_width < 768) {
				navHeight = $( '.navbar' ).outerHeight();
			} else {
				navHeight = ( $( '.navbar' ).outerHeight() - 15 );
			}
			return navHeight;
		}

		$( '.navbar a[href*="#"], a.btn[href*="#"]' ).click(
			function () {
				var menuitem = $( this ).attr( 'class' );
				if (menuitem === 'dropdown-toggle') {
					return;
				}
				if (location.pathname.replace( /^\//, '' ) === this.pathname.replace( /^\//, '' ) && location.hostname === this.hostname) {
					var target = $( this.hash );
					target     = target.length ? target : $( '[name=' + this.hash.slice( 1 ) + ']' );
					if (target.length) {
						$( 'html,body' ).animate(
							{
								scrollTop: ( target.offset().top - verifiedNavHeight )
							}, 1200
						);

						// Hide drop-down and submenu
						if ($( '.navbar .navbar-collapse' ).hasClass( 'in' )) {
							$( '.navbar .navbar-collapse.in' ).removeClass( 'in' );
						}
						if ($( '.navbar li.dropdown' ).hasClass( 'open' )) {
							$( '.navbar li.dropdown.open' ).removeClass( 'open' );
						}
						if ($( 'body' ).hasClass( 'menu-open' )) {
							$( 'body' ).removeClass( 'menu-open' );
							$( '.navbar-collapse' ).css( 'height','0' );
							$( '.navbar-toggle' ).attr( 'aria-expanded', 'false' );

						}

						return false;
					}
				}
			}
		);

		// Add control-label for each contact form field
		function addControlLabel(field) {
			var placeholderField = field.attr( 'placeholder' );
			field.removeAttr( 'placeholder' );
			$( '<label class="control-label"> ' + placeholderField + ' </label>' ).insertBefore( field );
		}

		var searchForm = $( '.search-form label' );
		if (typeof (searchForm) !== 'undefined') {

			var searchField = $( searchForm ).find( '.search-field' );
			if ($( searchField ).attr( 'value' ) === '') {
				$( searchForm ).addClass( 'label-floating is-empty' );
			} else {
				$( searchForm ).addClass( 'label-floating' );
			}

			addControlLabel( searchField );
		}

		var wooSearchForm = $( '.woocommerce-product-search' );
		if (typeof (wooSearchForm) !== 'undefined') {

			var wooSearchField = $( wooSearchForm ).find( '.search-field' );
			if ($( wooSearchField ).attr( 'value' ) === '') {
				$( wooSearchForm ).addClass( 'label-floating is-empty' );
			} else {
				$( wooSearchForm ).addClass( 'label-floating' );
			}

			addControlLabel( wooSearchField );
		}

		if (typeof $( '.contact_submit_wrap' ) !== 'undefined') {
			$( '.pirate-forms-submit-button' ).addClass( 'btn btn-primary' );
		}

		if (typeof $( '.form_captcha_wrap' ) !== 'undefined') {
			if ($( '.form_captcha_wrap' ).hasClass( 'col-sm-4' )) {
				$( '.form_captcha_wrap' ).removeClass( 'col-sm-6' );
			}
			if ($( '.form_captcha_wrap' ).hasClass( 'col-lg-6' )) {
				$( '.form_captcha_wrap' ).removeClass( 'col-lg-6' );
			}
			$( '.form_captcha_wrap' ).addClass( 'col-md-12' );
		}

		if (typeof $( 'form' ) !== 'undefined') {
			$( 'form' ).addClass( 'form-group' );
		}

		if (typeof $( 'input' ) !== 'undefined') {
			if (typeof $( 'input[type="text"]' ) !== 'undefined') {
				$( 'input[type="text"]' ).addClass( 'form-control' );
			}

			if (typeof $( 'input[type="email"]' ) !== 'undefined') {
				$( 'input[type="email"]' ).addClass( 'form-control' );
			}

			if (typeof $( 'input[type="url"]' ) !== 'undefined') {
				$( 'input[type="url"]' ).addClass( 'form-control' );
			}

			if (typeof $( 'input[type="password"]' ) !== 'undefined') {
				$( 'input[type="password"]' ).addClass( 'form-control' );
			}

			if (typeof $( 'input[type="tel"]' ) !== 'undefined') {
				$( 'input[type="tel"]' ).addClass( 'form-control' );
			}

			if (typeof $( 'input[type="search"]' ) !== 'undefined') {
				$( 'input[type="search"]' ).addClass( 'form-control' );
			}

			if (typeof $( 'input.select2-input' ) !== 'undefined') {
				$( 'input.select2-input' ).removeClass( 'form-control' );
			}
		}

		if (typeof $( 'textarea' ) !== 'undefined') {
			$( 'textarea' ).addClass( 'form-control' );
		}

		if (typeof $( '.form-control' ) !== 'undefined') {
			$( '.form-control' ).parent().addClass( 'form-group' );

			$( window ).on(
				'scroll', function () {
					$( '.form-control' ).parent().addClass( 'form-group' );
				}
			);
		}

		$( window ).on(
			'scroll', function () {
				if ($( 'body' ).hasClass( 'home' )) {
					if ($( window ).width() >= 751) {
						var hestia_scrollTop = $( window ).scrollTop(); // cursor position
						var headerHeight     = $( '.navbar' ).outerHeight(); // header height
						var isInOneSection   = 'no'; // used for checking if the cursor is in one section or not
						// for all sections check if the cursor is inside a section
						$( '#carousel-hestia-generic, section' ).each(
							function () {
								var thisID        = '#' + $( this ).attr( 'id' ); // section id
								var hestia_offset = $( this ).offset().top; // distance between top and our section
								var thisHeight    = $( this ).outerHeight(); // section height
								var thisBegin     = hestia_offset - headerHeight; // where the section begins
								var thisEnd       = hestia_offset + thisHeight - headerHeight; // where the section ends
								// if position of the cursor is inside of the this section
								if (hestia_scrollTop + verifiedNavHeight >= thisBegin && hestia_scrollTop + verifiedNavHeight <= thisEnd) {
									isInOneSection = 'yes';
									$( 'nav .on-section' ).removeClass( 'on-section' );
									$( 'nav a[href$="' + thisID + '"]' ).parent( 'li' ).addClass( 'on-section' ); // find the menu button with the same ID section
									return false;
								}
								if (isInOneSection === 'no') {
									$( 'nav .on-section' ).removeClass( 'on-section' );
								}
							}
						);
					}
				}
			}
		);

		$( document ).on(
			'DOMNodeInserted', '.added_to_cart', function () {
				if ( ! ( $( this ).parent().hasClass( 'hestia-view-cart-wrapper' ) )) {
					$( this ).wrap( '<div class="hestia-view-cart-wrapper"></div>' );
				}
			}
		);

		/**
		 * Add padding in post/page header
		 */
		function fixHeaderPadding() {
			if ($( window ).width() > 768) {
				var navbar_height = $( '.navbar-fixed-top' ).outerHeight();
				var beaver_offset = 40;
				$( '.pagebuilder-section' ).css( 'padding-top', navbar_height );
				$( '.fl-builder-edit .pagebuilder-section' ).css( 'padding-top', navbar_height + beaver_offset );
				$( '.page-header.header-small .container' ).css( 'padding-top', navbar_height + 100 );

				var headerHeight = $( '.single-product .page-header.header-small' ).height();
				var offset       = headerHeight + 100;
				$( '.single-product .page-header.header-small .container' ).css( 'padding-top', headerHeight - offset );

				var marginOffset = headerHeight - navbar_height - 172;
				$( '.woocommerce.single-product .blog-post .col-md-12 > div[id^=product].product' ).css( 'margin-top', -marginOffset );
			} else {
				$( '.page-header.header-small .container' ).removeAttr( 'style' );
			}
		}

		fixHeaderPadding();

		/**
		 * Calculate height for .page-header on front page
		 */
		function headerSpacingFrontpage() {
			if ($( '.home .header .carousel' ).length > 0) {
				var pageHeader      = $( '.page-header' ),
				pageHeaderContainer = $( '.page-header .container' ),
				windowWidth         = $( window ).width(),
				windowHeight        = $( window ).height();

				// Set page-header height
				if ( windowWidth > 768 ) {
					pageHeader.css( 'height', (windowHeight * 0.9) ); // 90% of window height
				} else {
					if ( windowHeight > pageHeaderContainer.outerHeight() ) {
						pageHeader.css( 'height', windowHeight ); // window height is 100%
						pageHeaderContainer.removeClass( 'container-height-auto' );
					} else {
						pageHeader.css( 'height', 'auto' ); // window height will be auto
						pageHeaderContainer.addClass( 'container-height-auto' );
					}
				}
			}
		}

		headerSpacingFrontpage();

		// Fix for Bootstrap Navwalker
		$( '.navbar .dropdown > a .caret' ).click(
			function () {
				event.preventDefault();
				event.stopPropagation();
				$( this ).toggleClass( 'caret-open' );
				$( this ).parent().siblings().toggleClass( 'open' );

				if ($( '.navbar .dropdown' ).hasClass( 'open' )) {
					$( '.navbar .dropdown' ).removeClass( 'open' );
					$( this ).toggleClass( 'caret-open' );
					$( this ).parent().siblings().toggleClass( 'open' );
				}
			}
		);

		// Add active parent links on navigation
		$( '.navbar .dropdown > a' ).click(
			function () {
				location.href = this.href;
			}
		);

		/**
		 * Detect if browser is iPhone or iPad then add body class
		 */
		function hestia_detect_ios() {
			if ($( '.hestia-about' ).length > 0 || $( '.hestia-ribbon' ).length > 0) {
				var iOS = /iPad|iPhone|iPod/.test( navigator.userAgent ) && ! window.MSStream;

				if (iOS) {
					$( 'body' ).addClass( 'is-ios' );
				}
			}
		}

		hestia_detect_ios();

		// Add size for each search input in top-bar
		if ($( '.hestia-top-bar input[type=search]' ).length > 0) {
			$( '.hestia-top-bar input[type=search]' ).each(
				function () {
					$( this ).attr( 'size', $( this ).parent().find( '.control-label' ).text().replace( / |…/g, '' ).length );
				}
			);
		}

		// Functions on window resize
		$( window ).resize(
			function () {
				fixHeaderPadding();
				headerSpacingFrontpage();
			}
		);

		// Very important! Don't Delete.
		var navigation = $( '#main-navigation' );
		navigation.on(
			'show.bs.collapse', function () {
				$( 'body' ).addClass( 'menu-open' );
			}
		);
		navigation.on(
			'hidden.bs.collapse', function () {
				$( 'body' ).removeClass( 'menu-open' );
			}
		);

		// Get window width
		function getWidth() {
			if (this.innerWidth) {
				return this.innerWidth;
			}

			if (document.documentElement && document.documentElement.clientWidth) {
				return document.documentElement.clientWidth;
			}

			if (document.body) {
				return document.body.clientWidth;
			}
		}
	}
);

(function ($) {
	$( window ).load(
		function () {
			// Sidebar toggle
			if ($( '.blog-sidebar-wrapper,.shop-sidebar-wrapper' ).length > 0) {
				var sidebarOrientation = 'left';

				// RTL
				if ( $( 'body.rtl' ).length !== 0 ) {
					sidebarOrientation = 'right';
				}

				$( '.hestia-sidebar-open' ).click(
					function () {
						$( '.sidebar-toggle-container' ).css( sidebarOrientation, '0' );
					}
				);

				$( '.hestia-sidebar-close' ).click(
					function () {
						$( '.sidebar-toggle-container' ).css( sidebarOrientation, '-100%' );
					}
				);
			}
		}
	);

}(jQuery));
