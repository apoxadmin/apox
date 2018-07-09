<div class="boka-newsletter">
	<?php if ( ! empty( $instance['title'] ) ) : ?>
		<div class="margin-bottom-30">
			<h4><?php echo esc_html( $instance['title'] ); ?></h4>
		</div>
	<?php endif; ?>
	<div class="newsletter-widget newsletter">
		<form class="position-relative" action="<?php echo esc_url( $instance['action_url'], 'boka' ); ?>" method="post" target="_blank">
			<input type="email" class="form-control" name="EMAIL" id="newsletter-email" placeholder="info@yoursite.com" required="">
			<button type="submit" class="btn"><i class="fa fa-envelope"></i></button>
		</form>
	</div>
</div>
