var rule={
    title:"Horizontal1 Rule Shortcode",
    id :'oscitas-form-rule',
    pluginName: 'rule'
};
(function() {
    _create_tinyMCE_options(rule);
})();

function ebs_return_html_rule(pluginObj){
    var form = jQuery('<div id="'+pluginObj.id+'" class="oscitas-container" title="'+pluginObj.title+'"><table id="oscitas-table" class="form-table ebs-default-options">\
			<tr>\
				<th><label for="oscitas-rule-style">'+ebsjstrans.style+':</label></th>\
				<td><select name="type" id="oscitas-rule-style">\
					<option value="rule-dotted">'+ebsjstrans.dotted+'</option>\
					<option value="rule-dashed">'+ebsjstrans.dashed+'</option>\
					<option value="rule-double">'+ebsjstrans.double+'</option>\
					<option value="rule-diagonal">'+ebsjstrans.diagonal+'</option>\
					<option value="rule-double-thick-thin">'+ebsjstrans.doublethickthin+'</option>\
					<option value="rule-double-fadecorder">'+ebsjstrans.doublefadecorner+'</option>\
					<option value="rule-fadecorder">'+ebsjstrans.fadecorner+'</option>\
					<option value="rule-shadow">'+ebsjstrans.shadow+'</option>\
					<option value="rule-wave">'+ebsjstrans.wave+'</option>\
					<option value="rule-thick">'+ebsjstrans.thick+'</option>\
					<option value="rule-thin">'+ebsjstrans.thin+'</option>\
				</select><br />\
				</td>\
			</tr>\
                        <tr>\
				<th><label for="oscitas-rule-margin">'+ebsjstrans.margin+':</label></th>\
				<td><input type="text" name="line" id="oscitas-rule-margin" value=""/><br />\
                                <small>'+ebsjstrans.enternumvaleg20+'</small>\
				</td>\
			</tr>\
                        <tr>\
				<th><label for="oscitas-rule-class">'+ebsjstrans.customclass+':</label></th>\
				<td><input type="text" name="line" id="oscitas-rule-class" value=""/><br />\
				</td>\
			</tr>\
		</table>\
		<p class="submit ebs-default-options">\
			<input type="button" id="oscitas-rule-submit" class="button-primary" value="'+ebsjstrans.insert+' '+ebsjstrans.horizontal+' '+ebsjstrans.rule+'" name="submit" />\
		</p>\
		<div class="pro-version-image aligncenter" style="display: none;"><img src="'+ebs_url+'shortcode/rule/screenshot.jpg"/></div>\
		</div>');

    return form;
}


function create_oscitas_rule(pluginObj){

    var form = jQuery(pluginObj.hashId);
    var table = form.find('table');
    //form.appendTo('body').hide();

    // handles the click event of the submit button
    form.find('#oscitas-rule-submit').click(function() {
        // defines the options and their default values
        // again, this is not the most elegant way to do this
        // but well, this gets the job done nonetheless
        var cusclass='',margin='';
        if(table.find('#oscitas-rule-class').val()!=''){
            cusclass= ' class="'+table.find('#oscitas-rule-class').val()+'"';
        }
        if(table.find('#oscitas-rule-margin').val()!=''){
            margin= ' margin="'+table.find('#oscitas-rule-margin').val()+'"';
        }
        var shortcode = '[rule'+cusclass+margin;

        shortcode += ' style="' + table.find('#oscitas-rule-style').val();

        shortcode += '" ';
        //shortcode += ' btntag="'+table.find('#oscitas-button-type').val()+'" ';



        shortcode += ']';

        // inserts the shortcode into the active editor
        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

        // closes Dialoguebox
        close_dialogue(pluginObj.hashId);
    });
}

