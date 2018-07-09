<?php
/**
 * Slide ID
 */
$sliderID = rand(1,1000);
?>
<div class="boka-camera-slider-widget camera-slider">
	<div class="boka-camera-slider<?php echo $sliderID; ?> camera_wrap">
		<?php
		foreach( $instance['CameraSlider'] as $i => $CameraSlider ) :

			$color = "";
			if ( ! empty( $CameraSlider['color'] ) || ! empty( $CameraSlider['bgColor'] ) ) :
				$color = $CameraSlider['color'].';';
				$bgColor = $CameraSlider['bgColor'].';';
				$color = ' style="color:' . $color . ' background-color:' . $bgColor . ' border-color:' . $bgColor . '"' ;
			endif;

			$title_animation = '';
			if ( ! empty( $CameraSlider['title_animation'] ) ) :
				$title_animation = 'animated '.$CameraSlider['title_animation'];
			endif;

			$content_animation = '';
			if ( ! empty( $CameraSlider['content_animation'] ) ) :
				$content_animation = 'animated '.$CameraSlider['content_animation'];
			endif;

			$btn_animation = '';
			if ( ! empty( $CameraSlider['btn_animation'] ) ) :
				$btn_animation = 'animated '.$CameraSlider['btn_animation'];
			endif;

			if ( ! empty( $CameraSlider['CameraSlider_button_text'] ) ) :
				$button = '<div class="slider-button"><a href="'.sow_esc_url($CameraSlider['CameraSlider_button_url']).'"  class="btn '.$btn_animation.'" '.$color.'>'.$CameraSlider['CameraSlider_button_text'].'</a></div>';
			endif;

			$CameraSlider_image = $CameraSlider['CameraSlider_image'];
			$image_url = siteorigin_widgets_get_attachment_image_src(
				$CameraSlider_image, '', ''
			);
			if ( ! empty( $image_url ) ) {
				$image_url = esc_url( $image_url[0] );
			}

			$CameraSlider_title_color = '';
			if(!empty($CameraSlider['CameraSlider_title_color'])) $CameraSlider_title_color = 'color: '.($CameraSlider['CameraSlider_title_color']);

			$CameraSlider_subtitle_color = '';
			if(!empty($CameraSlider['CameraSlider_subtitle_color'])) $CameraSlider_subtitle_color = 'color: '.($CameraSlider['CameraSlider_subtitle_color']);

			$text_position = '';
			if(!empty($CameraSlider['text_position'])) $text_position = $CameraSlider['text_position'];

			echo '<div  data-src="'. $image_url .'"><div class="container"><div class="camera-slider-inner '.$CameraSlider['heading_alignment'].'" style="margin:'.$text_position.'"><h1 style="'.$CameraSlider_title_color.'" class="'.$title_animation.'">'.$CameraSlider['CameraSlider_title'].'</h1><p class="'.$content_animation.'" style="'.$CameraSlider_subtitle_color.'">'.$CameraSlider['CameraSlider_subtitle'].'</p>'.$button.'</div></div></div>';

		endforeach; ?>
	</div>
</div>
<?php
/**
 * Primary Color
 */
$primary_color = get_theme_mod( 'primary_color', '#1488cc' );

/**
 * Advance Options
 */
?>
<script>
	jQuery( window ).ready(function() {
			jQuery('.boka-camera-slider<?php echo $sliderID; ?>').camera({
				fx: '<?php echo $instance['control']['effect']; ?>',
				height: '<?php echo $instance['control']['height']; ?>%',
				loader: '<?php echo $instance['control']['loader']; ?>',
				margin:'',
				alignment: 'center',
				barPosition: '<?php echo $instance['control']['barPosition']; ?>',
				thumbnails: false,
				playPause: false,
				loaderColor: '#fff',
				loaderBgColor: '<?php echo esc_attr( $primary_color ); ?>',
				hover: true,
				opacityOnGrid: true,
				pagination: false
			});

	});
</script>