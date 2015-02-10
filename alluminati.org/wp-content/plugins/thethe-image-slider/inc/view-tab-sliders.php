<?php
include 'inc.boxes.php';
?>
<?php 
global $_thethe_image_slider_error_msg;
if (isset($_thethe_image_slider_error_msg)) {?>
<div class="updated" id="message"><p><?php _e($_thethe_image_slider_error_msg); ?></p></div>
<?php } elseif($_GET['update']){?>
	<div class="updated" id="message"><p><?php _e('Slider updated.'); ?></p></div>
<?php }?>

<fieldset>
	<div class="wrap">
	<?php 
	$args = array(
   		'posts_per_page' => -1,
		'post_type'=> 'thethe-slider'
	);	
	$oQuery = new WP_Query( $args);
	if ($oQuery->have_posts()){?>
	<table cellspacing="0" class="widefat post fixed">
		<thead>
		<tr>
		<th style="" class="manage-column column-title" scope="col" width="20%"><?php _e('Slider Name'); ?></th>
		<th style="" class="manage-column column-title" scope="col" width="10%"><?php _e('Size'); ?></th>
		<th style="" class="manage-column column-title" scope="col" width="10%"><?php _e('Style'); ?></th>
		<th style="" class="manage-column column-title" scope="col" width="30%"><?php _e('Shortcode'); ?></th>
		</tr>
		</thead>
	
		<tfoot>
		<tr>
		<th style="" class="manage-column column-title" scope="col"><?php _e('Slider Name'); ?></th>
		<th style="" class="manage-column column-title" scope="col"><?php _e('Size'); ?></th>
		<th style="" class="manage-column column-title" scope="col"><?php _e('Style'); ?></th>
		<th style="" class="manage-column column-title" scope="col"><?php _e('Shortcode'); ?></th>
		</tr>
		</tfoot>
	
		<tbody>		
	  	<?php 
		// The Loop
		while( $oQuery->have_posts() ) : $oQuery->the_post();
			// option
			$arrOptions = array();
			foreach ( $g_arrBoxes as $box ) {
				if ($box['type'] == 'select' && !isset($box['keyvalue'])){
					$arrOptions[$box['name']] = $box['values'][get_post_meta(get_the_ID(), $box['name'], true)];
				}else{
					$arrOptions[$box['name']] = get_post_meta(get_the_ID(), $box['name'], true);
				}
			}
			// slides
			$strSlides = get_post_meta(get_the_ID(), 'slides', true);
			$arrSlides = (is_array($arrSlides = @unserialize($strSlides))) ? $arrSlides : array();
		?>			
			<tr valign="top" class="alternate author-self status-publish iedit" id="post-<?php echo get_the_ID()?>">
				<td class="post-title column-title">
					<strong><a title="<?php echo esc_attr(sprintf(__('View &#8220;%s&#8221; slides'), get_the_title()))?>" href="<?php echo getTabURLIS('editslider&id='.get_the_ID())?>" class="row-title" id="viewslider<?php echo get_the_ID()?>"><?the_title()?></a></strong>
					<div class="row-actions">
						<a title="<?php echo esc_attr(sprintf(__('Edit &#8220;%s&#8221;'), get_the_title()))?>" href="<?php echo getTabURLIS('editslider&id='.get_the_ID())?>" class="thethe-edit"><?php _e('Edit'); ?></a>
						|
						<a href="#" title="<?php _e('Edit Slides'); ?>" class="thethe-slide-view-slides" id="viewslider<?php echo get_the_ID()?>"><?php _e('Edit Slides'); ?></a>
						|
						<a href="<?php echo getTabURLIS('deleteslider&id='.get_the_ID())?>" title="<?php _e('Delete'); ?>" id="delete-<?php echo $arrOptions['_slider_name']?>" class="thethe-slider-delete"><?php _e('Delete'); ?></a>
					</div>
				</td>
				<td class="author column-author"><?php echo $arrOptions['_slider_width'] . ((!empty($arrOptions['_slider_width']) || !empty($arrOptions['_slider_height'])) ? 'x' :'') . $arrOptions['_slider_height']?></td>
                <?php $bgImg = $arrOptions['_slider_style'] == 'none' ? THETHE_IMAGE_SLIDER_URL.'style/images/blank.gif' : THETHE_IMAGE_SLIDER_URL.'style/skins/'.$arrOptions['_slider_style'].'/buttons.png';?>
				<td class="author column-author"><img class="thethe-slider-style-thumb" src="<?php echo $bgImg?>" alt="<?php echo FormatStyle($arrOptions['_slider_style'])?>" title="<?php echo FormatStyle($arrOptions['_slider_style'])?>" /></td>
				<td class="author column-author"><input type="text" value="<?php echo htmlentities('[thethe-image-slider name="'.$arrOptions['_slider_name'].'"]')?>" style="width: 80%"/></td>
			</tr>
			<tr id="viewslider<?php echo get_the_ID()?>slides" class="thethe-slider-hidden">
				<td colspan="4">			
				<div class="">
					<form action="admin.php?page=thethe-image-slider" method="POST" class="thethe-ajaxformsubmit" id="slider<?php echo get_the_ID()?>">
					<input type="hidden" name="id" value="<?php echo get_the_ID()?>" />
					<input type="hidden" name="action" value="reorderslides" />
					<?php if (!empty($arrSlides)){?>
					<div class="thethe-slider-headers">
						<div style="width:25px;height:10px;"></div>
						<div style="width:15%"><?php _e('Thumbnail')?></div>
						<div style="width:20%"><?php _e('Name')?></div>
						<div style="width:6%"><?php _e('Delay')?></div>
						<div style="width:10%"><?php _e('Transition')?></div>
						<div style="width:34%"><?php _e('Caption')?></div>
						<div style="width:10%"><?php _e('Actions')?></div>
						<br clear="all" />
					</div>
					<?php }?>
					<div class="thethe-slider-minheighter" id="slider<?php echo get_the_ID()?>-holder">
						<?php foreach ($arrSlides as $i => $arrSlide){?>
							<div class="thethe-slide postbox" id="slide<?php echo $i?>slider<?php echo get_the_ID()?>">
								<div style="width:25px">										
									<img src="<?php echo THETHE_IMAGE_SLIDER_URL?>style/images/move.png" title="Drag to Reorder slides" class="hndle" />
								</div>
								<div style="width:15%">
									<input type="hidden" name="slide[]" value="<?php echo $i?>;<?php echo get_the_ID()?>" />
									<a href="<?php echo getTabURLIS('editslide&id='.get_the_ID())?>&sid=<?php echo $i?>" class="thethe-edit">
									<?php  if (!empty($arrSlide['image'])){?>
                                    <?php $image_src = thethe_get_image_path( $arrSlide['image'] ); ?>
										<img src="<?php echo THETHE_IMAGE_SLIDER_URL . 'timthumb.php?w=80&h=80&zc=1&src='.urlencode($image_src)?>" />
									<?php }else{?>
										<img src="<?php echo THETHE_IMAGE_SLIDER_URL?>style/images/smallnoimg.png" />
									<?php }?>
									</a>
								</div>
								<div style="width:20%">
									<a href="<?php echo getTabURLIS('editslide&id='.get_the_ID())?>&sid=<?php echo $i?>" class="row-title"><?php echo $arrSlide['title']?></a><br />
									<?php if (!empty($arrSlide['url'])){?>
									<a href="http://<?php echo $arrSlide['url']?>" target="_blank" class="thethe-slider-small"><?php echo $arrSlide['url']?></a>
									<?php }?>
								</div>
								<div style="width:6%"><?php echo ($arrSlide['delay']/1000).'s' ?></div>
								<div style="width:10%"><?php echo $arrTransitionsList[$arrSlide['transition']]?></div>
								<div style="width:34%"><?php echo substr(htmlspecialchars($arrSlide['text']), 0, 400)?></div>
								<div style="width:10%">
									<a href="<?php echo getTabURLIS('editslide&id='.get_the_ID())?>&sid=<?php echo $i?>" class="thethe-edit" id="editslide<?php echo $i?>slider<?php echo get_the_ID()?>"><?php _e('Edit')?></a>
									<a href="#" class="thethe-slider-delete-slide" id="deleteslide<?php echo $i?>slider<?php echo get_the_ID()?>" title="<?php _e('Delete')?> <?php echo $arrSlide['title']?>"><?php _e('Delete')?></a>
								</div>
								<br clear="all" />
							</div>
						<?php }?>
					</div>
					<?php if (!empty($arrSlides)){?>
					<div style="clear: both"></div>
					<?php }?>
					<a href="<?php echo getTabURLIS('addnewslide&id='.get_the_ID())?>" class="button-primary thethe-slider-addnewbutton">Add New Slide</a>
					</form>
				</div>
				</td>
			</tr>
			<?php endwhile;
				wp_reset_postdata();
			?>
		</tbody>
	</table>    
	<?php }?>
    
	<br class="clear" />
	<a href="<?php echo getTabURLIS('addnew')?>" class="button-primary thethe-slider-addnewbutton">Add New Slider</a>
	<br class="clear" />
	</div>
</fieldset>
