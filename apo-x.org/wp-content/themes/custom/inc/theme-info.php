<?php
/**
 * Theme information krystal
 *
 * @package krystal
 */


if ( ! class_exists( 'Krystal_About_Page' ) ) {
	/**
	 * Singleton class used for generating the about page of the theme.
	 */
	class Krystal_About_Page {
		/**
		 * Define the version of the class.
		 *
		 * @var string $version The Krystal_About_Page class version.
		 */
		private $version = '1.0.0';
		/**
		 * Used for loading the texts and setup the actions inside the page.
		 *
		 * @var array $config The configuration array for the theme used.
		 */
		private $config;
		/**
		 * Get the theme name using wp_get_theme.
		 *
		 * @var string $theme_name The theme name.
		 */
		private $theme_name;
		/**
		 * Get the theme slug ( theme folder name ).
		 *
		 * @var string $theme_slug The theme slug.
		 */
		private $theme_slug;
		/**
		 * The current theme object.
		 *
		 * @var WP_Theme $theme The current theme.
		 */
		private $theme;
		/**
		 * Holds the theme version.
		 *
		 * @var string $theme_version The theme version.
		 */
		private $theme_version;		
		/**
		 * Define the html notification content displayed upon activation.
		 *
		 * @var string $notification The html notification content.
		 */
		private $notification;
		/**
		 * The single instance of Krystal_About_Page
		 *
		 * @var Krystal_About_Page $instance The Krystal_About_Page instance.
		 */
		private static $instance;
		/**
		 * The Main Krystal_About_Page instance.
		 *
		 * We make sure that only one instance of Krystal_About_Page exists in the memory at one time.
		 *
		 * @param array $config The configuration array.
		 */
		public static function krystal_init( $config ) {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Krystal_About_Page ) ) {
				self::$instance = new Krystal_About_Page;				
				self::$instance->config = $config;
				self::$instance->krystal_setup_config();
				self::$instance->krystal_setup_actions();				
			}
		}

		/**
		 * Setup the class props based on the config array.
		 */
		public function krystal_setup_config() {
			$theme = wp_get_theme();
			if ( is_child_theme() ) {
				$this->theme_name = $theme->parent()->get( 'Name' );
				$this->theme      = $theme->parent();
			} else {
				$this->theme_name = $theme->get( 'Name' );
				$this->theme      = $theme->parent();
			}
			$this->theme_version = $theme->get( 'Version' );
			$this->theme_slug    = $theme->get_template();			
			$this->notification  = isset( $this->config['notification'] ) ? $this->config['notification'] : ( '<p>' . sprintf( 'Welcome! Thank you for choosing %1$s ! To take full advantage of this theme, please make sure you visit our %2$swelcome page%3$s.', $this->theme_name, '<a href="' . esc_url( admin_url( 'themes.php?page=' . $this->theme_slug . '-theme-info' ) ) . '">', '</a>' ) . '</p><p><a href="' . esc_url( admin_url( 'themes.php?page=' . $this->theme_slug . '-theme-info' ) ) . '" class="button" style="text-decoration: none;">' . sprintf( 'Get started with %s', $this->theme_name ) . '</a></p>' );		
		}

		/**
		 * Setup the actions used for this page.
		 */
		public function krystal_setup_actions() {
			
			/* activation notice */
			add_action( 'load-themes.php', array( $this, 'krystal_activation_admin_notice' ) );						
		}		
		

		/**
		 * Adds an admin notice upon successful activation.
		 */
		public function krystal_activation_admin_notice() {
			global $pagenow;
			if ( is_admin() && ( 'themes.php' == $pagenow ) && isset( $_GET['activated'] ) ) {
				add_action( 'admin_notices', array( $this, 'krystal_about_page_welcome_admin_notice' ), 99 );
			}
		}

		/**
		 * Display an admin notice linking to the about page
		 */
		public function krystal_about_page_welcome_admin_notice() {
			if ( ! empty( $this->notification ) ) {
				echo '<div class="updated notice is-dismissible">';
				echo wp_kses_post( $this->notification );
				echo '</div>';
			}
		}		

	}
}


/**
 *  Adding a About Krystal page 
 */
add_action('admin_menu', 'krystal_add_menu');

function krystal_add_menu() {
     add_theme_page(__('About Krystal Theme','krystal'), __('About Krystal','krystal'),'manage_options', __('krystal-theme-info','krystal'), __('krystal_theme_info','krystal'));
}

/**
 *  Callback
 */
function krystal_theme_info() {
?>
	<div class="krystal-info">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="title">
						<h2><?php _e( 'Thank you for using Krystal Lite free WordPress theme', 'krystal' ); ?></h2>
						<div class="title-content">
							<p><?php _e( 'Krystal is a professional business template perfect for your blog, small business, online portfolio, construction companies and creative agencies. It is a clean and modern design bootstrap WordPress theme nicely coded for easy customization. Krystal provides a great experience and impression to your visitors with clean and elegant design. There is also a working ajax contact form in Krystal theme. Powered by most popular page builder Elementor you can easily create and edit pages. Krystal comes with 8+ unique demos and with 1 click demo import feature. Krystal is SEO friendly and mobile responsive too.', 'krystal' ); ?></p>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="section-box">
						<div class="icon">
							<span class="dashicons dashicons-visibility"></span>
						</div>
						<div class="heading">
							<h3><a href="https://www.spiraclethemes.com/krystal-free-wordpress-theme/" target="_blank"><?php _e( 'VIEW<br/> DEMO', 'krystal' ); ?></a></h3>
						</div>						
					</div>
				</div>
				<div class="col-md-3">
					<div class="section-box">
						<div class="icon">
							<span class="dashicons dashicons-format-aside"></span>
						</div>
						<div class="heading">
							<h3><a href="https://spiraclethemes.com/krystal-documentation/" target="_blank"><?php _e( 'VIEW<br/> DOCUMENTATION', 'krystal' ); ?></a></h3>
						</div>						
					</div>
				</div>
				<div class="col-md-3">
					<div class="section-box">
						<div class="icon">
							<span class="dashicons dashicons-video-alt2"></span>
						</div>
						<div class="heading">
							<h3><a href="https://www.spiraclethemes.com/krystal-video-tutorials/" target="_blank"><?php _e( 'VIDEO<br/> TUTORIALS', 'krystal' ); ?></a></h3>
						</div>						
					</div>
				</div>
				<div class="col-md-3">
					<div class="section-box">
						<div class="icon">
							<span class="dashicons dashicons-sos"></span>
						</div>
						<div class="heading">
							<h3><a href="https://wordpress.org/support/theme/krystal" target="_blank"><?php _e( 'ASK FOR<br/> SUPPORT', 'krystal' ); ?></a></h3>
						</div>						
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-3">
					<div class="section-box">
						<div class="icon">
							<span class="dashicons dashicons-star-filled"></span>
						</div>
						<div class="heading">
							<h3><a href="https://wordpress.org/themes/krystal/" target="_blank"><?php _e( 'RATE OUR<br/> THEME', 'krystal' ); ?></a></h3>
						</div>						
					</div>
				</div>
				<div class="col-md-3">
					<div class="section-box">
						<div class="icon">
							<span class="dashicons dashicons-admin-tools"></span>
						</div>
						<div class="heading">
							<h3><a href="https://themes.trac.wordpress.org/log/krystal/" target="_blank"><?php _e( 'VIEW<br/> CHANGELOGS', 'krystal' ); ?></a></h3>
						</div>						
					</div>
				</div>
				<div class="col-md-3">
					<div class="section-box">
						<div class="icon">
							<span class="dashicons dashicons-email-alt"></span>
						</div>
						<div class="heading">
							<h3><a href="https://www.spiraclethemes.com/contact-us/" target="_blank"><?php _e( 'CONTACT<br/> US', 'krystal' ); ?></a></h3>
						</div>						
					</div>
				</div>
				<div class="col-md-3">
					<div class="section-box section-last">
						<div class="icon">
							<span class="dashicons dashicons-cart"></span>
						</div>
						<div class="heading">
							<h3><a href="https://www.spiraclethemes.com/krystal-premium-wordpress-theme/" target="_blank"><?php _e( 'BUY PRO WITH<br/> EXTRA FEATURES', 'krystal' ); ?></a></h3>
						</div>						
					</div>
				</div>
			</div>			
		</div>		
	</div>
<?php
}
