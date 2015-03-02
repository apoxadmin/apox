<?php

function front_end_slider($images, $paramssld, $slider)
{
 ob_start();
	$sliderID=$slider[0]->id;
	$slidertitle=$slider[0]->name;
	$sliderheight=$slider[0]->sl_height;
	$sliderwidth=$slider[0]->sl_width;
	$slidereffect=$slider[0]->slider_list_effects_s;
	$slidepausetime=($slider[0]->description+$slider[0]->param);
	$sliderpauseonhover=$slider[0]->pause_on_hover;
	$sliderposition=$slider[0]->sl_position;
	$slidechangespeed=$slider[0]->param;
	
	$slideshow_title_position = explode('-', trim($paramssld['slider_title_position']));
	$slideshow_description_position = explode('-', trim($paramssld['slider_description_position']));

	$hasyoutube=false;
	$hasvimeo=false;
	foreach ($images as $key => $image_row) {
		if(strpos($image_row->image_url,'youtube') !== false || strpos($image_row->image_url,'youtu.be') !== false){$hasyoutube=true;}
		if(strpos($image_row->image_url,'vimeo') !== false){$hasvimeo=true;}
	}	
?>


<?php if ($hasvimeo==true){?>
<script src="<?php echo plugins_url( 'js/vimeo.lib.js' , __FILE__ ) ?>"></script>
<script>
jQuery(function(){
	var vimeoPlayer = document.querySelector('iframe');

	var volumes = [];
	var colors = [];
	var i=0;		
	<?php
	$i=0;
	//$vimeoparams=array_reverse($images);
	foreach ($images as $key => $image_row) {	if($image_row->sl_type=="video" and strpos($image_row->image_url,'vimeo') !== false){?>
		volumes[<?php echo $i; ?>] = '<?php echo intval($image_row->description)/100; ?>';
		colors[<?php echo $i; ?>] = '<?php echo $image_row->link_target; ?>';
	<?php $i++;}	} ?>
		
	jQuery('iframe').each(function(){
				Froogaloop(this).addEvent('ready', ready);
	});
	jQuery(".sidedock,.controls").remove();
	function ready(player_id) {
	
		froogaloop = $f(player_id);
	
		function setupEventListeners() {
			function setVideoVolume(player_id,value) {
				Froogaloop(player_id).api('setVolume',value);
			}	
			function setVideoColor(player_id,value) {
				Froogaloop(player_id).api('setColor',value);
			}			
			function onPlay() {
				froogaloop.addEvent('play',
				function(){
					video_is_playing_<?php echo $sliderID; ?>=true;
				});
			}
			function onPause() {
				froogaloop.addEvent('pause',
				function(){
					video_is_playing_<?php echo $sliderID; ?>=false;
				});
			}					
			function stopVimeoVideo(player){
				Froogaloop(player).api('pause');
			}
			
			setVideoVolume(player_id,volumes[i]);
			setVideoColor(player_id,colors[i]);
			i++;			
			
			onPlay();
			onPause();
			jQuery('#huge_it_slideshow_left_<?php echo $sliderID; ?>, #huge_it_slideshow_right_<?php echo $sliderID; ?>,.huge_it_slideshow_dots_<?php echo $sliderID; ?>').click(function(){
				stopVimeoVideo(player_id);
			});
		}
		setupEventListeners();
	}
});		
</script>
<?php } ?>

<?php if ($hasyoutube==true){?>

<script src="<?php echo plugins_url( 'js/youtube.lib.js' , __FILE__ ) ?>"></script>
<script> 
  <?php
  function get_youtube_id_from_url($url){
		if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
			return $match[1];
		}
	}
			
	$i=0;
	 foreach ($images as $key => $image_row) {
		if($image_row->sl_type=="video" and strpos($image_row->image_url,'youtu') !== false){	
  ?> 
		var player_<?php echo $image_row->id; ?>;
<?php
		}else if (strpos($image_row->image_url,'vimeo') !== false){ ?>
				
<?php
		}else{continue;}
		$i++;
	}
?>
		video_is_playing_<?php echo $sliderID; ?>=false;
		function onYouTubeIframeAPIReady() {
			<?php
			foreach ($images as $key => $image_row) {?>
							
				<?php if($image_row->sl_type=="video" and strpos($image_row->image_url,'youtube') !== false){
			?> 
				player_<?php echo $image_row->id; ?> = new YT.Player('video_id_<?php echo $sliderID; ?>_<?php echo $key;?>', {
				  height: '<?php echo $sliderheight; ?>',
				  width: '<?php echo $sliderwidth; ?>',
				  videoId: '<?php echo get_youtube_id_from_url($image_row->image_url); ?>',
				   playerVars: {
					'controls': <?php if ($images[$key]->sl_url=="on"){ echo 1;}else{echo 0;} ?>,           
					'showinfo': <?php if ($images[$key]->link_target=="on"){ echo 1;}else{echo 0;} ?>
				  },
				  events: {
					'onReady': onPlayerReady_<?php echo $image_row->id; ?>,
					'onStateChange': onPlayerStateChange_<?php echo $image_row->id; ?>,
					'loop':1
				  }
				});
			<?php
				}else{continue;}
			}
			?>
		}
		
		
<?php			
	foreach ($images as $key => $image_row) {
		if($image_row->sl_type=="video" and strpos($image_row->image_url,'youtube') !== false){
?> 
		  function onPlayerReady_<?php echo $image_row->id; ?>(event) {	
			 player_<?php echo $image_row->id; ?>.setVolume(<?php echo $images[$key]->description; ?>);
		  }
		  
		  function onPlayerStateChange_<?php echo $image_row->id; ?>(event) {
			//(event.data);
			if (event.data == YT.PlayerState.PLAYING) {
				event.target.setPlaybackQuality('<?php echo $images[$key]->name; ?>');
				video_is_playing_<?php echo $sliderID; ?>=true;
			}
			else{
				video_is_playing_<?php echo $sliderID; ?>=false;
			}
		  }
<?php 
	    }else{continue;}
		
	}
?>
	function stopYoutubeVideo() {
		<?php 
		$i=0;
		foreach ($images as $key => $image_row) {
			if($image_row->sl_type=="video" and strpos($image_row->image_url,'youtube') !== false){	
		?>
			player_<?php echo $image_row->id; ?>.pauseVideo();
		<?php
			}else{continue;}
				$i++;
			}
		?>
	}

</script>
<?php } ?>
	
        
<script>
	var data_<?php echo $sliderID; ?> = [];      
	var event_stack_<?php echo $sliderID; ?> = [];
	video_is_playing_<?php echo $sliderID; ?>=false;
	<?php
	//	$images=array_reverse($images);
		$recent_posts = wp_get_recent_posts( $args, ARRAY_A );
                
		$i=0;
		
		foreach($images as $image){
//                    var_dump($image);
			  	$imagerowstype=$image->sl_type;
				if($image->sl_type == ''){
				$imagerowstype='image';
				}
				switch($imagerowstype){
							
					case 'image':
						echo 'data_'.$sliderID.'["'.$i.'"]=[];';
						echo 'data_'.$sliderID.'["'.$i.'"]["id"]="'.$i.'";';
						echo 'data_'.$sliderID.'["'.$i.'"]["image_url"]="'.$image->image_url.'";';
						
						
						$strdesription=str_replace('"',"'",$image->description);
						$strdesription=preg_replace( "/\r|\n/", " ", $strdesription );
						echo 'data_'.$sliderID.'["'.$i.'"]["description"]="'.$strdesription.'";';

						
						$stralt=str_replace('"',"'",$image->name);
						$stralt=preg_replace( "/\r|\n/", " ", $stralt );
						echo 'data_'.$sliderID.'["'.$i.'"]["alt"]="'.$stralt.'";';
						$i++;
					break;
					
					case 'video':
						echo 'data_'.$sliderID.'["'.$i.'"]=[];';
						echo 'data_'.$sliderID.'["'.$i.'"]["id"]="'.$i.'";';
						echo 'data_'.$sliderID.'["'.$i.'"]["image_url"]="'.$image->image_url.'";';
						
						
						$strdesription=str_replace('"',"'",$image->description);
						$strdesription=preg_replace( "/\r|\n/", " ", $strdesription );
						echo 'data_'.$sliderID.'["'.$i.'"]["description"]="'.$strdesription.'";';

						
						$stralt=str_replace('"',"'",$image->name);
						$stralt=preg_replace( "/\r|\n/", " ", $stralt );
						echo 'data_'.$sliderID.'["'.$i.'"]["alt"]="'.$stralt.'";';
						$i++;
					break;
					
					
					case 'last_posts':
					
					foreach($recent_posts as $keyl => $recentimage){
                                            if ($recentimage["post_status"] == "publish"){
                                                if(get_the_post_thumbnail($recentimage["ID"], 'thumbnail') != ''){
						if($keyl < $image->sl_url){
						echo 'data_'.$sliderID.'["'.$i.'"]=[];';
						echo 'data_'.$sliderID.'["'.$i.'"]["id"]="'.$i.'";';
						echo 'data_'.$sliderID.'["'.$i.'"]["image_url"]="'.$recentimage['guid'].'";';
						
						
						$strdesription=str_replace('"',"'",$recentimage['post_content']);
						$strdesription=preg_replace( "/\r|\n/", " ", $strdesription );
						$strdesription=substr_replace($strdesription, "",$image->description);
						echo 'data_'.$sliderID.'["'.$i.'"]["description"]="'.$strdesription.'";';

						
						$stralt=str_replace('"',"'",$recentimage['post_title']);
						$stralt=preg_replace( "/\r|\n/", " ", $stralt );
						echo 'data_'.$sliderID.'["'.$i.'"]["alt"]="'.$stralt.'";';
						$i++;
						}
					}
                                            }
					
					}
					
					break;
			}
			
			
		}
	?>
	
	

      var huge_it_trans_in_progress_<?php echo $sliderID; ?> = false;
      var huge_it_transition_duration_<?php echo $sliderID; ?> = <?php echo $slidechangespeed;?>;
      var huge_it_playInterval_<?php echo $sliderID; ?>;
      // Stop autoplay.
      window.clearInterval(huge_it_playInterval_<?php echo $sliderID; ?>);
	  
     var huge_it_current_key_<?php echo $sliderID; ?> = '<?php echo (isset($current_key) ? $current_key : ''); ?>';
	 function huge_it_move_dots_<?php echo $sliderID; ?>() {
        var image_left = jQuery(".huge_it_slideshow_dots_active_<?php echo $sliderID; ?>").position().left;
        var image_right = jQuery(".huge_it_slideshow_dots_active_<?php echo $sliderID; ?>").position().left + jQuery(".huge_it_slideshow_dots_active_<?php echo $sliderID; ?>").outerWidth(true);
       
      }
      function huge_it_testBrowser_cssTransitions_<?php echo $sliderID; ?>() {
        return huge_it_testDom_<?php echo $sliderID; ?>('Transition');
      }
      function huge_it_testBrowser_cssTransforms3d_<?php echo $sliderID; ?>() {
        return huge_it_testDom_<?php echo $sliderID; ?>('Perspective');
      }
      function huge_it_testDom_<?php echo $sliderID; ?>(prop) {
        // Browser vendor CSS prefixes.
        var browserVendors = ['', '-webkit-', '-moz-', '-ms-', '-o-', '-khtml-'];
        // Browser vendor DOM prefixes.
        var domPrefixes = ['', 'Webkit', 'Moz', 'ms', 'O', 'Khtml'];
        var i = domPrefixes.length;
        while (i--) {
          if (typeof document.body.style[domPrefixes[i] + prop] !== 'undefined') {
            return true;
          }
        }
        return false;
      }
		function huge_it_cube_<?php echo $sliderID; ?>(tz, ntx, nty, nrx, nry, wrx, wry, current_image_class, next_image_class, direction) {
		
        /* If browser does not support 3d transforms/CSS transitions.*/
        if (!huge_it_testBrowser_cssTransitions_<?php echo $sliderID; ?>()) {
			jQuery(".huge_it_slideshow_dots_<?php echo $sliderID; ?>").removeClass("huge_it_slideshow_dots_active_<?php echo $sliderID; ?>").addClass("huge_it_slideshow_dots_deactive_<?php echo $sliderID; ?>");
        jQuery("#huge_it_dots_" + huge_it_current_key_<?php echo $sliderID; ?> + "_<?php echo $sliderID; ?>").removeClass("huge_it_slideshow_dots_deactive_<?php echo $sliderID; ?>").addClass("huge_it_slideshow_dots_active_<?php echo $sliderID; ?>");
          return huge_it_fallback_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction);
        }
        if (!huge_it_testBrowser_cssTransforms3d_<?php echo $sliderID; ?>()) {
          return huge_it_fallback3d_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction);
        }
			//alert(current_image_class+' '+next_image_class);
		  jQuery(current_image_class).css({'z-index': 'none'});
          jQuery(next_image_class).css({'z-index' : 2});
        huge_it_trans_in_progress_<?php echo $sliderID; ?> = true;
        /* Set active thumbnail.*/
		jQuery(".huge_it_slideshow_dots_<?php echo $sliderID; ?>").removeClass("huge_it_slideshow_dots_active_<?php echo $sliderID; ?>").addClass("huge_it_slideshow_dots_deactive_<?php echo $sliderID; ?>");  
		jQuery("#huge_it_dots_" + huge_it_current_key_<?php echo $sliderID; ?> + "_<?php echo $sliderID; ?>").removeClass("huge_it_slideshow_dots_deactive_<?php echo $sliderID; ?>").addClass("huge_it_slideshow_dots_active_<?php echo $sliderID; ?>");
        jQuery(".huge_it_slide_bg_<?php echo $sliderID; ?>").css('perspective', 1000);
        jQuery(current_image_class).css({
          transform : 'translateZ(' + tz + 'px)',
          backfaceVisibility : 'hidden'
        });
		
		 jQuery(".huge_it_slideshow_image_wrap_<?php echo $sliderID; ?>,.huge_it_slide_bg_<?php echo $sliderID; ?>,.huge_it_slideshow_image_item_<?php echo $sliderID; ?>,.huge_it_slideshow_image_second_item_<?php echo $sliderID; ?> ").css('overflow', 'visible');
		
        jQuery(next_image_class).css({
          opacity : 1,
          filter: 'Alpha(opacity=100)',
          backfaceVisibility : 'hidden',
          transform : 'translateY(' + nty + 'px) translateX(' + ntx + 'px) rotateY('+ nry +'deg) rotateX('+ nrx +'deg)'
        });
        jQuery(".huge_it_slider_<?php echo $sliderID; ?>").css({
          transform: 'translateZ(-' + tz + 'px)',
          transformStyle: 'preserve-3d'
        });
        /* Execution steps.*/
        setTimeout(function () {
          jQuery(".huge_it_slider_<?php echo $sliderID; ?>").css({
            transition: 'all ' + huge_it_transition_duration_<?php echo $sliderID; ?> + 'ms ease-in-out',
            transform: 'translateZ(-' + tz + 'px) rotateX('+ wrx +'deg) rotateY('+ wry +'deg)'
          });
        }, 20);
        /* After transition.*/
        jQuery(".huge_it_slider_<?php echo $sliderID; ?>").one('webkitTransitionEnd transitionend otransitionend oTransitionEnd mstransitionend', jQuery.proxy(huge_it_after_trans));
        function huge_it_after_trans() {
          /*if (huge_it_from_focus_<?php echo $sliderID; ?>) {
            huge_it_from_focus_<?php echo $sliderID; ?> = false;
            return;
          }*/
		  jQuery(".huge_it_slide_bg_<?php echo $sliderID; ?>,.huge_it_slideshow_image_item_<?php echo $sliderID; ?>,.huge_it_slideshow_image_second_item_<?php echo $sliderID; ?> ").css('overflow', 'hidden');
		  jQuery(".huge_it_slide_bg_<?php echo $sliderID; ?>").removeAttr('style');
          jQuery(current_image_class).removeAttr('style');
          jQuery(next_image_class).removeAttr('style');
          jQuery(".huge_it_slider_<?php echo $sliderID; ?>").removeAttr('style');
		 // alert(current_image_class+' '+next_image_class);
          jQuery(current_image_class).css({'opacity' : 0, filter: 'Alpha(opacity=0)', 'z-index': 1});
          jQuery(next_image_class).css({'opacity' : 1, filter: 'Alpha(opacity=100)', 'z-index' : 2});
         // huge_it_change_watermark_container_<?php echo $sliderID; ?>();
          huge_it_trans_in_progress_<?php echo $sliderID; ?> = false;
          if (typeof event_stack_<?php echo $sliderID; ?> !== 'undefined' && event_stack_<?php echo $sliderID; ?>.length > 0) {
            key = event_stack_<?php echo $sliderID; ?>[0].split("-");
            event_stack_<?php echo $sliderID; ?>.shift();
            huge_it_change_image_<?php echo $sliderID; ?>(key[0], key[1], data_<?php echo $sliderID; ?>, true,false);
          }
        }
      }
      function huge_it_cubeH_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        /* Set to half of image width.*/
        var dimension = jQuery(current_image_class).width() / 2;
        if (direction == 'right') {
          huge_it_cube_<?php echo $sliderID; ?>(dimension, dimension, 0, 0, 90, 0, -90, current_image_class, next_image_class, direction);
        }
        else if (direction == 'left') {
          huge_it_cube_<?php echo $sliderID; ?>(dimension, -dimension, 0, 0, -90, 0, 90, current_image_class, next_image_class, direction);
        }
      }
      function huge_it_cubeV_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        /* Set to half of image height.*/
        var dimension = jQuery(current_image_class).height() / 2;
        /* If next slide.*/
        if (direction == 'right') {
          huge_it_cube_<?php echo $sliderID; ?>(dimension, 0, -dimension, 90, 0, -90, 0, current_image_class, next_image_class, direction);
        }
        else if (direction == 'left') {
          huge_it_cube_<?php echo $sliderID; ?>(dimension, 0, dimension, -90, 0, 90, 0, current_image_class, next_image_class, direction);
        }
      }
      /* For browsers that does not support transitions.*/
      function huge_it_fallback_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        huge_it_fade_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction);
      }
      /* For browsers that support transitions, but not 3d transforms (only used if primary transition makes use of 3d-transforms).*/
      function huge_it_fallback3d_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        huge_it_sliceV_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction);
      }
      function huge_it_none_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        jQuery(current_image_class).css({'opacity' : 0, 'z-index': 1});
        jQuery(next_image_class).css({'opacity' : 1, 'z-index' : 2});

        /* Set active thumbnail.*/
        jQuery(".huge_it_slideshow_dots_<?php echo $sliderID; ?>").removeClass("huge_it_slideshow_dots_active_<?php echo $sliderID; ?>").addClass("huge_it_slideshow_dots_deactive_<?php echo $sliderID; ?>");
        jQuery("#huge_it_dots_" + huge_it_current_key_<?php echo $sliderID; ?> + "_<?php echo $sliderID; ?>").removeClass("huge_it_slideshow_dots_deactive_<?php echo $sliderID; ?>").addClass("huge_it_slideshow_dots_active_<?php echo $sliderID; ?>");
      }
      function huge_it_fade_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
		if (huge_it_testBrowser_cssTransitions_<?php echo $sliderID; ?>()) {
			
          jQuery(next_image_class).css('transition', 'opacity ' + huge_it_transition_duration_<?php echo $sliderID; ?> + 'ms linear');
		  jQuery(current_image_class).css('transition', 'opacity ' + huge_it_transition_duration_<?php echo $sliderID; ?> + 'ms linear');
          jQuery(current_image_class).css({'opacity' : 0, 'z-index': 1});
          jQuery(next_image_class).css({'opacity' : 1, 'z-index' : 2});
        }
        else {
		
          jQuery(current_image_class).animate({'opacity' : 0, 'z-index' : 1}, huge_it_transition_duration_<?php echo $sliderID; ?>);
          jQuery(next_image_class).animate({
              'opacity' : 1,
              'z-index': 2
            }, {
              duration: huge_it_transition_duration_<?php echo $sliderID; ?>,
              complete: function () {return false;}
            });
          // For IE.
          jQuery(current_image_class).fadeTo(huge_it_transition_duration_<?php echo $sliderID; ?>, 0);
          jQuery(next_image_class).fadeTo(huge_it_transition_duration_<?php echo $sliderID; ?>, 1);
        }

		jQuery(".huge_it_slideshow_dots_<?php echo $sliderID; ?>").removeClass("huge_it_slideshow_dots_active_<?php echo $sliderID; ?>").addClass("huge_it_slideshow_dots_deactive_<?php echo $sliderID; ?>");
		jQuery("#huge_it_dots_" + huge_it_current_key_<?php echo $sliderID; ?> + "_<?php echo $sliderID; ?>").removeClass("huge_it_slideshow_dots_deactive_<?php echo $sliderID; ?>").addClass("huge_it_slideshow_dots_active_<?php echo $sliderID; ?>");
      }
      function huge_it_grid_<?php echo $sliderID; ?>(cols, rows, ro, tx, ty, sc, op, current_image_class, next_image_class, direction) {
        /* If browser does not support CSS transitions.*/
        if (!huge_it_testBrowser_cssTransitions_<?php echo $sliderID; ?>()) {
			jQuery(".huge_it_slideshow_dots_<?php echo $sliderID; ?>").removeClass("huge_it_slideshow_dots_active_<?php echo $sliderID; ?>").addClass("huge_it_slideshow_dots_deactive_<?php echo $sliderID; ?>");
        jQuery("#huge_it_dots_" + huge_it_current_key_<?php echo $sliderID; ?> + "_<?php echo $sliderID; ?>").removeClass("huge_it_slideshow_dots_deactive_<?php echo $sliderID; ?>").addClass("huge_it_slideshow_dots_active_<?php echo $sliderID; ?>");
          return huge_it_fallback_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction);
		  
        }
        huge_it_trans_in_progress_<?php echo $sliderID; ?> = true;
        /* Set active thumbnail.*/
		jQuery(".huge_it_slideshow_dots_<?php echo $sliderID; ?>").removeClass("huge_it_slideshow_dots_active_<?php echo $sliderID; ?>").addClass("huge_it_slideshow_dots_deactive_<?php echo $sliderID; ?>");
        jQuery("#huge_it_dots_" + huge_it_current_key_<?php echo $sliderID; ?> + "_<?php echo $sliderID; ?>").removeClass("huge_it_slideshow_dots_deactive_<?php echo $sliderID; ?>").addClass("huge_it_slideshow_dots_active_<?php echo $sliderID; ?>");
        /* The time (in ms) added to/subtracted from the delay total for each new gridlet.*/
        var count = (huge_it_transition_duration_<?php echo $sliderID; ?>) / (cols + rows);
        /* Gridlet creator (divisions of the image grid, positioned with background-images to replicate the look of an entire slide image when assembled)*/
        function huge_it_gridlet(width, height, top, img_top, left, img_left, src, imgWidth, imgHeight, c, r) {
          var delay = (c + r) * count;
          /* Return a gridlet elem with styles for specific transition.*/
          return jQuery('<div class="huge_it_gridlet_<?php echo $sliderID; ?>" />').css({
            width : width,
            height : height,
            top : top,
            left : left,
            backgroundImage : 'url("' + src + '")',
            backgroundColor: jQuery(".huge_it_slideshow_image_wrap_<?php echo $sliderID; ?>").css("background-color"),
            /*backgroundColor: rgba(0, 0, 0, 0),*/
            backgroundRepeat: 'no-repeat',
            backgroundPosition : img_left + 'px ' + img_top + 'px',
            backgroundSize : imgWidth + 'px ' + imgHeight + 'px',
            transition : 'all ' + huge_it_transition_duration_<?php echo $sliderID; ?> + 'ms ease-in-out ' + delay + 'ms',
            transform : 'none'
          });
        }
        /* Get the current slide's image.*/
        var cur_img = jQuery(current_image_class).find('img');
        /* Create a grid to hold the gridlets.*/
        var grid = jQuery('<div />').addClass('huge_it_grid_<?php echo $sliderID; ?>');
        /* Prepend the grid to the next slide (i.e. so it's above the slide image).*/
        jQuery(current_image_class).prepend(grid);
        /* vars to calculate positioning/size of gridlets*/
        var cont = jQuery(".huge_it_slide_bg_<?php echo $sliderID; ?>");
        var imgWidth = cur_img.width();
        var imgHeight = cur_img.height();
        var contWidth = cont.width(),
            contHeight = cont.height(),
            imgSrc = cur_img.attr('src'),/*.replace('/thumb', ''),*/
            colWidth = Math.floor(contWidth / cols),
            rowHeight = Math.floor(contHeight / rows),
            colRemainder = contWidth - (cols * colWidth),
            colAdd = Math.ceil(colRemainder / cols),
            rowRemainder = contHeight - (rows * rowHeight),
            rowAdd = Math.ceil(rowRemainder / rows),
            leftDist = 0,
            img_leftDist = (jQuery(".huge_it_slide_bg_<?php echo $sliderID; ?>").width() - cur_img.width()) / 2;
        /* tx/ty args can be passed as 'auto'/'min-auto' (meaning use slide width/height or negative slide width/height).*/
        tx = tx === 'auto' ? contWidth : tx;
        tx = tx === 'min-auto' ? - contWidth : tx;
        ty = ty === 'auto' ? contHeight : ty;
        ty = ty === 'min-auto' ? - contHeight : ty;
        /* Loop through cols*/
        for (var i = 0; i < cols; i++) {
          var topDist = 0,
              img_topDst = (jQuery(".huge_it_slide_bg_<?php echo $sliderID; ?>").height() - cur_img.height()) / 2,
              newColWidth = colWidth;
          /* If imgWidth (px) does not divide cleanly into the specified number of cols, adjust individual col widths to create correct total.*/
          if (colRemainder > 0) {
            var add = colRemainder >= colAdd ? colAdd : colRemainder;
            newColWidth += add;
            colRemainder -= add;
          }
          /* Nested loop to create row gridlets for each col.*/
          for (var j = 0; j < rows; j++)  {
            var newRowHeight = rowHeight,
                newRowRemainder = rowRemainder;
            /* If contHeight (px) does not divide cleanly into the specified number of rows, adjust individual row heights to create correct total.*/
            if (newRowRemainder > 0) {
              add = newRowRemainder >= rowAdd ? rowAdd : rowRemainder;
              newRowHeight += add;
              newRowRemainder -= add;
            }
            /* Create & append gridlet to grid.*/
            grid.append(huge_it_gridlet(newColWidth, newRowHeight, topDist, img_topDst, leftDist, img_leftDist, imgSrc, imgWidth, imgHeight, i, j));
            topDist += newRowHeight;
            img_topDst -= newRowHeight;
          }
          img_leftDist -= newColWidth;
          leftDist += newColWidth;
        }
        /* Set event listener on last gridlet to finish transitioning.*/
        var last_gridlet = grid.children().last();
        /* Show grid & hide the image it replaces.*/
        grid.show();
        cur_img.css('opacity', 0);
        /* Add identifying classes to corner gridlets (useful if applying border radius).*/
        grid.children().first().addClass('rs-top-left');
        grid.children().last().addClass('rs-bottom-right');
        grid.children().eq(rows - 1).addClass('rs-bottom-left');
        grid.children().eq(- rows).addClass('rs-top-right');
        /* Execution steps.*/
        setTimeout(function () {
          grid.children().css({
            opacity: op,
            transform: 'rotate('+ ro +'deg) translateX('+ tx +'px) translateY('+ ty +'px) scale('+ sc +')'
          });
        }, 1);
        jQuery(next_image_class).css('opacity', 1);
        /* After transition.*/
        jQuery(last_gridlet).one('webkitTransitionEnd transitionend otransitionend oTransitionEnd mstransitionend', jQuery.proxy(huge_it_after_trans));
        function huge_it_after_trans() {
          jQuery(current_image_class).css({'opacity' : 0, 'z-index': 1});
          jQuery(next_image_class).css({'opacity' : 1, 'z-index' : 2});
          cur_img.css('opacity', 1);
          grid.remove();
          huge_it_trans_in_progress_<?php echo $sliderID; ?> = false;
          if (typeof event_stack_<?php echo $sliderID; ?> !== 'undefined' && event_stack_<?php echo $sliderID; ?>.length > 0) {
            key = event_stack_<?php echo $sliderID; ?>[0].split("-");
            event_stack_<?php echo $sliderID; ?>.shift();
            huge_it_change_image_<?php echo $sliderID; ?>(key[0], key[1], data_<?php echo $sliderID; ?>, true,false);
          }
        }
      }
      function huge_it_sliceH_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        if (direction == 'right') {
          var translateX = 'min-auto';
        }
        else if (direction == 'left') {
          var translateX = 'auto';
        }
        huge_it_grid_<?php echo $sliderID; ?>(1, 8, 0, translateX, 0, 1, 0, current_image_class, next_image_class, direction);
      }
      function huge_it_sliceV_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        if (direction == 'right') {
          var translateY = 'min-auto';
        }
        else if (direction == 'left') {
          var translateY = 'auto';
        }
        huge_it_grid_<?php echo $sliderID; ?>(10, 1, 0, 0, translateY, 1, 0, current_image_class, next_image_class, direction);
      }
      function huge_it_slideV_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        if (direction == 'right') {
          var translateY = 'auto';
        }
        else if (direction == 'left') {
          var translateY = 'min-auto';
        }
        huge_it_grid_<?php echo $sliderID; ?>(1, 1, 0, 0, translateY, 1, 1, current_image_class, next_image_class, direction);
      }
      function huge_it_slideH_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        if (direction == 'right') {
          var translateX = 'min-auto';
        }
        else if (direction == 'left') {
          var translateX = 'auto';
        }
        huge_it_grid_<?php echo $sliderID; ?>(1, 1, 0, translateX, 0, 1, 1, current_image_class, next_image_class, direction);
      }
      function huge_it_scaleOut_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        huge_it_grid_<?php echo $sliderID; ?>(1, 1, 0, 0, 0, 1.5, 0, current_image_class, next_image_class, direction);
      }
      function huge_it_scaleIn_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        huge_it_grid_<?php echo $sliderID; ?>(1, 1, 0, 0, 0, 0.5, 0, current_image_class, next_image_class, direction);
      }
      function huge_it_blockScale_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        huge_it_grid_<?php echo $sliderID; ?>(8, 6, 0, 0, 0, .6, 0, current_image_class, next_image_class, direction);
      }
      function huge_it_kaleidoscope_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        huge_it_grid_<?php echo $sliderID; ?>(10, 8, 0, 0, 0, 1, 0, current_image_class, next_image_class, direction);
      }
      function huge_it_fan_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        if (direction == 'right') {
          var rotate = 45;
          var translateX = 100;
        }
        else if (direction == 'left') {
          var rotate = -45;
          var translateX = -100;
        }
        huge_it_grid_<?php echo $sliderID; ?>(1, 10, rotate, translateX, 0, 1, 0, current_image_class, next_image_class, direction);
      }
      function huge_it_blindV_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        huge_it_grid_<?php echo $sliderID; ?>(1, 8, 0, 0, 0, .7, 0, current_image_class, next_image_class);
      }
      function huge_it_blindH_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        huge_it_grid_<?php echo $sliderID; ?>(10, 1, 0, 0, 0, .7, 0, current_image_class, next_image_class);
      }
      function huge_it_random_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction) {
        var anims = ['sliceH', 'sliceV', 'slideH', 'slideV', 'scaleOut', 'scaleIn', 'blockScale', 'kaleidoscope', 'fan', 'blindH', 'blindV'];
        /* Pick a random transition from the anims array.*/
        this["huge_it_" + anims[Math.floor(Math.random() * anims.length)] + "_<?php echo $sliderID; ?>"](current_image_class, next_image_class, direction);
      }
      
      function iterator_<?php echo $sliderID; ?>() {
        var iterator = 1;

        return iterator;
     }
	 
     function huge_it_change_image_<?php echo $sliderID; ?>(current_key, key, data_<?php echo $sliderID; ?>, from_effect,clicked) {
		
        if (data_<?php echo $sliderID; ?>[key]) {
		
			if(video_is_playing_<?php echo $sliderID; ?> && !clicked){
				return false;
			}
         
		 
		 
          if (!from_effect) {
            // Change image key.
            jQuery("#huge_it_current_image_key_<?php echo $sliderID; ?>").val(key);
             // if (current_key == '-2') { /* Dots.*/
				current_key = jQuery(".huge_it_slideshow_dots_active_<?php echo $sliderID; ?>").attr("image_key");
			//  }
          }

          if (huge_it_trans_in_progress_<?php echo $sliderID; ?>) {
			//errorlogjQuery(".huge_it_slideshow_image_wrap_<?php echo $sliderID; ?>").after(" --IN TRANSACTION-- <br />");
            event_stack_<?php echo $sliderID; ?>.push(current_key + '-' + key);
            return;
          }
		  
          var direction = 'right';
          if (huge_it_current_key_<?php echo $sliderID; ?> > key) {
            var direction = 'left';
          }
          else if (huge_it_current_key_<?php echo $sliderID; ?> == key) {
            return false;
          }
         
          // Set active thumbnail position.
      
          huge_it_current_key_<?php echo $sliderID; ?> = key;
          //Change image id, title, description.
          jQuery("#huge_it_slideshow_image_<?php echo $sliderID; ?>").attr('image_id', data_<?php echo $sliderID; ?>[key]["id"]);
		  
		  
		  jQuery(".huge_it_slideshow_title_text_<?php echo $sliderID; ?>").html(data_<?php echo $sliderID; ?>[key]["alt"]);
          jQuery(".huge_it_slideshow_description_text_<?php echo $sliderID; ?>").html(data_<?php echo $sliderID; ?>[key]["description"]);
        
		  var current_image_class = "#image_id_<?php echo $sliderID; ?>_" + data_<?php echo $sliderID; ?>[current_key]["id"];
          var next_image_class = "#image_id_<?php echo $sliderID; ?>_" + data_<?php echo $sliderID; ?>[key]["id"];
          
		  
		
		 if(jQuery(current_image_class).find('.huge_it_video_frame_<?php echo $sliderID; ?>').length>0) {
			var streffect='<?php echo $slidereffect; ?>';
			if(streffect=="cubeV" || streffect=="cubeH" || streffect=="none" || streffect=="fade"){
				huge_it_<?php echo $slidereffect; ?>_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction);
			}else{	
				huge_it_fade_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction);
			}	
		  }else{	
				huge_it_<?php echo $slidereffect; ?>_<?php echo $sliderID; ?>(current_image_class, next_image_class, direction);
		  }	
		  
		  
		jQuery('.huge_it_slideshow_title_text_<?php echo $sliderID; ?>').removeClass('none');
		if(jQuery('.huge_it_slideshow_title_text_<?php echo $sliderID; ?>').html()==""){jQuery('.huge_it_slideshow_title_text_<?php echo $sliderID; ?>').addClass('none');}

		jQuery('.huge_it_slideshow_description_text_<?php echo $sliderID; ?>').removeClass('none');
		if(jQuery('.huge_it_slideshow_description_text_<?php echo $sliderID; ?>').html()==""){jQuery('.huge_it_slideshow_description_text_<?php echo $sliderID; ?>').addClass('none');}
	  
		  
		  
		  jQuery(current_image_class).find('.huge_it_slideshow_title_text_<?php echo $sliderID; ?>').addClass('none');
		  jQuery(current_image_class).find('.huge_it_slideshow_description_text_<?php echo $sliderID; ?>').addClass('none');
		
		

		  
		  //errorlogjQuery(".huge_it_slideshow_image_wrap_<?php echo $sliderID; ?>").after("--cur-key="+current_key+" --cur-img-class="+current_image_class+" nxt-img-class="+next_image_class+"--");
			 huge_it_move_dots_<?php echo $sliderID; ?>();
			<?php foreach ($images as $key => $image_row) {if($image_row->sl_type=="video" and strpos($image_row->image_url,'youtube') !== false){	?>
				stopYoutubeVideo();
			<?php } } ?>
			window.clearInterval(huge_it_playInterval_<?php echo $sliderID; ?>);
			play_<?php echo $sliderID; ?>();
        }

      }
	  
      function huge_it_popup_resize_<?php echo $sliderID; ?>() {

		var staticsliderwidth=<?php echo $sliderwidth;?>;
		var sliderwidth=<?php echo $sliderwidth;?>;
		
		var bodyWidth=jQuery(window).width();
        var parentWidth = jQuery(".huge_it_slideshow_image_wrap_<?php echo $sliderID; ?>").parent().width();
		//if responsive js late responsive.js @  take body size and not parent div
		if(sliderwidth>parentWidth){sliderwidth=parentWidth;}
		if(sliderwidth>bodyWidth){sliderwidth=bodyWidth;}
		
		var str=(<?php echo $sliderheight;?>/staticsliderwidth);
		
		jQuery(".huge_it_slideshow_image_wrap_<?php echo $sliderID; ?>").css({width: (sliderwidth)});
		jQuery(".huge_it_slideshow_image_wrap_<?php echo $sliderID; ?>").css({height: ((sliderwidth) * str)});
		jQuery(".huge_it_slideshow_image_container_<?php echo $sliderID; ?>").css({width: (sliderwidth)});
		jQuery(".huge_it_slideshow_image_container_<?php echo $sliderID; ?>").css({height: ((sliderwidth) * str)});
			
		if("<?php echo $slideshow_title_position[1]; ?>"=="middle"){var titlemargintopminus=jQuery(".huge_it_slideshow_title_text_<?php echo $sliderID; ?>").outerHeight()/2;}		
		if("<?php echo $slideshow_title_position[0]; ?>"=="center"){var titlemarginleftminus=jQuery(".huge_it_slideshow_title_text_<?php echo $sliderID; ?>").outerWidth()/2;}		
		jQuery(".huge_it_slideshow_title_text_<?php echo $sliderID; ?>").css({cssText: "margin-top:-" + titlemargintopminus + "px; margin-left:-"+titlemarginleftminus+"px;"});
		
		if("<?php echo $slideshow_description_position[1]; ?>"=="middle"){var descriptionmargintopminus=jQuery(".huge_it_slideshow_description_text_<?php echo $sliderID; ?>").outerHeight()/2;}	
		if("<?php echo $slideshow_description_position[0]; ?>"=="center"){var descriptionmarginleftminus=jQuery(".huge_it_slideshow_description_text_<?php echo $sliderID; ?>").outerWidth()/2;}
		jQuery(".huge_it_slideshow_description_text_<?php echo $sliderID; ?>").css({cssText: "margin-top:-" + descriptionmargintopminus + "px; margin-left:-"+descriptionmarginleftminus+"px;"});		
		
		
		if("<?php echo $paramssld['slider_crop_image']; ?>"=="resize"){
			jQuery(".huge_it_slideshow_image_<?php echo $sliderID; ?>,  .huge_it_slideshow_image_container_<?php echo $sliderID; ?> img").css({
				cssText: "width:" + sliderwidth + "px; height:" + ((sliderwidth) * str)	+"px;"
			});
		}else {
			jQuery(".huge_it_slideshow_image_<?php echo $sliderID; ?>,.huge_it_slideshow_image_item2_<?php echo $sliderID; ?>").css({
			cssText: "max-width: " + sliderwidth + "px !important; max-height: " + (sliderwidth * str) + "px !important;"
		  });
		}
		
		jQuery('.huge_it_video_frame_<?php echo $sliderID; ?>').each(function (e) {
          jQuery(this).width(sliderwidth);
          jQuery(this).height(sliderwidth * str);
        });
      }
      
      jQuery(window).load(function () {
		jQuery(window).resize(function() {
			huge_it_popup_resize_<?php echo $sliderID; ?>();
		});
		
		jQuery('#huge_it_slideshow_left_<?php echo $sliderID; ?>').on('click',function(){
			huge_it_change_image_<?php echo $sliderID; ?>(parseInt(jQuery('#huge_it_current_image_key_<?php echo $sliderID; ?>').val()), (parseInt(jQuery('#huge_it_current_image_key_<?php echo $sliderID; ?>').val()) - iterator_<?php echo $sliderID; ?>()) >= 0 ? (parseInt(jQuery('#huge_it_current_image_key_<?php echo $sliderID; ?>').val()) - iterator_<?php echo $sliderID; ?>()) % data_<?php echo $sliderID; ?>.length : data_<?php echo $sliderID; ?>.length - 1, data_<?php echo $sliderID; ?>,false,true);
			return false;
		});
		
		jQuery('#huge_it_slideshow_right_<?php echo $sliderID; ?>').on('click',function(){
			huge_it_change_image_<?php echo $sliderID; ?>(parseInt(jQuery('#huge_it_current_image_key_<?php echo $sliderID; ?>').val()), (parseInt(jQuery('#huge_it_current_image_key_<?php echo $sliderID; ?>').val()) + iterator_<?php echo $sliderID; ?>()) % data_<?php echo $sliderID; ?>.length, data_<?php echo $sliderID; ?>,false,true);
			return false;
		});
		
		huge_it_popup_resize_<?php echo $sliderID; ?>();
        /* Disable right click.*/
        jQuery('div[id^="huge_it_container"]').bind("contextmenu", function () {
          return false;
        });
        			
		/*HOVER SLIDESHOW*/
		jQuery("#huge_it_slideshow_image_container_<?php echo $sliderID; ?>, .huge_it_slideshow_image_container_<?php echo $sliderID; ?>, .huge_it_slideshow_dots_container_<?php echo $sliderID; ?>,#huge_it_slideshow_right_<?php echo $sliderID; ?>,#huge_it_slideshow_left_<?php echo $sliderID; ?>").hover(function(){
			//errorlogjQuery(".huge_it_slideshow_image_wrap_<?php echo $sliderID; ?>").after(" -- hover -- <br /> ");
			jQuery("#huge_it_slideshow_right_<?php echo $sliderID; ?>").css({'display':'inline'});
			jQuery("#huge_it_slideshow_left_<?php echo $sliderID; ?>").css({'display':'inline'});
		},function(){
			jQuery("#huge_it_slideshow_right_<?php echo $sliderID; ?>").css({'display':'none'});
			jQuery("#huge_it_slideshow_left_<?php echo $sliderID; ?>").css({'display':'none'});
		});
		var pausehover="<?php echo $sliderpauseonhover;?>";
		if(pausehover=="on"){
			jQuery("#huge_it_slideshow_image_container_<?php echo $sliderID; ?>, .huge_it_slideshow_image_container_<?php echo $sliderID; ?>, .huge_it_slideshow_dots_container_<?php echo $sliderID; ?>,#huge_it_slideshow_right_<?php echo $sliderID; ?>,#huge_it_slideshow_left_<?php echo $sliderID; ?>").hover(function(){
				window.clearInterval(huge_it_playInterval_<?php echo $sliderID; ?>);
			},function(){
				window.clearInterval(huge_it_playInterval_<?php echo $sliderID; ?>);
				play_<?php echo $sliderID; ?>();
			});		
		}	
          play_<?php echo $sliderID; ?>();        
      });

      function play_<?php echo $sliderID; ?>() {	   
        /* Play.*/
		//errorlogjQuery(".huge_it_slideshow_image_wrap_<?php echo $sliderID; ?>").after(" -- paly  ---- ");
        huge_it_playInterval_<?php echo $sliderID; ?> = setInterval(function () {
			//errorlogjQuery(".huge_it_slideshow_image_wrap_<?php echo $sliderID; ?>").after(" -- time left ---- ");
          var iterator = 1;
          huge_it_change_image_<?php echo $sliderID; ?>(parseInt(jQuery('#huge_it_current_image_key_<?php echo $sliderID; ?>').val()), (parseInt(jQuery('#huge_it_current_image_key_<?php echo $sliderID; ?>').val()) + iterator) % data_<?php echo $sliderID; ?>.length, data_<?php echo $sliderID; ?>,false,false);
        }, '<?php echo $slidepausetime; ?>');
      }
	  
      jQuery(window).focus(function() {
       /*event_stack_<?php echo $sliderID; ?> = [];*/
        var i_<?php echo $sliderID; ?> = 0;
        jQuery(".huge_it_slider_<?php echo $sliderID; ?>").children("div").each(function () {
          if (jQuery(this).css('opacity') == 1) {
            jQuery("#huge_it_current_image_key_<?php echo $sliderID; ?>").val(i_<?php echo $sliderID; ?>);
          }
          i_<?php echo $sliderID; ?>++;
        });
      });
      jQuery(window).blur(function() {
        event_stack_<?php echo $sliderID; ?> = [];
        window.clearInterval(huge_it_playInterval_<?php echo $sliderID; ?>);
      });      
    </script>
	<style>				
	 .huge_it_slideshow_image_wrap_<?php echo $sliderID; ?> {
		height:<?php echo $sliderheight; ?>px;
		width:<?php  echo $sliderwidth; ?>px;
		position:relative;
		display: block;
		text-align: center;
		/*HEIGHT FROM HEADER.PHP*/
		clear:both;
		<?php if($sliderposition=="left"){ $position='float:left;';}elseif($sliderposition=="right"){$position='float:right;';}else{$position='float:none; margin:0px auto;';} ?>
		<?php echo $position;  ?>
		
		border-style:solid;
		border-left:0px !important;
		border-right:0px !important;
	}


	.huge_it_slideshow_image_wrap_<?php echo $sliderID; ?> * {
		box-sizing: border-box;
		-moz-box-sizing: border-box;
		-webkit-box-sizing: border-box;
	}
		 

	  .huge_it_slideshow_image_<?php echo $sliderID; ?> {
			/*width:100%;*/
	  }

	  #huge_it_slideshow_left_<?php echo $sliderID; ?>,
	  #huge_it_slideshow_right_<?php echo $sliderID; ?> {
		cursor: pointer;
		display:none;
		display: block;
		
		height: 100%;
		outline: medium none;
		position: absolute;

		/*z-index: 10130;*/
		z-index: 13;
		bottom:25px;
		top:50%;		
	  }
	 

	  #huge_it_slideshow_left-ico_<?php echo $sliderID; ?>,
	  #huge_it_slideshow_right-ico_<?php echo $sliderID; ?> {
		z-index: 13;
		-moz-box-sizing: content-box;
		box-sizing: content-box;
		cursor: pointer;
		display: table;
		left: -9999px;
		line-height: 0;
		margin-top: -15px;
		position: absolute;
		top: 50%;
		/*z-index: 10135;*/
	  }
	  #huge_it_slideshow_left-ico_<?php echo $sliderID; ?>:hover,
	  #huge_it_slideshow_right-ico_<?php echo $sliderID; ?>:hover {
		cursor: pointer;
	  }
	  
	  .huge_it_slideshow_image_container_<?php echo $sliderID; ?> {
		display: table;
		position: relative;
		top:0px;
		left:0px;
		text-align: center;
		vertical-align: middle;
		width:100%;
	  }	  
		
	  .huge_it_slideshow_title_text_<?php echo $sliderID; ?> {
		text-decoration: none;
		position: absolute;
		z-index: 11;
		display: inline-block;
		<?php  if($paramssld['slider_title_has_margin']=='on'){
				$slider_title_width=($paramssld['slider_title_width']-6);
				$slider_title_height=($paramssld['slider_title_height']-6);
				$slider_title_margin="3";
			}else{
				$slider_title_width=($paramssld['slider_title_width']);
				$slider_title_height=($paramssld['slider_title_height']);
				$slider_title_margin="0";
			}  ?>
		
		width:<?php echo $slider_title_width; ?>%;
		/*height:<?php echo $slider_title_height; ?>%;*/
		
		<?php 
			if($slideshow_title_position[0]=="left"){echo 'left:'.$slider_title_margin.'%;';}
			elseif($slideshow_title_position[0]=="center"){echo 'left:50%;';}
			elseif($slideshow_title_position[0]=="right"){echo 'right:'.$slider_title_margin.'%;';}
			
			if($slideshow_title_position[1]=="top"){echo 'top:'.$slider_title_margin.'%;';}
			elseif($slideshow_title_position[1]=="middle"){echo 'top:50%;';}
			elseif($slideshow_title_position[1]=="bottom"){echo 'bottom:'.$slider_title_margin.'%;';}
		 ?>
		padding:2%;
		text-align:<?php echo $paramssld['slider_title_text_align']; ?>;  
		font-weight:bold;
		color:#<?php echo $paramssld['slider_title_color']; ?>;
			
		background:<?php 			
				list($r,$g,$b) = array_map('hexdec',str_split($paramssld['slider_title_background_color'],2));
				$titleopacity=$paramssld["slider_title_background_transparency"]/100;						
				echo 'rgba('.$r.','.$g.','.$b.','.$titleopacity.')  !important'; 		
		?>;
		border-style:solid;
		font-size:<?php echo $paramssld['slider_title_font_size']; ?>px;
		border-width:<?php echo $paramssld['slider_title_border_size']; ?>px;
		border-color:#<?php echo $paramssld['slider_title_border_color']; ?>;
		border-radius:<?php echo $paramssld['slider_title_border_radius']; ?>px;
	  }
	  	  
	  .huge_it_slideshow_description_text_<?php echo $sliderID; ?> {
		text-decoration: none;
		position: absolute;
		z-index: 11;
		border-style:solid;
		display: inline-block;
		<?php  if($paramssld['slider_description_has_margin']=='on'){
				$slider_description_width=($paramssld['slider_description_width']-6);
				$slider_description_height=($paramssld['slider_description_height']-6);
				$slider_description_margin="3";
			}else{
				$slider_description_width=($paramssld['slider_description_width']);
				$slider_descriptione_height=($paramssld['slider_description_height']);
				$slider_description_margin="0";
			}  ?>
		
		width:<?php echo $slider_description_width; ?>%;
		/*height:<?php echo $slider_description_height; ?>%;*/
		<?php 
			if($slideshow_description_position[0]=="left"){echo 'left:'.$slider_description_margin.'%;';}
			elseif($slideshow_description_position[0]=="center"){echo 'left:50%;';}
			elseif($slideshow_description_position[0]=="right"){echo 'right:'.$slider_description_margin.'%;';}
			
			if($slideshow_description_position[1]=="top"){echo 'top:'.$slider_description_margin.'%;';}
			elseif($slideshow_description_position[1]=="middle"){echo 'top:50%;';}
			elseif($slideshow_description_position[1]=="bottom"){echo 'bottom:'.$slider_description_margin.'%;';}
		 ?>
		padding:3%;
		text-align:<?php echo $paramssld['slider_description_text_align']; ?>;  
		color:#<?php echo $paramssld['slider_description_color']; ?>;
		
		background:<?php 
			list($r,$g,$b) = array_map('hexdec',str_split($paramssld['slider_description_background_color'],2));	
			$descriptionopacity=$paramssld["slider_description_background_transparency"]/100;
			echo 'rgba('.$r.','.$g.','.$b.','.$descriptionopacity.') !important';
		?>;
		border-style:solid;
		font-size:<?php echo $paramssld['slider_description_font_size']; ?>px;
		border-width:<?php echo $paramssld['slider_description_border_size']; ?>px;
		border-color:#<?php echo $paramssld['slider_description_border_color']; ?>;
		border-radius:<?php echo $paramssld['slider_description_border_radius']; ?>px;
	  }
	  
	   .huge_it_slideshow_title_text_<?php echo $sliderID; ?>.none, .huge_it_slideshow_description_text_<?php echo $sliderID; ?>.none,
	   .huge_it_slideshow_title_text_<?php echo $sliderID; ?>.hidden, .huge_it_slideshow_description_text_<?php echo $sliderID; ?>.hidden	   {display:none;}
	      
	   .huge_it_slideshow_title_text_<?php echo $sliderID; ?> h1, .huge_it_slideshow_description_text_<?php echo $sliderID; ?> h1,
	   .huge_it_slideshow_title_text_<?php echo $sliderID; ?> h2, .huge_it_slideshow_title_text_<?php echo $sliderID; ?> h2,
	   .huge_it_slideshow_title_text_<?php echo $sliderID; ?> h3, .huge_it_slideshow_title_text_<?php echo $sliderID; ?> h3,
	   .huge_it_slideshow_title_text_<?php echo $sliderID; ?> h4, .huge_it_slideshow_title_text_<?php echo $sliderID; ?> h4,
	   .huge_it_slideshow_title_text_<?php echo $sliderID; ?> p, .huge_it_slideshow_title_text_<?php echo $sliderID; ?> p,
	   .huge_it_slideshow_title_text_<?php echo $sliderID; ?> strong,  .huge_it_slideshow_title_text_<?php echo $sliderID; ?> strong,
	   .huge_it_slideshow_title_text_<?php echo $sliderID; ?> span, .huge_it_slideshow_title_text_<?php echo $sliderID; ?> span,
	   .huge_it_slideshow_title_text_<?php echo $sliderID; ?> ul, .huge_it_slideshow_title_text_<?php echo $sliderID; ?> ul,
	   .huge_it_slideshow_title_text_<?php echo $sliderID; ?> li, .huge_it_slideshow_title_text_<?php echo $sliderID; ?> li {
			padding:2px;
			margin:0px;
	   }

	  .huge_it_slide_container_<?php echo $sliderID; ?> {
		display: table-cell;
		margin: 0 auto;
		position: relative;
		vertical-align: middle;
		width:100%;
		height:100%;
		_width: inherit;
		_height: inherit;
	  }
	  .huge_it_slide_bg_<?php echo $sliderID; ?> {
		margin: 0 auto;
		width:100%;
		height:100%;
		_width: inherit;
		_height: inherit;
	  }
	  .huge_it_slider_<?php echo $sliderID; ?> {
		width:100%;
		height:100%;
		display:table !important;
		padding:0px !important;
		margin:0px !important;
		
	  }
	  .huge_it_slideshow_image_item_<?php echo $sliderID; ?> {
		width:100%;
		height:100%;
		_width: inherit;
		_height: inherit;
		display: table-cell;
		filter: Alpha(opacity=100);
		opacity: 1;
		position: absolute;
		top:0px !important;
		left:0px !important;
		vertical-align: middle;
		z-index: 1;
		margin:0px !important;
		padding:0px  !important;
		border-radius: <?php echo $paramssld['slider_slideshow_border_radius']; ?>px !important;
	  }
	  .huge_it_slideshow_image_second_item_<?php echo $sliderID; ?> {
		width:100%;
		height:100%;
		_width: inherit;
		_height: inherit;
		display: table-cell;
		filter: Alpha(opacity=0);
		opacity: 0;
		position: absolute;
		top:0px !important;
		left:0px !important;
		vertical-align: middle;
		overflow:hidden;
		margin:0px !important;
		visibility:visible !important;
		padding:0px  !important;
		border-radius: <?php echo $paramssld['slider_slideshow_border_radius']; ?>px !important;
	  }
	  
	   .huge_it_slideshow_image_second_item_<?php echo $sliderID; ?> a, .huge_it_slideshow_image_item_<?php echo $sliderID; ?> a {
			display:block;
			width:100%;
			height:100%;	
	   }
	   
	  .huge_it_grid_<?php echo $sliderID; ?> {
		display: none;
		height: 100%;
		overflow: hidden;
		position: absolute;
		width: 100%;
	  }
	  .huge_it_gridlet_<?php echo $sliderID; ?> {
		opacity: 1;
		filter: Alpha(opacity=100);
		position: absolute;
	  }
	  
					
	  .huge_it_slideshow_dots_container_<?php echo $sliderID; ?> {
		display: table;
		position: absolute;
		width:100% !important;
		height:100% !important;
	  }
	  .huge_it_slideshow_dots_thumbnails_<?php echo $sliderID; ?> {
		margin: 0 auto;
		overflow: hidden;
		position: absolute;
		width:100%;
		height:30px;
	  }
	  
	  .huge_it_slideshow_dots_<?php echo $sliderID; ?> {
		display: inline-block;
		position: relative;
		cursor: pointer;
		box-shadow: 1px 1px 1px rgba(0,0,0,0.1) inset, 1px 1px 1px rgba(255,255,255,0.1);
		width:10px;
		height: 10px;
		border-radius: 10px;
		background: #00f;
		margin: 10px;
		overflow: hidden;
		z-index: 17;
	  }
	  
	  .huge_it_slideshow_dots_active_<?php echo $sliderID; ?> {
		opacity: 1;
		filter: Alpha(opacity=100);
	  }
	  .huge_it_slideshow_dots_deactive_<?php echo $sliderID; ?> {
	  
	  }
	  
	
		
		.huge_it_slideshow_image_wrap_<?php echo $sliderID; ?> {
			background:#<?php echo $paramssld['slider_slider_background_color']; ?>;
			border-width:<?php echo $paramssld['slider_slideshow_border_size']; ?>px;
			border-color:#<?php echo $paramssld['slider_slideshow_border_color']; ?>;
			border-radius:<?php echo $paramssld['slider_slideshow_border_radius']; ?>px;
		}
		
		.huge_it_slideshow_dots_thumbnails_<?php echo $sliderID; ?> {
			<?php if($paramssld['slider_dots_position']=="bottom"){?>
			bottom:0px;
			<?php }else if($paramssld['slider_dots_position']=="none"){?>
			display:none;
			<?
			}else{ ?>
			top:0px; <?php } ?>
		}
		
		.huge_it_slideshow_dots_<?php echo $sliderID; ?> {
			background:#<?php echo $paramssld['slider_dots_color']; ?>;
		}
		
		.huge_it_slideshow_dots_active_<?php echo $sliderID; ?> {
			background:#<?php echo $paramssld['slider_active_dot_color']; ?>;
		}
		
		<?php
		
		$arrowfolder=plugins_url('slider-image/Front_images/arrows');
		switch ($paramssld['slider_navigation_type']) {
			case 1:
				?>
					#huge_it_slideshow_left_<?php echo $sliderID; ?> {	
						left:0px;
						margin-top:-21px;
						height:43px;
						width:29px;
						background:url(<?php echo $arrowfolder;?>/arrows.simple.png) left  top no-repeat; 
					}
					
					#huge_it_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-21px;
						height:43px;
						width:29px;
						background:url(<?php echo $arrowfolder;?>/arrows.simple.png) right top no-repeat; 
					}
				<?php
				break;
			case 2:
				?>
					#huge_it_slideshow_left_<?php echo $sliderID; ?> {	
						left:0px;
						margin-top:-25px;
						height:50px;
						width:50px;
						background:url(<?php echo $arrowfolder;?>/arrows.circle.shadow.png) left  top no-repeat; 
					}
					
					#huge_it_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-25px;
						height:50px;
						width:50px;
						background:url(<?php echo $arrowfolder;?>/arrows.circle.shadow.png) right top no-repeat; 
					}

					#huge_it_slideshow_left_<?php echo $sliderID; ?>:hover {
						background-position:left -50px;
					}

					#huge_it_slideshow_right_<?php echo $sliderID; ?>:hover {
						background-position:right -50px;
					}
				<?php
				break;
			case 3:
				?>
					#huge_it_slideshow_left_<?php echo $sliderID; ?> {	
						left:0px;
						margin-top:-22px;
						height:44px;
						width:44px;
						background:url(<?php echo $arrowfolder;?>/arrows.circle.simple.dark.png) left  top no-repeat; 
					}
					
					#huge_it_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-22px;
						height:44px;
						width:44px;
						background:url(<?php echo $arrowfolder;?>/arrows.circle.simple.dark.png) right top no-repeat; 
					}

					#huge_it_slideshow_left_<?php echo $sliderID; ?>:hover {
						background-position:left -44px;
					}

					#huge_it_slideshow_right_<?php echo $sliderID; ?>:hover {
						background-position:right -44px;
					}
				<?php
				break;
			case 4:
				?>
					#huge_it_slideshow_left_<?php echo $sliderID; ?> {	
						left:0px;
						margin-top:-33px;
						height:65px;
						width:59px;
						background:url(<?php echo $arrowfolder;?>/arrows.cube.dark.png) left  top no-repeat; 
					}
					
					#huge_it_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-33px;
						height:65px;
						width:59px;
						background:url(<?php echo $arrowfolder;?>/arrows.cube.dark.png) right top no-repeat; 
					}

					#huge_it_slideshow_left_<?php echo $sliderID; ?>:hover {
						background-position:left -66px;
					}

					#huge_it_slideshow_right_<?php echo $sliderID; ?>:hover {
						background-position:right -66px;
					}
				<?php
				break;
			case 5:
				?>
					#huge_it_slideshow_left_<?php echo $sliderID; ?> {	
						left:0px;
						margin-top:-18px;
						height:37px;
						width:40px;
						background:url(<?php echo $arrowfolder;?>/arrows.light.blue.png) left  top no-repeat; 
					}
					
					#huge_it_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-18px;
						height:37px;
						width:40px;
						background:url(<?php echo $arrowfolder;?>/arrows.light.blue.png) right top no-repeat; 
					}

				<?php
				break;
			case 6:
				?>
					#huge_it_slideshow_left_<?php echo $sliderID; ?> {	
						left:0px;
						margin-top:-25px;
						height:50px;
						width:50px;
						background:url(<?php echo $arrowfolder;?>/arrows.light.cube.png) left  top no-repeat; 
					}
					
					#huge_it_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-25px;
						height:50px;
						width:50px;
						background:url(<?php echo $arrowfolder;?>/arrows.light.cube.png) right top no-repeat; 
					}

					#huge_it_slideshow_left_<?php echo $sliderID; ?>:hover {
						background-position:left -50px;
					}

					#huge_it_slideshow_right_<?php echo $sliderID; ?>:hover {
						background-position:right -50px;
					}
				<?php
				break;
			case 7:
				?>
					#huge_it_slideshow_left_<?php echo $sliderID; ?> {	
						left:0px;
						right:0px;
						margin-top:-19px;
						height:38px;
						width:38px;
						background:url(<?php echo $arrowfolder;?>/arrows.light.transparent.circle.png) left  top no-repeat; 
					}
					
					#huge_it_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-19px;
						height:38px;
						width:38px;
						background:url(<?php echo $arrowfolder;?>/arrows.light.transparent.circle.png) right top no-repeat; 
					}
				<?php
				break;
			case 8:
				?>
					#huge_it_slideshow_left_<?php echo $sliderID; ?> {	
						left:0px;
						margin-top:-22px;
						height:45px;
						width:45px;
						background:url(<?php echo $arrowfolder;?>/arrows.png) left  top no-repeat; 
					}
					
					#huge_it_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-22px;
						height:45px;
						width:45px;
						background:url(<?php echo $arrowfolder;?>/arrows.png) right top no-repeat; 
					}
				<?php
				break;
			case 9:
				?>
					#huge_it_slideshow_left_<?php echo $sliderID; ?> {	
						left:0px;
						margin-top:-22px;
						height:45px;
						width:45px;
						background:url(<?php echo $arrowfolder;?>/arrows.circle.blue.png) left  top no-repeat; 
					}
					
					#huge_it_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-22px;
						height:45px;
						width:45px;
						background:url(<?php echo $arrowfolder;?>/arrows.circle.blue.png) right top no-repeat; 
					}
				<?php
				break;
			case 10:
				?>
					#huge_it_slideshow_left_<?php echo $sliderID; ?> {	
						left:0px;
						margin-top:-24px;
						height:48px;
						width:48px;
						background:url(<?php echo $arrowfolder;?>/arrows.circle.green.png) left  top no-repeat; 
					}
					
					#huge_it_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-24px;
						height:48px;
						width:48px;
						background:url(<?php echo $arrowfolder;?>/arrows.circle.green.png) right top no-repeat; 
					}

					#huge_it_slideshow_left_<?php echo $sliderID; ?>:hover {
						background-position:left -48px;
					}

					#huge_it_slideshow_right_<?php echo $sliderID; ?>:hover {
						background-position:right -48px;
					}
				<?php
				break;
			case 11:
				?>
					#huge_it_slideshow_left_<?php echo $sliderID; ?> {	
						left:0px;
						margin-top:-29px;
						height:58px;
						width:55px;
						background:url(<?php echo $arrowfolder;?>/arrows.blue.retro.png) left  top no-repeat; 
					}
					
					#huge_it_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-29px;
						height:58px;
						width:55px;
						background:url(<?php echo $arrowfolder;?>/arrows.blue.retro.png) right top no-repeat; 
					}
				<?php
				break;
			case 12:
				?>
					#huge_it_slideshow_left_<?php echo $sliderID; ?> {	
						left:0px;
						margin-top:-37px;
						height:74px;
						width:74px;
						background:url(<?php echo $arrowfolder;?>/arrows.green.retro.png) left  top no-repeat; 
					}
					
					#huge_it_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-37px;
						height:74px;
						width:74px;
						background:url(<?php echo $arrowfolder;?>/arrows.green.retro.png) right top no-repeat; 
					}
				<?php
				break;
			case 13:
				?>
					#huge_it_slideshow_left_<?php echo $sliderID; ?> {	
						left:0px;
						margin-top:-16px;
						height:33px;
						width:33px;
						background:url(<?php echo $arrowfolder;?>/arrows.red.circle.png) left  top no-repeat; 
					}
					
					#huge_it_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-16px;
						height:33px;
						width:33px;
						background:url(<?php echo $arrowfolder;?>/arrows.red.circle.png) right top no-repeat; 
					}
				<?php
				break;
			case 14:
				?>
					#huge_it_slideshow_left_<?php echo $sliderID; ?> {	
						left:0px;
						margin-top:-51px;
						height:102px;
						width:52px;
						background:url(<?php echo $arrowfolder;?>/arrows.triangle.white.png) left  top no-repeat; 
					}
					
					#huge_it_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-51px;
						height:102px;
						width:52px;
						background:url(<?php echo $arrowfolder;?>/arrows.triangle.white.png) right top no-repeat; 
					}
				<?php
				break;
			case 15:
				?>
					#huge_it_slideshow_left_<?php echo $sliderID; ?> {	
						left:0px;
						margin-top:-19px;
						height:39px;
						width:70px;
						background:url(<?php echo $arrowfolder;?>/arrows.ancient.png) left  top no-repeat; 
					}
					
					#huge_it_slideshow_right_<?php echo $sliderID; ?> {
						right:0px;
						margin-top:-19px;
						height:39px;
						width:70px;
						background:url(<?php echo $arrowfolder;?>/arrows.ancient.png) right top no-repeat; 
					}
				<?php
				break;
			case 16:
				?>
					#huge_it_slideshow_left_<?php echo $sliderID; ?> {	
						left:-21px;
						margin-top:-20px;
						height:40px;
						width:37px;
						background:url(<?php echo $arrowfolder;?>/arrows.black.out.png) left  top no-repeat; 
					}
					
					#huge_it_slideshow_right_<?php echo $sliderID; ?> {
						right:-21px;
						margin-top:-20px;
						height:40px;
						width:37px;
						background:url(<?php echo $arrowfolder;?>/arrows.black.out.png) right top no-repeat; 
					}
				<?php
				break;
		}
?>
	</style>
	<?php
		  $args = array(
    'numberposts' => 10,
    'offset' => 0,
    'category' => 0,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'post',
    'post_status' => 'publish, future, pending, private',
    'suppress_filters' => true );

    $recent_posts = wp_get_recent_posts( $args, ARRAY_A );
	//print_r($recent_posts);
	//echo get_the_post_thumbnail(1, 'thumbnail');
 $image = wp_get_attachment_image_src( get_post_thumbnail_id( 1 ), 'thumbnail' );

	?>
	<div class="huge_it_slideshow_image_wrap_<?php echo $sliderID; ?>">
      <?php
      $current_pos = 0;
      ?>
		<!-- ##########################DOTS######################### -->
        <div class="huge_it_slideshow_dots_container_<?php echo $sliderID; ?>">
			  <div class="huge_it_slideshow_dots_thumbnails_<?php echo $sliderID; ?>">
				<?php
				$current_image_id=0;
				$current_pos =0;
				$current_key=0;
				$stri=0;
				foreach ($images as $key => $image_row) {
			  	$imagerowstype=$image_row->sl_type;
				if($image_row->sl_type == ''){
				$imagerowstype='image';
				}
				switch($imagerowstype){
							
							case 'image':
											
							  if ($image_row->id == $current_image_id) {
								$current_pos = $stri;
								$current_key = $stri;
							  }
							
							?>
								<div id="huge_it_dots_<?php echo $stri; ?>_<?php echo $sliderID; ?>" class="huge_it_slideshow_dots_<?php echo $sliderID; ?> <?php echo (($key==$current_image_id) ? 'huge_it_slideshow_dots_active_' . $sliderID : 'huge_it_slideshow_dots_deactive_' . $sliderID); ?>" onclick="huge_it_change_image_<?php echo $sliderID; ?>(parseInt(jQuery('#huge_it_current_image_key_<?php echo $sliderID; ?>').val()), '<?php echo $stri; ?>', data_<?php echo $sliderID; ?>,false,true);return false;" image_id="<?php echo $image_row->id; ?>" image_key="<?php echo $stri; ?>"></div>
							<?php
							  $stri++;
							break;
							case 'video':
											
							  if ($image_row->id == $current_image_id) {
								$current_pos = $stri;
								$current_key = $stri;
							  }
							
							?>
								<div id="huge_it_dots_<?php echo $stri; ?>_<?php echo $sliderID; ?>" class="huge_it_slideshow_dots_<?php echo $sliderID; ?> <?php echo (($key==$current_image_id) ? 'huge_it_slideshow_dots_active_' . $sliderID : 'huge_it_slideshow_dots_deactive_' . $sliderID); ?>" onclick="huge_it_change_image_<?php echo $sliderID; ?>(parseInt(jQuery('#huge_it_current_image_key_<?php echo $sliderID; ?>').val()), '<?php echo $stri; ?>', data_<?php echo $sliderID; ?>,false,true);return false;" image_id="<?php echo $image_row->id; ?>" image_key="<?php echo $stri; ?>"></div>
							<?php
							  $stri++;
							break;
							case 'last_posts':
							
							foreach($recent_posts as $lkeys => $last_posts){
                                                            if($lkeys < $image_row->sl_url){
                                                                if ($recentimage["post_status"] == "publish"){
                                                                    if(get_the_post_thumbnail($last_posts["ID"], 'thumbnail') != ''){
                                                                    $imagethumb = wp_get_attachment_image_src( get_post_thumbnail_id($last_posts["ID"]), 'thumbnail-size', true );

                                                                    if ($image_row->id == $current_image_id) {
                                                                        $current_pos = $stri;
                                                                        $current_key = $stri;
                                                                    }
                                                                    ?>
                                                                    <div id="huge_it_dots_<?php echo $stri; ?>_<?php echo $sliderID; ?>" class="huge_it_slideshow_dots_<?php echo $sliderID; ?> <?php echo (($stri==$current_image_id) ? 'huge_it_slideshow_dots_active_' . $sliderID : 'huge_it_slideshow_dots_deactive_' . $sliderID); ?>" onclick="huge_it_change_image_<?php echo $sliderID; ?>(parseInt(jQuery('#huge_it_current_image_key_<?php echo $sliderID; ?>').val()), '<?php echo $stri; ?>', data_<?php echo $sliderID; ?>,false,true);return false;" image_id="<?php echo $image_row->id; ?>" image_key="<?php echo $stri; ?>"></div>
                                                                    <?php
                                                                    $stri++;
                                                                }
                                                                }
                                                                
                                                            }
							}
							
							break;
					}
				}
				?>
			  </div>
			
			<?php
			   if ($paramssld['slider_show_arrows']=="on") {
			 ?>
				<a id="huge_it_slideshow_left_<?php echo $sliderID; ?>" href="#">
					<div id="huge_it_slideshow_left-ico_<?php echo $sliderID; ?>">
					<div><i class="huge_it_slideshow_prev_btn_<?php echo $sliderID; ?> fa"></i></div></div>
				</a>
				
				<a id="huge_it_slideshow_right_<?php echo $sliderID; ?>" href="#">
					<div id="huge_it_slideshow_right-ico_<?php echo $sliderID;?> , data_<?php echo $sliderID;?>">
					<div><i class="huge_it_slideshow_next_btn_<?php echo $sliderID; ?> fa"></i></div></div>
				</a>
			<?php
			}
			?>
		</div>
	  <!-- ##########################IMAGES######################### -->
      <div id="huge_it_slideshow_image_container_<?php echo $sliderID; ?>" class="huge_it_slideshow_image_container_<?php echo $sliderID; ?>">        
        <div class="huge_it_slide_container_<?php echo $sliderID; ?>">
          <div class="huge_it_slide_bg_<?php echo $sliderID; ?>">
            <ul class="huge_it_slider_<?php echo $sliderID; ?>">
			  <?php
			  $i=0;
			  foreach ($images as $key => $image_row) {
			  	$imagerowstype=$image_row->sl_type;
				if($image_row->sl_type == ''){
				$imagerowstype='image';
				}
				switch($imagerowstype){
					case 'image':
					$target="";
					?>
					  <li class="huge_it_slideshow_image<?php if ($i != $current_image_id) {$current_key = $key; echo '_second';} ?>_item_<?php echo $sliderID; ?>" id="image_id_<?php echo $sliderID.'_'.$i ?>">      
						<?php if($image_row->sl_url!=""){ 
							if ($image_row->link_target=="on"){$target='target="_blank'.$image_row->link_target.'"';}
							echo '<a href="'.$image_row->sl_url.'" '.$target.'>';
						} ?>
						<img alt="<?php echo $image_row->name; ?>" id="huge_it_slideshow_image_<?php echo $sliderID; ?>" class="huge_it_slideshow_image_<?php echo $sliderID; ?>" src="<?php echo $image_row->image_url; ?>" image_id="<?php echo $image_row->id; ?>" />
						<?php if($image_row->sl_url!=""){ echo '</a>'; }?>		
						<div class="huge_it_slideshow_title_text_<?php echo $sliderID; ?> <?php if(trim($image_row->name)=="") echo "none"; ?>">
							<?php echo $image_row->name; ?>
						</div>
						<div class="huge_it_slideshow_description_text_<?php echo $sliderID; ?> <?php if(trim($image_row->description)=="") echo "none"; ?>">
							<?php echo $image_row->description; ?>
						</div>
					  </li>
					  <?php
					$i++;
					break;
					
					case 'last_posts':
					foreach($recent_posts as $lkeys => $last_posts){
						if($lkeys < $image_row->sl_url){
                                                    
							$imagethumb = wp_get_attachment_image_src( get_post_thumbnail_id($last_posts["ID"]), 'thumbnail-size', true );
                                                        if ($recentimage["post_status"] == "publish"){
                                                            if(get_the_post_thumbnail($last_posts["ID"], 'thumbnail') != ''){
							$target="";
							?>
							  <li class="huge_it_slideshow_image<?php if ($i != $current_image_id) {$current_key = $key; echo '_second';} ?>_item_<?php echo $sliderID; ?>" id="image_id_<?php echo $sliderID.'_'.$i ?>">      
								<?php if ($image_row->sl_postlink=="1"){
										if ($image_row->link_target=="on"){$target='target="_blank'.$image_row->link_target.'"';}
										echo '<a href="'.$last_posts["guid"].'" '.$target.'>';
								} ?>
								<img alt="<?php echo $image_row->name; ?>" id="huge_it_slideshow_image_<?php echo $sliderID; ?>" class="huge_it_slideshow_image_<?php echo $sliderID; ?>" src="<?php echo $imagethumb[0]; ?>" image_id="<?php echo $image_row->id; ?>" />
								<?php if($image_row->sl_postlink=="1"){ echo '</a>'; }?>		
								<div class="huge_it_slideshow_title_text_<?php echo $sliderID; ?> <?php if(trim($last_posts["post_title"])=="") echo "none";  if($image_row->sl_stitle!="1") echo " hidden"; ?>">
										<?php echo $last_posts["post_title"]; ?>
								</div>
								<div class="huge_it_slideshow_description_text_<?php echo $sliderID; ?> <?php if(trim($last_posts["post_content"])=="") echo "none"; if($image_row->sl_sdesc!="1") echo " hidden"; ?>">
									<?php 
									echo substr_replace($last_posts["post_content"], "", $image_row->description); ?>
								</div>
							 </li>
							  <?php
							$i++;
							}
                                                        }
							
						}
					}
					break;
					case 'video':

						?>
						<li  class="huge_it_slideshow_image<?php if ($i != $current_image_id) {$current_key = $key; echo '_second';} ?>_item_<?php echo $sliderID; ?>" id="image_id_<?php echo $sliderID.'_'.$i ?>">      
							<?php 
								if(strpos($image_row->image_url,'youtube') !== false || strpos($rowimages->image_url,'youtu') !== false){
									$video_thumb_url=get_youtube_id_from_url($image_row->image_url); 
								?>
									
									<div id="video_id_<?php echo $sliderID;?>_<?php echo $key ;?>" class="huge_it_video_frame_<?php echo $sliderID; ?>"></div>
							<?php }else {
									$vimeo = $image_row->image_url;
									$imgid =  end(explode( "/", $vimeo ));
									
							?>					
								<iframe id="player_<?php echo $key ;?>"  class="huge_it_video_frame_<?php echo $sliderID; ?>" src="//player.vimeo.com/video/<?php echo $imgid; ?>?api=1&player_id=player_<?php echo $key ;?>&showinfo=0&controls=0" frameborder="0" allowfullscreen></iframe>
							<?php } ?>
						</li>
					<?php
					$i++;
					break;
				} 
			 } 
			  ?>
			   <input  type="hidden" id="huge_it_current_image_key_<?php echo $sliderID; ?>" value="0" />
            </ul>
          </div>
        </div>
      </div>
	</div>
	  <?php 
	return ob_get_clean();
}  
?>

