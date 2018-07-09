var highlights={
    title:"Highlights Shortcode",
    id :'oscitas-form-highlights',
    pluginName: 'highlights',
    showprobtn: false
};
(function() {
    _create_tinyMCE_options(highlights);
})();

function ebs_return_html_highlights(pluginObj){
    var form = jQuery('<div id="'+pluginObj.id+'" class="oscitas-container" title="'+pluginObj.title+'"><table id="oscitas-table" class="form-table">\
			 <tr>\
        <th class="aligncenter"><img src="'+ebs_url+'shortcode/highlights/screenshot.jpg" /></th>\
        </tr>\
		</table>\
		</div>');
    return form;
}


function create_oscitas_highlights(pluginObj){
}