var well={
    title:"Well Shortcode",
    id :'oscitas-form-well',
    pluginName: 'well'
};
(function() {
    _create_tinyMCE_options(well);
})();

function ebs_return_html_well(pluginObj){
    var form = jQuery('<div id="'+pluginObj.id+'" class="oscitas-container" title="'+pluginObj.title+'"><table id="oscitas-table" class="form-table ebs-default-options">\
			<tr>\
				<th><label for="oscitas-well-type">'+ebsjstrans.well+' '+ebsjstrans.type+':</label></th>\
				<td><select name="type" id="oscitas-well-type">\
					<option value="">'+ebsjstrans.default+'</option>\
					<option value="well-lg">'+ebsjstrans.large+'</option>\
					<option value="well-sm">'+ebsjstrans.small+'</option>\
				</select><br />\
				</td>\
			</tr>\
			<tr>\
				<th><label for="oscitas-well-content">'+ebsjstrans.well+' '+ebsjstrans.content+':</label></th>\
				<td><textarea name="well" id="oscitas-well-content">'+ebsjstrans.your+' '+ebsjstrans.content+'</textarea><br />\
				</td>\
			</tr>\
                        <tr>\
				<th><label for="oscitas-well-class">'+ebsjstrans.customclass+':</label></th>\
				<td><input type="text" name="line" id="oscitas-well-class" value=""/><br />\
				</td>\
			</tr>\
		</table>\
		<p class="submit ebs-default-options">\
			<input type="button" id="oscitas-well-submit" class="button-primary" value="'+ebsjstrans.insert+' '+ebsjstrans.well+'" name="submit" />\
		</p>\
		<div class="pro-version-image aligncenter" style="display: none;"><img src="'+ebs_url+'shortcode/well/screenshot.jpg"/></div>\
		</div>');

    return form;
}
function create_oscitas_well(pluginObj){
   var form=jQuery(pluginObj.hashId);
		
    var table = form.find('table');

   

        
		
    // handles the click event of the submit button
    form.find('#oscitas-well-submit').click(function(){
        var cusclass='';
        if(table.find('#oscitas-well-class').val()!=''){
            cusclass= ' class="'+table.find('#oscitas-well-class').val()+'"';
        }
        var shortcode = '['+$ebs_prefix+'well type="'+jQuery('#oscitas-well-type').val()+'"'+cusclass+']<br class="osc"/>';
        shortcode += jQuery('#oscitas-well-content').val()+'<br class="osc"/>';
        shortcode += '[/'+$ebs_prefix+'well]';

        // inserts the shortcode into the active editor
        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
        // closes fancybox
        close_dialogue(pluginObj.hashId);
    });
}

