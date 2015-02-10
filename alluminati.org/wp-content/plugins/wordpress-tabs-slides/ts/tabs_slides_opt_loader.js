/*
// JoomlaWorks "Tabs & Slides" Plugin for Joomla! 1.5.x - Version 2.4
// License: http://www.gnu.org/copyleft/gpl.html
// Copyright (c) 2006 - 2008 JoomlaWorks, a Komrade LLC company.
// More info at http://www.joomlaworks.gr
// Developers: Fotis Evangelou
// ***Last update: May 20th, 2008***
*/

// DOM Loader
var DomLoaded =
{
	onload: [],
	loaded: function()
	{
		if (arguments.callee.done) return;
		arguments.callee.done = true;
		for (i = 0;i < DomLoaded.onload.length;i++) {
			
			if(DomLoaded.onload[i] != undefined){
				DomLoaded.onload[i]();
			}
		}
	},
	load: function(fireThis)
	{
		this.onload.push(fireThis);
		if (document.addEventListener) 
			document.addEventListener("DOMContentLoaded", DomLoaded.loaded, null);
		if (/KHTML|WebKit/i.test(navigator.userAgent))
		{ 
			var _timer = setInterval(function()
			{
				if (/loaded|complete/.test(document.readyState))
				{
					clearInterval(_timer);
					delete _timer;
					DomLoaded.loaded();
				}
			}, 10);
		}
		/*@cc_on @*/
		/*@if (@_win32)
		var proto = "src='javascript:void(0)'";
		if (location.protocol == "https:") proto = "src=//0";
		document.write("<scr"+"ipt id=__ie_onload defer " + proto + "><\/scr"+"ipt>");
		var script = document.getElementById("__ie_onload");
		script.onreadystatechange = function() {
		    if (this.readyState == "complete") {
		        DomLoaded.loaded();
		    }
		};
		/*@end @*/
		
		DomLoaded.addLoadEvent(DomLoaded.loaded);
	},
	addLoadEvent: function(func)
	{
		// Source http://simonwillison.net/2004/May/26/addLoadEvent/
		  var oldonload = window.onload;
		  if (typeof window.onload != 'function') {
		    window.onload = func;
		  } else {
		    window.onload = function() {
		      if (oldonload) {
		        oldonload();
		      }
		      func();
		    }
		  }
		
	}
};

// Load everything up!
DomLoaded.load(function() {
	tabberAutomatic(tabberOptions);	// Load the tabs
	//initShowHideDivs();				// Load the slides
	//showHideContent(false,1);//});	// Automatically expand first item - disabled by default
});