<?php

$bg_padding = '';

if ( $instance['control']['style'] == 'default' ){
	$background_padding = 'background: '. $instance['control']['bg_color'].'; padding: '.$instance['control']['padding'].'px';
}else{
	$bg_padding = 'background: '. $instance['control']['bg_color'].'; padding: '.$instance['control']['padding'].'px';
}
?>

<div class="boka-testimonial-<?php echo $instance['control']['style']; ?> testimonial <?php echo $instance['heading_alignment']; ?>" style="<?php echo $bg_padding; ?>">
	<?php if ( ! empty( $instance['title'] ) ) : ?>
		<div class="<?php echo $instance['heading_alignment']; ?>-heading margin-bottom-30">
			<h2 class="margin-bottom-30 margin-null"><?php echo esc_html( $instance['title'] ); ?></h2>
		</div>
	<?php endif; ?>

	<?php if ( $instance['control']['style'] == 'default' ) { ?>

		<div class="row">
			<?php foreach( $instance['testimonial'] as $i => $testimonial ) : ?>
				<div class="col-md-<?php echo esc_attr( $instance['control']['per_row'] ); ?> col-sm-<?php echo esc_attr( $instance['control']['per_row'] ); ?> col-xs-12 margin-bottom-30">
					<div class="item-default overflow" style="<?php echo $background_padding; ?>">
						<?php

						$profile_picture = $testimonial['testimonial_profile_picture'];
						$image_details = siteorigin_widgets_get_attachment_image_src(
							$profile_picture, 'thumbnail',''
						);


						?><div class="test-name-position col-md-5 col-sm-12 col-xs-12"><?php

							if ( ! empty( $image_details ) ) {
								echo '<img src="' . esc_url( $image_details[0] ) . '" class="img-circle margin-bottom-20" />';
							}

							if ( ! empty( $testimonial['testimonial_name'] ) ) :

								if ( $instance['control']['color_name'] ){
									$color_name = 'color: '.$instance['control']['color_name'];
								}else{
									/**
									 * Primary Color
									 */
									$color_name = 'color: '.get_theme_mod( 'primary_color', '#1488cc' );
								}
								?>
								<h4 class="font-weight-400" style="<?php echo $color_name;?>"><?php echo esc_html( $testimonial['testimonial_name'] ); ?></h4>
							<?php endif;

							if ( ! empty( $testimonial['position'] ) ) :
								$color_position = 'color: '.$instance['control']['color_position'];
								?>
								<h6 class="font-weight-400" style="<?php echo $color_position; ?>"><?php echo esc_html( $testimonial['position'] ); ?></h6>
							<?php endif; ?>
						</div>

						<div class="col-md-7 col-sm-12 col-xs-12">
							<?php
							if ( ! empty( $instance['control']['quote'] ) ) : ?>
								<div class="testimonial-quote margin-bottom-10"></div>
							<?php endif;

							if ( ! empty( $testimonial['testimonial_texteditor'] ) ) :
								$color_content = 'color: '.$instance['control']['color_content'];
								?>
								<p class="font-weight-400 testimonial-details margin-null" style="<?php echo $color_content;?>">
									<?php echo  $testimonial['testimonial_texteditor'] ; ?>
								</p>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

	<?php } elseif ( $instance['control']['style'] == 'style-1' ) { ?>
		<div id="testimonial-slider-1" class="carousel carousel-1 slide" data-ride="carousel">
			<div class="carousel-inner" role="listbox">
				<?php foreach( $instance['testimonial'] as $i => $testimonial ) : ?>
					<div class="item">
						<?php

						$profile_picture = $testimonial['testimonial_profile_picture'];
						$image_details = siteorigin_widgets_get_attachment_image_src(
							$profile_picture, 'thumbnail',''
						);

						if ( ! empty( $image_details ) ) {
							echo '<img src="' . esc_url( $image_details[0] ) . '" class="img-circle center-block" />';
						}
						?><div class="test-name-position"><?php

							if ( ! empty( $testimonial['testimonial_name'] ) ) :

								if ( $instance['control']['color_name'] ){
									$color_name = 'color: '.$instance['control']['color_name'];
								}else{
									/**
									 * Primary Color
									 */
									$color_name = 'color: '.get_theme_mod( 'primary_color', '#1488cc' );
								}

								?>
								<h4 style="<?php echo $color_name;?>"><?php echo esc_html( $testimonial['testimonial_name'] ); ?></h4>
							<?php endif;

							if ( ! empty( $testimonial['position'] ) ) :
								$color_position = 'color: '.$instance['control']['color_position'];
								?>
								<h6 style="<?php echo $color_position; ?>"><?php echo esc_html( $testimonial['position'] ); ?></h6>
							<?php endif; ?>
						</div>
						<?php
						if ( ! empty( $instance['control']['quote'] ) ) : ?>
							<div class="testimonial-quote margin-top-30"></div>
						<?php endif;

						if ( ! empty( $testimonial['testimonial_texteditor'] ) ) :
							$color_content = 'color: '.$instance['control']['color_content'];
							?>
							<p class="testimonial-details margin-bottom-30 margin-top-30" style="<?php echo $color_content;?>">
								<?php echo  $testimonial['testimonial_texteditor'] ; ?>
							</p>
						<?php endif; ?>

					</div>
				<?php endforeach; ?>
			</div>
			<?php if ( $instance['control']['left_right_arrow'] != '' ) : ?>
				<div class="testimonial-indicator">
					<!-- Controls -->
					<a class="testimonial-prev" href="#testimonial-slider-1" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only"><?php esc_html_e( 'Previous', 'boka' ); ?></span>
					</a>
					<a class="testimonial-next" href="#testimonial-slider-1" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						<span class="sr-only"><?php esc_html_e( 'Next', 'boka' ); ?></span>
					</a>
				</div>
			<?php endif; ?>
			<?php
			$indicators = $instance['control']['indicators'];
			if ( $indicators == '' ){
				$indicators = 'hide';
			}
			?>

			<script>

				jQuery(document).ready(function () {

					var myCarousel = jQuery(".carousel-1");
					myCarousel.append("<ol class='carousel-indicators <?php echo $indicators; ?>'></ol>");
					var indicators = jQuery(".carousel-indicators");
					myCarousel.find(".carousel-inner").children(".item").each(function(index) {
						(index === 0) ?
							indicators.append("<li data-target='#testimonial-slider-1' data-slide-to='"+index+"' class='active'></li>") :
							indicators.append("<li data-target='#testimonial-slider-1' data-slide-to='"+index+"'></li>");
					});

					jQuery('#testimonial-slider-1').find('.item').first().addClass('active');
				});
			</script>
		</div>

	<?php } elseif ( $instance['control']['style'] == 'style-2' ) { ?>
		<div id="testimonial-slider-2" class="carousel carousel-2 slide" data-ride="carousel">
			<div class="carousel-inner" role="listbox">
				<?php foreach( $instance['testimonial'] as $i => $testimonial ) : ?>
					<div class="item">
						<?php

						$profile_picture = $testimonial['testimonial_profile_picture'];
						$image_details = siteorigin_widgets_get_attachment_image_src(
							$profile_picture, 'thumbnail',''
						);

						if ( ! empty( $image_details ) ) {
							echo '<img src="' . esc_url( $image_details[0] ) . '" class="img-circle center-block" />';
						}
						if ( ! empty( $testimonial['testimonial_texteditor'] ) ) :
							$color_content = 'color: '.$instance['control']['color_content'];
							?>
							<h3 class="testimonial-details margin-bottom-30 margin-top-30" style="<?php echo $color_content;?>">
								<b><i>" <?php echo  $testimonial['testimonial_texteditor'] ; ?> "</i></b>
							</h3>
						<?php endif; ?>
						<div class="test-name-position"><?php

							if ( ! empty( $instance['control']['quote'] ) ) : ?>
								<div class="testimonial-quote margin-top-30"></div>
							<?php endif;

							if ( ! empty( $testimonial['testimonial_name'] ) ) :
								if ( $instance['control']['color_name'] ){
									$color_name = 'color: '.$instance['control']['color_name'];
								}else{
									/**
									 * Primary Color
									 */
									$color_name = 'color: '.get_theme_mod( 'primary_color', '#1488cc' );
								}
								?>
								<h6 class="display-inline-b" style="<?php echo $color_name;?>"><?php echo esc_html( $testimonial['testimonial_name'] ); ?>, </h6>
							<?php endif;

							if ( ! empty( $testimonial['position'] ) ) :
								$color_position = 'color: '.$instance['control']['color_position'];
								?>
								<h6 class="display-inline-b" style="<?php echo $color_position; ?>"><?php echo esc_html( $testimonial['position'] ); ?></h6>
							<?php endif; ?>
						</div>

					</div>
				<?php endforeach; ?>

				<?php if ( $instance['control']['left_right_arrow'] != '' ) : ?>
					<div class="testimonial-indicator">
						<!-- Controls -->
						<a class="testimonial-prev" href="#testimonial-slider-2" role="button" data-slide="prev">
							<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
							<span class="sr-only"><?php esc_html_e( 'Previous', 'boka' ); ?></span>
						</a>
						<a class="testimonial-next" href="#testimonial-slider-2" role="button" data-slide="next">
							<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
							<span class="sr-only"><?php esc_html_e( 'Next', 'boka' ); ?></span>
						</a>
					</div>
				<?php endif; ?>

				<?php
				$indicators = $instance['control']['indicators'];
				if ( $indicators == '' ){
					$indicators = 'hide';
				}
				?>

				<script>

					jQuery(document).ready(function () {

						var myCarousel = jQuery(".carousel-2");
						myCarousel.append("<ol class='carousel-indicators <?php echo $indicators; ?>'></ol>");
						var indicators = jQuery(".carousel-indicators");
						myCarousel.find(".carousel-inner").children(".item").each(function(index) {
							(index === 0) ?
								indicators.append("<li data-target='#testimonial-slider-2' data-slide-to='"+index+"' class='active'></li>") :
								indicators.append("<li data-target='#testimonial-slider-2' data-slide-to='"+index+"'></li>");
						});

						jQuery('#testimonial-slider-2').find('.item').first().addClass('active');
					});
				</script>
			</div>
		</div>
	<?php } ?>
</div>