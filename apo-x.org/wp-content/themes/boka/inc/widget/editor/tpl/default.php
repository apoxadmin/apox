<div class="boka-editor <?php echo $instance['heading_alignment']; ?>">
	<?php if ( ! empty( $instance['icon'] ) ) :
		?><div class="margin-bottom-30"><?php
		$icon_styles = array();
		if(!empty($instance['icon_size'])) $icon_styles[] = 'font-size: '.intval($instance['icon_size']).'px';
		if(!empty($instance['icon_color'])) $icon_styles[] = 'color: '.$instance['icon_color'];
		echo  siteorigin_widget_get_icon( $instance['icon'], $icon_styles );
		?></div><?php
	endif; ?>
	<?php if ( ! empty( $instance['sub_title'] ) ||  ! empty( $instance['title'] ) ) : ?>
	<div class="<?php echo $instance['heading_alignment']; ?>-heading margin-bottom-30">
		<?php if ( ! empty( $instance['title'] ) ) : ?>
			<h1 class="page-header"><?php echo esc_html( $instance['title'] ); ?></h1>
		<?php endif; ?>
		<?php if ( ! empty( $instance['sub_title'] ) ) : ?>
			<h3 class="widget-sub-heading margin-null"><?php echo esc_html( $instance['sub_title'] ); ?></h3>
		<?php endif; ?>
	</div>
	<?php endif; ?>
	<?php if ( ! empty( $instance['texteditor'] ) ) : ?>
		<div class="services-details"><?php echo  $instance['texteditor']; ?></div>
	<?php endif; ?>
	<?php if ( ! empty( $instance['button_text'] ) ) : ?>
		<div class="default-button margin-top-30"><a href="<?php echo  sow_esc_url($instance['button_url']); ?>" class="btn <?php echo  $instance['button_style']; ?>"><?php echo  $instance['button_text']; ?></a></div>
	<?php endif; ?>
</div>