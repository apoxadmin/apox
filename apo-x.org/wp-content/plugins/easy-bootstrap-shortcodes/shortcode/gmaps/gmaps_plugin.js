var gmaps={
    title:"Google Maps Shortcode",
    id :'oscitas-form-gmaps',
    pluginName: 'gmaps',
    showprobtn: false
};
(function() {
    _create_tinyMCE_options(gmaps);
})();

function ebs_return_html_gmaps(pluginObj){
    var form = jQuery('<div id="'+pluginObj.id+'" class="oscitas-container" title="'+pluginObj.title+'"><table id="oscitas-table" class="form-table">\
			 <tr>\
        <th class="aligncenter"><img src="'+ebs_url+'shortcode/gmaps/screenshot.jpg" /></th>\
        </tr>\
		</table>\
		</div>');
    return form;
}


function create_oscitas_gmaps(pluginObj){
}