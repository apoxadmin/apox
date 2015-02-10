<?php
$arrSkins = array();
$strDefaultSkin = '';
if (is_admin()){
	$arrSkins = getTheTheSliderSkins();
	$strDefaultSkin = ($arrSkinsValues = array_keys($arrSkins)) ? $arrSkinsValues[0] : '';
};
$arrTransitionsList = array(
	'fade' 					=> 'Fade',
	
	'slideleft' 			=> 'Slide from left',
	'slidetop'				=> 'Slide from top',
	'slideright' 			=> 'Slide from right',
	'slidebottom' 			=> 'Slide from bottom',
								
	'slidenbounceleft' 		=> 'Slide from left with bounce',
	'slidenbouncetop'		=> 'Slide from top with bounce',
	'slidenbounceright' 	=> 'Slide from right with bounce',
	'slidenbouncebottom' 	=> 'Slide from bottom with bounce',

	'scaletop' 				=> 'Scale from top',
	'scalecenter'			=> 'Scale from center',
	'scalenslide'			=> 'Scale and slide',
	
	'zoom'					=> 'Zoom',
	'flip'					=> 'Flip',
	
	'rowsleft'				=> 'Rows to left',
	'rowsright'				=> 'Rows to right',
	'rowstop'				=> 'Rows to top',
	'rowsbottom'			=> 'Rows to bottom',
	'rowssides'				=> 'Rows to sides',
	
	'random'				=> 'Random'
);
$arrDelayList = array(
	'1000' => '1s',
	'2000' => '2s',
	'3000' => '3s',
	'4000' => '4s',
	'5000' => '5s',
	'10000'=> '10s'
);
$g_arrBoxes = array(
	array(
		'name'		=> '_slider_name',
		'title' 	=> 'Slider Name',
		'desc'		=> '',
		'help'		=> 'Enter the slider name here',
		'type'		=> 'text',
		'default'	=> ''
		),
	array(
		'name'		=> '_slider_width',
		'title' 	=> 'Slider Width',
		'desc'		=> 'pixels',
		'help'		=> 'Enter the slider width here',
		'type'		=> 'text',
		'default'	=> '468',
		'class'		=> 'thethe-small-text'
		),
	array(
		'name'		=> '_slider_height',
		'title' 	=> 'Slider Height',
		'desc'		=> 'pixels',
		'help'		=> 'Enter the slider height here',
		'type'		=> 'text',
		'default'	=> '264',
		'class'		=> 'thethe-small-text'
		),
	array(
		'name'		=> '_slider_trans_time',
		'title' 	=> 'Transition Time',
		'desc'		=> 'ms',
		'help'		=> 'Enter the slider transition time here',
		'type'		=> 'text',
		'default'	=> '800',
		'class'		=> 'thethe-small-text'
		),		
	array(
		'name'		=> '_slider_paginator',
		'title' 	=> 'Show Pagination',
		'desc'		=> '',
		'help'		=> 'Check this box to display the slider\'s pagination image',
		'type'		=> 'checkbox',
		'default'	=> 1
		),
	array(
		'name'		=> '_slider_paginator_type',
		'title' 	=> 'Pagination Type',
		'desc'		=> '',
		'help'		=> 'Select pagination style',
		'type'		=> 'select',
		'default'	=> 'dots',
		'values'	=> array(
						'dots'			=> 'dots',
						'thumbnails' 	=> 'thumbnails',
						'slidenames'	=> 'slide names',
						'numbers'	 	=> 'numbers'
					)
		),
	array(
		'name'		=> '_slider_paginator_position',
		'title' 	=> 'Pagination Position',
		'desc'		=> '',
		'help'		=> 'Select pagination position',
		'type'		=> 'select',
		'default'	=> 'bottomright',
		'values'	=> array(
						'bottomright'	=> 'Bottom Right',
						'bottomleft' 	=> 'Bottom Left',
						'topright'		=> 'Top Right',
						'topleft'	 	=> 'Top Left',
						'under'		 	=> 'Under the Slider',
					)
		),
	array(
		'name'		=> '_slider_controls',
		'title' 	=> 'Show Controls',
		'desc'		=> '',
		'help'		=> 'Check this box to display the slider\'s controls',
		'type'		=> 'checkbox',
		'default'	=> 1
		),
	array(
		'name'		=> '_slider_autoplay',
		'title' 	=> 'Auto Play',
		'desc'		=> '',
		'help'		=> 'Check this box to start slide show on the page load automatically',
		'type'		=> 'checkbox',
		'default'	=> 1
		),
	array(
		'name'		=> '_slider_loop',
		'title' 	=> 'Loop Slides',
		'desc'		=> '',
		'help'		=> 'Check  this  box  to  loop the slide show (display the first slide after the last one)',
		'type'		=> 'checkbox',
		'default'	=> 1
		),
	array(
		'name'		=> '_slider_autoresize',
		'title' 	=> 'Resize Slides',
		'desc'		=> '',
		'help'		=> 'Check this box to force automatic slide\'s image resizing (zoom or crop depending on the actuall image size)',
		'type'		=> 'checkbox',
		'default'	=> 1
		),
	array(
		'name'		=> '_slider_backlink',
		'title' 	=> 'Linkback to Developer',
		'desc'		=> '',
		'help'		=> 'Check this box to display a backlink to the plugin home page.',
		'type'		=> 'checkbox',
		'default'	=> 0
		),		
	array(
		'name'		=> '_slider_style',
		'title' 	=> 'Slider Style',
		'desc'		=> '',
		'help'		=> 'Select the style for the slider',
		'default'	=> $strDefaultSkin,
		'type'		=> 'select',
		'values'	=> $arrSkins,
		'keyvalue'	=> true,
		'class'		=> ''
		)
);

$g_arrSliderProperties = array(
	'Slide Settings' => array(
		array(
			'name'		=> 'image',
			'title'		=> 'Image',
			'help'		=> 'Choose the image to use as a slide',
			'default'	=> '',
			'desc'		=> '',
			'type'		=> 'image'
			),
		array(
			'name'		=> 'title',
			'title'		=> 'Name',
			'help'		=> 'Enter the slide name (maximum 20 chars)',
			'default'	=> '',
			'desc'		=> '',
			'type'		=> 'text'
			),
		array(
			'name'		=> 'url',
			'title'		=> 'Link URL',
			'help'		=> 'Enter the slider link URL',
			'default'	=> '',
			'desc'		=> '',
			'type'		=> 'text'
			),
		array(
			'name'		=> 'delay',
			'title'		=> 'Delay',
			'help'		=> 'Enter how many miliseconds delay to make before next transition',
			'default'	=> '5000',
			'desc'		=> 'ms',
			'type'		=> 'text',
			'values'	=> $arrDelayList,
			'class'		=> 'thethe-small-text'
			),
		array(
			'name'		=> 'transition',
			'title'		=> 'Transition',
			'default'	=> 'random',
			'desc'		=> '',
			'help'		=> 'Select the transition effect for this slide',
			'type'		=> 'select',
			'values'	=> $arrTransitionsList
			),
		),
	'Caption Settings' => array(
		array(
			'name'		=> 'slide_caption',
			'title' 	=> 'Show Caption',
			'desc'		=> '',
			'help'		=> 'Check this box to display the slider\'s caption',
			'type'		=> 'checkbox',
			'default'	=> 1
			),
		array(
			'name'		=> 'caption_position',
			'title'		=> 'Caption Position',
			'default'	=> 'bottom',
			'desc'		=> '',
			'help'		=> 'Select the caption position',
			'type'		=> 'select',
			'values'	=> array(
							'bottom'	=> 'Bottom',
							'top' 		=> 'Top',
							'left'		=> 'Left',
							'right' 	=> 'Right'
						)
			),
		array(
			'name'		=> 'caption_size',
			'title'		=> 'Caption Size',
			'default'	=> '60',
			'desc'		=> 'px',
			'help'		=> 'Enter the ize of the Caption area in pixels',
			'type'		=> 'text',
			'class'		=> 'thethe-small-text'			
			),
		array(
			'name'		=> 'caption_style',
			'title'		=> 'Caption Style',
			'default'	=> 'black',
			'desc'		=> '',
			'help'		=> 'Select the caption style.',
			'type'		=> 'select',
			'values'	=> array(
								'black'		=> 'Black',
								'gray' 		=> 'Gray',
								'white'		=> 'White'
							)
			),
		array(
			'name'		=> 'caption_bg_color',
			'title'		=> 'Caption Background Color',
			'default'	=> '',
			'desc'		=> '',
			'help'		=> 'Pick the caption background color.',
			'type'		=> 'text',
			'class'		=> 'thethe-small-text pickcolor'
			),						
		array(
			'name'		=> 'caption_text_color',
			'title'		=> 'Caption Text Color',
			'default'	=> '',
			'desc'		=> '',
			'help'		=> 'Pick the caption text color.',
			'type'		=> 'text',
			'class'		=> 'thethe-small-text pickcolor'
			),						
			
		array(
			'name'		=> 'caption_opacity',
			'title'		=> 'Caption Background Opacity',
			'help'		=> 'Specify the opacity percentage for the caption background.',
			'default'	=> '30',
			'desc'		=> '%',
			'type'		=> 'text',
			'class'		=> 'thethe-small-text'
			),	
		array(
			'name'		=> 'text',
			'title'		=> 'Caption Text',
			'help'		=> 'Enter  the HTML code for this slider\'s caption.',
			'default'	=> '',
			'desc'		=> '',
			'type'		=> 'textarea'
			)					
	)
);
?>