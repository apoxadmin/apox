<?php
function getTheTheSliderSkins(){
	global $TheTheIS;
	$arrSkins = array();
	$strDir = $TheTheIS['wp_plugin_dir'].'/style/skins/';
	if (is_dir($strDir)) {
	    if ($dh = opendir($strDir)) {
	        while (($file = readdir($dh)) !== false ) {
	        	if (is_dir($strDir . $file) && $file != '.' && $file != '..'){
	        		$arrSkins[$file] = FormatStyle($file);
	        	}
	        }
	        closedir($dh);
	    }
	}
	$arrSkins['none'] = 'None';
	return $arrSkins;
}

function FormatStyle($strStyle){
	return ucwords(str_replace('-', ' ', $strStyle));
}
if(!function_exists('getCurrentViewIndexIS')){ 
	function getCurrentViewIndexIS(){
		$fetchAllViewIndex = array('overview', 'sliders', 'addnew', 'customcss', 'editslide', 'addnewslide');
		$viewIndex = isset($_REQUEST['view']) 
			? $_REQUEST['view'] : 'overview';
		return $viewIndex;
	}
}
if(!function_exists('getTabURLIS')){ 
	function getTabURLIS($viewIndex = null){
		if (!$viewIndex) $viewIndex = 'overview';
		return 'admin.php?page=thethe-image-slider&amp;view=' . $viewIndex;
	}
}
?>