<?php class WPFB_AdminGuiFileBrowser {
	static function Display()
	{
		wpfb_loadclass('Output', 'File', 'Category','TplLib');
				
		$content ='';
		
		$file_tpls = WPFB_Core::GetTpls('file');
		$cat_tpls = WPFB_Core::GetTpls('cat');
		if(true || !isset($file_tpls['filebrowser_admin'])) {
			$file_tpls['filebrowser_admin'] = 
				'%file_small_icon% '.
				'%file_display_name% (<a href="%file_url%">%file_name%</a>, %file_size%) '.
				'<!-- IF %file_user_can_edit% --><a href="%file_edit_url%" class="edit" onclick="wpfbFBEditFile(event)">%\'Edit\'%</a><!-- ENDIF -->'.
				'<!-- IF %file_user_can_edit% --><a href="#" class="delete" onclick="return confirm(\'Sure?\') && wpfbFBDelete(event) && false;">%\'Delete\'%</a><!-- ENDIF -->'
			;
			WPFB_Core::SetFileTpls($file_tpls);
			//WPFB_Admin::ParseTpls();
		}
		
		if(true || !isset($cat_tpls['filebrowser_admin'])) {
			$cat_tpls['filebrowser_admin'] = 
				'<span class="cat-icon" style="background-image:url(\'%cat_icon_url%\');"><span class="cat-icon-overlay"></span></span>'.
				'%cat_name% (%cat_num_files% / %cat_num_files_total%)'.
				'<!-- IF %cat_user_can_edit% --><a href="%cat_edit_url%" class="edit" onclick="wpfbFBEditCat(event)">%\'Edit\'%</a><!-- ENDIF -->'.
				'<!-- IF %cat_user_can_edit% --><a href="#" class="delete" onclick="return confirm(\'Sure?\') && wpfbFBDelete(event) && false;">%\'Delete\'%</a><!-- ENDIF -->'
			;			
			WPFB_Core::SetCatTpls($cat_tpls);
			WPFB_Admin::ParseTpls();
		}
	

		WPFB_Output::FileBrowser($content, 0, empty($_GET['wpfb_cat']) ? 0 : intval($_GET['wpfb_cat']));	
		wpfb_call('Output', 'PrintJS');
		
?>
    <div class="wrap filebrowser-admin"> 
    <h2><?php _e('File Browser','wp-filebase') ?></h2>    
<?php
		echo '<div>'.__('You can Drag &amp; Drop (multiple) files directly on Categories to upload them. Dragging a category or an existing file to another category is also possible.','wp-filebase').'</div>';
		
		echo $content;
?>
	 </div>
<script>
	function wpfbFBEditCat(e) {
		e.stopPropagation();
	}
	
	function wpfbFBEditFile(e) {
		e.stopPropagation();
	}	
	
	function wpfbFBDelete(e) {
		e.stopPropagation();
		var t = jQuery(e.currentTarget).parents('li').first();		
		var d = {wpfb_action: 'delete'};
		var tid = t.attr('id').split('-');
		d[tid[tid.length-2]+'_id'] = +tid[tid.length-1];
		jQuery.ajax({type: 'POST', url: wpfbConf.ajurl, data: d,
			//async: false,
			success: (function (data) {
				if (data == '1') {
					t.fadeOut(300, function() { t.remove(); });
				}
			})
		});
	
		return false;
	}	
</script>
	
<?php
	}
}
