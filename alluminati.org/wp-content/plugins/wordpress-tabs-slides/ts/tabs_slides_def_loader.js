/*
// JoomlaWorks "Tabs & Slides" Plugin for Joomla! 1.5.x - Version 2.4
// License: http://www.gnu.org/copyleft/gpl.html
// Copyright (c) 2006 - 2008 JoomlaWorks, a Komrade LLC company.
// More info at http://www.joomlaworks.gr
// Developers: Fotis Evangelou
// ***Last update: May 20th, 2008***
*/

// Default Loader
function init_jwTS() {
    if (arguments.callee.done) return;
    arguments.callee.done = true;
	//initShowHideDivs();
	tabberAutomatic(tabberOptions);
	//showHideContent(false,1);});	// Automatically expand first item - disabled by default
};
// DOM2
if ( typeof window.addEventListener != "undefined" ) {
	window.addEventListener( "load", init_jwTS, false );
// IE 
} else if ( typeof window.attachEvent != "undefined" ) {
	window.attachEvent( "onload", init_jwTS );
} else {
	if ( window.onload != null ) {
		var oldOnload = window.onload;
		window.onload = function ( e ) {
			oldOnload( e );
			init_jwTS();
		};
	} else {
		window.onload = init_jwTS;
	}
}