<div class="boka-list-items">
	<?php

	$color = "";
	if ( ! empty( $instance['color'] ) ) :
		$color = " style = " .' color:' . $instance['color']. "";
	endif;

	if ( ! empty( $instance['heading'] ) ) : ?>
		<h3 class="margin-bottom-30 margin-null"<?php echo $color ?>><?php echo esc_html( $instance['heading'] ); ?></h3>
	<?php endif;

	if ( ! empty( $instance['sub_title'] ) ) : ?>
		<p <?php echo $color ?>><?php echo $instance['sub_title']; ?></p>
	<?php endif; ?>

	<ul class="list-items list-unstyled">

		<?php

		foreach( $instance['listItems'] as $i => $listItems ) :

			$icon_image = '';

			$icon_styles = array();
			if(!empty($listItems['icon_size'])) $icon_styles[] = 'font-size: '.intval($listItems['icon_size']).'px';
			if(!empty($listItems['icon_color'])) $icon_styles[] = 'color: '.$listItems['icon_color'];
			$icon_image =  siteorigin_widget_get_icon( $listItems['icons'], $icon_styles );

			if ( ! empty( $listItems['sub_title'] ) ) : ?>
				<li><?php echo $icon_image . esc_html( $listItems['sub_title'] ); ?></li>
			<?php endif;

		endforeach; ?>
	</ul>
</div>