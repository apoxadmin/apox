jQuery(document).ready(function() {
	
	/* Tabs in welcome page */
	function parallel_welcome_page_tabs(event) {
		jQuery(event).parent().addClass("nav-tab-active");
        jQuery(event).parent().siblings().removeClass("nav-tab-active");
        var tab = jQuery(event).attr("href");
        jQuery(".parallel-tab-pane").not(tab).css("display", "none");
        jQuery(tab).fadeIn();
	}
	
	var parallel_actions_anchor = location.hash;
	
	if( (typeof parallel_actions_anchor !== 'undefined') && (parallel_actions_anchor != '') ) {
		parallel_welcome_page_tabs('a[href="'+ parallel_actions_anchor +'"]');
	}
	
    jQuery(".nav-tab-wrapper a").click(function(event) {
        event.preventDefault();
		parallel_welcome_page_tabs(this);
    });

});