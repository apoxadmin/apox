<?php
/**
 * Welcome Screen Class
 */
class Parallel_Welcome {

	/**
	 * Constructor for the welcome screen
	 */
	public function __construct() {

		/* create dashbord page */
		add_action( 'admin_menu', array( $this, 'parallel_welcome_register_menu' ) );

		/* activation notice */
		add_action( 'admin_init', array( $this, 'parallel_activation_admin_notice' ) );

		/* enqueue script and style for welcome screen */
		add_action( 'admin_enqueue_scripts', array( $this, 'parallel_welcome_style_and_scripts' ) );

		/* load welcome screen */
		add_action( 'parallel_welcome', array( $this, 'parallel_welcome_getting_started' ), 	    10 );
		add_action( 'parallel_welcome', array( $this, 'parallel_welcome_theme_support' ),        	20 );
		add_action( 'parallel_welcome', array( $this, 'parallel_welcome_child_themes' ), 		    30 );
		add_action( 'parallel_welcome', array( $this, 'parallel_welcome_import_demo' ), 		    40 );

		/* Dismissable notice */
		add_action('admin_init',array($this,'dismiss_welcome'),1);
	}

	/**
	 * Creates the dashboard page
	 */
	public function parallel_welcome_register_menu() {
		add_theme_page( __( 'Setup Parallel', 'parallel' ), __( 'Setup Parallel', 'parallel' ), 'activate_plugins', 'parallel-welcome', array( $this, 'parallel_welcome_screen' ) );
	}

	/**
	 * Adds an admin notice upon successful activation.
	 */
	public function parallel_activation_admin_notice() {
		global $current_user;

		if ( is_admin() ) {

			$current_theme = wp_get_theme();
			$welcome_dismissed = get_user_meta($current_user->ID,'parallel_welcome_admin_notice');

			if($current_theme->get('Name')== "Parallel" && !$welcome_dismissed){
				add_action( 'admin_notices', array( $this, 'parallel_welcome_admin_notice' ), 99 );
			}

			wp_enqueue_style( 'parallel-welcome-notice-css', get_template_directory_uri() . '/inc/welcome/css/notice.css' );

		}
	}
	/**
	 * Adds a button to dismiss the notice
	 */
	function dismiss_welcome() {
		global $current_user;
		$user_id = $current_user->ID;

		if ( isset($_GET['parallel_welcome_dismiss']) && $_GET['parallel_welcome_dismiss'] == '1' ) {
			add_user_meta($user_id, 'parallel_welcome_admin_notice', 'true', true);
		}
	}
	/**
	 * Display an admin notice linking to the welcome screen

	 */
	public function parallel_welcome_admin_notice() {
		
		$dismiss_url = '<a href="' . esc_url( wp_nonce_url( add_query_arg( 'parallel_welcome_dismiss', '1' ) ) ) . '" class="notice-dismiss" target="_parent"></a>';
		?>
			<div class="notice theme-notice">
				<div class="theme-notice-logo"><span></span></div>
				<div class="theme-notice-message wp-theme-fresh">
					<strong><?php esc_html_e( 'Welcome, Thank you for choosing Parallel! ', 'parallel' ); ?></strong><br />
					<?php esc_html_e( 'Visit our welcome page to setup Parallel and start customizing your site.', 'parallel' ); ?></div>
				<div class="theme-notice-cta">
					<a href="<?php echo esc_url( admin_url( 'themes.php?page=parallel-welcome#getting_started' ) ); ?>" class="button button-hero" style="text-decoration: none;"><?php esc_html_e( 'Setup Parallel', 'parallel' ); ?> <?php echo $dismiss_url ?></a>
					<a target="_blank" href="<?php echo esc_url('https://www.themely.com/themes/parallel/'); ?>" class="button button-primary button-hero" style="text-decoration: none;"><?php _e( 'Upgrade to Parallel Pro!', 'parallel' ); ?></a>
				</div>
			</div>
		<?php
	}

	/**
	 * Load welcome screen css and javascript
	 */
	public function parallel_welcome_style_and_scripts( $hook_suffix ) {

		if ( 'appearance_page_parallel-welcome' == $hook_suffix ) {
			wp_enqueue_style( 'parallel-welcome-screen-css', get_template_directory_uri() . '/inc/welcome/css/welcome.css' );
			wp_enqueue_script( 'parallel-welcome-screen-js', get_template_directory_uri() . '/inc/welcome/js/welcome.js', array('jquery') );
		}
	}

	/**
	 * Welcome screen content
	 */
	public function parallel_welcome_screen() {

		?>

		<div class="wrap about-wrap theme-welcome">

            <h1><?php esc_html_e('Welcome to Parallel', 'parallel'); ?> <span><?php esc_html_e('VERSION 1.3.8.5', 'parallel'); ?></span></h1>

            <div class="about-text"><?php esc_html_e('Parallel is a one-page multi-purpose theme for professionals, agencies and businesses. Its strength lies in displaying content on a single page in a simple and elegant manner. It\'s super easy to customize and allows you to create a stunning website in minutes.', 'parallel'); ?></div>

            <a class="wp-badge" href="<?php echo esc_url('https://www.themely.com/'); ?>" target="_blank"><span><?php esc_html_e('Visit Website', 'parallel'); ?></span></a>

            <div class="clearfix"></div>

			<ul class="nav-tab-wrapper" role="tablist">
	            <li role="presentation" class="nav-tab nav-tab-active"><a href="#getting_started" aria-controls="getting_started" role="tab" data-toggle="tab"><?php esc_html_e( 'Getting Started','parallel'); ?></a></li>
	            <li role="presentation" class="nav-tab"><a href="#theme_support" aria-controls="theme_support" role="tab" data-toggle="tab"><?php esc_html_e( 'Theme Support','parallel'); ?></a></li>
	            <li role="presentation" class="nav-tab"><a href="#child_themes" aria-controls="child_themes" role="tab" data-toggle="tab"><?php esc_html_e( 'Child Themes','parallel'); ?></a></li>
	            <li role="presentation" class="nav-tab"><a href="#import_demo" aria-controls="import_demo" role="tab" data-toggle="tab"><?php esc_html_e( 'Import Demo','parallel'); ?></a></li>
	        </ul>

			<div class="info-tab-content">

				<?php do_action( 'parallel_welcome' ); ?>

			</div>

		</div>

		<?php
	}

	/**
	 * Getting started
	 */
	public function parallel_welcome_getting_started() {
		require_once( get_template_directory() . '/inc/welcome/getting-started.php' );
	}

	/**
	 * Theme Support
	 */
	public function parallel_welcome_theme_support() {
		require_once( get_template_directory() . '/inc/welcome/theme-support.php' );
	}

	/**
	 * Child themes
	 */
	public function parallel_welcome_child_themes() {
		require_once( get_template_directory() . '/inc/welcome/child-themes.php' );
	}

	/**
	 * Import Demo
	 */
	public function parallel_welcome_import_demo() {
		require_once( get_template_directory() . '/inc/welcome/import-demo.php' );
	}
}

$GLOBALS['Parallel_Welcome'] = new Parallel_Welcome();