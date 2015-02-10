<?php
function _thethe_image_slider_isExists($name)
{
	$q = new WP_Query( 'name=' . sanitize_title($name) .'&post_type=thethe-slider');
	return $q->post_count;
}

function _thethe_image_slider_add(){
	global $g_arrBoxes, $g_arrSliderProperties;
	// new slider creation
	if (!empty($_POST['_slider_name'])){
		$arrPost = array(
			'post_title' => $_POST['_slider_name'],
			'post_content' => '',
			'post_name' => $_POST['_slider_name'],
			'post_status' => 'publish',
			'post_type' => 'thethe-slider'
		);
		if ($post_id = wp_insert_post( $arrPost )){
			foreach ($g_arrBoxes as $box){
				if ($box['type'] == 'checkbox'){
					if (!isset($_POST[$box['name']])){
						$value = 0;
					}else {
						$value = 1;
					}
				}else{
					$value = $_POST[$box['name']];
				}
				$bR = update_post_meta($post_id, $box['name'], $value);
			}
			$_arrSlides = $_POST['slide'];
			$arrSlides = array();
			if (!empty($_arrSlides)){
				foreach ($_arrSlides as $key => $array){
					foreach ($array as $id => $value){
						if (!isset($arrSlides[$id])){
							$arrSlides[$id] = array();
						}
						if (!is_array($value) && !is_object($value)) {
							$value = stripslashes($value);
						}
						$arrSlides[$id][$key] = $value;
					}			
				}
			}
			foreach ($arrSlides as $id => $slide){
				foreach ($g_arrSliderProperties as $slideprop){
					if ($slide[$slideprop['name']] != $slideprop['default']){				
						break;
					}
					if (!empty($slide['image'])){
						break;
					}
					unset($arrSlides[$id]);
				}
			}
			$strSlides = addslashes(serialize($arrSlides));
			update_post_meta($post_id, 'slides', $strSlides);
			// good result
			return $post_id;
		}
	}
	// bad result
	return false;
}

function _thethe_image_slider_edit($bReset = false){
	global $g_arrBoxes;
	$post_id = $_POST['id'];
	if (empty($post_id)){
		return false;
	}
	if (!empty($_POST['_slider_name'])){
		$arrPost = array(
			'post_title' => $_POST['_slider_name'],
			'post_name' => $_POST['_slider_name'],
			'ID' => $post_id,
		);
		$post_id = wp_update_post( $arrPost );
	}
	foreach ($g_arrBoxes as $box){
		if ($box['type'] == 'checkbox'){
			if (!isset($_POST[$box['name']])){
				$value = 0;
			}else {
				$value = 1;
			}
		}else{
			$value = $_POST[$box['name']];
		}
		if ($bReset && $box['name'] != '_slider_name'){
			$value = $box['default'];
		}
		update_post_meta($post_id, $box['name'], $value);
	}
	return true;
}

function _thethe_image_slider_slide_edit($bReset = false){
	global $g_arrSliderProperties;
	$post_id = $_POST['id'];
	$slide_id = $_POST['sid'];
	
	if (empty($post_id)){
		return false;
	}
	$arrSlide = array();
	foreach ($g_arrSliderProperties as $title => $properties){
		foreach ($properties as $box){			
			$value = isset($_POST[$box['name']]) ? $_POST[$box['name']] : '';
			if (!is_array($value) && !is_object($value)) {
				$value = stripslashes($value);
			}
			if ($box['type'] == 'checkbox'){
				if (!isset($_POST[$box['name']])){
					$value = 0;
				}else {
					$value = 1;
				}
			}
			
			if ($bReset && $box['name'] != 'title' && $box['name'] != 'url' && $box['name'] != 'image'){
				$value = $box['default'];
			}
			$arrSlide[$box['name']] = $value;
		}
		$arrSlide['id'] = md5($arrSlide['image'] . $arrSlide['title'] . $arrSlide['url'] . $post_id);
	}	
	$strSlides = get_post_meta($post_id, 'slides', true);
	$arrSlides = (is_array($arrSlides = @unserialize($strSlides))) ? $arrSlides : array();
	if (isset($arrSlides[$slide_id])){
		$arrSlides[$slide_id] = $arrSlide;
	}
	$strSlides = addslashes(serialize($arrSlides));	
	update_post_meta($post_id, 'slides', $strSlides);
	return true;
}

function _thethe_image_slider_slide_add(){
	global $g_arrSliderProperties;
	$post_id = $_POST['id'];	
	if (empty($post_id)){
		return false;
	}
	$arrSlide = array();
	foreach ($g_arrSliderProperties as $title => $properties){
		foreach ($properties as $box){			
			$value = isset($_POST[$box['name']]) ? $_POST[$box['name']] : '';
			if (!is_array($value) && !is_object($value)) {
				$value = stripslashes($value);
			}
			if ($box['type'] == 'checkbox'){
				if (!isset($_POST[$box['name']])){
					$value = 0;
				}
			}
			$arrSlide[$box['name']] = $value;
		}
		$arrSlide['id'] = md5($arrSlide['image'] . $arrSlide['title'] . $arrSlide['url'] . $post_id);
	}
	$strSlides = get_post_meta($post_id, 'slides', true);
	$arrSlides = (is_array($arrSlides = @unserialize($strSlides))) ? $arrSlides : array();
	$arrSlides[] = $arrSlide;
	$strSlides = addslashes(serialize($arrSlides));	
	update_post_meta($post_id, 'slides', $strSlides);
	return (count($arrSlides) - 1);
}

function _thethe_image_slider_delete(){
	$post = get_post($_GET['id']);
	if ($post->post_type == 'thethe-slider'){
		wp_delete_post($post->ID);
		return true;
	}
	return false;
}

function _thethe_image_slider_slides_order(){
	$arrOrder = $_POST['order'];
	if (empty($arrOrder)){
		return ;
	}
	$arrTouched = array();
	$g_arrSliders = array();
	foreach ($arrOrder as $name => $list){
		if (empty($name)){
			continue;
		}
		$nID = str_replace('page', '', $name);
		if (empty($nID) || isset($arrTouched[$nID])){
			continue;
		}
		$_strOtherSlides = get_post_meta($nID, 'slides', true);
		$_arrSlides = (is_array($_arrSlides = @unserialize($_strOtherSlides))) ? $_arrSlides : array();
		$_s = array();
		foreach ($_arrSlides as $n => $_slide){
			$_slide['number'] = $n;
			$_s[$_slide['id']] = $_slide;
		}
		$g_arrSliders[$nID] = array('index' => $_s, 'number' => $_arrSlides);
	}
	foreach ($arrOrder as $name => $list){
		if (empty($name)){
			continue;
		}
		$nID = str_replace('page', '', $name);
		if (empty($nID) || isset($arrTouched[$nID])){
			continue;
		}
		$arrOrderList = explode(',', $list);
		$arrOthersSliders = array();
		$arrOrder = array();
		foreach ($arrOrderList as $slideID){
			$slideID = str_replace('id', '-', str_replace('slide', '', str_replace('slider', '-', $slideID)));			
			$arrSlide = explode('-', $slideID);
			if (empty($arrSlide)){
				continue;
			}
			if ($arrSlide[1] != $nID){
				if (!isset($arrOthersSliders[$arrSlide[1]])){
					$arrOthersSliders[$arrSlide[1]] = array();
				}
				$arrOthersSliders[$arrSlide[1]][] = $arrSlide[2];
			}
			$arrOrder[] = array('number' => $arrSlide[0], 'sid' => $arrSlide[1], 'id' => $arrSlide[2]);
		}
		$arrOthersSlidersSlides = array();
		foreach ($arrOthersSliders as $sid => $slides){
			if (!isset($g_arrSliders[$sid])){
				continue;
			}
			$_s = $g_arrSliders[$sid]['index'];
			$_arrSlides = $g_arrSliders[$sid]['number'];
			foreach ($slides as $_slide){
				if (isset($_s[$_slide])){
					if (!isset($arrOthersSlidersSlides[$sid])){
						$arrOthersSlidersSlides[$sid] = array();
					}
					$arrOthersSlidersSlides[$sid][$_slide] = $_s[$_slide];
					unset($_arrSlides[$_s[$_slide]['number']]);
					$_strSlides = addslashes(serialize($_arrSlides));
					$arrTouched[$sid] = true;
					update_post_meta($sid, 'slides', $_strSlides);
				}
			}
		}
		$arrNewSlides = array();
		$strSlides = get_post_meta($nID, 'slides', true);
		$arrSlides = (is_array($arrSlides = @unserialize($strSlides))) ? $arrSlides : array();
		$_s = array();
		foreach ($arrSlides as $n => $_slide){
			$_slide['number'] = $n;
			$_s[$_slide['id']] = $_slide;
		}
		foreach ($arrOrder as $slideinfo){
			$_slide = array();
			if ($slideinfo['sid'] == $nID){
				if (isset($_s[$slideinfo['id']])){
					$_slide = $_s[$slideinfo['id']];
				}
			}else{
				if (isset($arrOthersSlidersSlides[$slideinfo['sid']]) && isset($arrOthersSlidersSlides[$slideinfo['sid']][$slideinfo['id']])){
					$_slide = $arrOthersSlidersSlides[$slideinfo['sid']][$slideinfo['id']];
					
				}elseif (isset($_s[$slideinfo['id']])) {
					$_slide = $_s[$slideinfo['id']];
				}else {
					foreach ($g_arrSliders as $_id => $_slider){
						if (isset($_slider['index'][$slideinfo['id']])){
							$_slide = $_slider['index'][$slideinfo['id']];
						}
					}
				}
			}
			if (!empty($_slide)){
				$arrNewSlides[] = $_slide;
			}
		}
		$strSlides = addslashes(serialize($arrNewSlides));
		$arrTouched[$nID] = true;
		update_post_meta($nID, 'slides', $strSlides);
	}
}

function _thethe_image_slider_reorder(){
	$post_id = $_POST['id'];
	if (empty($post_id)){
		return false;
	}
	$arrSlides = $_POST['slide'];
	$arrOldSlides = array();
	$arrNewSlidesList = array();
	foreach ($arrSlides as $_slide){		
		$_arrSlide = explode(';', $_slide);
		$_post_id = $_arrSlide[1];
		$_slide_id = $_arrSlide[0];
		if (!isset($arrOldSlides[$_post_id])){
			$strSlides = get_post_meta($_post_id, 'slides', true);
			$arrOldSlides[$_post_id] = (is_array($arrOldSlides[$_post_id] = @unserialize($strSlides))) ? $arrOldSlides[$_post_id] : array();
		}
		if (isset($arrOldSlides[$_post_id][$_slide_id])){
			$arrNewSlidesList[] = $arrOldSlides[$_post_id][$_slide_id];
		}
		if ($_post_id != $post_id && isset($arrOldSlides[$_post_id][$_slide_id])){
			unset($arrOldSlides[$_post_id][$_slide_id]);
		}
	}
	$strSlides = addslashes(serialize($arrNewSlidesList));
	update_post_meta($post_id, 'slides', $strSlides);
	foreach ($arrOldSlides as $_post_id => $arrSlides){
		if ($_post_id != $post_id){
			$strSlides = addslashes(serialize($arrSlides));
			update_post_meta($_post_id, 'slides', $strSlides);
		}
	}
	_thethe_image_slider_rebuild_slides($post_id);
}

function _thethe_image_slider_rebuild_slides($id){
		include 'inc/inc.boxes.php';	
			$strSlides = get_post_meta($id, 'slides', true);
			$arrSlides = (is_array($arrSlides = @unserialize($strSlides))) ? $arrSlides : array();
		?>		

						<?php foreach ($arrSlides as $i => $arrSlide){?>
							<div class="thethe-slide postbox" id="slide<?php echo $i?>slider<?php echo $id?>">
								<div style="width:25px">										
									<img src="<?php echo THETHE_IMAGE_SLIDER_URL?>style/images/move.png" title="Drag to Reorder slides" class="hndle" />
								</div>
								<div style="width:15%">
									<input type="hidden" name="slide[]" value="<?php echo $i?>;<?php echo $id?>" />
									<a href="<?php echo getTabURLIS('editslide&id='.$id)?>&sid=<?php echo $i?>" class="thethe-edit">
									<?php  if (!empty($arrSlide['image'])){?>
                                    <?php $image_src = thethe_get_image_path( $arrSlide['image'] ); ?>
										<img src="<?php echo THETHE_IMAGE_SLIDER_URL . 'timthumb.php?w=80&h=80&zc=1&src='.urlencode($image_src)?>" />
									<?php }else{?>
										<img src="<?php echo THETHE_IMAGE_SLIDER_URL?>style/images/smallnoimg.png" />
									<?php }?>
									</a>
								</div>
								<div style="width:20%">
									<a href="<?php echo getTabURLIS('editslide&id='.$id)?>&sid=<?php echo $i?>" class="row-title"><?php echo $arrSlide['title']?></a><br />
									<?php if (!empty($arrSlide['url'])){?>
									<a href="http://<?php echo $arrSlide['url']?>" target="_blank" class="thethe-slider-small"><?php echo $arrSlide['url']?></a>
									<?php }?>
								</div>
								<div style="width:6%"><?php echo ($arrSlide['delay']/1000).'s' ?></div>
								<div style="width:10%"><?php echo $arrTransitionsList[$arrSlide['transition']]?></div>
								<div style="width:34%"><?php echo substr(htmlspecialchars($arrSlide['text']), 0, 400)?></div>
								<div style="width:10%">
									<a href="<?php echo getTabURLIS('editslide&id='.$id)?>&sid=<?php echo $i?>" class="thethe-edit" id="editslide<?php echo $i?>slider<?php echo $id?>"><?php _e('Edit')?></a>
									<a href="#" class="thethe-slider-delete-slide" id="deleteslide<?php echo $i?>slider<?php echo $id?>" title="<?php _e('Delete')?> <?php echo $arrSlide['title']?>"><?php _e('Delete')?></a>
								</div>
								<br clear="all" />
							</div>
						<?php }?>

					<?php if (!empty($arrSlides)){?>
					<div style="clear: both"></div>
					<?php }?>        
<?php				
}
function _thethe_image_slider_save_customcss($bReset = false){
	$strValue = $_POST['thethe-image-slider-customcss'];
	$enableCustomCss = $_POST['thethe-image-slider-enable-customcss'];
	if ($bReset){
		$strValue = '';
		$enableCustomCss = 0;
	}
	update_option('thethe-image-slider-enable-customcss', $enableCustomCss, '', 'no');
	update_option('thethe-image-slider-customcss', $strValue, '', 'no');
	return true;
}
?>