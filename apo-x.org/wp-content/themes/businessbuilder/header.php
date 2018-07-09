<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package businessbuilder
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'businessbuilder' ); ?></a>
		<header id="masthead" class="site-header" role="banner">
			<?php if ( get_theme_mod( 'toggle_header_frontpage' ) == '' ) : ?>
			<div class="site-branding container">
				<?php
				if ( has_custom_logo() ) {

					businessbuilder_the_custom_logo();
				}?>
				<a href="<?php echo esc_url(home_url()); ?>">
					<span class="site-title">
						<?php bloginfo( 'name' ); ?>
					</span>
				</a>
				<p class="site-description">
					<?php bloginfo( 'description' ); ?>
				</p>
			</div>
		<?php else : ?>
		<?php if ( is_front_page() ) : ?>
		<div class="site-branding container">
			<?php
			if ( has_custom_logo() ) {

				businessbuilder_the_custom_logo();
			}?>
			<a href="<?php echo esc_url(home_url()); ?>">
				<span class="site-title">
					<?php bloginfo( 'name' ); ?>
				</span>
			</a>
			<p class="site-description">
				<?php bloginfo( 'description' ); ?>
			</p>
		</div>
	<?php endif; ?>
<?php endif; ?>

<nav id="site-navigation" class="main-navigation" role="navigation">
	<div class="top-nav container">
		<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
			<span class="m_menu_icon"></span>
			<span class="m_menu_icon"></span>
			<span class="m_menu_icon"></span>
		</button>
		<div class="mobile-site-name">
			<a href="<?php echo home_url(); ?>">
				<?php echo get_bloginfo( 'name' ); ?>
			</a>
		</div>
		<div class="menu-wrapper">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
		</div>
	</div>
</nav><!-- #site-navigation -->
</header><!-- #masthead -->

<?php if ( get_theme_mod( 'toggle_widget_frontpage' ) == '' ) : ?>
	<?php if ( is_active_sidebar( 'top_widget_left') ||  is_active_sidebar( 'top_widget_middle') ||  is_active_sidebar( 'top_widget_right')  ) : ?>
	<div class="container">
		<div class="top-widget-container">
			<div class="top-widget-grid">
				<?php dynamic_sidebar( 'top_widget_left' ); ?>
			</div>
			<div class="top-widget-grid">
				<?php dynamic_sidebar( 'top_widget_middle' ); ?>
			</div>
			<div class="top-widget-grid">
				<?php dynamic_sidebar( 'top_widget_right' ); ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php else : ?>
	<?php if ( is_front_page() ) : ?>
	<?php if ( is_active_sidebar( 'top_widget_left') ||  is_active_sidebar( 'top_widget_middle') ||  is_active_sidebar( 'top_widget_right')  ) : ?>
	<div class="container">
		<div class="top-widget-container">
			<div class="top-widget-grid">
				<?php dynamic_sidebar( 'top_widget_left' ); ?>
			</div>
			<div class="top-widget-grid">
				<?php dynamic_sidebar( 'top_widget_middle' ); ?>
			</div>
			<div class="top-widget-grid">
				<?php dynamic_sidebar( 'top_widget_right' ); ?>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php endif; ?>
<?php endif; ?>
<div id="content" class="site-content">