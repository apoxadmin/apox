var widget={
    title:"Widget Shortcode",
    id :'oscitas-form-widget',
    pluginName: 'widget',
    showprobtn: false
};
(function() {
    _create_tinyMCE_options(widget);
})();

function ebs_return_html_widget(pluginObj){
    var form = jQuery('<div id="'+pluginObj.id+'" class="oscitas-container" title="'+pluginObj.title+'"><table id="oscitas-table" class="form-table">\
			 <tr>\
        <th class="aligncenter"><img src="'+ebs_url+'shortcode/widget/screenshot.jpg" /></th>\
        </tr>\
		</table>\
		</div>');
    return form;
}


function create_oscitas_widget(pluginObj){
}