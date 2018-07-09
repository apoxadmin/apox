var boxesframes={
    title:"Boxframe Shortcode",
    id :'oscitas-form-boxesframes',
    pluginName: 'boxesframes',
    showprobtn: false
};
(function() {
    _create_tinyMCE_options(boxesframes);
})();

function ebs_return_html_boxesframes(pluginObj){
    var form = jQuery('<div id="'+pluginObj.id+'" class="oscitas-container" title="'+pluginObj.title+'"><table id="oscitas-table" class="form-table">\
			 <tr>\
        <th class="aligncenter"><img src="'+ebs_url+'shortcode/boxesframes/screenshot.jpg"/></th>\
        </tr>\
		</table>\
		</div>');
    return form;
}


function create_oscitas_boxesframes(pluginObj){
}