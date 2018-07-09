var deslist={
    title:"List Group Shortcode",
    id :'oscitas-form-deslists',
    pluginName: 'deslist'
};
(function() {
    _create_tinyMCE_options(deslist);
})();
function ebs_return_html_deslist(pluginObj){
    var form = jQuery('<div id="'+pluginObj.id+'" class="oscitas-container" title="'+pluginObj.title+'"><table id="oscitas-table" class="form-table ebs-default-options">\
			<tr>\
				<th><label for="oscitas-line">'+ebsjstrans.noof+' '+ebsjstrans.list+' '+ebsjstrans.item+'</label></th>\
				<td><input type="text" name="line" id="oscitas-deslist-item" value="3"/><br /><small>'+ebsjstrans.enternumval+'</small>\
				</td>\
			</tr>\
                <tr>\
                    <th><label for="oscitas-deslist-style">'+ebsjstrans.list+' '+ebsjstrans.style+'</label></th>\
                    <td><select name="type" id="oscitas-deslist-style">\
                        <option value="">'+ebsjstrans.default+'</option>\
                        <option value="dl-horizontal">'+ebsjstrans.horizontal+'</option>\
                    </select><br />\
                    </td>\
                </tr>\
                        <tr>\
				<th><label for="oscitas-deslist-class">'+ebsjstrans.customclass+':</label></th>\
				<td><input type="text" name="line" id="oscitas-deslist-class" value=""/><br />\
				</td>\
			</tr>\
		</table>\
		<p class="submit ebs-default-options">\
			<input type="button" id="oscitas-deslist-submit" class="button-primary" value="'+ebsjstrans.insert+' '+ebsjstrans.list+'" name="submit" />\
		</p>\
		<div class="pro-version-image aligncenter" style="display: none;"><img src="'+ebs_url+'shortcode/deslist/screenshot.jpg"/></div>\
		</div>');
    return form;
}
function create_oscitas_deslist(pluginObj){

      var form=  jQuery(pluginObj.hashId);

    // creates a form to be displayed everytime the button is clicked
    // you should achieve this using AJAX instead of direct html code like this

		
    var table = form.find('table');

		
    // handles the click event of the submit button
    form.find('#oscitas-deslist-submit').click(function(){
        // defines the options and their default values
        // again, this is not the most elegant way to do this
        // but well, this gets the job done nonetheless
        var options = { 
            'type'       : 'arrow'
        },deslist=0,deslist_type;
        var cusclass='',style='';
        if(table.find('#oscitas-deslist-class').val()!=''){
            cusclass= ' class="'+table.find('#oscitas-deslist-class').val()+'"';
        }
        if(table.find('#oscitas-deslist-style').val()!=''){
            style= ' style="'+table.find('#oscitas-deslist-style').val()+'"';
        }
        var shortcode = '['+$ebs_prefix+'dl'+cusclass+style;
        var deslist_item=jQuery('#oscitas-deslist-item').val();
        if(isNaN(deslist_item)==false){
            deslist=deslist_item;
        } else{
            deslist=3;
        }	
     

        shortcode += ']<br/>';
        for(var i=1;i<=deslist;i++){
            shortcode +='['+$ebs_prefix+'dlitem heading="Heading '+i+'"]'+ebsjstrans.description+' '+i+'[/'+$ebs_prefix+'dlitem]<br/>'
        }
        shortcode +='[/'+$ebs_prefix+'dl]';
			
        // inserts the shortcode into the active editor
        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

        close_dialogue(pluginObj.hashId);
    });
}