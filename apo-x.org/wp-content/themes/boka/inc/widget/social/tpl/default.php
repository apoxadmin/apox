<div class="boka-social-media">
	<?php if ( ! empty( $instance['title'] ) ) : ?>
		<div class="margin-bottom-30">
			<h1 class="page-header"><?php echo esc_html( $instance['title'] ); ?></h1>
		</div>
	<?php endif; ?>
	<div class="social-widget social-media">
		<ul class="list-inline margin-bottom-0">
			<?php
			if(get_theme_mod('footer_fb')) {
				echo '<li><a href="'.esc_url(get_theme_mod('footer_fb')).'"  target="_blank"><i class="fa fa-facebook"></i></a></li>';
			}
			if(get_theme_mod('footer_tw')) {
				echo '<li><a href="'.esc_url(get_theme_mod('footer_tw')).'" target="_blank"><i class="fa fa-twitter"></i></a></li>';
			}
			if(get_theme_mod('footer_li')) {
				echo '<li><a href="'.esc_url(get_theme_mod('footer_li')).'" target="_blank"><i class="fa fa-linkedin"></i></a></li>';
			}
			if(get_theme_mod('footer_pint')) {
				echo '<li><a href="'.esc_url(get_theme_mod('footer_pint')).'" target="_blank"><i class="fa fa-pinterest"></i></a></li>';
			}
			if(get_theme_mod('footer_ins')) {
				echo '<li><a href="'.esc_url(get_theme_mod('footer_ins')).'" target="_blank"><i class="fa fa-linkedin"></i></a></li>';
			}
			if(get_theme_mod('footer_dri')) {
				echo '<li><a href="'.esc_url(get_theme_mod('footer_dri')).'" target="_blank"><i class="fa fa-dribbble"></i></a></li>';
			}
			if(get_theme_mod('footer_plus')) {
				echo '<li><a href="'.esc_url(get_theme_mod('footer_plus')).'" target="_blank"><i class="fa fa-google-plus"></i></a></li>';
			}
			if(get_theme_mod('footer_you')) {
				echo '<li><a href="'.esc_url(get_theme_mod('footer_you')).'" target="_blank"><i class="fa fa-youtube"></i></a></li>';
			}
			?>
		</ul>
	</div>
</div>
