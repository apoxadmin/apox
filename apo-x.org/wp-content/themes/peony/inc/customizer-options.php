<?php
/**
 * Defines customizer options
 *
 */

function peony_customizer_options() {
	global $peony_sidebars,$peony_default_options , $peony_homepage_sections,$peony_default_theme_fonts;
	
	// fonts
	
	$peony_default_theme_fonts = array(

		'Arial, Helvetica, sans-serif' => __( 'Arial, Helvetica, sans-serif', 'peony' ),
		"'Arial Black', Gadget, sans-serif" => __( "'Arial Black', Gadget, sans-serif", 'peony' ),
		"'Bookman Old Style', serif" => __( "'Bookman Old Style', serif", 'peony' ),
		"'Comic Sans MS', cursive" => __( "'Comic Sans MS', cursive", 'peony' ),
		"Courier, monospace" => __( "Courier, monospace", 'peony' ),
		"Garamond, serif" => __( "Garamond, serif", 'peony' ),
		"Georgia, serif" => __( "Georgia, serif", 'peony' ),
		"Impact, Charcoal, sans-serif" => __( "Impact, Charcoal, sans-serif", 'peony' ),
		"'Lucida Console', Monaco, monospace" => __( "'Lucida Console', Monaco, monospace", 'peony' ),
		"'Lucida Sans Unicode', 'Lucida Grande', sans-serif" => __( "'Lucida Sans Unicode', 'Lucida Grande', sans-serif", 'peony' ),
		"'MS Sans Serif', Geneva, sans-serif" => __( "'MS Sans Serif', Geneva, sans-serif", 'peony' ),
		"'MS Serif', 'New York', sans-serif" => __( "'MS Serif', 'New York', sans-serif", 'peony' ),
		"'Palatino Linotype', 'Book Antiqua', Palatino, serif" => __( "'Palatino Linotype', 'Book Antiqua', Palatino, serif", 'peony' ),
		"Tahoma, Geneva, sans-serif" => __( "Tahoma, Geneva, sans-serif", 'peony' ),
		"'Times New Roman', Times, serif" => __( "'Times New Roman', Times, serif", 'peony' ),
		"'Trebuchet MS', Helvetica, sans-serif" => __( "'Trebuchet MS', Helvetica, sans-serif", 'peony' ),
		"Verdana, Geneva, sans-serif" => __( "Verdana, Geneva, sans-serif", 'peony' )
		
	);
	
	$default_theme_fonts_option[''] =  __( '-- Select Font --', 'peony' );
	foreach($peony_default_theme_fonts as $index => $value){
		$default_theme_fonts_option[$index] =  $value;
	}
	
	// font size
	$font_size =  array_combine(range(1,100,1), range(1,100,1));


 // If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';
	
	$choices =  array( 
		'yes'   => __( 'Yes', 'peony' ),
		'no' => __( 'No', 'peony' )
	);
 
	$align =  array( 
          
		'left' => __( 'Left', 'peony' ),
		'right' => __( 'Right', 'peony' ),
		'center'  => __( 'Center', 'peony' )         
	);
  
	$repeat = array( 
          
		'repeat' => __( 'Repeat', 'peony' ),
		'repeat-x'  => __( 'Repeat-x', 'peony' ),
		'repeat-y' => __( 'Repeat-y', 'peony' ),
		'no-repeat'  => __( 'No-repeat', 'peony' )
          
	);
  
	$position =  array( 
          
		'top left' => __( 'Top Left', 'peony' ),
		'top center' => __( 'Top Center', 'peony' ),
		'top right' => __( 'Top Right', 'peony' ),
		'center left' => __( 'Center Left', 'peony' ),
		'center center'  => __( 'Center Center', 'peony' ),
		'center right' => __( 'Center Right', 'peony' ),
		'bottom left'  => __( 'Bottom Left', 'peony' ),
		'bottom center'  => __( 'Bottom Center', 'peony' ),
		'bottom right' => __( 'Bottom Right', 'peony' )
            
	);
  
	$opacity   =  array_combine(range(0.1,1,0.1), range(0.1,1,0.1));
	$font_size =  array_combine(range(1,100,1), range(1,100,1));
  
	$target = array(
		'_blank' => __( 'Open in new window', 'peony' ),
		'_self' => __( 'Open in same window', 'peony' )
		);
  
  
	// Stores all the controls that will be added
	$options = array();

	// Stores all the sections to be added
	$sections = array();

	// Stores all the panels to be added
	$panels = array();

	// Adds the sections to the $options array
	$options['sections'] = $sections;
	
 ##### Home Page #####
	
	$peony_homepage_sections = array(
		'slider' => __( 'Section - Slider', 'peony' ),
		'promo' => __( 'Section - Promo', 'peony' ),
		'gallery' => __( 'Section - Gallery', 'peony' ),
		'services' => __( 'Section - Services', 'peony' ),
		'recent_posts' => __( 'Section - Recent Posts', 'peony' ),
		'contact' => __( 'Section - Contact', 'peony' ),
		);
  
	
	// Section Slider
	$section = 'general-options';
	
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Peony: General Options', 'peony' ),
		'priority' => '1',
		'description' => '',
		'panel' => ''
	);
	
	$options['peony_primary_color'] = array(
        'id'          => 'peony_primary_color',
        'label'       => __( 'Primary Color', 'peony' ),
        'description' => '',
        'default'     => '#59c8c1',
        'type'        => 'color',
        'section' => $section,
      );
	
	$options['peony_layout'] = array(
		'id' => 'peony_layout',
		'label' => __( 'Layout', 'peony' ),
		'description'   => '',
		'section' => $section,
		'type'    => 'select',
		'default' => 'wide',
		'choices' => array( 'wide'=>__( 'Wide', 'peony' ), 'boxed'=> __( 'Boxed', 'peony' ) ),
	);
	
		
		$options['peony_sticky_header'] = array(
		'id' => 'peony_sticky_header',
		'label' => __( 'Sticky Header', 'peony' ),
		'description'   => '',
		'section' => $section,
		'type'    => 'checkbox',
		'default' => '',
	);
	
	$options['peony_display_main_menu'] = array(
		'id' => 'peony_display_main_menu',
		'label' => __( 'Display Normal Main Menu', 'peony' ),
		'description'   => '',
		'section' => $section,
		'type'    => 'checkbox',
		'default' => '1',
	);
	
	
	$options['peony_nav_drawer_breakpoint'] = array(
        'id'          => 'peony_nav_drawer_breakpoint',
        'label'      => __( 'Navigation Drawer breakpoint', 'peony' ),
        'description'        => __( 'Use a number without \'px\', default is 920. ex: 920.', 'peony' ),
        'default'         => '920',
        'type'        => 'text',
        'section' => $section,
        
      );

	$options['peony_subnav_width'] = array(
        'id'          => 'peony_subnav_width',
        'label'      => __( 'Sub-menu Width', 'peony' ),
        'description'        => __( 'Use a number without \'px\', default is 150. ex: 150.', 'peony' ),
        'default'         => '150',
        'type'        => 'text',
        'section' => $section,
        
      );

		 
	#### page title bar options ####
	
	$panel = 'page-title-bar';
	
	$panels[] = array(
		'id' => $panel,
		'title' => __( 'Peony: Page Title Bar', 'peony' ),
		'priority' => '2'
	);
	// Page Title Bar Options
	$section = 'page-title-bar-general';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'General', 'peony' ),
		'priority' => '10',
		'description' => '',
		'panel' => $panel
	  );
	$options['peony_enable_page_title_bar'] =  array(
		'id'          => 'peony_enable_page_title_bar',
		'label'       => __( 'Enable Page Title Bar', 'peony' ),
		'description' => '',
		'default'     => '1',
		'type'        => 'checkbox',
		'section'     => $section,
		'description' => __( 'Choose to display page title bar for pages.', 'peony' )
		);
	
	$options['peony_enable_blog_title_bar'] =  array(
		'id'          => 'peony_enable_blog_title_bar',
		'label'       => __( 'Enable Blog Title Bar', 'peony' ),
		'description' => '',
		'default'     => '1',
		'type'        => 'checkbox',
		'section'     => $section,
		'description' => __( 'Choose to display page title bar for posts.', 'peony' )
		);
	   
	$options['peony_page_title_bar_top_padding'] =  array(
		'id'          => 'peony_page_title_bar_top_padding',
		'label'      => __( 'Title Bar Top Padding', 'peony' ),
		'description'        => __( 'In pixels, ex: 210px', 'peony' ),
		'default'         => '110px',
		'type'        => 'text',
		'section' => $section,
		
		);
	   
	$options['peony_page_title_bar_bottom_padding'] =  array(
		'id'          => 'peony_page_title_bar_bottom_padding',
		'label'      => __( 'Title Bar Bottom Padding', 'peony' ),
		'description'        => __( 'In pixels, ex: 160px', 'peony' ),
		'default'         => '60px',
		'type'        => 'text',
		'section' => $section,
		
		);
	
	
	$options['peony_page_title_bar_background'] =  array(
		'id'          => 'peony_page_title_bar_background',
		'label'      => __( 'Title Bar Background Image', 'peony' ),
		'description'        => '',
		'default'         => '',
		'type'        => 'upload',
		'section' => $section,
		
		);
	$options['peony_page_title_bar_bg_pos'] = array(
		'id'          => 'peony_page_title_bar_bg_pos',
		'label'      => __( 'Background Image Position', 'peony' ),
		'description'        => '',
		'default'         => 'top left',
		'type'        => 'select',
		'section' => $section,
		'choices'     => $position
		);
		
	$options['peony_page_title_bar_style'] =  array(
		'id'          => 'peony_page_title_bar_style',
		'label'      => __( 'Page Title Position', 'peony' ),
		'description'        => __( 'Set alignment for page title.' ,'peony' ),
		'default'         => 'title-center',
		'type'        => 'select',
		'section' => $section,
		'choices'     => array(
						 'title-left' => __( 'Title Left Breadcrumb Right' ,'peony' ),
						 'title-right' => __( 'Title Right Breadcrumb Left' ,'peony' ),
						 'title-center' => __( 'Title Center Breadcrumb Center' ,'peony' ),
						 'title-left2' => __( 'Title Left Breadcrumb Left' ,'peony' ),
						 'title-right2' => __( 'Title Right Breadcrumb Right' ,'peony' ),
						 )
		
		);
	
	$options['peony_page_title_bg_full'] =  array(
		'id'          => 'peony_page_title_bg_full',
		'label'      => __( 'Background Full Width', 'peony' ),
		'description'        => '',
		'default'         => '1',
		'type'        => 'checkbox',
		'section' => $section,
		);
	
	
	// Breadcrumb Options
	$section = 'breadcrumb-options';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Breadcrumb Options', 'peony' ),
		'priority' => '11',
		'description' => '',
		'panel' => $panel
	  );
	 
	 $options['peony_display_breadcrumb'] =  array(
		'id'          => 'peony_display_breadcrumb',
		'label'       => __( 'Enable breadcrumb?', 'peony' ),
		'description' => __( 'Choose to display or hide breadcrumbs.', 'peony'),
		'default'     => '1',
		'type'        => 'checkbox',
		'section'     => $section,
		);
	
	$options['peony_breadcrumb_menu_prefix'] =  array(
		'id'          => 'peony_breadcrumb_menu_prefix',
		'label'      => __( 'Breadcrumb Menu Prefix', 'peony' ),
		'description'        => __( 'The text before the breadcrumb menu.', 'peony' ),
		'default'         => '',
		'type'        => 'text',
		'section' => $section,
		);
	$options['peony_breadcrumb_menu_separator'] =  array(
		'id'          => 'peony_breadcrumb_menu_separator',
		'label'      => __( 'Breadcrumb Menu Separator', 'peony' ),
		'description'        => __( 'Choose a separator between the single breadcrumbs.', 'peony' ),
		'default'         => '/',
		'type'        => 'text',
		'section' => $section,
	
		);
	$options['peony_breadcrumb_show_post_type_archive'] =  array(
		'id'          => 'peony_breadcrumb_show_post_type_archive',
		'label'      => __( 'Show Custom Post Type Archives on Breadcrumbs.', 'peony' ),
		'description'        => __( 'Check to display custom post type archives in the breadcrumb path.', 'peony' ),
		'default'         => '1',
		'type'        => 'checkbox',
		'section' => $section,
		);
	$options['peony_breadcrumb_show_categories'] =  array(
		'id'          => 'peony_breadcrumb_show_categories',
		'label'      => __( 'Show Post Categories on Breadcrumbs.', 'peony' ),
		'description'        => __( 'Check to display custom post type archives in the breadcrumb path.', 'peony' ),
		'default'         => '1',
		'type'        => 'checkbox',
		'section' => $section,        
	
		);
	
	
	#### Footer options ####
	
	$panel = 'footer';
	
	$panels[] = array(
		'id' => $panel,
		'title' => __( 'Peony: Footer', 'peony' ),
		'priority' => '4'
		);
	// general
	$section = 'footer-general';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'General', 'peony' ),
		'priority' => '10',
		'description' => '',
		'panel' => $panel
	  );
	  
	$options['peony_enable_footer_widgets'] =  array(
		'id'          => 'peony_enable_footer_widgets',
		'label'      => __( 'Enable Footer Widgets Area?', 'peony' ),
		'description'        => '',
		'default'         => '',
		'type'        => 'checkbox',
		'section' => $section,
		);
	  
	$options['peony_footer_top_padding'] =  array(
		'id'          => 'peony_footer_top_padding',
		'label'      => __( 'Top Padding', 'peony' ),
		'description'        => __( 'In pixels, ex: 60px', 'peony' ),
		'default'         => '60px',
		'type'        => 'text',
		'section' => $section,
		
		);
	   
	$options['peony_footer_bottom_padding'] =  array(
		'id'          => 'peony_footer_bottom_padding',
		'label'      => __( 'Bottom Padding', 'peony' ),
		'description'        => __( 'In pixels, ex: 40px', 'peony' ),
		'default'         => '40px',
		'type'        => 'text',
		'section' => $section,
		
	);

	$section = 'footer-copyright';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Copyright', 'peony' ),
		'priority' => '10',
		'description' => '',
		'panel' => $panel
	  );
	
	$options['peony_enable_tooltip'] =  array(
		'id'          => 'peony_enable_tooltip',
		'label'      => __( 'Enable Tooltip?', 'peony' ),
		'description'        => '',
		'default'         => '1',
		'type'        => 'checkbox',
		'section' => $section,
		);
	

	
	for( $i=1;$i<=8;$i++ ):

	$options['peony_footer_social_icon_'.$i] =  array(
		'id'          => 'peony_footer_social_icon_'.$i,
		'label'      => sprintf(__( 'Icon %d', 'peony' ),$i),
		'description'        => '',
		'default'         => '',
		'type'        => 'text',
		'section' => $section,
		);
	$options['peony_footer_social_title_'.$i] =  array(
		'id'          => 'peony_footer_social_title_'.$i,
		'label'      => sprintf(__( 'Title %d', 'peony' ),$i),
		'description'        => '',
		'default'         => '',
		'type'        => 'text',
		'section' => $section,
		);
	$options['peony_footer_social_link_'.$i] =  array(
		'id'          => 'peony_footer_social_link_'.$i,
		'label'      => sprintf(__( 'Link %d', 'peony' ),$i),
		'description'        => '',
		'default'         => '',
		'type'        => 'text',
		'section' => $section,
		);
	   
	endfor;
	
	
	### Sidebar  ###
	$panel = 'sidebar';

	$panels[] = array(
		'id' => $panel,
		'title' => __( 'Peony: Sidebar', 'peony' ),
		'priority' => '5'
	);

 // Pages
	$section = 'sidebar-pages';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Pages', 'peony' ),
		'priority' => '10',
		'description' => '',
		'panel' => $panel
	);

 
	$options['peony_left_sidebar_pages'] =  array(
        'id'          => 'peony_left_sidebar_pages',
        'label'       => __( 'Left Sidebar', 'peony' ),
        'description' => __( 'Select left sidebar that will display on all pages.', 'peony' ),
        'default'     => '',
        'type'        => 'select',
        'section'     => $section,
        'choices'     => $peony_sidebars,
  
      );
	$options['peony_right_sidebar_pages'] =  array(
        'id'          => 'peony_right_sidebar_pages',
        'label'       => __( 'Right Sidebar', 'peony' ),
        'description' => __( 'Select right sidebar that will display on all pages.', 'peony' ),
        'default'     => '',
        'type'        => 'select',
        'section'     => $section,
        'choices'     => $peony_sidebars,
  
      );

// Blog Posts
	$section = 'sidebar_blog_posts';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Blog Posts', 'peony' ),
		'priority' => '11',
		'description' => '',
		'panel' => $panel
	);
 
	$options['peony_left_sidebar_blog_posts'] =  array(
        'id'          => 'peony_left_sidebar_blog_posts',
        'label'      => __( 'Left Sidebar', 'peony' ),
        'description'        => __( 'Select left sidebar that will display on all blog posts.', 'peony' ),
        'default'         => '',
        'type'        => 'select',
        'section' => $section,        
        'choices'     => $peony_sidebars,
	
      );
	$options['peony_right_sidebar_blog_posts'] =  array(
        'id'          => 'peony_right_sidebar_blog_posts',
        'label'      => __( 'Right Sidebar', 'peony' ),
        'description'        => __( 'Select right sidebar that will display on all blog posts.', 'peony' ),
        'default'         => 'default_sidebar',
        'type'        => 'select',
        'section' => $section,
         'choices'     => $peony_sidebars,
	
      );

// Blog Posts
	$section = 'sidebar_blog_archive';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Blog Archive Category Pages', 'peony' ),
		'priority' => '12',
		'description' => '',
		'panel' => $panel
	);
 
	$options['peony_left_sidebar_blog_archive'] =  array(
        'id'          => 'peony_left_sidebar_blog_archive',
        'label'      => __( 'Left Sidebar', 'peony' ),
        'description'        => __( 'Select left sidebar that will display on blog archive pages.', 'peony' ),
        'default'         => '',
        'type'        => 'select',
        'section' => $section,
        'choices'     => $peony_sidebars,
	
      );
	$options['peony_right_sidebar_blog_archive'] =  array(
        'id'          => 'peony_right_sidebar_blog_archive',
        'label'      => __( 'Right Sidebar', 'peony' ),
        'description'        => __( 'Select right sidebar that will display on blog archive pages.', 'peony' ),
        'default'         => 'default_sidebar',
        'type'        => 'select',
        'section' => $section,
        'choices'     => $peony_sidebars,
	
      );

//Sidebar search

	$section = 'sidebar_404';
	$sections[] = array(
		'id' => $section,
		'title' => __( '404 Page', 'peony' ),
		'priority' => '6',
		'description' => '',
		'panel' => $panel
	);
 
	$options['peony_left_sidebar_404'] =  array(
        'id'          => 'peony_left_sidebar_404',
        'label'      => __( 'Left Sidebar', 'peony' ),
        'description'        => __( 'Select left sidebar that will display on 404 pages.', 'peony' ),
        'default'         => '',
        'type'        => 'select',
        'section' => $section,
        'choices'     => $peony_sidebars,
	
      );
	$options['peony_right_sidebar_404'] =  array(
        'id'          => 'peony_right_sidebar_404',
        'label'      => __( 'Right Sidebar', 'peony' ),
		'description'        => __( 'Select right sidebar that will display on 404 pages.', 'peony' ),
        'default'         => '',
        'type'        => 'select',
        'section' => $section,
        'choices'     => $peony_sidebars,
	
      );

### Blog ###
	$panel = 'blog';

	$panels[] = array(
		'id' => $panel,
		'title' => __( 'Peony: Blog', 'peony' ),
		'priority' => '7'
	);
	// General Blog Options
	$section = 'general_blog_options';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'General', 'peony' ),
		'priority' => '10',
		'description' => '',
		'panel' => $panel
	);
	
	$options['peony_blog_list_style'] =  array(
        'id'          => 'peony_blog_list_style',
        'label'      => __( 'Blog List Style', 'peony' ),
        'description' => '',
        'default'         => 'blog-aside-image',
        'type'        => 'select',
        'section' => $section,
		'choices' => array( ''=>__( 'Default', 'peony' ), 'blog-aside-image'=> __( 'Blog Aside Image', 'peony' ), 'blog-grid'=> __( 'Blog Grid', 'peony' ) ),
		);
 
	$options['peony_blog_title'] =  array(
        'id'          => 'peony_blog_title',
        'label'      => __( 'Blog Page Title', 'peony' ),
        'description'        => __( 'This text will display in the page title bar of the assigned blog page.', 'peony' ),
        'default'         => __('Blog', 'peony' ),
        'type'        => 'text',
        'section' => $section,    
	);
	

	$options['peony_blog_subtitle'] =  array(
        'id'          => 'peony_blog_subtitle',
        'label'      => __( 'Blog Page Subtitle', 'peony' ),
        'description'        => __( 'This text will display in the page title bar of the assigned blog page.', 'peony' ),
        'default'         => '',
        'type'        => 'text',
        'section' => $section,    
	);

	$options['peony_blog_pagination_type'] =  array(
        'id'          => 'peony_blog_pagination_type',
        'label'      => __( 'Pagination Type', 'peony' ),
        'description'        => __( 'Select the pagination type for the assigned blog page.', 'peony' ),
        'default'         =>  'pagination',
        'type'        => 'select',
        'section' => $section,
        'choices'     => array( 
		'pagination'     => __( 'Pagination', 'peony' ),
		'infinite_scroll'     => __( 'Infinite Scroll', 'peony' ),
		),
	
	);
	
	$options['peony_excerpt_or_content'] =  array(
        'id'          => 'peony_excerpt_or_content',
        'label'      => __( 'Excerpt or Full Blog Content', 'peony' ),
        'description'        => __( 'Choose to display an excerpt or full content on blog pages.', 'peony' ),
        'default'         => 'excerpt',
        'type'        => 'select',
        'section' => $section,
        'choices'     => array( 
		'excerpt'     => __( 'Excerpt', 'peony' ),
		'full_content'     => __( 'Full Content', 'peony' ), 
		),
	
	);

	$options['peony_archive_display_image'] =  array(
        'id'          => 'peony_archive_display_image',
        'label'      => __( 'Show Featured Image?', 'peony' ),
        'description'        => __( 'Choose to display feature image in blog archive page.', 'peony' ),
        'default'         => '1',
        'type'        => 'checkbox',
        'section' => $section,
	
	);

// Blog Single Post Page Options
	$section = 'single_blog_options';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Single Post Options', 'peony' ),
		'priority' => '11',
		'description' => '',
		'panel' => $panel
	);
 

	$options[ 'peony_single_display_image'] =  array(
        'id'          => 'peony_single_display_image',
        'label'       => __( 'Show Featured Image?', 'peony' ),
        'description' => __( 'Choose to display feature image in blog posts.', 'peony' ),
        'default'     => '1',
        'type'        => 'checkbox',
        'section'     => $section,
	
      );
	
	$options['peony_display_pagination'] =  array(
        'id'          => 'peony_display_pagination',
        'label'       => __( 'Show Previous/Next Pagination?', 'peony' ),
        'description' => __( 'Choose to display previous/next pagination in blog posts.', 'peony' ),
        'default'     => '1',
        'type'        => 'checkbox',
        'section' => $section,
	
      );
	$options['peony_display_post_title'] =  array(
        'id'          => 'peony_display_post_title',
        'label'       => __( 'Show Post Title?', 'peony' ),
        'description' => __( 'Choose to display post title in blog posts.', 'peony' ),
        'default'     => '1',
        'type'        => 'checkbox',
        'section'     => $section,
	
      );
	$options['peony_display_author_info_box'] =  array(
        'id'          => 'peony_display_author_info_box',
        'label'       => __( 'Show Author Info Box?', 'peony' ),
        'description' => __( 'Choose to display author info box in blog posts.', 'peony' ),
        'default'     => '1',
        'type'        => 'checkbox',
        'section'     => $section,
        'choices'     =>  $choices
	
	);

// Blog Meta Options
    $section = 'blog_meta_options';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Blog Meta Options', 'peony' ),
		'priority' => '11',
		'description' => '',
		'panel' => $panel
	);

	$options['peony_display_post_meta'] =  array(
        'id'          => 'peony_display_post_meta',
        'label'      => __( 'Show Post Meta?', 'peony' ),
        'description'        => __( 'Choose to display post meta in blog posts.', 'peony' ),
        'default'         => '1',
        'type'        => 'checkbox',
        'section' => $section,
	
	);
	$options['peony_display_meta_author'] =  array(
        'id'          => 'peony_display_meta_author',
        'label'      => __( 'Show Post Meta Author?', 'peony' ),
        'description'        => '',
        'default'         => '1',
        'type'        => 'checkbox',
        'section' => $section,
	
	);
	$options['peony_display_meta_date'] =  array(
        'id'          => 'peony_display_meta_date',
        'label'      => __( 'Show Post Meta Date?', 'peony' ),
        'description'        => '',
        'default'         => '1',
        'type'        => 'checkbox',
        'section' => $section,
	
      );
	$options['peony_display_meta_categories'] =  array(
        'id'          => 'peony_display_meta_categories',
        'label'      => __( 'Show Post Meta Categories?', 'peony' ),
        'description'        => '',
        'default'         => '1',
        'type'        => 'checkbox',
        'section' => $section,
	);

	$options['peony_display_meta_comments'] =  array(
        'id'          => 'peony_display_meta_comments',
        'label'      => __( 'Show Post Meta Comments?', 'peony' ),
        'description'        => '',
        'default'         => '1',
        'type'        => 'checkbox',
        'section' => $section,
	
      );
	$options['peony_display_meta_readmore'] =  array(
        'id'          => 'peony_display_meta_readmore',
        'label'      => __( 'Show Post Meta Read More?', 'peony' ),
        'description'        => '',
        'default'         => '1',
        'type'        => 'checkbox',
        'section' => $section,
	
	);

### 404 Page  ###

	$section = '404-page';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Peony: 404 Page', 'peony' ),
		'priority' => '8',
		'description' => '',
	);
 
	$options['peony_page_404'] = array(
		'id' => 'peony_page_404',
		'label' => __( '404 Page Content', 'peony' ),
		'description'   => '',
		'section' => $section,
		'type'    => 'dropdown-pages',
		'default' => '',
	); 
 
 
 ##### Styling #####
	
	$panel = 'styling';

	$panels[] = array(
		'id' => $panel,
		'title' => __( 'Peony: Styling', 'peony' ),
		'priority' => '9'
	);
		
    $section = 'general-styling';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'General', 'peony' ),
		'priority' => '11',
		'description' => '',
		'panel' => $panel
	);
    $options['peony_skin'] =  array(
        'id'          => 'peony_skin',
        'label'       => __( 'Skin', 'peony' ),
        'description' => '',
        'default'     => '0',
        'type'        => 'select',
        'section'     => $section,
        'choices'     => array(0=>__( 'Light', 'peony' ),1=>__( 'Dark', 'peony' ))
      ); 
   
   //Background Colors

	$section = 'background_colors';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Background Colors', 'peony' ),
		'priority' => '11',
		'description' => '',
		'panel' => $panel
	);


	$options['peony_header_background_color'] = array(
        'id'          => 'peony_header_background_color',
        'label'      => __( 'Header Background Color', 'peony' ),
        'description'        => __( 'Set background color for header.', 'peony' ),
        'default'         => '',
        'type'        => 'color',
        'section' => $section,
      );


	$options['peony_menu_background_color'] = array(
        'id'          => 'peony_menu_background_color',
        'label'      => __( 'Menu Background Color', 'peony' ),
        'description'        => __( 'Header style 2 only.', 'peony' ),
        'default'         => '',
        'type'        => 'color',
        'section' => $section,
	);
	$options['peony_page_background_color'] =  array(
        'id'          => 'peony_page_background_color',
        'label'      => __( 'Page Background Color', 'peony' ),
        'description'        => __( 'Set background color for page content area.', 'peony' ),
        'default'         => '',
        'type'        => 'color',
        'section' => $section,
                
	);

	$options['peony_page_title_bar_background_color'] =  array(
        'id'          => 'peony_page_title_bar_background_color',
        'label'      => __( 'Page Title Bar Background Color', 'peony' ),
        'description'        => __( 'Set background color for page title bar.', 'peony' ),
        'default'         => '#f5f5f5',
        'type'        => 'color',
        'section' => $section,
	);

	$options['peony_footer_background_color'] = array(
        'id'          => 'peony_footer_background_color',
        'label'      => __( 'Footer Background Color', 'peony' ),
        'description'        => __( 'Set background color for footer.', 'peony' ),
        'default'         => '#252525',
        'type'        => 'color',
        'section' => $section,
	);
	$options['peony_copyright_background_color'] = array(
        'id'          => 'peony_copyright_background_color',
        'label'      => __( 'Copyright Area Background Color', 'peony' ),
        'description'        => __( 'Set background color for copyright area.', 'peony' ),
        'default'         => '#000000',
        'type'        => 'color',
        'section' => $section,
      );

   //Main Color

	$section = 'colors';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Main Colors', 'peony' ),
		'priority' => '12',
		'description' => '',
		'panel' => $panel
	);
   
 
	$options['peony_page_title_color'] = array(
        'id'          => 'peony_page_title_color',
        'label'      => __( 'Page Title Color', 'peony' ),
        'description'        => '',
        'default'         => '#333333',
        'type'        => 'color',
        'section' => $section,
	);
	$options['peony_breadcrumb_text_color'] = array(
        'id'          => 'peony_breadcrumb_text_color',
        'label'      => __( 'Breadcrumb Text Color', 'peony' ),
        'description'        => '',
        'default'         => '#333333',
        'type'        => 'color',
        'section' => $section,
	);
   
	$options['peony_breadcrumb_link_color'] = array(
        'id'          => 'peony_breadcrumb_link_color',
        'label'      => __( 'Breadcrumb Link Color', 'peony' ),
        'description'        => '',
        'default'         => '#333333',
        'type'        => 'color',
        'section' => $section,
	);
   
	$options['peony_copyright_color'] = array(
        'id'          => 'peony_copyright_color',
        'label'      => __( 'Footer Copyright Info Color', 'peony' ),
        'description'        => '',
        'default'         => '#ffffff',
        'type'        => 'color',
        'section' => $section,
	);
   

	$options['peony_btt_color'] = array(
        'id'          => 'peony_btt_color',
        'label'      => __( 'Back to Top Color', 'peony' ),
        'description'        => '',
        'default'         => '#ffffff',
        'type'        => 'color',
        'section' => $section,
	);
    //Element Color

	$section = 'element_color';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Element Colors', 'peony' ),
		'priority' => '13',
		'description' => '',
		'panel' => $panel
	);

	$options['peony_body_text_color'] = array(
        'id'          => 'peony_body_text_color',
        'label'      => __( 'Body Text Color', 'peony' ),
        'description'        => '',
        'default'         => '',
        'type'        => 'color',
        'section' => $section,
	);
   
	$options['peony_body_link_color'] = array(
        'id'          => 'peony_body_link_color',
        'label'      => __( 'Body Link Color', 'peony' ),
        'description'        => '',
        'default'         => '',
        'type'        => 'color',
        'section' => $section,
	);
   
	$options['peony_body_heading_color'] = array(
        'id'          => 'peony_body_heading_color',
        'label'      => __( 'Body Heading Color', 'peony' ),
        'description'        => '',
        'default'         => '#333333',
        'type'        => 'color',
        'section' => $section,
	);
	$options['peony_sidebar_widget_title_color'] = array(
        'id'          => 'peony_sidebar_widget_title_color',
        'label'      => __( 'Sidebar Widget title Color', 'peony' ),
        'description'        => '',
        'default'         => '',
        'type'        => 'color',
        'section' => $section,
	);
	$options['peony_sidebar_widget_text_color'] = array(
        'id'          => 'peony_sidebar_widget_text_color',
        'label'      => __( 'Sidebar Widget text Color', 'peony' ),
        'description'        => '',
        'default'         => '',
        'type'        => 'color',
        'section' => $section,
	);

	$options['peony_sidebar_link_color'] = array(
        'id'          => 'peony_sidebar_link_color',
        'label'      => __( 'Sidebar Link Color', 'peony' ),
        'description'        => '',
        'default'         => '',
        'type'        => 'color',
        'section' => $section,
	);


    //Menu Color

	$section = 'menu_color';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Menu Colors', 'peony' ),
		'priority' => '14',
		'description' => '',
		'panel' => $panel
	);

	$options['peony_menu_toggle_color'] = array(
        'id'          => 'peony_menu_toggle_color',
        'label'      => __( 'Menu Toggle Color', 'peony' ),
        'description'        => '',
        'default'         => '#ffffff',
        'type'        => 'color',
        'section' => $section,
	);
	$options['peony_menu_font_color'] = array(
        'id'          => 'peony_menu_font_color',
        'label'      => __( 'Menu Font Color', 'peony' ),
        'description'        => '',
        'default'         => '',
        'type'        => 'color',
        'section' => $section,
	);
	$options['peony_menu_hover_font_color'] = array(
        'id'          => 'peony_menu_hover_font_color',
        'label'      => __( 'Menu Hover Font Color', 'peony' ),
        'description'        => '',
        'default'         => '',
        'type'        => 'color',
        'section' => $section,
	);
### Typography ###
	$panel = 'typography';

	$panels[] = array(
		'id' => $panel,
		'title' => __( 'Peony: Typography', 'peony' ),
		'priority' => '10'
	);
	
 // Custom Google Fonts
  
	$section = 'load_google_fonts';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Load Google Fonts', 'peony' ),
		'priority' => '1',
		'description' => '',
		'panel' => $panel

	);
  
	$options['peony_google_fonts'] =  array(
        'id'          => 'peony_google_fonts',
        'label'       => __( 'Google Fonts ( e.g. Open+Sans:300,400,700|Lobster:400,700|Palanquin+Dark:400,70 )', 'peony' ) ,
        'description' => '',
        'default'     => 'Open+Sans:300,400,700|Lobster:400,700|Palanquin+Dark:400,70',
        'type'        => 'text',
        'section'     => $section,
        
	);
   
    //  Font Family
  
	$section = 'font_family';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Font Family', 'peony' ),
		'priority' => '2',
		'description' => '',
		'panel' => $panel

	);
   
	$options['peony_body_font'] =  array(
        'id'          => 'peony_body_font',
        'label'      => __( 'Select Body Font Family', 'peony' ),
        'description'        => __( 'Select a font family for body text.', 'peony' ),
        'default'         => '',
        'type'        => 'select',
        'section' => $section,
        'choices'     => $default_theme_fonts_option
	);
	 
	$options['peony_menu_font'] =  array(
        'id'          => 'peony_menu_font',
        'label'      => __( 'Select Menu Font Family', 'peony' ),
        'description'        => __( 'Select a font family for navigations.', 'peony' ),
        'default'         => '',
        'type'        => 'select',
        'section' => $section,
		'choices'     => $default_theme_fonts_option
	);
	
	$options['peony_headings_font'] = array(
        'id'          => 'peony_headings_font',
        'label'      => __( 'Select Headings Font Family', 'peony' ),
        'description'        => __( 'Select a font family for headings.', 'peony' ),
        'default'         => '',
        'type'        => 'select',
        'section' => $section,
        'condition'   => '',
        'choices'     => $default_theme_fonts_option
	);
	$options['peony_section_title_font'] = array(
        'id'          => 'peony_section_title_font',
        'label'      => __( 'Select Sections Title Font Family', 'peony' ),
        'description'        => __( 'Select a font family for sections title.', 'peony' ),
        'default'         => '',
        'type'        => 'select',
        'section' => $section,
        'condition'   => '',
        'choices'     => $default_theme_fonts_option
	);
	
  
  // Font Size
	 
	$section = 'font_size';
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Font Size', 'peony' ),
		'priority' => '3',
		'description' => '',
		'panel' => $panel
	);
	$options['peony_body_font_size'] =  array(
        'id'          => 'peony_body_font_size',
        'label'      => __( 'Body Font Size', 'peony' ),
        'description'        => '',
        'default'         => '14',
        'type'        => 'select',
        'section' => $section,
		'choices'     => $font_size
	);
 
	$options['peony_main_menu_font_size'] =  array(
        'id'          => 'peony_main_menu_font_size',
        'label'      => __( 'Main Menu Font Size', 'peony' ),
        'description'        => '',
        'default'         => '14',
        'type'        => 'select',
        'section' => $section,
		'choices'     => $font_size
	);

	$options['peony_secondary_menu_font_size'] =  array(
        'id'          => 'peony_secondary_menu_font_size',
        'label'      => __( 'Secondary Menu Font Size', 'peony' ),
        'description'        => '',
        'default'         => '14',
        'type'        => 'select',
        'section' => $section,
		'choices'     => $font_size
	);
	$options['peony_sidebar_heading_font_size'] =  array(
        'id'          => 'peony_sidebar_heading_font_size',
        'label'      => __( 'Sidebar Widget Heading Font Size', 'peony' ),
        'description'        => '',
        'default'         => '16',
        'type'        => 'select',
        'section' => $section,
		'choices'     => $font_size
	);
	$options['peony_sidebar_content_font_size'] =  array(
        'id'          => 'peony_sidebar_content_font_size',
        'label'      => __( 'Sidebar Widget Content Font Size', 'peony' ),
        'description'        => '',
        'default'         => '14',
        'type'        => 'select',
        'section' => $section,
		'choices'     => $font_size
	);

	$options['peony_footer_widget_heading_font_size'] =  array(
        'id'          => 'peony_footer_widget_heading_font_size',
        'label'      => __( 'Footer Widget Heading Font Size', 'peony' ),
        'description'        => '',
        'default'         => '16',
        'type'        => 'select',
        'section' => $section,
		'choices'     => $font_size
	);


	$options['peony_copyright_font_size'] =  array(
        'id'          => 'peony_copyright_font_size',
        'label'      => __( 'Copyright Font Size', 'peony' ),
        'description'        => '',
        'default'         => '12',
        'type'        => 'select',
        'section' => $section,
		'choices'     => $font_size
	);


	$options['peony_h1_font_size'] =  array(
        'id'          => 'peony_h1_font_size',
        'label'      => __( 'Heading 1 (H1) Font Size', 'peony' ),
        'description'        => '',
        'default'         => '36',
        'type'        => 'select',
        'section' => $section,
        'choices'     => $font_size
        
	);
	$options['peony_h2_font_size'] =  array(
        'id'          => 'peony_h2_font_size',
        'label'      => __( 'Heading 2 (H2) Font Size', 'peony' ),
        'description'        => '',
        'default'         => '30',
        'type'        => 'select',
        'section' => $section,
        'choices'     => $font_size
        
	);
	$options['peony_h3_font_size'] =  array(
        'id'          => 'peony_h3_font_size',
        'label'      => __( 'Heading 3 (H3) Font Size', 'peony' ),
        'description'        => '',
        'default'         => '24',
        'type'        => 'select',
        'section' => $section,
        'choices'     => $font_size
        
	);
	$options['peony_h4_font_size'] =  array(
        'id'          => 'peony_h4_font_size',
        'label'      => __( 'Heading 4 (H4) Font Size', 'peony' ),
        'description'        => '',
        'default'         => '20',
        'type'        => 'select',
        'section' => $section,
        'choices'     => $font_size
        
        
      );
	$options['peony_h5_font_size'] =  array(
        'id'          => 'peony_h5_font_size',
        'label'      => __( 'Heading 5 (H5) Font Size', 'peony' ),
        'description'        => '',
        'default'         => '18',
        'type'        => 'select',
        'section' => $section,
        'choices'     => $font_size
        
        
	);
	$options['peony_h6_font_size'] =  array(
        'id'          => 'peony_h6_font_size',
        'label'      => __( 'Heading 6 (H6) Font Size', 'peony' ),
        'description'        => '',
        'default'         => '16',
        'type'        => 'select',
        'section' => $section,
        'choices'     => $font_size
      );
	$options['peony_site_name_font_size'] =  array(
        'id'          => 'peony_site_name_font_size',
        'label'      => __( 'Header Site Name Font Size', 'peony' ),
        'description'        => '',
        'default'         => '24',
        'type'        => 'select',
        'section' => $section,
        'choices'     => $font_size
      );
	$options['peony_tagline_font_size'] =  array(
        'id'          => 'peony_tagline_font_size',
        'label'      => __( 'Header Tagline Font Size', 'peony' ),
        'description'        => '',
        'default'         => '14',
        'type'        => 'select',
        'section' => $section,
        'choices'     => $font_size
      );

	$options['peony_sections_title_font_size'] =  array(
        'id'          => 'peony_sections_title_font_size',
        'label'      => __( 'Sections Title Font Size', 'peony' ),
        'description'        => '',
        'default'         => '36',
        'type'        => 'select',
        'section' => $section,
        'choices'     => $font_size
	);


	$options['peony_sections_content_font_size'] =  array(
        'id'          => 'peony_sections_content_font_size',
        'label'      => __( 'Sections Content Font Size', 'peony' ),
        'description'        => '',
        'default'         => '14',
        'type'        => 'select',
        'section' => $section,
        'choices'     => $font_size
	);

	$options['peony_page_title_font_size'] =  array(
        'id'          => 'peony_page_title_font_size',
        'label'      => __( 'Page Title Font Size', 'peony' ),
        'description'        => '',
        'default'         => '48',
        'type'        => 'select',
        'section' => $section,
        'choices'     => $font_size
	);
	
	$options['peony_blog_subtitle_font_size'] =  array(
        'id'          => 'peony_blog_subtitle_font_size',
        'label'      => __( 'Blog Page Subtitle Font Size', 'peony' ),
        'description'        => '',
        'default'         => '18',
        'type'        => 'select',
        'section' => $section,
        'choices'     => $font_size
	);
	
	$options['peony_breadcrumb_font_size'] =  array(
        'id'          => 'peony_breadcrumb_font_size',
        'label'      => __( 'Breadcrumb Font Size', 'peony' ),
        'description'        => '',
        'default'         => '14',
        'type'        => 'select',
        'section' => $section,
        'choices'     => $font_size
	);
	$options['peony_pagination_font_size'] =  array(
        'id'          => 'peony_pagination_font_size',
        'label'      => __( 'Pagination Font Size', 'peony' ),
        'description'        => '',
        'default'         => '14',
        'type'        => 'select',
        'section' => $section,
        'choices'     => $font_size
	);
	$options['peony_post_meta_font_size'] =  array(
        'id'          => 'peony_post_meta_font_size',
        'label'      => __( 'Post Meta Font Size', 'peony' ),
        'description'        => '',
        'default'         => '14',
        'type'        => 'select',
        'section' => $section,
        'choices'     => $font_size
	);

	$peony_default_options = array();
	foreach ( (array) $options as $option ) {
		if ( ! isset( $option['id'] ) ) {
			continue;
		}
		if ( ! isset( $option['default'] ) ) {
			continue;
		}
           $peony_default_options[$option['id']] = $option['default'];
	}


	// Adds the sections to the $options array
	$options['sections'] = $sections;

	// Adds the panels to the $options array
	$options['panels'] = $panels;

	$customizer_library = Customizer_Library::Instance();
	$customizer_library->add_options( $options );

	// To delete custom mods use: customizer_library_remove_theme_mods();

}
add_action( 'init', 'peony_customizer_options' );
