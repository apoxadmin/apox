var oscpopups={
    title:"Popups Shortcode",
    id :'oscitas-form-oscpopups',
    pluginName: 'oscpopups',
    showprobtn: false
};
(function() {
    _create_tinyMCE_options(oscpopups);
})();

function ebs_return_html_oscpopups(pluginObj){
    var form = jQuery('<div id="'+pluginObj.id+'" class="oscitas-container" title="'+pluginObj.title+'"><table id="oscitas-table" class="form-table">\
			 <tr>\
        <th class="aligncenter"><img src="'+ebs_url+'shortcode/oscpopups/screenshot.jpg" /></th>\
        </tr>\
		</table>\
		</div>');
    return form;
}


function create_oscitas_oscpopups(pluginObj){
}