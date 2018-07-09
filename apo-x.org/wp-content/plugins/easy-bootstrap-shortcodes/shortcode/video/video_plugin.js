var video={
    title:"Video Shortcode",
    id :'oscitas-form-video',
    pluginName: 'video',
    showprobtn: false
};
(function() {
    _create_tinyMCE_options(video);
})();

function ebs_return_html_video(pluginObj){
    var form = jQuery('<div id="'+pluginObj.id+'" class="oscitas-container" title="'+pluginObj.title+'"><table id="oscitas-table" class="form-table">\
			 <tr>\
        <th class="aligncenter"><img src="'+ebs_url+'shortcode/video/screenshot.jpg" /></th>\
        </tr>\
		</table>\
		</div>');
    return form;
}


function create_oscitas_video(pluginObj){
}