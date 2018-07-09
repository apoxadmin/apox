jQuery(document).ready(function () {
  jQuery(".wds_form .colspanchange").attr("colspan", jQuery(".wds_form table>thead>tr>th").length);
});

function spider_ajax_save(form_id, event) {
  /* Loading.*/
  jQuery(".spider_load").show();
  set_ffamily_value();
  var post_data = {};
  post_data["task"] = "apply";
  /* Global.*/
  post_data["current_id"] = jQuery("#current_id").val();
  post_data["nonce_wd"] = jQuery("#nonce_wd").val();
  post_data["nav_tab"] = jQuery("#nav_tab").val();
  post_data["tab"] = jQuery("#tab").val();
  post_data["sub_tab"] = jQuery("#sub_tab").val();
  
  var slider_data = {};  
  slider_data["slide_ids_string"] = jQuery("#slide_ids_string").val();
  slider_data["del_slide_ids_string"] = jQuery("#del_slide_ids_string").val();
  slider_data["name"] = jQuery("#name").val();
  slider_data["width"] = jQuery("#width").val();
  slider_data["height"] = jQuery("#height").val();
  slider_data["full_width"] = jQuery("input[name=full_width]:checked").val();
  slider_data["bg_fit"] = jQuery("input[name=bg_fit]:checked").val();
  slider_data["align"] = jQuery("#align").val();
  slider_data["effect"] = jQuery("#effect").val();
  slider_data["time_intervval"] = jQuery("#time_intervval").val();
  slider_data["autoplay"] = jQuery("input[name=autoplay]:checked").val();
  slider_data["stop_animation"] = jQuery("input[name=stop_animation]:checked").val();
  slider_data["shuffle"] = jQuery("input[name=shuffle]:checked").val();
  slider_data["music"] = jQuery("input[name=music]:checked").val();
  slider_data["music_url"] = jQuery("#music_url").val();
  slider_data["preload_images"] = jQuery("input[name=preload_images]:checked").val();
  slider_data["background_color"] = jQuery("#background_color").val();
  slider_data["background_transparent"] = jQuery("#background_transparent").val();
  slider_data["glb_border_width"] = jQuery("#glb_border_width").val();
  slider_data["glb_border_style"] = jQuery("#glb_border_style").val();
  slider_data["glb_border_color"] = jQuery("#glb_border_color").val();
  slider_data["glb_border_radius"] = jQuery("#glb_border_radius").val();
  slider_data["glb_margin"] = jQuery("#glb_margin").val();
  slider_data["glb_box_shadow"] = jQuery("#glb_box_shadow").val();
  slider_data["image_right_click"] = jQuery("input[name=image_right_click]:checked").val();
  slider_data["layer_out_next"] = jQuery("input[name=layer_out_next]:checked").val();
  slider_data["published"] = jQuery("input[name=published]:checked").val();
  slider_data["start_slide_num"] = jQuery("#start_slide_num").val();
  slider_data["effect_duration"] = jQuery("#effect_duration").val();
  slider_data["parallax_effect"] = jQuery("input[name=parallax_effect]:checked").val();
  slider_data["carousel"] = jQuery("input[name=carousel]:checked").val();
  slider_data["carousel_image_counts"] = jQuery("#carousel_image_counts").val();
  slider_data["carousel_image_parameters"] = jQuery("#carousel_image_parameters").val();
  slider_data["carousel_fit_containerWidth"] = jQuery("input[name=carousel_fit_containerWidth]:checked").val();
  slider_data["carousel_width"] = jQuery("#carousel_width").val();
  slider_data["carousel_degree"] = jQuery("#carousel_degree").val();
  slider_data["carousel_grayscale"] = jQuery("#carousel_grayscale").val();
  slider_data["carousel_transparency"] = jQuery("#carousel_transparency").val();
  slider_data["slider_loop"] = jQuery("input[name=slider_loop]:checked").val();
  slider_data["hide_on_mobile"] = jQuery("#hide_on_mobile").val();
  slider_data["twoway_slideshow"] = jQuery("input[name=twoway_slideshow]:checked").val();

  /* Navigation.*/
  slider_data["prev_next_butt"] = jQuery("input[name=prev_next_butt]:checked").val();
  slider_data["play_paus_butt"] = jQuery("input[name=play_paus_butt]:checked").val();
  slider_data["navigation"] = jQuery("input[name=navigation]:checked").val();
  slider_data["rl_butt_img_or_not"] = jQuery("input[name=rl_butt_img_or_not]:checked").val();
  slider_data["rl_butt_style"] = jQuery("#rl_butt_style").val();
  slider_data["right_butt_url"] = jQuery("#right_butt_url").val();
  slider_data["left_butt_url"] = jQuery("#left_butt_url").val();
  slider_data["right_butt_hov_url"] = jQuery("#right_butt_hov_url").val();
  slider_data["left_butt_hov_url"] = jQuery("#left_butt_hov_url").val();
  slider_data["rl_butt_size"] = jQuery("#rl_butt_size").val();
  slider_data["pp_butt_size"] = jQuery("#pp_butt_size").val();
  slider_data["butts_color"] = jQuery("#butts_color").val();
  slider_data["hover_color"] = jQuery("#hover_color").val();
  slider_data["nav_border_width"] = jQuery("#nav_border_width").val();
  slider_data["nav_border_style"] = jQuery("#nav_border_style").val();
  slider_data["nav_border_color"] = jQuery("#nav_border_color").val();
  slider_data["nav_border_radius"] = jQuery("#nav_border_radius").val();
  slider_data["nav_bg_color"] = jQuery("#nav_bg_color").val();
  slider_data["butts_transparent"] = jQuery("#butts_transparent").val();
  slider_data["play_paus_butt_img_or_not"] = jQuery("input[name=play_paus_butt_img_or_not]:checked").val();
  slider_data["play_butt_url"] = jQuery("#play_butt_url").val();
  slider_data["play_butt_hov_url"] = jQuery("#play_butt_hov_url").val();
  slider_data["paus_butt_url"] = jQuery("#paus_butt_url").val();
  slider_data["paus_butt_hov_url"] = jQuery("#paus_butt_hov_url").val();

  /* Bullets.*/
  slider_data["enable_bullets"] = jQuery("input[name=enable_bullets]:checked").val();
  slider_data["bull_position"] = jQuery("#bull_position").val();
  slider_data["bull_style"] = jQuery("#bull_style").val();
  slider_data["bullets_img_main_url"] = jQuery("#bullets_img_main_url").val();
  slider_data["bullets_img_hov_url"] = jQuery("#bullets_img_hov_url").val();
  slider_data["bull_butt_img_or_not"] = jQuery("input[name=bull_butt_img_or_not]:checked").val();
  slider_data["bull_size"] = jQuery("#bull_size").val();
  slider_data["bull_color"] = jQuery("#bull_color").val();
  slider_data["bull_act_color"] = jQuery("#bull_act_color").val();
  slider_data["bull_margin"] = jQuery("#bull_margin").val();

  /* Filmstrip.*/
  slider_data["enable_filmstrip"] = jQuery("input[name=enable_filmstrip]:checked").val();
  slider_data["film_pos"] = jQuery("#film_pos").val();
  slider_data["film_thumb_width"] = jQuery("#film_thumb_width").val();
  slider_data["film_thumb_height"] = jQuery("#film_thumb_height").val();
  slider_data["film_bg_color"] = jQuery("#film_bg_color").val();
  slider_data["film_tmb_margin"] = jQuery("#film_tmb_margin").val();
  slider_data["film_act_border_width"] = jQuery("#film_act_border_width").val();
  slider_data["film_act_border_style"] = jQuery("#film_act_border_style").val();
  slider_data["film_act_border_color"] = jQuery("#film_act_border_color").val();
  slider_data["film_dac_transparent"] = jQuery("#film_dac_transparent").val();

  /* Timer bar.*/
  slider_data["enable_time_bar"] = jQuery("input[name=enable_time_bar]:checked").val();
  slider_data["timer_bar_type"] = jQuery("#timer_bar_type").val();
  slider_data["timer_bar_size"] = jQuery("#timer_bar_size").val();
  slider_data["timer_bar_color"] = jQuery("#timer_bar_color").val();
  slider_data["timer_bar_transparent"] = jQuery("#timer_bar_transparent").val();

  /* Watermark.*/
  slider_data["built_in_watermark_type"] = jQuery("input[name=built_in_watermark_type]:checked").val();
  slider_data["built_in_watermark_text"] = jQuery("#built_in_watermark_text").val();
  slider_data["built_in_watermark_font_size"] = jQuery("#built_in_watermark_font_size").val();
  slider_data["built_in_watermark_font"] = jQuery("#built_in_watermark_font").val();
  slider_data["built_in_watermark_color"] = jQuery("#built_in_watermark_color").val();
  slider_data["built_in_watermark_opacity"] = jQuery("#built_in_watermark_opacity").val();
  slider_data["built_in_watermark_position"] = jQuery("input[name=built_in_watermark_position]:checked").val();
  slider_data["built_in_watermark_url"] = jQuery("#built_in_watermark_url").val();
  slider_data["built_in_watermark_size"] = jQuery("#built_in_watermark_size").val();

  slider_data["spider_uploader"] = jQuery("input[name=spider_uploader]:checked").val();
  slider_data["mouse_swipe_nav"] = jQuery("input[name=mouse_swipe_nav]:checked").val();
  slider_data["bull_hover"] = jQuery("input[name=bull_hover]:checked").val();
  slider_data["touch_swipe_nav"] = jQuery("input[name=touch_swipe_nav]:checked").val();
  slider_data["mouse_wheel_nav"] = jQuery("input[name=mouse_wheel_nav]:checked").val();
  slider_data["keyboard_nav"] = jQuery("input[name=keyboard_nav]:checked").val();
  slider_data["possib_add_ffamily"] = jQuery("#possib_add_ffamily").val();
  slider_data["show_thumbnail"] = jQuery("input[name=show_thumbnail]:checked").val();
  slider_data["thumb_size"] = jQuery("input[name=wds_thumb_size]").val();
  slider_data["fixed_bg"] = jQuery("input[name=fixed_bg]:checked").val();
  slider_data["smart_crop"] = jQuery("input[name=smart_crop]:checked").val();
  slider_data["crop_image_position"] = jQuery("input[name=crop_image_position]:checked").val();
  slider_data["possib_add_google_fonts"] = jQuery("input[name=possib_add_google_fonts]:checked").val();
  slider_data["possib_add_ffamily_google"] = jQuery("#possib_add_ffamily_google").val();
  /* Css.*/
  slider_data["css"] = jQuery("#css").val();
  /* Javascript */
  var js_textarea_val = {};
  jQuery(".callbeck-textarea").each(function(index,element){
	  js_textarea_val[jQuery(element).attr("name")] = jQuery(element).val();
  });
  slider_data["javascript"] = JSON.stringify(js_textarea_val);
  slider_data["bull_back_act_color"] = jQuery("#bull_back_act_color").val();
  slider_data["bull_back_color"] = jQuery("#bull_back_color").val();
  slider_data["bull_radius"] = jQuery("#bull_radius").val();
  
  post_data["slider_data"] = JSON.stringify(slider_data);

  post_data["slides"] = new Array();
  var wds_slide_ids = jQuery("#slide_ids_string").val();
  var slide_ids_array = wds_slide_ids.split(",");
  for (var i in slide_ids_array) {
    if (slide_ids_array.hasOwnProperty(i) && slide_ids_array[i] && slide_ids_array[i] != ",") {
      var slide_id = slide_ids_array[i];
      var slide_data = {};
      slide_data["id"] = slide_id;
      slide_data["title" + slide_id] = jQuery("#title" + slide_id).val();
      slide_data["order" + slide_id] = jQuery("#order" + slide_id).val();
      slide_data["published" + slide_id] = jQuery("input[name=published" + slide_id + "]:checked").val();
      slide_data["link" + slide_id] = jQuery("#link" + slide_id).val();
      slide_data["target_attr_slide" + slide_id] = jQuery("input[name=target_attr_slide" + slide_id +" ]:checked").val();
      slide_data["type" + slide_id] = jQuery("#type" + slide_id).val();
      slide_data["image_url" + slide_id] = jQuery("#image_url" + slide_id).val();
      slide_data["thumb_url" + slide_id] = jQuery("#thumb_url" + slide_id).val();
      slide_data["wds_video_type" + slide_id] = jQuery("#wds_video_type" + slide_id ).val();
      var layer_ids_string = jQuery("#slide" + slide_id + "_layer_ids_string").val();
      slide_data["slide" + slide_id + "_layer_ids_string"] = layer_ids_string;
      slide_data["slide" + slide_id + "_del_layer_ids_string"] = jQuery("#slide" + slide_id + "_del_layer_ids_string").val();
      if (layer_ids_string) {
        var layer_ids_array = layer_ids_string.split(",");
        for (var i in layer_ids_array) {
          if (layer_ids_array.hasOwnProperty(i) && layer_ids_array[i] && layer_ids_array[i] != ",") {
            var json_data = {};
            var layer_id = layer_ids_array[i];
            var prefix = "slide" + slide_id + "_layer" + layer_id;
            var type = jQuery("#" + prefix + "_type").val();
            json_data["type"] = type;
            json_data["title"] = jQuery("#" + prefix + "_title").val();
            json_data["depth"] = jQuery("#" + prefix + "_depth").val();
            json_data["static_layer"] = jQuery("input[name=" + prefix + "_static_layer]:checked").val();
            switch (type) {
              case "text": {
                json_data["text"] = jQuery("#" + prefix + "_text").val().replace(/[\\"]/g, '\\$&').replace(/\u0000/g, '\\0');
                json_data["image_width"] = jQuery("#" + prefix + "_image_width").val();
                json_data["image_height"] = jQuery("#" + prefix + "_image_height").val();
                json_data["image_scale"] = jQuery("input[name=slide" + slide_id + "_layer" + layer_id + "_image_scale]:checked").val();
                json_data["size"] = jQuery("#" + prefix + "_size").val();
                json_data["color"] = jQuery("#" + prefix + "_color").val();
                json_data["ffamily"] = jQuery("#" + prefix + "_ffamily").val();
                json_data["google_fonts"] =  jQuery("input[name=slide" + slide_id + "_layer" + layer_id + "_google_fonts]:checked").val();
                json_data["fweight"] = jQuery("#" + prefix + "_fweight").val();
                json_data["link"] = jQuery("#" + prefix + "_link").val();
                json_data["target_attr_layer"] = jQuery("input[name=" + prefix + "_target_attr_layer]:checked").val();
                json_data["padding"] = jQuery("#" + prefix + "_padding").val();
                json_data["fbgcolor"] = jQuery("#" + prefix + "_fbgcolor").val();
                json_data["transparent"] = jQuery("#" + prefix + "_transparent").val();
                json_data["border_width"] = jQuery("#" + prefix + "_border_width").val();
                json_data["border_style"] = jQuery("#" + prefix + "_border_style").val();
                json_data["border_color"] = jQuery("#" + prefix + "_border_color").val();
                json_data["border_radius"] = jQuery("#" + prefix + "_border_radius").val();
                json_data["shadow"] = jQuery("#" + prefix + "_shadow").val();
                json_data["add_class"] = jQuery("#" + prefix + "_add_class").val();
                json_data["hover_color_text"] = jQuery("#" + prefix + "_hover_color_text").val();
                json_data["text_alignment"] = jQuery("#" + prefix + "_text_alignment").val();
                json_data["layer_callback_list"] = jQuery("#" + prefix + "_layer_callback_list").val();
                json_data["link_to_slide"] = jQuery("#" + prefix + "_link_to_slide").val();
                json_data["align_layer"] = jQuery("input[name=" + prefix + "_align_layer]:checked").val();
                break;
              }
              case "image": {
                json_data["image_url"] = jQuery("#" + prefix + "_image_url").val();
                json_data["image_width"] = jQuery("#" + prefix + "_image_width").val();
                json_data["image_height"] = jQuery("#" + prefix + "_image_height").val();
                json_data["image_scale"] = jQuery("input[name=slide" + slide_id + "_layer" + layer_id + "_image_scale]:checked").val();
                json_data["alt"] = jQuery("#" + prefix + "_alt").val();
                json_data["link"] = jQuery("#" + prefix + "_link").val();
                json_data["target_attr_layer"] = jQuery("input[name=" + prefix + "_target_attr_layer]:checked").val();
                json_data["imgtransparent"] = jQuery("#" + prefix + "_imgtransparent").val();
                json_data["border_width"] = jQuery("#" + prefix + "_border_width").val();
                json_data["border_style"] = jQuery("#" + prefix + "_border_style").val();
                json_data["border_color"] = jQuery("#" + prefix + "_border_color").val();
                json_data["border_radius"] = jQuery("#" + prefix + "_border_radius").val();
                json_data["shadow"] = jQuery("#" + prefix + "_shadow").val();
                json_data["add_class"] = jQuery("#" + prefix + "_add_class").val();
                json_data["layer_callback_list"] = jQuery("#" + prefix + "_layer_callback_list").val();
                json_data["link_to_slide"] = jQuery("#" + prefix + "_link_to_slide").val();
                break;
              }
              case "video": {
                json_data["image_url"] = jQuery("#" + prefix + "_image_url").val();
                json_data["image_width"] = jQuery("#" + prefix + "_image_width").val();
                json_data["image_height"] = jQuery("#" + prefix + "_image_height").val();
                json_data["image_scale"] = jQuery("input[name=slide" + slide_id + "_layer" + layer_id + "_image_scale]:checked").val();
                json_data["link"] = jQuery("#" + prefix + "_link").val();
                json_data["alt"] = jQuery("#" + prefix + "_alt").val();
                json_data["border_width"] = jQuery("#" + prefix + "_border_width").val();
                json_data["border_style"] = jQuery("#" + prefix + "_border_style").val();
                json_data["border_color"] = jQuery("#" + prefix + "_border_color").val();
                json_data["border_radius"] = jQuery("#" + prefix + "_border_radius").val();
                json_data["shadow"] = jQuery("#" + prefix + "_shadow").val();
                json_data["add_class"] = jQuery("#" + prefix + "_add_class").val();
                break;
              }
              case "social": {
                json_data["social_button"] = jQuery("#" + prefix + "_social_button").val();
                json_data["size"] = jQuery("#" + prefix + "_size").val();
                json_data["transparent"] = jQuery("#" + prefix + "_transparent").val();
                json_data["color"] = jQuery("#" + prefix + "_color").val();
                json_data["hover_color"] = jQuery("#" + prefix + "_hover_color").val();
                json_data["add_class"] = jQuery("#" + prefix + "_add_class").val();
                break;
              }
              default:
                break;
            }
            json_data["left"] = jQuery("#" + prefix + "_left").val();
            json_data["top"] = jQuery("#" + prefix + "_top").val();
            json_data["published"] = jQuery("input[name=slide" + slide_id + "_layer" + layer_id + "_published]:checked").val();
            json_data["start"] = jQuery("#" + prefix + "_start").val();
            json_data["layer_effect_in"] = jQuery("#" + prefix + "_layer_effect_in").val();
            json_data["duration_eff_in"] = jQuery("#" + prefix + "_duration_eff_in").val();
            json_data["end"] = jQuery("#" + prefix + "_end").val();
            json_data["layer_effect_out"] = jQuery("#" + prefix + "_layer_effect_out").val();
            json_data["duration_eff_out"] = jQuery("#" + prefix + "_duration_eff_out").val();
            slide_data[prefix + "_json"] = JSON.stringify(json_data);
            json_data = null;
          }
        }
      }
      post_data["slides"].splice(post_data["slides"].length, 0, JSON.stringify(slide_data));
    }
  }

  jQuery.post(
    jQuery('#' + form_id).attr("action"),
    post_data,
    function (data) {
      var content = jQuery(data).find(".wds_nav_global_box").parent();
      var str = content.html();
      jQuery(".wds_nav_global_box").parent().html(str);
      var str = jQuery(data).find(".wds_task_cont").html();
      jQuery(".wds_task_cont").html(str);
      var str = jQuery(data).find(".wds_buttons").html();
      jQuery(".wds_buttons").html(str);
      var content = jQuery(data).find(".wds_slides_box");
      var str = content.html();
      jQuery(".wds_slides_box").html(str);
      var post_btn_href = jQuery(data).find("#wds_posts_btn").attr("href");
      jQuery("#wds_posts_btn").attr("href", post_btn_href);
    }
  ).success(function (data, textStatus, errorThrown) {
    wds_success(form_id, 0);
  });
  if (event.preventDefault) {
    event.preventDefault();
  }
  else {
    event.returnValue = false;
  }
}

function wds_action_after_save(form_id) {
  var post_data = {};
  post_data["task"] = jQuery("#task").val();
  post_data["current_id"] = jQuery("#current_id").val();
  post_data["nonce_wd"] = jQuery("#nonce_wd").val();
  jQuery.post(
    jQuery("#" + form_id).attr("action"),
    post_data,
    function (data) {
      jQuery(".wds_preview").find("div[class^='wds_preview_image']").each(function() {
        var image = jQuery(this).css("background-image");
        jQuery(this).css({backgroundImage: image.replace('")', Math.floor((Math.random() * 100) + 1) + '")')});
      });
    }
  ).success(function (data, textStatus, errorThrown) {
    wds_success(form_id, 1);
  });
}

function wds_success(form_id, end) {
  jQuery("#" + form_id).parent().find(".spider_message").remove();
  var task = jQuery("#task").val();
  var message;
  switch (task) {
    case "save": {
      jQuery("#" + form_id).submit();
      break;
    }
    case "preview": {
      if (end) {
        tb_show("Preview", wds_preview_url.replace("sliderID", jQuery("#current_id").val()));
      }
      else {
        wds_action_after_save(form_id);
      }
      break;
    }
    case "set_watermark": {
      if (end) {
        if (jQuery("input[name=built_in_watermark_type]:checked").val() == 'none') {
          message = "<div class='wd_error'><strong><p>You must set watermark type.</p></strong></div>";
        }
        else {
          message = "<div class='wd_updated'><strong><p>Watermark Succesfully Set.</p></strong></div>";
        }
      }
      else {
        wds_action_after_save(form_id);
      }
      break;
    }
    case "reset_watermark": {
      if (end) {
        message = "<div class='wd_updated'><strong><p>Watermark Succesfully Reset.</p></strong></div>";
      }
      else {
        wds_action_after_save(form_id);
      }
      break;
    }
    case "reset":
    case "duplicate":    {
      jQuery("#" + form_id).submit();
      break;
    }
    default: {
      message = "<div class='wd_updated'><strong><p>Items Succesfully Saved.</p></strong></div>";
      break;
    }
  }
  /* Loading.*/
  jQuery(".spider_load").hide();
  if (message) {
    jQuery(".spider_message_cont").html(message);
    jQuery(".spider_message_cont").show();
  }
  wds_onload();
  jscolor.bind();
}


function wds_onload() {
  var type_key;
  var color_key;
  var bull_type_key;
  var bull_color_key;
  jQuery(".wds_tabs").show();
  var nav_tab = jQuery("#nav_tab").val();
  wds_change_nav(jQuery(".wds_nav_tabs li[tab_type='" + nav_tab + "']"), 'wds_nav_' + nav_tab + '_box');
  var tab = jQuery("#tab").val();
  wds_change_tab(jQuery("." + tab  + "_tab_button_wrap"), 'wds_' + tab + '_box');
  bwg_built_in_watermark("watermark_type_" + jQuery("input[name=built_in_watermark_type]:checked").val());
  preview_built_in_watermark();
  wds_slide_weights();
  if (jQuery("#music1").is(":checked")) {
    bwg_enable_disable('', 'tr_music_url', 'music1');
  }
  else {
    bwg_enable_disable('none', 'tr_music_url', 'music0');
  }
  if (jQuery("#show_thumbnail1").is(":checked")) {
    bwg_enable_disable('', 'tr_thumb_size', 'show_thumbnail1');
  }
  else {
    bwg_enable_disable('none', 'tr_thumb_size', 'show_thumbnail0');
  }
  if (jQuery("#bg_fit_cover").is(":checked") || jQuery("#bg_fit_contain").is(":checked")) {
    jQuery('#tr_smart_crop').show();
  }
  else {
    jQuery('#tr_smart_crop').hide();
  }
  if (jQuery("#smart_crop1").is(":checked")) {
    bwg_enable_disable('', 'tr_crop_pos', 'smart_crop1');
  }
  else {
    bwg_enable_disable('none', 'tr_crop_pos', 'smart_crop0');
  }

  jQuery('.wds_rl_butt_groups').each(function(i) {
    var type_key = jQuery(this).attr('value');
    var src_top_left	= rl_butt_dir + wds_rl_butt_type[type_key]["type_name"] + '/1/1.png';
    var src_top_right	= rl_butt_dir + wds_rl_butt_type[type_key]["type_name"] + '/1/2.png';
    var src_bottom_left	= rl_butt_dir + wds_rl_butt_type[type_key]["type_name"] + '/1/3.png';
    var src_bottom_right  	= rl_butt_dir + wds_rl_butt_type[type_key]["type_name"] + '/1/4.png';
   
    jQuery(this).find('.src_top_left').attr('src', src_top_left);
    jQuery(this).find('.src_top_right').attr('src', src_top_right);
    jQuery(this).find('.src_bottom_left').attr('src', src_bottom_left);
    jQuery(this).find('.src_bottom_right').attr('src', src_bottom_right);	 
  });

  jQuery('.wds_rl_butt_col_groups').each(function(i) {
    var color_key = jQuery(this).attr('value');	 
    src_col_top_left	= rl_butt_dir + wds_rl_butt_type[type_cur_fold]["type_name"] + '/' + wds_rl_butt_type[type_cur_fold][color_key] + '/1.png';
    src_col_top_right	= rl_butt_dir + wds_rl_butt_type[type_cur_fold]["type_name"] + '/' + wds_rl_butt_type[type_cur_fold][color_key] + '/2.png';
    src_col_bottom_left	= rl_butt_dir + wds_rl_butt_type[type_cur_fold]["type_name"] + '/' + wds_rl_butt_type[type_cur_fold][color_key] + '/3.png';
    src_col_bottom_right  	= rl_butt_dir + wds_rl_butt_type[type_cur_fold]["type_name"] + '/' + wds_rl_butt_type[type_cur_fold][color_key] + '/4.png';
   
    jQuery(this).find('.src_col_top_left').attr('src', src_col_top_left);	
    jQuery(this).find('.src_col_top_right').attr('src', src_col_top_right);
    jQuery(this).find('.src_col_bottom_left').attr('src', src_col_bottom_left);
    jQuery(this).find('.src_col_bottom_right').attr('src', src_col_bottom_right);	 
  });

  jQuery('.wds_pp_butt_groups').each(function(i) {
    var pp_type_key = jQuery(this).attr('value');
    var pp_src_top_left	= pp_butt_dir + wds_pp_butt_type[pp_type_key]["type_name"] + '/1/1.png';
    var pp_src_top_right	= pp_butt_dir + wds_pp_butt_type[pp_type_key]["type_name"] + '/1/2.png';
    var pp_src_bottom_left	= pp_butt_dir + wds_pp_butt_type[pp_type_key]["type_name"] + '/1/3.png';
    var pp_src_bottom_right  	= pp_butt_dir + wds_pp_butt_type[pp_type_key]["type_name"] + '/1/4.png';
   
    jQuery(this).find('.pp_src_top_left').attr('src', pp_src_top_left);
    jQuery(this).find('.pp_src_top_right').attr('src', pp_src_top_right);
    jQuery(this).find('.pp_src_bottom_left').attr('src', pp_src_bottom_left);
    jQuery(this).find('.pp_src_bottom_right').attr('src', pp_src_bottom_right);	 
  });

  jQuery('.wds_pp_butt_col_groups').each(function(i) {
    var pp_color_key = jQuery(this).attr('value');	 
    var pp_src_col_top_left	= pp_butt_dir + wds_pp_butt_type[pp_type_cur_fold]["type_name"] + '/' + wds_pp_butt_type[pp_type_cur_fold][pp_color_key] + '/1.png';
    var pp_src_col_top_right = pp_butt_dir + wds_pp_butt_type[pp_type_cur_fold]["type_name"] + '/' + wds_pp_butt_type[pp_type_cur_fold][pp_color_key] + '/2.png';
    var pp_src_col_bottom_left = pp_butt_dir + wds_pp_butt_type[pp_type_cur_fold]["type_name"] + '/' + wds_pp_butt_type[pp_type_cur_fold][pp_color_key] + '/3.png';
    var pp_src_col_bottom_right = pp_butt_dir + wds_pp_butt_type[pp_type_cur_fold]["type_name"] + '/' + wds_pp_butt_type[pp_type_cur_fold][pp_color_key] + '/4.png';
   
    jQuery(this).find('.pp_src_col_top_left').attr('src', pp_src_col_top_left);	
    jQuery(this).find('.pp_src_col_top_right').attr('src', pp_src_col_top_right);
    jQuery(this).find('.pp_src_col_bottom_left').attr('src', pp_src_col_bottom_left);
    jQuery(this).find('.pp_src_col_bottom_right').attr('src', pp_src_col_bottom_right);	 
  });

  jQuery('.wds_bull_butt_groups').each(function(i) {
    bull_type_key = jQuery(this).attr('value');
    bull_src_left	= blt_img_dir + wds_blt_img_type[bull_type_key]["type_name"] + '/1/1.png';
    bull_src_right	= blt_img_dir + wds_blt_img_type[bull_type_key]["type_name"] + '/1/2.png';
   
    jQuery(this).find('.bull_src_left').attr('src', bull_src_left);
    jQuery(this).find('.bull_src_right').attr('src', bull_src_right);	 
  });

  jQuery('.wds_bull_butt_col_groups').each(function(i) {
    bull_color_key = jQuery(this).attr('value');	 
    bull_col_src_left	= blt_img_dir + wds_blt_img_type[bull_type_cur_fold]["type_name"] + '/' + wds_blt_img_type[bull_type_cur_fold][bull_color_key] + '/1.png';
    bull_col_src_right	= blt_img_dir + wds_blt_img_type[bull_type_cur_fold]["type_name"] + '/' + wds_blt_img_type[bull_type_cur_fold][bull_color_key] + '/2.png';
   
    jQuery(this).find('.bull_col_src_left').attr('src', bull_col_src_left);	
    jQuery(this).find('.bull_col_src_right').attr('src', bull_col_src_right);	 
  });
  jQuery('input:radio').on('change', function(){
    var radios = jQuery(this).closest('td').find('label').removeClass('selected_color');
    var label_for = jQuery("label[for='"+jQuery(this).attr('id')+"']");
    label_for.addClass('selected_color');
  });
}

function spider_select_value(obj) {
  obj.focus();
  obj.select();
}

function spider_run_checkbox() {
  jQuery("tbody").children().children(".check-column").find(":checkbox").click(function (l) {
    if ("undefined" == l.shiftKey) {
      return true
    }
    if (l.shiftKey) {
      if (!i) {
        return true
      }
      d = jQuery(i).closest("form").find(":checkbox");
      f = d.index(i);
      j = d.index(this);
      h = jQuery(this).prop("checked");
      if (0 < f && 0 < j && f != j) {
        d.slice(f, j).prop("checked", function () {
          if (jQuery(this).closest("tr").is(":visible")) {
            return h
          }
          return false
        })
      }
    }
    i = this;
    var k = jQuery(this).closest("tbody").find(":checkbox").filter(":visible").not(":checked");
    jQuery(this).closest("table").children("thead, tfoot").find(":checkbox").prop("checked", function () {
      return(0 == k.length)
    });
    return true
  });
  jQuery("thead, tfoot").find(".check-column :checkbox").click(function (m) {
    var n = jQuery(this).prop("checked"), l = "undefined" == typeof toggleWithKeyboard ? false : toggleWithKeyboard, k = m.shiftKey || l;
    jQuery(this).closest("table").children("tbody").filter(":visible").children().children(".check-column").find(":checkbox").prop("checked", function () {
      if (jQuery(this).is(":hidden")) {
        return false
      }
      if (k) {
        return jQuery(this).prop("checked")
      } else {
        if (n) {
          return true
        }
      }
      return false
    });
    jQuery(this).closest("table").children("thead,  tfoot").filter(":visible").children().children(".check-column").find(":checkbox").prop("checked", function () {
      if (k) {
        return false
      } else {
        if (n) {
          return true
        }
      }
      return false
    })
  });
}

// Set value by id.
function spider_set_input_value(input_id, input_value) {
  if (document.getElementById(input_id)) {
    document.getElementById(input_id).value = input_value;
  }
}

// Submit form by id.
function spider_form_submit(event, form_id) {
  if (document.getElementById(form_id)) {
    document.getElementById(form_id).submit();
  }
  if (event.preventDefault) {
    event.preventDefault();
  }
  else {
    event.returnValue = false;
  }
}

// Check if required field is empty.
function spider_check_required(id, name) {
  if (jQuery('#' + id).val() == '') {
    alert(name + '* field is required.');
    jQuery('#' + id).attr('style', 'border-color: #FF0000;');
    jQuery('#' + id).focus();
    jQuery('html, body').animate({
      scrollTop:jQuery('#' + id).offset().top - 200
    }, 500);
    return true;
  }
  else {
    return false;
  }
}

function wds_check_required(id, name) {
  if (jQuery('#' + id).val() == '') {
    alert(name + '* field is required.');
    wds_change_tab(jQuery(".wds_tab_label[tab_type='slides']"), 'wds_slides_box');
    jQuery('#' + id).attr('style', 'border-color: #FF0000;');
    jQuery('#' + id).focus();
    jQuery('html, body').animate({
      scrollTop:jQuery('#' + id).offset().top - 200
    }, 500);
    return true;
  }
  else {
    return false;
  }
}

// Show/hide order column and drag and drop column.
function spider_show_hide_weights() {
  if (jQuery("#show_hide_weights").val() == 'Show order column') {
    jQuery(".connectedSortable").css("cursor", "default");
    jQuery("#tbody_arr").find(".handle").hide(0);
    jQuery("#th_order").show(0);
    jQuery("#tbody_arr").find(".spider_order").show(0);
    jQuery("#show_hide_weights").val("Hide order column");
    if (jQuery("#tbody_arr").sortable()) {
      jQuery("#tbody_arr").sortable("disable");
    }
  }
  else {
    jQuery(".connectedSortable").css("cursor", "move");
    var page_number;
    if (jQuery("#page_number") && jQuery("#page_number").val() != '' && jQuery("#page_number").val() != 1) {
      page_number = (jQuery("#page_number").val() - 1) * 20 + 1;
    }
    else {
      page_number = 1;
    }
    jQuery("#tbody_arr").sortable({
      handle:".connectedSortable",
      connectWith:".connectedSortable",
      update:function (event, tr) {
        jQuery("#draganddrop").attr("style", "");
        jQuery("#draganddrop").html("<strong><p>Changes made in this table should be saved.</p></strong>");
        var i = page_number;
        jQuery('.spider_order').each(function (e) {
          if (jQuery(this).find('input').val()) {
            jQuery(this).find('input').val(i++);
          }
        });
      }
    });//.disableSelection();
    jQuery("#tbody_arr").sortable("enable");
    jQuery("#tbody_arr").find(".handle").show(0);
    jQuery("#tbody_arr").find(".handle").attr('class', 'handle connectedSortable');
    jQuery("#th_order").hide(0);
    jQuery("#tbody_arr").find(".spider_order").hide(0);
    jQuery("#show_hide_weights").val("Show order column");
  }
}

// Check all items.
function spider_check_all_items() {
  spider_check_all_items_checkbox();
  // if (!jQuery('#check_all').attr('checked')) {
    jQuery('#check_all').trigger('click');
  // }
}

function spider_check_all_items_checkbox() {
  if (jQuery('#check_all_items').attr('checked')) {
    jQuery('#check_all_items').attr('checked', false);
    jQuery('#draganddrop').hide();
  }
  else {
    var saved_items = (parseInt(jQuery(".displaying-num").html()) ? parseInt(jQuery(".displaying-num").html()) : 0);
    var added_items = (jQuery('input[id^="check_pr_"]').length ? parseInt(jQuery('input[id^="check_pr_"]').length) : 0);
    var items_count = added_items + saved_items;
    jQuery('#check_all_items').attr('checked', true);
    if (items_count) {
      jQuery('#draganddrop').html("<strong><p>Selected " + items_count + " item" + (items_count > 1 ? "s" : "") + ".</p></strong>");
      jQuery('#draganddrop').show();
    }
  }
}

function spider_check_all(current) {
  if (!jQuery(current).attr('checked')) {
    jQuery('#check_all_items').attr('checked', false);
    jQuery('#draganddrop').hide();
  }
}

// Set uploader to button class.
function spider_uploader(button_id, input_id, delete_id, img_id) {
  if (typeof img_id == 'undefined') {
    img_id = '';
  }
  jQuery(function () {
    var formfield = null;
    window.original_send_to_editor = window.send_to_editor;
    window.send_to_editor = function (html) {
      if (formfield) {
        var fileurl = jQuery('img', html).attr('src');
        if (!fileurl) {
          var exploded_html;
          var exploded_html_askofen;
          exploded_html = html.split('"');
          for (i = 0; i < exploded_html.length; i++) {
            exploded_html_askofen = exploded_html[i].split("'");
          }
          for (i = 0; i < exploded_html.length; i++) {
            for (j = 0; j < exploded_html_askofen.length; j++) {
              if (exploded_html_askofen[j].search("href")) {
                fileurl = exploded_html_askofen[i + 1];
                break;
              }
            }
          }
          if (img_id != '') {
            alert('You must select an image file.');
            tb_remove();
            return;
          }
          window.parent.document.getElementById(input_id).value = fileurl;
          window.parent.document.getElementById(button_id).style.display = "none";
          window.parent.document.getElementById(input_id).style.display = "inline-block";
          window.parent.document.getElementById(delete_id).style.display = "inline-block";
        }
        else {
          if (img_id == '') {
            alert('You must select an audio file.');
            tb_remove();
            return;
          }
          window.parent.document.getElementById(input_id).value = fileurl;
          window.parent.document.getElementById(button_id).style.display = "none";
          window.parent.document.getElementById(delete_id).style.display = "inline-block";
          if ((img_id != '') && window.parent.document.getElementById(img_id)) {
            window.parent.document.getElementById(img_id).src = fileurl;
            window.parent.document.getElementById(img_id).style.display = "inline-block";
          }
        }
        formfield.val(fileurl);
        tb_remove();
      }
      else {
        window.original_send_to_editor(html);
      }
      formfield = null;
    };
    formfield = jQuery(this).parent().parent().find(".url_input");
    tb_show('', 'media-upload.php?type=image&TB_iframe=true');
    jQuery('#TB_overlay,#TB_closeWindowButton').bind("click", function () {
      formfield = null;
    });
    return false;
  });
}

// Remove uploaded file.
function spider_remove_url(input_id, img_id) {
  var id = input_id.substr(9);
  if (typeof img_id == 'undefined') {
    img_id = '';
  }
  if (document.getElementById(input_id)) {
    document.getElementById(input_id).value = '';
  }
  if ((img_id != '') && document.getElementById(img_id)) {
    document.getElementById(img_id).style.backgroundImage = "url('')";
  }
}

function spider_reorder_items(tbody_id) {
  jQuery("#" + tbody_id).sortable({
    handle: ".connectedSortable",
    connectWith: ".connectedSortable",
    update: function (event, tr) {
      spider_sortt(tbody_id);
    }
  });
}

function spider_sortt(tbody_id) {
  var str = "";
  var counter = 0;
  jQuery("#" + tbody_id).children().each(function () {
    str += ((jQuery(this).attr("id")).substr(3) + ",");
    counter++;
  });
  jQuery("#albums_galleries").val(str);
  if (!counter) {
    document.getElementById("table_albums_galleries").style.display = "none";
  }
}

function spider_remove_row(tbody_id, event, obj) {
  var span = obj;
  var tr = jQuery(span).closest("tr");
  jQuery(tr).remove();
  spider_sortt(tbody_id);
}

function spider_jslider(idtaginp) {
  jQuery(function () {
    var inpvalue = jQuery("#" + idtaginp).val();
    if (inpvalue == "") {
      inpvalue = 50;
    }
    jQuery("#slider-" + idtaginp).slider({
      range:"min",
      value:inpvalue,
      min:1,
      max:100,
      slide:function (event, ui) {
        jQuery("#" + idtaginp).val("" + ui.value);
      }
    });
    jQuery("#" + idtaginp).val("" + jQuery("#slider-" + idtaginp).slider("value"));
  });
}

function spider_get_items(e) {
  if (e.preventDefault) {
    e.preventDefault();
  }
  else {
    e.returnValue = false;
  }
  var trackIds = [];
  var titles = [];
  var types = [];
  var tbody = document.getElementById('tbody_albums_galleries');
  var trs = tbody.getElementsByTagName('tr');
  for (j = 0; j < trs.length; j++) {
    i = trs[j].getAttribute('id').substr(3);
    if (document.getElementById('check_' + i).checked) {
      trackIds.push(document.getElementById("id_" + i).innerHTML);
      titles.push(document.getElementById("a_" + i).innerHTML);
      types.push(document.getElementById("url_" + i).innerHTML == "Album" ? 1 : 0);
    }
  }
  window.parent.bwg_add_items(trackIds, titles, types);
}

function preview_built_in_watermark() {
  setTimeout(function() {
    watermark_type = window.parent.document.getElementById('built_in_watermark_type_text').checked;
    if (watermark_type) {
      watermark_text = document.getElementById('built_in_watermark_text').value;
      watermark_font_size = document.getElementById('built_in_watermark_font_size').value * 400 / 500;
      watermark_font = 'bwg_' + document.getElementById('built_in_watermark_font').value.replace('.TTF', '').replace('.ttf', '');
      watermark_color = document.getElementById('built_in_watermark_color').value;
      watermark_opacity = 100 - document.getElementById('built_in_watermark_opacity').value;
      watermark_position = jQuery("input[name=built_in_watermark_position]:checked").val().split('-');
      document.getElementById("preview_built_in_watermark").style.verticalAlign = watermark_position[0];
      document.getElementById("preview_built_in_watermark").style.textAlign = watermark_position[1];
      stringHTML = '<span style="cursor:default;margin:4px;font-size:' + watermark_font_size + 'px;font-family:' + watermark_font + ';color:#' + watermark_color + ';opacity:' + (watermark_opacity / 100) + ';filter: Alpha(opacity=' + watermark_opacity + ');" class="non_selectable">' + watermark_text + '</span>';
      document.getElementById("preview_built_in_watermark").innerHTML = stringHTML;
    }
    watermark_type = window.parent.document.getElementById('built_in_watermark_type_image').checked;
    if (watermark_type) {
      watermark_url = document.getElementById('built_in_watermark_url').value;
      watermark_size = document.getElementById('built_in_watermark_size').value;
      watermark_position = jQuery("input[name=built_in_watermark_position]:checked").val().split('-');
      document.getElementById("preview_built_in_watermark").style.verticalAlign = watermark_position[0];
      document.getElementById("preview_built_in_watermark").style.textAlign = watermark_position[1];
      stringHTML = '<img class="non_selectable" src="' + watermark_url + '" style="margin:0 4px 0 4px;max-width:95%;width:' + watermark_size + '%;" />';
      document.getElementById("preview_built_in_watermark").innerHTML = stringHTML;
    }
  }, 50);
}

function bwg_built_in_watermark(watermark_type) {
  jQuery("#built_in_" + watermark_type).attr('checked', 'checked');
  jQuery("#tr_built_in_watermark_url").css('display', 'none');
  jQuery("#tr_built_in_watermark_size").css('display', 'none');
  jQuery("#tr_built_in_watermark_opacity").css('display', 'none');
  jQuery("#tr_built_in_watermark_text").css('display', 'none');
  jQuery("#tr_built_in_watermark_font_size").css('display', 'none');
  jQuery("#tr_built_in_watermark_font").css('display', 'none');
  jQuery("#tr_built_in_watermark_color").css('display', 'none');
  jQuery("#tr_built_in_watermark_position").css('display', 'none');
  jQuery("#tr_built_in_watermark_preview").css('display', 'none');
  jQuery("#preview_built_in_watermark").css('display', 'none');
  switch (watermark_type) {
    case 'watermark_type_text':
    {
      jQuery("#tr_built_in_watermark_opacity").css('display', '');
      jQuery("#tr_built_in_watermark_text").css('display', '');
      jQuery("#tr_built_in_watermark_font_size").css('display', '');
      jQuery("#tr_built_in_watermark_font").css('display', '');
      jQuery("#tr_built_in_watermark_color").css('display', '');
      jQuery("#tr_built_in_watermark_position").css('display', '');
      jQuery("#tr_built_in_watermark_preview").css('display', '');
      jQuery("#preview_built_in_watermark").css('display', 'table-cell');
      break;
    }
    case 'watermark_type_image':
    {
      jQuery("#tr_built_in_watermark_url").css('display', '');
      jQuery("#tr_built_in_watermark_size").css('display', '');
      jQuery("#tr_built_in_watermark_position").css('display', '');
      jQuery("#tr_built_in_watermark_preview").css('display', '');
      jQuery("#preview_built_in_watermark").css('display', 'table-cell');
      break;
    }
  }
}

function bwg_inputs() {
  jQuery(".spider_int_input").keypress(function (event) {
    var chCode1 = event.which || event.paramlist_keyCode;
    if (chCode1 > 31 && (chCode1 < 48 || chCode1 > 57) && (chCode1 != 46) && (chCode1 != 45)) {
      return false;
    }
    return true;
  });
}

function bwg_enable_disable(display, id, current) {
  jQuery("#" + current).attr('checked', 'checked');
  jQuery("#" + id).css('display', display);
}
function bwg_enable_disable_autoplay(display, id, current) { 
  jQuery("#" + current).attr('checked', 'checked');
  jQuery("." + id).css('visibility', display); 
}

function change_rl_butt_style(type_key) {
  jQuery("#wds_left_style").removeClass().addClass("fa " + type_key + "-left");
  jQuery("#wds_right_style").removeClass().addClass("fa " + type_key + "-right");
}

function change_bull_style(type_key) {
  jQuery("#wds_act_bull_style").removeClass().addClass("fa " + type_key.replace("-o", ""));
  jQuery("#wds_deact_bull_style").removeClass().addClass("fa " + type_key);
}

function change_rl_butt_type(that) {
  var type_key = jQuery(that).attr('value');
  src	= rl_butt_dir + wds_rl_butt_type[type_key]["type_name"] + '/1/1.png';
  var options = '';
  var divs = '';
  for (var i = 0; i < wds_rl_butt_type[type_key].length - 1; i++) {
    var num = i + 1;
    divs += '<div class="spider_option_cont" value="' + i + '"  onclick="change_rl_butt_color(this, ' + type_key + ')" > ' +
			  '<div  class="spider_option_cont_title" >' +
			    'Color-'+ num +
			  '</div>' +
			  '<div class="spider_option_cont_img" >' + 
			    '<img  src="' + rl_butt_dir + wds_rl_butt_type[type_key]["type_name"] + '/'+wds_rl_butt_type[type_key][i]+'/1.png" style="display:inline-block; width: 14px; height: 14px;" />' + 
			    '<img  src="' + rl_butt_dir + wds_rl_butt_type[type_key]["type_name"] + '/'+wds_rl_butt_type[type_key][i]+'/2.png" style="display:inline-block; width: 14px; height: 14px;" />' + 
			    '<img  src="' + rl_butt_dir + wds_rl_butt_type[type_key]["type_name"] + '/'+wds_rl_butt_type[type_key][i]+'/3.png" style="display:inline-block; width: 14px; height: 14px;" />' + 
			    '<img  src="' + rl_butt_dir + wds_rl_butt_type[type_key]["type_name"] + '/'+wds_rl_butt_type[type_key][i]+'/4.png" style="display:inline-block; width: 14px; height: 14px;" />' + 
			  '</div>' +
		    '</div>';
  }
  jQuery(".spider_options_cont .spider_option_cont").css({backgroundColor: ""});
  jQuery(that).css({backgroundColor: "#3399FF"});
  jQuery('.spider_options_color_cont').html(divs);
  jQuery('#rl_butt_img_l').attr("src", rl_butt_dir + wds_rl_butt_type[type_key]["type_name"] + '/1/1.png');
  jQuery('#rl_butt_img_r').attr("src", rl_butt_dir + wds_rl_butt_type[type_key]["type_name"] + '/1/2.png');
  jQuery('#rl_butt_hov_img_l').attr("src", rl_butt_dir + wds_rl_butt_type[type_key]["type_name"] + '/1/3.png');
  jQuery('#rl_butt_hov_img_r').attr("src", rl_butt_dir + wds_rl_butt_type[type_key]["type_name"] + '/1/4.png');

  jQuery('#left_butt_url').val(rl_butt_dir + wds_rl_butt_type[type_key]["type_name"] + '/1/1.png');
  jQuery('#right_butt_url').val(rl_butt_dir + wds_rl_butt_type[type_key]["type_name"] + '/1/2.png');
  jQuery('#left_butt_hov_url').val(rl_butt_dir + wds_rl_butt_type[type_key]["type_name"] + '/1/3.png');
  jQuery('#right_butt_hov_url').val(rl_butt_dir + wds_rl_butt_type[type_key]["type_name"] + '/1/4.png');
}

function change_play_paus_butt_type(that) {
  var type_key = jQuery(that).attr('value');
  var src	= pp_butt_dir + wds_pp_butt_type[type_key]["type_name"] + '/1/1.png';
  var options = '';
  var divs = '';
  for (var i = 0; i < wds_pp_butt_type[type_key].length; i++) {
    var num = i + 1;
    divs += '<div class="spider_option_cont" value="' + i + '" onclick="change_play_paus_butt_color(this, ' + type_key + ')" > ' +
			  '<div  class="spider_option_cont_title" >' +
			    'Color-'+ num +
			  '</div>' +
			  '<div class="spider_option_cont_img" >' + 
			    '<img  src="' + pp_butt_dir + wds_pp_butt_type[type_key]["type_name"] + '/'+wds_pp_butt_type[type_key][i]+'/1.png" style="display:inline-block; width: 14px; height: 14px;" />' + 
			    '<img  src="' + pp_butt_dir + wds_pp_butt_type[type_key]["type_name"] + '/'+wds_pp_butt_type[type_key][i]+'/2.png" style="display:inline-block; width: 14px; height: 14px;" />' + 
			    '<img  src="' + pp_butt_dir + wds_pp_butt_type[type_key]["type_name"] + '/'+wds_pp_butt_type[type_key][i]+'/3.png" style="display:inline-block; width: 14px; height: 14px;" />' + 
			    '<img  src="' + pp_butt_dir + wds_pp_butt_type[type_key]["type_name"] + '/'+wds_pp_butt_type[type_key][i]+'/4.png" style="display:inline-block; width: 14px; height: 14px;" />' + 
			  '</div>' +
		    '</div>';
  }
  jQuery(".spider_pp_options_cont .spider_option_cont").css({backgroundColor: ""});
  jQuery(that).css({backgroundColor: "#3399FF"});
  jQuery('.spider_pp_options_color_cont').html(divs);
  jQuery('#pp_butt_img_play').attr("src", pp_butt_dir + wds_pp_butt_type[type_key]["type_name"] + '/1/1.png');
  jQuery('#pp_butt_img_paus').attr("src", pp_butt_dir + wds_pp_butt_type[type_key]["type_name"] + '/1/3.png');
  jQuery('#pp_butt_hov_img_play').attr("src", pp_butt_dir + wds_pp_butt_type[type_key]["type_name"] + '/1/2.png');
  jQuery('#pp_butt_hov_img_paus').attr("src", pp_butt_dir + wds_pp_butt_type[type_key]["type_name"] + '/1/4.png');

  jQuery('#play_butt_url').val(pp_butt_dir + wds_pp_butt_type[type_key]["type_name"] + '/1/1.png');
  jQuery('#paus_butt_url').val(pp_butt_dir + wds_pp_butt_type[type_key]["type_name"] + '/1/3.png');
  jQuery('#play_butt_hov_url').val(pp_butt_dir + wds_pp_butt_type[type_key]["type_name"] + '/1/2.png');
  jQuery('#paus_butt_hov_url').val(pp_butt_dir + wds_pp_butt_type[type_key]["type_name"] + '/1/4.png');
}

function change_rl_butt_color(that, type_key) {
  var color_key = jQuery(that).attr('value');
  jQuery(".spider_options_color_cont .spider_option_cont").css({backgroundColor: ""});
  jQuery(that).css({backgroundColor: "#3399FF"});
  var src = rl_butt_dir + wds_rl_butt_type[type_key]["type_name"] + '/' + wds_rl_butt_type[type_key][color_key];
  jQuery('#rl_butt_img_l').attr("src", src + '/1.png');
  jQuery('#rl_butt_img_r').attr("src", src + '/2.png');
  jQuery('#rl_butt_hov_img_l').attr("src", src + '/3.png');
  jQuery('#rl_butt_hov_img_r').attr("src", src + '/4.png');

  jQuery('#left_butt_url').val(src + '/1.png');
  jQuery('#right_butt_url').val(src + '/2.png');
  jQuery('#left_butt_hov_url').val(src + '/3.png');
  jQuery('#right_butt_hov_url').val(src + '/4.png');
}

function change_play_paus_butt_color(that, type_key) {
  var color_key = jQuery(that).attr('value');
  jQuery(".spider_pp_options_color_cont .spider_option_cont").css({backgroundColor: ""});
  jQuery(that).css({backgroundColor: "#3399FF"});
  var src = pp_butt_dir + wds_pp_butt_type[type_key]["type_name"] + '/' + wds_pp_butt_type[type_key][color_key];
  jQuery('#pp_butt_img_play').attr("src", src + '/1.png');
  jQuery('#pp_butt_img_paus').attr("src", src + '/3.png');
  jQuery('#pp_butt_hov_img_play').attr("src", src + '/2.png');
  jQuery('#pp_butt_hov_img_paus').attr("src", src + '/4.png');

  jQuery('#play_butt_url').val(src + '/1.png');
  jQuery('#paus_butt_url').val(src + '/3.png');
  jQuery('#play_butt_hov_url').val(src + '/2.png');
  jQuery('#paus_butt_hov_url').val(src + '/4.png');
}

function change_src() {
  var src_l = jQuery('#rl_butt_img_l').attr("src");
  var src_r = jQuery('#rl_butt_img_r').attr("src");

  var src_h_l = jQuery('#rl_butt_hov_img_l').attr("src");
  var src_h_r = jQuery('#rl_butt_hov_img_r').attr("src");

  jQuery('#rl_butt_img_l').attr("src", src_h_l);
  jQuery('#rl_butt_img_r').attr("src", src_h_r);
  jQuery('#rl_butt_hov_img_l').attr("src", src_l);
  jQuery('#rl_butt_hov_img_r').attr("src", src_r);

  jQuery('#left_butt_url').val(src_h_l);
  jQuery('#right_butt_url').val(src_h_r);
  jQuery('#left_butt_hov_url').val(src_l);
  jQuery('#right_butt_hov_url').val(src_r);
}

function wds_choose_option(that) {
  jQuery('.spider_options_cont').toggle(1, function() {});
  jQuery(that).find("i").toggleClass("fa-angle-down").toggleClass("fa-angle-up");
}

function wds_choose_option_color(that) {
  jQuery('.spider_options_color_cont').toggle(1, function() {});
  jQuery(that).find("i").toggleClass("fa-angle-down").toggleClass("fa-angle-up");
}

function wds_choose_pp_option(that) {
  jQuery('.spider_pp_options_cont').toggle(1, function() {});
  jQuery(that).find("i").toggleClass("fa-angle-down").toggleClass("fa-angle-up");
}

function wds_choose_pp_option_color(that) {
  jQuery('.spider_pp_options_color_cont').toggle(1, function() {});
  jQuery(that).find("i").toggleClass("fa-angle-down").toggleClass("fa-angle-up");
}

function wds_choose_bull_option(that) {
  jQuery('.spider_bull_options_cont').toggle(1, function() {});
  jQuery(that).find("i").toggleClass("fa-angle-down").toggleClass("fa-angle-up");
}

function wds_choose_bull_option_color(that) {
  jQuery('.spider_bull_options_color_cont').toggle(1, function() {});
  jQuery(that).find("i").toggleClass("fa-angle-down").toggleClass("fa-angle-up");
}

function wds_change_custom_src() {
  var src_l = jQuery('#left_butt_img').attr("src");
  var src_r = jQuery('#right_butt_img').attr("src");

  var src_h_l = jQuery('#left_butt_hov_img').attr("src");
  var src_h_r = jQuery('#right_butt_hov_img').attr("src");

  jQuery('#left_butt_img').attr("src", src_h_l);
  jQuery('#right_butt_img').attr("src", src_h_r);
  jQuery('#left_butt_hov_img').attr("src", src_l);
  jQuery('#right_butt_hov_img').attr("src", src_r);

  jQuery('#left_butt_url').val(src_h_l);
  jQuery('#right_butt_url').val(src_h_r);
  jQuery('#left_butt_hov_url').val(src_l);
  jQuery('#right_butt_hov_url').val(src_r);
}

function wds_change_play_paus_custom_src() {
  var src_l = jQuery('#play_butt_img').attr("src");
  var src_r = jQuery('#paus_butt_img').attr("src");

  var src_h_l = jQuery('#play_butt_hov_img').attr("src");
  var src_h_r = jQuery('#paus_butt_hov_img').attr("src");

  jQuery('#play_butt_img').attr("src", src_h_l);
  jQuery('#paus_butt_img').attr("src", src_h_r);
  jQuery('#play_butt_hov_img').attr("src", src_l);
  jQuery('#paus_butt_hov_img').attr("src", src_r);

  jQuery('#play_butt_url').val(src_h_l);
  jQuery('#paus_butt_url').val(src_h_r);
  jQuery('#play_butt_hov_url').val(src_l);
  jQuery('#paus_butt_hov_url').val(src_r);
}


function change_play_paus_src() {
  var src_l = jQuery('#pp_butt_img_play').attr("src");
  var src_r = jQuery('#pp_butt_img_paus').attr("src");

  var src_h_l = jQuery('#pp_butt_hov_img_play').attr("src");
  var src_h_r = jQuery('#pp_butt_hov_img_paus').attr("src");

  jQuery('#pp_butt_img_play').attr("src", src_h_l);
  jQuery('#pp_butt_img_paus').attr("src", src_h_r);
  jQuery('#pp_butt_hov_img_play').attr("src", src_l);
  jQuery('#pp_butt_hov_img_paus').attr("src", src_r);

  jQuery('#play_butt_url').val(src_h_l);
  jQuery('#paus_butt_url').val(src_h_r);
  jQuery('#play_butt_hov_url').val(src_l);
  jQuery('#paus_butt_hov_url').val(src_r);
}

function wds_change_bullets_custom_src() {
  var src_m = jQuery('#bull_img_main').attr("src");
  var src_h = jQuery('#bull_img_hov').attr("src"); 

  jQuery('#bull_img_main').attr("src", src_h);
  jQuery('#bull_img_hov').attr("src", src_m);

  jQuery('#bullets_img_main_url').val(src_h);
  jQuery('#bullets_img_hov_url').val(src_m);
}

function change_bullets_images_type(that) {
  var type_key = jQuery(that).attr('value');
  var src	= blt_img_dir + wds_blt_img_type[type_key]["type_name"] + '/1/1.png';
  var options = '';
  var divs = '';
  for (var i = 0; i < wds_blt_img_type[type_key].length-1; i++) {
    var num = i + 1;
    divs += '<div class="spider_option_cont" value="'+i+'"  onclick="change_bullets_images_color(this, ' + type_key + ')" > ' +
			  '<div  class="spider_option_cont_title" style="width: 64%" >' +
				'Color-'+ num +
			  '</div>' +
			  '<div class="spider_option_cont_img" style="width: 22%;padding: 6px 5px 0px 5px;" >' + 
				'<img  src="' + blt_img_dir + wds_blt_img_type[type_key]["type_name"] + '/'+wds_blt_img_type[type_key][i]+'/1.png" style="display:inline-block; width: 14px; height: 14px;" />' + 
				'<img  src="' + blt_img_dir + wds_blt_img_type[type_key]["type_name"] + '/'+wds_blt_img_type[type_key][i]+'/2.png" style="display:inline-block; width: 14px; height: 14px;" />' + 
			  '</div>' +
			'</div>';
	
  }
  jQuery(".spider_bull_options_cont .spider_option_cont").css({backgroundColor: ""});
  jQuery(that).css({backgroundColor: "#3399FF"});
  var select = '<select class="select_icon"  name="bullets_images_color" id="bullets_images_color" onchange="change_bullets_images_color(this, '+type_key+')">' + options + '</select>';
  jQuery('.spider_bull_options_color_cont').html(divs);
  jQuery('#bullets_images_color_cont').html(select);
  jQuery('#bullets_img_main').attr("src", blt_img_dir + wds_blt_img_type[type_key]["type_name"] + '/1/1.png');
  jQuery('#bullets_img_hov').attr("src", blt_img_dir + wds_blt_img_type[type_key]["type_name"] + '/1/2.png');

  jQuery('#bullets_img_main_url').val(blt_img_dir + wds_blt_img_type[type_key]["type_name"] + '/1/1.png');
  jQuery('#bullets_img_hov_url').val(blt_img_dir + wds_blt_img_type[type_key]["type_name"] + '/1/2.png');
}

function change_bullets_images_color(that, type_key) {
  var color_key = jQuery(that).attr('value');
  jQuery(".spider_bull_options_color_cont .spider_option_cont").css({backgroundColor: ""});
  jQuery(that).css({backgroundColor: "#3399FF"});
  var src = blt_img_dir + wds_blt_img_type[type_key]["type_name"] + '/' + wds_blt_img_type[type_key][color_key];
  jQuery('#bullets_img_main').attr("src", src + '/1.png');
  jQuery('#bullets_img_hov').attr("src", src + '/2.png');

  jQuery('#bullets_img_main_url').val(src + '/1.png');
  jQuery('#bullets_img_hov_url').val(src + '/2.png');
}

function change_bullets_src() {
  var src_l = jQuery('#bullets_img_main').attr("src");
  var src_r = jQuery('#bullets_img_hov').attr("src");

  jQuery('#bullets_img_main').attr("src", src_r);
  jQuery('#bullets_img_hov').attr("src", src_l);

  jQuery('#bullets_img_main_url').val(src_r);
  jQuery('#bullets_img_hov_url').val(src_l);
}

function image_for_next_prev_butt(display) {
  switch (display) {
    case 'our' : {
      jQuery("#rl_butt_img_or_not_our").attr('checked', 'checked');
      jQuery("#right_left_butt_style").css('display', 'none');
      jQuery("#right_butt_upl").css('display', 'none');
      jQuery("#right_left_butt_select").css('display', '');
      jQuery("#tr_butts_color").css('display', 'none');
      jQuery("#tr_hover_color").css('display', 'none');
      break;
    }
    case 'custom' : {
      jQuery("#rl_butt_img_or_not_custom").attr('checked', 'checked');
      jQuery("#right_butt_upl").css('display', '');
      jQuery("#right_left_butt_select").css('display', 'none');
      jQuery("#right_left_butt_style").css('display', 'none');
      jQuery("#tr_butts_color").css('display', 'none');
      jQuery("#tr_hover_color").css('display', 'none');
      break;
    }
    case 'style' : {
      jQuery("#rl_butt_img_or_not_0").attr('checked', 'checked');
      jQuery("#right_butt_upl").css('display', 'none');
      jQuery("#right_left_butt_select").css('display', 'none');
      jQuery("#right_left_butt_style").css('display', '');
      jQuery("#tr_butts_color").css('display', '');
      jQuery("#tr_hover_color").css('display', '');
      break;
    }
    default: {
      break;
    }
  }
}

function image_for_bull_butt(display) {
  switch (display) {
    case 'our' : {
      jQuery("#bull_butt_img_or_not_our").attr('checked', 'checked');
      jQuery("#bullets_style").css('display', 'none');
      jQuery("#bullets_images_cust").css('display', 'none');  
      jQuery("#bullets_images_select").css('display', '');
      jQuery("#bullets_act_color").css('display', 'none');
      jQuery("#bullets_color").css('display', 'none');
      jQuery("#bullets_back_act_color").css('display', 'none');
      jQuery("#bullets_back_color").css('display', 'none');
      jQuery("#bullets_radius").css('display', 'none');
      break;
    }

    case 'custom' : {
      jQuery("#bull_butt_img_or_not_cust").attr('checked', 'checked');
      jQuery("#bullets_images_cust").css('display', '');
      jQuery("#bullets_images_select").css('display', 'none');
      jQuery("#bullets_style").css('display', 'none');
      jQuery("#bullets_act_color").css('display', 'none');
      jQuery("#bullets_color").css('display', 'none');
      jQuery("#bullets_back_act_color").css('display', 'none');
      jQuery("#bullets_back_color").css('display', 'none');
      jQuery("#bullets_radius").css('display', 'none');
      break;
    }
	
    case 'style' : {
      jQuery("#bull_butt_img_or_not_stl").attr('checked', 'checked');
      jQuery("#bullets_images_select").css('display', 'none');
	  jQuery("#bullets_images_cust").css('display', 'none');  
      jQuery("#bullets_style").css('display', '');
      jQuery("#bullets_act_color").css('display', '');
      jQuery("#bullets_color").css('display', '');
      jQuery("#bullets_back_act_color").css('display', 'none');
      jQuery("#bullets_back_color").css('display', 'none');
      jQuery("#bullets_radius").css('display', 'none');
      break;
    }
    case 'text' : {
      jQuery("#bull_butt_img_or_not_txt").attr('checked', 'checked');
      jQuery("#bullets_images_select").css('display', 'none');
	    jQuery("#bullets_images_cust").css('display', 'none');  
      jQuery("#bullets_style").css('display', 'none');
      jQuery("#bullets_act_color").css('display', 'none');
      jQuery("#bullets_color").css('display', '');
      jQuery("#bullets_back_act_color").css('display', '');
      jQuery("#bullets_back_color").css('display', '');
      jQuery("#bullets_radius").css('display', '');
      break;
    }
    default: {
      break;
    }
  }
}

function showhide_for_carousel_fildes(display) {
  if (display == 1) {
   jQuery("#carousel1").attr('checked', 'checked');
   jQuery("#carousel_fildes").css('display', '');
  }
  else {
   jQuery("#carousel0" ).attr('checked', 'checked');
   jQuery("#carousel_fildes").css('display', 'none');
  }
}

function image_for_play_pause_butt(display) {
  switch (display) {
    case 'our' : {
      jQuery("#play_pause_butt_img_or_not_our").attr('checked', 'checked');
      jQuery("#play_pause_butt_style").css('display', 'none');
      jQuery("#play_pause_butt_cust").css('display', 'none');
      jQuery("#play_pause_butt_select").css('display', '');
      jQuery("#tr_butts_color").css('display', 'none');
      jQuery("#tr_hover_color").css('display', 'none');
      break;
    }
    case 'custom' : {
      jQuery("#play_pause_butt_img_or_not_cust").attr('checked', 'checked');
      jQuery("#play_pause_butt_cust").css('display', '');
      jQuery("#play_pause_butt_select").css('display', 'none');
      jQuery("#play_pause_butt_style").css('display', 'none');
      jQuery("#tr_butts_color").css('display', 'none');
      jQuery("#tr_hover_color").css('display', 'none');
      break;
    }
    case 'style' : {
      jQuery("#play_pause_butt_img_or_not_style").attr('checked', 'checked');
      jQuery("#play_pause_butt_cust").css('display', 'none');
      jQuery("#play_pause_butt_select").css('display', 'none');
      jQuery("#play_pause_butt_style").css('display', '');
      jQuery("#tr_butts_color").css('display', '');
      jQuery("#tr_hover_color").css('display', '');
      break;
    }
    default: {
      break;
    }
  }
}

function bwg_change_album_view_type(type) {
  if (type == 'thumbnail') {
    jQuery("#album_thumb_dimensions").html('Album thumb dimensions: ');
	jQuery("#album_thumb_dimensions_x").css('display', '');
	jQuery("#album_thumb_height").css('display', '');
  }
  else {
    jQuery("#album_thumb_dimensions").html('Album thumb width: '); 
    jQuery("#album_thumb_dimensions_x").css('display', 'none');
	jQuery("#album_thumb_height").css('display', 'none');
  }
}

function spider_check_isnum(e) {
  var chCode1 = e.which || e.paramlist_keyCode;
  if (chCode1 > 31 && (chCode1 < 48 || chCode1 > 57) && (chCode1 != 46) && (chCode1 != 45)) {
    return false;
  }
  return true;
}

function wds_add_image_url(id) {
  jQuery('#add_image_url_button').attr("onclick", "if (spider_set_image_url('" + id + "')) {jQuery('.opacity_add_image_url').hide();} return false;");
  jQuery('.opacity_add_image_url').show();
  return false;
}
function spider_set_image_url(id) {
  if (!jQuery("#image_url_input").val()) {
    return false;
  }
  jQuery("#image_url" + id).val(jQuery("#image_url_input").val());
  jQuery("#thumb_url" + id).val(jQuery("#image_url_input").val());
  jQuery("#wds_preview_image" + id).css("background-image", "url('" + jQuery("#image_url_input").val() + "')");
  jQuery("#wds_tab_image" + id).css("background-image", "url('" + jQuery("#image_url_input").val() + "')");
  jQuery("#delete_image_url" + id).css("display", "inline-block");
  jQuery("#wds_preview_image" + id).css("display", "inline-block");
  jQuery("#image_url_input").val("");
  jQuery("#type" + id).val("image");
  jQuery("#trlink" + id).show();
  return true;
}

function spider_media_uploader(id, e, multiple) {
  if (typeof multiple == "undefined") {
    var multiple = false;
  }
  var custom_uploader;
  e.preventDefault();
  // If the uploader object has already been created, reopen the dialog.
  if (custom_uploader) {
    custom_uploader.open();
    // return;
  }
  // Extend the wp.media object.
  var library_type = (id == 'music') ? 'audio' : 'image'
  custom_uploader = wp.media.frames.file_frame = wp.media({
    title: 'Choose ' + library_type,
    library : { type : library_type},
    button: { text: 'Insert'},
    multiple: multiple
  });
  // When a file is selected, grab the URL and set it as the text field's value
  custom_uploader.on('select', function() {
    if (multiple == false) {
      attachment = custom_uploader.state().get('selection').first().toJSON();
    }
    else {
      attachment = custom_uploader.state().get('selection').toJSON();
    }
    var image_url = attachment.url;
    var thumb_url = (attachment.sizes && attachment.sizes.thumbnail)  ? attachment.sizes.thumbnail.url : image_url;
    switch (id) {
      case 'settings': {
        document.getElementById("background_image_url").value = image_url;
        document.getElementById("background_image").src = image_url;
        document.getElementById("button_bg_img").style.display = "none";
        document.getElementById("delete_bg_img").style.display = "inline-block";
        document.getElementById("background_image").style.display = "";
        document.getElementById("background_image_url").style.display = "";
        break;
      }
      case 'watermark': {
        document.getElementById("built_in_watermark_url").value = image_url; 
        preview_built_in_watermark();
        break;
      }
      case 'music': {
        var music_url = image_url;
        document.getElementById("music_url").value = music_url;
        break;
      }
      case 'nav_left_but': {
        /* Add image for left button.*/
        jQuery("#left_butt_img").attr("src", image_url);
        jQuery("#left_butt_url").val(image_url);
        break;
      }
      case 'nav_right_but': {
        /* Add image for right buttons.*/
        jQuery("#right_butt_img").attr("src", image_url);
        jQuery("#right_butt_url").val(image_url);
        break;
      }
      case 'nav_left_hov_but': {
        /* Add hover image for right buttons.*/
        jQuery("#left_butt_hov_img").attr("src", image_url);
        jQuery("#left_butt_hov_url").val(image_url);
        break;
      }
      case 'nav_right_hov_but': {
        /* Add hover image for left button.*/
        jQuery("#right_butt_hov_img").attr("src", image_url);
        jQuery("#right_butt_hov_url").val(image_url);
        break;
      }
      case 'bullets_main_but': {
        /* Add image for main button.*/
        jQuery("#bull_img_main").attr("src", image_url);
        jQuery("#bullets_img_main_url").val(image_url);
        break;
      }
      case 'bullets_hov_but': {
        /* Add image for hover button.*/
        jQuery("#bull_img_hov").attr("src", image_url);
        jQuery("#bullets_img_hov_url").val(image_url);
        break;
      }
	    case 'play_but': {
        /* Add image for play button.*/
        jQuery("#play_butt_img").attr("src", image_url);
        jQuery("#play_butt_url").val(image_url);
        break;
      }
      case 'play_hov_but': {
        /* Add image for pause button.*/
        jQuery("#play_butt_hov_img").attr("src", image_url);
        jQuery("#play_butt_hov_url").val(image_url);
        break;
      }
      case 'paus_but': {
        /* Add hover image for play button.*/
        jQuery("#paus_butt_img").attr("src", image_url);
        jQuery("#paus_butt_url").val(image_url);
        break;
      }
      case 'paus_hov_but': {
        /* Add hover image for pause button.*/
        jQuery("#paus_butt_hov_img").attr("src", image_url);
        jQuery("#paus_butt_hov_url").val(image_url);
        break;
      }
      case 'button_image_url': {
        /* Delete active slide if it has now image.*/
        jQuery(".wds_box input[id^='image_url']").each(function () {
          var slide_id = jQuery(this).attr("id").replace("image_url", "");
          if (!jQuery("#image_url" + slide_id).val() && !jQuery("#slide" + slide_id + "_layer_ids_string").val()) {
            wds_remove_slide(slide_id, 0);
          }
        });
        /* Add one or more slides.*/
        for (var i in attachment) {
          wds_add_slide();
          var slides_count = jQuery(".wbs_subtab div[id^='wbs_subtab']").length;
          var new_slide_id = "pr_" + slides_count;
          jQuery("#image_url" + new_slide_id).val(attachment[i]['url']);
          var thumb_url = (attachment[i]['sizes'] && attachment[i]['sizes']['thumbnail'])  ? attachment[i]['sizes']['thumbnail']['url'] : attachment[i]['url'];
          jQuery("#thumb_url" + new_slide_id).val(thumb_url);
          jQuery("#wds_preview_image" + new_slide_id).css("background-image", 'url("' + attachment[i]['url'] + '")');
          jQuery("#wds_tab_image" + new_slide_id).css("background-image", 'url("' + attachment[i]['url'] + '")');
          jQuery("#wds_tab_image" + new_slide_id).css("background-position", 'center');
          jQuery("#delete_image_url" + new_slide_id).css("display", "inline-block");
          jQuery("#wds_preview_image" + new_slide_id).css("display", "inline-block");
          jQuery("#type" + new_slide_id).val("image");
          jQuery("#trlink" + new_slide_id).show();
        }
        break;
      }
      default: {
        jQuery("#image_url" + id).val(image_url);
        jQuery("#thumb_url" + id).val(thumb_url);
        jQuery("#wds_preview_image" + id).css("background-image", "url('" + image_url + "')");
        jQuery("#wds_tab_image" + id).css("background-image", "url('" + image_url + "')");
        jQuery("#wds_tab_image" + id).css("background-position", "center");
        jQuery("#delete_image_url" + id).css("display", "inline-block");
        jQuery("#wds_preview_image" + id).css("display", "inline-block");
        jQuery("#type" + id).val("image");
        jQuery("#trlink" + id).show();
      }
	  }
  });
  // Open the uploader dialog.
  custom_uploader.open();
}

function wds_add_image(files, image_for, slide_id, layer_id) {
  switch (image_for) {
    case 'add_slides': {
      /* Delete active slide if it has now image.*/
      jQuery(".wds_box input[id^='image_url']").each(function () {
        var slide_id = jQuery(this).attr("id").replace("image_url", "");
        if (!jQuery("#image_url" + slide_id).val() && !jQuery("#slide" + slide_id + "_layer_ids_string").val()) {
          wds_remove_slide(slide_id, 0);
        }
      });
      /* Add one or more slides.*/
      for (var i in files) {
        wds_add_slide();
        var slides_count = jQuery(".wbs_subtab div[id^='wbs_subtab']").length;
        var new_slide_id = "pr_" + slides_count;
        jQuery("#image_url" + new_slide_id).val(files[i]['url']);
        jQuery("#thumb_url" + new_slide_id).val(files[i]['thumb_url']);
        jQuery("#wds_preview_image" + new_slide_id).css("background-image", 'url("' + files[i]['url'] + '")');
        jQuery("#wds_tab_image" + new_slide_id).css("background-image", 'url("' + files[i]['url'] + '")');
        jQuery("#wds_tab_image" + new_slide_id).css("background-position", 'center');
        jQuery(".wds_video_container" + new_slide_id).html("");
        jQuery("#delete_image_url" + new_slide_id).css("display", "inline-block");
        jQuery("#wds_preview_image" + new_slide_id).css("display", "inline-block");
        jQuery("#type" + new_slide_id).val("image");
        jQuery("#trlink" + new_slide_id).show();
      }
    break;
    }
    case 'add_layer': {
      /* Add image layer to current slide.*/
      wds_add_layer('image', slide_id, '', '', files);
      break;
    }
    case 'add_update_layer': {
      /* Update current layer image.*/
      if (typeof layer_id == "undefined") {
        var layer_id = "";
      }
      jQuery("#slide" + slide_id + "_layer" + layer_id).attr('src', files[0]['url']);
      jQuery("#slide" + slide_id + "_layer" + layer_id+"_image_url").val(files[0]['url']);  
      break;
    }
    case 'add_update_slide': {
      /* Add or update current slide.*/
      var file_resolution = [];						                                 							
      jQuery("#image_url" + slide_id).val(files[0]['url']);
      jQuery("#thumb_url" + slide_id).val(files[0]['thumb_url']);
      jQuery("#wds_preview_image" + slide_id).css("background-image", 'url("' + files[0]['url'] + '")');
      jQuery("#wds_tab_image" + slide_id).css("background-image", 'url("' + files[0]['url'] + '")');
      jQuery("#wds_tab_image" + slide_id).css("background-position", 'center');
      jQuery(".wds_video_container" + slide_id).html("");
      jQuery("#delete_image_url" + slide_id).css("display", "inline-block");
      jQuery("#wds_preview_image" + slide_id).css("display", "inline-block");
      jQuery("#type" + slide_id).val("image");
      jQuery("#trlink" + slide_id).show();
      break;
    }
    case 'watermark': {
      /* Add image for watermark.*/
      document.getElementById("built_in_watermark_url").value = files[0]['url']; 
      preview_built_in_watermark();							
      break;
    }
    case 'nav_right_but': {
      /* Add image for right buttons.*/
      document.getElementById("right_butt_url").value = files[0]['url']; 
      document.getElementById("right_butt_img").src = files[0]['url'];
      break;
    }
    case 'nav_left_but': {
      /* Add image for left button.*/
      document.getElementById("left_butt_url").value = files[0]['url']; 
      document.getElementById("left_butt_img").src = files[0]['url'];
      break;
    }
    case 'nav_right_hov_but': {
      /* Add hover image for right buttons.*/
      document.getElementById("right_butt_hov_url").value = files[0]['url']; 
      document.getElementById("right_butt_hov_img").src = files[0]['url'];
      break;
    }
    case 'nav_left_hov_but': {
      /* Add hover image for left button.*/
      document.getElementById("left_butt_hov_url").value = files[0]['url']; 
      document.getElementById("left_butt_hov_img").src = files[0]['url'];
      break;
    }
    case 'bullets_main_but': {
      /* Add image for main button.*/
      document.getElementById("bullets_img_main_url").value = files[0]['url'];
      document.getElementById("bull_img_main").src = files[0]['url'];
      break;
    }
    case 'bullets_hov_but': {
      /* Add image for hover button.*/
      document.getElementById("bullets_img_hov_url").value = files[0]['url'];
      document.getElementById("bull_img_hov").src = files[0]['url'];
      break;
    }

	case 'play_but': {
      /* Add hover image for right buttons.*/
      document.getElementById("play_butt_url").value = files[0]['url']; 
      document.getElementById("play_butt_img").src = files[0]['url'];
      break;
    }
    case 'play_hov_but': {
      /* Add hover image for left button.*/
      document.getElementById("play_butt_hov_url").value = files[0]['url']; 
      document.getElementById("play_butt_hov_img").src = files[0]['url'];
      break;
    }
	
	 case 'paus_but': {
      /* Add image for main button.*/
      document.getElementById("paus_butt_url").value = files[0]['url']; 
      document.getElementById("paus_butt_img").src = files[0]['url'];
      break;
    }
	case 'paus_hov_but': {
      /* Add image for hover button.*/
      document.getElementById("paus_butt_hov_url").value = files[0]['url']; 
      document.getElementById("paus_butt_hov_img").src = files[0]['url'];
      break;
    }
    default: {
      break;
    }
  }
}

function wds_change_sub_tab_title(that, box) {
 var slideID = box.substring("9");
  jQuery("#sub_tab").val(jQuery(that).attr("tab_type"));
  jQuery(".tab_buttons").removeClass("wds_sub_active");
  jQuery(".tab_link").removeClass("wds_sub_active");
  jQuery(".wds_tab_title_wrap").removeClass("wds_sub_active");
  jQuery(that).parent().addClass("wds_sub_active");
  jQuery(".wds_box").removeClass("wds_sub_active");
  jQuery("." + box).addClass("wds_sub_active");
  jQuery(".wds_sub_active .wds_tab_title").focus();
  jQuery(".wds_sub_active .wds_tab_title").select();

}

function wds_change_sub_tab(that, box) {
  var slideID = box.substring("9");
  jQuery("#sub_tab").val(jQuery(that).attr("tab_type"));
  jQuery(".tab_buttons").removeClass("wds_sub_active");
  jQuery(".tab_link").removeClass("wds_sub_active");
  jQuery(".wds_tab_title_wrap").removeClass("wds_sub_active");
  jQuery(".wds_box").removeClass("wds_sub_active");
  jQuery(that).parent().addClass("wds_sub_active");
  jQuery("." + box).addClass("wds_sub_active");
  jQuery(".tab_image").css('border-color','#B4AFAF');
  jQuery(that).css('border-color','#00A0D4');
  jQuery('.tab_image').find('input').blur();

}

function wds_change_tab(that, box) {
  jQuery("#tab").val(jQuery(that).find("[tab_type]").attr("tab_type"));
  jQuery(".tab_button_wrap a").removeClass("wds_active");
  jQuery(that).children().addClass("wds_active");
  jQuery(".tab_button_wrap").children().css('border-color','#ddd');
  jQuery(".wds_settings").css('background-image', 'url("' + plugin_dir + 'settings_grey.png")');
  jQuery(".wds_slides").css('background-image', 'url("' + plugin_dir + 'slider_grey.png")');
  if(jQuery(that).children().hasClass('wds_active')) {
    jQuery(that).children().css('border-color','#00A0D4');
  }
  jQuery(".wds_box").removeClass("wds_active");
  jQuery("." + box).addClass("wds_active");
  if (box == "wds_settings_box") {
    jQuery(".wds_reset_button").show();
    jQuery(".wds_settings").css('background-image', 'url("' + plugin_dir + 'settings.png")');
  }
  else {
    jQuery(".wds_reset_button").hide();
    jQuery(".wds_slides").css('background-image', 'url("' + plugin_dir + 'slider.png")');
  }
	
	jQuery(".tab_button_wrap").css('border-color','#ddd');
	if(jQuery(".wds_settings_box:visible").length>0){
		jQuery(".setting_tab_button_wrap a").css('border-color','#00A0D4');
    jQuery(".wds_settings").css('background-image', 'url("' + plugin_dir + 'settings.png")');
	}
	else if(jQuery(".wds_slides_box:visible").length>0){
		jQuery(".slides_tab_button_wrap a").css('border-color','#00A0D4');
    jQuery(".wds_slides").css('background-image', 'url("' + plugin_dir + 'slider.png")');
	}
}

function wds_change_nav(that, box) {
  jQuery("#nav_tab").val(jQuery(that).attr("tab_type"));
  jQuery(".wds_nav_tabs li").removeClass("wds_active");
  jQuery(that).addClass("wds_active");
  jQuery(".wds_nav_box").removeClass("wds_active");
  jQuery("." + box).addClass("wds_active");
}

function wds_showhide_layer(tbodyID, always_show) {
  jQuery("#" + tbodyID).css("background-color", "#FFFFFF");
  jQuery("#" + tbodyID + " .wds_layer_head_tr").css("background-color", "#cccccc");
  jQuery("#" + tbodyID).children().each(function() {
    if (!jQuery(this).hasClass("wds_layer_head_tr")) {
      if (jQuery(this).is(':hidden') || always_show) {
        jQuery(this).show();
      }
      else {
        jQuery("#" + tbodyID).css("background-color", "#e1e1e1");
        jQuery("#" + tbodyID + " .wds_layer_head_tr").css("background-color", "#e1e1e1");
        jQuery(this).hide();
      }
    }
  });
}

function wds_delete_layer(id, layerID) {
  if (confirm("Do you want to delete layer?")) {
    var prefix = "slide" + id + "_layer" + layerID;
	if (jQuery("#" + prefix).parent().attr("id") == prefix + "_div") {
       jQuery("#" + prefix).parent().remove();
       }
	else {
	   jQuery("#" + prefix).remove();
        }
    jQuery("#" + prefix + "_tbody").remove();

    var layerIDs = jQuery("#slide" + id + "_layer_ids_string").val();
    layerIDs = layerIDs.replace(layerID + ",", "");
    jQuery("#slide" + id + "_layer_ids_string").val(layerIDs);
    var dellayerIds = jQuery("#slide" + id + "_del_layer_ids_string").val() + layerID + ",";
    jQuery("#slide" + id + "_del_layer_ids_string").val(dellayerIds);
  }
}

function wds_duplicate_layer(type, id, layerID, new_id) {
  var prefix = "slide" + id + "_layer" + layerID;
  var new_layerID = "pr_" + wds_layerID;
  var new_prefix = "slide" + id + "_layer" + new_layerID;
  if (typeof new_id != 'undefined') {
    /* From slide duplication.*/
    new_prefix = "slide" + new_id + "_layer" + new_layerID;
    id = new_id;
    jQuery("#" + new_prefix + "_left").val(jQuery("#" + prefix + "_left").val());
    jQuery("#" + new_prefix + "_top").val(jQuery("#" + prefix + "_top").val());
  }
  else {
    /* From layer duplication.*/
    jQuery("#" + new_prefix + "_left").val(0);
    jQuery("#" + new_prefix + "_top").val(0);
  }
  jQuery("#" + new_prefix + "_text").val(jQuery("#" + prefix + "_text").val());
  jQuery("#" + new_prefix + "_link").val(jQuery("#" + prefix + "_link").val());
  jQuery("#" + new_prefix + "_start").val(jQuery("#" + prefix + "_start").val());
  jQuery("#" + new_prefix + "_end").val(jQuery("#" + prefix + "_end").val());
  jQuery("#" + new_prefix + "_delay").val(jQuery("#" + prefix + "_delay").val());
  jQuery("#" + new_prefix + "_duration_eff_in").val(jQuery("#" + prefix + "_duration_eff_in").val());
  jQuery("#" + new_prefix + "_duration_eff_out").val(jQuery("#" + prefix + "_duration_eff_out").val());
  jQuery("#" + new_prefix + "_color").val(jQuery("#" + prefix + "_color").val());
  jQuery("#" + new_prefix + "_size").val(jQuery("#" + prefix + "_size").val());
  jQuery("#" + new_prefix + "_padding").val(jQuery("#" + prefix + "_padding").val());
  jQuery("#" + new_prefix + "_fbgcolor").val(jQuery("#" + prefix + "_fbgcolor").val());
  jQuery("#" + new_prefix + "_transparent").val(jQuery("#" + prefix + "_transparent").val());
  jQuery("#" + new_prefix + "_border_width").val(jQuery("#" + prefix + "_border_width").val());
  jQuery("#" + new_prefix + "_border_color").val(jQuery("#" + prefix + "_border_color").val());
  jQuery("#" + new_prefix + "_border_radius").val(jQuery("#" + prefix + "_border_radius").val());
  jQuery("#" + new_prefix + "_shadow").val(jQuery("#" + prefix + "_shadow").val());
  jQuery("#" + new_prefix + "_image_url").val(jQuery("#" + prefix + "_image_url").val());
  jQuery("#" + new_prefix + "_image_width").val(jQuery("#" + prefix + "_image_width").val());
  jQuery("#" + new_prefix + "_image_height").val(jQuery("#" + prefix + "_image_height").val());
  jQuery("#" + new_prefix + "_alt").val(jQuery("#" + prefix + "_alt").val());
  jQuery("#" + new_prefix + "_imgtransparent").val(jQuery("#" + prefix + "_imgtransparent").val());
  jQuery("#" + new_prefix + "_hover_color").val(jQuery("#" + prefix + "_hover_color").val());
  jQuery("#" + new_prefix + "_type").val(jQuery("#" + prefix + "_type").val());
  jQuery("#" + new_prefix + "_add_class").val(jQuery("#" + prefix + "_add_class").val());
  jQuery("#" + new_prefix + "hover_color_text").val(jQuery("#" + prefix + "_hover_color_text").val());
  if (jQuery("#" + prefix + "_published1").is(":checked")) {
    jQuery("#" + new_prefix + "_published1").attr("checked", "checked");
  }
  else if (jQuery("#" + prefix + "_published0").is(":checked")) {
    jQuery("#" + new_prefix + "_published0").attr("checked", "checked");
  }
  if (type == "video") {
    if (jQuery("#" + prefix + "_image_scale1").is(":checked")) {
      jQuery("#" + new_prefix + "_image_scale1").attr("checked", "checked");
    }
    else if (jQuery("#" + prefix + "_image_scale0").is(":checked")) {
      jQuery("#" + new_prefix + "_image_scale0").attr("checked", "checked");
    }
  }
  else {
    if (jQuery("#" + prefix + "_image_scale").is(":checked")) {
      jQuery("#" + new_prefix + "_image_scale").attr("checked", "checked");
    }
  }
  if (jQuery("#" + prefix + "_target_attr_layer").is(":checked")) {
      jQuery("#" + new_prefix + "_target_attr_layer").attr("checked", "checked");
  }
  else {
	  jQuery("#" + new_prefix + "_target_attr_layer").removeAttr("checked");
  }
  jQuery("#" + new_prefix + "_transition option").each(function() {
    if (jQuery(this).val() == jQuery("#" + prefix + "_transition").val()) {
      jQuery(this).attr("selected", "selected");
    }
  });
  jQuery("#" + new_prefix + "_ffamily option").each(function() {
    if (jQuery(this).val() == jQuery("#" + prefix + "_ffamily").val()) {
      jQuery(this).attr("selected", "selected");
    }
  });
  jQuery("#" + new_prefix + "_fweight option").each(function() {
    if (jQuery(this).val() == jQuery("#" + prefix + "_fweight").val()) {
      jQuery(this).attr("selected", "selected");
    }
  });
  jQuery("#" + new_prefix + "_border_style option").each(function() {
    if (jQuery(this).val() == jQuery("#" + prefix + "_border_style").val()) {
      jQuery(this).attr("selected", "selected");
    }
  });
  jQuery("#" + new_prefix + "_social_button option").each(function() {
    if (jQuery(this).val() == jQuery("#" + prefix + "_social_button").val()) {
      jQuery(this).attr("selected", "selected");
    }
  });
  jQuery("#" + new_prefix + "_layer_effect_in option").each(function() {
    if (jQuery(this).val() == jQuery("#" + prefix + "_layer_effect_in").val()) {
      jQuery(this).attr("selected", "selected");
    }
  });
  jQuery("#" + new_prefix + "_layer_effect_out option").each(function() {
    if (jQuery(this).val() == jQuery("#" + prefix + "_layer_effect_out").val()) {
      jQuery(this).attr("selected", "selected");
    }
  });
  jQuery("#" + new_prefix + "_text_alignment option").each(function() {
    if (jQuery(this).val() == jQuery("#" + prefix + "_text_alignment").val()) {
      jQuery(this).attr("selected", "selected");
    }
  });
  if (jQuery("#" + prefix + "_google_fonts1").is(":checked")) {
    jQuery("#" + new_prefix + "_google_fonts1").attr("checked", "checked");
  }
  else if (jQuery("#" + prefix + "_google_fonts0").is(":checked")) {
    jQuery("#" + new_prefix + "_google_fonts0").attr("checked", "checked");
  }
  if (jQuery("#" + prefix + "_align_layer").is(":checked")) {
    jQuery("#" + new_prefix + "_align_layer").attr("checked", "checked");
  }
  else {
	  jQuery("#" + new_prefix + "_align_layer").removeAttr("checked");
  }
  if (jQuery("#" + prefix + "_static_layer").is(":checked")) {
    jQuery("#" + new_prefix + "_static_layer").attr("checked", "checked");
  }
  else {
	  jQuery("#" + new_prefix + "_static_layer").removeAttr("checked");
  }
  if (type == "text") {
    wds_new_line(new_prefix);
    jQuery("#" + new_prefix).attr({
      id: new_prefix,
      onclick: "wds_showhide_layer('" + new_prefix + "_tbody', 1)",
      style: "z-index: " + jQuery("#" + new_prefix + "_depth").val() + ";" +
             "left: " + jQuery("#" + new_prefix + "_left").val() + "px;" +
             "top: " + jQuery("#" + new_prefix + "_top").val() + "px;" +
             "display: inline-block;" +
             "color: #" + jQuery("#" + prefix + "_color").val() + "; " +
             "font-size: " + jQuery("#" + prefix + "_size").val() + "px; " +
             "line-height: 1.25em; " +
             "font-family: " + jQuery("#" + prefix + "_ffamily").val() + "; " +
             "font-weight: " + jQuery("#" + prefix + "_fweight").val() + "; " +
             "padding: " + jQuery("#" + prefix + "_padding").val() + "; " +
             "background-color: " + wds_hex_rgba(jQuery("#" + prefix+ "_fbgcolor").val(), (100 - jQuery("#" + prefix+ "_transparent").val())) + "; " +
             "border: " + jQuery("#" + prefix + "_border_width").val() + "px " + jQuery("#" + prefix+ "_border_style").val() + " #" + jQuery("#" + prefix+ "_border_color").val() + "; " +
             "border-radius: " + jQuery("#" + prefix + "_border_radius").val() + ";" +
             "text-align: " + jQuery("#" + prefix + "_text_alignment").val() + ";" + 
             "position: absolute;"
    });
    jQuery("#" + new_prefix).hover(function() { jQuery(this).css("color", jQuery("#" + prefix + "_hover_color_text").val()); }, function() { jQuery(this).css("color", jQuery("#" + prefix + "_color").val()); });
    wds_text_width("#" + new_prefix + "_image_width", new_prefix);
    wds_text_height("#" + new_prefix + "_image_height", new_prefix);
    wds_break_word("#" + new_prefix + "_image_scale", new_prefix);
  }
  else if (type == "image") {
    jQuery("#wds_preview_image" + id).append(jQuery("<img />").attr({
      id: new_prefix,
      src: jQuery("#" + prefix).attr("src"),
      "class": "wds_draggable_" + id + " wds_draggable",
      onclick: "wds_showhide_layer('" + new_prefix + "_tbody', 1)",
      style: "z-index: " + jQuery("#" + new_prefix + "_depth").val() + "; " +
             "left: " + jQuery("#" + new_prefix + "_left").val() + "px;" +
             "top: " + jQuery("#" + new_prefix + "_top").val() + "px;" +
             "opacity: " + (100 - jQuery("#" + prefix + "_imgtransparent").val()) / 100 + "; filter: Alpha(opacity=" + (100 - jQuery("#" + prefix+ "_imgtransparent").val()) + "); " +
             "border: " + jQuery("#" + prefix + "_border_width").val() + "px " + jQuery("#" + prefix+ "_border_style").val() + " #" + jQuery("#" + prefix+ "_border_color").val() + "; " +
             "border-radius: " + jQuery("#" + prefix + "_border_radius").val() + "; " +
             "box-shadow: " + jQuery("#" + prefix + "_shadow").val() + "; " +
             "position: absolute;"
    }));
    wds_scale("#" + new_prefix + "_image_scale", new_prefix);
  }
  jscolor.bind();
  wds_drag_layer(id);
}

function wds_duplicate_slide(slide_id) {
  var new_slide_id = wds_add_slide();
  var type;
  var prefix;
  var layer_id;
  var tab_image = jQuery('#wds_tab_image' + slide_id).css('background-image');
  jQuery("input[name=published" + new_slide_id + "]:checked").val(jQuery("input[name=published" + slide_id + "]:checked").val());
  jQuery("#link" + new_slide_id).val(jQuery("#link" + slide_id).val());
  jQuery("input[name=target_attr_slide" + new_slide_id +" ]:checked").val(jQuery("input[name=target_attr_slide" + slide_id +" ]:checked").val());
  jQuery("#type" + new_slide_id).val(jQuery("#type" + slide_id).val());
  jQuery("#image_url" + new_slide_id).val(jQuery("#image_url" + slide_id).val());
  jQuery("#thumb_url" + new_slide_id).val(jQuery("#thumb_url" + slide_id).val());
  /*If type is video*/
  if (jQuery("#type" + new_slide_id).val() == 'YOUTUBE' || jQuery("#type" + new_slide_id).val() == 'VIMEO') {
    jQuery("#wds_preview_image" + new_slide_id).css("background-image", 'url("' + jQuery("#thumb_url" + slide_id).val() + '")');
    jQuery("#wds_tab_image" + new_slide_id).css("background-image", tab_image);
    jQuery("#trlink" + new_slide_id).hide();
  }
  else {
    jQuery("#wds_preview_image" + new_slide_id).css("background-image", tab_image);
    jQuery("#wds_tab_image" + new_slide_id).css("background-image", tab_image);
    jQuery("#trlink" + new_slide_id).show();
  }
  var layer_ids_string = jQuery("#slide" + slide_id + "_layer_ids_string").val();
  if (layer_ids_string) {
    var layer_ids_array = layer_ids_string.split(",");
    for (var i in layer_ids_array) {
      if (layer_ids_array.hasOwnProperty(i) && layer_ids_array[i] && layer_ids_array[i] != ",") {
      layer_id = layer_ids_array[i];
      prefix = "slide" + slide_id + "_layer" + layer_id;
      type = jQuery("#" + prefix + "_type").val();		
      wds_add_layer(type, new_slide_id, '', 1);
      wds_duplicate_layer(type, slide_id, layer_id, new_slide_id);
      }
    }
  }
}

var wds_layerID = 0;
function wds_add_layer(type, id, layerID, duplicate, files, edit) {
  var layers_count = jQuery(".wds_slide" + id + " .layer_table_count").length;
  wds_layerID = layers_count + 1;
  if (typeof layerID == "undefined" || layerID == "") {
    var layerID = "pr_" + wds_layerID;
    jQuery("#slide" + id + "_layer_ids_string").val(jQuery("#slide" + id + "_layer_ids_string").val() + layerID + ',');
  }
  if (typeof duplicate == "undefined") {
    var duplicate = 0;
  }
  if (typeof edit == "undefined") {
    var edit = 0;
  }

  var layer_effects_in_option = "";
  var layer_effects_out_option = "";
  var free_layer_effects = ['none', 'bounce', 'tada', 'bounceInDown', 'bounceOutUp', 'fadeInLeft', 'fadeOutRight'];
  var layer_effects_in = {
    'none' : 'None',
    'bounce' : 'Bounce',
    'tada' : 'Tada',
    'bounceInDown' : 'BounceInDown',
    'fadeInLeft' : 'FadeInLeft',
    'flash' : 'Flash',
    'pulse' : 'Pulse',
    'rubberBand' : 'RubberBand',
    'shake' : 'Shake',
    'swing' : 'Swing',
    'wobble' : 'Wobble',
    'hinge' : 'Hinge',
    'lightSpeedIn' : 'LightSpeedIn',
    'rollIn' : 'RollIn',
	
    'bounceIn' : 'BounceIn',
    'bounceInLeft' : 'BounceInLeft',
    'bounceInRight' : 'BounceInRight',
    'bounceInUp' : 'BounceInUp',

    'fadeIn' : 'FadeIn',
    'fadeInDown' : 'FadeInDown',
    'fadeInDownBig' : 'FadeInDownBig',
    'fadeInLeftBig' : 'FadeInLeftBig',
    'fadeInRight' : 'FadeInRight',
    'fadeInRightBig' : 'FadeInRightBig',
    'fadeInUp' : 'FadeInUp',
    'fadeInUpBig' : 'FadeInUpBig',

    'flip' : 'Flip',
    'flipInX' : 'FlipInX',
    'flipInY' : 'FlipInY',

    'rotateIn' : 'RotateIn',
    'rotateInDownLeft' : 'RotateInDownLeft',
    'rotateInDownRight' : 'RotateInDownRight',
    'rotateInUpLeft' : 'RotateInUpLeft',
    'rotateInUpRight' : 'RotateInUpRight',
	
    'zoomIn' : 'ZoomIn',
    'zoomInDown' : 'ZoomInDown',
    'zoomInLeft' : 'ZoomInLeft',
    'zoomInRight' : 'ZoomInRight',
    'zoomInUp' : 'ZoomInUp',  
  };

  var layer_effects_out = {
    'none' : 'None',
    'bounce' : 'Bounce',
    'tada' : 'Tada',
    'bounceOutUp' : 'BounceOutUp',
    'fadeOutRight' : 'FadeOutRight',
    'flash' : 'Flash',
    'pulse' : 'Pulse',
    'rubberBand' : 'RubberBand',
    'shake' : 'Shake',
    'swing' : 'Swing',
    'wobble' : 'Wobble',
    'hinge' : 'Hinge',
    'lightSpeedOut' : 'LightSpeedOut',
    'rollOut' : 'RollOut',

    'bounceOut' : 'BounceOut',
    'bounceOutDown' : 'BounceOutDown',
    'bounceOutLeft' : 'BounceOutLeft',
    'bounceOutRight' : 'BounceOutRight',

    'fadeOut' : 'FadeOut',
    'fadeOutDown' : 'FadeOutDown',
    'fadeOutDownBig' : 'FadeOutDownBig',
    'fadeOutLeft' : 'FadeOutLeft',
    'fadeOutLeftBig' : 'FadeOutLeftBig',
    'fadeOutRightBig' : 'FadeOutRightBig',
    'fadeOutUp' : 'FadeOutUp',
    'fadeOutUpBig' : 'FadeOutUpBig',

    'flip' : 'Flip',
    'flipOutX' : 'FlipOutX',
    'flipOutY' : 'FlipOutY',

    'rotateOut' : 'RotateOut',
    'rotateOutDownLeft' : 'RotateOutDownLeft',
    'rotateOutDownRight' : 'RotateOutDownRight',
    'rotateOutUpLeft' : 'RotateOutUpLeft',
    'rotateOutUpRight' : 'RotateOutUpRight',

    'zoomOut' : 'ZoomOut',
    'zoomOutDown' : 'ZoomOutDown',
    'zoomOutLeft' : 'ZoomOutLeft',
    'zoomOutRight' : 'ZoomOutRight',
    'zoomOutUp' : 'ZoomOutUp',  
  };

  for (var i in layer_effects_in) {
    layer_effects_in_option += '<option ' + ((jQuery.inArray(i, free_layer_effects) == -1) ? 'disabled="disabled" title="This effect is disabled in free version."' : '') + ' value="' + i + '">' + layer_effects_in[i] + '</option>';
  }
  for (var i in layer_effects_out) {
    layer_effects_out_option += '<option ' + ((jQuery.inArray(i, free_layer_effects) == -1) ? 'disabled="disabled" title="This effect is disabled in free version."' : '') + ' value="' + i + '">' + layer_effects_out[i] + '</option>';
  }
  
  var font_weights_option = "";
  var font_weights = {'lighter' : 'Lighter', 'normal' : 'Normal', 'bold' : 'Bold'};
  for (var i in font_weights) {
    font_weights_option += '<option value="' + i + '">' + font_weights[i] + '</option>';
  }
  var border_styles_option = "";
  var border_styles = {'none' : 'None', 'solid' : 'Solid', 'dotted' : 'Dotted', 'dashed' : 'Dashed', 'double' : 'Double', 'groove' : 'Groove', 'ridge' : 'Ridge', 'inset' : 'Inset', 'outset' : 'Outset'};
  for (var i in border_styles) {
    border_styles_option += '<option value="' + i + '">' + border_styles[i] + '</option>';
  }
  var social_button_option = "";
  var social_button = {"facebook" : "Facebook", "google-plus" : "Google+", "twitter" : "Twitter", "pinterest" : "Pinterest", "tumblr" : "Tumblr"};
  for (var i in social_button) {
    social_button_option += '<option value="' + i + '">' + social_button[i] + '</option>';
  }

  var prefix = "slide" + id + "_layer" + layerID;
  var tbodyID = prefix + "_tbody";
  
  var text_alignments_option = "";
  var text_alignments = {'center' : 'Center', 'left' : 'Left', 'right' : 'Right'};
  for (var i in text_alignments) {
    text_alignments_option += '<option value="' + i + '">' + text_alignments[i] + '</option>';
  }
  
  jQuery(".wds_slide" + id + "> table").append(jQuery("<tbody />").attr("id", tbodyID));
  jQuery('#' + tbodyID).attr('style',"background-color:#fff");
    jQuery('#' + tbodyID).addClass("layer_table_count");
  var tbody = '<tr class="wds_layer_head_tr">' +
                '<td colspan="4" class="wds_layer_head">' +
                  '<div class="wds_layer_left"><div class="layer_handle handle connectedSortable" title="Drag to re-order"></div>' +
                  '<span class="wds_layer_label" onclick="wds_showhide_layer(\'' + tbodyID + '\', 0)"><input id="' + prefix + '_title" name="' + prefix + '_title" type="text" class="wds_layer_title" style="width: 120px; padding:5px; color:#00A2D0; " value="Layer ' + wds_layerID + '" title="Layer title" /></span></div>' +
                  '<div class="wds_layer_right"><span class="wds_layer_remove" title="Delete layer" onclick="wds_delete_layer(\'' + id + '\', \'' + layerID + '\')"></span>' +
                  '<span class="wds_layer_dublicate" title="Duplicate layer" onclick="wds_add_layer(\'' + type + '\', \'' + id + '\', \'\', 1); wds_duplicate_layer(\'' + type + '\', \'' + id + '\', \'' + layerID + '\');"></span>' +
                  '<input type="text" name="' + prefix + '_depth" id="' + prefix + '_depth" prefix="' + prefix + '" value="' + wds_layerID + '" class="wds_layer_depth spider_int_input" onkeypress="return spider_check_isnum(event)" onchange="jQuery(\'#' + prefix + '\').css({zIndex: jQuery(this).val()})" title="z-index" /></div><div class="wds_clear"></div></td>' +
              '</tr>';
  var text = '<td class="spider_label"><label for="' + prefix + '_text">Text: </label></td>' +
             '<td><textarea id="' + prefix + '_text" name="' + prefix + '_text" style="width: 222px; height: 60px; resize: vertical;" onkeyup="wds_new_line(\'' + prefix + '\')">Sample text</textarea></td>';
  var text_dimensions = '<td class="spider_label"><label for="' + prefix + '_image_width">Dimensions: </label></td>' +
                        '<td>' +
                          '<input id="' + prefix + '_image_width" class="spider_int_input" type="text" onchange="wds_text_width(this,\'' + prefix + '\')" value="" name="' + prefix + '_image_width" /> x ' +
                          '<input id="' + prefix + '_image_height" class="spider_int_input" type="text" onchange="wds_text_height(this,\'' + prefix + '\')" value="" name="' + prefix + '_image_height" /> % ' +
                          '<input id="' + prefix + '_image_scale" type="checkbox" onchange="wds_break_word(this, \'' + prefix + '\')" name="' + prefix + '_image_scale" checked="checked"/><label for="' + prefix + '_image_scale">Break-word</label>' +
                          '<div class="spider_description">Leave blank to keep the initial width and height.</div></td>';
  var alt = '<td class="spider_label"><label for="' + prefix + '_alt">Alt: </label></td>' +
             '<td><input type="text" id="' + prefix + '_alt" name="' + prefix + '_alt" value=""  />' +
                 '<div class="spider_description">Set the HTML attribute specified in the IMG tag.</div></td>';
  var link = '<td class="spider_label"><label for="' + prefix + '_link">Link: </label></td>' +
             '<td><input type="text" id="' + prefix + '_link" name="' + prefix + '_link" value=""  />' +
                 '<input id="' + prefix + '_target_attr_layer" type="checkbox"  name="' + prefix + '_target_attr_layer" value="1" checked="checked" /><label for="' + prefix + '_target_attr_layer"> Open in a new window</label>' +
                 '<div class="spider_description">Use http:// and https:// for external links.</div></td>';
  var position = '<td class="spider_label"><label>Position: </label></td>' +
                 '<td> X <input type="text" name="' + prefix + '_left" id="' + prefix + '_left" value="0" class="spider_int_input" onkeypress="return spider_check_isnum(event)" onchange="jQuery(\'#' + prefix + '\').css({left: jQuery(this).val() + \'px\'})" />' +
                 ' Y <input type="text" name="' + prefix + '_top" id="' + prefix + '_top" value="0" class="spider_int_input" onkeypress="return spider_check_isnum(event)" onchange="jQuery(\'#' + prefix + '\').css({top: jQuery(this).val() + \'px\'})" />';
  if (type == 'text') {
    position += '<input id="' + prefix + '_align_layer" type="checkbox" name="' + prefix + '_align_layer" value="1"       onchange="wds_position_left_disabled(\'' + prefix + '\');" /><label for="' + prefix + '_align_layer">Fixed step (left, center, right)</label>';
  }                 
    position += '<div class="spider_description">In addition you can drag and drop the layer to a desired position.</div></td>';
  var published = '<td class="spider_label"><label>Published: </label></td>' +
                  '<td><input type="radio" id="' + prefix + '_published1" name="' + prefix + '_published" checked="checked" value="1" ><label for="' + prefix + '_published1">Yes</label>' +
                      '<input type="radio" id="' + prefix + '_published0" name="' + prefix + '_published" value="0" /><label for="' + prefix + '_published0">No</label><div class="spider_description"></div></td>';
  var color = '<td class="spider_label"><label for="' + prefix + '_color">Color: </label></td>' +
               '<td><input type="text" name="' + prefix + '_color" id="' + prefix + '_color" value="" class="color" onchange="jQuery(\'#' + prefix + '\').css({color: \'#\' + jQuery(this).val()})" /><div class="spider_description"></div></td>';
  var hover_color_text = '<td class="spider_label"><label for="' + prefix + '_hover_color_text">Hover Color: </label></td>' +
                    '<td><input type="text" name="' + prefix + '_hover_color_text" id="' + prefix + '_hover_color_text" value="" class="color" onchange="jQuery(\'#' + prefix + '\').hover(function() { jQuery(this).css({color: \'#\' + jQuery(\'#' + prefix + '_hover_color_text\').val()}); }, function() { jQuery(this).css({color: \'#\' + jQuery(\'#' + prefix + '_color\').val()}); })" /><div class="spider_description"></div></td>';             
  var size = '<td class="spider_label"><label for="' + prefix + '_size">Size: </label></td>' +
              '<td><input type="text" name="' + prefix + '_size" id="' + prefix + '_size" value="18" class="spider_int_input" onkeypress="return spider_check_isnum(event)" onchange="jQuery(\'#' + prefix + '\').css({fontSize: jQuery(this).val() + \'px\', lineHeight: jQuery(this).val() + \'px\'})" /> px<div class="spider_description"></div></td>';
  var ffamily = '<td class="spider_label"><label for="' + prefix + '_ffamily">Font family: </label></td>' +
                '<td><select class="select_icon"  style="width: 200px;" name="' + prefix + '_ffamily" id="' + prefix + '_ffamily" onchange="wds_change_fonts(\'' + prefix + '\', 1)"></select>' +
                    '<input type="radio" id="' + prefix + '_google_fonts1" name="' + prefix + '_google_fonts" value="1" onchange="wds_change_fonts(\'' + prefix + '\');" /><label for="' + prefix + '_google_fonts1">Google fonts</label>' +
                    '<input type="radio" id="' + prefix + '_google_fonts0" name="' + prefix + '_google_fonts" checked="checked" value="0" onchange="wds_change_fonts(\'' + prefix + '\');" /><label for="' + prefix + '_google_fonts0">Default</label>' +
                    '<div class="spider_description"></div></td>';
  var fweight = '<td class="spider_label"><label for="' + prefix + '_fweight">Font weight: </label></td>' +
                '<td><select class="select_icon"  name="' + prefix + '_fweight" id="' + prefix + '_fweight" onchange="jQuery(\'#' + prefix + '\').css({fontWeight: jQuery(this).val()})">' + font_weights_option + '</select><div class="spider_description"></div></td>';
  var padding = '<td class="spider_label"><label for="' + prefix + '_padding">Padding: </label></td>' +
                 '<td><input type="text" name="' + prefix + '_padding" id="' + prefix + '_padding" value="5px" class="spider_char_input" onchange="document.getElementById(\'' + prefix + '\').style.padding=jQuery(this).val()" /><div class="spider_description">Use CSS type values.</div></td>';
  var fbgcolor = '<td class="spider_label"><label for="' + prefix + '_fbgcolor">Background Color: </label></td>' +
                 '<td><input type="text" name="' + prefix + '_fbgcolor" id="' + prefix + '_fbgcolor" value="000000" class="color" onchange="jQuery(\'#' + prefix + '\').css({backgroundColor: wds_hex_rgba(jQuery(this).val(), 100 - jQuery(\'#' + prefix + '_transparent\').val())})" /><div class="spider_description"></div></td>';
  var fbgtransparent = '<td class="spider_label"><label for="' + prefix + '_transparent">Transparent: </label></td>' +
                       '<td><input type="text" name="' + prefix + '_transparent" id="' + prefix + '_transparent" value="50" class="spider_int_input" onkeypress="return spider_check_isnum(event)" onchange="jQuery(\'#' + prefix + '\').css({backgroundColor: wds_hex_rgba(jQuery(\'#' + prefix + '_fbgcolor\').val(), 100 - jQuery(this).val())})" /> %<div class="spider_description">Value must be between 0 to 100.</div></td>';
  var imgtransparent = '<td class="spider_label"><label for="' + prefix + '_imgtransparent">Transparent: </label></td>' +
                       '<td><input type="text" name="' + prefix + '_imgtransparent" id="' + prefix + '_imgtransparent" value="0" class="spider_int_input" onkeypress="return spider_check_isnum(event)" onchange="jQuery(\'#' + prefix + '\').css({opacity: (100 - jQuery(this).val()) / 100, filter: \'Alpha(opacity=\' + 100 - jQuery(this).val() + \')\'})" /> %<div class="spider_description">Value must be between 0 to 100.</div></td>';
  var border_width = '<td class="spider_label"><label for="' + prefix + '_border_width">Border: </label></td>' +
                     '<td><input type="text" name="' + prefix + '_border_width" id="' + prefix + '_border_width" value="2" class="spider_int_input" onkeypress="return spider_check_isnum(event)" onchange="jQuery(\'#' + prefix + '\').css({borderWidth: jQuery(this).val() + \'px\'})" /> px ' +
                        '<select class="select_icon"  name="' + prefix + '_border_style" id="' + prefix + '_border_style" style="width: 80px;" onchange="jQuery(\'#' + prefix + '\').css({borderStyle: jQuery(this).val()})">' + border_styles_option + '</select> ' +
                        '<input type="text" name="' + prefix + '_border_color" id="' + prefix + '_border_color" value="" class="color" onchange="jQuery(\'#' + prefix + '\').css({borderColor: \'#\' + jQuery(this).val()})" /><div class="spider_description"></div></td>';
  var border_radius = '<td class="spider_label"><label for="' + prefix + '_border_radius">Radius: </label></td>' +
                      '<td><input type="text" name="' + prefix + '_border_radius" id="' + prefix + '_border_radius" value="2px" class="spider_char_input" onchange="jQuery(\'#' + prefix + '\').css({borderRadius: jQuery(this).val()})" /><div class="spider_description">Use CSS type values.</div></td>';
  var shadow = '<td class="spider_label"><label for="' + prefix + '_shadow">Shadow: </label></td>' +
               '<td><input type="text" name="' + prefix + '_shadow" id="' + prefix + '_shadow" value="" class="spider_char_input" onchange="jQuery(\'#' + prefix + '\').css({boxShadow: jQuery(this).val()})" /><div class="spider_description">Use CSS type values (e.g. 10px 10px 5px #888888).</div></td>';
  var dimensions = '<td class="spider_label"><label>Dimensions: </label></td>' +
                   '<td>' +
                     '<input type="hidden" name="' + prefix + '_image_url" id="' + prefix + '_image_url" />' +
                     '<input type="text" name="' + prefix + '_image_width" id="' + prefix + '_image_width" value="" class="spider_int_input" onkeyup="wds_scale(\'#' + prefix + '_image_scale\', \'' + prefix + '\')" /> x ' +
                     '<input type="text" name="' + prefix + '_image_height" id="' + prefix + '_image_height" value="" class="spider_int_input" onkeyup="wds_scale(\'#' + prefix + '_image_scale\', \'' + prefix + '\')" /> px ' +
                     '<input type="checkbox" name="' + prefix + '_image_scale" id="' + prefix + '_image_scale" onchange="wds_scale(this, \'' + prefix + '\')" /><label for="' + prefix + '_image_scale">Scale</label>' +
                     '<input class="wds_not_image_buttons_grey wds_free_button" type="button" value="Edit Image" onclick="alert(\'This functionality is disabled in free version.\')" />' +
                     '<div class="spider_description">Set width and height of the image.</div></td>';
  var social_button = '<td class="spider_label"><label for="' + prefix + '_social_button">Social button: </label></td>' +
                      '<td><select class="select_icon"  name="' + prefix + '_social_button" id="' + prefix + '_social_button" onchange="jQuery(\'#' + prefix + '\').attr(\'class\', \'wds_draggable fa fa-\' + jQuery(this).val())">' + social_button_option + '</select><div class="spider_description"></div></td>';
  var transparent = '<td class="spider_label"><label for="' + prefix + '_transparent">Transparent: </label></td>' +
                    '<td><input type="text" name="' + prefix + '_transparent" id="' + prefix + '_transparent" value="0" class="spider_int_input" onkeypress="return spider_check_isnum(event)" onchange="jQuery(\'#' + prefix + '\').css({opacity: (100 - jQuery(this).val()) / 100, filter: \'Alpha(opacity=\' + 100 - jQuery(this).val() + \')\'})" /> %<div class="spider_description">Value must be between 0 to 100.</div></td>';
  var hover_color = '<td class="spider_label"><label for="' + prefix + '_hover_color">Hover Color: </label></td>' +
                    '<td><input type="text" name="' + prefix + '_hover_color" id="' + prefix + '_hover_color" value="" class="color" onchange="jQuery(\'#' + prefix + '\').hover(function() { jQuery(this).css({color: \'#\' + jQuery(\'#' + prefix + '_hover_color\').val()}); }, function() { jQuery(this).css({color: \'#\' + jQuery(\'#' + prefix + '_color\').val()}); })" /><div class="spider_description"></div></td>';
  var layer_type = '<input type="hidden" name="' + prefix + '_type" id="' + prefix + '_type" value="' + type + '" />';
  var layer_effect_in = '<td class="spider_label"><label>Effect in: </label></td>' +
                   '<td>' +
                    '<span style="display: table-cell;">' +
                      '<input type="text" name="' + prefix + '_start" id="' + prefix + '_start" value="1000" class="spider_int_input" /> ms' +
                      '<div class="spider_description">Start</div>' +
                    '</span>' +
                    '<span style="display: table-cell;">' +
                      '<select class="select_icon"  name="' + prefix + '_layer_effect_in" id="' + prefix + '_layer_effect_in" style="width:150px;" onchange="wds_trans_effect_in(\'' + id + '\', \'' + prefix + '\', ' + ((type == 'social') ? 1 : 0) + '); wds_trans_end(\'' + prefix + '\', jQuery(this).val());">' + layer_effects_in_option + '</select>' +
                      '<div class="spider_description">Effect</div>' +
                    '</span>' +
                    '<span style="display: table-cell;">' +
                      '<input id="' + prefix + '_duration_eff_in" class="spider_int_input" type="text"  onkeypress="return spider_check_isnum(event)" onchange="wds_trans_effect_in(\'' + id + '\', \'' + prefix + '\', ' + ((type == 'social') ? 1 : 0) + '); wds_trans_end(\'' + prefix + '\', jQuery(\'#' + prefix + '_layer_effect_in\').val());" value="1000" name="' + prefix + '_duration_eff_in"> ms' +
                      '<div class="spider_description">Duration</div>' +
                    '</span>' +
                    '<div class="spider_description spider_free_version">Some effects are disabled in free version.</div>' +
                   '</td>';
  var layer_effect_out = '<td class="spider_label"><label>Effect out: </label></td>' +
                   '<td>' +
                    '<span style="display: table-cell;">' +
                      '<input type="text" name="' + prefix + '_end" id="' + prefix + '_end" value="3000" class="spider_int_input" /> ms' +
                      '<div class="spider_description">Start</div>' +
                    '</span>' +
                    '<span style="display: table-cell;">' +
                      '<select class="select_icon"  name="' + prefix + '_layer_effect_out" id="' + prefix + '_layer_effect_out" style="width:150px;" onchange="wds_trans_effect_out(\'' + id + '\', \'' + prefix + '\', ' + ((type == 'social') ? 1 : 0) + '); wds_trans_end(\'' + prefix + '\', jQuery(this).val());">' + layer_effects_out_option + '</select>' +
                      '<div class="spider_description">Effect</div>' +
                    '</span>' +
                    '<span style="display: table-cell;">' +
                      '<input id="' + prefix + '_duration_eff_out" class="spider_int_input" type="text" onkeypress="return spider_check_isnum(event)" onchange="wds_trans_effect_out(\'' + id + '\', \'' + prefix + '\', ' + ((type == 'social') ? 1 : 0) + '); wds_trans_end(\'' + prefix + '\', jQuery(\'#' + prefix + '_layer_effect_out\').val());" value="1000" name="' + prefix + '_duration_eff_out"> ms' +
                      '<div class="spider_description">Duration</div>' +
                    '</span>' +
                    '<div class="spider_description spider_free_version">Some effects are disabled in free version.</div>' + 
                   '</td>';
  var add_class = '<td class="spider_label"><label for="' + prefix + '_add_class">Add class: </label></td>' +
                          '<td><input type="text" name="' + prefix + '_add_class" id="' + prefix + '_add_class" value="" class="spider_char_input" /><div class="spider_description"></div></td>';
  var text_alignment = '<td class="spider_label"><label for="' + prefix + '_text_alignment">Text alignment: </label></td>' +
                     '<td><select class="select_icon" style="width: 70px;" name="' + prefix + '_text_alignment" id="' + prefix + '_text_alignment"    onchange="jQuery(\'#' + prefix + '\').css({textAlign: jQuery(this).val()})">' + text_alignments_option + '</select><div class="spider_description"></div></td>'; 

  var static_layer = '<td class="spider_label"><label for="' + prefix + '_static_layer">Static layer: </label></td>' + '<td><input id="' + prefix + '_static_layer" type="checkbox" name="' + prefix + '_static_layer" value="1" /><div class="spider_description">The layer will be visible on all slides.</div></td>';
  switch(type) {
    case 'text': {
      jQuery("#wds_preview_image" + id).append(jQuery("<span />").attr({
        id: prefix,
        "class": "wds_draggable_" + id + " wds_draggable",
        "data-type": "wds_text_parent",
        onclick: "wds_showhide_layer('" + tbodyID + "', 1)",
        style: "z-index: " + layerID.replace("pr_", "") + "; " +
               "word-break: normal;" +
               "display: inline-block; " +
               "position: absolute;" +
               "left: 0; top: 0; " +
               "color: #FFFFFF; " +
               "font-size: 18px; " +
               "line-height: 1.25em; " +
               "font-family: Arial; " +
               "font-weight: normal; " +
               "padding: 5px; " +
               "background-color: " + wds_hex_rgba('000000', 50) + "; " +
               "border-radius: 2px;"
      }).html("Sample text"));
      jQuery("#" + tbodyID).append(tbody + '<tr><td colspan=2>'+ 
				'<table class="layer_table_left" style="width: 60%">' +
					'<tr class="wds_layer_tr">' +
						text +
          '</tr><tr class="wds_layer_tr">' +
						static_layer +  
					'</tr><tr class="wds_layer_tr">' +	
						text_dimensions +						
					'</tr><tr class="wds_layer_tr">' +	
						position +
					'</tr><tr class="wds_layer_tr">' +	
						size +
					'</tr><tr class="wds_layer_tr">' +		
						color +
            '</tr><tr class="wds_layer_tr">' +
						hover_color_text +  
					'</tr><tr class="wds_layer_tr">' +
						ffamily +
					'</tr><tr class="wds_layer_tr">' +
						fweight +
					'</tr><tr class="wds_layer_tr">' +
						link +
					'</tr><tr class="wds_layer_tr">' +
						published +					
				'</tr></table>'+			
				'<table class="layer_table_right" style="width:39%">'+
				'<tr class="wds_layer_tr">' +
						layer_effect_in +
					'</tr><tr class="wds_layer_tr">' +
						layer_effect_out +
					'</tr><tr class="wds_layer_tr">' +
						padding +
					'</tr><tr class="wds_layer_tr">' +
						fbgcolor +
					'</tr><tr class="wds_layer_tr">' +
						fbgtransparent +  
					'</tr><tr class="wds_layer_tr">' +
						border_width +
					'</tr><tr class="wds_layer_tr">' +
						border_radius +
					'</tr><tr class="wds_layer_tr">' +
						shadow +
					'</tr><tr class="wds_layer_tr">' +
						add_class +
           '</tr><tr class="wds_layer_tr">' +
						text_alignment +
					'</tr>' +			
				'</table>'+  
				'</td></tr>' + layer_type 
      );
      wds_change_fonts(prefix);
      break;
    }
    case 'image': {
      if(edit == 0) {
        var tbody_html = tbody +
				'<tr><td colspan=2>'+ 
				'<table class="layer_table_left" style="width: 60%">' +
        '<tr class="wds_layer_tr">' +
          static_layer +
        '</tr><tr class="wds_layer_tr">' +
          dimensions +
        '</tr><tr class="wds_layer_tr">' +
          alt +
        '</tr><tr class="wds_layer_tr">' +
          link +
        '</tr><tr class="wds_layer_tr">' +
          position +
        '</tr><tr class="wds_layer_tr">' +
          imgtransparent + 
        '</tr><tr class="wds_layer_tr">' +
          published +
				'</tr></table>'+			
				'<table class="layer_table_right" style="width:39%">'+
				'<tr class="wds_layer_tr">' +
          layer_effect_in +
        '</tr><tr class="wds_layer_tr">' +
          layer_effect_out +
        '</tr><tr class="wds_layer_tr">' +
          border_width +
        '</tr><tr class="wds_layer_tr">' +
          border_radius +
        '</tr><tr class="wds_layer_tr">' +
          shadow +
				'</tr><tr class="wds_layer_tr">' +
					add_class +
					'</tr>' +			
				'</table>'+  
				'</td></tr>' + layer_type 				
      }
      if (!duplicate) {
        if (spider_uploader) { // Add image layer by spider uploader.
          wds_add_image_layer_by_spider_uploader(prefix, files, tbodyID, id, layerID, tbody_html);
        }
        else { // Add image layer by media uploader.
          image_escape = wds_add_image_layer(prefix, tbodyID, id, layerID, tbody_html, edit);
        }
      }
      else {
        jQuery("#" + tbodyID).append(tbody_html);
      }
      break;
    }
    default: {
      break;
    }
  }
  if (!duplicate) {
    wds_drag_layer(id);
    jscolor.bind();
  }
  wds_layer_weights(id);
  wds_onkeypress();
  return layerID;
}

function wds_scale(that, prefix) {
  var wds_theImage = new Image();
  wds_theImage.src = jQuery("#" + prefix).attr("src");
  var wds_origWidth = wds_theImage.width;
  var wds_origHeight = wds_theImage.height;
  var width = jQuery("#" + prefix + "_image_width").val();
  var height = jQuery("#" + prefix + "_image_height").val();
  jQuery("#" + prefix).css({maxWidth: width + "px", maxHeight: height + "px", width: "", height: ""});
  if (!jQuery(that).is(':checked') || !jQuery(that).val()) {
    jQuery("#" + prefix).css({width: width + "px", height: height + "px"});
  }
  else if (wds_origWidth <= width || wds_origHeight <= height) {
    if (wds_origWidth / width > wds_origHeight / height) {
      jQuery("#" + prefix).css({width: width + "px"});
    }
    else {
      jQuery("#" + prefix).css({height: height + "px"});
    }
  }
}

function wds_drag_layer(id) {
  jQuery(".wds_draggable_" + id).draggable({ containment: "#wds_preview_wrapper_" + id, scroll: false });
  jQuery(".wds_draggable_" + id).bind('dragstart', function(event) {
    jQuery(this).addClass('wds_active_layer');
  }).bind('drag', function(event) {
    var prefix = jQuery(this).attr("id");
    var check = jQuery('#' + prefix + '_align_layer').is(":checked");
    if (!check) {
      jQuery("#" + prefix + "_left").val(parseInt(jQuery(this).offset().left - jQuery(".wds_preview_image" + id).offset().left));
    }
    jQuery("#" + prefix + "_top").val(parseInt(jQuery(this).offset().top - jQuery(".wds_preview_image" + id).offset().top));
  })
  jQuery(".wds_draggable_" + id).bind('dragstop', function(event) {
    jQuery(this).removeClass('wds_active_layer');
    var prefix = jQuery(this).attr("id");
    var check = jQuery('#' + prefix + '_align_layer').is(":checked");
    var left = parseInt(jQuery(this).offset().left - jQuery(".wds_preview_image" + id).offset().left);
    var layer_center = left + jQuery("#" + prefix).width() / 2;
    var pos_center = -jQuery("#" + prefix).width() / 2 + jQuery(".wds_preview_image" + id).width() / 2;
    var pos_rigth = (jQuery(".wds_preview_image" + id).width() - jQuery("#" + prefix).width()) - 2 * parseInt(jQuery("#" + prefix + "_padding").val());
    if (check) {
      /*center*/
      if ((layer_center > jQuery(".wds_preview_image" + id).width() / 4 && layer_center < jQuery(".wds_preview_image" + id).width() / 2) || (layer_center >jQuery(".wds_preview_image" + id).width() / 2 && layer_center <= 3 * jQuery(".wds_preview_image" + id).width() / 4)) {
        jQuery("#" + prefix).css({left:pos_center + 'px'});
        jQuery("#" + prefix + "_left").val(parseInt(pos_center));
      }
      /*right*/
      else if (layer_center > (3 * jQuery(".wds_preview_image" + id).width() / 4) && layer_center < jQuery(".wds_preview_image" + id).width()) {
        jQuery("#" + prefix).css({left:pos_rigth + 'px'});
        jQuery("#" + prefix + "_left").val(parseInt(pos_rigth));
      }
      /*left*/
      else if (layer_center > 0 && layer_center <= jQuery(".wds_preview_image" + id).width() / 4){
       jQuery("#" + prefix).css({left:'0px'});
       jQuery("#" + prefix + "_left").val(0);
      }
    }
  });
}

function wds_layer_weights(id) {
  jQuery(".ui-sortable" + id + "").sortable({
    handle: ".connectedSortable",
    connectWith: ".connectedSortable",
    update: function (event) {
      var i = 1;
      jQuery(".wds_slide" + id + " .wds_layer_depth").each(function (e) {
        if (jQuery(this).val()) {
          jQuery(this).val(i++);
          prefix = jQuery(this).attr("prefix");
          jQuery("#" + prefix).css({zIndex: jQuery(this).val()});
        }
      });
    }
  });//.disableSelection();
  // jQuery(".ui-sortable").sortable("enable");
}

function wds_slide_weights() {
  jQuery(".aui-sortable").sortable({
    connectWith: ".connectedSortable",
    items: ".connectedSortable",
    update: function (event) {
      var i = 1;
      jQuery(".wbs_subtab input[id^='order']").each(function (e) {
        if (jQuery(this).val()) {
          jQuery(this).val(i++);
        }
      });
    }
  });
  jQuery(".aui-sortable").disableSelection();
}

function wds_add_image_layer(prefix, tbodyID, id, layerID, tbody_html, edit) {
  var custom_uploader;
  /*event.preventDefault();*/
  // If the uploader object has already been created, reopen the dialog.
  if (custom_uploader) {
    custom_uploader.open();
    return;
  }
  if (typeof edit == "undefined") {
    var edit = 0;
  }
  // Extend the wp.media object.
  custom_uploader = wp.media.frames.file_frame = wp.media({
    title: 'Choose Image',
    library : { type : 'image'},
    button: { text: 'Insert'},
    multiple: false
  });
  // When a file is selected, grab the URL and set it as the text field's value
  custom_uploader.on('select', function() {
    jQuery("#" + tbodyID).append(tbody_html);
    attachment = custom_uploader.state().get('selection').first().toJSON();
    if (edit == 0) {
      jQuery("#wds_preview_image" + id).append(jQuery("<img />").attr({
        id: prefix,
        "class": "wds_draggable_" + id + " wds_draggable",
        onclick: "wds_showhide_layer('" + tbodyID + "', 1)",
        src: attachment.url,
        style: "z-index: " + layerID.replace("pr_", "") + "; " +
               "left: 0; top: 0; " +
               "border: 2px none #FFFFFF; " +
               "border-radius: 2px; " +
               "opacity: 1; filter: Alpha(opacity=100); " +
               "position: absolute;"
      }));

      var att_width = attachment.width ? attachment.width : jQuery("#" + prefix).width();
      var att_height = attachment.height ? attachment.height : jQuery("#" + prefix).height();
      var width = Math.min(att_width, jQuery("#wds_preview_image" + id).width());
      var height = Math.min(att_height, jQuery("#wds_preview_image" + id).height());

      jQuery("#" + prefix + "_image_url").val(attachment.url);
      jQuery("#" + prefix + "_image_width").val(width);
      jQuery("#" + prefix + "_image_height").val(height);
      jQuery("#" + prefix + "_image_scale").attr("checked", "checked");
      wds_scale("#" + prefix + "_image_scale", prefix);
    }
    else {
      jQuery("#" + prefix).attr("src", attachment.url);
      jQuery("#" + prefix + "_image_url").val(attachment.url);
    }
    wds_drag_layer(id);
    jscolor.bind();
  });

  // Open the uploader dialog.
  custom_uploader.open();
}

function wds_add_image_layer_by_spider_uploader(prefix, files, tbodyID, id, layerID, tbody_html) {
  var file_resolution = [];
  jQuery("#" + tbodyID).append(tbody_html);	
    jQuery("#wds_preview_image" + id).append(jQuery("<img />").attr({
      id: prefix,
      class: "wds_draggable_" + id + " wds_draggable",
      onclick: "wds_showhide_layer('" + tbodyID + "', 1)",
      src: files[0]['url'],
      style: "z-index: " + layerID.replace("pr_", "") + "; " +
             "left: 0; top: 0; " +
             "border: 2px none #FFFFFF; " +
             "border-radius: 2px; " +
             "opacity: 1; filter: Alpha(opacity=100); " +
             "position: absolute;"
    }));
	
    file_resolution = files[0]['resolution'].split('x');	
    var file_width = parseInt(file_resolution[0]) ? parseInt(file_resolution[0]) : jQuery("#" + prefix).width();
    var file_height = parseInt(file_resolution[1]) ? parseInt(file_resolution[1]) : jQuery("#" + prefix).height();
    var width = Math.min(file_width, jQuery("#wds_preview_image" + id).width());
    var height = Math.min(file_height, jQuery("#wds_preview_image" + id).height());

    jQuery("#" + prefix + "_image_url").val(files[0]['url']);
    jQuery("#" + prefix + "_image_width").val(width);
    jQuery("#" + prefix + "_image_height").val(height);
    jQuery("#" + prefix + "_image_scale").attr("checked", "checked");
    wds_scale("#" + prefix + "_image_scale", prefix);
    wds_drag_layer(id);
    jscolor.bind();  
}

function wds_hex_rgba(color, transparent) {
  color = "#" + color;
  var redHex = color.substring(1, 3);
  var greenHex = color.substring(3, 5);
  var blueHex = color.substring(5, 7);

  var redDec = parseInt(redHex, 16);
  var greenDec = parseInt(greenHex, 16);
  var blueDec = parseInt(blueHex, 16);

  var colorRgba = 'rgba(' + redDec + ', ' + greenDec + ', ' + blueDec + ', ' + transparent / 100 + ')';
  return colorRgba;
}

function wds_add_slide() {
  var slides_count = jQuery(".wbs_subtab div[id^='wbs_subtab']").length;
  var tmp_arr = [];
  var order_arr = [];
  var tmp_i = 0;
  jQuery(".wbs_subtab").find(".tab_link").each(function() {
    var tmp_id = jQuery(this).attr("id");
    if (tmp_id.indexOf("pr_") !== -1) {
      tmp_arr[tmp_i++] = tmp_id.replace("wbs_subtabpr_", "");
    }
    order_arr.push(jQuery('#order' + tmp_id.replace("wbs_subtab", "")).val()) ;
  });
  if (typeof tmp_arr !== 'undefined' && tmp_arr.length > 0) {
    var slideID = "pr_" + (Math.max.apply(Math, tmp_arr) + 1);
    ++slides_count;
  }
  else {
    var slideID = "pr_" + ++slides_count;
  }
  var order_id = 1;
  if (typeof order_arr !== 'undefined' && order_arr.length > 0) {
    order_id = Math.max.apply(Math, order_arr) + 1;
  }
  var uploader_href_for_add_slide = uploader_href.replace('slideID', slideID);
  var uploader_href_for_add_layer = uploader_href_for_add_slide.replace('add_update_slide', 'add_layer'); 
  if (spider_uploader) {
    slide_upload_by = ' <a href="' + uploader_href_for_add_slide + '" class="action_buttons edit_slide thickbox thickbox-preview" title="Add/Edit Image" onclick="return false;">Add/Edit Image</a>';
    update_thumb_by = ' <input type="button" class="action_buttons edit_thumb wds_free_button" id="button_image_url' + slideID + '" onclick="alert(\'This functionality is disabled in free version.\'); return false;" value="Edit Thumbnail" />';
    edit_slide_by = ' <a href="' + uploader_href_for_add_slide + '" class="wds_change_thumbnail thickbox thickbox-preview" title="Add/Edit Image" onclick="return false;"></a>';
    img_layer_upload_by = ' <a href="' + (!fv ? uploader_href_for_add_layer : "") + '" class="' + (!fv ? "" : "wds_free_button") + ' action_buttons add_image_layer button-small" title="Add Image Layer" onclick="' + (!fv ? "" : "alert('This functionality is disabled in free version.')") + '; return false;">Add Image Layer</a>';
  }
  else {
    slide_upload_by = ' <input id="button_image_url' + slideID + '" class="action_buttons edit_slide" type="button" value="Add/Edit Image" onclick="spider_media_uploader(\'' + slideID + '\', event); return false;" />';
    edit_slide_by = ' <span class="wds_change_thumbnail" type="button" value="Add/Edit Image" onclick="spider_media_uploader(\'' + slideID + '\', event); return false;" ></span>';
     update_thumb_by = ' <input type="button" class="action_buttons edit_thumb wds_free_button" id="button_image_url' + slideID + '" onclick="alert(\'This functionality is disabled in free version.\'); return false;" value="Edit Thumbnail" />';
    img_layer_upload_by = ' <input class="action_buttons add_image_layer ' + (!fv ? "" : "secondary wds_free_button") + '  button-small" type="button" value="Add Image Layer" onclick="' + (!fv ? "wds_add_layer(\'image\', \'' + slideID + '\', \'\', event)" : "alert('This functionality is disabled in free version.')") + '; return false;" />';
  }
  jQuery("#slide_ids_string").val(jQuery("#slide_ids_string").val() + slideID + ',');
  jQuery(".wds_slides_box *").removeClass("wds_sub_active");
  jQuery(
    '<div id="wds_subtab_wrap' + slideID + '" class="wds_subtab_wrap connectedSortable"><div id="wbs_subtab' + slideID + '" class="tab_link wds_sub_active" href="#" style="display:block !important; width:149px; height:140px; padding:0; margin-right: 25px;">' +
      '<div  class="tab_image" id="wds_tab_image' + slideID + '">' + 
        '<div class="tab_buttons">' + 
          '<div class="handle_wrap"><div class="handle" title="Drag to re-order"></div></div>' +
          '<div class="wds_tab_title_wrap"> <input  type="text" id="title' + slideID + '" name="title' + slideID + '" value="Slide ' + order_id + '" class="wds_tab_title" tab_type="slide' + slideID + '"  /></div><input  type="hidden" name="order' + slideID + '" id="order' + slideID + '" value="' + order_id + '" /></div>' +
          '<div class="overlay"><div id="hover_buttons">' +
          edit_slide_by +
          ' <span class="wds_slide_dublicate" onclick="wds_duplicate_slide(\'' + slideID + '\');" title="Duplicate slide"></span>' +
          ' <span class="wds_tab_remove" title="Delete slide" onclick="wds_remove_slide(\'' + slideID + '\')"></span></div></div>' +
         ' </div></div></div>').insertBefore(".new_tab_image");
  jQuery(".wbs_subtab").after(
    '<div class="wds_box wds_sub_active wds_slide' + slideID + '">' +
      '<table class="ui-sortable' + slideID + '">' +
        '<thead><tr><td colspan="4"> </td></tr></thead>' +
        '<tbody>' +
          '<input type="hidden" name="type' + slideID + '" id="type' + slideID + '" value="image" />' +
          '<tr class="bgcolor"><td colspan="4"><div class="slide_add_buttons_wrap">' +
            slide_upload_by +
            '</div><div class="slide_add_buttons_wrap"><input class="action_buttons add_by_url" type="button" value="Add Image by URL" onclick="wds_add_image_url(\'' + slideID + '\')" />' +
	    '</div><div class="slide_add_buttons_wrap"><input type="button" class="action_buttons add_video wds_free_button" onclick="alert(\'This functionality is disabled in free version.\')"" value="Add Video" />' +
            '</div><div class="slide_add_buttons_wrap"><input class="action_buttons embed_media wds_free_button" type="button" value="Embed Media" onclick="alert(\'This functionality is disabled in free version.\')">' +
	    '</div><div class="slide_add_buttons_wrap"><input class="action_buttons add_post wds_free_button" type="button" value="Add Post" onclick="alert(\'This functionality is disabled in free version.\')">' +
            '</div><div class="slide_add_buttons_wrap"><input id="delete_image_url' + slideID + '" class="action_buttons delete" type="button" value="Delete" onclick="wds_remove_slide(\'' + slideID + '\')" />' + update_thumb_by + 
            ' <input id="image_url' + slideID + '" type="hidden" value="" name="image_url' + slideID + '" />' +
            '</div><div class="slide_add_buttons_wrap"> <input id="thumb_url' + slideID + '" type="hidden" value="" name="thumb_url' + slideID + '" /></div></td>' +
          '</tr><tr class="bgcolor"><td colspan="4">' +
            '<div id="wds_preview_wrapper_' + slideID + '" class="wds_preview_wrapper" style="width: ' + jQuery("#width").val() + 'px; height: ' + jQuery("#height").val() + 'px;">' +
            '<div class="wds_preview" style="overflow: hidden; position: absolute; width: inherit; height: inherit; background-color: transparent; background-image: none; display: block;">' +
            '<div id="wds_preview_image' + slideID + '" class="wds_preview_image' + slideID + '" ' +
                 'style="background-color: ' + wds_hex_rgba(jQuery("#background_color").val(), (100 - jQuery("#background_transparent").val())) + '; ' +
                        'background-image: url(\'\'); ' +
                        'background-position: center center; ' +
                        'background-repeat: no-repeat; ' +
                        'background-size: ' + jQuery('input[name=bg_fit]:radio:checked').val() + '; ' +
                        'border-width: ' + jQuery('#glb_border_width').val() + 'px; ' +
                        /*'border-style: ' + jQuery('#glb_border_style').val() + '; ' +
                        'border-color: #' + jQuery('#glb_border_color').val() + '; ' +
                        'border-radius: ' + jQuery('#glb_border_radius').val() + '; ' +
                        'box-shadow: ' + jQuery('#glb_box_shadow').val() + '; ' +*/
                        'width: inherit; height: inherit;"></div></div></div></td>' +
          '</tr><tr><td><table class="wds_slide_radio_left"><tr><td class="spider_label"><label>Published: </label></td>' +
              '<td><input id="published' + slideID + '1" type="radio" value="1" checked="checked" name="published' + slideID + '">' +
                  '<label for="published' + slideID + '1">Yes</label>' +
                  '<input id="published' + slideID + '0" type="radio" value="0" name="published' + slideID + '">' +
                  '<label for="published' + slideID + '0">No</label></td>' +
          '</tr></table><table class="wds_slide_radio_right"><tr id="trlink' + slideID + '"><td  title="You can set a redirection link, so that the user will get to the mentioned location upon hitting the slide.Use http:// and https:// for external links." class="wds_tooltip spider_label"><label for="link' + slideID + '">Link the slide to: </label></td>' +
                   '<td><input id="link' + slideID + '" type="text"  value="" name="link' + slideID + '" />' +
                       '<input id="target_attr_slide' + slideID + '" type="checkbox"  name="target_attr_slide' + slideID + '" value="1" checked="checked" /><label for="target_attr_slide' + slideID + '"> Open in a new window</label>' +
                       '</td>' +
          '</tr></table></td></tr><tr class="bgcolor"><td colspan="4">' +
            '<div class="layer_add_buttons_wrap"><input class="action_buttons add_text_layer ' + (!fv ? "" : " wds_free_button") + '  button-small" type="button" value="Add Text Layer" onclick="' + (!fv ? "wds_add_layer(\'text\', \'' + slideID + '\')" : "alert('This functionality is disabled in free version.')") + '; return false;">' +
            img_layer_upload_by +
	    '</div><div class="layer_add_buttons_wrap"><input class="action_buttons add_video_layer button-small wds_free_button" type="button" onclick="alert(\'This functionality is disabled in free version.\'); return false;" value="Add Video Layer" />' +
            '</div><div class="layer_add_buttons_wrap"><input class="action_buttons add_embed_layer button-small wds_free_button" type="button" value="Embed Media Layer" onclick="alert(\'This functionality is disabled in free version.\'); return false;" />' +
            ' </div><div class="layer_add_buttons_wrap"><input class="action_buttons add_social_layer button-small wds_free_button" type="button" value="Add Social Buttons Layer" onclick="alert(\'This functionality is disabled in free version.\'); return false;">' +
	    '</div><div class="layer_add_buttons_wrap"><input class="action_buttons add_hotspot_layer button-small wds_free_button" type="button" value="Add Hotspot Layer" onclick="alert(\'This functionality is disabled in free version.\'); return false;"></td>' +
          '</tr></tbody></table>' +
          '<input id="slide' + slideID + '_layer_ids_string" name="slide' + slideID + '_layer_ids_string" type="hidden" value="" />' +
          '<input id="slide' + slideID + '_del_layer_ids_string" name="slide' + slideID + '_del_layer_ids_string" type="hidden" value="" />' +
          '<script>' +
            'jQuery(window).load(function() {' +
              'wds_drag_layer(\'' + slideID + '\');' +
            '});' +
            'spider_remove_url(\'image_url' + slideID + '\', \'wds_preview_image' + slideID + '\');' +
          '</script>' +
          '</div>');
  jQuery('#wbs_subtab' + slideID).addClass("wds_sub_active");
  wds_slide_weights();
  wds_onkeypress();
  jQuery(function(){
    jQuery(document).on("click","#wds_tab_image" + slideID ,function(){
        wds_change_sub_tab(this, 'wds_slide' + slideID);
    });
    jQuery(document).on("click","#wds_tab_image" + slideID + " input",function(e){
        e.stopPropagation();
    });
    jQuery(document).on("click","#title" + slideID,function(){
        wds_change_sub_tab(jQuery("#wds_tab_image" + slideID), 'wds_slide' + slideID);
        wds_change_sub_tab_title(this, 'wds_slide' + slideID);
    });
  });
  return slideID;
}

function wds_remove_slide(slideID, conf) {
  if (typeof conf == "undefined") {
    var conf = 1;
  }
  if (conf) {
    if (!confirm("Do you want to delete slide?")) {
      return;
    }
  }
  jQuery("#sub_tab").val("");
  jQuery(".wds_slides_box *").removeClass("wds_sub_active");
  jQuery(".wds_slide" + slideID).remove();
  jQuery("#wbs_subtab" + slideID).remove();
  jQuery("#wds_subtab_wrap" + slideID).remove();

  var slideIDs = jQuery("#slide_ids_string").val();
  slideIDs = slideIDs.replace(slideID + ",", "");
  jQuery("#slide_ids_string").val(slideIDs);
  var delslideIds = jQuery("#del_slide_ids_string").val() + slideID + ",";
  jQuery("#del_slide_ids_string").val(delslideIds);

  jQuery(".wbs_subtab div[id^='wbs_subtab']").each(function () {
    var id = jQuery(this).attr("id");
    firstSlideID = id.replace("wbs_subtab", "");
    jQuery("#wbs_subtab" + firstSlideID).addClass("wds_sub_active");
    jQuery(".wds_slide" + firstSlideID).addClass("wds_sub_active");
  });
}

function wds_trans_end(id, effect) {
  var transitionEvent = wds_whichTransitionEvent();
  var e = document.getElementById(id);
  transitionEvent && e.addEventListener(transitionEvent, function() {
    jQuery("#" + id).removeClass("wds_animated").removeClass(effect);
  });
}

function wds_whichTransitionEvent() {
  var t;
  var el = document.createElement('fakeelement');
  var transitions = {
    'animation':'animationend',
    'OAnimation':'oAnimationEnd',
    'MozAnimation':'animationend',
    'WebkitAnimation':'webkitAnimationEnd'
  }
  for (t in transitions) {
    if (el.style[t] !== undefined) {
      return transitions[t];
    }
  }
}

function wds_new_line(prefix) {
  jQuery("#" + prefix).html(jQuery("#" + prefix + "_text").val().replace(/(\r\n|\n|\r)/gm, "<br />"));
}

function wds_trans_effect_in(slider_id, prefix, social) {
  var social_class = "";
  if (social) {
    social_class = ' fa fa-' + jQuery("#" + prefix + "_social_button").val();
  }
  jQuery("#" + prefix).css(
    '-webkit-animation-duration', jQuery("#" + prefix + "_duration_eff_in").val() / 1000 + "s").css(
    'animation-duration' , jQuery("#" + prefix + "_duration_eff_in").val() / 1000 + "s");
  jQuery("#" + prefix).removeClass().addClass(
    jQuery("#" + prefix + "_layer_effect_in").val() + " wds_animated wds_draggable_" + slider_id + social_class + " wds_draggable ui-draggable");
}

function wds_trans_effect_out(slider_id, prefix, social) {
  var social_class = "";
  if (social) {
    social_class = ' fa fa-' + jQuery("#" + prefix + "_social_button").val();
  }
  jQuery("#" + prefix).css(
    '-webkit-animation-duration', jQuery("#" + prefix + "_duration_eff_out").val() / 1000 + "s").css(
    'animation-duration' , jQuery("#" + prefix + "_duration_eff_out").val() / 1000 + "s");
  jQuery("#" + prefix).removeClass().addClass(
    jQuery("#" + prefix + "_layer_effect_out").val() + " wds_animated wds_draggable_" + slider_id + social_class + " wds_draggable ui-draggable");
}

function wds_break_word(that, prefix) {
  if (jQuery(that).is(':checked')) {
    jQuery("#" + prefix).css({wordBreak: "normal"});
  }
  else {
    jQuery("#" + prefix).css({wordBreak: "break-all"});  
  }
}

function wds_text_width(that, prefix) {
  var width = parseInt(jQuery(that).val());
  if (width) {
    if (width >= 100) {
      width = 100;
      jQuery("#" + prefix).css({left : 0});
      jQuery("#" + prefix + "_left").val(0);
    }
    else {
      var layer_left_position = parseInt(jQuery("#" + prefix).css("left"));	
      var layer_parent_div_width = parseInt(jQuery("#" + prefix).parent().width());
      var left_position_in_percent = (layer_left_position / layer_parent_div_width) * 100;
      if ((parseInt(left_position_in_percent) + width) > 100) {
        var left_in_pix = parseInt((100 - width) * (layer_parent_div_width / 100));
        jQuery("#" + prefix).css({left : left_in_pix + "px"});
        jQuery("#" + prefix + "_left").val(left_in_pix);
      }
    }
    jQuery("#" + prefix).css({width: width + "%"});
    jQuery(that).val(width);
  }
  else {
    jQuery("#" + prefix).css({width: ""});
    jQuery(that).val("0");
  }
}

function wds_text_height(that, prefix) {
  var height = parseInt(jQuery(that).val());
  if (height) {
    if (height >= 100) {
      jQuery("#" + prefix).css({top : 0});
      jQuery("#" + prefix + "_top").val(0);
    }
    else {
      var layer_top_position = parseInt(jQuery("#" + prefix).css("top"));	
      var layer_parent_div_height = parseInt(jQuery("#" + prefix).parent().height());
      var top_position_in_percent = (layer_top_position / layer_parent_div_height) * 100;
      if ((parseInt(top_position_in_percent) + height) > 100) {
        var top_in_pix = parseInt((100 - height) * (layer_parent_div_height / 100 ));
        jQuery("#" + prefix).css({top : top_in_pix});
        jQuery("#" + prefix + "_top").val(top_in_pix);
      }
    }
    jQuery("#" + prefix).css({height: height + "%"});
    jQuery(that).val(height);
  }
  else {
    jQuery("#" + prefix).css({height: ""});
    jQuery(that).val("0");
  }
}

function wds_whr(forfield) {
  var width = jQuery("#width").val();
  var height = jQuery("#height").val();
  var ratio = jQuery("#ratio").val();
  if (forfield == 'width') {
    if (width && height) {
      jQuery("#ratio").val(Math.round((width / height) * 100) / 100);
    }
    else if (width && ratio) {
      jQuery("#height").val(Math.round((width / ratio) * 100) / 100);
    }
  }
  else if (forfield == 'height') {
    if (width && height) {
      jQuery("#ratio").val(Math.round((width / height) * 100) / 100);
    }
  }
  else {
    if (width && ratio) {
      jQuery("#height").val(Math.round((width / ratio) * 100) / 100);
    }
  }
  jQuery('.wds_preview_wrapper').width(jQuery("#width").val());
  jQuery('.wds_preview_wrapper').height(jQuery("#height").val());
}

function wds_onkeypress() {
  jQuery("input[type='text']").on("keypress", function (event) {
    if ((jQuery(this).attr("id") != "search_value") && (jQuery(this).attr("id") != "current_page")) {
      var chCode1 = event.which || event.paramlist_keyCode;
      if (chCode1 == 13) {
        if (event.preventDefault) {
          event.preventDefault();
        }
        else {
          event.returnValue = false;
        }
      }
    }
    return true;
  });
}

jQuery(document).ready(function () {
  wds_onkeypress();
  if (typeof jQuery().tooltip !== 'undefined') {
    if (jQuery.isFunction(jQuery().tooltip)) {
      jQuery(".wds_tooltip").tooltip({
        track: true,
        content: function () {
          return jQuery(this).prop('title');
        }
      });
    }
  }
});

function wde_change_text_bg_color(prefix) {
  var bgColor = wds_hex_rgba(jQuery("#" + prefix + "_fbgcolor").val(), 100 - jQuery("#" + prefix + "_transparent").val());
  jQuery("#" + prefix).css({backgroundColor: bgColor});
  wds_hotspot_position(prefix);
}

function wds_change_fonts(prefix, change) {
  var fonts;
  if (jQuery("#" + prefix + "_google_fonts1").is(":checked")) {
    fonts = wds_objectGGF;
  }
  else {
    fonts = {'arial' : 'Arial', 'lucida grande' : 'Lucida grande', 'segoe ui' : 'Segoe ui', 'tahoma' : 'Tahoma', 'trebuchet ms' : 'Trebuchet ms', 'verdana' : 'Verdana', 'cursive' : 'Cursive', 'fantasy' : 'Fantasy', 'monospace' : 'Monospace', 'serif' : 'Serif'};
    if (jQuery('#possib_add_ffamily').val() != '') {
      var possib_add_ffamily = jQuery('#possib_add_ffamily').val().split("*WD*");
      for (var i = 0; i < possib_add_ffamily.length; i++) {
        if (possib_add_ffamily[i]) {
          fonts[possib_add_ffamily[i].toLowerCase()] = possib_add_ffamily[i];
        }
      }
    }
  }
  if (typeof change == "undefined") {
    var fonts_option = "";
    for (var i in fonts) {
      fonts_option += '<option value="' + i + '">' + fonts[i] + '</option>';
    }
    jQuery("#" + prefix + "_ffamily").html(fonts_option);
  }
  var font = jQuery("#" + prefix + "_ffamily").val();
  jQuery("#" + prefix).css({fontFamily: fonts[font]});
}

function set_ffamily_value() {
  var font = jQuery("#possib_add_ffamily_input").val();
  if (font != '' ) {
    if (jQuery("#possib_add_google_fonts").is(":checked")) {
      var ffamily_google = jQuery('#possib_add_ffamily_google').val();
      if (ffamily_google != '') {
        ffamily_google += "*WD*" + font;
      }
      else {
        ffamily_google = font;
      }
      jQuery('#possib_add_ffamily_google').val(ffamily_google);
    }
    else {
      var ffamily = jQuery('#possib_add_ffamily').val();
      if (ffamily != '') {
        ffamily += "*WD*" + font;
      }
      else {
        ffamily = font;
      }
      jQuery('#possib_add_ffamily').val(ffamily);
    }
  }
}

function wds_check_number() {
  var number = jQuery('#wds_thumb_size').val();
  if (number != '' && (number < 0 || number > 1)) {
      alert('The thumbnail size must be between 0 to 1.');
      jQuery('#wds_thumb_size').val("");
  }
}

function add_new_callback(par_tr, select) {
	var select_val = select.val(),
      selected = select.find("option[value=" + select_val + "]"),
      textarea_html = "";
  par_tr.next().find("td").append("<div class='callbeck-item'><span class='spider_label_options'>" + selected.text() + "</span><textarea class='callbeck-textarea' name='" + select_val + "'>" + textarea_html + "</textarea><button type='button' id='remove_callback' class='action_buttons remove_callback' onclick=\"remove_callback_item(this);\">Remove</button></div>");
	selected.hide().removeAttr("selected");

  select.find("option").each(function() {
    if (jQuery(this).css("display") == "block") {
      jQuery(this).attr("selected", "selected");
      return false;
    }
  });
}

function remove_callback_item(that) {
	jQuery(that).parent().remove();
	jQuery("#callback_list").find("option[value=" + jQuery(that).prev().attr("name") + "]").show();
}

function wds_bulk_actions(that) {
  var action = jQuery(that).val();
  if (action == 'export') {
    alert('This functionality is disabled in free version.');
  }
  else if (action != '') {
    if (action == 'delete_all') {
      if (!confirm('Do you want to delete selected items?')) {
        return false;
      }
    }
    spider_set_input_value('task', action);
    jQuery('#sliders_form').submit();     
  }
  else {
    return false;
  }
  return true;
}

function wds_loading_gif(image_name, plagin_url) {
 jQuery("#load_gif_img").attr('src', plagin_url + '/images/loading/' + image_name + '.gif');
}
function wds_position_left_disabled(that) {
  if (jQuery("#" + that + "_align_layer").is(":checked")) {
    jQuery("#" + that + "_left").attr('disabled', 'disabled');
  }
  else {
    jQuery("#" + that + "_left").removeAttr("disabled");
  }
}