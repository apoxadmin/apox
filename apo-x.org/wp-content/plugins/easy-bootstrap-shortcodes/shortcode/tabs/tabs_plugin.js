var tabs={
    title:"Tabs Shortcode",
    id :'oscitas-form-osctabs',
    pluginName: 'tabs',
    showprobtn: false
};
(function() {
    _create_tinyMCE_options(tabs);
})();

function ebs_return_html_tabs(pluginObj){
    var form = jQuery('<div id="'+pluginObj.id+'" class="oscitas-container" title="'+pluginObj.title+'">\
		<p class="submit">\
			<input type="button" id="oscitas-oscitastoggles-submit" class="button-primary" value="'+ebsjstrans.insert+' '+ebsjstrans.tab+'" name="submit" />\
		</p><br/>\
    <table id="oscitas-table" class="form-table">\
			 <tr>\
        <th class="aligncenter"><img src="'+ebs_url+'shortcode/tabs/screenshot.jpg" /></th>\
        </tr>\
		</table>\
		</div>');
    return form;
}


function create_oscitas_tabs(pluginObj){

    var form = jQuery(pluginObj.hashId);

    var table = form.find('table');

    //ebs_color_picker(form.find('.color'));

    // handles the click event of the submit button
    form.find('#oscitas-oscitastoggles-submit').click(function(){
        var shortcode = '['+$ebs_prefix+'tabs class="yourcustomclass"]<br/>['+$ebs_prefix+'tab title="'+ebsjstrans.tabnum+' 1" active="active"]'+ebsjstrans.tab+' 1 '+ebsjstrans.content+' '+ebsjstrans.goes+' '+ebsjstrans.here+'.[/'+$ebs_prefix+'tab]<br/>['+$ebs_prefix+'tab title="'+ebsjstrans.tabnum+' 2"]'+ebsjstrans.tab+' 2 '+ebsjstrans.content+' '+ebsjstrans.goes+' '+ebsjstrans.here+'.[/'+$ebs_prefix+'tab]<br/>['+$ebs_prefix+'tab title="'+ebsjstrans.tabnum+' 3"]'+ebsjstrans.tab+' 3 '+ebsjstrans.content+' '+ebsjstrans.goes+' '+ebsjstrans.here+'.[/'+$ebs_prefix+'tab]<br/>['+$ebs_prefix+'tab title="'+ebsjstrans.tabnum+' 4"]'+ebsjstrans.tab+' 4 '+ebsjstrans.content+' '+ebsjstrans.goes+' '+ebsjstrans.here+'.[/'+$ebs_prefix+'tab]<br/>[/'+$ebs_prefix+'tabs]';

        // inserts the shortcode into the active editor
        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

        // closes fancybox
        close_dialogue(pluginObj.hashId);
    });
}

//
//
//(function() {
//    tinymce.create('tinymce.plugins.oscitasTabs', {
//        init : function(ed, url) {
//            ed.addButton('oscitastabs', {
//                title : 'Tabs Shortcode',
//                image : url+'/icon.png',
//                onclick : function() {
//                    ed.selection.setContent('['+$ebs_prefix+'tabs class="yourcustomclass"]<br/>['+$ebs_prefix+'tab title="'+ebsjstrans.tabnum+' 1" active="active"]'+ebsjstrans.tab+' 1 '+ebsjstrans.content+' '+ebsjstrans.goes+' '+ebsjstrans.here+'.[/'+$ebs_prefix+'tab]<br/>['+$ebs_prefix+'tab title="'+ebsjstrans.tabnum+' 2"]'+ebsjstrans.tab+' 2 '+ebsjstrans.content+' '+ebsjstrans.goes+' '+ebsjstrans.here+'.[/'+$ebs_prefix+'tab]<br/>['+$ebs_prefix+'tab title="'+ebsjstrans.tabnum+' 3"]'+ebsjstrans.tab+' 3 '+ebsjstrans.content+' '+ebsjstrans.goes+' '+ebsjstrans.here+'.[/'+$ebs_prefix+'tab]<br/>['+$ebs_prefix+'tab title="'+ebsjstrans.tabnum+' 4"]'+ebsjstrans.tab+' 4 '+ebsjstrans.content+' '+ebsjstrans.goes+' '+ebsjstrans.here+'.[/'+$ebs_prefix+'tab]<br/>[/'+$ebs_prefix+'tabs]');
//                }
//            });
//        },
//        createControl : function(n, cm) {
//            return null;
//        },
//        getInfo : function() {
//            return {
//                longname : "Tabs Shortcode",
//                author : 'Oscitas Themes',
//                authorurl : 'http://www.oscitasthemes.com/',
//                infourl : 'http://www.oscitasthemes.com/',
//                version : "2.0.0"
//            };
//        }
//    });
//    tinymce.PluginManager.add('oscitastabs', tinymce.plugins.oscitasTabs);
//})();
