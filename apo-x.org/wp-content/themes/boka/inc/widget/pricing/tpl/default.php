<div class="boka-pricing row <?php echo $instance['heading_alignment']; ?>">


	<?php foreach( $instance['pricing'] as $i => $pricing ) :
		$color = "";
		$button = "";
		$text_color = "";
		if ( ! empty( $pricing['color'] ) ) :
			$button = $pricing['color'].';';
			$text_color = $pricing['color'].';';
			$bg_color = $pricing['color'].';';

			$button = ' style=" background-color:' . $button . ' border-color:' . $button . '"' ;
			$text_color = ' style="color:' . $text_color . '"' ;
			$bg_color = ' style="background-color:' . $bg_color . '"' ;

		endif;

		?>

		<div class="col-md-<?php echo esc_attr( $instance['per_row'] ); ?> col-sm-<?php echo esc_attr( $instance['per_row'] ); ?> col-xs-12 margin-bottom-30">
			<div class="pricing-list">
				<h3 class="margin-null plan-name"<?php echo $bg_color; ?>><?php echo $pricing['planName']; ?></h3>
				<h2 class="currency-amount"<?php echo $text_color; ?>><span class="small"<?php echo $text_color; ?>><?php echo $pricing['currency']; ?></span><?php echo $pricing['amount']; ?></h2>
				<div class="margin-top-30"><?php echo $pricing['texteditor']; ?></div>

				<?php

				if ( ! empty( $pricing['button_text'] ) ) : ?>
					<a href="<?php echo sow_esc_url($pricing['button_url']); ?>" class="btn margin-top-30"<?php echo $button; ?>><?php echo $pricing['button_text']; ?></a>
				<?php endif; ?>

			</div>
		</div>

	<?php endforeach; ?>
</div>