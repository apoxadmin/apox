<?php
/**
 * @package krystal
 */


/**
 * Krystal Header Style 1
 */
if ( ! function_exists( 'krystal_header_style_1' ) ) :
function krystal_header_style_1() {
	?>
		<header id="home-inner" class="menu-wrapper elementor-menu-anchor">
	        <div class="container">                                                       
	            <!-- ============================ Theme Menu ========================= -->
	            <div class="navbar-header">	                
	                <?php 
	                	if (has_custom_logo()){
	                		krystal_the_custom_logo();
	                	}	                		                	
	                ?>
	                <?php 
	                    $alt_logo=esc_url(get_theme_mod( 'kr_alt_logo' ));
	                	if(!empty($alt_logo)) {
		                	?>
		                		<a id="logo-alt" class="logo-alt" href="<?php echo esc_url(home_url()); ?>"><img src="<?php echo esc_url( get_theme_mod( 'kr_alt_logo' ) ); ?>" alt="logo"></a>
		                	<?php
		                }		                
	                ?>
	                <h1 class="site-title">
				        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php esc_attr(bloginfo( 'name' )); ?></a>
				    </h1>
				    <?php
				        $description = esc_attr(get_bloginfo( 'description', 'display' ));
				        if ( $description || is_customize_preview() ) { 
				            ?>
				                <p class="site-description"><?php echo $description; ?></p>
				            <?php 
				        }
				    ?>
	                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	                    <span class="sr-only"><?php _e( 'Toggle navigation', 'krystal' ); ?></span>
	                    <i class="fa fa-bars fa-1x"></i>
	                </button>
	            </div>
	            <div class="res-menu hidden-sm hidden-md hidden-lg">
	                <div class="navbar-collapse collapse">
	                    <?php
	if($_SESSION['class'] == 'admin') { 
		 wp_nav_menu( array('menu' => 'Excomm' , 
							'theme_location' => 'primary', 
							'depth'             => 2,
			                  	'container'         => 'ul',
			                  	'container_class'   => '',
			                  	'container_id'      => '',
			                  	'menu_class'        => 'nav',
			                  	'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
			                  	'walker'            => new wp_bootstrap_navwalker()) );
	}
	elseif(isset($_SESSION['id'])) {
	 // if they are logged in
	 wp_nav_menu( array( 'menu' => 'Logged_In' , 'theme_location' => 'primary', 'depth'             => 2,
			                  	'container'         => 'ul',
			                  	'container_class'   => '',
			                  	'container_id'      => '',
			                  	'menu_class'        => 'nav',
			                  	'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
			                  	'walker'            => new wp_bootstrap_navwalker()));
	} 
	else {
	 // they are not logged in
	 wp_nav_menu( array( 'theme_location' => 'primary', 'depth'             => 2,
			                  	'container'         => 'ul',
			                  	'container_class'   => '',
			                  	'container_id'      => '',
			                  	'menu_class'        => 'nav',
			                  	'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
			                  	'walker'            => new wp_bootstrap_navwalker()) );
	}
	
			                wp_nav_menu( array(			                  	
			                  	'theme_location'    => 'primary',
			                  	'depth'             => 2,
			                  	'container'         => 'ul',
			                  	'container_class'   => '',
			                  	'container_id'      => '',
			                  	'menu_class'        => 'nav',
			                  	'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
			                  	'walker'            => new wp_bootstrap_navwalker())
			                );
			             ?>   
	                </div>
	            </div>
	            <nav class="main-menu hidden-xs">
	            	<?php
		                wp_nav_menu( array(		                  	
		                  	'theme_location'    => 'primary',
		                  	'depth'             => 3,
		                  	'container'         => 'ul',
		                  	'container_class'   => '',
		                  	'container_id'      => '',
		                  	'menu_class'        => 'nav',
		                  	'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
		                  	'walker'            => new wp_bootstrap_navwalker())
		                );
		             ?>                
	            </nav> 
	        </div>
	    </header> 
	<?php	
}
endif;



/**
 * Krystal Header Style 2
 */
if ( ! function_exists( 'krystal_header_style_2' ) ) :
function krystal_header_style_2() {
	?>
		<header id="home-inner" class="menu-wrapper style-2 elementor-menu-anchor">
        <div class="container">                                                       
            <!-- ============================ Theme Menu ========================= -->
            <div class="navbar-header">                
                <?php 
                	if (has_custom_logo()){
	                	krystal_the_custom_logo();
	                }	                
                ?>
                <?php 
                    $alt_logo=esc_url(get_theme_mod( 'kr_alt_logo' ));
                	if(!empty($alt_logo)) {
	                	?>
	                		<a id="logo-alt" class="logo-alt" href="<?php echo esc_url(home_url()); ?>"><img src="<?php echo esc_url( get_theme_mod( 'kr_alt_logo' ) ); ?>" alt="logo"></a>
	                	<?php
	                }	                
                ?>          
                <h1 class="site-title">
				    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php esc_attr(bloginfo( 'name' )); ?></a>
				</h1>
				<?php
				    $description = esc_attr(get_bloginfo( 'description', 'display' ));
				    if ( $description || is_customize_preview() ) { 
				        ?>
				            <p class="site-description"><?php echo $description; ?></p>
				        <?php 
				    }
				?>      
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only"><?php _e( 'Toggle navigation', 'krystal' ); ?></span>
                    <i class="fa fa-bars fa-1x"></i>
                </button>
            </div>
            <div class="res-menu hidden-sm hidden-md hidden-lg">
                <div class="navbar-collapse collapse">
                    <?php
		                wp_nav_menu( array(		                  	
		                  	'theme_location'    => 'primary',
		                  	'depth'             => 2,
		                  	'container'         => 'ul',
		                  	'container_class'   => '',
		                  	'container_id'      => '',
		                  	'menu_class'        => 'nav',
		                  	'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
		                  	'walker'            => new wp_bootstrap_navwalker())
		                );
		             ?>   
                </div>
            </div>
            <nav class="main-menu hidden-xs">
            	<?php
	                wp_nav_menu( array(	                  	
	                  	'theme_location'    => 'primary',
	                  	'depth'             => 3,
	                  	'container'         => 'ul',
	                  	'container_class'   => '',
	                  	'container_id'      => '',
	                  	'menu_class'        => 'nav',
	                  	'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
	                  	'walker'            => new wp_bootstrap_navwalker())
	                );
	             ?>                
            </nav> 
        </div>
    </header> 
	<?php		

}
endif;


if ( ! function_exists( 'krystal_action_header_hook' ) ) :
function krystal_action_header_hook() {
	if("style1" === esc_attr(get_theme_mod( 'kr_header_styles','style1'))) {
	    add_action( 'krystal_action_header', 'krystal_header_style_1' );
	}
	else{
	    add_action( 'krystal_action_header', 'krystal_header_style_2' );
	}
}
endif;
add_action( 'wp', 'krystal_action_header_hook' );



/**
 * Krystal Footer
 */

if ( ! function_exists( 'krystal_footer_copyrights' ) ) :
function krystal_footer_copyrights() {
	?>
		<div class="row">
            <div class="copyrights">
                <p><?php echo esc_attr(get_theme_mod( 'kr_copyright_text', __('Copyrights krystal. All Rights Reserved','krystal')) ); ?><span><?php _e(' | Theme by ','krystal') ?><a href="https://www.spiraclethemes.com/" target="_blank"><?php _e('Spiraclethemes','krystal') ?></a></span></p>
            </div>
        </div>
	<?php
}
endif;


if ( ! function_exists( 'krystal_action_footer_hook' ) ) :
function krystal_action_footer_hook() {
	add_action( 'krystal_action_footer', 'krystal_footer_copyrights' );	
}
endif;
add_action( 'wp', 'krystal_action_footer_hook' );



/**
 * Krystal Page Title
 */

if ( ! function_exists( 'krystal_get_page_title' ) ) :
function krystal_get_page_title($blogtitle=false,$archivetitle=false,$searchtitle=false,$pagenotfoundtitle=false) {
	if(!is_front_page()){
		if ('color' === esc_attr(get_theme_mod( 'kr_page_bg_radio','color' ))) {
			?>
				<div class="page-title" style="background:<?php echo sanitize_hex_color(get_theme_mod( 'kr_page_bg_color','#555555' )); ?>;">
			<?php
		}
		else if('image' === esc_attr(get_theme_mod( 'kr_page_bg_radio','color' ))){
			?>
				<?php
					if(true===get_theme_mod( 'kr_page_bg_parallax',true)) {
						?>
							<div class="page-title" data-parallax="scroll" data-image-src="<?php echo esc_url(get_theme_mod( 'kr_page_bg_image',get_template_directory_uri().'/img/start-bg.jpg' )); ?>">
						<?php
					}
					else{
						?>
							<div class="page-title"  style="background:url('<?php echo esc_url(get_theme_mod( 'kr_page_bg_image',get_template_directory_uri().'/img/start-bg.jpg' )); ?>') no-repeat scroll center center / cover">	
						<?php
					}
				?>
				
			<?php
		}
		else{
			?>
				<div class="page-title" style="background:#555555;"> 
			<?php
		}
		
		?>
			
			<div class="content-section img-overlay">
				<div class="container">
					<div class="row text-center">
						<div class="col-md-12">
							<div class="section-title page-title"> 
								<?php
									if($blogtitle){
										?><h1 class="main-title"><?php single_post_title(); ?></h1><?php
									}
									if($archivetitle){
										?><h1 class="main-title"><?php the_archive_title(); ?></h1><?php
									}
									if($searchtitle){
										?><h1 class="main-title"><?php _e('SEARCH RESULTS','krystal') ?></h1><?php
									}
									if($pagenotfoundtitle){
										?><h1 class="main-title"><?php _e('PAGE NOT FOUND','krystal') ?></h1><?php
									}
									if($blogtitle==false && $archivetitle==false && $searchtitle==false && $pagenotfoundtitle==false){
										?><h1 class="main-title"><?php the_title(); ?></h1><?php
									}
								?>
			                    <div class="bread-crumb" typeof="BreadcrumbList" vocab="http://schema.org/">
									<?php 
										if(function_exists('bcn_display')){
											bcn_display();
										}
									?>
								</div>                                                           
			                </div>						
						</div>
					</div>
				</div>	
			</div>
			</div>	<!-- End page-title -->	
		<?php
	}	
}
endif;