<?php 
/*
 * Plugin Name: Custom css-js-php
 * Description: Write custom code for php, html, javascript and css.
 * Plugin URI: http://www.flippercode.com
 * Author: Flippercode
 * Author URI: http://www.flippercode.com
 * Version: 1.0 
 */
 
 
 class Wce_Code_Editor{
   
   var $load;
   
   var $shortcode_name = "wce_code";
   
   var $textdomain = "wce";
   
   var $table = "";
   
   public function __construct(){
	   
	  global $wpdb; 
	
	  $this->table = $wpdb->prefix."wce_editor_content";
	
	  add_shortcode( $this->shortcode_name, array( $this, "wce_editor_inline_code" ) );  
	  
	  add_action( "wp_head", array($this, "wce_inline_code_header_footer"), 500 ); 
	  
	  add_action( "wp_footer", array($this, "wce_inline_code_header_footer"), 500); 
   
      add_action( "init", array($this, "wce_run_filter_action_hooks"));
      
      add_action( "plugins_loaded", array( $this, "wce_load_textdomain" ) );
   
   }
   
   public function wce_load_textdomain(){
	
	load_plugin_textdomain( $this->textdomain , false, dirname( plugin_basename( __FILE__ ) ) . "/lang/" );    
	   
   }
   
   public function wce_run_filter_action_hooks(){
     
	 global $wpdb;
	 
	 if(defined("DISABLE_WCE"))
	 return;

	 $action_filters = $wpdb->get_results("SELECT * FROM ".$this->table." WHERE data_cond IN( 'filter', 'action') AND status = 1");
   
     if(empty($action_filters))
	 return;
	 
	 foreach( $action_filters as $hook ){
	 
	   $wp_func_name = "";
	 
	   if(empty($hook->data_source))
	   continue;
	   
	   if(empty($hook->tag_name))
	   continue;
	   
	   if( $hook->data_cond == "filter")

	   $wp_func_name = "add_filter";
	   	   
	   else if( $hook->data_cond == "action" )
	   
	   $wp_func_name = "add_action";
	   
	   else continue;
	   
	   $functions = $this->get_function_name($hook->data_source);
	   
	   if(empty($functions))
	   continue;
	   
	   
	   $this->wce_call_php_script($hook->data_source);
	   
	   foreach( $functions as $func_name )
	   
	   if( function_exists($func_name) ){
		
		if($hook->accept_args > 1)
		
		$wp_func_name( $hook->tag_name, $func_name , 10 , $hook->accept_args );
		
		else 
		
		$wp_func_name( $hook->tag_name, $func_name );
	 
		   
	   }
	   
	   
	 }
	 
   
   }
   
   public function wce_call_php_script( $script_source ){
	
	  if( strpos($script_source, "php") > 0) 
	  echo  eval("?>{$script_source}"); 
	  
	  else
	  echo  eval("{$script_source}");
    
    } 
   
   public function get_function_name( $script_source ){
	
	$func_name = array();
	
	preg_match_all('/function[\s\n]+(\S+)[\s\n]*\(/', $script_source, $matches);
	
	if( $matches[1] )
	$func_name = $matches[1];
	
	 
	return $func_name;   
   
   }
   
   public function wce_inline_code_header_footer(){
	 
	 global $wpdb;
	 
	 $filter_by = '';
	 
	 if( current_filter() == "wp_head" )
	 
	 $filter_by = "header";
	 
	 if( current_filter() == "wp_footer" )
	 
	 $filter_by = "footer";
	 
	
	 if(empty($filter_by))
	 
	 return;
    
     $scripts_source = $wpdb->get_results($wpdb->prepare("SELECT id FROM ".$this->table." WHERE data_cond= %s", $filter_by) );
	 
	 if(!$scripts_source)
	 return;   
	 
	 
	 foreach( $scripts_source as $source )
	 {
		 echo do_shortcode('[wce_code id="'.$source->id.'"]');
	 }
	 
   
   }
   
   public function wce_editor_inline_code($atts){
	 
	 global $wpdb;
	 
	 $id = $atts["id"];  
	 
	 if(!$id )
	 return false;
	 
	 
	 $row = $wpdb->get_row("SELECT * FROM ".$this->table." WHERE id=". $id." AND status = 1");
	 
	 
	 if( empty($row->data_source) )
	 return false;
	 
	 
	 $script_source = trim($row->data_source);

	 ob_start();
	 
	 switch($row->data_type){
		
		case 'css'  :  
		
		echo <<<EOT
<style type="text/css">
{$script_source}
</style>
EOT;
        break; 
		
		case 'js'  :   
	    
	    $script_source = htmlspecialchars_decode($script_source);  
		
		echo <<<EOT
<script type="text/javascript">
{$script_source}
</script>
EOT;

		 break; 
	   
	     case 'php' :
	         
	         eval("?>{$script_source}"); 
	         
	     break;	 
		 
	  }
	  
	  return ob_get_clean();
   
   }
 
   public function admin_do(){
      
	  add_action( "admin_init", array($this, 'wce_admin_init') );
      
	  add_action( "admin_menu", array( $this, "wce_code_admin_menu" ) );
	  
	 // wp_enqueue_script("bootstrap",  plugins_url( 'bootstrap/css/bootstrap.css', __FILE__ ));
   
   }
   
   public function wce_code_admin_menu(){
	   
    
	  add_menu_page( __("CSS-JS-PHP", $this->textdomain), __("CSS-JS-PHP", $this->textdomain), "manage_options", "wce-code", array($this, "wce_code_overview") );
	
	  add_submenu_page( "wce-code", __("Add CSS", $this->textdomain), __("Add New CSS", $this->textdomain), "manage_options", "add-new-code-css", array($this, "wce_code_editor_form") );
	 
	  add_submenu_page( "wce-code", __("Manage CSS", $this->textdomain), __("Manage CSS", $this->textdomain), "manage_options", "wce-code-css", array($this, "wce_code_list") );
	  
	  add_submenu_page( "wce-code", __("Add JS", $this->textdomain), __("Add New JS", $this->textdomain), "manage_options", "add-new-code-js", array($this, "wce_code_editor_form") );  
   
      add_submenu_page( "wce-code", __("Manage JS", $this->textdomain), __("Manage JS", $this->textdomain), "manage_options", "wce-code-js", array($this, "wce_code_list") ); 
     
      add_submenu_page( "wce-code", __("Add PHP", $this->textdomain), __("Add New PHP", $this->textdomain), "manage_options", "add-new-code-php", array($this, "wce_code_editor_form") ); 
    
      add_submenu_page( "wce-code", __("Manage PHP", $this->textdomain), __("Manage PHP", $this->textdomain), "manage_options", "wce-code-php", array($this, "wce_code_list") ); 

      add_submenu_page( "wce-code", __("Import/Export", $this->textdomain), __("Import/Export", $this->textdomain), "manage_options", "wce-code-import-export", array($this, "wce_code_import_export") ); 
  
  }
   
   public function wce_code_overview(){
	

	?>
	<style>
	.wce_features li {
		
		list-style: circle;
		font-size:14px;
		margin-top:10px;
		margin-left:20px;
		
		}
	</style>
	<div class="wrap wpgmp-wrap">
    <div class="col-md-11"> 
		<h3><span class="glyphicon glyphicon-asterisk"></span><?php _e('About the Plugin', $this->textdomain) ?></h3>
		<div id="dashboard-widgets-container" class="wpgmp-overview">
		    <div id="dashboard-widgets" class="metabox-holder">
				<div id="post-body">
					<div id="dashboard-widgets-main-content">
						<div class="postbox-container" id="main-container" style="width:75%;">
							<?php _e('You can define your custom css, javascript or php code and apply using shortcode, actions or filters easily. Below are the 3 main things you can do with this plugin.', $this->textdomain) ?>
						    <ul class='wce_features'>
						    <li>No need to write in theme files and no fear to loss changes on theme updated.</li>
						    <li>Same with plugins, You can extend functionality of other plugin using this plugin without losing changes on plugin upgrade.</li>
						    <li>Export/Import functionaity makes easy to keep backup and transfer to another site.</li>
						    </ul>
						    <p>
						    <font style="color:red">Incase, due to syntex error in your coding, You can disable this plugin by defining following line in wp-config.php. 
						    
						    <code>define("DISABLE_WCE",true)</code>
						    
						   </font>
						    </p>
						    <p>
						    if still you need some help to implement some custom code or enhance existing plugin or theme, you may leave a mail to hello@flippercode.com
						    </p>
						</div>
			    		<div class="postbox-container" id="side-container" style="width:24%;">
						</div>						
					</div>
				</div>
		    </div>
		</div>
		<div style="clear:both"></div>
	</div>
	
	<?php

	   
	}
   public function wce_admin_init(){
    
    global $plugin_page;
	
	if( !$plugin_page )
	return;
	
	  
	  include_once( dirname(__FILE__).'/class-wce-admin.php');
	  
	  if( in_array($plugin_page, array("add-new-code-php", "wce-code-php")))
	  $slug_class = "Wce_Code_Php_Html"; 
	 
	  else if( in_array($plugin_page, array("add-new-code-css", "wce-code-css")))
	  $slug_class = "Wce_Code_Css"; 
 
	  else if( in_array($plugin_page, array("add-new-code-js", "wce-code-js")))
	  $slug_class = "Wce_Code_Js"; 
	  
	  else 
	  $slug_class = "Wce_Code";

	  if(class_exists($slug_class) == false)
	  
	  return;
	  
	  $this->load = new $slug_class;
	  
	  $this->load->textdomain = $this->textdomain;
	  
	  $this->load->shortcode_name = $this->shortcode_name;
	  
	  $this->load->table = $this->table;
	  
	  $title = ucfirst($this->load->data_type);
	   
	  if($this->load->data_type == 'js')
	   
	  $title = __("Javascript", $this->textdomain );

	  if( $_GET['page'] === "add-new-code-".$this->load->data_type){
	  
	    $this->load->page_title = __( "Add New ".strtoupper($title), $this->textdomain) ;
	    
      
      }
	  
	  if( isset($_GET['action']) && $_GET['action'] == "edit" && intval($_GET['id']) ){
	   
	   $this->load->page_title = __( "Edit ".$title, $this->textdomain) ;
	   
	   $this->load->setValue('id', $_GET['id']);
	   
	   $this->load->populate();
	  
	  }
	  if( isset($_POST['wce_action']) ){
		  
		  if( ! current_user_can("delete_users"))
		 
		  return;
		  
		  if($_POST['wce_action'] == 1 ){
			  
			
			 if(! wp_verify_nonce( $_POST[$this->load->type."_nonce"], $this->load->nonce_name ) )
			
			 wp_die(__("You don't have sufficient permission.", $this->textdomain) ); 
			 
			 $this->load->populate();
			 
			 $this->load->submit(); 
			  
		   }
	  
	      if( in_array($_POST['wce_action'], array("import", "export"))){
			
			 if( ! current_user_can($_POST['wce_action']) )
			 return;  
			 
			 $action = $_POST['wce_action'];
			 
			 if(! wp_verify_nonce($_POST[$action."_data"], "{$action}_action") )
			
			 wp_die( __("You don't have sufficient permission.", $this->textdomain) ); 
			 
			 $this->load->$action(); 
			  
		  }
     }
	
	 $this->load->after_form_load();
	
   }
   
   public function wce_code_import_export(){
	 
	 $this->load->wce_get_form(); 
	   
   }
   
   public function wce_code_list(){
	 
	 if(isset($_GET['action']) && $_GET['action']=="edit")
	 $this->load->wce_get_form();
	 else
	 $this->load->wce_get_list();
   
   }
   
   public function wce_code_editor_form(){
	 
	 $this->load->wce_get_form();
   
   }
    
   public function install($network_wide){
	
	if ( is_multisite() && $network_wide ) { // See if being activated on the entire network or one blog

		global $wpdb;

		// Get this so we can switch back to it later
		$currentblog = $wpdb->blogid;
		// For storing the list of activated blogs
		$activated = array();

		// Get all blogs in the network and activate plugin on each one
		$sql = "SELECT blog_id FROM {$wpdb->blogs}";
		$blog_ids = $wpdb->get_col($wpdb->prepare($sql,null));
		foreach ($blog_ids as $blog_id) {
			switch_to_blog($blog_id);
			$this->install_wpdb_table();
			$activated[] = $blog_id;
		}

		// Switch back to the current blog
		switch_to_blog($currentblog);

					
	  } else { // Running on a single blog
	   
	   $this->install_wpdb_table();
	}   
	   
   }
   
   private function install_wpdb_table(){
	   
	   $sql = "CREATE TABLE `".$this->table."` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `data_title` varchar(100) NOT NULL,
			  `data_type` varchar(30) NOT NULL,
			  `data_source` longtext NOT NULL,
			  `data_cond` varchar(60) NOT NULL,
			  `tag_name` varchar(100) NOT NULL,
              `accept_args` int(11) NOT NULL,
              `status` tinyint(1) NOT NULL DEFAULT '1',
			   PRIMARY KEY (`id`)
              )";
              
       require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
       dbDelta( $sql );
       
       register_uninstall_hook( __FILE__, array( $this, "uninstall" ) );
    }
    
   public function uninstall(){
	
	global $wpdb;
	
	$wpdb->query("DROP TABLE ".$this->table);    
    
   } 
   
 }
 
 $wc_code_editor = new Wce_Code_Editor();
 
 if( is_admin() )
 
 $wc_code_editor->admin_do(); 
 
 register_activation_hook( __FILE__, array( $wc_code_editor, "install" ) );
 
 



