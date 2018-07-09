<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package boka
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="wrap-fix">
	<header class="header">
		<?php if ( get_theme_mod( 'enable_top_bar' ) ) : ?>
			<section class="top-bar">
				<div class="container">
					<div class="row">
						<?php if ( get_theme_mod( 'top_bar_text' ) ) : ?>
							<div class="col-md-6 col-sm-6 col-xs-12 top-bar-text">
								<p><?php echo get_theme_mod( 'top_bar_text' ); ?></p>
							</div>
						<?php endif;

						if( get_theme_mod( 'enable_top_bar_social' ) ) : ?>

							<div class="col-md-6 col-sm-6 col-xs-12 header-social">
								<?php do_action('boka_social'); ?>
							</div>

						<?php endif; ?>
					</div>
				</div>
			</section>
		<?php endif; ?>
		<!--------------- Header Top ---------------->
		<section class="header-top position-relative text-capitalize">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<!--------------- Primary Menu ---------------->
						<nav class="navbar navbar-default primary-menu">
							<div class="site-branding logo">
								<?php
								if ( get_theme_mod('custom_logo') && function_exists('the_custom_logo') )  :
									the_custom_logo();
								else : ?>
									<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
									<p class="site-title"><?php bloginfo( 'description' ); ?></p>
								<?php endif ?>
							</div>
							<div class="navbar-header">
								<button type="button" data-toggle="collapse" data-target="#navbar-collapse" class="navbar-toggle">
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
							</div>
							<?php  if ( class_exists( 'WooCommerce' ) || get_theme_mod( 'search_enable' ) ) : ?>
								<div class="text-right search-cart">
									<ul class="list-inline margin-null">
										<?php if( get_theme_mod( 'search_enable' ) ) : ?>
											<!--------------- Search ---------------->
											<li class="dropdown search">
												<a data-toggle="dropdown" class="search-border" href="#" aria-expanded="true"><i class="fa fa-search"></i></a>
												<form role="search" method="get" class="dropdown-menu search-fix" action="<?php echo esc_url( home_url( '/' )); ?>">
													<input type="search" class="search-field form-control"
														   placeholder="<?php echo esc_attr( 'Search ...', 'boka' ); ?>"
														   value="<?php echo get_search_query() ?>" name="s" />
													<button type="submit"><i class="fa fa-search"></i></button>
												</form>
											</li>
										<?php endif ;
										 if ( class_exists( 'WooCommerce' ) ) : ?>
											<li class="cart-icon text-left">
												<a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" >
													<i class="fa fa-shopping-basket"></i>
													<span>
														<?php echo sprintf ( _n( ' %d', ' %d', WC()->cart->get_cart_contents_count(), 'boka' ), WC()->cart->get_cart_contents_count() ); ?>
													</span>
												</a>
												<div class="mini-cart">
													<?php woocommerce_mini_cart(); ?>
												</div>
											</li>
										<?php endif; ?>
									</ul>
								</div>
							<?php endif; ?>
							<div id="navbar-collapse" class="navbar-collapse collapse">
								<?php
								wp_nav_menu( array(
										'menu'              => 'primary',
										'theme_location'    => 'primary',
										'menu_id'			=> 'primary-menu',
										'container'         => '',
										'container_class'   => 'collapse navbar-collapse',
										'container_id'      => 'bs-example-navbar-collapse-1',
										'menu_class'        => 'nav navbar-nav',
										'fallback_cb'       => 'boka_wp_bootstrap_navwalker::fallback',
										'walker'            => new boka_wp_bootstrap_navwalker())
								);
								?>
							</div>
						</nav>
					</div>
				</div>
			</div>
		</section>
		<?php if ( get_theme_mod( 'enable_hero_area' ) && is_front_page() ) : ?>
			<div class="header-banner-image position-relative<?php echo get_header_image() ? ' banner-banner-content-fix' : ''; ?>">
				<?php if ( get_header_image() ) : ?>
					<img src="<?php header_image(); ?>"  alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" class="img-responsive">
				<?php endif; ?>
				<div class="header-banner-contents text-center">
					<?php if ( get_theme_mod( 'header_banner_heading' ) != '' ) : ?>
					<h1><?php echo esc_html( get_theme_mod( 'header_banner_heading' ) ); ?></h1>
					<?php endif;
					if ( get_theme_mod( 'header_banner_text' ) != '' ) : ?>
					<p><?php echo esc_html( get_theme_mod( 'header_banner_text' ) ); ?></p>
					<?php endif;
					if ( get_theme_mod( 'header_banner_button_text' ) != '' ) : ?>
					<a href="<?php echo esc_url( get_theme_mod( 'header_banner_button_link' ) ); ?>" class="btn"><?php echo esc_html( get_theme_mod( 'header_banner_button_text' ) ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
	</header>

<?php boka_title(); ?>