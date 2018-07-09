var pricingtable={
    title:"Pricing Table Shortcode",
    id :'oscitas-form-pricingtable',
    pluginName: 'pricingtable',
    showprobtn: false
};
(function() {
    _create_tinyMCE_options(pricingtable);
})();

function ebs_return_html_pricingtable(pluginObj){
    var form = jQuery('<div id="'+pluginObj.id+'" class="oscitas-container" title="'+pluginObj.title+'"><table id="oscitas-table" class="form-table">\
			 <tr>\
        <th class="aligncenter"><img src="'+ebs_url+'shortcode/pricingtable/screenshot.jpg" /></th>\
        </tr>\
		</table>\
		</div>');
    return form;
}


function create_oscitas_pricingtable(pluginObj){
}