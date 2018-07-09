var toggles={
    title:"Toggle/Accordion Shortcode",
    id :'oscitas-form-oscitasToggles',
    pluginName: 'toggles',
    showprobtn: false
};
(function() {
    _create_tinyMCE_options(toggles);
})();

function ebs_return_html_toggles(pluginObj){
    var form = jQuery('<div id="'+pluginObj.id+'" class="oscitas-container" title="'+pluginObj.title+'">\
		<p class="submit">\
			<input type="button" id="oscitas-oscitastoggles-submit" class="button-primary" value="'+ebsjstrans.insert+' '+ebsjstrans.toggle+'" name="submit" />\
		</p><br/><table id="oscitas-table" class="form-table">\
			 <tr>\
        <th class="aligncenter"><img src="'+ebs_url+'shortcode/toggles/screenshot.jpg" /></th>\
        </tr>\
		</table>\
		</div>');
    return form;
}

function create_oscitas_toggles(pluginObj){

    var form = jQuery(pluginObj.hashId);

    var table = form.find('table');

    //ebs_color_picker(form.find('.color'));

    // handles the click event of the submit button
    form.find('#oscitas-oscitastoggles-submit').click(function(){
        var shortcode = '['+$ebs_prefix+'toggles class="yourcustomclass"]<br/>['+$ebs_prefix+'toggle title="'+ebsjstrans.accordionnumber+' 1" class="in"]'+ebsjstrans.toggle+' 1 '+ebsjstrans.content+' '+ebsjstrans.goes+' '+ebsjstrans.here+'.[/'+$ebs_prefix+'toggle]<br/>['+$ebs_prefix+'toggle title="'+ebsjstrans.accordionnumber+' 2"]'+ebsjstrans.toggle+' 2 '+ebsjstrans.content+' '+ebsjstrans.goes+' '+ebsjstrans.here+'.[/'+$ebs_prefix+'toggle]<br/>['+$ebs_prefix+'toggle title="'+ebsjstrans.accordionnumber+' 3"]'+ebsjstrans.toggle+' 3 '+ebsjstrans.content+' '+ebsjstrans.goes+' '+ebsjstrans.here+'.[/'+$ebs_prefix+'toggle]<br/>['+$ebs_prefix+'toggle title="'+ebsjstrans.accordionnumber+' 4"]'+ebsjstrans.toggle+' 4 '+ebsjstrans.content+' '+ebsjstrans.goes+' '+ebsjstrans.here+'.[/'+$ebs_prefix+'toggle]<br/>[/'+$ebs_prefix+'toggles]';

        // inserts the shortcode into the active editor
        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

        // closes fancybox
        close_dialogue(pluginObj.hashId);
    });
}



//
//
//
//(function() {
//    tinymce.create('tinymce.plugins.oscitasToggles', {
//        init : function(ed, url) {
//            ed.addButton('oscitastoggles', {
//                title : 'Toggle/Accordion Shortcode',
//                image : url+'/icon.png',
//                onclick : function() {
//                    ed.selection.setContent('['+$ebs_prefix+'toggles class="yourcustomclass"]<br/>['+$ebs_prefix+'toggle title="'+ebsjstrans.accordionnumber+' 1" class="in"]'+ebsjstrans.toggle+' 1 '+ebsjstrans.content+' '+ebsjstrans.goes+' '+ebsjstrans.here+'.[/'+$ebs_prefix+'toggle]<br/>['+$ebs_prefix+'toggle title="'+ebsjstrans.accordionnumber+' 2"]'+ebsjstrans.toggle+' 2 '+ebsjstrans.content+' '+ebsjstrans.goes+' '+ebsjstrans.here+'.[/'+$ebs_prefix+'toggle]<br/>['+$ebs_prefix+'toggle title="'+ebsjstrans.accordionnumber+' 3"]'+ebsjstrans.toggle+' 3 '+ebsjstrans.content+' '+ebsjstrans.goes+' '+ebsjstrans.here+'.[/'+$ebs_prefix+'toggle]<br/>['+$ebs_prefix+'toggle title="'+ebsjstrans.accordionnumber+' 4"]'+ebsjstrans.toggle+' 4 '+ebsjstrans.content+' '+ebsjstrans.goes+' '+ebsjstrans.here+'.[/'+$ebs_prefix+'toggle]<br/>[/'+$ebs_prefix+'toggles]');
//                }
//            });
//        },
//        createControl : function(n, cm) {
//            return null;
//        },
//        getInfo : function() {
//            return {
//                longname : "Toggle Shortcode",
//                author : 'Oscitas Themes',
//                authorurl : 'http://www.oscitasthemes.com/',
//                infourl : 'http://www.oscitasthemes.com/',
//                version : "2.0.0"
//            };
//        }
//    });
//    tinymce.PluginManager.add('oscitastoggles', tinymce.plugins.oscitasToggles);
//})();
