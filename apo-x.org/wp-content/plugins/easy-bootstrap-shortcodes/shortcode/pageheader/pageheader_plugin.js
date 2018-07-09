var pageheader={
    title:"Page Header Shortcode",
    id :'oscitas-form-pageheader',
    pluginName: 'pageheader',
    showprobtn: false
};
(function() {
    _create_tinyMCE_options(pageheader);
})();

function ebs_return_html_pageheader(pluginObj){
    var form = jQuery('<div id="'+pluginObj.id+'" class="oscitas-container" title="'+pluginObj.title+'"><table id="oscitas-table" class="form-table">\
			 <tr>\
        <th class="aligncenter"><img src="'+ebs_url+'shortcode/pageheader/screenshot.jpg" /></th>\
        </tr>\
		</table>\
		</div>');
    return form;
}


function create_oscitas_pageheader(pluginObj){
}