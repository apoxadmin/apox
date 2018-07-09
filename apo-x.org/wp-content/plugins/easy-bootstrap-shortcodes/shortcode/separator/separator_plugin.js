var separator={
    title:"Separator Shortcode",
    id :'oscitas-form-separator',
    pluginName: 'separator',
    showprobtn: false
};
(function() {
    _create_tinyMCE_options(separator);
})();

function ebs_return_html_separator(pluginObj){
    var form = jQuery('<div id="'+pluginObj.id+'" class="oscitas-container" title="'+pluginObj.title+'"><table id="oscitas-table" class="form-table">\
			 <tr>\
        <th class="aligncenter"><img src="'+ebs_url+'shortcode/separator/screenshot.jpg" /></th>\
        </tr>\
		</table>\
		</div>');
    return form;
}


function create_oscitas_separator(pluginObj){
}