<?php

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Krystal_Custom_Content' ) ) :

	class Krystal_Custom_Content extends WP_Customize_Control {

		// Whitelist content parameter
		public $content = '';
		/**
		* Render the control's content.
		*
		* Allows the content to be overriden without having to rewrite the wrapper.
		*
		* @since   1.0.0
		* @return  void
		*/
		public function render_content() {

			if ( isset( $this->label ) ) {
				echo '<span class="customize-control-title">' . $this->label . '</span>';
			}

			if ( isset( $this->content ) ) {
				echo $this->content;
			}

			if ( isset( $this->description ) ) {
				echo '<span class="description customize-control-description">' . $this->description . '</span>';
			}

		}
	}

endif;


if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Krystal_Documentation' ) ) :

	/* custom information type */
	class Krystal_Documentation extends WP_Customize_Control {

		//parameters
	    public $type = 'info';
	    public $label = '';
	    /**
		* Render the control's content.
		*
		* Allows the content to be overriden without having to rewrite the wrapper.
		*
		* @since   1.0.0
		* @return  void
		*/
	    public function render_content() {
	    ?>
	        <p><?php echo esc_html( $this->label ); ?></p>
	    <?php
	    }
	}

endif;


if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Krystal_Info' ) ) :

	/* custom information type */
	class Krystal_Info extends WP_Customize_Control {

		//parameters
	    public $type = 'info';
	    public $label = '';
	    /**
		* Render the control's content.
		*
		* Allows the content to be overriden without having to rewrite the wrapper.
		*
		* @since   1.0.0
		* @return  void
		*/
	    public function render_content() {
	    ?>
	        <h3 class="info"><?php echo esc_html( $this->label ); ?></h3>
	    <?php
	    }
	}

endif;
