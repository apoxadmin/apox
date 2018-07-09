var animation={
    title:"Animation Shortcode",
    id :'oscitas-form-animation',
    pluginName: 'animation',
    showprobtn: false
};
(function() {
    _create_tinyMCE_options(animation);
})();

function ebs_return_html_animation(pluginObj){
    var form = jQuery('<div id="'+pluginObj.id+'" class="oscitas-container" title="'+pluginObj.title+'"><table id="oscitas-table" class="form-table">\
			 <tr>\
        <th class="aligncenter"><img src="'+ebs_url+'shortcode/animation/screenshot.jpg"/></th>\
        </tr>\
		</table>\
		</div>');
    return form;
}


function create_oscitas_animation(pluginObj){
}