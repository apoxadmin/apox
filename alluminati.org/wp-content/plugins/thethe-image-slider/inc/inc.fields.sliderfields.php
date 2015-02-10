<?php
// field start to customize easy
if ( ! function_exists( 'sp_field_start' ) ) :
function sp_field_start () {
	return '<div class="slideroption">';
}
endif;

// field end to customize easy
if ( ! function_exists( 'field_end' ) ) :
function sp_field_end() {
	return '<br class="clear" /></div>';
}
endif;

// field end to customize easy
if ( ! function_exists( 'field_label' ) ) :
function field_label( $args ) {
	return '<div class="label"><label for="'.$args['name'].'">'.$args['title'].':</label></div>';
}
endif;

// field to customize easy
if ( ! function_exists( 'field_field' ) ) :
function field_field($strInner, $strDesc = '', $strClass = '') {
	return '<div class="field '.$strClass.'">'.$strInner.' '.$strDesc.'</div>';
}
endif;

// description to customize easy
if ( ! function_exists( 'field_desc' ) ) :
function field_desc($strInner) {
	if (empty($strInner)){
		return '';
	}
	return '<div class="desc"><em>'.$strInner.'</em></div>';
}
endif;

// description to customize easy
if ( ! function_exists( 'field_help' ) ) :
function field_help($strInner) {
	return '<div class="thethe-slider-help">?<div class="thethe-slider-innerhelp">'.htmlspecialchars($strInner).'</div></div>';
}
endif;

$post = null;
if ( ! function_exists( 'set_html_post' ) ) :
	function set_html_post($_post){
		global $post;
		$post = $_post;
	}
endif;
// this switch statement specifies different types of meta boxes
// you can add more types if you add a case and a corresponding function
// to handle it
if ( ! function_exists( 'field_html' ) ) :
function field_html ( $args, $arrSlide = array() ) {
	switch ( $args['type'] ) {
		case 'textarea':
			return text_area( $args, $arrSlide );
		case 'checkbox':
			return checkbox_field( $args, $arrSlide );
		case 'select':
			return select_field( $args, $arrSlide );
		case 'image':
			return image_field( $args, $arrSlide );
		default:
			return text_field( $args, $arrSlide );
	}
}
endif;

// this is the default text field meta box
if ( ! function_exists( 'text_field' ) ) :
function text_field ( $args, $arrSlide = array() ) {
	global $post;
	$description = $args['desc'];
	$strHelp  = $args['help'];
	// adjust data
	if (empty($arrSlide)){
		$args['value'] = get_post_meta($post->ID, $args['name'], true);
	}else{		
		$strName = trim( str_replace('slide', '', $args['name']), '[]' );
		if (trim($arrSlide[$strName])!='')
			$args['value'] = $arrSlide[$strName];
		else 
			$args['value'] = '';
	}
	if (trim($args['value'])==''){
		$args['value'] = $args['default'];
	}
	$strClass = '';
	if (!empty($args['class'])){
		$strClass = ' class="'.$args['class'].'"';
	}
	$label_format =	
		field_label($args).
		field_field('<input type="text" name="'.$args['name'].'" value="'.$args['value'].'" '.$strClass.'/>', $description).
		field_help($strHelp);
	return $label_format;
}
endif;

// this is the default text field meta box
if ( ! function_exists( 'image_field' ) ) :
function image_field ( $args, $arrSlide = array() ) {
	global $post;
	$description = $args['desc'];
	$strHelp  = $args['help'];
	// adjust data
	if (empty($arrSlide)){
		$args['value'] = get_post_meta($post->ID, $args['name'], true);
	}else{		
		$strName = trim( str_replace('slide', '', $args['name']), '[]' );
		$args['value'] = !empty($arrSlide[$strName]) ? $arrSlide[$strName] : '';
	}
	$label_format =	
		field_label($args).
		field_field('<input type="text" name="'.$args['name'].'" value="'.$args['value'].'" class="thethe-upload-image" />', $description).
		field_help($strHelp);
	return $label_format;
}
endif;

// this is the checkbox field meta box
if ( ! function_exists( 'checkbox_field' ) ) :
function checkbox_field ( $args, $arrSlide = array() ) {
	global $post;
	$description = $args['desc'];
	$strHelp  = $args['help'];
	// adjust data
	if (empty($arrSlide)){
		$args['value'] = get_post_meta($post->ID, $args['name'], true);
	}else{
		//$strName = trim( str_replace('slide', '', $args['name']), '[]' );
		//$args['value'] = !empty($arrSlide[$strName]) ? $arrSlide[$strName] : false;
		
		$args['value'] = $arrSlide[$args['name']];
	}
	if ($args['value'] === '' || $args['value'] === false){
		$args['value'] = $args['default'];
	}
	$label_format =	
		field_label($args).
		field_field('<input type="checkbox" class="checkbox" name="'.$args['name'].'" value="1" '. ((!empty($args['value']))?'checked="checked"':'') .' />', $description, 'checkbox').
		field_help($strHelp);
	return $label_format;
}
endif;

// this is the checkbox field meta box
if ( ! function_exists( 'select_field' ) ) :
function select_field ( $args, $arrSlide = array() ) {
	global $post;
	$description = $args['desc'];
	$strHelp  = $args['help'];
	// adjust data
	if (empty($arrSlide)){
		$args['value'] = get_post_meta($post->ID, $args['name'], true);
	}else{
		$strName = trim( str_replace('slide', '', $args['name']), '[]' );
		$args['value'] = !empty($arrSlide[$strName]) ? $arrSlide[$strName] : '';
	}
	if ($args['value'] === '' || $args['value'] === false){
		$args['value'] = $args['default'];
	}
	$strOptions = '';
	foreach ($args['values'] as $value => $arg){
		$strOptions .= '<option value="'.$value.'" '.(($args['value'] == $value) ? 'selected="selected"' : '').'>'.ucwords($arg).'</option>';
	}
	$app = '';
	$id = '';
	if ($args['name'] == '_slider_style'){
		$id = 'thethe-slider-style';
		$app = '<div class="thethe-preview-style" id="' . $id .'preview"></div>';
	}
	$strClass = '';
	if (!empty($args['class'])){
		$strClass = ' class="'.$args['class'].'"';
	}
	$label_format =	
		field_label($args).
		field_field('<select name="'.$args['name'].'" '.(!empty($id) ? 'id ="'.$id.'"' : '').' '.$strClass.'>' . $strOptions . '</select>'.$app, $description).
		field_help($strHelp);
	return $label_format;
}
endif;

// this is the text area meta box
if ( ! function_exists( 'text_area' ) ) :
function text_area ( $args, $arrSlide = array() ) {
	global $post;
	$description = $args['desc'];
	$strHelp  = $args['help'];
	// adjust data
	if (empty($arrSlide)){
		$args['value'] = get_post_meta($post->ID, $args['name'], true);
	}else{
		$strName = trim( str_replace('slide', '', $args['name']), '[]' );
		$args['value'] = !empty($arrSlide[$strName]) ? $arrSlide[$strName] : '';
	}
	$label_format =
		field_label($args).
		field_field('<textarea name="'.$args['name'].'" rows="5" cols="10">'.htmlspecialchars($args['value']).'</textarea>', $description).
		field_help($strHelp);
	return $label_format;
}
endif;