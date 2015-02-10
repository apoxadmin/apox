<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

class Wce_List_Table extends WP_List_Table

{

    function __construct()
    {
        parent::__construct(array(

            'singular' => 'wce',

            'plural' => 'wce',

        ));
        
        

    }

    function column_default($item, $column_name)
    {
        return $item[$column_name];
    }



    function column_title($item)
    {
		$page = "wce-code-".$item['data_type'];
        
        $actions = array(

            'edit' => sprintf('<a href="?page=%s&action=edit&id=%s">%s</a>', $page, $item['id'], __('Edit', $this->textdomain )),

            'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['id'], __('Delete', $this->textdomain )),

        );

      
      return sprintf('%s %s',

            $item['data_title'],

            $this->row_actions($actions)

        );

		

    }



    function column_cb($item)

    {

        return sprintf(

            '<input type="checkbox" name="id[]" value="%s" />',

            $item['id']

        );

    }



    function get_columns()

    {

        $columns = array(

            'cb' => '<input type="checkbox" />',

            'title' => __("Title", $this->textdomain ),
            
            'include_in' => __("Apply Using", $this->textdomain ),
            
            'status' => __("Status", $this->textdomain ),
		
			'shortcode' => __("Shortcode", $this->textdomain ),
        );

        return $columns;

    }
    
    function column_include_in( $item ){
	 
	 $include = $item['data_cond'];
	 
		 
	if( in_array($include, array('filter', 'action') ) ){
	  $title = "<b>WP ".ucfirst($include)."</b>";
	  $title .= "<p style='font-size:11px'>".ucfirst($include)." name : ".$item['tag_name']."</p>";
	  if($item['accept_args'] > 1)
	  $title .= "<p style='font-size:11px'> ".__('Accept args', $this->textdomain)." : ".$item['accept_args']."</p>";
	 
	} 
	else
	if( in_array($include, array('header', 'footer') ) ){
	  $title = "<b>WP ".ucfirst($include)."</b>";
	  $title .= "<p style='font-size:11px'> ".__('Action name', $this->textdomain)." : wp_".$include."</p>";
	
	}else{
	  
	  $title = "<b>".__('Shortcode', $this->textdomain)."</b>";	
	}  

	 if(isset($title))  
	 return $title;
	
	}



    function get_sortable_columns() {

        $sortable_columns = array(

            'title' => array('title', true),
            
            'include_in' => array('data_cond', false),
            
             'status' => array('status', false),
        );

        return $sortable_columns;

    }
    
    function column_status($item){
	
	 if( $item['status'] == 1)
	 $title = "Enable";
	 else 
	 $title = "Disable";
	 return $title; 	
	
	}
    
    function column_type($item){
		
	 if($item['data_type'] == "php"){

	   $item['data_type'] = __("<b>PHP</b>", $this->textdomain);
	   
	   if( ! in_array( $item['data_cond'], array('filter', 'action') ) )	
	   
	   $item['data_type'] = __("<b>PHP/HTML</b>", $this->textdomain);
	 	 
	 }
	 
	 
	 if($item['data_type'] == "js")
	 
	 $item['data_type'] = __("<b>JAVASCRIPT</b>", $this->textdomain);
		
	 if($item['data_type'] == "css")
	 
	 $item['data_type'] = __("<b>CSS</b>", $this->textdomain);
		
	 return ucfirst($item['data_type']);
	
	}
	
	function column_shortcode($item){
		
	  if( ! in_array( $item['data_cond'], array('filter', 'action') ) )		
	  
	  return '['.$this->shortcode_name.' id="'.$item['id'].'"] <br><i style="font-size:10px;">'.__("Copy and paste shortcode on page or posts.", $this->textdomain).'</i>';	
	
	}



    function get_bulk_actions() {

        $actions = array(

            'delete' => __('Delete', $this->textdomain),
            
            'enable' => __('Enable', $this->textdomain),

            'disable' => __('Disable', $this->textdomain)


        );

        return $actions;

    }
    
    function process_bulk_action(){

        global $wpdb;
       
        if ('delete' === $this->current_action()) {

            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();

            if (is_array($ids)) $ids = implode(',', $ids);



            if (!empty($ids)) {

                $wpdb->query("DELETE FROM ".$this->table." WHERE id IN($ids)");

            }

        }
        if ('enable' === $this->current_action()) {

            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();

 
            if (!empty($ids)) {

                foreach( $ids as $id)
                $wpdb->update( $this->table, array('status' => 1), array('id' => $id));

            }

        }
        if ('disable' === $this->current_action()) {

            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
 
            if (!empty($ids)) {
                
                foreach( $ids as $id)
                $wpdb->update( $this->table, array('status' => 0), array('id' => $id));
            }

        }

    }



    function prepare_items()
    {

        global $wpdb;

        $per_page = 10;
        
        $columns = $this->get_columns();

        $hidden = array();
        
        $this->process_bulk_action();

        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);

        $total_items = $wpdb->get_var("SELECT COUNT(id) FROM ".$this->table);

        $paged = isset($_REQUEST['paged']) ? ($_REQUEST['paged']-1)*$per_page : 0;

        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'id';

        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';
        
        if(isset($this->data_type) && !empty($this->data_type))
        $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$this->table. " WHERE data_type = '%s'  ORDER BY $orderby $order LIMIT %d OFFSET %d", $this->data_type, $per_page, $paged), ARRAY_A);
        else
        $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$this->table." ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
        
        $this->set_pagination_args(array(

            'total_items' => $total_items,

            'per_page' => $per_page,

            'total_pages' => ceil($total_items / $per_page)

        ));

    }

}
