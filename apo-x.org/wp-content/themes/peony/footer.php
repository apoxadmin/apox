<footer>
<?php $enable_footer_widgets  = esc_attr(peony_option('enable_footer_widgets')); ?>
<?php if ($enable_footer_widgets == '1'): ?>
	<div class="footer-widget-area">
	<div class="container">
	<div class="row">
	<?php $footer_columns = 4; ?>
	<?php for ($i = 1; $i <= $footer_columns; $i++) : ?>
		<div class="col-sm-6 col-md-<?php echo 12/$footer_columns; ?>">
			<?php if (is_active_sidebar("footer_widget_".$i)) : ?>
			<?php dynamic_sidebar("footer_widget_".$i); ?>
			<?php endif; ?>
		</div>
	<?php endfor; ?>
	</div>
	</div>
	</div>
<?php endif; ?>

<div class="footer-info-area">
<div class="container text-center">
<div class="row">
<div class="col-md-4 text-left">
	<div class="site-info">
		<?php printf(__('Designed by <a href="%s">Magee Theme</a>. All Rights Reserved.', 'peony' ),esc_url('http://www.mageewp.com/'))?>
	</div>
</div>
<div class="col-md-4 text-center">
	<ul class="footer-sns peony_footer_social_icon_1">
	<?php
	$enable_tooltip  = esc_attr(peony_option('enable_tooltip'));
	if ($enable_tooltip == '1')
		$tooltip = 'tooltip';
	else
		$tooltip = '';
	for ($i = 1; $i <= 8; $i++) {
		$social_icon  = esc_attr(peony_option('footer_social_icon_'.$i));
		$social_title = esc_attr(peony_option('footer_social_title_'.$i));
		$social_link  = esc_url(peony_option('footer_social_link_'.$i));
			
		if ($social_icon != '') {
			$social_icon  = 'fa-'.str_replace('fa-','',$social_icon);
			echo '<li><a href="'.$social_link.'" data-original-title="'.$social_title.'" title="'.$social_title.'" data-placement="top" data-toggle="'.$tooltip.'" target="_blank"><i class="fa '.$social_icon.'"></i></a></li>';
		}
	}?>
	</ul>
</div>
<div class="col-md-4 text-right">
	<a href="javascript:;" class="scroll-to-top"><i class="fa fa-angle-up"></i></a>
</div>
</div><!--row-->
</div>
</div>
</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>