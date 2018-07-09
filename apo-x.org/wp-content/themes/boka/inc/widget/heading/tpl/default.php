<div class="boka-heading <?php echo $instance['heading_alignment']; ?>">
	<?php

	$heading_tag = $instance['heading_tag'];

	$color = "";
	if ( ! empty( $instance['color'] ) ) :
		$text_color = $instance['color'].';';
		$color = ' style="color:' . $text_color . '"' ;
	endif;

	if ( ! empty( $instance['heading'] ) ) : ?>
		<<?php echo $heading_tag; ?> class="margin-bottom-30 margin-null"<?php echo $color ?>><?php echo esc_html( $instance['heading'] ); ?></<?php echo $heading_tag; ?>>
	<?php endif;

	if ( ! empty( $instance['sub_title'] ) ) : ?>
		<p class="lead-text margin-null"<?php echo $color ?>><?php echo $instance['sub_title']; ?></p>
	<?php endif; ?>

</div>