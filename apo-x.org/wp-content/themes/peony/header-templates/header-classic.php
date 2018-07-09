<?php
	global $peony_post_meta, $peony_sticky_header;
	
	$peony_custom_menu = false;
 
	if (isset($peony_post_meta['peony_custom_menu'][0]))
		$peony_custom_menu = $peony_post_meta['peony_custom_menu'][0];
			
	if ($peony_custom_menu)
		$theme_location = $peony_custom_menu;
	else
		$theme_location = 'primary'; 
	 
	$header_class   = 'logo-left';
	$str_header     = '';
	$header_overlay = '';
	if (isset($peony_post_meta['peony_header_overlay'][0])){
		
		if ( $peony_post_meta['peony_header_overlay'][0] !='0' &&  $peony_post_meta['peony_header_overlay'][0] !='' ){
			$header_overlay = $peony_post_meta['peony_header_overlay'][0];
		}
		
		}
	
	if( $header_overlay == '1' || $header_overlay == 'on' ) {
		$header_class  .= ' overlay';
	}
	

	$custom_logo_id = get_theme_mod('custom_logo');
    $image          = wp_get_attachment_image_src($custom_logo_id , 'full');
    $logo           =  $image[0];
	
    // normal header
    $str_header .= '<header id="header" class="'.$header_class.'">';
    $str_header .= '<div class="container">
						<div class="logo-box text-left">
							  <a href="'.esc_url(home_url('/')).'">';
	if ($logo)
		$str_header .= '<img class="site-logo normal_logo peony_standard_logo" alt="'.esc_attr(get_bloginfo('name')).'" src="'.esc_url($logo).'" >';
	$str_header .= '</a>
						<div class="name-box">
								<a href="'.esc_url(home_url('/')).'"><h1 class="site-name">'.esc_attr(get_bloginfo('name')).'</h1></a>
							<span class="site-tagline">'.get_bloginfo('description').'</span>
						</div>
					</div>
					<a class="site-nav-toggle">
						<span class="sr-only">'.__( 'Toggle navigation', 'peony' ).'</span>
						<i class="fa fa-bars"></i>
					</a>';
//@if NODE_ENV == 'free'
		$str_header .= '<nav class="normal-site-nav" >';
//@endif
//@if NODE_ENV == 'pro'
		$nav_hover_effectet = peony_option('nav_hover_effectet');
		$str_header .= '<nav class="normal-site-nav style' .$nav_hover_effectet .'" >';
//@endif
        $str_header .= wp_nav_menu(array('theme_location'=>$theme_location,'depth'=>0,'fallback_cb' =>false,'container'=>'','container_class'=>'main-menu','menu_id'=>'menu-main','menu_class'=>'main-nav','link_before' => '<span class="menu-item-label">', 'link_after' => '</span>','items_wrap'=> '<ul id="%1$s" class="%2$s">%3$s</ul>','echo'=>false)).'
                        </nav>
					</div>
					<nav class="site-nav">
					<h1 class="text-right">'.get_bloginfo('name').'</h1>
						<button type="button" class="close" aria-label="'.__( 'Close', 'peony' ).'"><span aria-hidden="true">&times;</span></button>
						 ';
	$str_header .= wp_nav_menu(array('theme_location'=>$theme_location,'depth'=>0,'fallback_cb' =>false,'container'=>'','container_class'=>'main-menu','menu_id'=>'menu-main','menu_class'=>'main-nav','link_before' => '<span class="menu-item-label">', 'link_after' => '</span>','items_wrap'=> '<ul id="%1$s" class="%2$s">%3$s</ul>','echo'=>false));
	$str_header .= '</nav></header>';
	
	// sticky header
	if ($peony_sticky_header == '1') {
		$header_class = ' fxd-header';
        $str_header .= '<header class="'.$header_class.'">';
	    $str_header .= '<div class="container">
						<div class="logo-box text-left">
							  <a href="'.esc_url(home_url('/')).'">';
	if ($logo)
		$str_header .= '<img class="site-logo normal_logo peony_standard_logo" alt="'.get_bloginfo('name').'" src="'.esc_url($logo).'" >';
	$str_header .= '</a>
						<div class="name-box">
								<a href="'.esc_url(home_url('/')).'"><h1 class="site-name">'.get_bloginfo('name').'</h1></a>
							<span class="site-tagline">'.get_bloginfo('description').'</span>
						</div>
					</div>
					<a class="site-nav-toggle">
						<span class="sr-only">'.__( 'Toggle navigation', 'peony' ).'</span>
						<i class="fa fa-bars"></i>
					</a>';
//@if NODE_ENV == 'free'
		$str_header .= '<nav class="normal-site-nav" >';
//@endif
//@if NODE_ENV == 'pro'
		$nav_hover_effectet = peony_option('nav_hover_effectet');
		$str_header .= '<nav class="normal-site-nav style' .$nav_hover_effectet .'" >';
//@endif
        $str_header .= wp_nav_menu(array('theme_location'=>$theme_location,'depth'=>0,'fallback_cb' =>false,'container'=>'','container_class'=>'main-menu','menu_id'=>'menu-main','menu_class'=>'main-nav','link_before' => '<span class="menu-item-label">', 'link_after' => '</span>','items_wrap'=> '<ul id="%1$s" class="%2$s">%3$s</ul>','echo'=>false)).'
                        </nav>
					</div>
					<nav class="site-nav">
					<h1 class="text-right">'.get_bloginfo('name').'</h1>
						<button type="button" class="close" aria-label="'.__( 'Close', 'peony' ).'"><span aria-hidden="true">&times;</span></button>
						 ';
	$str_header .= wp_nav_menu(array('theme_location'=>$theme_location,'depth'=>0,'fallback_cb' =>false,'container'=>'','container_class'=>'main-menu','menu_id'=>'menu-main','menu_class'=>'main-nav','link_before' => '<span class="menu-item-label">', 'link_after' => '</span>','items_wrap'=> '<ul id="%1$s" class="%2$s">%3$s</ul>','echo'=>false));
	$str_header .= '</nav></header>';
	}
	
	echo $str_header;