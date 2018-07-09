var sectionhead={
    title:"Section Head Shortcode",
    id :'oscitas-form-sectionhead',
    pluginName: 'sectionhead',
    showprobtn: false
};
(function() {
    _create_tinyMCE_options(sectionhead);
})();

function ebs_return_html_sectionhead(pluginObj){
    var form = jQuery('<div id="'+pluginObj.id+'" class="oscitas-container" title="'+pluginObj.title+'"><table id="oscitas-table" class="form-table">\
			 <tr>\
        <th class="aligncenter"><img src="'+ebs_url+'shortcode/sectionhead/screenshot.jpg" /></th>\
        </tr>\
		</table>\
		</div>');
    return form;
}


function create_oscitas_sectionhead(pluginObj){
}