var blur={
    title:"Blur Shortcode",
    id :'oscitas-form-blur',
    pluginName: 'blur',
    showprobtn: false
};
(function() {
    _create_tinyMCE_options(blur);
})();

function ebs_return_html_blur(pluginObj){
    var form = jQuery('<div id="'+pluginObj.id+'" class="oscitas-container" title="'+pluginObj.title+'"><table id="oscitas-table" class="form-table">\
			 <tr>\
        <th class="aligncenter"><img src="'+ebs_url+'shortcode/blur/screenshot.jpg" /></th>\
        </tr>\
		</table>\
		</div>');
    return form;
}


function create_oscitas_blur(pluginObj){
}