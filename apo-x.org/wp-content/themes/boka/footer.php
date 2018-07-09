<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package boka
 */

?>

<footer class="footer-main">
	<?php if ( ( is_active_sidebar( 'footer-widget' ) ) || ( is_active_sidebar( 'footer-widget-2' ) )  || ( is_active_sidebar( 'footer-widget-3' ) )  || ( is_active_sidebar( 'footer-widget-4' ) ) ) : ?>
		<!--------------- Footer Top ---------------->
		<section class="footer-top">
			<div class="container">
				<div class="row">
					<?php

					if ( get_theme_mod( 'footer_widget_column' ) == 'four' ) { ?>

						<div class="col-md-3 col-sm-6 col-xs-12">
							<?php
							if ( is_active_sidebar( 'footer-widget' ) ) :
								dynamic_sidebar( 'footer-widget' );
							endif;
							?>
						</div>

						<div class="col-md-3 col-sm-6 col-xs-12">
							<?php
							if ( is_active_sidebar( 'footer-widget-2' ) ) :
								dynamic_sidebar( 'footer-widget-2' );
							endif;
							?>
						</div>

						<div class="col-md-3 col-sm-6 col-xs-12">
							<?php
							if ( is_active_sidebar( 'footer-widget-3' ) ) :
								dynamic_sidebar( 'footer-widget-3' );
							endif;
							?>
						</div>

						<div class="col-md-3 col-sm-6 col-xs-12">
							<?php
							if ( is_active_sidebar( 'footer-widget-4' ) ) :
								dynamic_sidebar( 'footer-widget-4' );
							endif;
							?>
						</div>

						<?php

					} elseif ( get_theme_mod( 'footer_widget_column' ) == 'three' ) { ?>

						<div class="col-md-4 col-sm-6 col-xs-12">
							<?php
							if ( is_active_sidebar( 'footer-widget' ) ) :
								dynamic_sidebar( 'footer-widget' );
							endif;
							?>
						</div>

						<div class="col-md-4 col-sm-6 col-xs-12">
							<?php
							if ( is_active_sidebar( 'footer-widget-2' ) ) :
								dynamic_sidebar( 'footer-widget-2' );
							endif;
							?>
						</div>

						<div class="col-md-4 col-sm-12 col-xs-12">
							<?php
							if ( is_active_sidebar( 'footer-widget-3' ) ) :
								dynamic_sidebar( 'footer-widget-3' );
							endif;
							?>
						</div>

						<?php

					} else { ?>

						<div class="col-md-6 col-sm-6 col-xs-12">
							<?php
							if ( is_active_sidebar( 'footer-widget' ) ) :
								dynamic_sidebar( 'footer-widget' );
							endif;
							?>
						</div>

						<div class="col-md-6 col-sm-6 col-xs-12">
							<?php
							if ( is_active_sidebar( 'footer-widget-2' ) ) :
								dynamic_sidebar( 'footer-widget-2' );
							endif;
							?>
						</div>

					<?php } ?>

				</div>
			</div>
		</section>
	<?php endif; ?>
	<!--------------- Footer bottom ---------------->
	<section class="footer-bottom">
		<div class="container">
			<div class="row">

				<?php if( get_theme_mod( 'social_footer_enable' ) ) : ?>

				<div class="col-md-6 col-sm-6 col-xs-12 footer-social">
					<?php do_action('boka_social'); ?>
				</div>

				<?php endif;

				do_action('boka_footer_copyright');

				?>
			</div>
		</div>
	</section>
</footer>
</div>
<?php wp_footer(); ?>

</body>
</html>