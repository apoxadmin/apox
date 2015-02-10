var farbtastic;

function pickColor(color, colorField) {
	farbtastic.setColor(color);
	jQuery(colorField).val(color);	
}

jQuery(document).ready(function() {

	var i =1,
		divString = '<div/>';
		
	jQuery('.pickcolor').each(function (){
		
		var	divPicker = jQuery(divString).attr('id','colorPickerDiv' + i).addClass('colorPickerDiv'),
			colorField = jQuery(this);
		
		colorField.click(function() {
			jQuery(this).after(divPicker);
			jQuery(divPicker).show();
			farbtastic = jQuery.farbtastic(divPicker, function(color) {
				pickColor(color, colorField);
			});
			pickColor(colorField.val(), colorField);
			
		});
		i++;
	});
	jQuery(document).mousedown(function(){
		jQuery('.colorPickerDiv').each(function(){
			var display = jQuery(this).css('display');
			if ( display == 'block' )
				jQuery(this).fadeOut(2);
		});
	});
});
