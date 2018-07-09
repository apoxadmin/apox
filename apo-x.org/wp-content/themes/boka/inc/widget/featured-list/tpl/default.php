<div class="boka-featured-list">
	<?php foreach( $instance['FeaturedList'] as $i => $FeaturedList ) : ?>
		<div class="col-md-<?php echo esc_attr( $instance['per_row'] ); ?> col-sm-<?php echo esc_attr( $instance['per_row'] ); ?> col-xs-12 margin-top-30">
			<div class="featured-list">
				<?php if ( $FeaturedList['image_icon'] == 'icon' ) :

					$icon_styles = array();

					if(!empty($FeaturedList['icon_color'])) $icon_styles[] = 'color: '.$FeaturedList['icon_color'];
					echo  '<div class="margin-bottom-30 featured-list-image-icon">' .siteorigin_widget_get_icon( $FeaturedList['icons'], $icon_styles ).'</div>';

				else :
					$profile_picture = $FeaturedList['image'];
					$image_details = siteorigin_widgets_get_attachment_image_src(
						$profile_picture, 'boka-medium-thumb', ''
					);
					if ( ! empty( $image_details ) ) {
						echo '<img src="' . esc_url( $image_details[0] ) . '" class="margin-bottom-30 featured-list-image-icon" />';
					}
				endif;
				if ( ! empty( $FeaturedList['title'] ) ) : ?>
					<h3 class="margin-null font-weight-400"><?php echo esc_html( $FeaturedList['title'] ); ?></h3>
				<?php endif; ?>
				<?php if ( ! empty( $FeaturedList['sub_title'] ) ) : ?>
					<p class="margin-null"><?php echo esc_html( $FeaturedList['sub_title'] ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	<?php endforeach; ?>
</div>