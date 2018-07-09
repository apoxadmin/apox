<div class="boka-team text-center row">
	<?php foreach( $instance['team'] as $i => $team ) : ?>
		<div class="boka-team-list team-list col-md-<?php echo esc_attr( $instance['per_row'] ); ?> col-sm-6 col-xs-12 margin-bottom-30">
			<div class="team-details">

				<?php
				$profile_picture = $team['profile_picture'];
				$profile_picture_fallback = $team['profile_picture_fallback'];
				$image_details = siteorigin_widgets_get_attachment_image_src(
					$profile_picture, 'boka-team-thumb', ''
				);
				if ( ! empty( $image_details ) ) {
					echo '<img src="' . esc_url( $image_details[0] ) . '" class="img-responsive img-circle center-block margin-bottom-30" alt="" />';
				} ?>

				<?php if ( ! empty( $team['name'] ) ) : ?>
					<h3 class="margin-null"><?php echo esc_html( $team['name'] ); ?></h3>
				<?php endif; ?>
				<?php if ( ! empty( $team['position'] ) ) : ?>
					<p class="margin-null"><?php echo  $team['position'] ; ?></p>
				<?php endif; ?>

				<ul class="list-inline margin-top-20">
					<?php if ( ! empty( $team['facebook'] ) ) : ?>
						<li><a href="<?php echo sow_esc_url( $team['facebook'] );?>" class="fb-team" target="_blank"><i class="fa fa-facebook"></i></a></li>
					<?php endif; ?>
					<?php if ( ! empty( $team['linkedin'] ) ) : ?>
						<li><a href="<?php echo sow_esc_url( $team['linkedin'] );?>" class="li-team" target="_blank"><i class="fa fa-linkedin"></i></a></li>
					<?php endif; ?>
					<?php if ( ! empty( $team['twitter'] ) ) : ?>
						<li><a href="<?php echo sow_esc_url( $team['twitter'] );?>" class="tw-team" target="_blank"><i class="fa fa-twitter"></i></a></li>
					<?php endif; ?>
					<?php if ( ! empty( $team['youtube'] ) ) : ?>
						<li><a href="<?php echo sow_esc_url( $team['youtube'] );?>" class="yt-team" target="_blank"><i class="fa fa-youtube-play"></i></a></li>
					<?php endif; ?>
				</ul>

			</div>
		</div>
	<?php endforeach; ?>
</div>
