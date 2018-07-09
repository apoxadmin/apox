/**
 * File customizer-controls.js
 *
 * The file for generic customizer controls.
 *
 * @package Hestia
 */

jQuery( document ).ready(
	function() {
			'use strict';

			wp.customize(
				'hestia_team_content', function( value ) {
					value.bind(
						function() {
							var authors_values;
							var result = '';

							if ( jQuery.isFunction( wp.customize._value.hestia_authors_on_blog ) ) {
								authors_values = wp.customize._value.hestia_authors_on_blog();
							}
							jQuery( '#customize-control-hestia_team_content .customizer-repeater-general-control-repeater-container' ).each(
								function () {
									var title = jQuery( this ).find( '.customizer-repeater-title-control' ).val();
									var id    = jQuery( this ).find( '.social-repeater-box-id' ).val();
									if ( typeof (title) !== 'undefined' && title !== '' && typeof (id) !== 'undefined' && id !== '' ) {
										result += '<option value="' + id + '" ';
										if ( authors_values && authors_values !== 'undefined' ) {
											if (authors_values.indexOf( id ) !== -1) {
												result += 'selected';
											}
										}
										result += '>' + title + '</option>';
									}
								}
							);

							jQuery( '#customize-control-hestia_authors_on_blog .repeater-multiselect-team' ).html( result );
						}
					);
				}
			);

			/* Move controls to Widgets sections. Used for sidebar placeholders */
		if ( typeof wp.customize.control( 'hestia_placeholder_sidebar_1' ) !== 'undefined' ) {
			wp.customize.control( 'hestia_placeholder_sidebar_1' ).section( 'sidebar-widgets-sidebar-1' );
		}
		if ( typeof wp.customize.control( 'hestia_placeholder_sidebar_woocommerce' ) !== 'undefined' ) {
			wp.customize.control( 'hestia_placeholder_sidebar_woocommerce' ).section( 'sidebar-widgets-sidebar-woocommerce' );
		}

			jQuery( '#customize-theme-controls' ).on(
				'click', '.hestia-link-to-top-menu', function(){
					wp.customize.section( 'menu_locations' ).focus();
				}
			);

	}
);
