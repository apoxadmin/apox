<?php
/**
 * @package   Wordpress_Countdown_Timer
 * @author    Jordan Calder <jcalder@leadgenix.com>
 * @license   GPL-2.0+
 * @link      http://leadgenix.com
 * @copyright 2014 Leadgenix
 */
?>

<div class="wrap">

	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<form method="post" action="options.php">
    	
        <?php settings_fields( 'myoption-group' ); ?>
        <?php do_settings_sections( 'wordpress-countdown-timer' ); ?>
        <?php submit_button(); ?>
        
    </form>

</div>
