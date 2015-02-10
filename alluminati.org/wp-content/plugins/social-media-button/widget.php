<?php
class SMButtonsWidget extends WP_Widget {

	public function SMButtonsWidget() {
        parent::__construct(
            'sm_buttons_widget',
            __('Social Media Buttons', 'smbuttons' ),
            array( 'description' => __( 'A widget that displays various social media button at Wordpress widgets area.', 'smbuttons' ), )
        );
    }// end constructor

	function widget( $args, $instance ) {
		// Widget output
	    extract( $args );
	 
	    /* Our variables from the widget settings. */
	    $this->widget_title = apply_filters('widget_title', $instance['title'] );

	    $this->fb_button	=	($instance['fb_button'] == "1" ? "true" : "false");
	    $this->g_plus		=	($instance['g_plus'] == "1" ? "true" : "false");
	    $this->linkedin 	=	($instance['linkedin'] == "1" ? "true" : "false");
	    $this->twitter 		=	($instance['twitter'] == "1" ? "true" : "false");
	    $this->youtube 		=	($instance['youtube'] == "1" ? "true" : "false");
	    $this->pinterest 	=	($instance['pinterest'] == "1" ? "true" : "false");
	    $this->github 		=	($instance['github'] == "1" ? "true" : "false");

	    $this->fb_url 		= 	$instance['fb_url'];
	    $this->gp_url 		=	$instance['gp_url'];
	    $this->in_url 		=	$instance['in_url'];
	    $this->t_url 		=	$instance['t_url'];
	    $this->y_url 		=	$instance['y_url'];
	    $this->pin_url 		=	$instance['pin_url'];
	    $this->git_url 		=	$instance['git_url'];

	    $this->icon_color 			=	$instance['icon_color'];
	    $this->icon_hover_color 	=	$instance['icon_hover_color'];
	    $this->icon_bg_color 		=	$instance['icon_bg_color'];
	    $this->icon_hover_bg_color 	=	$instance['icon_hover_bg_color'];

	    add_action( 'wp_footer', array( $this, 'sm_buttons_custom_style' ) );

	   	//Display Sidebar
	   	?>
	   		<aside class="widget widget_smbuttons">
	   	<?php
		    if ( $this->widget_title ){
		        echo '<h1 class="widget-title">'.$this->widget_title.'</h1>';
		    }
	    ?>
	        <div class="widget-content">
	        	<?php if ( $this->fb_button == "true" ): ?>
	        		<a class="facebook" title="Facebook" target="_blank" href="<?php echo $this->fb_url ?>"><i class="fa fa-facebook"></i></a>
	        	<?php endif; ?>

	        	<?php if ( $this->g_plus == "true" ): ?>
	        		<a title="Google+" target="_blank" href="<?php echo $this->gp_url ?>"><i class="fa fa-google-plus"></i></a>
				<?php endif; ?>

	        	<?php if ( $this->linkedin == "true" ): ?>
	        		<a title="LinkedIn" target="_blank" href="<?php echo $this->in_url ?>"><i class="fa fa-linkedin"></i></a>
				<?php endif; ?>

	        	<?php if ( $this->twitter == "true" ): ?>
	        		<a title="Twitter" target="_blank" href="<?php echo $this->t_url ?>"><i class="fa fa-twitter"></i></a>
				<?php endif; ?>

	        	<?php if ( $this->youtube == "true" ): ?>
	        		<a title="Youtube" target="_blank" href="<?php echo $this->y_url ?>"><i class="fa fa-youtube"></i></a>
				<?php endif; ?>

	        	<?php if ( $this->pinterest == "true" ): ?>
	        		<a title="Pinterest" target="_blank" href="<?php echo $this->pin_url ?>"><i class="fa fa-pinterest"></i></a>
				<?php endif; ?>

	        	<?php if ( $this->github == "true" ): ?>
	        		<a title="GitHub" target="_blank" href="<?php echo $this->git_url ?>"><i class="fa fa-github"></i></a>
				<?php endif; ?>
	        </div>
	        </aside>
	    <?php
	}

	public function sm_buttons_custom_style(){ ?>
		<style>
			.widget.widget_smbuttons .widget-content {margin: 20px 0;}
			.widget.widget_smbuttons a {background: <?php echo $this->icon_bg_color; ?>;border-radius: 50px;padding: 10px;}
			.widget.widget_smbuttons a.facebook {padding: 10px 15px;}
			.widget.widget_smbuttons a:hover {background: <?php echo $this->icon_hover_bg_color; ?>;-webkit-transition: all 1s;transition: all 1s;}
			.widget.widget_smbuttons a:hover i {color: <?php echo $this->icon_hover_color; ?>;-webkit-transition: all 1s;transition: all 1s;}
			.widget.widget_smbuttons i {color: <?php echo $this->icon_color; ?>;font-size: 20px;line-height: 50px;vertical-align: middle;}
		</style>
	<?php }

	function update( $new_instance, $old_instance ) {
		// Save widget options
	    $instance = $old_instance;
	 
	    /* Strip tags for title and name to remove HTML (important for text inputs). */
	    $instance['title'] = strip_tags( $new_instance['title'] );
	    
	    $instance['fb_url'] = strip_tags( $new_instance['fb_url'] );
	    $instance['gp_url'] = strip_tags( $new_instance['gp_url'] );
	    $instance['in_url'] = strip_tags( $new_instance['in_url'] );
	    $instance['t_url'] = strip_tags( $new_instance['t_url'] );
	    $instance['y_url'] = strip_tags( $new_instance['y_url'] );
	    $instance['pin_url'] = strip_tags( $new_instance['pin_url'] );
	    $instance['git_url'] = strip_tags( $new_instance['git_url'] );

	    $instance['icon_color'] = strip_tags( $new_instance['icon_color'] );
	    $instance['icon_hover_color'] = strip_tags( $new_instance['icon_hover_color'] );
	    $instance['icon_bg_color'] = strip_tags( $new_instance['icon_bg_color'] );
	    $instance['icon_hover_bg_color'] = strip_tags( $new_instance['icon_hover_bg_color'] );

	    $instance['fb_button'] = (bool)$new_instance['fb_button'];
	    $instance['g_plus'] = (bool)$new_instance['g_plus'];
	    $instance['linkedin'] = (bool)$new_instance['linkedin'];
	    $instance['twitter'] = (bool)$new_instance['twitter'];
	    $instance['youtube'] = (bool)$new_instance['youtube'];
	    $instance['pinterest'] = (bool)$new_instance['pinterest'];
	    $instance['github'] = (bool)$new_instance['github'];
	 
	    return $instance;
	}

	function form( $instance ) {
		// Output admin widget options form	    
		/* Set up some default widget settings. */
	    $defaults = array(
	        'title' 				=> $this->widget_title,
	        'fb_button' 			=> $this->fb_button,
	        'fb_url' 				=> $this->fb_url,
	        'g_plus' 				=> $this->g_plus,
	        'gp_url' 				=> $this->gp_url,
	        'linkedin' 				=> $this->linkedin,
	        'in_url' 				=> $this->in_url,
	        'twitter' 				=> $this->twitter,
	        't_url' 				=> $this->t_url,
	        'youtube' 				=> $this->youtube,
	        'y_url' 				=> $this->y_url,
	        'pinterest' 			=> $this->pinterest,
	        'pin_url' 				=> $this->pin_url,
	        'github' 				=> $this->github,
	        'git_url' 				=> $this->git_url,
	        'icon_color' 			=> '#000000',
	        'icon_hover_color' 		=> '#dddddd',
	        'icon_bg_color' 		=> '#00fd00',
	        'icon_hover_bg_color' 	=> '#ff0000',
	    );
	 
	    $instance = wp_parse_args( (array) $instance, $defaults );
		?>	    
		<!-- Widget Title: Text Input -->
	    <p>
	    	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'smbuttons') ?></label>
	    	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
	    </p>
		<!-- Show Facebook: Checkbox -->
	    <p>
	    	<input type="checkbox" class="widefat" id="<?php echo $this->get_field_id( 'fb_button' ); ?>" name="<?php echo $this->get_field_name( 'fb_button' ); ?>" value="1" <?php echo ($instance['fb_button'] == "true" ? "checked='checked'" : ""); ?> />
	    	<label for="<?php echo $this->get_field_id( 'fb_button' ); ?>"><?php _e('Facebook', 'smbuttons') ?></label><br>
	    	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'fb_url' ); ?>" name="<?php echo $this->get_field_name( 'fb_url' ); ?>" value="<?php echo $instance['fb_url']; ?>" placeholder="http://facebook.com/name" />
	    </p>
		<!-- Show Google Plug: Checkbox -->
	    <p>
	    	<input type="checkbox" class="widefat" id="<?php echo $this->get_field_id( 'g_plus' ); ?>" name="<?php echo $this->get_field_name( 'g_plus' ); ?>" value="1" <?php echo ($instance['g_plus'] == "true" ? "checked='checked'" : ""); ?> />
	    	<label for="<?php echo $this->get_field_id( 'g_plus' ); ?>"><?php _e('Google Plus', 'smbuttons') ?></label><br>
	    	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'gp_url' ); ?>" name="<?php echo $this->get_field_name( 'gp_url' ); ?>" value="<?php echo $instance['gp_url']; ?>" placeholder="https://plus.google.com/+userid" />
	    </p>
		<!-- Show LinkedIn: Checkbox -->
	    <p>
	    	<input type="checkbox" class="widefat" id="<?php echo $this->get_field_id( 'linkedin' ); ?>" name="<?php echo $this->get_field_name( 'linkedin' ); ?>" value="1" <?php echo ($instance['linkedin'] == "true" ? "checked='checked'" : ""); ?> />
	    	<label for="<?php echo $this->get_field_id( 'linkedin' ); ?>"><?php _e('LinkedIn', 'smbuttons') ?></label><br>
	    	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'in_url' ); ?>" name="<?php echo $this->get_field_name( 'in_url' ); ?>" value="<?php echo $instance['in_url']; ?>" placeholder="https://www.linkedin.com/in/user" />
	    </p>
		<!-- Show Twitter: Checkbox -->
	    <p>
	    	<input type="checkbox" class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" value="1" <?php echo ($instance['twitter'] == "true" ? "checked='checked'" : ""); ?> />
	    	<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e('Twitter', 'smbuttons') ?></label><br>
	    	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 't_url' ); ?>" name="<?php echo $this->get_field_name( 't_url' ); ?>" value="<?php echo $instance['t_url']; ?>" placeholder="https://twitter.com/username" />
	    </p>
		<!-- Show Youtube: Checkbox -->
	    <p>
	    	<input type="checkbox" class="widefat" id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" value="1" <?php echo ($instance['youtube'] == "true" ? "checked='checked'" : ""); ?> />
	    	<label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php _e('Youtube', 'smbuttons') ?></label><br>
	    	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'y_url' ); ?>" name="<?php echo $this->get_field_name( 'y_url' ); ?>" value="<?php echo $instance['y_url']; ?>" placeholder="https://www.youtube.com/user/username" />
	    </p>
		<!-- Show Pinterest: Checkbox -->
	    <p>
	    	<input type="checkbox" class="widefat" id="<?php echo $this->get_field_id( 'pinterest' ); ?>" name="<?php echo $this->get_field_name( 'pinterest' ); ?>" value="1" <?php echo ($instance['pinterest'] == "true" ? "checked='checked'" : ""); ?> />
	    	<label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php _e('Pinterest', 'smbuttons') ?></label><br>
	    	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'pin_url' ); ?>" name="<?php echo $this->get_field_name( 'pin_url' ); ?>" value="<?php echo $instance['pin_url']; ?>" placeholder="http://www.pinterest.com/username" />
	    </p>
		<!-- Show GitHub: Checkbox -->
	    <p>
	    	<input type="checkbox" class="widefat" id="<?php echo $this->get_field_id( 'github' ); ?>" name="<?php echo $this->get_field_name( 'github' ); ?>" value="1" <?php echo ($instance['github'] == "true" ? "checked='checked'" : ""); ?> />
	    	<label for="<?php echo $this->get_field_id( 'github' ); ?>"><?php _e('GitHub', 'smbuttons') ?></label><br>
	    	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'git_url' ); ?>" name="<?php echo $this->get_field_name( 'git_url' ); ?>" value="<?php echo $instance['git_url']; ?>" placeholder="https://github.com/username" />
	    </p>
		<!-- Show Icon Color: Checkbox -->
	    <p>
	    	<input type="color" class="" id="<?php echo $this->get_field_id( 'icon_color' ); ?>" name="<?php echo $this->get_field_name( 'icon_color' ); ?>" value="<?php echo $instance['icon_color']; ?>" />
	    	<label for="<?php echo $this->get_field_id( 'icon_color' ); ?>"><?php _e('Icon Color', 'smbuttons') ?></label>
	    </p>
		<!-- Show Icon Background Color: Checkbox -->
	    <p>	    
	    	<input type="color" class="" id="<?php echo $this->get_field_id( 'icon_bg_color' ); ?>" name="<?php echo $this->get_field_name( 'icon_bg_color' ); ?>" value="<?php echo $instance['icon_bg_color']; ?>" />
	    	<label for="<?php echo $this->get_field_id( 'icon_bg_color' ); ?>"><?php _e('Icon Background Color', 'smbuttons') ?></label>
	    </p>
		<!-- Show Icon Color: Checkbox -->
	    <p>
	    	<input type="color" class="" id="<?php echo $this->get_field_id( 'icon_hover_color' ); ?>" name="<?php echo $this->get_field_name( 'icon_hover_color' ); ?>" value="<?php echo $instance['icon_hover_color']; ?>" />
	    	<label for="<?php echo $this->get_field_id( 'icon_hover_color' ); ?>"><?php _e('Icon Color on Hover', 'smbuttons') ?></label>
	    </p>
		<!-- Show Icon Background Color: Checkbox -->
	    <p>	    
	    	<input type="color" class="" id="<?php echo $this->get_field_id( 'icon_hover_bg_color' ); ?>" name="<?php echo $this->get_field_name( 'icon_hover_bg_color' ); ?>" value="<?php echo $instance['icon_hover_bg_color']; ?>" />
	    	<label for="<?php echo $this->get_field_id( 'icon_hover_bg_color' ); ?>"><?php _e('Icon Background Color on Hover', 'smbuttons') ?></label>
	    </p>
	    <?php
	}
}

function sm_buttons_register_widgets() {
	register_widget( 'SMButtonsWidget' );
}

add_action( 'widgets_init', 'sm_buttons_register_widgets' );