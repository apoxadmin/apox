<?php
/**
 * @package krystal-shop
 */


/**
 * Krystal Shop Header Style 1
 */
if ( ! function_exists( 'krystal_shop_header_style_1' ) ) :
function krystal_shop_header_style_1() {
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
				        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				    </h1>
				    <?php
				        $description = esc_attr(get_bloginfo( 'description', 'display' ));
				        if ( $description || is_customize_preview() ) { 
				            ?>
				                <p class="site-description"><?php echo $description; ?></p>
				            <?php 
				        }
				    ?>
				    <span class="res-cart-menu hidden-sm hidden-md hidden-lg">
				    	<?php
				    		if ( krystal_shop_is_woocommerce_activated() ) { 
	            				krystal_shop_wc_menu_cart_link();
	            			}
				    	?>
				    </span>
	                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	                    <span class="sr-only"><?php _e( 'Toggle navigation', 'krystal-shop' ); ?></span>
	                    <i class="fa fa-bars fa-1x"></i>
	                </button>
	            </div>
	            <?php 
	            	if ( krystal_shop_is_woocommerce_activated() ) { 
	            		?>
							<ul class="nav cart-menu navbar-nav navbar-right">
								<li class="menu-cart-inner">
									<?php krystal_shop_wc_menu_cart(); ?>
								</li>
							</ul>
						<?php 
					}
				?>
	            <div class="res-menu hidden-sm hidden-md hidden-lg">
	                <div class="navbar-collapse collapse">
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
 * Krystal Shop Header Style 2
 */
if ( ! function_exists( 'krystal_shop_header_style_2' ) ) :
function krystal_shop_header_style_2() {
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
				    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				</h1>
				<?php
				    $description = esc_attr(get_bloginfo( 'description', 'display' ));
				    if ( $description || is_customize_preview() ) { 
				        ?>
				            <p class="site-description"><?php echo $description; ?></p>
				        <?php 
				    }
				?>      
				<span class="res-cart-menu hidden-sm hidden-md hidden-lg">
				    <?php
				    	if ( krystal_shop_is_woocommerce_activated() ) { 
	            			krystal_shop_wc_menu_cart_link();
	            		}
				    ?>
				</span>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only"><?php _e( 'Toggle navigation', 'krystal-shop' ); ?></span>
                    <i class="fa fa-bars fa-1x"></i>
                </button>
            </div>
            <?php 
	            if ( krystal_shop_is_woocommerce_activated() ) { 
	            	?>
						<ul class="nav cart-menu navbar-nav navbar-right">
							<li class="menu-cart-inner">
								<?php krystal_shop_wc_menu_cart(); ?>
							</li>
						</ul>
					<?php 
				}
			?>
            <div class="res-menu hidden-sm hidden-md hidden-lg">
                <div class="navbar-collapse collapse">
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


if ( ! function_exists( 'krystal_shop_action_header_hook' ) ) :
function krystal_shop_action_header_hook() {
	if("style1" === esc_attr(get_theme_mod( 'kr_header_styles','style1'))) {
	    add_action( 'krystal_action_header', 'krystal_shop_header_style_1' );
	}
	else{
	    add_action( 'krystal_action_header', 'krystal_shop_header_style_2' );
	}
}
endif;
add_action( 'wp', 'krystal_shop_action_header_hook' );


?>