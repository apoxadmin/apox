<?php
/**
 * Product search template.
 *
 * @package krystal-shop
 */

?>
<div class="krystal-product-search">
	<form role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
			$terms = get_terms( array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => true,
				'parent'     => 0,
			) );
		?>
		<?php 
			if (  ! empty( $terms ) && ! is_wp_error( $terms ) ) { 
				?>
					<div class="krystal-search-wrap">
						<?php 
							$current = ( isset( $_GET['product_cat'] ) ) ? esc_attr( $_GET['product_cat'] ) : ''; 
						?>
						<select class="select_products" name="product_cat">
							<option value=""><?php _e( 'All Categories', 'krystal-shop' ); ?></option>
							<?php 
								foreach ( $terms as $cat ) { 
									?>
										<option value="<?php echo esc_attr( $cat->name ); ?>" <?php selected( $current, esc_attr( $cat->name ) ); ?> ><?php echo esc_attr( $cat->name ); ?></option>
									<?php 
								} 
							?>
						</select>
					</div>
				<?php 
			} 
		?>
		<div class="krystal-search-form">
			<input type="search" id="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>" class="search-field" placeholder="<?php echo __( 'Search products&hellip;', 'krystal-shop' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
			<input type="submit" class="fa" value="&#xf002;&nbsp;<?php echo __('Search','krystal-shop') ?>" />
			<input type="hidden" name="post_type" value="product" />
		</div>
	</form>
</div>
