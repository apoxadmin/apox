<?php

/*
 * General stuff for usage at WordPress plugins
 * Author: Vladimir Garagulya
 * Author email: vladimir@shinephp.com
 * Author URI: http://shinephp.com
 * 
 */

/**
 * This class contains general stuff for usage at WordPress plugins and must be extended by child class
 */
class URE_Base_Lib {

    protected static $instance = null; // object exemplar reference  
    protected $options_id = ''; // identifire to save/retrieve plugin options to/from wp_option DB table
    protected $options = array(); // plugin options data
    protected $multisite = false;
    protected $active_for_network = false;
    protected $blog_ids = null;
    protected $main_blog_id = 0;

    
    public static function get_instance($options_id = '') {
        if (self::$instance===null) {        
            self::$instance = new URE_Base_Lib($options_id);
        }
        
        return self::$instance;
    }
    // end of get_instance()
        

    /**
     * class constructor
     * @param string $options_id  to save/retrieve plugin options to/from wp_option DB table
     */
    protected function __construct($options_id) {

        $this->multisite = function_exists('is_multisite') && is_multisite();
        if ($this->multisite) {
            $this->blog_ids = $this->get_blog_ids();
            // get Id of 1st (main) blog
            $this->main_blog_id = $this->get_main_site();
        }

        $this->init_options($options_id);

    }
    // end of __construct()

    
    public function get($property_name) {
        
        if (!property_exists($this, $property_name)) {
            syslog(LOG_ERR, 'Lib class does not have such property '. $property_name);
        }
        
        return $this->$property_name;
    }
    // end of get_property()
    

    public function get_main_site() {
        global $current_site;
        
        return $current_site->blog_id;
    }
    // end of get_main_site()



    /**
     * Returns the array of multisite WP blogs IDs
     * @global wpdb $wpdb
     * @return array
     */
    protected function get_blog_ids() {
        global $wpdb;

        $blog_ids = $wpdb->get_col("select blog_id from $wpdb->blogs order by blog_id asc");

        return $blog_ids;
    }
    // end of get_blog_ids()

    
    /**
     * get current options for this plugin
     */
    protected function init_options($options_id) {
        $this->options_id = $options_id;
        $this->options = get_option($options_id);
    }
    // end of init_options()

    /**
     * Return HTML formatted message
     * 
     * @param string $message   message text
     * @param string $error_style message div CSS style
     */
    public function show_message($message, $error_style = false) {

        if ($message) {
            if ($error_style) {
                echo '<div id="message" class="error" >';
            } else {
                echo '<div id="message" class="updated fade">';
            }
            echo $message . '</div>';
        }
    }
    // end of show_message()

    /**
     * Returns value by name from GET/POST/REQUEST. Minimal type checking is provided
     * 
     * @param string $var_name  Variable name to return
     * @param string $request_type  type of request to process get/post/request (default)
     * @param string $var_type  variable type to provide value checking
     * @return mix variable value from request
     */
    public function get_request_var($var_name, $request_type = 'request', $var_type = 'string') {

        $result = 0;
        if ($request_type == 'get') {
            if (isset($_GET[$var_name])) {
                $result = $_GET[$var_name];
            }
        } else if ($request_type == 'post') {
            if (isset($_POST[$var_name])) {
                if ($var_type != 'checkbox') {
                    $result = $_POST[$var_name];
                } else {
                    $result = 1;
                }
            }
        } else {
            if (isset($_REQUEST[$var_name])) {
                $result = filter_var($_REQUEST[$var_name], FILTER_SANITIZE_STRING);
            }
        }

        if ($result) {
            if ($var_type == 'int' && !is_numeric($result)) {
                $result = 0;
            }
            if ($var_type != 'int') {
                $result = esc_attr($result);
            }
        }

        return $result;
    }
    // end of get_request_var()

    /**
     * returns option value for option with name in $option_name
     */
    public function get_option($option_name, $default = false) {

        if (isset($this->options[$option_name])) {
            return $this->options[$option_name];
        } else {
            return $default;
        }
    }
    // end of get_option()

    /**
     * puts option value according to $option_name option name into options array property
     */
    public function put_option($option_name, $option_value, $flush_options = false) {

        $this->options[$option_name] = $option_value;
        if ($flush_options) {
            $this->flush_options();
        }
    }
    // end of put_option()

    /**
     * Delete URE option with name option_name
     * @param string $option_name
     * @param bool $flush_options
     */
    public function delete_option($option_name, $flush_options = false) {
        if (array_key_exists($option_name, $this->options)) {
            unset($this->options[$option_name]);
            if ($flush_options) {
                $this->flush_options();
            }
        }
    }
    // end of delete_option()

    /**
     * saves options array into WordPress database wp_options table
     */
    public function flush_options() {

        update_option($this->options_id, $this->options);
    }
    // end of flush_options()

    /**
     * Check product versrion and stop execution if product version is not compatible
     * @param type $must_have_version
     * @param type $version_to_check
     * @param type $error_message
     * @return type
     */
    public static function check_version($must_have_version, $version_to_check, $error_message, $plugin_file_name) {

        if (version_compare($must_have_version, $version_to_check, '<')) {
            if (is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX )) {
                require_once ABSPATH . '/wp-admin/includes/plugin.php';
                deactivate_plugins($plugin_file_name);
                wp_die($error_message);
            } else {
                return;
            }
        }
    }
    // end of check_version()


    public function get_current_url() {
        global $wp;
        $current_url = esc_url_raw(add_query_arg($wp->query_string, '', home_url($wp->request)));

        return $current_url;
    }
    // end of get_current_url()

    
    /**
     * Returns comma separated list from the first $items_count element of $full_list array
     * 
     * @param array $full_list
     * @param int $items_count
     * @return string
     */
    public function get_short_list_str($full_list, $items_count=3) {
     
        $short_list = array(); $i = 0;
        foreach($full_list as $key=>$item) {            
            if ($i>=$items_count) {
                break;
            }
            $short_list[] = $item;
            $i++;
        }
        
        $str = implode(', ', $short_list);
        if ($items_count<count($full_list)) {
            $str .= '...';
        }
        
        return $str;
    }    
    //  end of get_short_list_str()
    
    
    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private function __clone() {
        
    }
    // end of __clone()
    
    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    private function __wakeup() {
        
    }
    // end of __wakeup()

}
// end of Garvs_WP_Lib class