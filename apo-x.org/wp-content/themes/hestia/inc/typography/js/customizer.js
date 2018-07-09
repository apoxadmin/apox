/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @package hestia
 * @since 1.1.38
 */

/* global wp*/
/* global jQuery*/

wp.customize(
	'hestia_body_font_size', function( value ) {
		'use strict';
		value.bind(
			function( to ) {

				var settings = {
					cssProperty: 'font-size',
					propertyUnit: 'px',
					styleClass: 'hestia-body-text-css'
				};

				var arraySizes = {
					size1: { selectors: 'p, ul, li, select, table, .form-group.label-floating label.control-label, .form-group.label-placeholder label.control-label, .copyright, .woocommerce .product .card-product div.card-description p, #secondary div[id^=woocommerce_layered_nav] ul li a, #secondary div[id^=woocommerce_product_categories] ul li a, .footer div[id^=woocommerce_layered_nav] ul li a, .footer div[id^=woocommerce_product_categories] ul li a, #secondary div[id^=woocommerce_price_filter] .price_label, .footer div[id^=woocommerce_price_filter] .price_label, .woocommerce ul.product_list_widget li, .footer ul.product_list_widget li, ul.product_list_widget li,        .woocommerce .woocommerce-result-count,        .woocommerce div.product div.woocommerce-tabs ul.tabs.wc-tabs li a, .variations tr .label, .woocommerce.single-product .section-text, .woocommerce div.product form.cart .reset_variations, .woocommerce.single-product div.product .woocommerce-review-link, .woocommerce div.product form.cart a.reset_variations,       .woocommerce-cart .shop_table .actions .coupon .input-text,        .woocommerce-cart table.shop_table td.actions input[type=submit],        .woocommerce .cart-collaterals .cart_totals .checkout-button,        .form-control,        .woocommerce-checkout #payment ul.payment_methods li, .woocommerce-checkout #payment ul.payment_methods div, .woocommerce-checkout #payment ul.payment_methods div p, .woocommerce-checkout #payment input[type=submit], .woocommerce-checkout input[type=submit], .woocommerce.single-product .section-text', valueDiff: 0 },
					size2: { selectors: '.woocommerce.single-product .product .woocommerce-product-rating .star-rating, .woocommerce .star-rating, .woocommerce .woocommerce-breadcrumb, button, input[type="submit"], input[type="button"], .btn, .woocommerce .single-product div.product form.cart .button, .woocommerce div#respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce div#respond input#submit.alt, .woocommerce a.button.alt, body.woocommerce button.button.alt, #secondary div[id^=woocommerce_price_filter] .button, .footer div[id^=woocommerce_price_filter] .button, .tooltip-inner', valueDiff: -2 },
					size3: { selectors: 'woocommerce-cart table.shop_table th', valueDiff: -1 },
					size4: { selectors: '#secondary div[id^=woocommerce_recent_reviews] .reviewer, .footer div[id^=woocommerce_recent_reviews] .reviewer', valueDiff: 1 },
					size5: { selectors: '.hestia-features .hestia-info p, .hestia-features .info p, .features .hestia-info p, .features .info p, .woocommerce-cart table.shop_table .product-name a, .woocommerce-checkout .form-row label, .media p', valueDiff: 2 },
					size6: { selectors: '.blog-post .section-text', valueDiff: 2.8 },
					size7: { selectors: '.hestia-about p', valueDiff: 3.5 },
					size8: { selectors: '.carousel span.sub-title, .media .media-heading, .card .footer .stats .fa', valueDiff: 4.2},
					size9: { selectors: 'table > thead > tr > th', valueDiff: 7 },
					size10: { selectors: '.woocommerce-cart table.shop_table th', valueDiff: -5 },
					size11: { selectors: '.added_to_cart.wc-forward, .products .shop-item .added_to_cart', valueDiff: -4.2 }
				};

				setStyle( arraySizes, settings, to );

			}
		);
	}
);

wp.customize(
	'hestia_headings_font_size', function( value ){
		'use strict';
		value.bind(
			function( to ) {

				var settings = {
					cssProperty: 'font-size',
					propertyUnit: 'px',
					styleClass: 'hestia-headings-style-css'
				};

				var arraySizes = {
					size1: { selectors: '.widget h5', valueDiff: -14.56 },
					size2: { selectors: 'h1,.page-header.header-small .hestia-title, .page-header.header-small .title, .blog-post.blog-post-wrapper .section-text h1', valueDiff: 16.8 },
					size3: { selectors: '.carousel h1.hestia-title, .carousel h2.title', valueDiff: 30.8 },
					size4: { selectors: 'h2, .blog-post.blog-post-wrapper .section-text h2, .woocommerce section.related.products h2, .woocommerce.single-product h1.product_title', valueDiff: 0 },
					size5: { selectors: 'h3, .blog-post.blog-post-wrapper .section-text h3', valueDiff: -10.85 },
					size6: { selectors: 'h4, .card-blog .card-title, .blog-post.blog-post-wrapper .section-text h4', valueDiff: -18.2 },
					size7: { selectors: 'h5, .blog-post.blog-post-wrapper .section-text h5', valueDiff: -18.9 },
					size8: { selectors: 'h6, .card-product .category, .blog-post.blog-post-wrapper .section-text h6', valueDiff: -23.8 },
					size9: { selectors: '.archive .page-header.header-small .hestia-title, .blog .page-header.header-small .hestia-title, .search .page-header.header-small .hestia-title, .archive .page-header.header-small .title,.blog .page-header.header-small .title, .search .page-header.header-small .title', valueDiff: 8.4 },
					size10: { selectors: '.woocommerce span.comment-reply-title, .woocommerce.single-product .summary p.price, .woocommerce.single-product .woocommerce-variation-price span.price', valueDiff: -10.85}
				};

				setStyle( arraySizes, settings, to );

			}
		);
	}
);

wp.customize(
	'hestia_line_height', function( value ) {
		'use strict';

		value.bind(
			function( to ) {

				var settings = {
					cssProperty: 'line-height',
					propertyUnit: 'px',
					styleClass: 'hestia-line-height-css'
				};

				var arraySizes = {
					size1: { selectors: 'body, .woocommerce .product .card-product .card-description p, .woocommerce ul.product_list_widget li a, .footer ul.product_list_widget li a, ul.product_list_widget li a', valueDiff: 0 },
					size2: { selectors: '.media p', valueDiff: 4.6 },
					size3: { selectors: '.blog-post, ul, ol, .carousel span.sub-title', valueDiff: 4.2 },
					size4: { selectors: 'h1, .carousel h1.hestia-title, .carousel h2.title', valueDiff: 56.28 },
					size5: { selectors: 'h2', valueDiff: 33.6 },
					size6: { selectors: 'h3', valueDiff: 14.77 },
					size7: { selectors: 'h4, .widget h5, .woocommerce-cart table.shop_table .product-name a', valueDiff: 7.21 },
					size8: { selectors: 'h5, .hestia-about p', valueDiff: 6.125 },
					size9: { selectors: 'h6', valueDiff: -2.1 },
					size10: { selectors: '.widget ul li', valueDiff: 12.6 }
				};

				setStyle( arraySizes, settings, to );

			}
		);
	}
);

wp.customize(
	'hestia_letter_spacing', function( value ) {
		'use strict';
		value.bind(
			function( to ) {
				var settings = {
					selectors: 'body',
					cssProperty: 'letter-spacing',
					propertyUnit: 'px',
					styleClass: 'hestia-letter-spacing-css'
				}, val;
				val          = JSON.parse( to );
				styleCss( settings, val );

			}
		);
	}
);

wp.customize(
	'hestia_paragraph_margin', function( value ) {
		'use strict';
		value.bind(
			function( to ) {
				var settings = {
					selectors: 'p, .blog-post .section-text p, .hestia-about p, .card-description p, .woocommerce .product .card-product .card-description p',
					cssProperty: 'margin-bottom',
					propertyUnit: 'px',
					styleClass: 'hestia-paragraph-margin-css'
				}, val;
				val          = JSON.parse( to );
				styleCss( settings, val );
			}
		);
	}
);

wp.customize(
	'hestia_container_width', function( value ) {
		'use strict';
		value.bind(
			function( to ) {
				if ( to ) {
					var values = JSON.parse( to );
					if ( values ) {
						if ( values.mobile ) {
							var settings = {
								selectors: '.container',
								cssProperty: 'width',
								propertyUnit: 'px',
								styleClass: 'hestia-container-width-css'
							}, val;
							val          = JSON.parse( to );
							styleCss( settings, val );
						}
					}
				}
			}
		);
	}
);

/**
 * Apply different size for each selector in arraySizes.
 *
 * @param arraySizes
 * @param settings
 * @param to
 */
function setStyle ( arraySizes, settings, to ) {
	'use strict';
	var data, desktopVal, tabletVal, mobileVal,
		className = settings.styleClass, i = 1;

	var val = JSON.parse( to );
	if ( typeof( val ) === 'object' && val !== null ) {
		if ('desktop' in val) {
			desktopVal = val.desktop;
		}
		if ('tablet' in val) {
			tabletVal = val.tablet;
		}
		if ('mobile' in val) {
			mobileVal = val.mobile;
		}
	}

	for ( var key in arraySizes ) {
		// skip loop if the property is from prototype
		if ( ! arraySizes.hasOwnProperty( key )) {
			continue;
		}
		var obj = arraySizes[key];

		if ( typeof( val ) === 'object' && val !== null ) {
			data = {
				desktop: ( parseFloat( desktopVal ) + obj.valueDiff ),
				tablet: ( parseFloat( tabletVal ) + obj.valueDiff ),
				mobile: ( parseFloat( mobileVal ) + obj.valueDiff )
			};
		} else {
			data = parseFloat( to ) + obj.valueDiff;
		}
		settings.styleClass = className + '-' + i;
		settings.selectors  = obj.selectors;

		styleCss( settings, data );
		i++;
	}
}

/**
 * Set style for range controls.
 *
 * @param settings
 * @param to
 */
function styleCss( settings, to ){
	'use strict';
	var result     = '';
	var styleClass = jQuery( '.' + settings.styleClass );
	if ( to !== null && typeof to === 'object' ) {
		jQuery.each(
			to, function ( key, value ) {
				var style_to_add;
				if ( settings.selectors === '.container' ) {
					style_to_add = settings.selectors + '{ ' + settings.cssProperty + ':' + value + settings.propertyUnit + '; max-width: 100%; }';
				} else {
					style_to_add = settings.selectors + '{ ' + settings.cssProperty + ':' + value + settings.propertyUnit + '}';
				}
				switch ( key ) {
					case 'desktop':
						result += style_to_add;
						break;
					case 'tablet':
						result += '@media (max-width: 767px){' + style_to_add + '}';
						break;
					case 'mobile':
						result += '@media (max-width: 480px){' + style_to_add + '}';
						break;
				}
			}
		);
		if ( styleClass.length > 0 ) {
			styleClass.text( result );
		} else {
			jQuery( 'head' ).append( '<style type="text/css" class="' + settings.styleClass + '">' + result + '</style>' );
		}
	} else {
		jQuery( settings.selectors ).css( settings.cssProperty, to + 'px' );
	}
}
