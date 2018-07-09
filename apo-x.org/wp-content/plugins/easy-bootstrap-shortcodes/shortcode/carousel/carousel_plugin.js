var carousel={
    title:"Carousel Shortcode",
    id :'oscitas-form-carousel',
    pluginName: 'carousel',
    showprobtn: false
};
(function() {
    _create_tinyMCE_options(carousel);
})();

function ebs_return_html_carousel(pluginObj){
    var form = jQuery('<div id="'+pluginObj.id+'" class="oscitas-container" title="'+pluginObj.title+'"><table id="oscitas-table" class="form-table">\
			 <tr>\
        <th class="aligncenter"><img src="'+ebs_url+'shortcode/carousel/screenshot.jpg" /></th>\
        </tr>\
		</table>\
		</div>');
    return form;
}


function create_oscitas_carousel(pluginObj){
}