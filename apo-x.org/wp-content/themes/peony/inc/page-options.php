<?php

/**
 * Page Options ( Using Mageewp Page Layout plugin API )
 */

function peony_page_options() {

/************ get nav menus*************/
 
	$nav_menus[''] =  __( 'Default', 'peony' );
	$menus = get_registered_nav_menus();
	
	foreach ( $menus as $location => $description ) {
		$nav_menus[$location] = $description ;
		
	}

	$box1 = new Mpl_Metaboxes( array(
		'id' => 'peony_page_options',
		'screens' => array( 'page' ), 
		'title' => __( 'Peony Page Options', 'peony' ),
		'context' => 'advanced', 
		'priority' => 'high',
		'fields' => array(
			
			array(
				'name' => 'peony_header_overlay',
				'type' => 'checkbox',
				'heading' => __( 'Header Overlay', 'peony' ),
				'value' => '',
				'desc' => '',
				
			),
			
			array(
				'name' => 'peony_custom_menu',
				'type' => 'select',
				'heading' => __( 'Custom Menu', 'peony' ),
				'value' => '',
				'desc' => '',
				'options' =>$nav_menus
				
			),
			
			array(
				'name' => 'peony_fullpage',
				'type' => 'checkbox',
				'heading' => __( 'Full Width', 'peony' ),
				'value' => 0,
				'desc' => '',
				
			),
			
			/*array(
				'name' => 'peony_fullscreen',
				'type' => 'select',
				'heading' => __( 'Full Screen:', 'peony' ),
				'value' => '',
				'desc' => '',
				'options' => array(
								   '0' => __( 'Disable', 'peony' ),
								   '1' => __( 'Full Screen', 'peony' ),
								   '2' => __( '3D Full Screen', 'peony' ),
								   )
				
			),*/
			
			array(
				'name' => 'peony_side_menu',
				'type' => 'checkbox',
				'heading' => __( 'Display Side Navigation', 'peony' ),
				'value' => 0,
				'desc' => '',
				'dependency' => array(
					'element' => 'peony_fullpage',
					'value' => '1',
				),
			),
			array(
				'name' => 'peony_enable_page_title_bar',
				'type' => 'select',
				'heading' => __( 'Display Page Title Bar', 'peony' ),
				'value' => '0',
				'desc' => __( 'Title Bar Backgroud Color & Title Bar Backgroud Image options are available in pro version', 'peony' ),
				'options' => array(
					'0' => __( 'Default', 'peony' ),
					'1' => __( 'Yes', 'peony' ),
					'2' => __( 'No', 'peony' ),
				),
			),
			
	
			
						
		)
   ) );
}

/**
 * Hook to post screen
 */
if ( is_admin() && class_exists('Mpl_Metaboxes') ) {

	add_action( 'load-post.php', 'peony_page_options' );
	add_action( 'load-post-new.php', 'peony_page_options' );
}