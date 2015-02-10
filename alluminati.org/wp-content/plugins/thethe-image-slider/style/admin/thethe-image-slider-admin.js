jQuery(document).ready(function() {
	var fileInput = '';
	var oImg = '';

	jQuery('.thethe-upload-image, .thethe-upload-imageup').live('click',
	function() {
		fileInput = jQuery('.thethe-upload-image');
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		return false;
	});

	// user inserts file into post. only run custom if user started process using the above process
	// window.send_to_editor(html) is how wp would normally handle the received data

	window.original_send_to_editor = window.send_to_editor;
	window.send_to_editor = function(html) {
		if (fileInput) {
			fileurl = jQuery('img', html).attr('src');
			if (!fileurl) {
				fileurl = jQuery(html).attr('src');
			}
			jQuery(fileInput).val(fileurl);

			tb_remove();
			rebuildPreview();

		} else {
			window.original_send_to_editor(html);
		}
	};
	jQuery('#add_slider').click(function() {
		oSlider = jQuery('#slider_copy').clone(true);
		jQuery(':input', oSlider).each(function() {
			jQuery(this).val('');
		});
		oSlider.appendTo(jQuery('#sliders_holder'))
	});

	jQuery('.thethe-slider-help').bind('mouseover mouseout',
	function() {
		if (jQuery(this).attr('class') == 'thethe-slider-help') {
			jQuery(this).addClass('thethe-slider-showhelp');
			jQuery('.thethe-slider-innerhelp', this).css({
				'opacity': 0
			});
			jQuery('.thethe-slider-innerhelp', this).animate({
				'opacity': 1
			},
			300);
			if (jQuery('.thethe-slider-innerhelp', this).width() < 100) {
				jQuery('.thethe-slider-innerhelp', this).css({
					'marginLeft': '-225px',
					'width': '200px'
				})
			}

		} else {
			jQuery(this).removeClass('thethe-slider-showhelp');
		}
	});

	jQuery('.thethe-slide-view-slides').bind('click',
	function() {
		nID = jQuery(this).attr('id');
		oTR = jQuery('#' + nID + 'slides');
		if (oTR.attr('class') == 'thethe-slider-hidden') {
			oTR.removeClass('thethe-slider-hidden');
			oTR.addClass('thethe-slider-show');
		} else {
			oTR.removeClass('thethe-slider-show');
			oTR.addClass('thethe-slider-hidden');
		}
		return false;
	});

	function set_del_buttons() {
		jQuery('.thethe-slider-delete-slide').each(function() {
			jQuery(this).bind('click',
			function() {
				sName = jQuery(this).attr('title').replace('Delete ', '');
				if (confirm('Are you sure you want to delete "' + sName + '" slide permanently?')) {

					nTRID = jQuery(this).attr('id').replace('delete', '');
					jQuery('#' + nTRID).remove();

					nFormID = jQuery(this).attr('id').replace(/deleteslide[0-9]+/, '');
					jQuery('#' + nFormID).ajaxSubmit({
						'data': {
							'ajax': true,
							'submit': 'Yes'
						},
						'target': '#' + nFormID + '-holder',
						'success': set_del_buttons
					});
					return false;
				}
				return false;
			})
		})
	};

	jQuery('.thethe-slider-minheighter').sortable({
		axis: 'y',
		handle: '.hndle',
		items: '.thethe-slide',
		cursor: 'crosshair',
		update: function() {
			nFormID = jQuery(this).attr('id').replace('-holder', '');
			jQuery('#' + nFormID).ajaxSubmit({
				'data': {
					'ajax': true,
					'submit': 'Yes'
				},
				'target': '#' + nFormID + '-holder',
				'success': set_del_buttons
			});
		}
	});

	if (jQuery('#thethe-slider-stylepreview').attr('id')) {
		strImage = (jQuery('#thethe-slider-stylepreview').css('backgroundImage')).replace('url("', '').replace('images/blank.gif")', '');
		jQuery('#thethe-slider-style').bind('change',
		function() {
			bgImg = jQuery(this).val() == 'none' ? 'none': 'url(' + strImage + 'skins/' + jQuery(this).val() + '/buttons.png)';
			jQuery('#thethe-slider-stylepreview').css({
				'backgroundImage': bgImg
			})
		});
		bgImg = jQuery('#thethe-slider-style').val() == 'none' ? 'none': 'url(' + strImage + 'skins/' + jQuery('#thethe-slider-style').val() + '/buttons.png)';
		jQuery('#thethe-slider-stylepreview').css({
			'backgroundImage': bgImg
		})
	}

	jQuery('.thethe-slider-delete').each(function() {
		jQuery(this).bind('click',
		function() {
			sName = jQuery(this).attr('id').replace('delete-', '');
			if (confirm('Are you sure you want to delete "' + sName + '" slider permanently?')) {
				return true;
			}
			return false;
		})
	})

	set_del_buttons();
	function strip_tags(str, arrExclude) {
		for (i = 0; i < arrExclude.length; i++) {
			str = str.replace('<' + arrExclude[i] + '>', '[{' + arrExclude[i] + '}]');
			str = str.replace('</' + arrExclude[i] + '>', '[{/' + arrExclude[i] + '}]');
		}
		str = str.replace(/<\/?[^>]+>/gi, '');
		for (i = 0; i < arrExclude.length; i++) {
			str = str.replace('[{' + arrExclude[i] + '}]', '<' + arrExclude[i] + '>');
			str = str.replace('[{/' + arrExclude[i] + '}]', '</' + arrExclude[i] + '>');
		}
		return str;
	}

	rebuildPreview = function() {
		oForm = jQuery('#thethe-slider-slideform');
		strImagePath = jQuery('input[name|=image]').val();
		strName = jQuery('input[name|=title]').val();
		strUrl = jQuery('input[name|=url]').val();
		strText = jQuery('textarea[name|=text]').val();
		strCaptionPosition = jQuery('select[name|=caption_position]').val();
		strCaptionStyle = jQuery('select[name|=caption_style]').val();
		strCaptionBgColor = jQuery('input[name|=caption_bg_color]').val();
		strCaptionTextColor = jQuery('input[name|=caption_text_color]').val();
		strCaptionOpacity = 1 - (parseInt(jQuery('input[name|=caption_opacity]').val()) / 100);
		showCaption = jQuery('input[name|=slide_caption]').is(':checked');
		strHTML = '<img src="' + strImagePath + '" width="400px" class="thethe-upload-imageup">';
		if (showCaption) {
			strHTML += '<div class="thethe-image-slider-caption thethe-image-slider-caption-' + strCaptionPosition + ' thethe-image-slider-caption-' + strCaptionStyle + '">' + '<div class="thethe-image-slider-caption-bg thethe-image-slider-caption-' + strCaptionStyle + '" style="background:' + strCaptionBgColor + ';"></div>' + '<div class="thethe-image-slider-caption-inner" style="color:' + strCaptionTextColor + ';">' + '<div class="thethe-image-slider-caption-text">' + strText + '</div>' + '</div>';
			strHTML += '</div>';
			
		}
		jQuery('.thethe-slider-slide').html(strHTML);
		jQuery('.thethe-image-slider-caption-bg').css( 'opacity' , strCaptionOpacity);
	}

	if (jQuery('.thethe-slider-slide').attr('class')) {
		rebuildPreview();
		jQuery(':input', jQuery('#thethe-slider-slideform')).bind('change',
		function() {
			rebuildPreview();
		});
		jQuery('#thethe-slider-slideform').mousedown(function() {
			rebuildPreview();
		});
	}
	if (jQuery('.thethe-slider-delete-slide').attr('class')) {
		postboxes.add_postbox_toggles('thethe-image-slider');
	}

});