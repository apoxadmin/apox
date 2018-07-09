<div class="boka-brand  <?php echo $instance['heading_alignment']; ?>">
	<?php if ( ! empty( $instance['title'] ) ) : ?>
		<div class="<?php echo $instance['heading_alignment']; ?>-heading margin-bottom-30">
			<h1 class="page-header"><?php echo esc_html( $instance['title'] ); ?></h1>
		</div>
	<?php endif; ?>
	<ul class="boka-brand-list position-relative brand list-inline margin-bottom-0">
		<?php foreach( $instance['brand'] as $i => $brand ) : ?>
			<?php
			$profile_picture = $brand['profile_picture'];
			$image_details = siteorigin_widgets_get_attachment_image_src(
				$profile_picture, 'thumbnail', ''
			);
			$url = '';
			if ( ! empty( $url ) ) {
				$url = sow_esc_url( $brand['button_url'] );
			}else{
				$url = '#';
			}
			if ( ! empty( $image_details ) ) {
				echo '<li class="margin-top-20"><a href="'.$url.'" target="_blank"><img src="'. esc_url( $image_details[0] ).'" class="img-responsive center-block" /></a></li>';
			}
			?>
		<?php endforeach; ?>
	</ul>
</div>
