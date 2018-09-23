<?php

/**
 * Woocommerce Categories Section Widget
 */


if( ! class_exists('Krystal_shop_Woo_Cat_Section_Widget')) :
class Krystal_shop_Woo_Cat_Section_Widget extends WP_Widget {
	var $defaults;
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'kr_wo_cat_section_widget', // Base ID
			__( 'Krystal Shop: Woocommerce Categories Section', 'krystal-shop' ), // Name
			array( 'description' => __( 'Adds Woocommerce Categories with image', 'krystal-shop' ),
			'panels_groups' => array('krystal-shop') ) // Args
		);	        
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$nop = ! empty( $instance['nop'] ) ? $instance['nop'] : '4';
		?>

		<div class="woocat-wrapper">
			<div class="content">
				<div class="woocat-wrapper-inner">
					<div class="row">
						<div class="woocat-inner">
                            <div id="woocat-show" class="woocat-list">
                                <?php
									$taxonomyName = "product_cat";
									$prod_categories = get_terms($taxonomyName, array(
									    'orderby'=> 'name',
									    'order' => 'ASC',
									    'hide_empty' => 1,
									    'number' => $nop,
									));  
									foreach( $prod_categories as $prod_cat ) {
								    	if ( $prod_cat->parent != 0 ){
								    		continue;
								    	}											    	
										$cat_thumb_id = get_term_meta( $prod_cat->term_id, 'thumbnail_id', true );
										$cat_thumb_url = wp_get_attachment_image_src( $cat_thumb_id,array('250','170'));
										$term_link = get_term_link( $prod_cat, 'product_cat' );				    		
								    	?>
								    		<div class="cat-item col-lg-3 col-md-3 col-sm-6 col-xs-12">
						                        <div class="cat-inner">   
						                           	<figure class="imghv">
						                            	<?php
						                            		if(!empty(esc_url($cat_thumb_url[0]))) {
						                            			?><img class="img-responsive" src="<?php echo esc_url($cat_thumb_url[0]) ?>" alt="<?php echo esc_attr($prod_cat->name) ?>"><?php
						                            		}
						                            		else{
						                            			?><img class="img-responsive" src="<?php echo get_stylesheet_directory_uri(); ?>/img/blog-no-image.jpg" alt="<?php echo esc_attr($prod_cat->name) ?>"><?php
						                            		}
						                            	?>
													</figure>
												</div>
						                        <div class="description">
						                            <h5><a href="<?php echo esc_url($term_link) ?>"><?php echo esc_attr($prod_cat->name) ?></a></h5>	
						                            <p><?php echo esc_attr($prod_cat->count) ?> <?php _e("ITEMS","krystal-shop") ?></p>                            	
						                        </div>
						                    </div>
								    	<?php 
								    } 
									wp_reset_query(); 
								?>                                                 
                            </div>
                        </div>						
					</div>
				</div>
			</div>
		</div>		
       <?php
    }
	
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
	$nop = ! empty( $instance['nop'] ) ? $instance['nop'] : '';           
    ?>
		<p>
	        <label for="<?php echo $this->get_field_id('nop'); ?>"><?php _e('Number of posts:','krystal-shop'); ?></label>
	        <input class="widefat" id="<?php echo $this->get_field_id('nop'); ?>" name="<?php echo $this->get_field_name('nop'); ?>" type="text" value="<?php echo absint($nop); ?>" />
	    </p>	    
       
    <?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;		
		$instance[ 'nop'] = absint( $new_instance['nop']);        
    	return $instance;
	}

}
endif;



if( ! function_exists('register_krystal_shop_woo_cat_section_widget')) :
// register widget
function register_krystal_shop_woo_cat_section_widget() {
    register_widget( 'Krystal_shop_Woo_Cat_Section_Widget' );
}
endif;

add_action( 'widgets_init', 'register_krystal_shop_woo_cat_section_widget' );
