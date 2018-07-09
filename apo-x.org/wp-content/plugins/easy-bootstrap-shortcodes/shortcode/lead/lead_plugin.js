var lead={
    title:"Lead Shortcode",
    id :'oscitas-form-lead',
    pluginName: 'lead',
    showprobtn: false
};
(function() {
    _create_tinyMCE_options(lead);
})();

function ebs_return_html_lead(pluginObj){
    var form = jQuery('<div id="'+pluginObj.id+'" class="oscitas-container" title="'+pluginObj.title+'"><table id="oscitas-table" class="form-table">\
			 <tr>\
        <th class="aligncenter"><img src="'+ebs_url+'shortcode/lead/screenshot.jpg" /></th>\
        </tr>\
		</table>\
		</div>');
    return form;
}


function create_oscitas_lead(pluginObj){
}