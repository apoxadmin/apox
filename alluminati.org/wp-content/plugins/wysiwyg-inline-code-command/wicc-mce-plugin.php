<?php
/*
    Copyright 2011, 2012 Peter Williams (email: peter@newton.cx)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
header('Content-type: application/x-javascript');
/* Start wicc-mce-plugin.js */
?>
(function () {
    tinymce.create('tinymce.plugins.WICCPlugin', {
	init: function(ed, url) {
	    ed.addCommand('mceWICC', function() {
		ed.formatter.toggle ('inlinecode');
	    });

	    ed.addButton('wicc', {title: 'Inline Code (Alt-Shift-C)', 
				 cmd: 'mceWICC',
				 image: url + '/wicc-button.png'});

	    ed.addShortcut ('alt+shift+c', 'Inline Code', 'mceWICC');

	    ed.onInit.add (function () {
		ed.formatter.register ('inlinecode', {inline: 'code', remove: 'all'});
	    });
	},

	getInfo: function() {
	    return {
	        longname : 'WYSIWYG Inline Code Command',
		author : 'Peter Williams',
		authorurl : 'http://newton.cx/~peter/',
		infourl : 'http://wordpress.org/extend/plugins/wysiwyg-inline-code-command/',
		version : tinymce.majorVersion + "." + tinymce.minorVersion
	    };
	}
    });

    tinymce.PluginManager.add('wicc', tinymce.plugins.WICCPlugin);
})();
<?php /* End wicc-mce-plugin.js */ ?>