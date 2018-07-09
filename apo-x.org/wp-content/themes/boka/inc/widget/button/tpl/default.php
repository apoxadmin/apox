<div class="boka-button <?php echo $instance['heading_alignment']; ?>">
	<?php
	$color = "";
	if ( ! empty( $instance['color'] ) || ! empty( $instance['bgColor'] ) ) :
		$color = $instance['color'].';';
		$bgColor = $instance['bgColor'].';';
		$color = ' style="color:' . $color . ' background-color:' . $bgColor . ' border-color:' . $bgColor . '"' ;
	endif;
	?>
	<a href="<?php echo sow_esc_url( $instance['button_url'] ); ?>" class="btn"<?php echo $color; ?>><?php echo esc_html( $instance['button_text'] ); ?></a>
</div>