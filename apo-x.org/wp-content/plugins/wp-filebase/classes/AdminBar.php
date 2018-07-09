<?php class WPFB_AdminBar {
static function AdminBar() {
	global $wp_admin_bar;
	
	WPFB_Core::PrintJS();
	
	$wp_admin_bar->add_menu(array('id' => WPFB, 'title' => WPFB_PLUGIN_NAME, 'href' => admin_url('admin.php?page=wpfilebase_manage')));
	
	$wp_admin_bar->add_menu(array('parent' => WPFB, 'id' => WPFB.'-add-file', 'title' => __('Add File', WPFB), 'href' => admin_url('admin.php?page=wpfilebase_files#addfile')));
	
	$current_object = get_queried_object();
	$is_filebrowser = false;
	if ( !empty($current_object) && !empty($current_object->post_type) && $current_object->ID > 0) {
		$is_filebrowser = ($current_object->ID == WPFB_Core::$settings->file_browser_post_id);
		$link = WPFB_PLUGIN_URI.'editor_plugin.php?manage_attachments=1&amp;post_id='.$current_object->ID;
		$wp_admin_bar->add_menu( array( 'parent' => WPFB, 'id' => WPFB.'-attachments', 'title' => __('Manage attachments', WPFB), 'href' => $link,
		'meta' => array('onclick' => 'window.open("'.$link.'", "wpfb-manage-attachments", "width=680,height=400,menubar=no,location=no,resizable=no,status=no,toolbar=no,scrollbars=yes");return false;')));
	}
	
	$wp_admin_bar->add_menu(array('parent' => WPFB, 'id' => WPFB.'-add-file', 'title' => __('Sync Filebase', WPFB), 'href' => admin_url('admin.php?page=wpfilebase_manage&action=sync')));
	
	$wp_admin_bar->add_menu(array('parent' => WPFB, 'id' => WPFB.'-toggle-context-menu', 'title' => !empty(WPFB_Core::$settings->file_context_menu)?__('Disable file context menu',WPFB):__('Enable file context menu', WPFB), 'href' => 'javascript:;',
	'meta' => array('onclick' => 'return wpfb_toggleContextMenu();')));
	
	if($is_filebrowser) {
		$wp_admin_bar->add_menu(array('parent' => WPFB, 'id' => WPFB.'-toggle-drag-drop', 'title' => get_user_option('wpfb_set_fbdd') ? __('Disable file browser Drag &amp; Drop',WPFB) : __('Enable file browser Drag &amp; Drop', WPFB), 'href' => 'javascript:;',
		'meta' => array('onclick' => 'jQuery.ajax({url:wpfbConf.ajurl,type:"POST",data:{action:"set-user-setting",name:"fbdd",value:'.(get_user_option('wpfb_set_fbdd')?0:1).'},async:false});location.reload();return false;')));
	}
	
}
}
