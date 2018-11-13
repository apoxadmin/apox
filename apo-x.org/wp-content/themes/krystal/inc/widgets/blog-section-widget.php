<?php

/**
 * Blog Section widget.
 */


if( ! class_exists('Krystal_Blog_Section_Widget')) :

class Krystal_Blog_Section_Widget extends WP_Widget {

	var $defaults;

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'krystal_blog_widget', // Base ID
			__( 'Krystal: Blog Section', 'krystal' ), // Name
			array( 'description' => __( 'Adds Blog section', 'krystal'), ) // Args
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
		extract( $args );
		extract( wp_parse_args( $instance, $this->defaults ) ); 	
		
	    $nop = ! empty( $instance['nop'] ) ? $instance['nop'] : '2';	    

	    $options = array(
        	'post_type' => 'post',
        	'posts_per_page' => $nop,
    	);       

    	$query = new WP_Query( $options );
    	// run the loop based on the query
    	if ( $query->have_posts() ) { 
       		?>
       			<section id="blog-section">
       				<div class="blog-content">
		                <div class="container">		                    
		                    <div class="row">
		                    	<?php
									while ( $query->have_posts() ) {
										$query->the_post();
										$postid = get_the_ID();

										?>
											<div class="col-md-6 col-sm-6 col-xs-12">
					                            <article>
					                                <div class="blog-wrapper" >
					                                    <?php
											                if ( has_post_thumbnail()) {
											                    ?>
											                        <div class="image">
											                            <?php
											                                the_post_thumbnail('full');
											                            ?>
											                        </div>                      
											                    <?php                    
											                }                   
											            ?>
											            <div class="meta-wrapper">
											                <div class="meta">
											                    <?php
											                        if(is_sticky()){
											                            ?>                                        
											                                <span class="meta-item">
											                                    <i class="fa fa-thumb-tack"></i><?php _e('Sticky Post','krystal') ?>
											                                </span> 
											                            <?php       
											                        }                                
											                    ?>              
											                    <span class="meta-item">
											                        <i class="fa fa-clock-o"></i><?php the_time(get_option('date_format')) ?>
											                    </span>                                            
											                    <span class="meta-item">
											                        <i class="fa fa-user"></i><a class="author-post-url" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>"><?php the_author() ?></a>
											                    </span>                        
											                    <span class="meta-item">
											                        <i class="fa fa-commenting"></i><?php comments_number('0','1','%'); ?> <?php _e('Comments','krystal'); ?>
											                    </span>
											                </div>  
											            </div>					                                    
					                                    <div class="blog-content">
					                                        <div class="heading">
					                                            <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
					                                        </div>
					                                        <div class="blog-excerpt">
					                                            <p><?php the_excerpt(); ?></p>
					                                        </div>
					                                    </div>
					                                    <div class="read-more">
					                                        <a href="<?php the_permalink() ?>"><?php _e('READ MORE ','krystal'); ?></a>
					                                    </div>
					                                </div>
					                            </article>
					                        </div>
										<?php
									}
								?>
		                    </div>
		                </div>
		            </div>
       			</section>
       		<?php
    	}
    	wp_reset_postdata();
    }
	
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {				
	    $nop = ! empty( $instance['nop'] ) ? $instance['nop'] : '2';    
	  
	    ?>     	  	    	
		    <p>
		        <label for="<?php echo $this->get_field_id('nop'); ?>"><?php _e('Number of posts:','krystal'); ?></label>
		        <input class="widefat" id="<?php echo $this->get_field_id('nop'); ?>" name="<?php echo $this->get_field_name('nop'); ?>" type="text" value="<?php echo $nop; ?>" />
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
     	$instance['nop'] = absint( $new_instance['nop'] );       

    	return $instance;
	}

}
endif;



if( ! function_exists('krystal_register_blog_section_widget')) :
// register widget
function krystal_register_blog_section_widget() {
    register_widget( 'Krystal_Blog_Section_Widget' );
}
endif;

add_action( 'widgets_init', 'krystal_register_blog_section_widget' );
