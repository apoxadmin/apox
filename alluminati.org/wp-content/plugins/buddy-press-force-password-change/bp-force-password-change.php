<?php
/*
Plugin Name: BP Force Password Change
Plugin URI: 
Description: Adds a checkbox to the edit user form to force users to change their passwords.
Version: 0.1
Author: Leon Amarant
Author URI: 
License: GPLv2 or later
*/

/* *********
[1] ADD HOOKS TO PUT A "FORCE PASSWORD" CHECKBOX ON THE ADMIN USER EDIT SCREEN
************ */
function add_force_password_change_checkbox( $user ) {
	wp_enqueue_script('bp-pw-change', plugins_url('/js/bp-force-pw-change.js',__FILE__) ); ?>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		var checkit = <?php if(get_the_author_meta( 'force_password_change', $user->ID ) =='yes' ) { echo 'true'; } else { echo 'false';} ?>;
		bp_forcepw_addCheckbox(checkit);  
	});
	</script>
<?php }
 
function save_for_password_change_setting( $user_id ) {
	
	if ( !current_user_can( 'edit_user', $user_id ) )
		return FALSE;
	
	update_usermeta( $user_id, 'force_password_change', $_POST['force_password_change'] );
}
 
add_action( 'show_user_profile', 'add_force_password_change_checkbox' );
add_action( 'edit_user_profile', 'add_force_password_change_checkbox' );
 
add_action( 'personal_options_update', 'save_for_password_change_setting' );
add_action( 'edit_user_profile_update', 'save_for_password_change_setting' );

/* *********
[1] Register Necessary Scripts
************ */
function bp_force_password_register_scripts(){
	wp_register_style( 'bp-force-password', plugins_url('/css/bp-force-pw-change.css',__FILE__) );
	wp_enqueue_style('bp-force-password');
	wp_register_style( 'colorbox', plugins_url('/css/colorbox.css',__FILE__) );
	wp_enqueue_style('colorbox');
	wp_enqueue_script( 'colorbox', plugins_url('/js/jquery.colorbox.min.js',__FILE__), array('jquery') );
	wp_enqueue_script('bp-pw-change', plugins_url('/js/bp-force-pw-change.js',__FILE__) );
}
add_action('init', 'bp_force_password_register_scripts');

/* *********
[2] ADD HOOKS TO EACH PAGE LOAD CHECK IF THE "FORCE PASSWORD" VALUE IS SET FOR THE USER.
	IF IT IS, AND ADD THE FORM TO THE PAGE AND TRIGGER A MODAL WINDOW THAT DISPLAYS IT.
************ */
function bp_force_password_check_on_load($user) {
	global $current_user;
	$current_user = wp_get_current_user();
	
	if(!is_user_logged_in())    //get out if not logged in
		return;
	
	if( is_admin())   //only do this on non-administrative pages
		return;
	
	if ( current_user_can('manage_options') )    //user is administrator so return
		return;
	
	//passed so far, now check the users force_password_change value
	if(get_the_author_meta( 'force_password_change', $current_user->ID ) =='yes' ){ ?>
		<script type="text/javascript">        
		jQuery(document).ready(function($) { 
			//alert('-1'); 			      
			bp_forcepw_showPwResetForm(
				'<?php _e('New Password', 'rcp'); ?>', 
				'<?php _e('Password Confirm', 'rcp'); ?>',
				'<?php echo wp_create_nonce('bp_password_nonce'); ?>',
				'<?php _e('Change Password', 'bp'); ?>',
				'<?php echo $current_user->ID; ?>',
				'<?php echo get_bloginfo('wpurl') . '/wp-admin/admin-ajax.php' ?>'
				//'<?php echo plugins_url('/bp-force-pw-process.php',__FILE__) ?>'
			);
			//alert('-2');
		});
		</script>       
	<?php  }
}
add_action('wp_footer', 'bp_force_password_check_on_load');

/* *********
[2] SET UP ASYNC FUNCTION TO HANDLE ORM PROCESSING
************ */
function bp_force_password_ajax() {

	//Process the change password form and remove the 'force_password_change' meta field from the user
	$userID = $_POST["bp-force-pw-uid"];
	$newPW = $_POST["bp-force-pw-pw"];
	
	update_usermeta( $userID, 'force_password_change', 'no' );
		
	$ret = array('confirm' => 'fail');
	if(wp_verify_nonce($_POST['bp_password_nonce'], 'bp_password_nonce')) { 
		$user_data = array(
			'ID' => $userID,
			'user_pass' => $newPW
		);            
		wp_update_user($user_data);    
		$ret = array('confirm' => 'success'); 
	}	
	print(json_encode($ret));
	die();
}
add_action('wp_ajax_dopwchange', 'bp_force_password_ajax');

?>