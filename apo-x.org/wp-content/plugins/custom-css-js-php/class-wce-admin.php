<?php 
  
  if ( ! defined( 'ABSPATH' ) ) exit;
  
  class Wce_Code_Admin{
    
	var $table;
	
	var $textdomain = "wce";

	var $page_title;
	
	var $form_note;
	
	var $nonce_name;
	
	var $wp_editor = false;
	
	var $form_lable = '';
    
    var $body_lable = '';
	
	var $form_fields = array( 'data_title', 'data_type', 'data_cond', 'data_source');
    
	var $form_values = array();
	
	
 
	function __construct(){
	  
	  global $wpdb;
	  
	  $this->table = $wpdb->prefix."wce_editor_content";
	  
	  $this->body_lable  = __("Write your code here", $this->textdomain );
	  
	  $this->form_fields = apply_filters("wce_editor_form_fiels", $this->form_fields);
	 
	  add_action( "wce_page_before_element", array( $this, "show_messages" ) );
  
	  add_action( "wce_after_form_complete_load", array( $this, "wce_load_codemirror_lib" ) );
	
	}
	
	public function wce_load_codemirror_lib(){

	  wp_enqueue_style("wce-codemirror", plugins_url("/assets/codemirror/codemirror.css", __FILE__) );	
	 
	  wp_enqueue_script("wce-codemirror", plugins_url("/assets/codemirror/codemirror.js", __FILE__) );	
		
	}
	
	public function after_form_load(){
    
     if( !isset($_GET['action']) && $_GET['page'] == "wce-code-".$this->data_type )
     remove_all_actions("wce_after_form_complete_load"); 
	
	 do_action("wce_after_form_complete_load");
	
	}
	
	public function populate(){
	 
	 global $wpdb;
	 
	 if( $id = $this->getValue('id') )
	 
	 $row_data = $wpdb->get_row( "SELECT * from ".$this->table." WHERE id=".$id, ARRAY_A );
	 
	 if( isset($_POST) && !empty($_POST) )
	 
	 $row_data = $_POST;
	 
	 if(!isset($row_data['data_type']))
	 
	 $row_data['data_type'] = $this->data_type;
	 
	 
	 foreach($this->form_fields as $field)
	   
	 $this->setValue($field, $row_data[$field] );
		
	}
	
	public function setValue( $key , $value){
	
	 add_filter("wc_field_".$key."_value", 'stripslashes' );
	
	 $value = apply_filters("wc_field_".$key."_value", $value );
	 
	 $this->form_values[$key] = $value; 
	
	}
	
	public function getValue($key){
	
	 if( isset($this->form_values[$key]) && !empty($this->form_values[$key]))
	 return $this->form_values[$key];
	 
	 return ''; 
	
	}
	
	public function submit(){
	 

	  if( ! $this->_valid() )
	  return;
	 
	  $id = $this->_save();
	  
	  do_action( "wce_after_save_source", $id );
	  
	  wp_redirect( add_query_arg("message", 1) ); 	
	
	}
	
	private function _valid(){
		
	  $errors = new Wp_Error();
	  
	  if(!$this->getValue('data_title'))
	  
	  $errors->add( "data_title", __("<strong>Error:</strong> Title is requred", $this->textdomain) );	
	
	  if(!$this->getValue('data_source'))
	  
	  $errors->add( "data_source", __("<strong>Error:</strong> Body content is requred", $this->textdomain) );	

	  $this->errors = apply_filters("wce_form_errors", $errors, $this->form_values );
	  
	  if( !$this->errors->get_error_code() )
	  
	  return true;	
	
	  
	  return false;
		
	}
	
	private function _save(){
	    
	    global $wpdb;	
	    
		if( empty($this->form_values) )
		return;
		
		if( $id = $this->getValue('id') ){
		
		$wpdb->update( $this->table, $this->form_values, array("id" => $id ));
		 
		 return $this->id;	
			
		}

		$wpdb->insert( $this->table, $this->form_values );
		
		
	 
	  return $wpdb->insert_id;
	
	}
	
    public function show_messages(){
		
	  if( isset($this->errors) && is_object($this->errors) && count($this->errors->get_error_codes()) > 0 ){
		 
		 echo '<div id="messages" class="error">'.implode("<br>", $this->errors->get_error_messages() ).'</div>'; 
	  
	  }else if( isset($_GET['message']) && $_GET['message'] == 1){
		
		 echo '<div id="messages" class="updated">'.__("Save changes successfully", $this->textdomain).'</div>';  
		  
	  }	
		
	}
	
	public function page_before_element(){
	
	  echo '<div class="wrap">';
	  
	  echo '<h2>'.$this->page_title.'</h2>';
	  
	  do_action("wce_page_before_element");
	
	}
	
	public function page_after_element(){
	  
	  echo '</div>';  
	  
	  do_action("wce_page_after_element");
	
	}
	
	public function wce_get_form(){
	 
	 $this->page_before_element();
	 
	 $this->form(); 
	 
	 $this->page_after_element(); 
	
	}
	
    public function form(){
		?>
		<style>
		#data_title,#save{margin-left: 12px;}
		.submit{margin-top:0px!important;}
		#title{margin-left: 8px;}
		.wrap h2{margin-left: 8px;}
		.form-table th {
		 width:165px!important;
		 padding: 10px 10px 0px 0px!important;}
		 .form-table td {
			 padding: 8px 10px!important;}
		 span.required{
			color:red;
			font-weight:bold;
			padding-left:4px; 
		  }	 
				
		</style>
	   <form method="post" action="" name="" enctype="multipart/form-data"> 
	   
	    <table class="form-table">
		  <tr valign="top">
		    <th scope="row"><b><?php if($this->form_lable) echo $this->form_lable; ?></b></th>
		  </tr>
		  <tr valign="bottom">
			<th><label id="title"><?php _e('Title', $this->textdomain ); ?></label><span class="required">*</span></th>  
		    <td><input type="text" name="data_title" value="<?php echo $this->getValue('data_title'); ?>" class="regular-text" id="data_title"></td>
		  </tr>
		  <tr valign="top">
		    <td colspan="2"><?php echo $this->form_extra_fields(); ?></td>
		  </tr>
		  <tr>
		   <td colspan="2">
			 <label><b><?php if($this->body_lable) echo $this->body_lable; ?></label> <span class="required">*</span></b><br><br>  
		     <?php 
			  if($this->wp_editor == true): 
			   wp_editor($this->getValue('data_source'), "data_source");
			  
			  else: 
			 ?>
		     <textarea name="data_source" id="data_source"><?php echo $this->getValue('data_source'); ?></textarea>
			<?php 
			  
			  endif; 
			  
			  if($this->form_note) echo '<p class="description">'.$this->form_note.'</p>';
			?>
			</td>
		  </tr>
		</table>
		 <?php 
		  $this->form_hidden_fields(); 
		 ?>
		 <p class="submit">
		   <input type="submit" name="save" id="save" value="Save" class="button-primary" />
		 </p>
	   </form> 	
	  <?php      
	
	
	}
	
	function form_extra_fields(){
	  
	  ?>
	    <table class="form-table">
	      <tr valign="top">
	        <th scope="row"><label><?php _e("Apply Using", $this->textdomain ); ?></label></th>
	        <td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("Apply Using", $this->textdomain ); ?></span></legend>
	          <label title="Shortcode"><input type="radio" class="data_cond" value="" name="data_cond" <?php checked($this->getValue('data_cond'),"") ?>> <span><?php _e('Shortcode', $this->textdomain) ?></span></label>&nbsp;&nbsp;
	          <label title="Header"><input type="radio" value="header" name="data_cond" <?php checked($this->getValue('data_cond'),"header") ?>> <span><?php _e('wp_head', $this->textdomain) ?></span></label>&nbsp;&nbsp;
	          <label title="Footer"><input type="radio" value="footer" name="data_cond" <?php checked($this->getValue('data_cond'),"footer") ?>> <span><?php _e('wp_footer', $this->textdomain) ?></span></label>
	        </fieldset>	
	        </td>
	      </tr>
	    </table>
	  <?php 
	
	}
	
	function form_hidden_fields(){
	 
	  echo '<input type="hidden" name="wce_action" value="1"/>';
	  
	  wp_nonce_field( $this->nonce_name, $this->type."_nonce"); 
	 
	}
	
	public function wce_list_table(){
		
	  include_once(dirname(__FILE__).'/class-wce-list-table.php');
	  
	  $wce_list_table = new Wce_List_Table();
	  
	  $wce_list_table->table = $this->table; 
	  
	  $wce_list_table->textdomain = $this->textdomain;
	  
	  $wce_list_table->shortcode_name = $this->shortcode_name;
	  
	  $wce_list_table->data_type = $this->data_type;
	  
	  $wce_list_table->prepare_items();
	  
	  $wce_list_table->display();
	
	}
	
	public function wce_get_list(){
	 
	  $this->page_before_element();
	  
	  echo '<form method="post" action="">';
	  
	  $this->wce_list_table();
	  
	  echo '</form>';
	 
	  $this->page_after_element();
	
	}
	
	
  
  }
  
  class Wce_Code extends Wce_Code_Admin{
    
       
	public function __construct(){
	 
	  $this->page_title =  __("Import File", $this->textdomain );
	  
	  parent::__construct();
	
	}
	
   public function wce_get_form(){
	 
	 $this->page_before_element();
	 
	 $this->form(); 
	 
	 $this->page_after_element(); 
	
	}
	
	public function form(){

	 ?>
	  <form method="post" action="" enctype="multipart/form-data">
	    <table class="form-table">
		 <input type="hidden" name="wce_action" value="import"/>	
           <tr valign="top">
             <td width="100"><input type="file" name="import_file"></td>
             <td><input type="submit" name="import_btn" value="<?php _e('Import', $this->textdomain); ?>" class="button-primary"></td>
           </tr> 	    
	    </table> 
	    <?php  wp_nonce_field( "import_action", "import_data"); ?>
	  </form>
	  <h2>Export File</h2>
	    <form method="post" action="">
		 <input type="hidden" name="wce_action" value="export"/>	
	     <table class="form-table">
           <tr valign="top">
             <th><input type="submit" name="download_file" value="<?php _e('Download Export File', $this->textdomain); ?>" class="button-primary"></th>
           </tr> 	    
	     </table> 
	     <?php  wp_nonce_field("export_action","export_data"); ?>
	  </form>
	 <?php	
		
    }
    
    public function import(){
		
	  global $wpdb;	
	  
	  if( !$this->valid('import') )
	  return; 	
	  
	  $file = fopen( $_FILES['import_file']['tmp_name'], 'r' );	
	  
	  $field_head = array( "data_title", "data_type", "data_source", "data_cond", "tag_name"); 
	       
	  if( $row_first = fgetcsv( $file, NULL, ",") ){
	   
	   $insert = false;
	   
	   if( !in_array("data_title", $row_first) || !in_array("data_type", $row_first) ){
	    $this->errors->add("column_head", __("<strong>Error:</strong> Frist line of data column not found. Column is (".implode(",", $field_head).")", $this->textdomain) );
	    return;
       } 
       
	   while( $row = fgetcsv( $file, NULL, ",") ){
		 
		 $insert_data = array();
		 
		 if ( is_array( $row ) && count( $row ) == count( $row_first ) ) {
			
			$num = 0; 
		    
		    foreach( $field_head as $field){	 
		     
		      $insert_data[$field] = $row[$num];	 
		      
		      $num++;
		    
		    }
		    
		   if(count($insert_data) > 0){
			 $wpdb->insert( $this->table, $insert_data);
			 $insert = true;
			 unset($insert_data);   
		   }
		 
		  }
	   
	   }
	  
	   if($insert)
	   add_action("admin_notices", array($this, "wce_admin_import_notice") ); 
	   else
	   $this->errors->add("error", __("<strong>Problem for data insert try to again upload file.</strong>", $this->textdomain) );
	  
     }
	  
	  	
    }
    
    public function wce_admin_import_notice(){
	  echo '<div id="message" class="updated widefat"><p>'.__("Import data successfully", $this->textdomain).'.</p></div>';	
	}
    
    public function export(){
      
      global $wpdb;
	  
	  if( ! $this->valid('export') )
	  return;
		
		ob_clean( );
		
		$all_results = $wpdb->get_results("SELECT * From ".$this->table, ARRAY_A );
		
		$rm_fields = array("id", "accept_args");
		
		$fields = array();

		$rows = array();
	
		foreach( $all_results[0] as $field_name => $field_val){
		
		  if( in_array( $field_name, $rm_fields) )
		  continue;
		  
		  $fields[] = $field_name;
		  
		  
		}
		
		$rows[] = $fields; 
		
		foreach( $all_results as $field_value){
		   
		   $csv_data = array();
 
		   foreach( $fields as $field_name)	
		   $csv_data[] =  stripslashes($field_value[$field_name]);
		   
		   $rows[] = $csv_data; 
		}
		

		$file_path = plugin_dir_path(__FILE__)."/tmp/wce-data.csv";
		
		$fp = fopen($file_path , "ab");
		
		foreach($rows as $row){
		  
		  $result = fputcsv($fp, $row, ",");
		  
	    }
	    
		
		fclose($fp);
		
		
		header("Pragma: public"); // required
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false); // required for certain browsers
		header("Content-Type: application/octet-stream; charset=UTF-8");
		header("Content-Disposition: attachment; filename=\"".basename($file_path)."\";" );
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".filesize($file_path));
		
		readfile( $file_path );
		unlink($file_path);
		
		die( );
	  
		
    }
    
    private function valid( $type ){
		
		global $wpdb;
		
		if(! $type)
		return;
		
		$this->errors = new Wp_Error();
		
		if( $type === "export"){
		  
		  if($wpdb->get_var("SELECT COUNT(id) as ids FROM ".$this->table ) == false )
		  $this->errors->add( "data", __("<strong>Error:</strong> No data provided for download.", $this->textdomain) );
		}
		if( $type === "import"){
	     
	
		 if( empty( $_FILES['import_file']['name']))
	      $this->errors->add( "filename", __("<strong>Error:</strong> Upload a csv file.", $this->textdomain) ); 
	     
	     if($_FILES['import_file']['name']){
		   
		   $file = fopen( $_FILES['import_file']['tmp_name'], 'r' );	 
	       
	       $row = fgetcsv( $file, NULL, ",");

	       fclose($file);
	       if($row == false)
	       $this->errors->add("file_invalid", __("<strong>Error:</strong> Unable to read csv file.", $this->textdomain));
	       
	       if( is_array($row) && empty($row))
	       $this->errors->add("file_invalid", __("<strong>Error:</strong> File is empty.", $this->textdomain));

	     }

	   } 
	
	  
	  if( !$this->errors->get_error_code() )
	  return true;	
	
	  
	  return false;
	  
   }
 
  
  }
  
  class Wce_Code_Php_Html extends Wce_Code_Admin{
   
    var $inc_dir;
    
    var $actions;
    
    var $filters;
    
    var $func_prefix = "wce_";
    
	
	 
	public function __construct(){
	 
	  $this->page_title =  __("Manage PHP", $this->textdomain );
	  
	  $this->data_type = "php";
	  
	  $this->nonce_name = $this->data_type.'_source';
	  
	  $this->form_note2 = esc_html__("Don't use <?php tag at starting", $this->textdomain)."<br>";
	
	  $this->form_note2 .= esc_html__("You can define mutiple functions here to call on a single action or filter.", $this->textdomain)."<br>";
  
	  $this->form_note = esc_html__("<?php tag required at starting.", $this->textdomain);
	  
	  $this->inc_dir = plugin_dir_path(__FILE__)."inc/";
	  
	  add_action("wce_after_form_complete_load", array($this, "wce_load_default_actions_filters"));
	  
	  add_filter( 'wce_editor_form_fiels', array($this, "wce_action_filter_fields") ); 
	
	  add_filter('wce_form_errors', array( $this, "wce_action_filter_hook_validate"), 10, 2);
	  
	  add_action( "wce_after_form_complete_load", array( $this, "wce_load_codemirror_php" ), 11 );

	  
	  parent::__construct();
	  
	}
	
	public function wce_load_codemirror_php(){

	  wp_enqueue_script("wce-codemirror-mode-htmlmixed", plugins_url("/assets/codemirror/mode/htmlmixed.js",__FILE__) );	

	  wp_enqueue_script("wce-codemirror-mode-xml", plugins_url("/assets/codemirror/mode/xml.js",__FILE__) );	

	  wp_enqueue_script("wce-codemirror-mode-js", plugins_url("/assets/codemirror/mode/javascript.js",__FILE__) );	

	  wp_enqueue_script("wce-codemirror-mode-css", plugins_url("/assets/codemirror/mode/css.js",__FILE__) );	

	  wp_enqueue_script("wce-codemirror-mode-clike", plugins_url("/assets/codemirror/mode/clike.js",__FILE__) );	
		
	  wp_enqueue_script("wce-codemirror-mode-php", plugins_url("/assets/codemirror/mode/php.js",__FILE__) );	
      
      wp_enqueue_script("wce-codemirror-php", plugins_url("/assets/codemirror/js/cm-php.js",__FILE__) );

	}
	
	public function wce_action_filter_hook_validate($errors, $field){
	 
	 if(!empty($field['data_cond'])){
	   
	   if(empty($field['tag_name']))	 
	   $errors->add("tagname", __("<strong>Error:</strong> Action/Filter name is required.", $this->textdomain) );
	 }
	
	 return $errors;
	}
	
	function wce_action_filter_fields($fields){
	
	 $fields[] = "tag_name";
	 
	 $fields[] = "accept_args";
	
	 return $fields;
	
	}

	function wce_load_default_actions_filters(){
	
	  add_action( "wce_wp_tag_actions", array($this, 'wce_wp_tag_actions_filters'), 1, 2 );
	  
	  add_action( "wce_wp_tag_filters", array($this, 'wce_wp_tag_actions_filters'), 1,  2 );
	  
	  
	}
	
	function wce_wp_tag_actions_filters($type, $actions){
	  
	  if( $type == 'action')
	  $this->actions =  $actions;
	  
	  if( $type == 'filter')
	  $this->filters =  $actions;
	  
	  if( $this->getValue('data_cond') == "action"){
	    
		if( $tagname = $this->getValue('tag_name') )
		
		$this->actions[$tagname]['script_content'] = $this->getValue('data_source'); 
	  
	  }
	  
	  
	  if( $this->getValue('data_cond') == "filter"){
	  
	    
		if( $tagname = $this->getValue('tag_name') )
		
		$this->filters[$tagname]['script_content'] = $this->getValue('data_source'); 
	  
	  }


	
	}
	
	function form_extra_fields(){
	  
	  ?>
	    
	    <script type="text/javascript">
		
		jQuery(document).ready(function(){
		
		 jQuery('input:radio[name="data_cond"]').change(function(e){
		  
		  e.preventDefault();
		  
		   obj = jQuery(this);
		   
		   var tags = "";
		   
		   var label = "";
		   
		   acf =  jQuery('input:radio[name="data_cond"]:checked').val();
		   
		   jQuery('.description').html('<?php echo $this->form_note2; ?>');
		   
		   tag = jQuery("<input>").attr("type", "text").attr("name", "tag_name").css("width","369px");

		   table = obj.closest("table");
		   
		   tr2 = table.find('tr').eq(1).hide();
		   
		   tr3 = table.find('tr').eq(2).hide();
		   
		   if( acf  == 'action'){
		   label = '<label><?php _e("Action Name", $this->textdomain); ?><span class="required">*</span></label>';
	       }
		   else
		   if( acf  == 'filter'){
		    label = '<label><?php _e("Filter Name", $this->textdomain); ?> <span class="required">*</span></label>';
           }else{
		     
		     jQuery('.description').html('<?php echo $this->form_note; ?>');
		     <?php if( !$this->getValue("data_source") ): ?>
		     jQuery('#data_source').val('');
		     <?php endif; ?>
		    return;
		   }
		   
		   var current_action  = '<?php if( $this->getValue("data_cond") ) echo $this->getValue("data_cond");  ?>';
		   
		   <?php 
			  if($this->getValue("tag_name"))
			  echo "tag.val('".$this->getValue("tag_name")."');"; 
		   ?>
		   
		   if( current_action != acf)
		   tag.val('');
			
			 var tagnote = ''; 
			 
			 if(acf == 'action')
			 tagnote = '<?php _e("Write correct wordpress action tag name.", $this->textdomain); ?>';
			 if(acf == 'filter')
			 tagnote = '<?php _e("Write correct wordpress filter tag name.", $this->textdomain); ?>';
			 
			 tr2.find("th").html(label);
			 tr2.find("td").html(tag).append("<p class='description'>"+tagnote+"</p>");
			 tr2.fadeIn(); 

		 
		 }).change();
		 
		 
		}) 	
	    
	    </script>
	    
	    <table class="form-table" style="width:70%">
	      <tr valign="top">
	        <th scope="row">
			  <label><?php _e("Apply Using", $this->textdomain ); ?></label>
			</th>
			<td>  
			<fieldset><legend class="screen-reader-text"><span><?php _e("Apply Using", $this->textdomain ); ?></span></legend>
	          <label title="Shortcode"><input type="radio" class="data_cond" value="" name="data_cond" <?php checked($this->getValue('data_cond'),"") ?>> <span><?php _e("Shortcode", $this->textdomain ); ?></span></label>&nbsp;&nbsp;
	          <label title="WP Action"><input type="radio" class="data_cond" value="action" name="data_cond" <?php checked($this->getValue('data_cond'),"action") ?>> <span><?php _e("WP Action", $this->textdomain ); ?></span></label>&nbsp;&nbsp;
	          <label title="WP Filter"><input type="radio" class="data_cond" value="filter" name="data_cond" <?php checked($this->getValue('data_cond'),"filter") ?>> <span><?php _e("WP Filter", $this->textdomain ); ?></span></label>
	        </fieldset>	
	        </td>
	       </tr>
	       <tr valign="top">   
	         <th>&nbsp;</th>
			 <td>&nbsp;</td>
	       </tr>
	       <tr valign="top">   
	         <th>&nbsp;</th>
			 <td>&nbsp;</td>
	       </tr>
	    </table>
	  <?php 
	
	}
  
 
  
  }
 
  class Wce_Code_Js extends Wce_Code_Admin{
  
   
    public function __construct(){
  
     $this->page_title =  __("Manage Javascript", $this->textdomain );
	 
	  $this->data_type = "js";
	  
	  $this->nonce_name = $this->data_type.'_source';
	  
	  $this->form_note = esc_html__( "Do not include <script> tag inside.", $this->textdomain );
	  
	  add_action( "wce_after_form_complete_load", array( $this, "wce_load_codemirror_js" ), 11 );
      
      parent::__construct(); 

    } 
    
    public function wce_load_codemirror_js(){
	

	  wp_enqueue_script("wce-codemirror-mode-js", plugins_url("/assets/codemirror/mode/javascript.js",__FILE__) );	

      wp_enqueue_script("wce-codemirror-js", plugins_url("/assets/codemirror/js/cm-javascript.js",__FILE__) );
	
	}    

  
  
  } 
  
  class Wce_Code_Css extends Wce_Code_Admin{
    
	public function __construct(){
  
     $this->page_title =  __("Manage CSS", $this->textdomain );
	 
	 $this->data_type = "css";
	  
	 $this->nonce_name = $this->data_type.'_source';
	  
	  $this->form_note = esc_html__( "Write css code without <style>...</style> tags. ex: a{ text-decoration:none; }", $this->textdomain );
      
      add_action( "wce_after_form_complete_load", array( $this, "wce_load_codemirror_css" ), 11 );
     
      parent::__construct();
	
    }   
    
    public function wce_load_codemirror_css(){
	
	  wp_enqueue_script("wce-codemirror-mode-css", plugins_url("/assets/codemirror/mode/css.js",__FILE__) );	
      wp_enqueue_script("wce-codemirror-css", plugins_url("/assets/codemirror/js/cm-css.js",__FILE__) );
	
	}     
	
 
  
  } 
