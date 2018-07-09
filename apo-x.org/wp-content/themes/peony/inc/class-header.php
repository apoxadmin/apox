<?php
/**
 * MPL Header Class.
 *
 * @since 1.0
 */
 
class Peony_Template_Header {
	
	public $mpl_header_options;
	private $is_saved;
	
	public function __construct( $mpl_header_options = array() ) {

		$options = get_option('mpl_top_bar_header');
		$this->is_saved = false;

		if ( $options ){
			$options = @json_decode($options,true);
			if ( !empty($options) && $options != null )
				$this->is_saved = true;
			}
		
		$default_options = $this->get_default_options();
		
		$this->mpl_header_options = $this->array_extend((array)$default_options,(array)$options);
		
		if ( $mpl_header_options != NULL )
		$this->mpl_header_options = $this->array_extend((array)$this->mpl_header_options,(array)$mpl_header_options);
						
		add_action( 'wp_enqueue_scripts', array($this, 'enqueue_scripts') );
		add_filter('peony_header',array($this,'get_header'),10,2);
		add_filter('peony_body_class', array($this,'body_class_filter'));
		add_filter('mpl_top_bar_class', array($this,'top_bar_class'));
		add_filter('mpl_classic_nav_class', array($this,'classic_nav_class'));
		add_filter('mpl_menu_container_class', array($this,'menu_container_class'));
		add_filter('mpl_wrap_class', array($this,'wrap_class'));
		add_filter('mpl_side_wrap_class', array($this,'side_wrap_class'));
		add_filter('mpl_float_nav_class', array($this,'float_nav_class'));
		
		
	}
	
/**
 * Get default options
 */
	public function get_default_options(){
		
		$options =  array(
						  
    	'layout' => array(
            'header_layout' => 'classic',
            'classic' => array(
                    'microwidgets' => 'no',
                    'top_bar_left' => array
                        (
                            'Menu' => array
                                (
                                    'on_desktops' => 'show',
                                    'tablet' => 'leave',
                                    'style' => 'list',
                                ),

                            'Cart' => array
                                (
                                    'title' => '',
                                    'caption_align' => 'left',
                                ),

                        ),

                    'top_bar_right' => array
                        (
                            'Search' => array
                                (
                                    'caption' => '',
                                    'show_icon' => '',
                                    'on_desktops' => 'show',
                                    'tablet' => 'leave',
                                    'phone' => 'logo',
                                )

                        ),

                    'near_menu' => array
                        (
                            'Social' => array
                                (
                                    'on_desktops' => 'show',
                                    'tablet' => 'leave',
                                ),

                        ),
						
					'near_logo_left'=> array(),

                    'near_logo_right' => array
                        (
                            'Text' => array
                                (
                                    'content' => '',
                                    'on_desktops' => 'show',
                                    'tablet' => 'leave',
                                    'phone' => 'logo',
                                ),

                        ),

                    'area_near_menu' => '',
                    'area_near_logo_left' => '0px 0px 0px 0px',
                    'area_near_logo_right' => '0px 0px 0px 0px',
                    'logo_position' => 'left',
                    'menu_position' => 'left',
                    'margin_above_menu' => '',
                    'margin_below_menu' => '',
                    'header_height' => '',
                    'full_width_header' => 'disaled',
                ),
			"inline" => array(
					  "microwidgets" => "no",
					  "top_bar_left" => array(
						  "Text" => array(
							  "content" => "This is test",
							  "on_desktops" => "show",
							  "tablet" => "leave"
						  )
					  ),
					  "top_bar_right" => array(
						  "Social" => array(
							  "on_desktops" => "show",
							  "tablet" => "leave"
						  )
					  ),
					  "near_menu" => array(
						  "Cart" => array(
							  "title" => "",
							  "caption_align" => "left"
						  ),
						  "Search" => array(
							  "caption" => "",
							  "show_icon" => "",
							  "on_desktops" => "show",
							  "tablet" => "leave"
						  )
					  ),
					  "area_near_menu" => "",
					  "menu_position" => "right",
					  "header_height" => "100",
					  "full_width_header" => "disaled"
        ),
			
			"split" => array(
					  "microwidgets" => "yes",
					  "near_menu_left" => array(
						  "Search" => array(
							  "caption" => "",
							  "show_icon" => "",
							  "on_desktops" => "show",
							  "tablet" => "leave"
						  )
					  ),
					  "near_menu_right" => array(
						  "Cart" => array(
							  "title" => "",
							  "caption_align" => "left"
						  )
					  ),
					  "area_near_menu_left" => "",
					  "area_near_menu_right" => "",
					  "header_height" => "100",
					  "full_width_header" => "disabled",
					  'top_bar_left' => '',
					   'top_bar_right' => '',
        ),
			
			"side" => array(
					  "microwidgets" => "yes",
					  "below_menu" => array(
						  "Social" => array(
							  "on_desktops" => "show",
							  "tablet" => "leave"
						  ),
						  "Text" => array(
							  "content" => "",
							  "on_desktops" => "show",
							  "tablet" => "leave"
						  )
					  ),
					  "area_below_menu" => "",
					  "header_position" => "right",
					  "header_width" => "300",
					  "width_of_header_content" => "300",
					  "position_of_header_content" => "center",
					  "header_content_paddings" => "",
					  "menu_position" => "top",
					  "logo_info_position" => "edges_of_entire_content",
					  "menu_paddings" => "",
					  "menu_items_alignment" => "center",
					  "menu_itmes_link_area" => "full_width"
        ),
			
			"inline_three" => array( 
						"microwidgets" => "",
						"top_line" => 
						array( 
							  "Text" => 
							  array( 
									"content" => "",
									"on_desktops" => "show",
									"tablet" => "leave"
									)
							  ),
						"area_in_top_line" => "",
						"area_below_menu" => "",
						"below_menu" => "",
						"logo_position" => "left",
						"height" => "",
						"full_width_header" => "enabled",
						"sliding_menu_position" => "right",
						"animation" => "slide",
						"show_header" => "above",
						"floating_logo" => "enabled",
						"header_width" => "300",
						"width_of_header_content" => "300",
						"position_of_header_content" => "center",
						"header_content_paddings" => "",
						"menu_position" => "top",
						"logo_info_position" => "edges_of_menu",
						"menu_paddings" => "",
						"menu_items_alignment" => "left",
						"menu_itmes_link_area" => "full_width",
						"menu_paddings_top"=>'',
						"menu_paddings_bottom"=>''
						),

        ),
		
    	'top_bar' => array
        (
            'top_bar_font_size' => '13',
            'capitalize' => '',
            'top_bar_font_color' => '',
            'top_padding' => '8',
            'bottom_padding' => '8',
            'side_paddings' => '',
            'background_or_line' => 'content_width_line',
            'background_line_color' => '',
            'background_line_opacity' => '1',
        ),

    	'header' => array
        (
            'header_settings' => array
                (
                    'background' => array
                        (
                            'background_color' => '',
                            'background_opacity' => '1',
                            'background_image' => '',
                            'fullscreen' => 'yes',
                            'fixed_background' => 'yes',
                            'header_decoration' => 'line',
                            'line_color' => '',
                            'line_opacity' => 0,
                        ),

                    'menu' => array
                        (
                            'open_menu_icon_color' => '',
                            'open_menu_background' => '',
                            'open_menu_background_opacity' => '100',
                            'close_menu_icon_color' => '',
                            'close_menu_background' => '',
                            'close_menu_background_opacity' => '100',
                            'menu_icon_margin' => '',
                            'background_border_radius' => '0',
                        ),

                    'classic' => array
                        (
                            'menu_background_line' => 'backgrond',
                            'background_color' => '',
                            'background_opacity' => '',
                        ),

                    'sliding' => array
                        (
                            'background_color' => '',
                            'background_opacity' => '100',
                            'background_image' => '',
                            'fullscreen' => 'yes',
                            'fixed_background' => 'yes',
                        ),

                ),

        ),

    	'menu' => array
        (
            'menu_settings' => array
                (
                    'font' => array
                        (
                            'font_size' => 16,
                            'capitalize' => '',
                            'subtitles_font_size' => 11,
                            'normal_font_color' => '',
                            'hover_font_color' => 'accent',
                            'hover_custom_color' => '',
                            'hover_gradient1' => '',
                            'hover_gradient2' => '',
                            'active_item_font_color' => 'accent',
                            'active_custom_color' => '',
                            'active_gradient1' => '',
                            'active_gradient2' => '',
                            'menu_icon_size' => 0,
                            'next_level' => 'yes',
                        ),

                    'margins' => array
                        (
                            'menu_paddings' => '',
                            'margin' => '',
                            'side_margins' => 'regular',
                            'full_height' => 'enabled',
                        ),

                    'dividers' => array
                        (
                            'dividers' => 'enabled',
                            'divider_height' => '100',
                            'height' => '42',
                            'first_last_dividers' => 'enabled',
                            'dividers_color' => '',
                            'dividers_opacity' => '',
                        ),

                    'decoration' => array
                        (
                            'decoration' => 'none',
                            'underline_custom_color' => '',
                            'underline_gradient1' => '',
                            'underline_gradient2' => '',
							'hover_style' => 'outline'
                        ),

                ),

        ),

    	'sub_menu' => array
        (
            'sub_menu_settings' => array
                (
                    'font' => array
                        (
                            'font_size' => '16',
                            'capitalize' => '',
                            'subtitles_font_size' => '11',
                            'normal_font_color' => '',
                            'hover_font_color' => 'accent',
                            'active_item_font_color' => 'accent',
                            'menu_icon_size' => 0,
                            'next_level' => 'yes',
                            'parent_menu' => 'yes',
                        ),

                    'margins' => array
                        (
                            'paddings' => '8px 10px 8px 10px',
                            'margin' => '0px 0px 0px 0px',
                        ),

                    'background' => array
                        (
                            'color' => '',
                            'opacity' => 0,
                            'width' => '',
                            'hover_background' => 'disabled',
                        ),

                    'side' => array
                        (
                            'show' => 'sideways'
                        ),
					'navigation_panel' => array(
												'floating_navigation' => 'disabled',
												'effect' => 'sticky',
												'scrolling' => '',
												'height' => '',
												'background_color' => '',
												'background_opacity' => '100',
												'decoration' => '',
												'line_color' => '',
												'line_opacity' => '',
												)
						
                ),

        ),

    	'microwidgets' => array
        (
            'near_menu_font_size' => '13',
            'near_menu_font_color' => '',
            'near_logo_font_size' => '13',
            'near_logo_font_color' => '',
        ),

    	'float_header' => array
        (
            'navigation_panel' => array
                (
                    'floating_navigation' => 'enabled',
                    'effect' => 'fade',
                    'scrolling' => '',
                    'height' => '',
                    'background_color' => '',
                    'background_opacity' => 100,
                    'decoration' => 'disabled',
                    'line_color' => '',
                    'line_opacity' => '',
                )

        ),

    'mobile_header' => array
        (
            'mobile_settings' => array
                (
                    'tablet' => array
                        (
                            'switch' => 1040,
                            'height' => 60,
                        ),

                    'phone' => array
                        (
                            'switch' => 800,
                            'height' => 60,
                        ),

                    'navigation' => array
                        (
                            'floating' => 'disabled'
                        ),

                    'font' => array
                        (
                            'font_size' => 16,
                            'capitalize' => '',
                            'subtitles_font_size' => 11,
                            'normal_font_color' => '',
							'hover_font_color' => 'accent',
							'hover_custom_color' => '',
                            'hover_gradient1' => '',
                            'hover_gradient2' => '',
                            'active_item_font_color' => 'accent',
							'active_custom_color' => '',
                            'active_gradient1' => '',
                            'active_gradient2' => '',
                        ),

                    'background' => array
                        (
                            'color' => '',
                            'opacity' => '',
                            'maximum_width' => '',
                            'slides_from' => 'left'
                        ),

                )

        )
	);
	return $options ;
		
		}
	
/**
 * Enqueue header js & css
 */
 
	public function enqueue_scripts(){
		
		$new_options = $this->mpl_header_options ;
		$header_css  = '';
		
		$default_options = $this->get_default_options();
				
		$options =  $this->array_extend((array)$default_options,(array)$new_options);
			
		if ( isset($options['layout']) && is_array($options['layout']) ){
			
			$layout_name           = $options['layout']['header_layout'];
			$top_bar_options       = $options['top_bar'];
			$header_options        = $options['header'];
			$menu_options          = $options['menu'];
			$sub_menu_options      = $options['sub_menu'];
			$microwidgets_options  = $options['microwidgets'];
			$mobile_header_options = $options['mobile_header'];
			$float_header_options  = $options['float_header'];
			$layout_options        = $options['layout'][$layout_name];
						
			// header layout		
			extract($layout_options);
			
			switch ($layout_name){
				
				case "classic":
				
					if ( $area_near_menu != '' ){
						$header_css .= ".top-wrap .near-menu{\r\n";
						$header_css .= "padding: ".$area_near_menu.";\r\n";
						$header_css .= "}\r\n";
					}
					if ( $area_near_logo_left != '' ){
						$header_css .= ".top-wrap .near-logo-left{\r\n";
						$header_css .= "padding: ".$area_near_logo_left.";\r\n";
						$header_css .= "}\r\n";
					}
					
					if ( $area_near_logo_right != '' ){
						$header_css .= ".top-wrap .near-logo-right{\r\n";
						$header_css .= "padding: ".$area_near_logo_right.";\r\n";
						$header_css .= "}\r\n";
					}
					
					if ( $margin_above_menu != '' )
						$margin_above_menu = str_replace('px','',$margin_above_menu);
					if (  $margin_below_menu != '' )
						$margin_below_menu = str_replace('px','',$margin_below_menu);
					
					if ( $margin_above_menu != '' || $margin_below_menu != '' ){
						$header_css .= ".top-wrap .mpl-header:not(.mpl-side-header){\r\n";
						$header_css .= "padding-top: ".$margin_above_menu."px;\r\n";
						$header_css .= "padding-bottom: ".$margin_below_menu."px;\r\n";
						$header_css .= "}\r\n";
					}
						
					if ( $header_height != '' ){
						$header_height = str_replace('px','',$header_height);
						$header_css .= ".top-wrap .mpl-header:not(.mpl-side-header) .mpl-main-header{\r\n";
						$header_css .= "height: ".$header_height."px;\r\n";
						$header_css .= "}\r\n";
					
					}
				
				break;
				
				case "inline":
				
					if ( $area_near_menu != '' ){
						$header_css .= ".top-wrap .near-menu{\r\n";
						$header_css .= "padding: ".$area_near_menu.";\r\n";
						$header_css .= "}\r\n";
					}
					
					if ( $header_height != '' ){
						$header_height = str_replace('px','',$header_height);
						$header_css .= ".mpl-header-main .mpl-header .mpl-main-header{\r\n";
						$header_css .= "height: ".$header_height."px;\r\n";
						$header_css .= "}\r\n";
					
					}
					break;
				
				case "split":
				
					if ( $area_near_menu_left != '' ){
						$header_css .= ".top-wrap .near-menu-left{\r\n";
						$header_css .= "padding: ".$area_near_menu_left.";\r\n";
						$header_css .= "}\r\n";
					}
					
					if ( $area_near_menu_right != '' ){
						$header_css .= ".top-wrap .near-menu-right{\r\n";
						$header_css .= "padding: ".$area_near_menu_right.";\r\n";
						$header_css .= "}\r\n";
					}
					if ( $header_height != '' ){
						$header_height = str_replace('px','',$header_height);
						$header_css .= ".mpl-header-main .mpl-header .mpl-main-header{\r\n";
						$header_css .= "height: ".$header_height."px;\r\n";
						$header_css .= "}\r\n";
					
					}
				
				break;
				
				case "side":
				
					if ( $area_below_menu != '' ){
						$header_css .= ".top-wrap .near-below-menu{\r\n";
						$header_css .= "padding: ".$area_below_menu.";\r\n";
						$header_css .= "}\r\n";
					}
					if ( $header_width != '' ){
						$header_css .= ".mpl-header.mpl-side-header{\r\n";
						$header_css .= "width: ".$header_width.";\r\n";
						$header_css .= "}\r\n";
					
					}
				
					if ( $width_of_header_content != '' ){
						$header_css .= ".top-wrap .mpl-header .mpl-main-header{\r\n";
						$header_css .= "width: ".$width_of_header_content.";\r\n";
						$header_css .= "}\r\n";
					
					}
					if ( $menu_paddings_top != '' ){
						$header_css .= ".top-wrap .mpl-main-nav{\r\n";
						$header_css .= "padding-top: ".$menu_paddings_top.";\r\n";
						$header_css .= "}\r\n";
					}
					if ( $menu_paddings_bottom != '' ){
						$header_css .= ".top-wrap .mpl-main-nav{\r\n";
						$header_css .= "padding-bottom: ".$menu_paddings_bottom.";\r\n";
						$header_css .= "}\r\n";
					}
				
				
				break;
				
				case "inline_three":
				
							
					if ( $area_in_top_line != '' ){
						$header_css .= ".top-wrap .area-in-top-line{\r\n";
						$header_css .= "padding: ".$area_in_top_line.";\r\n";
						$header_css .= "}\r\n";
					}
					
					if ( $area_below_menu != '' ){
						$header_css .= ".top-wrap .area-below-menu{\r\n";
						$header_css .= "padding: ".$area_below_menu.";\r\n";
						$header_css .= "}\r\n";
					}
					
					
					if ( $height != '' ){
						$height = str_replace('px','',$height);
						$header_css .= ".top-wrap .mpl-mixed-header .mpl-main-header{\r\n";
						$header_css .= "height: ".$height."px;\r\n";
						$header_css .= "}\r\n";
					
					}
					if ( $header_width != '' ){
						$header_css .= ".top-wrap .mpl-side-header:not(.mpl-side-header-overlay){\r\n";
						$header_css .= "width: ".$header_width.";\r\n";
						$header_css .= "}\r\n";
					
					}
				
					if ( $width_of_header_content != '' ){
						$header_css .= ".top-wrap .mpl-side-header:not(.mpl-side-header-overlay) .mpl-main-header{\r\n";
						$header_css .= "width: ".$width_of_header_content.";\r\n";
						$header_css .= "}\r\n";
					
					}
					
					if ( $header_content_paddings != '' ){
						$header_css .= ".top-wrap .mpl-side-header .mpl-main-header{\r\n";
						$header_css .= "padding: ".$header_content_paddings.";\r\n";
						$header_css .= "}\r\n";
					 }
					if ( $menu_paddings_top != '' ){
						$header_css .= ".top-wrap .mpl-main-nav{\r\n";
						$header_css .= "padding-top: ".$menu_paddings_top.";\r\n";
						$header_css .= "}\r\n";
					}
					if ( $menu_paddings_bottom != '' ){
						$header_css .= ".top-wrap .mpl-main-nav{\r\n";
						$header_css .= "padding-bottom: ".$menu_paddings_bottom.";\r\n";
						$header_css .= "}\r\n";
					}
				
				break;
				
				}
							
			// top bar styling
			extract($top_bar_options);
			
			$header_css .= ".mpl-top-bar{\r\n";
			 if ( is_numeric($top_padding) ){
				 $header_css .= "padding-top:".$top_padding."px;";
				 }
			if ( is_numeric($bottom_padding) ){
				 $header_css .= "padding-bottom:".$bottom_padding."px;";
				 }
			if ( is_numeric($side_paddings) ){
				 $header_css .= "padding-left:".$side_paddings."px;";
				 $header_css .= "padding-right:".$side_paddings."px;";
				 }
			 $header_css .= "}\r\n";
			 
			 $header_css .= ".mpl-top-bar,.mpl-top-bar a,.mpl-top-bar span,.mpl-top-bar .mpl-f-microwidget,.mpl-top-bar .mpl-search-label:before{\r\n";
			 
			 if ( is_numeric($top_bar_font_size) ){
				 $header_css .= "font-size:".$top_bar_font_size."px !important;";
				 }
			 if ( $capitalize == 'yes' ){
				 $header_css .= "text-transform:capitalize !important;";
				 }
			 if ( $top_bar_font_color != '' ){
				 $header_css .= "color:".$top_bar_font_color.";";
				 }
			 $header_css .= "}\r\n";
			 		 
			// header styling
			 extract($header_options);	
			 if ( isset($header_settings) && is_array($header_settings) ){
				 
				 // header background
				 extract($header_settings['background']);
				 
				 if ( isset($header_settings['background']['background_color']) && $header_settings['background']['background_color'] != '' ){
					$color = $this->hex2rgb($header_settings['background']['background_color']);
					$opacity = (absint($header_settings['background']['background_opacity'])/100);
					$header_css .= ".top-wrap .mpl-header:not(.mpl-side-header){\r\n";
					$header_css .= "background-color: rgba(".$color[0].",".$color[1].",".$color[2].",".$opacity.");\r\n";
					$header_css .= "}\r\n";
			 	 }
				 
				 if ( $background_image != '' ){
					$header_css .= ".top-wrap .mpl-header:not(.mpl-side-header){\r\n";
					$header_css .= "background-image: url(".$background_image.");\r\n";
					$header_css .= "}\r\n";
			 	 }
				 
				 if ( $fullscreen == 'yes' ){
					$header_css .= ".top-wrap .mpl-header:not(.mpl-side-header){\r\n";
					$header_css .= "-webkit-background-size:cover;\r\n";
					$header_css .= "-moz-background-size:cover;\r\n";
					$header_css .= "-o-background-size:cover;\r\n";
					$header_css .= "background-size:cover;\r\n";
					$header_css .= "}\r\n";
			 	 }
				 
				 if ( $fixed_background == 'yes' ){
					$header_css .= ".top-wrap .mpl-header:not(.mpl-side-header){\r\n";
					$header_css .= "background-attachment: fixed;\r\n";
					$header_css .= "}\r\n";
			 	 }
				 
				 if ( isset($line_color) && $line_color != '' ){
					$color = $this->hex2rgb($line_color);
					$opacity = (absint($line_opacity)/100);
					$header_css .= ".mpl-header.border:not(.mpl-side-header):not(.mpl-mixed-header){\r\n";
					$header_css .= "border-color: rgba(".$color[0].",".$color[1].",".$color[2].",".$opacity.");\r\n";
					$header_css .= "}\r\n";
			 	 }
				 
				 // menu icon
				 extract($header_settings['menu']);
				 
				 if ( $open_menu_icon_color != '' ){
					$header_css .= ".mpl-menu-toggle .mpl-line,.mpl-toggle-icon:before, .mpl-toggle-icon:after{\r\n";
					$header_css .= "background-color: ".$open_menu_icon_color.";\r\n";
					$header_css .= "}\r\n";
			 	 }
				 if ( $close_menu_icon_color != '' ){
					$header_css .= ".mpl-close-toggle .mpl-line:before, .mpl-close-toggle .mpl-line:after{\r\n";
					$header_css .= "background-color: ".$close_menu_icon_color.";\r\n";
					$header_css .= "}\r\n";
			 	 }
				 if ( $open_menu_background != '' ){
					$color = $this->hex2rgb($open_menu_background);
					$opacity = (absint($open_menu_background_opacity)/100);
					$header_css .= ".mpl-menu-toggle .mpl-toggle-icon{\r\n";
					$header_css .= "background-color: rgba(".$color[0].",".$color[1].",".$color[2].",".$opacity.") ;\r\n";
					$header_css .= "}\r\n";
			 	 }
				 
				 if ( $close_menu_background != '' ){
					$color = $this->hex2rgb($close_menu_background);
					$opacity = (absint($close_menu_background_opacity)/100);
					$header_css .= ".mpl-close-toggle{\r\n";
					$header_css .= "background-color: rgba(".$color[0].",".$color[1].",".$color[2].",".$opacity.") ;\r\n";
					$header_css .= "}\r\n";
			 	 }
				 
				 if ( $menu_icon_margin != '' ){
					$header_css .= ".mpl-menu-toggle{\r\n";
					$header_css .= "margin: ".$menu_icon_margin." ;\r\n";
					$header_css .= "}\r\n";
			 	 }
				 
				 if ( is_numeric($background_border_radius) ){
					$header_css .= ".mpl-menu-toggle .mpl-toggle-icon,.mpl-close-toggle{\r\n";
					$header_css .= "border-radius: ".$background_border_radius."px;\r\n";
					$header_css .= "}\r\n";
			 	 }	
				 
				 // classic menu 				 
				 if ( $header_settings['classic']['background_color'] && $header_settings['classic']['background_color'] != '' ){
					 
					$color = $this->hex2rgb($header_settings['classic']['background_color']);
					$opacity = (absint($header_settings['classic']['background_opacity'])/100);
					$header_css .= ".mpl-navigation.mpl-style-solid-bg:before{\r\n";
					$header_css .= "background-color: rgba(".$color[0].",".$color[1].",".$color[2].",".$opacity.") ;\r\n";
					$header_css .= "}\r\n";
					$header_css .= ".mpl-navigation.mpl-style-top-line:before,\r\n";
					$header_css .= ".mpl-navigation.mpl-style-top-line-full:before {\r\n";
					$header_css .= "background-color:rgba(".$color[0].",".$color[1].",".$color[2].",".$opacity.");\r\n";
					$header_css .= "}\r\n";
			 	 }
				 
				 // Sliding Menu
				 extract($header_settings['sliding']);
				 
				 if ( isset($header_settings['sliding']['background_color']) && $header_settings['sliding']['background_color'] != '' ){
					$color = $this->hex2rgb($header_settings['sliding']['background_color']);
					$opacity = (absint($header_settings['sliding']['background_opacity'])/100);
					$header_css .= ".top-wrap .mpl-side-header{\r\n";
					$header_css .= "background-color: rgba(".$color[0].",".$color[1].",".$color[2].",".$opacity.");\r\n";
					$header_css .= "}\r\n";
			 	 }
				 
				 $header_css .= ".top-wrap .mpl-side-header{\r\n";
				 
				 if ( isset($header_settings['sliding']['background_image']) && $header_settings['sliding']['background_image'] != '')
					$header_css .= "background-image: url(".$header_settings['sliding']['background_image'].");\r\n";
				 if ( isset($header_settings['sliding']['fullscreen']) && $header_settings['sliding']['fullscreen'] == 'yes' ){
					
					$header_css .= "-webkit-background-size:cover;\r\n";
					$header_css .= "-moz-background-size:cover;\r\n";
					$header_css .= "-o-background-size:cover;\r\n";
					$header_css .= "background-size:cover;\r\n";
			 	 }
				 
			
				 $header_css .= "}\r\n";
								
			 	}
				
			// menu styling
			
			 extract($menu_options);
			 if ( isset($menu_settings) && is_array($menu_settings) ){
				 
				 // fonts
				  extract($menu_settings['font']);
				  
				  if ( is_numeric($font_size) ){
					$header_css .= ".mpl-header .mpl-main-nav > li > a{\r\n";
					$header_css .= "font-size: ".$font_size."px;\r\n";
					$header_css .= "}\r\n";
			 	 }
				 if ( $capitalize == 'yes' ){
					$header_css .= ".mpl-header .mpl-main-nav > li > a{\r\n";
					$header_css .= "text-transform:capitalize;";
					$header_css .= "}\r\n";
			 	 }
				 
				 if ( $normal_font_color !='' ){
					$header_css .= ".mpl-header .mpl-main-nav > li > a{\r\n";
					$header_css .= "color: ".$normal_font_color.";\r\n";
					$header_css .= "}\r\n";
			 	 }
				 
				 if ( $hover_font_color == 'color' ){
				
				 if ( $hover_custom_color !='' ){
					$header_css .= ".mpl-header .mpl-main-nav > li > a:hover{\r\n";
					$header_css .= "color: ".$hover_custom_color.";\r\n";
					$header_css .= "}\r\n";
			 	 }
				 }
				 
				 if ( $hover_font_color == 'gradient' ){
				
					 if ( $hover_gradient1 !='' && $hover_gradient2 !='' ){
						$header_css .= ".mpl-header .mpl-main-nav > li > a:hover span{\r\n";
	
						$header_css .= "
						  color: ".$hover_gradient1.";
						  background: -webkit-gradient(linear,left top,right top,color-stop(32%,".$hover_gradient1."),color-stop(100%,".$hover_gradient2."));
						  background: -webkit-linear-gradient(left,".$hover_gradient1." 32%,".$hover_gradient2." 100%);
						  -webkit-background-clip: text;
						  -webkit-text-fill-color: transparent;";
	
						$header_css .= "}\r\n";
					 }
				 }
				 
				  if ( isset($active_item_font_color) && $active_item_font_color == 'color' ){
				
					 if ( $active_custom_color !='' ){
						$header_css .= ".mpl-header .mpl-main-nav > li.current-menu-item > a{\r\n";
						$header_css .= "color: ".$active_custom_color.";\r\n";
						$header_css .= "}\r\n";
					 }
					 if ( $menu_icon_size !='' ){
						$header_css .= ".mpl-header .mpl-main-nav > li.current-menu-item > a > i{\r\n";
						$header_css .= "font-size: ".$menu_icon_size."px;\r\n";
						$header_css .= "}\r\n";
					 }
				 
				 }
				 
				 
				 if ( isset($active_item_font_color) && $active_item_font_color == 'gradient' ){
				
					 if ( $active_gradient1 !='' && $active_gradient2 !='' ){
						$header_css .= ".mpl-header .mpl-main-nav > li.current-menu-item > a span{\r\n";
	
						$header_css .= "color: ".$active_gradient1.";
						  background: -webkit-gradient(linear,left top,right top,color-stop(32%,".$active_gradient1."),color-stop(100%,".$active_gradient2."));
						  background: -webkit-linear-gradient(left,".$active_gradient1." 32%,".$active_gradient2." 100%);
						  -webkit-background-clip: text;
						  -webkit-text-fill-color: transparent;";
	
						$header_css .= "}\r\n";
					 }
				 }
				 
				 
				 if ( isset($next_level) && $next_level == 'yes' ){
				 
				 $header_css .= ".mpl-header .mpl-main-nav > li.menu-item-has-children > a:after{\r\n";
				 $header_css .= "padding-left: 6px; font-family: FontAwesome;content: \"\\f105\";";
				 $header_css .= "}\r\n";
				 
				 }
				 
				 // margin
				 if ( isset($menu_settings['margins']['paddings']) && $menu_settings['margins']['paddings'] != '' ){
					 
					 $header_css .= ".mpl-header .mpl-main-nav > li > a{";
					 $header_css .= "padding:".$menu_settings['margins']['paddings'].";";
					 $header_css .= "}\r\n";
				 }
				  if ( isset($menu_settings['margins']['margin']) && $menu_settings['margins']['margin'] != '' ){
					 
					 $header_css .= ".mpl-header .mpl-main-nav > li > a{";
					 $header_css .= "margin:".$menu_settings['margins']['margin'].";";
					 $header_css .= "}\r\n";
				 }
				 
				 // dividers
				 
				  if ( isset($menu_settings['dividers']['divider_height']) && $menu_settings['dividers']['divider_height'] == 'custom' ){
					  					 
					 $header_css .= ".mpl-header:not(.mpl-side-header).dividers .mpl-main-nav > li:before, .mpl-header:not(.mpl-side-header).dividers.surround .mpl-main-nav > li:last-child:after{";
					 $header_css .= "height:".$menu_settings['dividers']['height']."px;";
					 $header_css .= "}\r\n";
				 }
				 
				  if ( isset($menu_settings['dividers']['dividers_color']) && $menu_settings['dividers']['dividers_color'] != '' ){
					 
					$color = $this->hex2rgb($menu_settings['dividers']['dividers_color']);
					$opacity = (absint($menu_settings['dividers']['dividers_opacity'])/100);
					$header_css .= ".mpl-header:not(.mpl-side-header).dividers .mpl-main-nav > li:before, .mpl-header:not(.mpl-side-header).dividers.surround .mpl-main-nav > li:last-child:after{\r\n";
					$header_css .= "border-right-color: rgba(".$color[0].",".$color[1].",".$color[2].",".$opacity.");\r\n";
					$header_css .= "border-left-color: rgba(".$color[0].",".$color[1].",".$color[2].",".$opacity.");\r\n";
					$header_css .= "}\r\n";
					
					 }  
					 
				// decoration
				
				extract($menu_settings['decoration']);
				
				 if ( $underline_custom_color !='' ){
					$color = $this->hex2rgb($underline_custom_color);
					$header_css .= ".hoverline-lefttoright > li > a > span:before,\r\n
					.hoverline-fromcenter > li > a > span:before,\r\n
.hoverline-upwards > li > a > span:before,\r\n
.hoverline-downwards > li > a > span:before{\r\n";
					$header_css .= "background-color: ".$underline_custom_color.";\r\n";
					$header_css .= "}\r\n";
					
					$header_css .= ".mpl-header .hoverbg > li:not(.active) > a:hover, .mpl-header .hoverbg > li.menu-item-hoverd:not(.active) > a{\r\n";
					$header_css .= "background-color: rgba(".$color[0].",".$color[1].",".$color[2].",0.1);\r\n";
					$header_css .= "}\r\n";
					$header_css .= ".mpl-header .hoveroutline > li:not(.active) > a:hover, .mpl-header .hoveroutline > li.menu-item-hoverd:not(.active) > a {\r\n";
					$header_css .= "border-color: ".$underline_custom_color.";\r\n";
					$header_css .= "}\r\n";

			 	 }
				  
			 }
			 
			 // submenu styling
			 extract($sub_menu_options);
			 			 
			 if ( isset($sub_menu_settings) && is_array($sub_menu_settings) ){
				
				 // fonts
				  extract($sub_menu_settings['font']);
				  
				  if ( is_numeric($font_size) ){
					$header_css .= ".mpl-header .mpl-main-nav > li li a{\r\n";
					$header_css .= "font-size: ".$font_size."px;\r\n";
					$header_css .= "}\r\n";
			 	 }
				 if ( $capitalize == 'yes' ){
					$header_css .= ".mpl-header .mpl-main-nav > li li a{\r\n";
					$header_css .= "text-transform:capitalize;";
					$header_css .= "}\r\n";
			 	 }
				 
				 
				 if ( $normal_font_color !='' ){
					$header_css .= ".mpl-header .mpl-main-nav > li li a{\r\n";
					$header_css .= "color: ".$normal_font_color.";\r\n";
					$header_css .= "}\r\n";
			 	 }
				 
				 if ( $hover_font_color == 'color' ){
				
				 if ( $hover_custom_color !='' ){
					$header_css .= ".mpl-header .mpl-main-nav > li li a:hover{\r\n";
					$header_css .= "color: ".$hover_custom_color.";\r\n";
					$header_css .= "}\r\n";
			 	 }
				 }
				 
				 if ( $hover_font_color == 'gradient' ){
				
					 if ( $hover_gradient1 !='' && $hover_gradient2 !='' ){
						$header_css .= ".mpl-header .mpl-main-nav > li li a:hover span{\r\n";
	
						$header_css .= "
						  color: ".$hover_gradient1.";
						  background: -webkit-gradient(linear,left top,right top,color-stop(32%,".$hover_gradient1."),color-stop(100%,".$hover_gradient2."));
						  background: -webkit-linear-gradient(left,".$hover_gradient1." 32%,".$hover_gradient2." 100%);
						  -webkit-background-clip: text;
						  -webkit-text-fill-color: transparent;";
	
						$header_css .= "}\r\n";
					 }
				 }
				 
				  if ( isset($active_item_font_color) && $active_item_font_color == 'color' ){
				
					 if ( $active_custom_color !='' ){
						$header_css .= ".mpl-header .mpl-main-nav > li li.current-menu-item > a{\r\n";
						$header_css .= "color: ".$active_custom_color.";\r\n";
						$header_css .= "}\r\n";
					 }
					 if ( $menu_icon_size !='' ){
						$header_css .= ".mpl-header .mpl-main-nav > li li.current-menu-item > a > i{\r\n";
						$header_css .= "font-size: ".$menu_icon_size."px;\r\n";
						$header_css .= "}\r\n";
					 }
				 
				 }
				 
				 
				 if ( isset($active_item_font_color) && $active_item_font_color == 'gradient' ){
				
					 if ( $active_gradient1 !='' && $active_gradient2 !='' ){
						$header_css .= ".mpl-header .mpl-main-nav > li li.current-menu-item > a span{\r\n";
	
						$header_css .= "
						  color: ".$active_gradient1.";
						  background: -webkit-gradient(linear,left top,right top,color-stop(32%,".$active_gradient1."),color-stop(100%,".$active_gradient2."));
						  background: -webkit-linear-gradient(left,".$active_gradient1." 32%,".$active_gradient2." 100%);
						  -webkit-background-clip: text;
						  -webkit-text-fill-color: transparent;";
	
						$header_css .= "}\r\n";
					 }
				 }
				 
				 if ( isset($next_level) && $next_level == 'yes' ){
				 
				 	$header_css .= ".mpl-header .mpl-main-nav > li li.menu-item-has-children > a:after{\r\n";
					$header_css .= "padding-left: 6px; font-family: FontAwesome;content: \"\\f105\";";
					$header_css .= "}\r\n";
				 }
				 
				 // margin
				 if ( isset($sub_menu_settings['margins']['paddings']) && $sub_menu_settings['margins']['paddings'] != '' ){
					 
					 $header_css .= ".mpl-main-nav .sub-menu li a, .mpl-mobile-main-nav .sub-menu li a, .mpl-micronav .sub-menu li a{";
					 $header_css .= "padding:".$sub_menu_settings['margins']['paddings'].";";
					 $header_css .= "}\r\n";
				 }
				  if ( isset($sub_menu_settings['margins']['margin']) && $sub_menu_settings['margins']['margin'] != '' ){
					 
					 $header_css .= ".mpl-main-nav .sub-menu li a, .mpl-mobile-main-nav .sub-menu li a, .mpl-micronav .sub-menu li a{";
					 $header_css .= "margin:".$sub_menu_settings['margins']['margin'].";";
					 $header_css .= "}\r\n";
				 }
				 
				 // background
				 
				  if ( isset($sub_menu_settings['background']['color']) && $sub_menu_settings['background']['color'] != '' ){
					 
					$color = $this->hex2rgb($sub_menu_settings['background']['color']);
					$opacity = (absint($sub_menu_settings['background']['opacity'])/100);
					$header_css .= ".mpl-header:not(.mpl-side-header) .mpl-main-nav .sub-menu{\r\n";
					$header_css .= "background-color: rgba(".$color[0].",".$color[1].",".$color[2].",".$opacity.");\r\n";
					$header_css .= "}\r\n";
				 }
				 if ( isset($sub_menu_settings['background']['width']) && is_numeric($sub_menu_settings['background']['width']) ){
					 
					$header_css .= ".mpl-header:not(.mpl-side-header) .mpl-main-nav .sub-menu{\r\n";
					$header_css .= "width: ".$sub_menu_settings['background']['width']."px;\r\n";
					$header_css .= "}\r\n";
				 }
				 
				 // microwidgets
				 extract($microwidgets_options);
				 
				 if ( is_numeric($near_menu_font_size) ){
					 
					$header_css .= ".mpl-header .near-menu,.mpl-header .near-menu i,.mpl-header .near-menu a,.mpl-header .near-menu span{\r\n";
					$header_css .= "font-size: ".$near_menu_font_size."px;\r\n";
					$header_css .= "}\r\n";
					 
					 }
					 
				if ( $near_menu_font_color !='' ){
					 
					$header_css .= ".mpl-header .near-menu,.mpl-header .near-menu i,.mpl-header .near-menu a{\r\n";
					$header_css .= "color: ".$near_menu_font_color.";\r\n";
					$header_css .= "}\r\n";
					 
					 }
					 
				if ( is_numeric($near_logo_font_size) ){
					 
					$header_css .= ".mpl-header .near-logo-left,.mpl-header .near-logo-right{\r\n";
					$header_css .= "font-size: ".$near_logo_font_size."px;\r\n";
					$header_css .= "}\r\n";
					 
					 }
					 
				if ( $near_logo_font_color !='' ){
					 
					$header_css .= ".mpl-header .near-logo-left,.mpl-header .near-logo-right{\r\n";
					$header_css .= "color: ".$near_logo_font_color.";\r\n";
					$header_css .= "}\r\n";
					 
					 }
					 
				// Float Header

				if ( $float_header_options['navigation_panel']['background_color'] !='' ){
										
					$color = $this->hex2rgb($float_header_options['navigation_panel']['background_color']);
					$opacity = (absint($float_header_options['navigation_panel']['background_opacity'])/100);
					$header_css .= ".top-wrap .mpl-fxd-header-wrap .mpl-header{\r\n";
					$header_css .= "background-color: rgba(".$color[0].",".$color[1].",".$color[2].",".$opacity.");\r\n";
					$header_css .= "}\r\n";
					
					}
					
				if ( is_numeric($float_header_options['navigation_panel']['height']) ){
					
					$header_css .= ".top-wrap .mpl-fxd-header-wrap .mpl-main-header{\r\n";
					$header_css .= "height:".$float_header_options['navigation_panel']['height']."px;\r\n";
					$header_css .= "}\r\n";
					
					}
					
				if ( $float_header_options['navigation_panel']['decoration'] =='shadow'){
					
					$header_css .= ".top-wrap .mpl-fxd-header-wrap .mpl-header{\r\n";
					$header_css .= "-webkit-box-shadow: 1px 1px 4px 1px rgba(0,0,0,0.1);\r\n";
					$header_css .= "box-shadow: 1px 1px 4px 1px rgba(0,0,0,0.1);\r\n";
					$header_css .= "}\r\n";
					
					}
					
				if ( isset($float_header_options['navigation_panel']) && $float_header_options['navigation_panel']['decoration'] =='line'){
					
					$color = $this->hex2rgb($float_header_options['navigation_panel']['line_color']);
					$opacity = (absint($float_header_options['navigation_panel']['line_opacity'])/100);
					$header_css .= ".top-wrap .mpl-fxd-header-wrap .mpl-header.border{\r\n";
					$header_css .= "border-bottom-color:rgba(".$color[0].",".$color[1].",".$color[2].",".$opacity.");\r\n";
					$header_css .= "}\r\n";
					
					}
					 
					$header_css .= ".mpl-side-header-overlay {display:none;}";
					
				// Mobile Header
				 extract($mobile_header_options);
				 
				 if ( isset($mobile_settings) && is_array($mobile_settings) ){
					 
					 $tablet_switch = $mobile_settings['tablet']['switch'];
					 $tablet_height = $mobile_settings['tablet']['height'];
					 $phone_switch  = $mobile_settings['phone']['switch'];
					 $phone_height  = $mobile_settings['phone']['height'];
					 
					extract($mobile_settings['font']);
					
					 $header_css .= ".mpl-mobile-side-header li a span{\r\n";
					 if (is_numeric($font_size))
					 $header_css .= "font-size: ".$font_size."px;\r\n";
					 if ($capitalize == 'yes')
					 $header_css .= "text-transform:capitalize;";
					 if ($normal_font_color != '')
					 $header_css .= "color: ".$normal_font_color.";\r\n";
					 
					 if ( $hover_font_color == 'color' ){
				
						 if ( $hover_custom_color !='' ){
							$header_css .= "color: ".$hover_custom_color.";\r\n";
						 }
					 }
					 if ( isset($hover_font_color) && $hover_font_color == 'gradient' ){
				
					 if ( $hover_gradient1 !='' && $hover_gradient2 !='' ){	
						$header_css .= "color: ".$hover_gradient1.";
						  background: -webkit-gradient(linear,left top,right top,color-stop(32%,".$hover_gradient1."),color-stop(100%,".$hover_gradient2."));
						  background: -webkit-linear-gradient(left,".$hover_gradient1." 32%,".$hover_gradient2." 100%);
						  -webkit-background-clip: text;
						  -webkit-text-fill-color: transparent;";
	
					 }
				 }
				 
				 
					 $header_css .= "}\r\n";
					 
					  if ( isset($active_item_font_color) && $active_item_font_color == 'gradient' ){
				
					 if ( $active_gradient1 !='' && $active_gradient2 !='' ){
						$header_css .= ".mpl-mobile-side-header li.current-menu-item > a span{\r\n";
	
						$header_css .= "color: ".$active_gradient1.";
						  background: -webkit-gradient(linear,left top,right top,color-stop(32%,".$active_gradient1."),color-stop(100%,".$active_gradient2."));
						  background: -webkit-linear-gradient(left,".$active_gradient1." 32%,".$active_gradient2." 100%);
						  -webkit-background-clip: text;
						  -webkit-text-fill-color: transparent;";
	
						$header_css .= "}\r\n";
					 }
				 }
					 
				
				
				if (is_numeric($tablet_switch) && $tablet_switch>0){
					
					$header_css .= "@media screen and (min-width: ".$tablet_switch."px) {
					.hide-on-desktop {
						display: none;
					  }
				}";
					
					$header_css .= "@media screen and (max-width: ".$tablet_switch."px) {
					.mpl-header:not(.mpl-side-header) .mpl-main-header {
						display: none;
					}
					.mpl-mobile-main-header {
						display: -webkit-flex;
						display: -moz-flex;
						display: -ms-flexbox;
						display: -ms-flex;
						display: flex;
					}
				}";
				}
				
				if (is_numeric($tablet_switch) && is_numeric($phone_switch) ){
					$header_css .= "@media screen and (max-width: ".$tablet_switch."px) and (min-width: ".$phone_switch."px) {
						
						.hide-on-first-switch,
						.mpl-mobile-main-header .hide-on-first-switch {
						  display: none;
						}
											  
						.in-menu-first-switch {
						  display: none;
						}
					.mpl-mobile-main-header{
						height:".$tablet_height."px;
						}
					 .tablet-logoright-toggleleft .mpl-mobile-main-header .mpl-logo {
					  -webkit-order: 3;
					  -moz-order: 3;
					  -ms-flex-order: 3;
					  order: 3;
				  }
				  .tablet-logoright-toggleleft .mpl-mobile-main-header .mpl-menu-toggle {
					  -webkit-order: 1;
					  -moz-order: 1;
					  -ms-flex-order: 1;
					  order: 1;
				  }
				  .tablet-logoright-toggleleft .mpl-mobile-main-header .mpl-f-microwidgets {
					  -webkit-order: 2;
					  -moz-order: 2;
					  -ms-flex-order: 2;
					  order: 2;
					  -webkit-flex-grow: 10;
					  -moz-flex-grow: 10;
					  -ms-flex-positive: 10;
					  -ms-flex-grow: 10;
					  flex-grow: 10;
					  padding-left: 40px;
				  }
			  
				  .tablet-logocenter-toggleleft .mpl-mobile-main-header .mpl-logo {
					  -webkit-order: 1;
					  -moz-order: 1;
					  -ms-flex-order: 1;
					  order: 1;
				  }
				  .tablet-logocenter-toggleleft .mpl-mobile-main-header .mpl-menu-toggle {
					  -webkit-flex: 1 1 0%;
					  -moz-flex: 1 1 0%;
					  -ms-flex: 1 1 0%;
					  flex: 1 1 0%;
				  }
				  .tablet-logocenter-toggleleft .mpl-mobile-main-header .mpl-f-microwidgets {
					  -webkit-flex: 1 1 0%;
					  -moz-flex: 1 1 0%;
					  -ms-flex: 1 1 0%;
					  flex: 1 1 0%;
					  -webkit-flex-flow: row wrap;
					  -moz-flex-flow: row wrap;
					  -ms-flex-flow: row wrap;
					  flex-flow: row wrap;
					  -webkit-justify-content: flex-end;
					  -moz-justify-content: flex-end;
					  -ms-flex-pack: flex-end;
					  -ms-justify-content: flex-end;
					  justify-content: flex-end;
					  -ms-flex-pack: end;
					  -webkit-order: 2;
					  -moz-order: 2;
					  -ms-flex-order: 2;
					  order: 2;
				  }
			  
				  .tablet-logoleft-toggleright .mpl-mobile-main-header .mpl-logo {
					  -webkit-order: 1;
					  -moz-order: 1;
					  -ms-flex-order: 1;
					  order: 1;
				  }
				  .tablet-logoleft-toggleright .mpl-mobile-main-header .mpl-menu-toggle {
					  -webkit-order: 3;
					  -moz-order: 3;
					  -ms-flex-order: 3;
					  order: 3;
				  }
				  .tablet-logoleft-toggleright .mpl-mobile-main-header .mpl-f-microwidgets {
					  -webkit-order: 2;
					  -moz-order: 2;
					  -ms-flex-order: 2;
					  order: 2;
					  -webkit-flex-grow: 10;
					  -moz-flex-grow: 10;
					  -ms-flex-positive: 10;
					  -ms-flex-grow: 10;
					  flex-grow: 10;
					  padding-right: 40px;
					  -webkit-justify-content: flex-end;
					  -moz-justify-content: flex-end;
					  -ms-flex-pack: flex-end;
					  -ms-justify-content: flex-end;
					  justify-content: flex-end;
					  -ms-flex-pack: end;
				  }
			  
				  .tablet-logocenter-toggleright .mpl-mobile-main-header .mpl-logo {
					  -webkit-order: 1;
					  -moz-order: 1;
					  -ms-flex-order: 1;
					  order: 1;
				  }
				  .tablet-logocenter-toggleright .mpl-mobile-main-header .mpl-menu-toggle {
					  -webkit-flex: 1 1 0%;
					  -moz-flex: 1 1 0%;
					  -ms-flex: 1 1 0%;
					  flex: 1 1 0%;
					  -webkit-flex-flow: row wrap;
					  -moz-flex-flow: row wrap;
					  -ms-flex-flow: row wrap;
					  flex-flow: row wrap;
					  -webkit-justify-content: flex-end;
					  -moz-justify-content: flex-end;
					  -ms-flex-pack: flex-end;
					  -ms-justify-content: flex-end;
					  justify-content: flex-end;
					  -ms-flex-pack: end;
					  -webkit-order: 2;
					  -moz-order: 2;
					  -ms-flex-order: 2;
					  order: 2;
				  }
				  .tablet-logocenter-toggleright .mpl-mobile-main-header .mpl-f-microwidgets {
					  -webkit-flex: 1 1 0%;
					  -moz-flex: 1 1 0%;
					  -ms-flex: 1 1 0%;
					  flex: 1 1 0%;
				  }}";
				}
				
				if (is_numeric($tablet_switch) && $tablet_switch>0){
					$header_css .= "@media screen and (max-width: ".($phone_switch-1)."px) {
					.mpl-mobile-main-header{
						height:".$phone_height."px;
						}
					.mpl-top-bar {
						display: none;
					}
					.phone-logoright-toggleleft .mpl-mobile-main-header .mpl-logo {
						-webkit-order: 3;
						-moz-order: 3;
						-ms-flex-order: 3;
						order: 3;
					}
					.phone-logoright-toggleleft .mpl-mobile-main-header .mpl-menu-toggle {
						-webkit-order: 1;
						-moz-order: 1;
						-ms-flex-order: 1;
						order: 1;
					}
					.phone-logoright-toggleleft .mpl-mobile-main-header .mpl-f-microwidgets {
						-webkit-order: 2;
						-moz-order: 2;
						-ms-flex-order: 2;
						order: 2;
						-webkit-flex-grow: 10;
						-moz-flex-grow: 10;
						-ms-flex-positive: 10;
						-ms-flex-grow: 10;
						flex-grow: 10;
						padding-left: 40px;
					}
				
					.phone-logocenter-toggleleft .mpl-mobile-main-header .mpl-logo {
						-webkit-order: 1;
						-moz-order: 1;
						-ms-flex-order: 1;
						order: 1;
					}
					.mobile-logocenter-toggleleft .mpl-mobile-main-header .mpl-menu-toggle {
						-webkit-flex: 1 1 0%;
						-moz-flex: 1 1 0%;
						-ms-flex: 1 1 0%;
						flex: 1 1 0%;
					}
					.phone-logocenter-toggleleft .mpl-mobile-main-header .mpl-f-microwidgets {
						-webkit-flex: 1 1 0%;
						-moz-flex: 1 1 0%;
						-ms-flex: 1 1 0%;
						flex: 1 1 0%;
						-webkit-flex-flow: row wrap;
						-moz-flex-flow: row wrap;
						-ms-flex-flow: row wrap;
						flex-flow: row wrap;
						-webkit-justify-content: flex-end;
						-moz-justify-content: flex-end;
						-ms-flex-pack: flex-end;
						-ms-justify-content: flex-end;
						justify-content: flex-end;
						-ms-flex-pack: end;
						-webkit-order: 2;
						-moz-order: 2;
						-ms-flex-order: 2;
						order: 2;
					}
				
					.phone-logoleft-toggleright .mpl-mobile-main-header .mpl-logo {
						-webkit-order: 1;
						-moz-order: 1;
						-ms-flex-order: 1;
						order: 1;
					}
					.phone-logoleft-toggleright .mpl-mobile-main-header .mpl-menu-toggle {
						-webkit-order: 3;
						-moz-order: 3;
						-ms-flex-order: 3;
						order: 3;
					}
					.phone-logoleft-toggleright .mpl-mobile-main-header .mpl-f-microwidgets {
						-webkit-order: 2;
						-moz-order: 2;
						-ms-flex-order: 2;
						order: 2;
						-webkit-flex-grow: 10;
						-moz-flex-grow: 10;
						-ms-flex-positive: 10;
						-ms-flex-grow: 10;
						flex-grow: 10;
						padding-right: 40px;
						-webkit-justify-content: flex-end;
						-moz-justify-content: flex-end;
						-ms-flex-pack: flex-end;
						-ms-justify-content: flex-end;
						justify-content: flex-end;
						-ms-flex-pack: end;
					}
				
					.phone-logocenter-toggleright .mpl-mobile-main-header .mpl-logo {
						-webkit-order: 1;
						-moz-order: 1;
						-ms-flex-order: 1;
						order: 1;
					}
					.phone-logocenter-toggleright .mpl-mobile-main-header .mpl-menu-toggle {
						-webkit-flex: 1 1 0%;
						-moz-flex: 1 1 0%;
						-ms-flex: 1 1 0%;
						flex: 1 1 0%;
						-webkit-flex-flow: row wrap;
						-moz-flex-flow: row wrap;
						-ms-flex-flow: row wrap;
						flex-flow: row wrap;
						-webkit-justify-content: flex-end;
						-moz-justify-content: flex-end;
						-ms-flex-pack: flex-end;
						-ms-justify-content: flex-end;
						justify-content: flex-end;
						-ms-flex-pack: end;
						-webkit-order: 2;
						-moz-order: 2;
						-ms-flex-order: 2;
						order: 2;
					}
					.phone-logocenter-toggleright .mpl-mobile-main-header .mpl-f-microwidgets {
						-webkit-flex: 1 1 0%;
						-moz-flex: 1 1 0%;
						-ms-flex: 1 1 0%;
						flex: 1 1 0%;
					}}";
				}
				
				}
	  
			 }
		
		}
		
		wp_enqueue_style( 'peony-header',  get_template_directory_uri() .'/css/header.css', array('peony-style'), '', false );
		wp_enqueue_style( 'peony-header-custom',  get_template_directory_uri() .'/css/header-custom.css', array('peony-style'), '', false );
		wp_enqueue_script( 'peony-header', get_template_directory_uri() . '/js/header.js' , array( 'jquery' ), null, true);
		
		wp_add_inline_style( 'peony-header', $header_css );
		
		wp_localize_script( 'peony-header', 'peony_header', array(
		'ajaxurl'  => admin_url('admin-ajax.php'),
		'themeurl' => get_template_directory_uri(),
		'options' => array( 
					  'floating_navigation' => $float_header_options['navigation_panel']['floating_navigation'], 
					  'effect' => $float_header_options['navigation_panel']['effect'], 
					  'scrolling' => $float_header_options['navigation_panel']['scrolling'], 
					  'phone_nav_floating' =>$mobile_settings['navigation']['floating'],
					  'phone_switch' => $phone_switch,
					  'tablet_switch' => $tablet_switch,
					  'layout_name' => $layout_name,
					  'inline_three'=> array('floating_logo'=>$options['layout']['inline_three']['floating_logo'])
					  ),
		));
		
		
		}

/**
 * Get top bar css class names
 *
 * @return string
 */
 
	public function top_bar_class( $class ){
		
		$options = $this->mpl_header_options;
		$return  = '';
		
		if ( isset($options['top_bar']) ):
		$top_bar_options = $options['top_bar'];
		$background_or_line = isset($top_bar_options['background_or_line'])?$top_bar_options['background_or_line']:'disabled';
		
		switch( $background_or_line ){
			case "disabled":
				$return = '';
			break;
			case "bottom_line":
				$return = 'mpl-style-bottom-line';
			break;
			case "bottom_line_full":
				$return = 'mpl-style-bottom-line-full';
			break;
			case "solid_bg":
				$return = 'mpl-style-solid-bg';
			break;
			}
			return $class.' '.$return;
			else:
				return $class;
			endif;
		
		}
		
/**
 * Get css class names of classic header nav
 *
 * @return string
 */	
 
	function classic_nav_class( $class ){
		
		$options = $this->mpl_header_options;
		$return  = '';
		
		if ( isset($options['header']['header_settings'])):
		
			$classic_options      = $options['header']['header_settings']['classic'];
			$menu_background_line = isset($options['header']['header_settings']['classic']['menu_background_line'])?
		                        	$options['header']['header_settings']['classic']['menu_background_line']:'';
										
		switch( $menu_background_line ){
			case "disabled":
				$return = '';
			break;
			case "content_width_line":
				$return = 'mpl-style-top-line';
			break;
			case "full_width_line":
				$return = 'mpl-style-top-line-full';
			break;
			case "backgrond":
				$return = 'mpl-style-solid-bg';
			break;
			}
			
			return $class.' '.$return;
			
			else:
				return $class;
			endif;
			
		}
	
/**
 * Get css class names of classic header nav
 *
 * @return string
 */	
 
	function menu_container_class( $class ){
		
		$options = $this->mpl_header_options;
				
		if ( isset($options['menu']['menu_settings']['decoration'])):
		
			extract($options['menu']['menu_settings']['decoration']);
			
			if ( $decoration == 'underline' ){
				if ( isset($direction) ){
					switch( $direction ){
						
						case "left_right":
							$class .= ' hoverline-lefttoright';
						break;
						case "from_center":
							$class .= ' hoverline-fromcenter';
						break;
						case "upwards":
							$class .= ' hoverline-upwards';
						break;
						case "downwards":
							$class .= ' hoverline-downwards';
						break;
					
						}
					}
				
				}
			
			if ( $decoration == 'outline' ){
				if ( isset($hover_style) ){
				  switch( $hover_style ){
					  
					  case "outline":
							$class .= ' hoveroutline';
						break;
						case "background":
							$class .= ' hoverbg';
						break;
					  
				  }
				}
				
			}
			
			
		endif;
		
		return $class;
		
		
		}
	

/**
 * Get header options
 *
 * @return array
 * @param array  $args
 */	
	public function get_header_options( $args = array() ){
		
		if ( !is_array($args) && $args !='')
			$args = @json_decode($args,true);
			
		$options = $this->array_extend((array)$this->mpl_header_options,(array)$args);
		
		return $options;
		
		}
		
/**
 * Get header
 *
 * @return html
 * @param array  $args header options
 * @param bool  $echo output or return
 */
	
	public function get_header( $args = array(), $echo = false ){
		
		$options = $this->get_header_options( $args );
								
		if ( isset($options['layout']) && is_array($options['layout']) && $this->is_saved == true && class_exists('MageewpPageLayoutPro')){
			
			$layout_name    = $options['layout']['header_layout'];
			$layout_options = $options['layout'][$layout_name];
			
						
			if( $echo == false )
				return $this->get_header_layout($layout_name,$layout_options);
			else
				echo $this->get_header_layout($layout_name,$layout_options);
			
		}
		else{
			
			ob_start();
			get_template_part('header-templates/header','classic');
			$return = ob_get_contents();
			ob_end_clean();
			if( $echo == false )
				return $return;
			else
				echo $return;
			}
		
		}


/**
 * Get header
 *
 * @return html
 * @param string  $name header layout name
 * @param array  $args header layout options
 */	
 
	public function get_header_layout($name,$args){
		
		global $peony_post_meta;
		
		$options = $this->mpl_header_options;
		
		$peony_custom_menu = false;		
		$default_options   = $this->get_default_options();
		$default_options   = $default_options['layout'][$name];
		$layout_options    = $this->array_extend((array)$default_options, (array)$args );
				
		$float_header      = $options['float_header']['navigation_panel'];
			
		extract($layout_options);
						 
		if (isset($peony_post_meta['peony_custom_menu'][0]))
			$peony_custom_menu = $peony_post_meta['peony_custom_menu'][0];
	
		if ($peony_custom_menu)
			$theme_location = $peony_custom_menu;
		else
			$theme_location = 'primary'; 
					
		$html           = '' ;
		$wrap_class     = '';
		$custom_logo_id = get_theme_mod('custom_logo');
		$image          = wp_get_attachment_image_src($custom_logo_id , 'full');
		$logo           = $image[0];
		$logo_str       = '';
		$main_menu      = '';
		$mobile_menu    = '';
		$secondary_menu = '';
		
		if ( $menu_position == 'justified' )
			$menu_position = 'justify';
		
		if ( $logo != '' )
			$logo_str   = '<a href="'.esc_url(home_url('/')).'"><img src="'.esc_url($logo).'" alt="'.get_bloginfo('name').'"></a>';
			
		$display_microwidgets  = ( $microwidgets == 'yes' || $microwidgets == '1' )? true:false;
		
		$menu_container_class  = apply_filters( 'mpl_menu_container_class', 'mpl-main-nav' );
		$float_nav_class       = apply_filters( 'mpl_float_nav_class' ,'');
		
		if ( has_nav_menu($theme_location) ):
		$main_menu = wp_nav_menu( array(
						'theme_location'  => $theme_location,
						'menu'            => '',
						'container'       => 'ul',
						'container_class' => '',
						'container_id'    => '',
						'menu_class'      => $menu_container_class,
						'menu_id'         => '',
						'echo'            => false,
						'before'          => '',
						'after'           => '',
						'link_before'     => '',
						'link_after'      => '',
						'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'           => 0,
						'walker'          => '',
						'link_before'     => '<span>',
						'link_after'      => '</span>'
					  ) );
		
		$mobile_menu = wp_nav_menu( array(
						'theme_location'  => $theme_location,
						'menu'            => '',
						'container'       => 'ul',
						'container_class' => $menu_container_class,
						'container_id'    => '',
						'menu_class'      => 'mpl-mobile-main-nav',
						'menu_id'         => '',
						'echo'            => false,
						'before'          => '',
						'after'           => '',
						'link_before'     => '',
						'link_after'      => '',
						'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'           => 0,
						'walker'          => '',
						'link_before'     => '<span>',
						'link_after'      => '</span>',
						'submenu_class'   => 'sub-menu'
					  ) );
		endif;
				
		if ( has_nav_menu('secondary') )
		
		$secondary_menu = wp_nav_menu( array(
						'theme_location'  => 'secondary',
						'menu'            => '',
						'container'       => 'ul',
						'container_class' => '',
						'container_id'    => '',
						'menu_class'      => $menu_container_class,
						'menu_id'         => '',
						'echo'            => false,
						'before'          => '',
						'after'           => '',
						'link_before'     => '',
						'link_after'      => '',
						'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'           => 0,
						'walker'          => '',
						'link_before'     => '<span>',
						'link_after'      => '</span>',
						'submenu_class'   => 'sub-menu'
					  ) );
			

		switch($name){
			
			case "classic":
				$top_bar_options['top_bar_left']  = $top_bar_left;
				$top_bar_options['top_bar_right'] = $top_bar_right;
								
				$wrap_class     .= $menu_position;
				$top_bar = $this->get_top_bar( $top_bar_options, $display_microwidgets );
									
				if ( $full_width_header != 'disaled')
					$wrap_class .= $float_nav_class = ' fullwidth';
				
				
				$near_logo_left_html  = $this->get_microwidget_items($near_logo_left, $display_microwidgets);
				$near_logo_right_html = $this->get_microwidget_items($near_logo_right, $display_microwidgets);
				$near_menu_html       = $this->get_microwidget_items($near_menu, $display_microwidgets);
					
				$wrap_class        = apply_filters('mpl_wrap_class', $wrap_class);
				$classic_nav_class = apply_filters( 'mpl_classic_nav_class', '' );
							
				if ( $logo_position == 'center'){
					$wrap_class .= ' logocenter';
				
				$near_logo_left_html  = $this->get_microwidget_items($near_logo_left, $display_microwidgets);
				
				$html .= '<div class="mpl-header mpl-header-main mpl-classic-header '.$wrap_class.'">
					'.$top_bar.'
					<div class="mpl-main-header">
						<div class="mpl-logo">
						<div class="mpl-f-microwidgets near-logo-left">
								'.$near_logo_left_html.'
							</div>
							'.$logo_str.'
							<div class="mpl-f-microwidgets near-logo-right">
								'.$near_logo_right_html.'
							</div>
						</div>
						<nav class="mpl-navigation '.$classic_nav_class.'">
							'.$main_menu.'
							<div class="mpl-f-microwidgets near-menu">
							   '.$near_menu_html.'
							</div>
						</nav>
					</div>
					</div>
				<div class="mpl-mobile-main-header">
                <div class="mpl-logo">
                    '.$logo_str.'
                </div>
                <div class="mpl-f-microwidgets near-logo-right">
                    '.$near_menu_html.'
                </div>
                <div class="mpl-menu-toggle">
                    <div class="mpl-toggle-icon">
                        <span class="mpl-line"></span>
                    </div>
                </div>
            </div>';

				}else{
			
				$html .= '<div class="mpl-header mpl-header-main mpl-classic-header '.$wrap_class.'">
				'.$top_bar.'
				<div class="mpl-main-header">
					<div class="mpl-logo">
					<div class="mpl-f-microwidgets near-logo-left">'.$near_logo_left_html.'</div>
					   '.$logo_str.'
						<div class="mpl-f-microwidgets near-logo-right">
							'.$near_logo_right_html.'
						</div>
					</div>
					<nav class="mpl-navigation '.$classic_nav_class.'">
					'.$main_menu.'
						<div class="mpl-f-microwidgets near-menu">
							'.$near_menu_html.'
						</div>
					</nav>
				</div>
				</div>
				<div class="mpl-mobile-main-header">
                <div class="mpl-logo">
                    '.$logo_str.'
                </div>
                <div class="mpl-f-microwidgets near-logo-right">
                    '.$near_logo_right_html.'
                </div>
                <div class="mpl-menu-toggle">
                    <div class="mpl-toggle-icon">
                        <span class="mpl-line"></span>
                    </div>
                </div>
				</div>';
			
			
				}
				
			$html .='<div class="mpl-mobile-side-header mpl-mobile-sider-header-left">
            '.$mobile_menu.'
            <div class="mpl-f-microwidgets near-logo-right">
              '.$near_logo_right_html.'
            </div>
            <div class="mpl-close-toggle">
                <div class="mpl-close-icon">
                    <div class="mpl-line"></div>
                </div>
            </div> 
        </div>';
		
		// fixed header
		if( $float_header['floating_navigation'] == 'enabled' ){
			
			$html .= '<div class="mpl-fxd-header-wrap" style="visibility:hidden;">
            <div class="mpl-header mpl-classic-header '.$float_nav_class.' left">
                <div class="mpl-main-header">
                    <div class="mpl-logo">
                        '.$logo_str.'
                    </div>
                    '.$main_menu.'
                    <div class="mpl-f-microwidgets near-menu">
                        '.$near_menu_html.'
                    </div>
                </div>
            </div>
        </div>';
				
				}
		
			
			break;
			
			case "inline":
			
				$top_bar_options['top_bar_left']  = $top_bar_left;
				$top_bar_options['top_bar_right'] = $top_bar_right;			
				
				$wrap_class .= $menu_position;
				$top_bar     = $this->get_top_bar( $top_bar_options , $display_microwidgets );
					
				if ( $full_width_header != 'disaled')
					$wrap_class .= $float_nav_class = ' fullwidth';
					
				$wrap_class = apply_filters('mpl_wrap_class', $wrap_class);
				
				$html .= '<div class="mpl-header mpl-header-main mpl-inline-header '.$wrap_class.'">
				'.$top_bar.'
				<div class="mpl-main-header">
					<div class="mpl-logo">
						'.$logo_str.'
					</div>
					'.$main_menu.'
					<div class="mpl-f-microwidgets near-menu">
						'.$this->get_microwidget_items($near_menu, $display_microwidgets).'
					</div>
				</div>
				<div class="mpl-mobile-main-header"></div>
			</div>';
			
			if( $float_header['floating_navigation'] == 'enabled' ){
			
			$html .= '<div class="mpl-fxd-header-wrap" style="visibility:hidden;">
            <div class="mpl-header mpl-inline-header '.$float_nav_class.' right">
                <div class="mpl-main-header">
                    <div class="mpl-logo">
                        '.$logo_str.'
                    </div>
                    '.$main_menu.'
                    <div class="mpl-f-microwidgets near-menu">
                        '.$this->get_microwidget_items($near_menu, $display_microwidgets).'
                    </div>
                </div>
                <div class="mpl-mobile-main-header"></div>
            </div>
        </div>';
				
				}
		
			break;
			
			case "split":
				
				$top_bar_options['top_bar_left']  = $top_bar_left;
				$top_bar_options['top_bar_right'] = $top_bar_right;			
								
				$wrap_class .= $menu_position;
				$top_bar     = $this->get_top_bar( $top_bar_options , $display_microwidgets );
				
					
				if ( $full_width_header != 'disabled')
					$wrap_class .= $float_nav_class = ' fullwidth';
				
				$wrap_class = apply_filters('mpl_wrap_class', $wrap_class);
				$html .= '<div class="mpl-header mpl-header-main mpl-split-header '.$wrap_class.'">
			   '.$top_bar.'
				<div class="mpl-main-header">
					<div class="mpl-logo">
						'.$logo_str.'
					</div>
					<nav class="mpl-navigation">
						'.$main_menu.'
						<div class="mpl-f-microwidgets near-menu-left">
							'.$this->get_microwidget_items($near_menu_left, $display_microwidgets).'
						</div>
					</nav>
					<nav class="mpl-navigation">
						'.$secondary_menu.'
						<div class="mpl-f-microwidgets near-menu-right">
							'.$this->get_microwidget_items($near_menu_right, $display_microwidgets).'
						</div>
					</nav>
				</div>
				<div class="mpl-mobile-main-header"></div>
			</div>';
			
			if( $float_header['floating_navigation'] == 'enabled' ){
			
			$html .= '<div class="mpl-fxd-header-wrap" style="visibility:hidden;">
            <div class="mpl-header mpl-split-header '.$float_nav_class.' outside">
                <div class="mpl-main-header">
                    <div class="mpl-logo">
                        '.$logo_str.'
                    </div>
                    <nav class="mpl-navigation">
                        '.$main_menu.'
                        <div class="mpl-f-microwidgets near-menu-left">
                            '.$this->get_microwidget_items($near_menu_left, $display_microwidgets).'
                        </div>
                    </nav>
                    <nav class="mpl-navigation">
                        '.$secondary_menu.'
                        <div class="mpl-f-microwidgets near-menu-right">
                           '.$this->get_microwidget_items($near_menu_right, $display_microwidgets).'
                        </div>
                    </nav>
                </div>
                <div class="mpl-mobile-main-header"></div>
            </div>
        </div>';
				
				}
		
			break;
			
			case "side":
				
				$wrap_class      = apply_filters('mpl_wrap_class', '');
				$side_wrap_class = apply_filters('mpl_side_wrap_class', '');
				
				$html .= '<div class="mpl-header  mpl-side-header mpl-side-header-'.$header_position.' h-'.$menu_items_alignment.' c-'.$position_of_header_content.' '.$wrap_class.' '.$side_wrap_class.'">
				<div class="mpl-main-header">
					<div class="mpl-logo">
						'.$logo_str.'
					</div>
					'.$main_menu.'
					<div class="mpl-f-microwidgets near-below-menu">
						'.$this->get_microwidget_items($below_menu, $display_microwidgets).'
					</div>
				</div>
				<div class="mpl-mobile-main-header"></div>
			</div>';
			
			break;
			
			case "inline_three":
								
				if ( $full_width_header != 'disabled')
					$wrap_class .= ' fullwidth';
					
				if ($logo_position == 'left')
					$wrap_class .= ' logoleft-toggleright';
				else
					$wrap_class .= ' logocenter-toggleright';
				
				$wrap_class      = apply_filters('mpl_wrap_class', $wrap_class);
				$side_wrap_class = apply_filters('mpl_side_wrap_class', '');
				
				if ($sliding_menu_position == 'full')
					$sliding_menu_position = 'overlay';
					
				$html .= '<div class="mpl-header mpl-side-header mpl-side-header-'.$sliding_menu_position.' h-'.$position_of_header_content.' '.$side_wrap_class .'" >
				<div class="mpl-main-header">
					<div class="mpl-logo">
					   '.$logo_str.'
					</div>
					'.$main_menu.'
					<div class="mpl-f-microwidgets area-in-top-line">
						'.$this->get_microwidget_items($top_line, $display_microwidgets).'
					</div>
				</div>
				<div class="mpl-close-toggle">
					<div class="mpl-close-icon">
						<div class="mpl-line"></div>
					</div>
				</div> 
			</div>
			
			<div class="mpl-header mpl-header-main mpl-mixed-header '.$wrap_class.'">
				<div class="mpl-main-header">
					<div class="mpl-logo">
						'.$logo_str.'
					</div>
					<div class="mpl-f-microwidgets area-below-menu">
						'.$this->get_microwidget_items($below_menu, $display_microwidgets).'
					</div>
					<div class="mpl-menu-toggle">
						<div class="mpl-toggle-icon">
							<span class="mpl-line"></span>
						</div>
					</div>
				</div>
			</div>';
						
			break;
			
			}
			
			return $html;
		
		}
		
/**
 * <body> tag css class filter
 *
 * @return string
 */	
 	
	function body_class_filter($body_class){
		
		 $options = $this->mpl_header_options;
		 
		 if ( isset($options['layout']) && is_array($options['layout']) ){
			
			$layout_name    = $options['layout']['header_layout'];
			$layout_options = $options['layout'][$layout_name];
			$header_position = isset($layout_options['header_position'])?$layout_options['header_position']:'right';
			
			$body_class       .= ' mpl-header-'.$layout_name;
			
			switch($layout_name){
				
				case "side":
					$body_class .= ' mpl-header-side-'.$header_position;
				break;
				
				}
			
		 }
		
		return $body_class;
		
		}

/**
 * Header container css class filter
 *
 * @return string
 */	
	function wrap_class($wrap_class){
		
		$options = $this->mpl_header_options;
		
		 if ( isset($options['header']) && is_array($options['header']) ){
			 
			$layout_name       = isset($options['layout']['header_layout'])?$options['layout']['header_layout']:'';
			$header_decoration = $options['header']['header_settings']['background']['header_decoration'];
			$dividers          = $options['menu']['menu_settings']['dividers'];
						
			
			switch($layout_name){
				
				case "":
					$wrap_class .= ' border';
				break;
				case "classic":
				case "inline":
					if ( $dividers['dividers'] == 'enabled' ){
						
						$wrap_class .= ' dividers';
						
						}
					if ( $dividers['first_last_dividers'] == 'enabled' )
					{
						$wrap_class .= ' surround';
						
						}
						
					if ( $header_decoration == 'line' )
						$wrap_class .= ' border';
					else
						$wrap_class .= ' '.$header_decoration;

				
				break;
				case "side":
					$sub_menu_style = $options['sub_menu']['sub_menu_settings']['side']['show'];
					if ( $sub_menu_style == 'sideways' )
						$wrap_class .= ' sub-sideways';
					if ( $sub_menu_style == 'downwards' )
						$wrap_class .= ' sub-downwards';
				
				break;
		
				default:
				
					if ( $header_decoration == 'line' )
						$wrap_class .= ' border';
					else
						$wrap_class .= ' '.$header_decoration;
					
				break;
				
				}
		 }
		return $wrap_class;
		
		}
		
/**
 * Side menu header container css class filter
 *
 * @return string
 */	
	function side_wrap_class($wrap_class){
		
		$options = $this->mpl_header_options;
		
		 if ( isset($options['header']) && is_array($options['header']) ){
			 
			$layout_name    = isset($options['layout']['header_layout'])?$options['layout']['header_layout']:'';
			$layout_options = $options['layout'][$layout_name];
			switch($layout_name){
				

				case "side":
				case "inline_three":
				
					$menu_position        = $layout_options['menu_position'];
					$logo_info_position   = $layout_options['logo_info_position'];
					$menu_items_alignment = $layout_options['menu_items_alignment'];
					$menu_itmes_link_area = $layout_options['menu_itmes_link_area'];
					
					if ( $menu_position == 'center' )
						$wrap_class .= ' v-center';
						
					if ( $menu_position == 'bottom' )
						$wrap_class .= ' v-bottom';
						
					if ( $logo_info_position == 'edges_of_menu' )
						$wrap_class .= ' c-inside';
						
					if ( $menu_itmes_link_area == 'full_width' )
						$wrap_class .= ' h-justify';
						
				break;
	
				}
		 }
		return $wrap_class;
		
		}

/**
 * Float menu css class filter
 *
 * @return string
 */	
	function float_nav_class($wrap_class){
		
		$options = $this->mpl_header_options;
		
		 if ( isset($options['float_header']) && is_array($options['float_header']) ){
			 
			 $decoration = $options['float_header']['navigation_panel']['decoration'];
			 if ( $decoration != 'disabled' ){
				 if ( $decoration == 'line' ){
						 $wrap_class .= ' border';
					 }else{
						$wrap_class .= ' '.$decoration;
					}
			 }
			 
		 }
		return $wrap_class;
		
		}


/**
 * Get top bar
 *
 * @return html
 * @param array  $args top bar options
 * @param bool  $display_microwidgets display  microwidgets or not
 */	
	public function get_top_bar( $args = array(), $display_microwidgets=true ){
		
		if ( $display_microwidgets == false )
			return '';
			
		$left_options  = $args['top_bar_left'];
		$right_options = $args['top_bar_right'];
		$html          = '';
		if ($left_options !='' || $right_options !='' ){
		$top_bar_left  = $this->get_microwidget_items($left_options, $display_microwidgets);
		$top_bar_right = $this->get_microwidget_items($right_options, $display_microwidgets);
		
		
		$css_class = apply_filters('mpl_top_bar_class', 'mpl-top-bar');
		
		$html = '<div class="'.$css_class .'">
                <div class="mpl-f-microwidgets">
                    '.$top_bar_left.'
                </div>
                <div class="mpl-f-microwidgets">
                   '.$top_bar_right.'
                </div>
            </div>' ;
			
			}
			
			return $html;
		
		}

/**
 * Get microwidget items
 *
 * @return html
 * @param array  $options microwidgets options
 * @param bool  $display_microwidgets display  microwidgets or not
 */	
	public function get_microwidget_items( $options, $display_microwidgets = true ){
		
		$html  = '';
		
		if ($display_microwidgets==true && is_array($options) ):
		
			foreach( $options as $k=>$v ){
			
			$class = $this -> get_mini_widget_class($options[$k]);
			
			switch($k){
				
				case "Menu":
				  
				  $wrap_class  = ( 'list' == $options[$k]['style'] ? 'list-type-menu' : 'select-type-menu' );
				  $wrap_class .= ' top-bar-menu';
				  $html .= '<span class="mpl-microwidget  mpl-micronav mpl-micronav-list mpl-top-bar-menu '.$class.'">';
				  
				  if ( has_nav_menu('top_bar_menu') )
				  $html .= wp_nav_menu( array(
						'theme_location'  => 'top_bar_menu',
						'menu'            => '',
						'container'       => '',
						'container_class' => '',
						'container_id'    => '',
						'menu_class'      => $wrap_class,
						'menu_id'         => '',
						'echo'            => false,
						'fallback_cb'     => '',
						'before'          => '',
						'after'           => '',
						'link_before'     => '',
						'link_after'      => '',
						'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'           => 0,
						'walker'          => ''
					  ) );
				  
				  $html .= '</span>';
									
				break;
				
				case "Cart":
				  if (class_exists('WooCommerce')) {
				  	$html .= '<div class="mpl-microwidget '.$class.'">'.$this->wc_mini_cart().'</div>';
				  }
				  
				break;
				
				case "Search":
					
					$hide      = '';
					$css_style = '';
					$icon_html = '';
					if( $options[$k]['show_icon'] == 'yes' ):
						$hide      = 'hide';
						$icon_html = '<div class="mpl-search-label"></div>';
					else:
						$css_style = 'position:static';
					endif;
					
					$html .= '<div class="mpl-microwidget mpl-search '.$class.'">
						'.$icon_html.'
						<div class="mpl-search-wrap right-overflow '.$hide .'" style="'.$css_style .'">
									  <form action="'.esc_url(home_url('/')).'" class="searchform">
										  <label>
											  <span class="screen-reader-text">'.__('Search for:','peony').'</span>
											  <input type="search" class="search-field" placeholder="'.__('Search','peony').'&hellip;" value="" name="s">
										  </label>
										  <input type="submit" class="search-submit" value="'.__('Search','peony').'">
									  </form>
								  </div></div>';		
					
				break;
				
				case "Login":
				
					if ( is_user_logged_in() ) {
						$caption    = $options[$k]['logout_caption'];
						$login_link = wp_logout_url();
						$icon       = '<i class="fa fa-sign-out logout-icon" aria-hidden="true"></i>';
					} else {
						$caption    = $options[$k]['login_caption'];
						$login_link = $options[$k]['link'];
						$icon       = '<i class="fa fa-sign-in login-icon" aria-hidden="true"></i>';
						
						if ( ! $login_link ) {
							$login_link = wp_login_url();
						}
					}
					
					if( $options[$k]['show_icon'] != 'yes' )
						$icon = '';

				  $html .= '<div class="mpl-microwidget '.$class.'"><a href="'.$login_link.'">'.$icon.' '.$caption.'</a></div>';
				break;
				
				case "Social":
				  $html .= '<div class="mpl-microwidget mpl-microicons '.$class.'">
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-weibo"></i></a>
                    </div>';
				break;
				
				case "Text":
				  $html .= '<span class="mpl-microwidget '.$class.'">'.$options[$k]['content'].'</span>';
				break;
				
				}
			
			}
		endif;
			
			return $html;
		
		}
		
/**
 * Get microwidget wrap css class
 *
 * @return html
 * @param array  $args microwidget options
 * @param array  $class default classes
 */	
	public function get_mini_widget_class( $args = array(), $class = array() ) {
		
		$options = array_merge(array('on_desktops'=>'show','tablet'=>'show','phone'=>'show'),(array)$args);
		$classes = $class;
		
		$classes[] = $this->array_value( $options['on_desktops'], array(
			'show' => 'show-on-desktop',
			'hide' => 'hide-on-desktop',
		));

		$classes[] = $this->array_value( $options['tablet'], array(
			'leave'   => 'in-menu-first-switch',
			'show' => 'near-logo-first-switch',
			'hide'    => 'hide-on-first-switch',
		));

		$classes[] = $this->array_value( $options['phone'], array(
			'leave'   => 'in-menu-second-switch',
			'show' => 'near-logo-second-switch',
			'hide'    => 'hide-on-second-switch',
		) );

		$classes = apply_filters( 'mpl_mini_widget_class', $classes, $class );

		return implode( ' ', $classes );
	}

/**
 * Get array value by key
 *
 * @return string
 */	
	public function array_value( $key, $array, $default = null ) {
		return isset( $array[ $key ] ) ? $array[ $key ] : $default;
	}
	
/**
 * Array merge
 *
 * @return array
 */	
	public function parse_args( $args, $defaults = '' ) {
		if ( is_object( $args ) )
			$r = get_object_vars( $args );
		elseif ( is_array( $args ) )
			$r =& $args;
		else
			wp_parse_str( $args, $r );
	
		if ( is_array( $defaults ) )
			return array_merge( $defaults, $r );
		return $r;
	}
	

/**
 * Cover hex to rgb
 *
 * @return array
 */	
	public function hex2rgb( $colour ) {
		if ( trim($colour) == '' )
			return false; 
		if ( $colour[0] == '#' ) { 
			$colour = substr( $colour, 1 ); 
		} 
		if ( strlen( $colour ) == 6 ) { 
			list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] ); 
		} elseif ( strlen( $colour ) == 3 ) { 
			list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] ); 
		} else { 
			return false; 
		} 
		$r = hexdec( $r ); 
		$g = hexdec( $g ); 
		$b = hexdec( $b ); 
    return array( '0' => $r, '1' => $g, '2' => $b ); 
	} 

/**
 * "Extend" recursively array $a with array $b values
 *
 * @return array
 */	
	
	public function array_extend($a, $b) {
    foreach($b as $k=>$v) {
        if( is_array($v) ) {
            if( !isset($a[$k]) ) {
                $a[$k] = $v;
            } else {
                $a[$k] = $this->array_extend($a[$k], $v);
            }
        } else {
            $a[$k] = $v;
        }
    }
    return $a;
	}
	
	
	public function wc_mini_cart(){
		
	  if (!class_exists('WooCommerce')) 
	  return;
	  
	  ob_start();
	  $cart_class = array();
	  $cart_caption = __( 'Your cart', 'peony' );
	  $cart_counter_bg_class = '';
	  $product_counter_html = '';
	  $products_count = esc_html(WC()->cart->cart_contents_count);
	  
	  // show or not cart icon
	  $show_icon = '';
	  if ( ! $show_icon ) {
		  $cart_class[] = 'icon-off';
	  }
	  
	  // change cart caption
	  $cart_caption = '';
	  
	  
	  if ( '' == $cart_caption ) {
		  $cart_caption .= '&nbsp;';
	  
		  if ( $show_icon ) {
			  $cart_class[] = 'text-disable';
		  }
	  }
	  
	  $show_products_counter = '';
	  if ( 'never' != $show_products_counter ) {
	  
		  $counter_class = 'counter';
	  
		  if ( 'if_not_empty' == $show_products_counter ) {
			  $counter_class .= ' hide-if-empty';
	  
			  if ( $products_count <= 0 ) {
				  $counter_class .= ' hidden';
			  }
		  }
	  
		  $product_counter_html = "<span class=\"{$counter_class}\">{$products_count}</span>";
	  }
	  
	  $cart_class[] = 'show-sub-cart';
	  ?>
	  
	  <div class="<?php echo 'shopping-cart ' . implode( ' ',  $cart_class ); ?>">
	  
		  <a class="wc-ico-cart mpl-shopping-cart <?php echo implode( ' ', $cart_class ); ?>" href="<?php echo wc_get_cart_url(); ?>"><?php echo $cart_caption; echo $product_counter_html; ?></a>
	  
		  <div class="shopping-cart-wrap">
			  <div class="shopping-cart-inner">
	  
				  <?php
				  $cart_is_empty = count( WC()->cart->get_cart() ) <= 0;
				  $list_class = array( 'cart_list', 'product_list_widget' );
	  
				  if ( $cart_is_empty ) {
					  $list_class[] = 'empty';
				  }
				  ?>
	  
				  <ul class="<?php echo esc_attr( implode( ' ', $list_class ) ); ?>">
	  
					  <?php if ( !$cart_is_empty ) : ?>
	  
						  <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
	  
							  $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							  $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
	  
							  if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
	  
								  $product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
								  $thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
								  $product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
								  ?>
								  <li>
									  <?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove" title="%s">&times;</a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'peony' ) ), $cart_item_key ); ?>
									  <?php if ( ! $_product->is_visible() ) : ?>
										  <?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . $product_name; ?>
									  <?php else : ?>
										  <a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
											  <?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . $product_name; ?>
										  </a>
									  <?php endif; ?>
									  <?php echo WC()->cart->get_item_data( $cart_item ); ?>
	  
									  <?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
								  </li>
								  <?php
							  }
	  
						  endforeach; ?>
	  
					  <?php else : ?>
	  
						  <li><?php _e( 'No products in the cart.', 'peony' ); ?></li>
	  
					  <?php endif; ?>
	  
				  </ul><!-- end product list -->
	  
				  <?php if ( sizeof( WC()->cart->get_cart() ) <= 0 ) : ?>
					  <div style="display: none;">
				  <?php endif; ?>
	  
					  <p class="total"><strong><?php _e( 'Subtotal', 'peony' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>
	  
					  <p class="buttons">
						  <a href="<?php echo wc_get_cart_url(); ?>" class="button view-cart"><?php _e( 'View Cart', 'peony' ); ?></a>
						  <a href="<?php echo wc_get_checkout_url(); ?>" class="button checkout"><?php _e( 'Checkout', 'peony' ); ?></a>
					  </p>
	  
				  <?php if ( sizeof( WC()->cart->get_cart() ) <= 0 ) : ?>
					  </div>
				  <?php endif; ?>
			  </div>
		  </div>
	  
	  </div>
<?php
	$output = ob_get_clean();

	return $output;
		
		}
	}
	
	new Peony_Template_Header;