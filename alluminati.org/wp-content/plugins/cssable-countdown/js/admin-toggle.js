(function($) { // hide scope, no $ conflict
$(document).ready(function() {
	$('.ccw_toggle-option h4').live('click', 'a', function(event) {
		event.preventDefault(); // prevent jumping to the top
		$(this).siblings('.ccw_toggled').toggle();
  	});
});
})(jQuery);

/*
	$(selector).live(events, data, handler);                // jQuery 1.3+
	$(document).delegate(selector, events, data, handler);  // jQuery 1.4.3+
	$(document).on(events, selector, data, handler);        // jQuery 1.7+
*/