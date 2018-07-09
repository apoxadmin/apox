var dropcaps={
    title:"Dropcaps Shortcode",
    id :'oscitas-form-dropcaps',
    pluginName: 'dropcaps',
    showprobtn: false
};
(function() {
    _create_tinyMCE_options(dropcaps);
})();

function ebs_return_html_dropcaps(pluginObj){
    var form = jQuery('<div id="'+pluginObj.id+'" class="oscitas-container" title="'+pluginObj.title+'"><table id="oscitas-table" class="form-table">\
			 <tr>\
        <th class="aligncenter"><img src="'+ebs_url+'shortcode/dropcaps/screenshot.jpg" /></th>\
        </tr>\
		</table>\
		</div>');
    return form;
}


function create_oscitas_dropcaps(pluginObj){
}