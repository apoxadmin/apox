<?php

/*

    Plugin Name: Email Blaster

    Plugin URI: http://www.emailblasteruk.com/wordpress

    Description: The official Email Blaster Widget. Add a newsletter signup form or contact forms to your WordPress site. + Use the power of Email Blaster to email your subscribers. Getting Started: 1) Click the "Activate" link to the left of this description. 2) <a href="http://www.emailblasteruk.co.uk/landing/wordpress">Sign up and build your form.</a> 3) Go to your <a href="/wp-admin/widgets.php">Widgets area</a> and enter your QuickCode. <a href="https://www.youtube.com/watch?v=p__Th95VewQ">Need more help?</a>.

    Author: Email Blaster

    Author URI: http://www.emailblasteruk.com

    Version: 1.0.3



    This program is free software: you can redistribute it and/or modify

    it under the terms of the GNU General Public License as published by

    the Free Software Foundation, either version 3 of the License, or

    (at your option) any later version.



    This program is distributed in the hope that it will be useful,

    but WITHOUT ANY WARRANTY; without even the implied warranty of

    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the

    GNU General Public License for more details.



    You should have received a copy of the GNU General Public License

    along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/



require_once 'emailblaster.class.php';



/**

 * 

 */

function register_emailblaster_widget(){

	register_widget('emailblaster');

}



add_action('widgets_init','register_emailblaster_widget');



?>