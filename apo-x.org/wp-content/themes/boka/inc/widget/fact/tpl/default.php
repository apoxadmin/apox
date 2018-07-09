<div class="boka-fact-widget fact-list padding-gap-3 padding-gap-4 <?php echo $instance['heading_alignment']; ?>">
	<?php if ( ! empty( $instance['title'] ) ) : ?>
		<div class="<?php echo $instance['heading_alignment']; ?>-heading margin-bottom-30">
			<h1 class="page-header"><?php echo esc_html( $instance['title'] ); ?></h1>
		</div>
	<?php endif; ?>
	<ul class="boka-fact-list position-relative list-inline text-capitalize">
		<?php foreach( $instance['fact'] as $i => $fact ) :
			echo '<li><h4>'.$fact['menu_title'].'</h4><h1>'.$fact['texteditor'].'</h1></li>';
		endforeach; ?>
	</ul>
</div>
