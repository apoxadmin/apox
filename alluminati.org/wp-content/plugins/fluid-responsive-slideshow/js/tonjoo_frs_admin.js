jQuery(document).ready(function($){
	if($('.widget-liquid-right').length > 0) $('.widget-liquid-right').accordion();

	$(".postbox-container  ").on('change','#tonjoo-frs-show_button select',function(){
		value = $(this).attr('value')

		if(value=='false'){			
			$(".button_attr").hide('slow');
			$("#tonjoo-frs-button_skin").hide('slow');
		}

		else{
			$(".button_attr").show('slow');
			$("#tonjoo-frs-button_skin").show('slow');
		}
	})

	$(".postbox-container  ").on('change','#tonjoo-frs-padding_type select',function(){
		value = $(this).attr('value')

		if(value=='auto'){			
			$("#textbox_padding").hide('slow');
		}
		else{
			$("#textbox_padding").show('slow');
		}
	})

	$(".postbox-container  ").on('change','#tonjoo-frs-is-fluid select',function(){
		value = $(this).attr('value')

		if(value=='true'){			
			$("#max_image_width").hide('slow');
		}
		else{
			$("#max_image_width").show('slow');
		}
	})

	$(".postbox-container ").on('change',' #tonjoo_show_navigation_arrow select',function(){
		value = $(this).attr('value')

		if(value=='true'){

			$(".tonjoo_nav_option").show('slow');
		}
		else{
			$(".tonjoo_nav_option").hide('slow');
		}
	})

	$(".postbox-container ").on('change','#tonjoo-frs-bg-textbox-type select',function(){
		value = $(this).attr('value')

		if(value=='picture'){			
			$("#tonjoo-frs-textbox-bg").show('slow');
			$("#textbox_color").hide('slow');
		}
		else if(value=='color'){
			$("#tonjoo-frs-textbox-bg").hide('slow');
			$("#textbox_color").show('slow');
		}
		else{
			$("#textbox_color").hide('slow');
			$("#tonjoo-frs-textbox-bg").hide('slow');
		}
	})

	// Preview Padding
	$(".postbox-container ").on('change','#tonjoo-frs-padding_type select',function(){
		preview_padding();
	});

	$(".postbox-container ").on('keyup','#frs_textbox_padding',function(){
		preview_padding();
	});

	function preview_padding()
	{
		var type = $('#tonjoo-frs-padding_type select').val();

		if(type == 'auto')
		{
			$('#frs-position-preview-padding-left').html('A');
			$('#frs-position-preview-padding-top').html('Automatic padding type');
			$('#frs-position-preview-padding-right').html('A');
			$('#frs-position-preview-padding-bottom').html('A');
		}
		else
		{
			var padding = $('#textbox_padding input').val();
			var arr_pad = padding.split('px ');

			// get rid last 'px'
			arr_pad[3] = arr_pad[3].slice(0,-2);

			$('#frs-position-preview-padding-left').html(arr_pad[0]);
			$('#frs-position-preview-padding-top').html(arr_pad[1]);
			$('#frs-position-preview-padding-right').html(arr_pad[2]);
			$('#frs-position-preview-padding-bottom').html(arr_pad[3]);
		}
	}


	// Preview Position	
	$(".postbox-container ").on('change','#tonjoo-frs-text_position select',function(){
		preview_position();
	});

	$(".postbox-container ").on('change','#tonjoo-frs-textbox_width select',function(){
		preview_position();
	});

	function preview_position(){
		var position = $('#tonjoo-frs-text_position select').val();
		var width = $('#tonjoo-frs-textbox_width select').val();

		position = position.substring(21);
		obj = $('#frs-position-preview-obj');

		obj.removeAttr('style');

		// width
		obj.css({
			"width": (470 * width / 12) + 'px'
		})

		// position
		switch (position)
		{
			case 'left': 
				obj.css({
					"margin-top": '65px'
				}).html('Text Box<br/><span>( Left )</span>')
			    break;
			case 'top-left': 
				obj.css({
					"margin-right": 'auto'
				}).html('Text Box<br/><span>( Top Left )</span>')
			    break;
			case 'top': 
				obj.css({
					"margin-left": 'auto',
					"margin-right": 'auto'
				}).html('Text Box<br/><span>( Top )</span>')
			    break;
			case 'top-right': 
				obj.css({
					"margin-left": 'auto'
				}).html('Text Box<br/><span>( Top Right )</span>')
			    break;
			case 'right': 
				obj.css({
					"margin-left": 'auto',
					"margin-top": '65px'
				}).html('Text Box<br/><span>( Right )</span>')
			    break;
			case 'bottom-right': 
				obj.css({
					"margin-left": 'auto',
					"margin-top": '135px'
				}).html('Text Box<br/><span>( Bottom Right )</span>')
			    break;
			case 'bottom': 
				obj.css({
					"margin-left": 'auto',
					"margin-right": 'auto',
					"margin-top": '135px'
				}).html('Text Box<br/><span>( Bottom )</span>')
			    break;
			case 'bottom-left': 
				obj.css({
					"margin-right": 'auto',
					"margin-top": '135px'
				}).html('Text Box<br/><span>( Bottom Left )</span>')
			    break;
			case 'center': 
				obj.css({
					"margin-left": 'auto',
					"margin-right": 'auto',
					"margin-top": '65px'
				}).html('Text Box<br/><span>( Center )</span>')
			    break;
			case 'sticky-top': 
				obj.css({
					"margin-left": '-41px',
					"margin-top": '-41px',
					"width": '510px'
				}).html('Text Box<br/><span>( Sticky Top )</span>')
			    break;
			case 'sticky-bottom': 
				obj.css({
					"margin-left": '-41px',
					"margin-top": '175px',
					"width": '510px'
				}).html('Text Box<br/><span>( Sticky Bottom )</span>')
			    break;
			default:  
				// no action
		}		
	}
	
	/**
	 * Slideshow submenu
	 */
	jQuery(document).ready( function($) {
		var category = $('table#table-slide tbody').attr('category');

		if($('table#table-slide tbody').length > 0) frs_resort_data_table();	    

	   	$('table#table-slide tbody , .frs-modal-container  ').on('click','[frs-delete-slide]',function(){
	   		
	   		deleteConfirmation = confirm("Are you sure to delete the slide ? ");	

	   		button = jQuery(this)	

	   		post_id = button.data('post-id')

	   		if(deleteConfirmation){
	   			 ajax_button_spin(button)
	   			 data = {
		   			action:'frs_delete',
		   			post_id:button.data('post-id')
		   		}

	   			jQuery.post(ajaxurl, data,function(response){
	   				if(response.success)
	   				{
	   					jQuery('.frs-modal-backdrop').removeClass('active');
						jQuery('.frs-modal-container .frs-table-left').html('');	
						jQuery('.frs-modal-container').hide();	

	   		 			jQuery('#list_item_'+post_id).hide('3000', function(){ 
	   		 				jQuery('#list_item_'+post_id).remove() 
	   		 				frs_check_table_size()
	   		 			});
	   		 			ajax_button_spin_stop(button)
	   		 			frs_notice_updated()
	   				}
	   				else{
	   					frs_notice_error_updated()
	   				}
	   			})
	   		}else{
	   			ajax_button_spin_stop(button)
	   		}	  
	   	})

		// add slide category
		$('[frs-add-slide-type]').click(function(){
			var string = prompt("Enter the category name", "");
			
			if (string != null) 
			{
				data = {
		   			action:'frs_add_slidetype',
		   			name: string
		   		}

	   			jQuery.post(ajaxurl, data,function(response){	   				
	   				if(response.success) {	   	
	   					window.location.href = admin_url + '&tab=' + response.slug + '&tabtype=slide';
	   				}
	   			});
			}
   		});

   		// select all input text on click
		$('[frs-input-shortcode]').click(function(){
			$(this).select();
   		});

   		// create first slideshow
		$('#frs-first-add-slideshow').click(function(){
			var string = $('#frs-first-slideshow-input').val();

			if (string != null && string != '')
			{
				// do loading
				$(this)
					.html('Loading...')
					.attr('id','its-loaded');

				// ajax
				data = {
		   			action:'frs_add_slidetype',
		   			name: string
		   		}

	   			jQuery.post(ajaxurl, data,function(response){	   				
	   				if(response.success) {	   	
	   					window.location.href = admin_url + '&tab=' + response.slug + '&tabtype=slide';
	   				}
	   			});
			}
			else
			{
				alert("Please enter your new slideshow name");
			}
   		});

   		// delete slide category
		$('[frs-delete-slide-type]').click(function(){
			var x = confirm("Are you sure want to delete this slideshow?");
			
			if (x == true) 
			{
				data = {
		   			action:'frs_delete_slidetype',
		   			id: $(this).attr('id')
		   		}

	   			jQuery.post(ajaxurl, data,function(response){	   				
	   				if(response.success) {	   	
	   					window.location.href = admin_url + '&settings-updated=true';
	   				}
	   			});
			}
   		});

   		jQuery('.frs-modal-container').on('click','[frs-modal-close-modal]',function(){
			jQuery('.frs-modal-backdrop').removeClass('active');
			jQuery('.frs-modal-cat-container').hide();	
			jQuery('.spinner').removeClass('active')

		})

   		// add slide
	   	$('[frs-add-slide]').click(function(){
			add_slide();
	   	});

	   	if(get_other == 'add-new-intro')
	   	{
	   		add_slide();

	   		// alert('xxx');

	   		// introJs().goToStep(8).start();

	   		window.setTimeout(function(){
	   			introJs()
		   		.setOption('tooltipPosition', 'auto')
		   		.setOption('positionPrecedence', ['left', 'right', 'bottom', 'top'])
		   		.goToStep(8)
		   		.start();
	   		},1000);	   		
	   	}

	   	function add_slide()
	   	{
	   		button = $('[frs-add-slide]');

			ajax_button_spin(button)

   			data = {
	   			action:'frs_show_modal',
	   			post_id: 'false'
	   		}

   			jQuery.post(ajaxurl, data,function(response){	   				
   				if(response.success){	   					

   					decoded = $("<div/>").html(response.modal).text();

   		 			jQuery('.frs-modal-container .frs-table-left').html(decoded)

   		 			/* set right content value */
   		 			var frs_id = response.id
   		 			var frs_title = response.title
   		 			var img_default = response.img_default
   		 			var post_thumbnail_id = response.post_thumbnail_id

   		 			jQuery('#frs-tonjoo-modal .floating-modal-button .button-primary').data('post-id',frs_id);
   		 			
   		 			jQuery('#frs-tonjoo-modal .floating-modal-button .button-danger').data('post-id',frs_id);
   		 			
   		 			jQuery('#frs-tonjoo-modal input#frs-title').val(frs_title);

   		 			jQuery('#frs-tonjoo-modal [media-upload-image]').attr('src',response.scr);
   		 			
   		 			jQuery('#frs-tonjoo-modal [media-upload-id]').attr('value',post_thumbnail_id);
   		 			
   		 			jQuery('#frs-tonjoo-modal [frs-remove-image]').attr('data-image-default',img_default);

   		 			jQuery('#frs-tonjoo-modal .floating-modal-button .button-danger').hide();

   		 			if(typeof tinyMCE != 'undefined' && tinyMCE.get('frs-modal-content'))
   		 				tinyMCE.get('frs-modal-content').setContent(response.content)
   		 			else
   		 				jQuery('#frs-modal-content').val('')

   		 			/* set active */
   		 			jQuery('.frs-modal-backdrop').addClass('active')
   		 			jQuery('.frs-modal-container').show().addClass('active')

   		 			preview_position();
   		 			preview_padding();

   		 			ajax_button_spin_stop(button)
   				}
   			})	   
	   	}


		// edit slide
	    $('table#table-slide tbody ').on('click','[frs-edit-slide]',function(){

			button = jQuery(this)	

			ajax_button_spin(button)

   			data = {
	   			action:'frs_show_modal',
	   			post_id:button.data('post-id')
	   		}

   			jQuery.post(ajaxurl, data,function(response){	   				

   				if(response.success){	   					

   					ajax_button_spin_stop(button)

   					decoded = $("<div/>").html(response.modal).text();

   		 			jQuery('.frs-modal-container .frs-table-left').html(decoded)

   		 			/* set right content value */
   		 			var frs_id = response.id
   		 			var frs_title = response.title
   		 			var img_default = response.img_default
   		 			var post_thumbnail_id = response.post_thumbnail_id

   		 			jQuery('#frs-tonjoo-modal .floating-modal-button .button-primary').data('post-id',frs_id);
   		 			
   		 			jQuery('#frs-tonjoo-modal .floating-modal-button .button-danger').data('post-id',frs_id);
   		 			
   		 			jQuery('#frs-tonjoo-modal input#frs-title').val(frs_title);

   		 			jQuery('#frs-tonjoo-modal [media-upload-image]').attr('src',response.scr);
   		 			
   		 			jQuery('#frs-tonjoo-modal [media-upload-id]').attr('value',post_thumbnail_id);
   		 			
   		 			jQuery('#frs-tonjoo-modal [frs-remove-image]').attr('data-image-default',img_default);

   		 			jQuery('#frs-tonjoo-modal .floating-modal-button .button-danger').show();

   		 			/* set active */
   		 			jQuery('.frs-modal-backdrop').addClass('active')

   		 			jQuery('.frs-modal-container').show().addClass('active')

			 		if(typeof tinyMCE != 'undefined' && tinyMCE.get('frs-modal-content'))
			   	 		tinyMCE.get('frs-modal-content').setContent(response.content)
				    else
				    	jQuery('#frs-modal-content').val(response.content);

					preview_position();		
					preview_padding();		    

   		 			frs_check_table_size()
   				}
   			})
	   	})

	});

	jQuery('.frs-modal-backdrop').click(function(){
		jQuery(this).removeClass('active');
		jQuery('.frs-modal-container .frs-table-left').html('');
		jQuery('.frs-modal-container').hide();	
		jQuery('.spinner').removeClass('active')
		frs_check_table_size()
	})
	
	jQuery('.frs-modal-container').on('click','[frs-modal-close-modal]',function(){
		jQuery('.frs-modal-backdrop').removeClass('active');		
		jQuery('.frs-modal-container .frs-table-left').html('');
		jQuery('.frs-modal-container').hide();
		jQuery('.spinner').removeClass('active')

	})

	

	/**
	 * Save 
	 */

	jQuery('.frs-modal-container').on('click','[frs-save-slider]',function(){


	 	if(jQuery('#frs-modal-form #frs-title').val() == "")
	 	{
	 		
	 		alert("Please fill the slider title");

	 		post_id = jQuery(this).data('post-id')
	 		
	 	}
	 	else
	 	{
	 		button = jQuery(this)

	 		ajax_button_spin(button)

	 		if(typeof tinyMCE != 'undefined' && tinyMCE.get('frs-modal-content')){
       	 		content =  tinyMCE.get('frs-modal-content').getContent()
		    }else{
		        content =  jQuery('#frs-modal-content').val();
		    }

			post_id = jQuery('[frs-save-slider]').data('post-id')

			var data =  jQuery('#frs-modal-form').serialize() + '&action=frs_save&content=' + content +"&post_id="+post_id+"&slide_type="+current_frs_slide_type;

			jQuery.post(ajaxurl, data,function(response){	   				
				if(response.success){	   					
					//insert row ke table, jquery sortable diulangi)

					// 
					var data = 'action=frs_render_row&post_id=' + response.id

					replace_id = response.id

					jQuery.post(ajaxurl, data,function(response){
						if(response.success){

							decoded = $("<div/>").html(response.row).text();

							// edit data / replace row
							if(!isNaN(post_id)){
								$("#list_item_"+replace_id ).replaceWith(decoded );
							}
							else{
								//New data , add row
								if(jQuery('#table-slide tr:last').length){
									jQuery('#table-slide tr:last').after(decoded)
								}
								else
									jQuery('#table-slide tbody').html(decoded)

								//re sort jquery table
								frs_resort_data_table()
							}
							frs_check_table_size()
							jQuery('.frs-modal-backdrop').removeClass('active');
							jQuery('.frs-modal-container .frs-table-left').html('');	
							jQuery('.frs-modal-container').hide();	

							ajax_button_spin_stop(button)

							frs_notice_updated()
						}
						else{
							frs_notice_error_updated()
						}
					})	   	

				}
			})
	 	}		
	})


	/*
	 * Media Uploader
	 */

	var custom_uploader
    var media_button
    
    $('.postbox-container').on('click','[mediauploadbutton]',function(e) {

        media_button = $(this)


 
        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }

        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            jQuery('[frs-mediauploader]').find('[media-upload-id]').val(attachment.id);

            thumbnail = attachment.url
            
            jQuery('[frs-mediauploader]').find('[media-upload-image]').attr('src',thumbnail);

        });
 
        //Open the uploader dialog
        custom_uploader.open();
 
    });

	jQuery('.postbox-container').on('click','[frs-remove-image]',function(){

		jQuery('[media-upload-id]').val('');

		jQuery('[media-upload-image]').attr('src',jQuery(this).data('image-default'));
	})	
})

function startTour() {
	var tour = introJs();

	tour.setOption('tooltipPosition', 'auto');
	tour.setOption('positionPrecedence', ['left', 'right', 'bottom', 'top']);

	// go to the next page
	// tour.setOption('doneLabel', 'Next page').oncomplete(function() {
 	// 		window.location.href = '?page=frs-setting-page&tab=a-first-one&tabtype=slide&other=add-new-intro';
 	// });

	tour.start();
}

function frs_check_table_size(){
	if(jQuery("table#table-slide tr").size()==0){
		jQuery('.no-slide').removeClass('hide')
	}
	else{
		jQuery('.no-slide').addClass('hide')
	}
}

function frs_resort_data_table(){

 	jQuery('table#table-slide tbody').sortable({
	    items: '.list_item',
	    opacity: 0.5,
	    cursor: 'pointer',
	    axis: 'y',
	    update: function() {
	        var ordr = jQuery(this).sortable('serialize') + '&action=frs_list_update_order';

	        jQuery.post(ajaxurl, ordr, function(response){
	           frs_notice_updated() 
	        });
	    },
	    helper: function(e, tr){
		    
		    var originals = tr.children();
		    var helper = tr.clone();
		    helper.children().each(function(index)
		    {
		      // Set helper cell sizes to match the original sizes
		      jQuery(this).width(originals.eq(index).width());
		
		    });
		    
		    return helper;
		}
	});
}

function ajax_button_spin(button){
	if(button.next('.spinner').size()!=0)
		button.next('.spinner').addClass('active')
	else
		button.siblings('.spinner').addClass('active')
}

function ajax_button_spin_stop(button){
	if(button.next('.spinner').size()!=0)
		button.next('.spinner').removeClass('active')
	else
		button.siblings('.spinner').removeClass('active')
}

function frs_notice_updated() {
	jQuery('.frs-notice-wrapper').addClass('active');
	jQuery('.frs-updated').hide();
	jQuery('.frs-updated').stop().show('slow');
}

function frs_notice_error_updated() {	
	jQuery('.frs-notice-wrapper').addClass('active');
	jQuery('.frs-updated-error').hide()
	jQuery('.frs-updated-error').stop().show('slow')
}