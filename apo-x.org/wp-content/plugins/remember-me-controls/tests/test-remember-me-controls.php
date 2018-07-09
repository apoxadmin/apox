<?php

defined( 'ABSPATH' ) or die();

class Remember_Me_Controls_Test extends WP_UnitTestCase {

	public function setUp() {
		parent::setUp();
		c2c_RememberMeControls::get_instance()->install();
	}

	public function tearDown() {
		parent::tearDown();

		// Reset options
		c2c_RememberMeControls::get_instance()->reset_options();

		remove_filter( 'c2c_linkify_text',                array( $this, 'add_text_to_linkify' ) );
		remove_filter( 'c2c_linkify_text_replace_once',   '__return_true' );
		remove_filter( 'c2c_linkify_text_case_sensitive', '__return_true' );
		remove_filter( 'c2c_linkify_text_comments',       '__return_true' );
		remove_filter( 'c2c_linkify_text_filters',        array( $this, 'add_custom_filter' ) );
		remove_filter( 'c2c_linkify_text_linked_text',    array( $this, 'add_title_attribute_to_linkified_text' ), 10, 3 );
	}


	//
	//
	// DATA PROVIDERS
	//
	//


	//
	//
	// HELPER FUNCTIONS
	//
	//


	protected function set_option( $settings = array() ) {
		$obj = c2c_RememberMeControls::get_instance();
		$defaults = $obj->get_options();
		$settings = wp_parse_args( (array) $settings, $defaults );
		$obj->update_option( $settings );
	}


	//
	//
	// TESTS
	//
	//


	public function test_class_exists() {
		$this->assertTrue( class_exists( 'c2c_RememberMeControls' ) );
	}

	public function test_plugin_framework_class_name() {
		$this->assertTrue( class_exists( 'c2c_RememberMeControls_Plugin_041' ) );
	}

	public function test_plugin_framework_version() {
		$this->assertEquals( '041', c2c_RememberMeControls::get_instance()->c2c_plugin_version() );
	}

	public function test_get_version() {
		$this->assertEquals( '1.6', c2c_RememberMeControls::get_instance()->version() );
	}

	public function test_instance_object_is_returned() {
		$this->assertTrue( is_a( c2c_RememberMeControls::get_instance(), 'c2c_RememberMeControls' ) );
	}

	public function test_hooks_action_auth_cookie_expiration() {
		$this->assertNotFalse( has_action( 'auth_cookie_expiration', array( c2c_RememberMeControls::get_instance(), 'auth_cookie_expiration' ), 10, 3 ) );
	}

	public function test_hooks_action_login_head() {
		$this->assertNotFalse( has_action( 'login_head', array( c2c_RememberMeControls::get_instance(), 'add_css' ) ) );
	}

	public function test_hooks_filter_login_footer() {
		$this->assertNotFalse( has_filter( 'login_footer', array( c2c_RememberMeControls::get_instance(), 'add_js' ) ) );
	}

	public function test_option_default_for_auto_remember_me() {
		$this->assertFalse( c2c_RememberMeControls::get_instance()->get_options()['auto_remember_me'] );
	}

	public function test_option_default_for_remember_me_forever() {
		$this->assertFalse( c2c_RememberMeControls::get_instance()->get_options()['remember_me_forever'] );
	}

	public function test_option_default_for_remember_me_duration() {
		$this->assertEmpty( c2c_RememberMeControls::get_instance()->get_options()['remember_me_duration'] );
	}

	public function test_option_default_for_disable_remember_me() {
		$this->assertFalse( c2c_RememberMeControls::get_instance()->get_options()['disable_remember_me'] );
	}

	public function test_auth_cookie_expiration_is_unaffected_if_plugin_not_configured() {
		$this->assertEquals( 456, c2c_RememberMeControls::get_instance()->auth_cookie_expiration( 456, 1, false ) );
	}

	public function test_auth_cookie_expiration_is_unaffected_if_remember_me_not_checked() {
		$this->set_option( array( 'remember_me_forever' => true, 'remember_me_duration' => 27 ) );
		$this->assertEquals( 456, c2c_RememberMeControls::get_instance()->auth_cookie_expiration( 456, 1, false ) );
	}

	public function test_auth_cookie_expiration_if_remember_me_forever() {
		$this->set_option( array( 'remember_me_forever' => true ) );
		$this->assertEquals( 100 * YEAR_IN_SECONDS, c2c_RememberMeControls::get_instance()->auth_cookie_expiration( 456, 1, true ) );
	}

	public function test_auth_cookie_expiration_remember_me_forever_has_priority_over_remember_me_duration() {
		$this->set_option( array( 'remember_me_forever' => true, 'remember_me_duration' => 200 ) );
		$this->assertEquals( 100 * YEAR_IN_SECONDS, c2c_RememberMeControls::get_instance()->auth_cookie_expiration( 456, 1, true ) );
	}

	public function test_auth_cookie_expiration_if_remember_me_duration() {
		$this->set_option( array( 'remember_me_duration' => 24 * 21 ) );
		$this->assertEquals( 24 * 21 * HOUR_IN_SECONDS, c2c_RememberMeControls::get_instance()->auth_cookie_expiration( 456, 1, true ) );
	}

	public function test_auth_cookie_expiration_remember_me_duration_does_not_exceed_max() {
		$this->set_option( array( 'remember_me_duration' => 24 * 365 * 101 ) ); // 101 years
		$this->assertEquals( 100 * YEAR_IN_SECONDS, c2c_RememberMeControls::get_instance()->auth_cookie_expiration( 456, 1, true ) );
	}

	public function test_auth_cookie_expiration_remember_me_duration_of_0_result_in_default_expiration() {
		$this->set_option( array( 'remember_me_duration' => 0 ) );
		$this->assertEquals( 456, c2c_RememberMeControls::get_instance()->auth_cookie_expiration( 456, 1, true ) );
	}

	public function test_auth_cookie_expiration_if_remember_unchecked_and_disable_remember_me() {
		$this->set_option( array( 'disable_remember_me' => true ) );
		$this->assertEquals( 2 * DAY_IN_SECONDS, c2c_RememberMeControls::get_instance()->auth_cookie_expiration( 456, 1, false ) );
	}

	public function test_auth_cookie_expiration_if_remember_checked_and_disable_remember_me() {
		$this->set_option( array( 'disable_remember_me' => true ) );
		$this->assertEquals( 2 * DAY_IN_SECONDS, c2c_RememberMeControls::get_instance()->auth_cookie_expiration( 456, 1, true ) );
	}

	public function test_auth_cookie_expiration_if_remember_checked_that_disable_remember_me_has_top_priority() {
		$this->set_option( array( 'disable_remember_me' => true, 'remember_me_forever' => true, 'remember_me_duration' => 33 ) );
		$this->assertEquals( 2 * DAY_IN_SECONDS, c2c_RememberMeControls::get_instance()->auth_cookie_expiration( 456, 1, true ) );
	}

	public function test_uninstall_deletes_option() {
		$option = 'c2c_remember_me_controls';
		c2c_RememberMeControls::get_instance()->get_options();

		$this->assertNotFalse( get_option( $option ) );

		c2c_RememberMeControls::uninstall();

		$this->assertFalse( get_option( $option ) );
	}

}
