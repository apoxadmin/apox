<div class="boka-content-box <?php echo $instance['heading_alignment']; ?>">
	<?php foreach( $instance['contentBox'] as $i => $contentBox ) : ?>
		<div class="col-md-<?php echo esc_attr( $instance['per_row'] ); ?> col-sm-<?php echo esc_attr( $instance['per_row'] ); ?> col-xs-12 margin-top-30">
			<div class="content-box">
				<?php if ( $contentBox['image_icon'] == 'icon' ) :

					$icon_styles = array();
					if(!empty($contentBox['icon_size'])) $icon_styles[] = 'font-size: '.intval($contentBox['icon_size']).'px';
					if(!empty($contentBox['icon_color'])) $icon_styles[] = 'color: '.$contentBox['icon_color'];
					echo  '<div class="margin-bottom-30">' .siteorigin_widget_get_icon( $contentBox['icons'], $icon_styles ).'</div>';

				else :
					$profile_picture = $contentBox['image'];
					$image_details = siteorigin_widgets_get_attachment_image_src(
						$profile_picture, 'boka-medium-thumb', ''
					);
					if ( ! empty( $image_details ) ) {
						echo '<img src="' . esc_url( $image_details[0] ) . '" class="margin-bottom-30" />';
					}
				endif;
				if ( ! empty( $contentBox['title'] ) ) : ?>
					<h3 class="margin-null margin-bottom-30 font-weight-400"><?php echo esc_html( $contentBox['title'] ); ?></h3>
				<?php endif; ?>
				<?php if ( ! empty( $contentBox['sub_title'] ) ) : ?>
					<p class="margin-null"><?php echo esc_html( $contentBox['sub_title'] ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	<?php endforeach; ?>
</div>