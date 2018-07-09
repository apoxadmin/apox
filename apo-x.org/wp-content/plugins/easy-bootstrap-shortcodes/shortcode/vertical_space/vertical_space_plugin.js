var vertical_space={
    title:"Vertical Space Shortcode",
    id :'oscitas-form-vertical_space',
    pluginName: 'vertical_space',
    showprobtn: false
};
(function() {
    _create_tinyMCE_options(vertical_space);
})();

function ebs_return_html_vertical_space(pluginObj){
    var form = jQuery('<div id="'+pluginObj.id+'" class="oscitas-container" title="'+pluginObj.title+'"><table id="oscitas-table" class="form-table">\
			 <tr>\
        <th class="aligncenter"><img src="'+ebs_url+'shortcode/vertical_space/screenshot.jpg" /></th>\
        </tr>\
		</table>\
		</div>');
    return form;
}


function create_oscitas_vertical_space(pluginObj){
}