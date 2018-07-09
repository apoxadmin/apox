var testimonial={
    title:"Testimonial Shortcode",
    id :'oscitas-form-testimonial',
    pluginName: 'testimonial',
    showprobtn: false
};
(function() {
    _create_tinyMCE_options(testimonial);
})();

function ebs_return_html_testimonial(pluginObj){
    var form = jQuery('<div id="'+pluginObj.id+'" class="oscitas-container" title="'+pluginObj.title+'"><table id="oscitas-table" class="form-table">\
			 <tr>\
        <th class="aligncenter"><img src="'+ebs_url+'shortcode/testimonial/screenshot.jpg" /></th>\
        </tr>\
		</table>\
		</div>');
    return form;
}


function create_oscitas_testimonial(pluginObj){
}