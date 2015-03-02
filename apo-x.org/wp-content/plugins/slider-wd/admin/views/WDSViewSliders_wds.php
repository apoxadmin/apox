<?php

class WDSViewSliders_wds {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  private $model;


  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function __construct($model) {
    $this->model = $model;
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function display() {
    $rows_data = $this->model->get_rows_data();
    $page_nav = $this->model->page_nav();
    $search_value = ((isset($_POST['search_value'])) ? esc_html(stripslashes($_POST['search_value'])) : '');
    $search_select_value = ((isset($_POST['search_select_value'])) ? (int) $_POST['search_select_value'] : 0);
    $asc_or_desc = ((isset($_POST['asc_or_desc'])) ? esc_html(stripslashes($_POST['asc_or_desc'])) : 'asc');
    $order_by = (isset($_POST['order_by']) ? esc_html(stripslashes($_POST['order_by'])) : 'id');
    $order_class = 'manage-column column-title sorted ' . $asc_or_desc;
    $ids_string = '';
    ?>
    <div style="clear: both; float: left; width: 99%;">
      <div style="float: left; font-size: 14px; font-weight: bold;">
        This section allows you to create, edit and delete sliders.
        <a style="color: blue; text-decoration: none;" target="_blank" href="http://web-dorado.com/wordpress-slider-wd-guide-step-2.html">Read More in User Manual</a>
      </div>
      <div style="float: right; text-align: right;">
        <a style="text-decoration: none;" target="_blank" href="http://web-dorado.com/files/fromslider.php">
          <img width="215" border="0" alt="web-dorado.com" src="<?php echo WD_S_URL . '/images/wd_logo.png'; ?>" />
        </a>
      </div>
    </div>
    <form class="wrap" id="sliders_form" method="post" action="admin.php?page=sliders_wds" style="float: left; width: 99%;">
      <span class="slider-icon"></span>
      <h2>
        Sliders
        <a href="" class="add-new-h2" onclick="spider_set_input_value('task', 'add');
                                               spider_form_submit(event, 'sliders_form')">Add new</a>
      </h2>
      <div class="buttons_div">
        <span class="button-secondary non_selectable" onclick="spider_check_all_items()">
          <input type="checkbox" id="check_all_items" name="check_all_items" onclick="spider_check_all_items_checkbox()" style="margin: 0; vertical-align: middle;" />
          <span style="vertical-align: middle;">Select All</span>
        </span>
        <input class="button-secondary" type="submit" onclick="spider_set_input_value('task', 'publish_all')" value="Publish" />
        <input class="button-secondary" type="submit" onclick="spider_set_input_value('task', 'unpublish_all')" value="Unpublish" />
        <input class="button-secondary" type="submit" onclick="spider_set_input_value('task', 'duplicate_all')" value="Duplicate" />
        <input class="button-secondary" type="submit" onclick="if (confirm('Do you want to delete selected items?')) {
                                                       spider_set_input_value('task', 'delete_all');
                                                     } else {
                                                       return false;
                                                     }" value="Delete" />
      </div>
      <div class="tablenav top">
        <?php
        WDW_S_Library::search('Name', $search_value, 'sliders_form');
        WDW_S_Library::html_page_nav($page_nav['total'], $page_nav['limit'], 'sliders_form');
        ?>
      </div>
      <table class="wp-list-table widefat fixed pages">
        <thead>
          <th class="manage-column column-cb check-column table_small_col"><input id="check_all" type="checkbox" onclick="spider_check_all(this)" style="margin:0;" /></th>
          <th class="table_small_col <?php if ($order_by == 'id') {echo $order_class;} ?>">
            <a onclick="spider_set_input_value('task', '');
                        spider_set_input_value('order_by', 'id');
                        spider_set_input_value('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (esc_html(stripslashes($_POST['order_by'])) == 'id') && esc_html(stripslashes($_POST['asc_or_desc'])) == 'asc') ? 'desc' : 'asc'); ?>');
                        spider_form_submit(event, 'sliders_form')" href="">
              <span>ID</span><span class="sorting-indicator"></span>
            </a>
          </th>
          <th class="table_big_col">Slider</th>
          <th class="<?php if ($order_by == 'name') {echo $order_class;} ?>">
            <a onclick="spider_set_input_value('task', '');
                        spider_set_input_value('order_by', 'name');
                        spider_set_input_value('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (esc_html(stripslashes($_POST['order_by'])) == 'name') && esc_html(stripslashes($_POST['asc_or_desc'])) == 'asc') ? 'desc' : 'asc'); ?>');
                        spider_form_submit(event, 'sliders_form')" href="">
              <span>Name</span><span class="sorting-indicator"></span>
            </a>
          </th>
          <th class="table_big_col">Slides</th>
          <th class="table_big_col">Shortcode</th>
          <th class="table_large_col">PHP function</th>
          <th class="table_big_col <?php if ($order_by == 'published') {echo $order_class;} ?>">
            <a onclick="spider_set_input_value('task', '');
                        spider_set_input_value('order_by', 'published');
                        spider_set_input_value('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (esc_html(stripslashes($_POST['order_by'])) == 'published') && esc_html(stripslashes($_POST['asc_or_desc'])) == 'asc') ? 'desc' : 'asc'); ?>');
                        spider_form_submit(event, 'sliders_form')" href="">
              <span>Published</span><span class="sorting-indicator"></span>
            </a>
          </th>
          <th class="table_big_col">Edit</th>
          <th class="table_big_col">Delete</th>
        </thead>
        <tbody id="tbody_arr">
          <?php
          if ($rows_data) {
            foreach ($rows_data as $row_data) {
              $alternate = (!isset($alternate) || $alternate == 'class="alternate"') ? '' : 'class="alternate"';
              $published_image = (($row_data->published) ? 'publish' : 'unpublish');
              $published = (($row_data->published) ? 'unpublish' : 'publish');
              $prev_img_url = $this->model->get_slider_prev_img($row_data->id);
              $slides_count = $this->model->get_slides_count($row_data->id);
              ?>
              <tr id="tr_<?php echo $row_data->id; ?>" <?php echo $alternate; ?>>
                <td class="table_small_col check-column"><input id="check_<?php echo $row_data->id; ?>" name="check_<?php echo $row_data->id; ?>" onclick="spider_check_all(this)" type="checkbox" /></td>
                <td class="table_small_col"><?php echo $row_data->id; ?></td>
                <td class="table_big_col">
                  <img title="<?php echo $row_data->name; ?>" style="border: 1px solid #CCCCCC; max-width: 70px; max-height: 50px;" src="<?php echo $prev_img_url . '?date=' . date('Y-m-y H:i:s'); ?>">
                </td>
                <td>
                  <a onclick="spider_set_input_value('task', 'edit');
                                spider_set_input_value('page_number', '1');
                                spider_set_input_value('search_value', '');
                                spider_set_input_value('search_or_not', '');
                                spider_set_input_value('asc_or_desc', 'asc');
                                spider_set_input_value('order_by', 'order');
                                spider_set_input_value('current_id', '<?php echo $row_data->id; ?>');
                                spider_form_submit(event, 'sliders_form')" href="" title="Edit"><?php echo $row_data->name; ?>
                  </a>
                </td>
                <td class="table_big_col"><?php echo $slides_count; ?></td>
                <td class="table_big_col" style="padding-left: 0; padding-right: 0;">
                  <input type="text" value='[wds id="<?php echo $row_data->id; ?>"]' onclick="spider_select_value(this)" size="11" readonly="readonly" style="padding-left: 1px; padding-right: 1px;" />
                </td>
                <td class="table_large_col" style="padding-left: 0; padding-right: 0;">
                  <input type="text" value="&#60;?php wd_slider(<?php echo $row_data->id; ?>); ?&#62;" onclick="spider_select_value(this)" size="23" readonly="readonly" style="padding-left: 1px; padding-right: 1px;" />
                </td>
                <td class="table_big_col"><a onclick="spider_set_input_value('task', '<?php echo $published; ?>');spider_set_input_value('current_id', '<?php echo $row_data->id; ?>');spider_form_submit(event, 'sliders_form')" href=""><img src="<?php echo WD_S_URL . '/images/' . $published_image . '.png'; ?>"></img></a></td>
                <td class="table_big_col"><a onclick="spider_set_input_value('task', 'edit');
                                                      spider_set_input_value('page_number', '1');
                                                      spider_set_input_value('search_value', '');
                                                      spider_set_input_value('search_or_not', '');
                                                      spider_set_input_value('asc_or_desc', 'asc');
                                                      spider_set_input_value('order_by', 'order');
                                                      spider_set_input_value('current_id', '<?php echo $row_data->id; ?>');
                                                      spider_form_submit(event, 'sliders_form')" href="">Edit</a></td>
                <td class="table_big_col"><a onclick="spider_set_input_value('task', 'delete');
                                                      spider_set_input_value('current_id', '<?php echo $row_data->id; ?>');
                                                      spider_form_submit(event, 'sliders_form')" href="">Delete</a></td>
              </tr>
              <?php
              $ids_string .= $row_data->id . ',';
            }
          }
          ?>
        </tbody>
      </table>
      <input id="task" name="task" type="hidden" value="" />
      <input id="current_id" name="current_id" type="hidden" value="" />
      <input id="ids_string" name="ids_string" type="hidden" value="<?php echo $ids_string; ?>" />
      <input id="asc_or_desc" name="asc_or_desc" type="hidden" value="asc" />
      <input id="order_by" name="order_by" type="hidden" value="<?php echo $order_by; ?>" />
    </form>
    <?php
  }

  public function edit($id, $reset = FALSE) {
    $row = $this->model->get_row_data($id, $reset);
    $slides_row = $this->model->get_slides_row_data($id);
    $slide_ids_string = '';
    $sub_tab_type = WDW_S_Library::get('sub_tab', '');

    $page_title = (($id != 0) ? 'Edit slider ' . $row->name : 'Create new slider');
    $aligns = array(
      'left' => 'Left',
      'center' => 'Center',
      'right' => 'Right',
    );
    $border_styles = array(
      'none' => 'None',
      'solid' => 'Solid',
      'dotted' => 'Dotted',
      'dashed' => 'Dashed',
      'double' => 'Double',
      'groove' => 'Groove',
      'ridge' => 'Ridge',
      'inset' => 'Inset',
      'outset' => 'Outset',
    );
    $button_styles = array(
      'fa-chevron' => 'Chevron',
      'fa-angle' => 'Angle',
      'fa-angle-double' => 'Double',
    );
    $bull_styles = array(
      'fa-circle-o' => 'Circle O',
      'fa-circle' => 'Circle',
      'fa-minus' => 'Minus',
      'fa-square-o' => 'Square O',
      'fa-square' => 'Square',
    );
    $font_families = array(
      'arial' => 'Arial',
      'lucida grande' => 'Lucida grande',
      'segoe ui' => 'Segoe ui',
      'tahoma' => 'Tahoma',
      'trebuchet ms' => 'Trebuchet ms',
      'verdana' => 'Verdana',
      'cursive' =>'Cursive',
      'fantasy' => 'Fantasy',
      'monospace' => 'Monospace',
      'serif' => 'Serif',
    );
    $font_weights = array(
      'lighter' => 'Lighter',
      'normal' => 'Normal',
      'bold' => 'Bold',
    );
    $social_buttons = array(
      'facebook' => 'Facebook',
      'google-plus' => 'Google+',
      'twitter' => 'Twitter',
      'pinterest' => 'Pinterest',
      'tumblr' => 'Tumblr',
    );
    $free_effects = array('none', 'fade', 'sliceH', 'fan', 'scaleIn');
    $effects = array(
      'none' => 'None',
      'fade' => 'Fade',
      'sliceH' => 'Slice Horizontal',
      'fan' => 'Fan',
      'scaleIn' => 'Scale In',
      'zoomFade' => 'Zoom Fade',
      'parallelSlideH' => 'Parallel Slide Horizontal',
      'parallelSlideV' => 'Parallel Slide Vertical',
      'slic3DH' => 'Slice 3D Horizontal',
      'slic3DV' => 'Slice 3D Vertical',
      'slicR3DH' => 'Slice 3D Horizontal Random',
      'slicR3DV' => 'Slice 3D Vertical Random',
      'blindR' => 'Blind',
      'tilesR' => 'Tiles',
      'blockScaleR' => 'Block Scale Random',
      'cubeH' => 'Cube Horizontal',
      'cubeV' => 'Cube Vertical',
      'cubeR' => 'Cube Random',
      'sliceV' => 'Slice Vertical',
      'slideH' => 'Slide Horizontal',
      'slideV' => 'Slide Vertical',
      'scaleOut' => 'Scale Out',
      'blockScale' => 'Block Scale',
      'kaleidoscope' => 'Kaleidoscope',
      'blindH' => 'Blind Horizontal',
      'blindV' => 'Blind Vertical',
      'random' => 'Random',
      '3Drandom' => '3D Random',
    );
    $free_layer_effects = array('none', 'bounce', 'tada', 'bounceInDown', 'bounceOutUp', 'fadeInLeft', 'fadeOutRight');
    $layer_effects_in = array(
      'none' => 'None',
      'bounce' => 'Bounce',
      'tada' => 'Tada',
      'bounceInDown' => 'BounceInDown',
      'fadeInLeft' => 'FadeInLeft',
      'flash' => 'Flash',
      'pulse' => 'Pulse',
      'rubberBand' => 'RubberBand',
      'shake' => 'Shake',
      'swing' => 'Swing',
      'wobble' => 'Wobble',
      'hinge' => 'Hinge',
      
      'lightSpeedIn' => 'LightSpeedIn',
      'rollIn' => 'RollIn',
      
      'bounceIn' => 'BounceIn',
      'bounceInLeft' => 'BounceInLeft',
      'bounceInRight' => 'BounceInRight',
      'bounceInUp' => 'BounceInUp',
      
      'fadeIn' => 'FadeIn',
      'fadeInDown' => 'FadeInDown',
      'fadeInDownBig' => 'FadeInDownBig',
      'fadeInLeftBig' => 'FadeInLeftBig',
      'fadeInRight' => 'FadeInRight',
      'fadeInRightBig' => 'FadeInRightBig',
      'fadeInUp' => 'FadeInUp',
      'fadeInUpBig' => 'FadeInUpBig',
      
      'flip' => 'Flip',
      'flipInX' => 'FlipInX',
      'flipInY' => 'FlipInY',
      
      'rotateIn' => 'RotateIn',
      'rotateInDownLeft' => 'RotateInDownLeft',
      'rotateInDownRight' => 'RotateInDownRight',
      'rotateInUpLeft' => 'RotateInUpLeft',
      'rotateInUpRight' => 'RotateInUpRight',
        
      'zoomIn' => 'ZoomIn',
      'zoomInDown' => 'ZoomInDown',
      'zoomInLeft' => 'ZoomInLeft',
      'zoomInRight' => 'ZoomInRight',
      'zoomInUp' => 'ZoomInUp',       
    );
    $layer_effects_out = array(
      'none' => 'None',
      'bounce' => 'Bounce',
      'tada' => 'Tada',
      'bounceOutUp' => 'BounceOutUp',
      'fadeOutRight' => 'FadeOutRight',
      'flash' => 'Flash',
      'pulse' => 'Pulse',
      'rubberBand' => 'RubberBand',
      'shake' => 'Shake',
      'swing' => 'Swing',
      'wobble' => 'Wobble',
      'hinge' => 'Hinge',
      
      'lightSpeedOut' => 'LightSpeedOut',
      'rollOut' => 'RollOut',
    
      'bounceOut' => 'BounceOut',
      'bounceOutDown' => 'BounceOutDown',
      'bounceOutLeft' => 'BounceOutLeft',
      'bounceOutRight' => 'BounceOutRight',
      
      'fadeOut' => 'FadeOut',
      'fadeOutDown' => 'FadeOutDown',
      'fadeOutDownBig' => 'FadeOutDownBig',
      'fadeOutLeft' => 'FadeOutLeft',
      'fadeOutLeftBig' => 'FadeOutLeftBig',
      'fadeOutRightBig' => 'FadeOutRightBig',
      'fadeOutUp' => 'FadeOutUp',
      'fadeOutUpBig' => 'FadeOutUpBig',
    
      'flip' => 'Flip',
      'flipOutX' => 'FlipOutX',
      'flipOutY' => 'FlipOutY',
    
      'rotateOut' => 'RotateOut',
      'rotateOutDownLeft' => 'RotateOutDownLeft',
      'rotateOutDownRight' => 'RotateOutDownRight',
      'rotateOutUpLeft' => 'RotateOutUpLeft',
      'rotateOutUpRight' => 'RotateOutUpRight',

      'zoomOut' => 'ZoomOut',
      'zoomOutDown' => 'ZoomOutDown',
      'zoomOutLeft' => 'ZoomOutLeft',
      'zoomOutRight' => 'ZoomOutRight',
      'zoomOutUp' => 'ZoomOutUp',
    );
    $built_in_watermark_fonts = array();
    foreach (scandir(path_join(WD_S_DIR, 'fonts')) as $filename) {
      if (strpos($filename, '.') === 0) {
        continue;
      }
      else {
        $built_in_watermark_fonts[] = $filename;
      }
    }
    if (get_option("wds_theme_version")) {
      $fv = TRUE;
      $fv_class = 'spider_free_version_label';
      $fv_disabled = 'disabled="disabled"';
      $fv_message = '<tr><td colspan="2"><div class="error" style="padding: 5px; font-size: 14px; color: #000000 !important;">Some options are disabled in free version.</div></td></tr>';
      $fv_title = ' title="This option is disabled in free version."';
    }
    else {
      $fv = FALSE;
      $fv_class = '';
      $fv_disabled = '';
      $fv_message = '';
      $fv_title = '';
    }
    ?>
    <div class="spider_message_cont"></div>
    <div class="spider_load">
      <div class="spider_load_cont"></div>
      <div class="spider_load_icon"><img class="spider_ajax_loading" src="<?php echo WD_S_URL . '/images/ajax_loader.png'; ?>"></div>
    </div>
    <div style="clear: both; float: left; width: 99%;">
      <div style="float: left; font-size: 14px; font-weight: bold;">
        This section allows you to add/edit slider.
        <a style="color: blue; text-decoration: none;" target="_blank" href="http://web-dorado.com/wordpress-slider-wd-guide-step-2.html">Read More in User Manual</a>
      </div>
      <div style="float: right; text-align: right;">
        <a style="text-decoration: none;" target="_blank" href="http://web-dorado.com/files/fromslider.php">
          <img width="215" border="0" alt="web-dorado.com" src="<?php echo WD_S_URL . '/images/wd_logo.png'; ?>" />
        </a>
      </div>
    </div>
    <form class="wrap" method="post" id="sliders_form" action="admin.php?page=sliders_wds" style="float: left; width: 99%;">
      <span class="slider-icon"></span>
      <h2><?php echo $page_title; ?></h2>
      <div class="wds_buttons" style="float: right; position: absolute; right: 11px; z-index: 50;">
        <input class="button-secondary" type="button" onclick="if (wds_check_required('name', 'Name')) {return false;};
                                                                   spider_set_input_value('task', 'save');
                                                                   spider_ajax_save('sliders_form', event);" value="Save" />
        <input class="button-secondary" type="button" onclick="if (wds_check_required('name', 'Name')) {return false;};
                                                                   spider_set_input_value('task', 'apply');
                                                                   spider_ajax_save('sliders_form', event);" value="Apply" />
        <input class="button-secondary" type="button" onclick="if (wds_check_required('name', 'Name')) {return false;};
                                                               spider_set_input_value('task', 'duplicate');
                                                               spider_ajax_save('sliders_form', event);" value="Save as Copy" />
	<?php
        if ($row->spider_uploader) {
          ?>
        <a href="<?php echo add_query_arg(array('action' => 'addImage', 'width' => '700', 'height' => '550', 'extensions' => 'jpg,jpeg,png,gif', 'callback' => 'wds_add_image', 'image_for' => 'add_slides', 'TB_iframe' => '1'), admin_url('admin-ajax.php')); ?>" class="button-primary thickbox thickbox-preview" title="Add Images" onclick="return false;">
          Add Images
        </a>
          <?php
        }
        ?>
        <input class="button-secondary wds_free_button" type="button" value="Add Posts" onclick="alert('This functionality is disabled in free version.')" />
        <input class="button-primary" type="button" onclick="if (wds_check_required('name', 'Name')) {return false;};
                                                               spider_set_input_value('task', 'set_watermark');
                                                               spider_ajax_save('sliders_form', event);" value="Set Watermark" />
        <input class="button-secondary" type="button" onclick="if (wds_check_required('name', 'Name')) {return false;};
                                                               spider_set_input_value('task', 'reset_watermark');
                                                               spider_ajax_save('sliders_form', event);" value="Reset Watermark" />
        <input class="button-secondary" type="button" onclick="if (wds_check_required('name', 'Name')) {return false;};
                                                               spider_set_input_value('task', 'reset');
                                                               spider_ajax_save('sliders_form', event);" value="Reset Settings" />
        <input class="button-secondary" type="submit" onclick="spider_set_input_value('task', 'cancel')" value="Cancel" />
      </div>
      <div class="wds_tabs">
        <a href="#"><span tab_type="settings" onclick="wds_change_tab(this, 'wds_settings_box')" class="wds_tab_label">Settings</span></a>
        <a href="#"><span tab_type="slides" onclick="wds_change_tab(this, 'wds_slides_box')" class="wds_tab_label">Slides</span></a>
        <div class="wds_clear"></div>
      </div>
      <div>
        <!--------------Settings tab----------->
        <div class="wds_box wds_settings_box">
          <div class="wds_nav_tabs">
            <ul>
              <li tab_type="global" onclick="wds_change_nav(this, 'wds_nav_global_box')">
                <a href="#">Global</a>
              </li>
              <li tab_type="navigation" onclick="wds_change_nav(this, 'wds_nav_navigation_box')" >
                <a href="#">Navigation</a>
              </li>
              <li tab_type="bullets" onclick="wds_change_nav(this, 'wds_nav_bullets_box')" >
                <a href="#">Bullets</a>
              </li>
              <li tab_type="filmstrip" onclick="wds_change_nav(this, 'wds_nav_filmstrip_box')" >
                <a href="#">Filmstrip</a>
              </li>
              <li tab_type="timer_bar" onclick="wds_change_nav(this, 'wds_nav_timer_bar_box')" >
                <a href="#">Timer bar</a>
              </li>
              <li tab_type="watermark" onclick="wds_change_nav(this, 'wds_nav_watermark_box')" >
                <a href="#">Watermark</a>
              </li>
              <li tab_type="css" onclick="wds_change_nav(this, 'wds_nav_css_box')" >
                <a href="#">CSS</a>
              </li>
            </ul>
          </div>
          <div>
            <div class="wds_nav_box wds_nav_global_box">
              <table>
                <tbody>
                  <tr>
                    <td class="spider_label"><label>Dimensions: </label></td>
                    <td>
                      <input type="text" name="width" id="width" value="<?php echo $row->width; ?>" class="spider_int_input" onchange="wds_whr('width')" onkeypress="return spider_check_isnum(event)" /> x 
                      <input type="text" name="height" id="height" value="<?php echo $row->height; ?>" class="spider_int_input" onchange="wds_whr('height')" onkeypress="return spider_check_isnum(event)" /> px
                      <div class="spider_description">Maximum width and height for slider.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label>Full width: </label></td>
                    <td>
                      <input type="radio" id="full_width1" name="full_width" <?php echo (($row->full_width) ? 'checked="checked"' : ''); ?> value="1" /><label for="full_width1">Yes</label>
                      <input type="radio" id="full_width0" name="full_width" <?php echo (($row->full_width) ? '' : 'checked="checked"'); ?> value="0" /><label for="full_width0">No</label>
                      <input type="text" name="ratio" id="ratio" value="" class="spider_int_input" onchange="wds_whr('ratio')" onkeypress="return spider_check_isnum(event)" /><label for="ratio">Ratio</label>
                      <div class="spider_description">The image will stretch to the page width, taking the height based on dimensions ratio.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label>Background fit: </label></td>
                    <td>
                      <input type="radio" name="bg_fit" id="bg_fit_cover" value="cover" <?php if ($row->bg_fit == 'cover') echo 'checked="checked"'; ?> onchange="jQuery('div[id^=\'wds_preview_image\']').css({backgroundSize: 'cover'})" /><label for="bg_fit_cover">Cover</label>
                      <input type="radio" name="bg_fit" id="bg_fit_fill" value="100% 100%" <?php if ($row->bg_fit == '100% 100%') echo 'checked="checked"'; ?> onchange="jQuery('div[id^=\'wds_preview_image\']').css({backgroundSize: '100% 100%'})" /><label for="bg_fit_fill">Fill</label>
                      <input type="radio" name="bg_fit" id="bg_fit_contain" value="contain" <?php if ($row->bg_fit == 'contain') echo 'checked="checked"'; ?> onchange="jQuery('div[id^=\'wds_preview_image\']').css({backgroundSize: 'contain'})" /><label for="bg_fit_contain">Contain</label>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="align">Align: </label></td>
                    <td>
                      <select name="align" id="align">
                        <?php
                        foreach ($aligns as $key => $align) {
                          ?>
                          <option value="<?php echo $key; ?>" <?php echo (($row->align == $key) ? 'selected="selected"' : ''); ?>><?php echo $align; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                      <div class="spider_description">Set the alignment of the slider.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label_options">
                      <label for="effect">Effect:</label>
                    </td>
                    <td>
                      <select name="effect" id="effect">
                        <?php
                        foreach ($effects as $key => $effect) {
                          ?>
                          <option value="<?php echo $key; ?>" <?php echo (!in_array($key, $free_effects)) ? 'disabled="disabled" title="This effect is disabled in free version."' : ''; ?> <?php if ($row->effect == $key) echo 'selected="selected"'; ?>><?php echo $effect; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                      <div class="spider_description spider_free_version">Some effects are disabled in free version.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="time_intervval">Time Interval: </label></td>
                    <td>
                      <input type="text" id="time_intervval" name="time_intervval" value="<?php echo $row->time_intervval; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" /> sec.
                      <div class="spider_description">Set the time interval for the change of the sliders when autoplay is on.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label>Autoplay: </label></td>
                    <td>
                      <input type="radio" id="autoplay1" name="autoplay" <?php echo (($row->autoplay) ? 'checked="checked"' : ''); ?> value="1" /><label for="autoplay1">Yes</label>
                      <input type="radio" id="autoplay0" name="autoplay" <?php echo (($row->autoplay) ? '' : 'checked="checked"'); ?> value="0" /><label for="autoplay0">No</label>
                      <div class="spider_description">Choose whether to autoplay the sliders or not.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label>Stop on hover: </label></td>
                    <td>
                      <input type="radio" id="stop_animation1" name="stop_animation" <?php echo (($row->stop_animation) ? 'checked="checked"' : ''); ?> value="1" /><label for="stop_animation1">Yes</label>
                      <input type="radio" id="stop_animation0" name="stop_animation" <?php echo (($row->stop_animation) ? '' : 'checked="checked"'); ?> value="0" /><label for="stop_animation0">No</label>
                      <div class="spider_description">The option works when autoplay is on.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label>Shuffle: </label></td>
                    <td>
                      <input type="radio" id="shuffle1" name="shuffle" <?php echo (($row->shuffle) ? 'checked="checked"' : ''); ?> value="1" /><label for="shuffle1">Yes</label>
                      <input type="radio" id="shuffle0" name="shuffle" <?php echo (($row->shuffle) ? '' : 'checked="checked"'); ?> value="0" /><label for="shuffle0">No</label>
                      <div class="spider_description">Choose whether to have the slides change in a random manner or to keep the original sequence.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label>Music: </label></td>
                    <td>
                      <input type="radio" id="music1" name="music" <?php echo (($row->music) ? 'checked="checked"' : ''); ?> value="1" onClick="bwg_enable_disable('', 'tr_music_url', 'music1')" /><label for="music1">Yes</label>
                      <input type="radio" id="music0" name="music" <?php echo (($row->music) ? '' : 'checked="checked"'); ?> value="0" onClick="bwg_enable_disable('none', 'tr_music_url', 'music0')" /><label for="music0">No</label>
                      <div class="spider_description">Choose whether to have music/audio track playback with the slider or not.</div>
                    </td>
                  </tr>
                  <tr id="tr_music_url">
                    <td class="spider_label_options">
                      <label for="music_url">Music url: </label>
                    </td>
                    <td>
                      <input type="text" id="music_url" name="music_url" size="39" value="<?php echo $row->music_url; ?>" style="display:inline-block;" />
                      <input id="add_music_url" class="button-primary" type="button" onclick="spider_media_uploader('music', event); return false;" value="Add music" />
                      <div class="spider_description">Only .aac,.m4a,.f4a,.mp3,.ogg,.oga formats are supported.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label>Smart Load: </label></td>
                    <td>
                      <input type="radio" id="preload_images1" name="preload_images" <?php echo (($row->preload_images) ? 'checked="checked"' : ''); ?> value="1" /><label for="preload_images1">Yes</label>
                      <input type="radio" id="preload_images0" name="preload_images" <?php echo (($row->preload_images) ? '' : 'checked="checked"'); ?> value="0" /><label for="preload_images0">No</label>
                      <div class="spider_description">Choose to have faster load for the first few images and process the rest meanwhile.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="background_color">Background color:</label></td>
                    <td>
                      <input type="text" name="background_color" id="background_color" value="<?php echo $row->background_color; ?>" class="color" onchange="jQuery('div[id^=\'wds_preview_image\']').css({backgroundColor: wds_hex_rgba(jQuery(this).val(), 100 - jQuery('#background_transparent').val())})" />
                      <input id="background_transparent" name="background_transparent" class="spider_int_input" type="text" onchange="jQuery('div[id^=\'wds_preview_image\']').css({backgroundColor: wds_hex_rgba(jQuery('#background_color').val(), 100 - jQuery(this).val())})" onkeypress="return spider_check_isnum(event)" value="<?php echo $row->background_transparent; ?>" /> %
                      <div class="spider_description">Transparency value must be between 0 to 100.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="glb_border_width">Border: </label></td>
                    <td>
                      <input type="text" name="glb_border_width" id="glb_border_width" value="<?php echo $row->glb_border_width; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" /> px 
                      <select name="glb_border_style" id="glb_border_style" >
                        <?php
                        foreach ($border_styles as $key => $border_style) {
                          ?>
                          <option value="<?php echo $key; ?>" <?php echo (($row->glb_border_style == $key) ? 'selected="selected"' : ''); ?>><?php echo $border_style; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                      <input type="text" name="glb_border_color" id="glb_border_color" value="<?php echo $row->glb_border_color; ?>" class="color" />
                      <div class="spider_description">Set the border width, type and the color.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="glb_border_radius">Border radius: </label></td>
                    <td>
                      <input type="text" name="glb_border_radius" id="glb_border_radius" value="<?php echo $row->glb_border_radius; ?>" class="spider_char_input" />
                      <div class="spider_description">Use CSS type values.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="glb_margin">Margin: </label></td>
                    <td>
                      <input type="text" name="glb_margin" id="glb_margin" value="<?php echo $row->glb_margin; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" /> px
                      <div class="spider_description">Set a margin for the slider.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="glb_box_shadow">Shadow: </label></td>
                    <td>
                      <input type="text" name="glb_box_shadow" id="glb_box_shadow" value="<?php echo $row->glb_box_shadow; ?>" class="spider_box_input" />
                      <div class="spider_description">Use CSS type values (e.g. 10px 10px 5px #888888).</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label_options">
                      <label>Right click protection: </label>
                    </td>
                    <td>
                      <input type="radio" name="image_right_click" id="image_right_click_1" value="1" <?php if ($row->image_right_click) echo 'checked="checked"'; ?> /><label for="image_right_click_1">Yes</label>
                      <input type="radio" name="image_right_click" id="image_right_click_0" value="0" <?php if (!$row->image_right_click) echo 'checked="checked"'; ?> /><label for="image_right_click_0">No</label>
                      <div class="spider_description">Disable image right click possibility.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label_options">
                      <label>Layer out on next: </label>
                    </td>
                    <td>
                      <input type="radio" name="layer_out_next" id="layer_out_next_1" value="1" <?php if ($row->layer_out_next) echo 'checked="checked"'; ?> /><label for="layer_out_next_1">Yes</label>
                      <input type="radio" name="layer_out_next" id="layer_out_next_0" value="0" <?php if (!$row->layer_out_next) echo 'checked="checked"'; ?> /><label for="layer_out_next_0">No</label>
                      <div class="spider_description">Choose whether to have the layer effect out regardless of the timing between the hit to the next slider or skip the effect out and get to the next image.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label>Turn SliderWD Media Upload: </label></td>
                    <td>
                      <input type="radio" id="spider_uploader1" name="spider_uploader" <?php echo (($row->spider_uploader) ? 'checked="checked"' : ''); ?> value="1" /><label for="spider_uploader1">Yes</label>
                      <input type="radio" id="spider_uploader0" name="spider_uploader" <?php echo (($row->spider_uploader) ? '' : 'checked="checked"'); ?> value="0" /><label for="spider_uploader0">No</label>
                      <div class="spider_description">Choose the option to use the custom media upload instead of the WordPress default for adding images.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label>Published: </label></td>
                    <td>
                      <input type="radio" id="published1" name="published" <?php echo (($row->published) ? 'checked="checked"' : ''); ?> value="1" /><label for="published1">Yes</label>
                      <input type="radio" id="published0" name="published" <?php echo (($row->published) ? '' : 'checked="checked"'); ?> value="0" /><label for="published0">No</label>
                      <div class="spider_description">Choose whether to publish the mentioned slider or not.</div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="wds_nav_box wds_nav_navigation_box">
              <table>
                <tbody>
                  <tr>
                    <td class="spider_label_options">
                      <label>Next / Previous buttons: </label>
                    </td>
                    <td>
                      <input type="radio" name="prev_next_butt" id="prev_next_butt_1" value="1" <?php if ($row->prev_next_butt) echo 'checked="checked"'; ?> /><label for="prev_next_butt_1">Yes</label>
                      <input type="radio" name="prev_next_butt" id="prev_next_butt_0" value="0" <?php if (!$row->prev_next_butt) echo 'checked="checked"'; ?> /><label for="prev_next_butt_0">No</label>
                      <div class="spider_description">Choose whether to display Previous and Next buttons or not.</div>
                    </td>
                  </tr> 
                  <tr>
                    <td class="spider_label_options">
                      <label>Show Navigation buttons: </label>
                    </td>
                    <td>
                      <input type="radio" name="navigation" id="navigation_1" value="hover" <?php if ($row->navigation == 'hover') echo 'checked="checked"'; ?> /><label for="navigation_1">On hover</label>
                      <input type="radio" name="navigation" id="navigation_0" value="always" <?php if ($row->navigation == 'always' ) echo 'checked="checked"'; ?> /><label for="navigation_0">Always</label>
                      <div class="spider_description">Select between the option of always displaying the navigation buttons or only when hovered.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label_options">
                      <label>Image for Next / Previous buttons: </label>
                    </td>
                    <td>
                      <input type="radio" name="rl_butt_img_or_not" id="rl_butt_img_or_not_our" value="our" <?php if ($row->rl_butt_img_or_not == 'our') echo 'checked="checked"'; ?> onClick="image_for_next_prev_butt('our')" /><label for="rl_butt_img_or_not_our">Default</label>
                      <input type="radio" name="rl_butt_img_or_not" id="rl_butt_img_or_not_cust" value="custom" <?php if ($row->rl_butt_img_or_not == 'custom') echo 'checked="checked"'; ?> onClick="image_for_next_prev_butt('custom')" /><label for="rl_butt_img_or_not_cust">Custom</label>
                      <input type="radio" name="rl_butt_img_or_not" id="rl_butt_img_or_not_style" value="style" <?php if ($row->rl_butt_img_or_not == 'style') echo 'checked="checked"'; ?> onClick="image_for_next_prev_butt('style')" /><label for="rl_butt_img_or_not_style">Styled</label>
                      <input type="hidden" id="right_butt_url" name="right_butt_url" value="<?php echo $row->right_butt_url; ?>" />
                      <input type="hidden" id="right_butt_hov_url" name="right_butt_hov_url" value="<?php echo $row->right_butt_hov_url; ?>" />
                      <input type="hidden" id="left_butt_url" name="left_butt_url" value="<?php echo $row->left_butt_url; ?>" />
                      <input type="hidden" id="left_butt_hov_url" name="left_butt_hov_url" value="<?php echo $row->left_butt_hov_url; ?>" />
                      <div class="spider_description">Choose whether to use default navigation buttons or to upload custom ones.</div>
                    </td>
                  </tr>	
                </tbody>
                <tbody class="<?php echo $fv_class; ?>"<?php echo $fv_title; ?>>
                  <?php echo $fv_message; ?>
                  <tr id="right_left_butt_style">
                    <td class="spider_label <?php echo $fv_class; ?>"><label for="rl_butt_style">Next / Previous buttons style: </label></td>
                    <td>
                      <div style="display: table;">
                        <div style="display: table-cell; vertical-align: middle;">
                          <select name="rl_butt_style" id="rl_butt_style" onchange="change_rl_butt_style(jQuery(this).val())">
                          <?php
                          foreach ($button_styles as $key => $button_style) {
                            ?>
                            <option value="<?php echo $key; ?>" <?php echo (($row->rl_butt_style == $key) ? 'selected="selected"' : ''); ?>><?php echo $button_style; ?></option>
                            <?php
                          }
                          ?>
                          </select>
                        </div>
                        <div style="display: table-cell; vertical-align: middle; background-color: rgba(229, 229, 229, 0.62); text-align: center;">
                          <i id="wds_left_style" class="fa <?php echo $row->rl_butt_style; ?>-left" style="color: #<?php echo $row->butts_color; ?>; display: inline-block; font-size: 40px; width: 40px; height: 40px;"></i>
                          <i id="wds_right_style" class="fa <?php echo $row->rl_butt_style; ?>-right" style="color: #<?php echo $row->butts_color; ?>; display: inline-block; font-size: 40px; width: 40px; height: 40px;"></i>
                        </div>
                      </div>
                      <div class="spider_description">Choose the style of the button you prefer to have as navigation buttons.</div>
                    </td>
                  </tr>				  
                  <tr id="right_butt_upl">
                    <td class="spider_label_options" style="vertical-align: middle;">
                      <label>Upload buttons images: </label>
                    </td>
                    <td>
                      <div style="display: table;">
                        <div style="display: table-cell; vertical-align: middle;">
                          <input class="button-secondary wds_ctrl_btn_upload wds_free_button" type="button" value="Previous Button" onclick="alert('This functionality is disabled in free version.')" />
                          <input class="button-secondary wds_ctrl_btn_upload wds_free_button" type="button" value="Previous Button Hover" onclick="alert('This functionality is disabled in free version.')" />
                        </div>
                        <div style="display: table-cell; vertical-align: middle;">
                          <input class="button-secondary wds_ctrl_btn_upload wds_free_button" type="button" value="Next Button" onclick="alert('This functionality is disabled in free version.')" />
                          <input class="button-secondary wds_ctrl_btn_upload wds_free_button" type="button" value="Next Button Hover" onclick="alert('This functionality is disabled in free version.')" />
                        </div>
                        <div style="width:100px; display: table-cell; vertical-align: middle; text-align: center;background-color: rgba(229, 229, 229, 0.62); padding-top: 4px; border-radius: 3px;">
                          <img id="left_butt_img" src="<?php echo $row->left_butt_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                          <img id="right_butt_img" src="<?php echo $row->right_butt_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                          <img id="left_butt_hov_img" src="<?php echo $row->left_butt_hov_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                          <img id="right_butt_hov_img" src="<?php echo $row->right_butt_hov_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                        </div>
                        <div style="display: table-cell; text-align: center; vertical-align: middle;">
                          <input type="button" class="button button-small wds_reverse" onclick="wds_change_custom_src()" value="Reverse" />
                        </div>
                      </div>
                    </td>
                  </tr>
                  <script>				  
                    var wds_rl_butt_type = [];
                    var rl_butt_dir = '<?php echo WD_S_URL . '/images/arrow/'; ?>';
                    var type_cur_fold = '1';
                    <?php				    
                    $folder_names = scandir(WD_S_DIR . '/images/arrow'); 
                    $cur_fold_name = '';
                    $cur_type_key = '';
                    $cur_color_key = '';
                    $cur_sub_fold_names = array();
                    array_splice($folder_names, 0, 2);
                    $flag = FALSE;
                    foreach ($folder_names as $type_key => $folder_name) {
                      if (is_dir(WD_S_DIR . '/images/arrow/' . $folder_name)) {
                        ?>
                        wds_rl_butt_type["<?php echo $type_key; ?>"] = [];
                        wds_rl_butt_type["<?php echo $type_key; ?>"]["type_name"] = "<?php echo $folder_name; ?>";
                        <?php
                        if ($row->left_butt_url != '') {
                          /* Getting current button's type folder and color folder.*/
                          $check_cur_fold = explode('/' , $row->left_butt_url);
                          if (in_array($folder_name, $check_cur_fold)) {
                            $flag = TRUE;
                            $cur_fold_name = $folder_name;
                            $cur_type_key = $type_key;
                            $cur_sub_fold_names = scandir(WD_S_DIR . '/images/arrow/' . $cur_fold_name);
                            array_splice($cur_sub_fold_names, 0, 2);
                            ?>
                        type_cur_fold = '<?php echo $cur_type_key;?>';
                            <?php
                          }
                        }
                        $sub_folder_names = scandir( WD_S_DIR . '/images/arrow/' . $folder_name);
                        array_splice($sub_folder_names, 0, 2);
                        foreach ($sub_folder_names as $color_key => $sub_folder_name) {
                          if (is_dir(WD_S_DIR . '/images/arrow/' . $folder_name . '/' . $sub_folder_name)) {
                            if ($cur_fold_name == $folder_name) {
                              /* Getting current button's color key.*/
                              if (in_array($sub_folder_name, $check_cur_fold)) {
                                $cur_color_key = $color_key;
                              }
                            }
                            ?>
                            wds_rl_butt_type["<?php echo $type_key; ?>"]["<?php echo $color_key; ?>"] = "<?php echo $sub_folder_name; ?>";
                            <?php
                          }
                        }
                      }
                      else {
                        echo $folder_name . " is not a directory.";
                      }
                    }
                    ?> 
                  </script>
                  <tr id="right_left_butt_select">
                    <td class="spider_label_options" style="vertical-align: middle;">
                      <label for="right_butt_url">Choose buttons: </label>
                    </td>
                    <td style="display: block;">
                      <div style="display: table; margin-bottom: 14px;">
                        <div style="display: table-cell; vertical-align: middle;">
                          <div style="display: block; width: 180px;">
                            <div class="spider_choose_option" onclick="wds_choose_option(this)"> 
                              <div  class="spider_option_main_title">Choose group</div>
                              <div class="spider_sel_option_ic"><i class="fa fa-angle-down fa-lg" style="color: #1E8CBE"></i></div>
                            </div>
                            <div class="spider_options_cont">
                            <?php
                            foreach ($folder_names as $type_key => $folder_name) {
                              ?> 							  							  
                              <div class="spider_option_cont wds_rl_butt_groups" value="<?php echo $type_key; ?>" <?php echo (($cur_type_key == $type_key) ? 'selected="selected" style="background-color: #3399FF;"' : ''); ?> onclick="change_rl_butt_type(this)"> 
                                <div  class="spider_option_cont_title">
                                  <?php echo 'Group-' . ++$type_key; ?>
                                </div>
                                <div class="spider_option_cont_img">
                                  <img class="src_top_left" style="display: inline-block; width: 14px; height: 14px;" />
                                  <img class="src_top_right" style="display: inline-block; width: 14px; height: 14px;" />
                                  <img class="src_bottom_left" style="display: inline-block; width: 14px; height: 14px;" />
                                  <img class="src_bottom_right" style="display: inline-block; width: 14px; height: 14px;" /> 
                                </div>
                              </div>
                              <?php
                            }
                            if (!$flag) {
                              /* Folder doesn't exist.*/
                              ?>
                              <div class="spider_option_cont" value="0" selected="selected" disabled="disabled">Custom</div>
                              <?php
                            }
                            ?>
                            </div>
                          </div>							
                        </div>
                        <div style="display:table-cell;vertical-align: middle;">
                          <div style="display: block; width: 180px; margin-left: 12px;">
                            <div class="spider_choose_option" onclick="alert('This functionality is disabled in free version.')">
                              <div  class="spider_option_main_title">Choose color</div>
                              <div class="spider_sel_option_ic"><i class="fa fa-angle-down fa-lg" style="color:#1E8CBE"></i></div>
                            </div>
                          </div>
                        </div>
                        <div style="width:100px; display: table-cell; vertical-align: middle; text-align: center;">
                          <div style=" display: block; margin-left: 12px; vertical-align: middle; text-align: center;background-color: rgba(229, 229, 229, 0.62); padding-top: 4px; border-radius: 3px;">
                          <img id="rl_butt_img_l" src="<?php echo $row->left_butt_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                          <img id="rl_butt_img_r" src="<?php echo $row->right_butt_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                          <img id="rl_butt_hov_img_l" src="<?php echo $row->left_butt_hov_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                          <img id="rl_butt_hov_img_r" src="<?php echo $row->right_butt_hov_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                          </div>
                        </div>
                        <div style="display: table-cell; text-align: center; vertical-align: middle;">
                          <input type="button" class="button button-small wds_reverse" onclick="change_src()" value="Reverse" />
                        </div>
                      </div>
                      <div class="spider_description">Choose the type and color for navigation button images. The option is designed for limited preview (colors not included) purposes and can't be saved.</div>
                    </td>
                  </tr>
                  <tr id="right_left_butt_size">
                    <td class="spider_label <?php echo $fv_class; ?>"><label for="rl_butt_size">Next / Previous buttons size: </label></td>
                    <td>
                      <input type="text" name="rl_butt_size" id="rl_butt_size" value="<?php echo $row->rl_butt_size; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" <?php echo $fv_disabled; ?> /> px
                      <div class="spider_description">Set the size for the next / previous buttons.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label_options">
                      <label>Play / Pause button: </label>
                    </td>
                    <td>
                      <input type="radio" name="play_paus_butt" id="play_paus_butt_1" value="1" <?php if ($row->play_paus_butt) echo 'checked="checked"'; ?> /><label for="play_paus_butt_1">Yes</label>
                      <input type="radio" name="play_paus_butt" id="play_paus_butt_0" value="0" <?php if (!$row->play_paus_butt) echo 'checked="checked"'; ?> /><label for="play_paus_butt_0">No</label>
                      <div class="spider_description">Choose whether to display Play and Pause buttons or not.</div>
                    </td>
                  </tr>
                </tbody>
                <tbody>
                  <tr>
                    <td class="spider_label_options">
                      <label>Image for Play / Pause buttons: </label>
                    </td>
                    <td>
                      <input type="radio" name="play_paus_butt_img_or_not" id="play_pause_butt_img_or_not_our" value="our" <?php if ($row->play_paus_butt_img_or_not == 'our') echo 'checked="checked"'; ?> onClick="image_for_play_pause_butt('our')" /><label for="play_pause_butt_img_or_not_our">Default</label>
                      <input type="radio" name="play_paus_butt_img_or_not" id="play_pause_butt_img_or_not_cust" value="custom" <?php if ($row->play_paus_butt_img_or_not == 'custom') echo 'checked="checked"'; ?> onClick="image_for_play_pause_butt('custom')" /><label for="play_pause_butt_img_or_not_cust">Custom</label>
                      <input type="radio" name="play_paus_butt_img_or_not" id="play_pause_butt_img_or_not_select" value="style" <?php if ($row->play_paus_butt_img_or_not == 'style') echo 'checked="checked"'; ?> onClick="image_for_play_pause_butt('style')" /><label for="play_pause_butt_img_or_not_select">Styled</label>
                      <input type="hidden" id="play_butt_url" name="play_butt_url" value="<?php echo $row->play_butt_url; ?>" />
                      <input type="hidden" id="play_butt_hov_url" name="play_butt_hov_url" value="<?php echo $row->play_butt_hov_url; ?>" />
                      <input type="hidden" id="paus_butt_url" name="paus_butt_url" value="<?php echo $row->paus_butt_url; ?>" />
                      <input type="hidden" id="paus_butt_hov_url" name="paus_butt_hov_url" value="<?php echo $row->paus_butt_hov_url; ?>" />
                      <div class="spider_description">Choose whether to use default play/pause buttons or to upload custom ones.</div>
                    </td>
                  </tr>
                </tbody>
                <tbody class="<?php echo $fv_class; ?>"<?php echo $fv_title; ?>>
                  <tr id="play_pause_butt_style">
                    <td class="spider_label"><label for="pp_butt_style">Play / Pause buttons style: </label></td>
                    <td>
                      <div style="display: table-cell; vertical-align: middle; background-color: rgba(229, 229, 229, 0.62); text-align: center;">
                        <i id="wds_play_style" class="fa fa-play" style="color: #<?php echo $row->butts_color; ?>; display: inline-block; font-size: 40px; width: 40px; height: 40px;"></i>
                        <i id="wds_paus_style" class="fa fa-pause" style="color: #<?php echo $row->butts_color; ?>; display: inline-block; font-size: 40px; width: 40px; height: 40px;"></i>
                      </div>
                    </td>
                  </tr>
                  <tr id="play_pause_butt_cust">
                    <td class="spider_label_options" style="vertical-align: middle;">
                      <label>Upload buttons images: </label>
                    </td>
                    <td>
                      <div style="display: table;">
                        <div style="display: table-cell; vertical-align: middle;">
                          <input class="button-secondary wds_ctrl_btn_upload wds_free_button" type="button" value="Play Button" onclick="alert('This functionality is disabled in free version.')" />
                          <input class="button-secondary wds_ctrl_btn_upload wds_free_button" type="button" value="Play Button Hover" onclick="alert('This functionality is disabled in free version.')" />
                        </div>
                        <div style="display: table-cell; vertical-align: middle;">
                          <input class="button-secondary wds_ctrl_btn_upload wds_free_button" type="button" value="Pause Button" onclick="alert('This functionality is disabled in free version.')" />
                          <input class="button-secondary wds_ctrl_btn_upload wds_free_button" type="button" value="Pause Button Hover" onclick="alert('This functionality is disabled in free version.')" />
                        </div>
                        <div style="width:100px; display: table-cell; vertical-align: middle; text-align: center;background-color: rgba(229, 229, 229, 0.62); padding-top: 4px; border-radius: 3px;">
                          <img id="play_butt_img" src="<?php echo $row->play_butt_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                          <img id="paus_butt_img" src="<?php echo $row->paus_butt_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                          <img id="play_butt_hov_img" src="<?php echo $row->play_butt_hov_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                          <img id="paus_butt_hov_img" src="<?php echo $row->paus_butt_hov_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                        </div>
                        <div style="display: table-cell; text-align: center; vertical-align: middle;">
                          <input type="button" class="button button-small wds_reverse" onclick="wds_change_play_paus_custom_src()" value="Reverse" />
                        </div>
                      </div>
                    </td>
                  </tr>
                  <script>				  
                    var wds_pp_butt_type = [];
                    var pp_butt_dir = '<?php echo WD_S_URL . '/images/button/'; ?>';
                    var pp_type_cur_fold = '1';
                    <?php				    
                    $folder_names = scandir(WD_S_DIR . '/images/button'); 
                    $butt_cur_fold_name = '';
                    $butt_cur_type_key = '';
                    $butt_cur_color_key = '';
                    $butt_cur_sub_fold_names = array();
                    array_splice($folder_names, 0, 2);
                    $flag = FALSE;
                    foreach ($folder_names as $type_key => $folder_name) {
                      if (is_dir(WD_S_DIR . '/images/button/' . $folder_name)) {
                        ?>
                        wds_pp_butt_type["<?php echo $type_key; ?>"] = [];
                        wds_pp_butt_type["<?php echo $type_key; ?>"]["type_name"] = "<?php echo $folder_name; ?>";
                        <?php
                        if ($row->play_butt_url != '') {
                          /* Getting current button's type folder and color folder.*/
                          $check_butt_cur_fold = explode('/' , $row->play_butt_url);
                          if (in_array($folder_name, $check_butt_cur_fold)) {
                            $flag = TRUE;
                            $butt_cur_fold_name = $folder_name;
                            $butt_cur_type_key = $type_key;
                            $butt_cur_sub_fold_names = scandir(WD_S_DIR . '/images/button/' . $butt_cur_fold_name);
                            array_splice($butt_cur_sub_fold_names, 0, 2);
                            ?>
                        pp_type_cur_fold = '<?php echo $butt_cur_type_key;?>';
                            <?php
                          }
                        }
                        $sub_folder_names = scandir( WD_S_DIR . '/images/button/' . $folder_name);
                        array_splice($sub_folder_names, 0, 2);
                        foreach ($sub_folder_names as $color_key => $sub_folder_name) {
                          if (is_dir(WD_S_DIR . '/images/button/' . $folder_name . '/' . $sub_folder_name)) {
                            if ($butt_cur_fold_name == $folder_name) {
                              /* Getting current button's color key.*/
                              if (in_array($sub_folder_name, $check_butt_cur_fold)) {
                                $butt_cur_color_key = $color_key;
                              }
                            }
                            ?>
                            wds_pp_butt_type["<?php echo $type_key; ?>"]["<?php echo $color_key; ?>"] = "<?php echo $sub_folder_name; ?>";
                            <?php
                          }
                        }
                      }
                      else {
                        echo $folder_name . " is not a directory.";
                      }
                    }
                    ?> 
                  </script>
                  <tr id="play_pause_butt_select">
                    <td class="spider_label_options" style="vertical-align: middle;">
                      <label for="right_butt_url">Choose buttons: </label>
                    </td>
                    <td style="display: block;">
                        <div style="display: table; margin-bottom: 14px;">
                          <div style="display: table-cell; vertical-align: middle;">
                            <div style="display: block; width: 180px;">
                              <div class="spider_choose_option" onclick="wds_choose_pp_option(this)"> 
                                <div class="spider_option_main_title">Choose group</div>
                                <div class="spider_sel_option_ic"><i class="fa fa-angle-down fa-lg" style="color: #1E8CBE"></i></div>
                              </div>
                              <div class="spider_pp_options_cont">
                              <?php
                              foreach ($folder_names as $type_key => $folder_name) {
                                ?> 							  							  
                                <div class="spider_option_cont wds_pp_butt_groups" value="<?php echo $type_key; ?>" <?php echo (($butt_cur_type_key == $type_key) ? 'selected="selected" style="background-color: #3399FF;"' : ''); ?> onclick="change_play_paus_butt_type(this)"> 
                                  <div  class="spider_option_cont_title">
                                    <?php echo 'Group-' . ++$type_key; ?>
                                  </div>
                                  <div class="spider_option_cont_img">
                                    <img class="pp_src_top_left" style="display: inline-block; width: 14px; height: 14px;" />
                                    <img class="pp_src_top_right" style="display: inline-block; width: 14px; height: 14px;" />
                                    <img class="pp_src_bottom_left" style="display: inline-block; width: 14px; height: 14px;" />
                                    <img class="pp_src_bottom_right" style="display: inline-block; width: 14px; height: 14px;" /> 
                                  </div>
                                </div>
                                <?php
                              }
                              if (!$flag) {
                                /* Folder doesn't exist.*/
                                ?>
                                <div class="spider_option_cont" value="0" selected="selected" disabled="disabled">Custom</div>
                                <?php
                              }
                              ?>
                              </div>
                            </div>
                          </div>
                          <div style="display:table-cell;vertical-align: middle;">
                            <div style="display: block; width: 180px; margin-left: 12px;">
                              <div class="spider_choose_option" onclick="alert('This functionality is disabled in free version.')">
                                <div  class="spider_option_main_title">Choose color</div>
                                <div class="spider_sel_option_ic"><i class="fa fa-angle-down fa-lg" style="color:#1E8CBE"></i></div>
                              </div>
                            </div>
                          </div>
                          <div style="width:100px; display: table-cell; vertical-align: middle; text-align: center;">
                            <div style=" display: block; margin-left: 12px; vertical-align: middle; text-align: center;background-color: rgba(229, 229, 229, 0.62); padding-top: 4px; border-radius: 3px;">
                              <img id="pp_butt_img_play" src="<?php echo $row->play_butt_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                              <img id="pp_butt_img_paus" src="<?php echo $row->paus_butt_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                              <img id="pp_butt_hov_img_play" src="<?php echo $row->play_butt_hov_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                              <img id="pp_butt_hov_img_paus" src="<?php echo $row->paus_butt_hov_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                            </div>
                          </div>
                          <div style="display: table-cell; text-align: center; vertical-align: middle;">
                            <input type="button" class="button button-small wds_reverse" onclick="change_play_paus_src()" value="Reverse" />
                          </div>
                        </div>
                      <div class="spider_description">Choose the type and color for navigation button images. The option is designed for limited preview (colors not included) purposes and can't be saved.</div>
                    </td>
                  </tr>
                  <tr id="play_pause_butt_size">
                    <td class="spider_label <?php echo $fv_class; ?>"><label for="pp_butt_size">Play / Pause button size: </label></td>
                    <td>
                      <input type="text" name="pp_butt_size" id="pp_butt_size" value="<?php echo $row->pp_butt_size; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" <?php echo $fv_disabled; ?> /> px
                      <div class="spider_description">Set the size for the play / pause buttons.</div>
                    </td>
                  </tr>
                  <tr id="tr_butts_color">
                    <td class="spider_label <?php echo $fv_class; ?>"><label for="butts_color">Buttons color: </label></td>
                    <td>
                      <input type="text" name="butts_color" id="butts_color" value="<?php echo $row->butts_color; ?>" class="color" <?php echo $fv_disabled; ?> onchange="jQuery('#wds_left_style,#wds_right_style').css({color: '#' + jQuery(this).val()})" />
                      <div class="spider_description">Select a color for the navigation buttons.</div>
                    </td>
                  </tr>
                  <tr id="tr_hover_color">
                    <td class="spider_label <?php echo $fv_class; ?>"><label for="hover_color">Hover color: </label></td>
                    <td>
                      <input type="text" name="hover_color" id="hover_color" value="<?php echo $row->hover_color; ?>" class="color" <?php echo $fv_disabled; ?> />
                      <div class="spider_description">Select a hover color for the navigation buttons.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label <?php echo $fv_class; ?>"><label for="nav_border_width">Border: </label></td>
                    <td>
                      <input type="text" name="nav_border_width" id="nav_border_width" value="<?php echo $row->nav_border_width; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" <?php echo $fv_disabled; ?> /> px
                      <select name="nav_border_style" id="nav_border_style" <?php echo $fv_disabled; ?>>
                        <?php
                        foreach ($border_styles as $key => $border_style) {
                          ?>
                          <option value="<?php echo $key; ?>" <?php echo (($row->nav_border_style == $key) ? 'selected="selected"' : ''); ?>><?php echo $border_style; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                      <input type="text" name="nav_border_color" id="nav_border_color" value="<?php echo $row->nav_border_color; ?>" class="color" <?php echo $fv_disabled; ?> />
                      <div class="spider_description">Select the type, size and the color of border for the navigation buttons.</div>
                    </td>
                  </tr>
                    <td class="spider_label <?php echo $fv_class; ?>"><label for="nav_border_radius">Border radius: </label></td>
                    <td>
                      <input type="text" name="nav_border_radius" id="nav_border_radius" value="<?php echo $row->nav_border_radius; ?>" class="spider_char_input" <?php echo $fv_disabled; ?> />
                      <div class="spider_description">Use CSS type values.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label <?php echo $fv_class; ?>"><label for="nav_bg_color">Background color: </label></td>
                    <td>
                      <input type="text" name="nav_bg_color" id="nav_bg_color" value="<?php echo $row->nav_bg_color; ?>" class="color" <?php echo $fv_disabled; ?> />
                      <input type="text" name="butts_transparent" id="butts_transparent" value="<?php echo $row->butts_transparent; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" <?php echo $fv_disabled; ?> /> %
                      <div class="spider_description">Transparency value must be between 0 to 100.</div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="wds_nav_box wds_nav_bullets_box">
              <table>
                <tbody>
                  <tr>
                    <td class="spider_label"><label>Enable bullets: </label></td>
                    <td>
                      <input type="radio" id="enable_bullets1" name="enable_bullets" <?php echo (($row->enable_bullets) ? 'checked="checked"' : ''); ?> value="1" /><label for="enable_bullets1">Yes</label>
                      <input type="radio" id="enable_bullets0" name="enable_bullets" <?php echo (($row->enable_bullets) ? '' : 'checked="checked"'); ?> value="0" /><label for="enable_bullets0">No</label>
                      <div class="spider_description">Choose whether to have navigation bullets or not.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label>Position: </label></td>
                    <td>
                      <select name="bull_position" id="bull_position">
                        <option value="top" <?php echo (($row->bull_position == "top") ? 'selected="selected"' : ''); ?>>Top</option>
                        <option value="bottom" <?php echo (($row->bull_position == "bottom") ? 'selected="selected"' : ''); ?>>Bottom</option>
                      </select>
                      <div class="spider_description">Select the position for the navigation bullets.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label_options">
                      <label>Image for bullets: </label>
                    </td>
                    <td>
                      <input type="radio" name="bull_butt_img_or_not" id="bull_butt_img_or_not_our" value="our" <?php if ($row->bull_butt_img_or_not == 'our') echo 'checked="checked"'; ?> onClick="image_for_bull_butt('our')" /><label for="bull_butt_img_or_not_our">Default</label>
                      <input type="radio" name="bull_butt_img_or_not" id="bull_butt_img_or_not_cust" value="custom" <?php if ($row->bull_butt_img_or_not == 'custom') echo 'checked="checked"'; ?> onClick="image_for_bull_butt('custom')" /><label for="bull_butt_img_or_not_cust">Custom</label>
                      <input type="radio" name="bull_butt_img_or_not" id="bull_butt_img_or_not_stl" value="style" <?php if ($row->bull_butt_img_or_not == 'style') echo 'checked="checked"'; ?> onClick="image_for_bull_butt('style')" /><label for="bull_butt_img_or_not_stl">Styled</label>
                      <input type="hidden" id="bullets_img_main_url" name="bullets_img_main_url" value="<?php echo $row->bullets_img_main_url; ?>" />
                      <input type="hidden" id="bullets_img_hov_url" name="bullets_img_hov_url" value="<?php echo $row->bullets_img_hov_url; ?>" />
                      <div class="spider_description">Choose whether to use default or styled bullets.</div>
                    </td>
                  </tr>
                </tbody>
                <tbody class="<?php echo $fv_class; ?>"<?php echo $fv_title; ?>>
                  <?php echo $fv_message; ?>
                  <tr id="bullets_style">
                    <td class="spider_label <?php echo $fv_class; ?>"><label for="bull_style">Bullet style: </label></td>
                    <td>
                      <div style="display: table;">
                        <div style="display: table-cell; vertical-align: middle;">
                          <select name="bull_style" id="bull_style" <?php echo $fv_disabled; ?> onchange="change_bull_style(jQuery(this).val())">
                            <?php
                            foreach ($bull_styles as $key => $bull_style) {
                              ?>
                              <option value="<?php echo $key; ?>" <?php echo (($row->bull_style == $key) ? 'selected="selected"' : ''); ?>><?php echo $bull_style; ?></option>
                              <?php
                            }
                            ?>
                          </select>
                        </div>
                        <div style="display: table-cell; vertical-align: middle; background-color: rgba(229, 229, 229, 0.62); text-align: center;">
                          <i id="wds_act_bull_style" class="fa <?php echo str_replace('-o', '', $row->bull_style); ?>" style="color: #<?php echo $row->bull_act_color; ?>; display: inline-block; font-size: 40px; width: 40px; height: 40px;"></i>
                          <i id="wds_deact_bull_style" class="fa <?php echo $row->bull_style; ?>" style="color: #<?php echo $row->bull_color; ?>; display: inline-block; font-size: 40px; width: 40px; height: 40px;"></i>
                        </div>
                      </div>
                      <div class="spider_description">Choose the style for the bullets.</div>
                    </td>
                  </tr>
                  <script>				  
                    var wds_blt_img_type = [];
                    var blt_img_dir = '<?php echo WD_S_URL . '/images/bullet/'; ?>';
					var bull_type_cur_fold = '1';
                    <?php				    
                    $folder_names = scandir(WD_S_DIR . '/images/bullet'); 
                    $bull_cur_fold_name = '';
                    $bull_cur_type_key = '';
                    $bull_cur_color_key = '';
                    $bull_cur_sub_fold_names = array();
                    array_splice($folder_names, 0, 2);
                    $flag = FALSE;
                    foreach ($folder_names as $type_key => $folder_name) {
                      if (is_dir(WD_S_DIR . '/images/bullet/' . $folder_name)) {
                        ?>
                        wds_blt_img_type["<?php echo $type_key; ?>"] = [];
                        wds_blt_img_type["<?php echo $type_key; ?>"]["type_name"] = "<?php echo $folder_name; ?>";
                        <?php
                        if ($row->bullets_img_main_url != '') {
                          /* Getting current button's type folder and color folder.*/
                          $check_bull_cur_fold = explode('/' , $row->bullets_img_main_url);
                          if (in_array($folder_name, $check_bull_cur_fold)) {
                            $flag = TRUE;
                            $bull_cur_fold_name = $folder_name;
                            $bull_cur_type_key = $type_key;
                            $bull_cur_sub_fold_names = scandir(WD_S_DIR . '/images/bullet/' . $bull_cur_fold_name);
                            array_splice($bull_cur_sub_fold_names, 0, 2);
                            ?>
                        bull_type_cur_fold = '<?php echo $bull_cur_type_key;?>';
                            <?php						
                          }
                        }
                        $sub_folder_names = scandir(WD_S_DIR . '/images/bullet/' . $folder_name);						  
                        array_splice($sub_folder_names, 0, 2); 
                        foreach ($sub_folder_names as $color_key => $sub_folder_name) {
                          if (is_dir(WD_S_DIR . '/images/bullet/' . $folder_name . '/' . $sub_folder_name)) {
                            if ($bull_cur_fold_name == $folder_name) {
                              /* Getting current button's color key.*/
                              if (in_array($sub_folder_name, $check_bull_cur_fold)) {
                                $bull_cur_color_key = $color_key;
                              }
                            }
                            ?>
                            wds_blt_img_type["<?php echo $type_key; ?>"]["<?php echo $color_key; ?>"] = "<?php echo $sub_folder_name; ?>";
                            <?php 
                          }
                        }
                      }
                      else {
                        echo $folder_name . " is not a directory";
                      }
                    }
                    ?> 
                  </script>
                  <tr id="bullets_images_cust">
                    <td class="spider_label_options" style="vertical-align: middle;">
                      <label>Upload buttons images: </label>
                    </td>
                    <td>
                      <div style="display: table;">
                        <div style="display: table-cell; vertical-align: middle;">
                          <input class="button-secondary wds_ctrl_btn_upload wds_free_button" type="button" value="Active Button" onclick="alert('This functionality is disabled in free version.')" />
                        </div>
                        <div style="display: table-cell; vertical-align: middle;">
                          <input class="button-secondary wds_free_button" type="button" value="Deactive Button" onclick="alert('This functionality is disabled in free version.')" />
                        </div>  
                        <div style="width:100px; display: table-cell; vertical-align: middle; text-align: center;background-color: rgba(229, 229, 229, 0.62); padding-top: 4px; border-radius: 3px;">
                          <img id="bull_img_main" src="<?php echo $row->bullets_img_main_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                          <img id="bull_img_hov" src="<?php echo $row->bullets_img_hov_url; ?>" style="display:inline-block; width: 40px; height: 40px;" /> 
                        </div>
                        <div style="display: table-cell; text-align: center; vertical-align: middle;">
                          <input type="button" class="button button-small wds_reverse" onclick="wds_change_bullets_custom_src()" value="Reverse" />
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr id="bullets_images_select">
                    <td class="spider_label_options" style="vertical-align: middle;">
                      <label for="bullets_images_url">Chooes buttons: </label>
                    </td>
                    <td style="display: block;">
                      <div style="display: table; margin-bottom: 14px;">
                        <div style="display: table-cell; vertical-align: middle;">
                          <div style="display: block; width: 180px;">
                            <div class="spider_choose_option" onclick="wds_choose_bull_option(this)">
                              <div class="spider_option_main_title">Choose group</div>
                              <div class="spider_sel_option_ic"><i class="fa fa-angle-down fa-lg" style="color: #1E8CBE;"></i></div>
                            </div>
                            <div class="spider_bull_options_cont">
                            <?php
                            foreach ($folder_names as $type_key => $folder_name) {
                              ?>
                              <div class="spider_option_cont wds_bull_butt_groups" value="<?php echo $type_key; ?>" <?php echo (($bull_cur_type_key == $type_key) ? 'selected="selected" style="background-color: #3399FF;"' : ''); ?> onclick="change_bullets_images_type(this)">
                                <div class="spider_option_cont_title" style="width: 64%;">
                                  <?php echo 'Group-' . ++$type_key; ?>
                                </div>
                                <div class="spider_option_cont_img">
                                  <img class="bull_src_left" style="display: inline-block; width: 14px; height: 14px;" />
                                  <img class="bull_src_right" style="display: inline-block; width: 14px; height: 14px;" />
                                </div>
                              </div>
                              <?php
                            }
                            if (!$flag) {
                              /* Folder doesn't exist.*/
                              ?>
                              <div class="spider_option_cont" value="0" selected="selected" disabled="disabled">Custom</div>
                              <?php
                            }
                            ?>
                            </div>
                          </div>							
                        </div>
                        <div style="display: table-cell; vertical-align: middle;">
                          <div style="display: block; width: 180px; margin-left: 12px;">
                            <div class="spider_choose_option" onclick="alert('This functionality is disabled in free version.')" >
                              <div class="spider_option_main_title" >Choose color</div>
                              <div class="spider_sel_option_ic"><i class="fa fa-angle-down fa-lg" style="color: #1E8CBE;"></i></div>
                            </div>
                          </div>
                        </div>						
                        <div style="width: 100px; display: table-cell; vertical-align: middle; text-align: center;">
                          <div style="display: block; vertical-align: middle; margin-left: 12px; text-align: center; background-color: rgba(229, 229, 229, 0.62); padding-top: 4px; border-radius: 3px;">
                            <img id="bullets_img_main" src="<?php echo $row->bullets_img_main_url; ?>" style="display: inline-block; width: 40px; height: 40px;" />
                            <img id="bullets_img_hov" src="<?php echo $row->bullets_img_hov_url; ?>" style="display: inline-block; width: 40px; height: 40px;" />
                          </div>
                        </div>						
                        <div style="display: table-cell; text-align: center; vertical-align: middle;">
                          <input type="button" class="button button-small wds_reverse" onclick="change_bullets_src()" value="Reverse" />
                        </div>
                      </div>
                      <div class="spider_description">Choose the type and color for the bullets. The option is designed for limited preview (colors not included) purposes and can't be saved.</div>
                    </td>
                  </tr>
                  <tr id="bullet_size">
                    <td class="spider_label <?php echo $fv_class; ?>"><label for="bull_size">Size: </label></td>
                    <td>
                      <input type="text" name="bull_size" id="bull_size" value="<?php echo $row->bull_size; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" <?php echo $fv_disabled; ?> /> px
                      <div class="spider_description">Define the size of the navigation bullets.</div>
                    </td>
                  </tr>
                  <tr id="bullets_color">
                    <td class="spider_label <?php echo $fv_class; ?>"><label for="bull_color">Color: </label></td>
                    <td>
                      <input type="text" name="bull_color" id="bull_color" value="<?php echo $row->bull_color; ?>" class="color" <?php echo $fv_disabled; ?> onchange="jQuery('#wds_deact_bull_style').css({color: '#' + jQuery(this).val()})" />
                      <div class="spider_description">Select the color for the navigation bullets.</div>
                    </td>
                  </tr> 
                  <tr id="bullets_act_color">
                    <td class="spider_label <?php echo $fv_class; ?>"><label for="bull_act_color">Active color: </label></td>
                    <td>
                      <input type="text" name="bull_act_color" id="bull_act_color" value="<?php echo $row->bull_act_color; ?>" class="color" <?php echo $fv_disabled; ?> onchange="jQuery('#wds_act_bull_style').css({color: '#' + jQuery(this).val()})" />
                      <div class="spider_description">Select the color for the bullet, which is currently displaying a corresponding image.</div>
                    </td>
                  </tr>
                  <tr id="bullet_margin">
                    <td class="spider_label <?php echo $fv_class; ?>"><label for="bull_margin">Margin: </label></td>
                    <td>
                      <input type="text" name="bull_margin" id="bull_margin" value="<?php echo $row->bull_margin; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" <?php echo $fv_disabled; ?> /> px
                      <div class="spider_description">Set the margin for the navigation bullets in pixels.</div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="wds_nav_box wds_nav_filmstrip_box spider_free_version_label" title="This functionality is disabled in free version.">
              <table>
                <tbody>
                  <tr>
                    <td colspan="2">
                      <div class="error" style="padding: 5px; font-size: 14px; color: #000000 !important;">Filmstrip is disabled in free version.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label spider_free_version_label"><label>Enable filmstrip: </label></td>
                    <td>
                      <input disabled="disabled" type="radio" id="enable_filmstrip1" name="enable_filmstrip" <?php echo (($row->enable_filmstrip) ? 'checked="checked"' : ''); ?> value="1" /><label for="filmstrip1">Yes</label>
                      <input disabled="disabled" type="radio" id="enable_filmstrip0" name="enable_filmstrip" <?php echo (($row->enable_filmstrip) ? '' : 'checked="checked"'); ?> value="0" /><label for="filmstrip0">No</label>
                      <div class="spider_description">Choose whether to have thumbnails of the slides displayed as a filmstrip or not.</div>
                    </td>
                  </tr>
                  <tr id="filmstrip_position">
                    <td class="spider_label"><label>Position: </label></td>
                    <td>
                      <select disabled="disabled" name="film_pos" id="film_pos">
                        <option value="top" <?php echo (($row->film_pos == "top") ? 'selected="selected"' : ''); ?>>Top</option>
                        <option value="right" <?php echo (($row->film_pos == "right") ? 'selected="selected"' : ''); ?>>Right</option>
                        <option value="bottom" <?php echo (($row->film_pos == "bottom") ? 'selected="selected"' : ''); ?>>Bottom</option>
                        <option value="left" <?php echo (($row->film_pos == "left") ? 'selected="selected"' : ''); ?>>Left</option>
                      </select>
                      <div class="spider_description">Set the position of the filmstrip.</div>
                    </td>
                  </tr>
                  <tr id="filmstrip_size">
                    <td class="spider_label"><label for="film_thumb_width">Thumbnail dimensions: </label></td>
                    <td>
                      <input disabled="disabled" type="text" name="film_thumb_width" id="film_thumb_width" value="<?php echo $row->film_thumb_width; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" /> x 
                      <input disabled="disabled" type="text" name="film_thumb_height" id="film_thumb_height" value="<?php echo $row->film_thumb_height; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" /> px
                      <div class="spider_description">Define the maximum width and heigth of the filmstrip thumbnails.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="film_bg_color">Background color: </label></td>
                    <td>
                      <input disabled="disabled" type="text" name="film_bg_color" id="film_bg_color" value="<?php echo $row->film_bg_color; ?>" class="color" />
                      <div class="spider_description">Select the background color for the filmstrip.</div>
                    </td>
                  </tr>
                  <tr id="filmstrip_thumb_margin">
                    <td class="spider_label"><label for="film_tmb_margin">Thumbnail margin: </label></td>
                    <td>
                      <input disabled="disabled" type="text" name="film_tmb_margin" id="film_tmb_margin" value="<?php echo $row->film_tmb_margin; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)"/> px
                      <div class="spider_description">Set the margin for the thumbnails.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="film_act_border_width">Active border: </label></td>
                    <td>
                      <input disabled="disabled" type="text" name="film_act_border_width" id="film_act_border_width" value="<?php echo $row->film_act_border_width; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)"/> px
                      <select disabled="disabled" name="film_act_border_style" id="film_act_border_style">
                        <?php
                        foreach ($border_styles as $key => $border_style) {
                          ?>
                          <option value="<?php echo $key; ?>" <?php echo (($row->film_act_border_style == $key) ? 'selected="selected"' : ''); ?>><?php echo $border_style; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                      <input disabled="disabled" type="text" name="film_act_border_color" id="film_act_border_color" value="<?php echo $row->film_act_border_color; ?>" class="color"/>
                      <div class="spider_description">The thumbnail for the currently displayed image will have a border. You can set its size, type and color.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="film_dac_transparent">Deactive transparency: </label></td>
                    <td>
                      <input disabled="disabled" type="text" name="film_dac_transparent" id="film_dac_transparent" value="<?php echo $row->film_dac_transparent; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)"/> %
                      <div class="spider_description">You can set a transparency level for the inactive filmstrip items which must be between 0 to 100..</div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="wds_nav_box wds_nav_timer_bar_box">
              <table>
                <tbody>
                  <tr>
                    <td class="spider_label"><label>Enable timer bar: </label></td>
                    <td>
                      <input type="radio" id="enable_time_bar1" name="enable_time_bar" <?php echo (($row->enable_time_bar) ? 'checked="checked"' : ''); ?> value="1" /><label for="time_bar1">Yes</label>
                      <input type="radio" id="enable_time_bar0" name="enable_time_bar" <?php echo (($row->enable_time_bar) ? '' : 'checked="checked"'); ?> value="0" /><label for="time_bar0">No</label>
                      <div class="spider_description">You can add a bar displaying the timing left to switching to the next slide on autoplay.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="timer_bar_type">Type: </label></td>
                    <td>
                      <select name="timer_bar_type" id="timer_bar_type">
                        <option value="top" <?php echo (($row->timer_bar_type == "top") ? 'selected="selected"' : ''); ?>>Line top</option>
                        <option value="bottom" <?php echo (($row->timer_bar_type == "bottom") ? 'selected="selected"' : ''); ?>>Line Bottom</option>
                        <option value="circle_top_left" <?php echo (($row->timer_bar_type == "circle_top_left") ? 'selected="selected"' : ''); ?>>Circle top left</option>
                        <option value="circle_top_right" <?php echo (($row->timer_bar_type == "circle_top_right") ? 'selected="selected"' : ''); ?>>Circle top right</option>
                        <option value="circle_bot_left" <?php echo (($row->timer_bar_type == "circle_bot_left") ? 'selected="selected"' : ''); ?>>Circle bottom left</option>
                        <option value="circle_bot_right" <?php echo (($row->timer_bar_type == "circle_bot_right") ? 'selected="selected"' : ''); ?>>Circle bottom right</option>
                      </select>
                      <div class="spider_description">Choose the type of the timer bar to be used within the slider.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="timer_bar_size">Size: </label></td>
                    <td>
                      <input type="text" name="timer_bar_size" id="timer_bar_size" value="<?php echo $row->timer_bar_size; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" /> px
                      <div class="spider_description">Define the height of the timer bar.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="timer_bar_color">Color: </label></td>
                    <td>
                      <input type="text" name="timer_bar_color" id="timer_bar_color" value="<?php echo $row->timer_bar_color; ?>" class="color" />
                      <input type="text" name="timer_bar_transparent" id="timer_bar_transparent" value="<?php echo $row->timer_bar_transparent; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)"/> %
                      <div class="spider_description">Transparency value must be between 0 to 100.</div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="wds_nav_box wds_nav_watermark_box">
              <div class="updated">
                <p>
                Please note that the <b>Fill</b> and <b>Contain</b> options will work fine with <b>Watermark</b> option regardless of the image dimensions, 
                whereas for the <b>Cover</b> option you should have the image identical to the size set in the <b>Dimensions</b> settings. 
                If you have uploaded the image with another dimension, you will need to resize the image and upload it again.
                </p>
              </div>
              <table>
                <tbody>
                  <tr>
                    <td style="width: 50%; vertical-align: top; height: 100%; display: table-cell;">
                      <table>
                        <tbody>
                          <tr id="tr_built_in_watermark_type">
                            <td class="spider_label_options">
                              <label>Watermark type: </label>
                            </td>
                            <td>
                              <input type="radio" name="built_in_watermark_type" id="built_in_watermark_type_none" value="none" <?php if ($row->built_in_watermark_type == 'none') echo 'checked="checked"'; ?> onClick="bwg_built_in_watermark('watermark_type_none')" />
                              <label for="built_in_watermark_type_none">None</label>
                              <input type="radio" name="built_in_watermark_type" id="built_in_watermark_type_text" value="text" <?php if ($row->built_in_watermark_type == 'text') echo 'checked="checked"'; ?> onClick="bwg_built_in_watermark('watermark_type_text')" onchange="preview_built_in_watermark()" />
                              <label for="built_in_watermark_type_text">Text</label>
                              <input type="radio" name="built_in_watermark_type" id="built_in_watermark_type_image" value="image" <?php if ($row->built_in_watermark_type == 'image') echo 'checked="checked"'; ?> onClick="bwg_built_in_watermark('watermark_type_image')" onchange="preview_built_in_watermark()" />
                              <label for="built_in_watermark_type_image">Image</label>
                              <div class="spider_description">Choose what kind of watermark you want to use.</div>
                            </td>
                          </tr>
                          <tr id="tr_built_in_watermark_url">
                            <td class="spider_label_options">
                              <label for="built_in_watermark_url">Watermark url: </label>
                            </td>
                            <td>
                              <input type="text" id="built_in_watermark_url" name="built_in_watermark_url" style="width: 68%;" value="<?php echo $row->built_in_watermark_url; ?>" style="display:inline-block;" onchange="preview_built_in_watermark()" />
                              <?php
                              if (!$row->spider_uploader) {
                                ?>
                              <input id="wat_img_add_butt" class="button-primary" type="button" onclick="spider_media_uploader('watermark', event); return false;" value="Add Image" />
                                <?php
                              }
                              else {
                                ?>
                              <a href="<?php echo add_query_arg(array('action' => 'addImage', 'width' => '700', 'height' => '550', 'extensions' => 'jpg,jpeg,png,gif', 'callback' => 'wds_add_image', 'image_for' => 'watermark', 'TB_iframe' => '1'), admin_url('admin-ajax.php')); ?>" class="button-primary thickbox thickbox-preview" title="Add Image" onclick="return false;">
                                Add Image
                              </a>
                                <?php
                              }
                              ?>
                              <div class="spider_description">Only .png format is supported.</div>
                            </td>
                          </tr>                    
                          <tr id="tr_built_in_watermark_text">
                            <td class="spider_label_options">
                              <label for="built_in_watermark_text">Watermark text: </label>
                            </td>
                            <td>
                              <input type="text" name="built_in_watermark_text" id="built_in_watermark_text" style="width: 100%;" value="<?php echo $row->built_in_watermark_text; ?>" onchange="preview_built_in_watermark()" onkeypress="preview_built_in_watermark()" />
                              <div class="spider_description">Provide the text which will be displayed over the slides.</div>
                            </td>
                          </tr>
                          <tr id="tr_built_in_watermark_size">
                            <td class="spider_label_options">
                              <label for="built_in_watermark_size">Watermark size: </label>
                            </td>
                            <td>
                              <input type="text" name="built_in_watermark_size" id="built_in_watermark_size" value="<?php echo $row->built_in_watermark_size; ?>" class="spider_int_input" onchange="preview_built_in_watermark()" /> %
                              <div class="spider_description">Enter size of watermark in percents according to image.</div>
                            </td>
                          </tr>
                          <tr id="tr_built_in_watermark_font_size">
                            <td class="spider_label_options">
                              <label for="built_in_watermark_font_size">Watermark font size: </label>
                            </td>
                            <td>
                              <input type="text" name="built_in_watermark_font_size" id="built_in_watermark_font_size" value="<?php echo $row->built_in_watermark_font_size; ?>" class="spider_int_input" onchange="preview_built_in_watermark()" onkeypress="return spider_check_isnum(event)" /> px
                              <div class="spider_description">Specify the font size of the watermark.</div>
                            </td>
                          </tr>
                            <tr id="tr_built_in_watermark_font">
                            <td class="spider_label_options">
                              <label for="built_in_watermark_font">Watermark font style: </label>
                            </td>
                            <td>
                            <select name="built_in_watermark_font" id="built_in_watermark_font" style="width:150px;" onchange="preview_built_in_watermark()">
                              <?php
                              foreach ($built_in_watermark_fonts as $watermark_font) {
                              ?>
                              <option value="<?php echo $watermark_font; ?>" <?php if ($row->built_in_watermark_font == $watermark_font) echo 'selected="selected"'; ?>><?php echo $watermark_font; ?></option>
                              <?php
                              }
                              ?>
                            </select>
                            <?php 
                              foreach ($built_in_watermark_fonts as $watermark_font) {
                              ?>
                              <style>
                              @font-face {
                                font-family: <?php echo 'bwg_' . str_replace('.ttf', '', $watermark_font); ?>;
                                src: url("<?php echo WD_S_URL . '/fonts/' . $watermark_font; ?>");
                               }
                              </style>
                              <?php
                              }
                            ?>
                            <div class="spider_description">Specify the font family for the watermark text.</div>
                            </td>
                          </tr>
                          <tr id="tr_built_in_watermark_color">
                            <td class="spider_label_options">
                              <label for="built_in_watermark_color">Watermark color: </label>
                            </td>
                            <td>
                              <input type="text" name="built_in_watermark_color" id="built_in_watermark_color" value="<?php echo $row->built_in_watermark_color; ?>" class="color" onchange="preview_built_in_watermark()" />
                              <input type="text" name="built_in_watermark_opacity" id="built_in_watermark_opacity" value="<?php echo $row->built_in_watermark_opacity; ?>" class="spider_int_input" onchange="preview_built_in_watermark()" /> %
                              <div class="spider_description">Transparency value must be between 0 to 100.</div>
                            </td>
                          </tr>
                          <tr id="tr_built_in_watermark_position">
                            <td class="spider_label_options">
                              <label>Watermark position: </label>
                            </td>
                            <td>
                              <table class="wds_position_table">
                                <tbody>
                                  <tr>
                                    <td class="wds_position_td"><input type="radio" value="top-left" name="built_in_watermark_position" <?php if ($row->built_in_watermark_position == "top-left") echo 'checked="checked"'; ?> onchange="preview_built_in_watermark()"></td>
                                    <td class="wds_position_td"><input type="radio" value="top-center" name="built_in_watermark_position" <?php if ($row->built_in_watermark_position == "top-center") echo 'checked="checked"'; ?> onchange="preview_built_in_watermark()"></td>
                                    <td class="wds_position_td"><input type="radio" value="top-right" name="built_in_watermark_position" <?php if ($row->built_in_watermark_position == "top-right") echo 'checked="checked"'; ?> onchange="preview_built_in_watermark()"></td>
                                  </tr>
                                  <tr>
                                    <td class="wds_position_td"><input type="radio" value="middle-left" name="built_in_watermark_position" <?php if ($row->built_in_watermark_position == "middle-left") echo 'checked="checked"'; ?> onchange="preview_built_in_watermark()"></td>
                                    <td class="wds_position_td"><input type="radio" value="middle-center" name="built_in_watermark_position" <?php if ($row->built_in_watermark_position == "middle-center") echo 'checked="checked"'; ?> onchange="preview_built_in_watermark()"></td>
                                    <td class="wds_position_td"><input type="radio" value="middle-right" name="built_in_watermark_position" <?php if ($row->built_in_watermark_position == "middle-right") echo 'checked="checked"'; ?> onchange="preview_built_in_watermark()"></td>
                                  </tr>
                                  <tr>
                                    <td class="wds_position_td"><input type="radio" value="bottom-left" name="built_in_watermark_position" <?php if ($row->built_in_watermark_position == "bottom-left") echo 'checked="checked"'; ?> onchange="preview_built_in_watermark()"></td>
                                    <td class="wds_position_td"><input type="radio" value="bottom-center" name="built_in_watermark_position" <?php if ($row->built_in_watermark_position == "bottom-center") echo 'checked="checked"'; ?> onchange="preview_built_in_watermark()"></td>
                                    <td class="wds_position_td"><input type="radio" value="bottom-right" name="built_in_watermark_position" <?php if ($row->built_in_watermark_position == "bottom-right") echo 'checked="checked"'; ?> onchange="preview_built_in_watermark()"></td>
                                  </tr>
                                </tbody>
                              </table>
                              <div class="spider_description">Choose the positioning of the watermark.</div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                    <td style="width: 50%; vertical-align: top;height: 100%; display: table-cell;">
                      <span id="preview_built_in_watermark" style='display:table-cell; background-image:url("<?php echo WD_S_URL . '/images/watermark_preview.jpg'?>"); background-size:100% 100%;width:400px;height:400px;padding-top: 4px; position:relative;'></span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="wds_nav_box wds_nav_css_box">
              <table style="width:50%">
                <tbody>
                  <tr>
                    <td class="spider_label"><label for="css">Css: </label></td> 
                  </tr> 
                  <tr>
                    <td style="width: 90%;">
                      <div class="spider_description">Add custom CSS to apply custom changes to the slider.</div>
                      <textarea id="css" name="css" rows="30" style="width: 100%;"><?php echo htmlspecialchars($row->css); ?></textarea>
                    </td>
                  </tr>   
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!--------------Slides tab----------->
        <div class="wds_box wds_slides_box">
          <table>
            <thead><tr><td colspan="4">&nbsp;</td></tr></thead>
            <tbody style="width: 98%; display: block;">
              <tr>
                <td class="spider_label"><label for="name">Slider name: <span style="color:#FF0000;">*</span> </label></td>
                <td><input type="text" id="name" name="name" value="<?php echo $row->name; ?>" size="39" /></td>
              </tr>
              <tr style="display: block;">
                <td colspan="4" style="display: block;">
                  <div class="wds_tabs wbs_subtab aui-sortable">
                    <?php
                    foreach ($slides_row as $key => $slide_row) {
                      ?>
                    <a id="wbs_subtab<?php echo $slide_row->id; ?>" class="connectedSortable <?php echo (((($id == 0 || !$sub_tab_type) || (strpos($sub_tab_type, 'pr') !== FALSE)) && $key == 0) || ('slide' . $slide_row->id == $sub_tab_type)) ? 'wds_sub_active' : ''; ?>" href="#">
                      <div class="handle" title="Drag to re-order"></div>
                      <input type="text" id="title<?php echo $slide_row->id; ?>" name="title<?php echo $slide_row->id; ?>" value="<?php echo $slide_row->title; ?>" class="wds_tab_title" tab_type="slide<?php echo $slide_row->id; ?>" onclick="wds_change_sub_tab(this, 'wds_slide<?php echo $slide_row->id; ?>')"/>
                      <span class="wds_slide_dublicate" onclick="wds_duplicate_slide('<?php echo $slide_row->id; ?>');" title="Duplicate slide"></span>					                   
                      <span class="wds_tab_remove" title="Delete slide" onclick="wds_remove_slide('<?php echo $slide_row->id; ?>')"></span>
                      <input type="hidden" name="order<?php echo $slide_row->id; ?>" id="order<?php echo $slide_row->id; ?>" value="<?php echo $slide_row->order; ?>" />
                    </a>
                      <?php
                    }
                    ?>
                    <a class="wds_add_layer" href="#" title="Add slide" onclick="wds_add_slide()">+</a>
                    <div class="wds_clear"></div>
                  </div>
                  <?php
                  foreach ($slides_row as $key => $slide_row) {
                    ?>
                  <div class="wds_box <?php echo (((($id == 0 || !$sub_tab_type) || (strpos($sub_tab_type, 'pr') !== FALSE)) && $key == 0) || ('slide' . $slide_row->id == $sub_tab_type)) ? 'wds_sub_active' : ''; ?> wds_slide<?php echo $slide_row->id; ?>">
                    <table class="ui-sortable<?php echo $slide_row->id; ?>">
                      <thead><tr><td colspan="4">&nbsp;</td></tr></thead>
                      <tbody>
                        <input type="hidden" name="type<?php echo $slide_row->id; ?>" id="type<?php echo $slide_row->id; ?>" value="<?php echo $slide_row->type; ?>" />
                        <tr>
                          <td colspan="4">
                            <?php
                            if (!$row->spider_uploader) {
                              ?>
                            <input type="button" class="button-primary" id="button_image_url<?php echo $slide_row->id; ?>" onclick="spider_media_uploader('<?php echo $slide_row->id; ?>', event); return false;" value="Add Image from Media Library" />
                              <?php
                            }
                            else {
                              ?>
                            <a href="<?php echo add_query_arg(array('action' => 'addImage', 'width' => '700', 'height' => '550', 'extensions' => 'jpg,jpeg,png,gif', 'callback' => 'wds_add_image', 'image_for' => 'add_update_slide', 'slide_id' => $slide_row->id, 'TB_iframe' => '1'), admin_url('admin-ajax.php')); ?>" class="button-primary thickbox thickbox-preview" title="Add Image" onclick="return false;">
                              Add Image
                            </a>
                              <?php
                            }
                            ?>
                            <input type="button" class="button-primary" onclick="wds_add_image_url('<?php echo $slide_row->id; ?>')" value="Add Image by URL" />
                            <input type="button" class="button-secondary wds_free_button" onclick="alert('This functionality is disabled in free version.')" value="Add Video" />
			    <input class="button-secondary wds_free_button" type="button" value="Add Post" onclick="alert('This functionality is disabled in free version.')" />
                            <input type="button" class="button-secondary" id="delete_image_url<?php echo $slide_row->id; ?>" onclick="spider_remove_url('image_url<?php echo $slide_row->id; ?>', 'wds_preview_image<?php echo $slide_row->id; ?>')" value="Remove" />
                            <input type="hidden" id="image_url<?php echo $slide_row->id; ?>" name="image_url<?php echo $slide_row->id; ?>" value="<?php echo $slide_row->image_url; ?>" />
                            <input type="hidden" id="thumb_url<?php echo $slide_row->id; ?>" name="thumb_url<?php echo $slide_row->id; ?>" value="<?php echo $slide_row->thumb_url; ?>" />
                          </td>
                        </tr>
                        <tr>
                          <td colspan="4">
                            <div id="wds_preview_wrapper_<?php echo $slide_row->id; ?>" class="wds_preview_wrapper" style="width: <?php echo $row->width; ?>px; height: <?php echo $row->height; ?>px;">
                              <div class="wds_preview" style="overflow: hidden; position: absolute; width: inherit; height: inherit; background-color: transparent; background-image: none; display: block;">
                                <div id="wds_preview_image<?php echo $slide_row->id; ?>" class="wds_preview_image<?php echo $slide_row->id; ?>"
                                     style='background-color: <?php echo WDW_S_Library::spider_hex2rgba($row->background_color, (100 - $row->background_transparent) / 100); ?>;
                                            background-image: url("<?php echo $slide_row->type != 'image'  ? $slide_row->thumb_url : $slide_row->image_url . '?date=' . date('Y-m-d H:i:s'); ?>");
                                            background-position: center center;
                                            background-repeat: no-repeat;
                                            background-size: <?php echo $row->bg_fit; ?>;
                                            width: inherit;
                                            height: inherit;
                                            /*position: relative;*/'>
                                <?php
                                $layers_row = $this->model->get_layers_row_data($slide_row->id);
                                if ($layers_row) {
                                  foreach ($layers_row as $key => $layer) {
                                    $prefix = 'slide' . $slide_row->id . '_layer' . $layer->id;
                                    switch ($layer->type) {
                                      case 'text': {
                                        ?>
                                        <span id="<?php echo $prefix; ?>" class="wds_draggable_<?php echo $slide_row->id; ?> wds_draggable ui-draggable" onclick="wds_showhide_layer('<?php echo $prefix; ?>_tbody', 1)"
                                              style="<?php echo $layer->image_width ? 'width: ' . $layer->image_width . '%; ' : ''; ?><?php echo $layer->image_height ? 'height: ' . $layer->image_height . '%; ' : ''; ?>word-break: <?php echo ($layer->image_scale ? 'keep-all' : 'break-all'); ?>; display: inline-block; position: absolute; left: <?php echo $layer->left; ?>px; top: <?php echo $layer->top; ?>px; z-index: <?php echo $layer->depth; ?>; color: #<?php echo $layer->color; ?>; font-size: <?php echo $layer->size; ?>px; line-height: 1.25em; font-family: <?php echo $layer->ffamily; ?>; font-weight: <?php echo $layer->fweight; ?>; padding: <?php echo $layer->padding; ?>; background-color: <?php echo WDW_S_Library::spider_hex2rgba($layer->fbgcolor, (100 - $layer->transparent) / 100); ?>; border: <?php echo $layer->border_width; ?>px <?php echo $layer->border_style; ?> #<?php echo $layer->border_color; ?>; border-radius: <?php echo $layer->border_radius; ?>; box-shadow: <?php echo $layer->shadow; ?>"><?php echo str_replace(array("\r\n", "\r", "\n"), "<br>", $layer->text); ?></span>
                                        <?php
                                        break;
                                      }
                                      case 'image': {
                                        ?>
                                        <img id="<?php echo $prefix; ?>" class="wds_draggable_<?php echo $slide_row->id; ?> wds_draggable ui-draggable" onclick="wds_showhide_layer('<?php echo $prefix; ?>_tbody', 1)" src="<?php echo $layer->image_url; ?>"
                                             style="opacity: <?php echo (100 - $layer->imgtransparent) / 100; ?>; filter: Alpha(opacity=<?php echo 100 - $layer->imgtransparent; ?>); position: absolute; left: <?php echo $layer->left; ?>px; top: <?php echo $layer->top; ?>px; z-index: <?php echo $layer->depth; ?>; border: <?php echo $layer->border_width; ?>px <?php echo $layer->border_style; ?> #<?php echo $layer->border_color; ?>; border-radius: <?php echo $layer->border_radius; ?>; box-shadow: <?php echo $layer->shadow; ?>; " />
                                        <?php
                                        break;
                                      }
                                      case 'video': {
                                        ?>
                                        <img id="<?php echo $prefix; ?>" class="wds_draggable_<?php echo $slide_row->id; ?> wds_draggable ui-draggable" onclick="wds_showhide_layer('<?php echo $prefix; ?>_tbody', 1)" src="<?php echo $layer->image_url; ?>"
                                             style="max-width: <?php echo $layer->image_width; ?>px; width: <?php echo $layer->image_width; ?>px; max-height: <?php echo $layer->image_height; ?>px; height: <?php echo $layer->image_height; ?>px; position: absolute; left: <?php echo $layer->left; ?>px; top: <?php echo $layer->top; ?>px; z-index: <?php echo $layer->depth; ?>; border: <?php echo $layer->border_width; ?>px <?php echo $layer->border_style; ?> #<?php echo $layer->border_color; ?>; border-radius: <?php echo $layer->border_radius; ?>; box-shadow: <?php echo $layer->shadow; ?>;" />
                                        <?php
                                        break;
                                      }
                                      case 'social': {
                                        ?>
                                        <style>#<?php echo $prefix; ?>:hover {color: #<?php echo $layer->hover_color; ?> !important;}</style>
                                        <i id="<?php echo $prefix; ?>" class="wds_draggable_<?php echo $slide_row->id; ?> wds_draggable fa fa-<?php echo $layer->social_button; ?> ui-draggable" onclick="wds_showhide_layer('<?php echo $prefix; ?>_tbody', 1)"
                                           style="opacity: <?php echo (100 - $layer->transparent) / 100; ?>; filter: Alpha(opacity=<?php echo 100 - $layer->transparent; ?>); position: absolute; left: <?php echo $layer->left; ?>px; top: <?php echo $layer->top; ?>px; z-index: <?php echo $layer->depth; ?>; color: #<?php echo $layer->color; ?>; font-size: <?php echo $layer->size; ?>px; line-height: <?php echo $layer->size; ?>px; padding: <?php echo $layer->padding; ?>; "></i>
                                        <?php
                                        break;
                                      }
                                      default:
                                        break;
                                    }
                                  }
                                }
                                ?>
                                </div>
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td class="spider_label"><label>Published: </label></td>
                          <td>
                            <input type="radio" id="published<?php echo $slide_row->id; ?>1" name="published<?php echo $slide_row->id; ?>" <?php echo (($slide_row->published) ? 'checked="checked"' : ''); ?> value="1" /><label for="published<?php echo $slide_row->id; ?>1">Yes</label>
                            <input type="radio" id="published<?php echo $slide_row->id; ?>0" name="published<?php echo $slide_row->id; ?>" <?php echo (($slide_row->published) ? '' : 'checked="checked"'); ?> value="0" /><label for="published<?php echo $slide_row->id; ?>0">No</label>
                          </td>
                        </tr>
                        <tr id="trlink<?php echo $slide_row->id; ?>" <?php echo $slide_row->type == 'image' ? '' : 'style="display: none;"'; ?>>
                          <td class="spider_label">
                            <label for="link<?php echo $slide_row->id; ?>">Link the slide to: </label>
                          </td>
                          <td>
                            <input id="link<?php echo $slide_row->id; ?>" type="text" size="39" value="<?php echo $slide_row->link; ?>" name="link<?php echo $slide_row->id; ?>" />
                            <input id="target_attr_slide<?php echo $slide_row->id; ?>" type="checkbox"  name="target_attr_slide<?php echo $slide_row->id; ?>" <?php echo (($slide_row->target_attr_slide) ? 'checked="checked"' : ''); ?> value="1" /><label for="target_attr_slide<?php echo $slide_row->id; ?>"> Open in a new window</label>
                            <div class="spider_description">You can set a redirection link, so that the user will get to the mentioned location upon hitting the slide.<br />Use http:// and https:// for external links.</div>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="4">
                            <input type="button" class="button-<?php echo !$fv ? "primary" : "secondary wds_free_button"; ?> button button-small" onclick="<?php echo !$fv ? "wds_add_layer('text', '" . $slide_row->id . "')" : "alert('This functionality is disabled in free version.')"; ?>; return false;" value="Add Text Layer" />
                            <?php
                            if (!$row->spider_uploader) {
                              ?>
                            <input type="button" class="button-<?php echo !$fv ? "primary" : "secondary wds_free_button"; ?> button button-small" onclick="<?php echo !$fv ? "wds_add_layer('image', '" . $slide_row->id . "', '', event)" : "alert('This functionality is disabled in free version.')"; ?>; return false;" value="Add Image Layer" />
                              <?php
                            }
                            else {
                              ?>
                            <a href="<?php echo !$fv ? add_query_arg(array('action' => 'addImage', 'width' => '700', 'height' => '550', 'extensions' => 'jpg,jpeg,png,gif', 'callback' => 'wds_add_image', 'image_for' => 'add_layer', 'slide_id' => $slide_row->id, 'TB_iframe' => '1'), admin_url('admin-ajax.php')) : ''; ?>" onclick="<?php echo !$fv ? '' : "alert('This functionality is disabled in free version.')"; ?>; return false;" class="button-<?php echo !$fv ? "primary thickbox thickbox-preview" : "secondary wds_free_button"; ?> button button-small" title="Add Image Layer">
                              Add Image layer
                            </a>
                              <?php
                            }
                            ?>
                            <input type="button" class="button-secondary button button-small wds_free_button" onclick="alert('This functionality is disabled in free version.'); return false;" value="Add Video Layer" />
                            <input type="button" class="button-secondary button button-small wds_free_button" onclick="alert('This functionality is disabled in free version.'); return false;" value="Add Social Button Layer" />
                          </td>
                        </tr>
                      </tbody>
                      <?php
                      $layer_ids_string = '';
                      if ($layers_row) {
                        foreach ($layers_row as $key => $layer) {
                          $prefix = 'slide' . $slide_row->id . '_layer' . $layer->id;
                          ?>
                          <tbody id="<?php echo $prefix; ?>_tbody">
                            <tr class="wds_layer_head_tr">
                              <td class="wds_layer_head" colspan="4">
                                <div class="handle connectedSortable" title="Drag to re-order"></div>
                                <span class="wds_layer_label" onclick="wds_showhide_layer('<?php echo $prefix; ?>_tbody', 0)"><input id="<?php echo $prefix; ?>_title" name="<?php echo $prefix; ?>_title" type="text" class="wds_layer_title" style="width: 80px;" value="<?php echo $layer->title; ?>" title="Layer title" /></span>
                                <span class="wds_layer_remove" onclick="wds_delete_layer('<?php echo $slide_row->id; ?>', '<?php echo $layer->id; ?>')" title="Delete layer"></span>
                                <span class="wds_layer_dublicate" onclick="wds_add_layer('<?php echo $layer->type; ?>', '<?php echo $slide_row->id; ?>', '', 1, 0); wds_duplicate_layer('<?php echo $layer->type; ?>', '<?php echo $slide_row->id; ?>', '<?php echo $layer->id; ?>');" title="Duplicate layer"></span>
                                <input id="<?php echo $prefix; ?>_depth" class="wds_layer_depth spider_int_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({zIndex: jQuery(this).val()})" onkeypress="return spider_check_isnum(event)" value="<?php echo $layer->depth; ?>" prefix="<?php echo $prefix; ?>" name="<?php echo $prefix; ?>_depth" title="z-index" />
                              </td>
                            </tr>
                            <?php
                            switch ($layer->type) {
                              /*--------text layer----------*/
                              case 'text': {
                                ?>
                            <tr class="wds_layer_tr" style="display: none;">
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_text">Text: </label>
                              </td>
                              <td>
                                <textarea id="<?php echo $prefix; ?>_text" name="<?php echo $prefix; ?>_text" style="width: 222px; height: 60px; resize: vertical;" onkeyup="wds_new_line('<?php echo $prefix; ?>');"><?php echo $layer->text; ?></textarea>
                                <div class="spider_description"></div>
                              </td>							  
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_layer_effect_in">Effect In:</label>
                              </td>
                              <td>
                                <span style="display: table-cell;">
                                  <input id="<?php echo $prefix; ?>_start" class="spider_int_input" type="text" value="<?php echo $layer->start; ?>" name="<?php echo $prefix; ?>_start" /> ms 
                                  <div class="spider_description">Start</div>
                                </span>
                                <span style="display: table-cell;">
                                  <select name="<?php echo $prefix; ?>_layer_effect_in" id="<?php echo $prefix; ?>_layer_effect_in" style="width:150px;" onchange="wds_trans_effect_in('<?php echo $slide_row->id; ?>', '<?php echo $prefix; ?>', 0); wds_trans_end('<?php echo $prefix; ?>', jQuery(this).val());">
                                  <?php
                                  foreach ($layer_effects_in as $key => $layer_effect_in) {
                                    ?>
                                    <option value="<?php echo $key; ?>" <?php echo (!in_array($key, $free_layer_effects)) ? 'disabled="disabled" title="This effect is disabled in free version."' : ''; ?> <?php if ($layer->layer_effect_in == $key) echo 'selected="selected"'; ?>><?php echo $layer_effect_in; ?></option>
                                    <?php
                                  }
                                  ?>
                                  </select>
                                  <div class="spider_description">Effect</div>
                                </span>
                                <span style="display: table-cell;">
                                  <input id="<?php echo $prefix; ?>_duration_eff_in" class="spider_int_input" type="text" onkeypress="return spider_check_isnum(event)" onchange="wds_trans_effect_in('<?php echo $slide_row->id; ?>', '<?php echo $prefix; ?>', 0); wds_trans_end('<?php echo $prefix; ?>', jQuery('#<?php echo $prefix; ?>_layer_effect_in').val());" value="<?php echo $layer->duration_eff_in; ?>" name="<?php echo $prefix; ?>_duration_eff_in" /> ms
                                  <div class="spider_description">Duration</div>
                                </span>
                                <div class="spider_description spider_free_version">Some effects are disabled in free version.</div>
                              </td>
                            </tr>							
                            <tr class="wds_layer_tr" style="display: none;">
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_image_width">Dimensions: </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_image_width" class="spider_int_input" type="text" onchange="wds_text_width(this,'<?php echo $prefix; ?>')" value="<?php echo $layer->image_width; ?>" name="<?php echo $prefix; ?>_image_width" /> x 
                                <input id="<?php echo $prefix; ?>_image_height" class="spider_int_input" type="text" onchange="wds_text_height(this,'<?php echo $prefix; ?>')" value="<?php echo $layer->image_height; ?>" name="<?php echo $prefix; ?>_image_height" /> % 
                                <input id="<?php echo $prefix; ?>_image_scale" type="checkbox" onchange="wds_break_word(this, '<?php echo $prefix; ?>')" name="<?php echo $prefix; ?>_image_scale" <?php echo (($layer->image_scale) ? 'checked="checked"' : ''); ?> /><label for="<?php echo $prefix; ?>_image_scale">Break-word</label>
                                <div class="spider_description">Leave blank to keep the initial width and height.</div>
                              </td>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_layer_effect_out">Effect Out:</label>
                              </td>
                              <td>
                                <span style="display: table-cell;">
                                  <input id="<?php echo $prefix; ?>_end" class="spider_int_input" type="text" value="<?php echo $layer->end; ?>" name="<?php echo $prefix; ?>_end"> ms
                                  <div class="spider_description">Start</div>
                                </span> 
                                <span style="display: table-cell;">
                                  <select name="<?php echo $prefix; ?>_layer_effect_out" id="<?php echo $prefix; ?>_layer_effect_out" style="width:150px;" onchange="wds_trans_effect_out('<?php echo $slide_row->id; ?>', '<?php echo $prefix; ?>', 0); wds_trans_end('<?php echo $prefix; ?>', jQuery(this).val());">
                                  <?php
                                  foreach ($layer_effects_out as $key => $layer_effect_out) {
                                    ?>
                                    <option value="<?php echo $key; ?>" <?php echo (!in_array($key, $free_layer_effects)) ? 'disabled="disabled" title="This effect is disabled in free version."' : ''; ?> <?php if ($layer->layer_effect_out == $key) echo 'selected="selected"'; ?>><?php echo $layer_effect_out; ?></option>
                                    <?php
                                  }
                                  ?>
                                  </select>
                                  <div class="spider_description">Effect</div>
                                </span> 
                                <span style="display: table-cell;">
                                  <input id="<?php echo $prefix; ?>_duration_eff_out" class="spider_int_input" type="text" onkeypress="return spider_check_isnum(event)" onchange="wds_trans_effect_out('<?php echo $slide_row->id; ?>', '<?php echo $prefix; ?>', 0); wds_trans_end('<?php echo $prefix; ?>', jQuery('#<?php echo $prefix; ?>_layer_effect_out').val());" value="<?php echo $layer->duration_eff_out; ?>" name="<?php echo $prefix; ?>_duration_eff_out"> ms
                                  <div class="spider_description">Duration</div>
                                </span>
                                <div class="spider_description spider_free_version">Some effects are disabled in free version.</div>
                              </td>
                            </tr>
                            <tr class="wds_layer_tr" style="display: none;">
                              <td class="spider_label">
                                <label>Position: </label>
                              </td>
                              <td>
                                X <input id="<?php echo $prefix; ?>_left" class="spider_int_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({left: jQuery(this).val() + 'px'})" onkeypress="return spider_check_isnum(event)" value="<?php echo $layer->left; ?>" name="<?php echo $prefix; ?>_left" />
                                Y <input id="<?php echo $prefix; ?>_top" class="spider_int_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({top: jQuery(this).val() + 'px'})" onkeypress="return spider_check_isnum(event)" value="<?php echo $layer->top; ?>" name="<?php echo $prefix; ?>_top" />
                                <div class="spider_description">In addition you can drag and drop the layer to a desired position.</div>
                              </td> 
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_padding">Padding: </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_padding" class="spider_char_input" type="text" onchange="document.getElementById('<?php echo $prefix; ?>').style.padding=jQuery(this).val();" value="<?php echo $layer->padding; ?>" name="<?php echo $prefix; ?>_padding">
                                <div class="spider_description">Use CSS type values.</div>
                              </td>                              
                            </tr>		
                            <tr class="wds_layer_tr" style="display: none;">                             
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_size">Size: </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_size" class="spider_int_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({fontSize: jQuery(this).val() + 'px', lineHeight: jQuery(this).val() + 'px'})" onkeypress="return spider_check_isnum(event)" value="<?php echo $layer->size; ?>" name="<?php echo $prefix; ?>_size" /> px
                                <div class="spider_description"></div>
                              </td>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_fbgcolor">Background Color: </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_fbgcolor" class="color" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({backgroundColor: wds_hex_rgba(jQuery(this).val(), 100 - jQuery('#<?php echo $prefix; ?>_transparent').val())})" value="<?php echo $layer->fbgcolor; ?>" name="<?php echo $prefix; ?>_fbgcolor" />
                                <div class="spider_description"></div>
                              </td>
                            </tr>
                            <tr class="wds_layer_tr" style="display: none;">
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_color">Color: </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_color" class="color" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({color: '#' + jQuery(this).val()})" value="<?php echo $layer->color; ?>" name="<?php echo $prefix; ?>_color" />
                                <div class="spider_description"></div>
                              </td>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_transparent">Transparent: </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_transparent" class="spider_int_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({backgroundColor: wds_hex_rgba(jQuery('#<?php echo $prefix; ?>_fbgcolor').val(), 100 - jQuery(this).val())})" onkeypress="return spider_check_isnum(event)" value="<?php echo $layer->transparent; ?>" name="<?php echo $prefix; ?>_transparent"> %
                                <div class="spider_description">Value must be between 0 to 100.</div>
                              </td>
                            </tr>
                            <tr class="wds_layer_tr" style="display: none;">
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_ffamily">Font family: </label>
                              </td>
                              <td>
                                <select id="<?php echo $prefix; ?>_ffamily" onchange="jQuery('#<?php echo $prefix; ?>').css({fontFamily: jQuery(this).val()})" name="<?php echo $prefix; ?>_ffamily">
                                  <?php
                                  foreach ($font_families as $key => $font_family) {
                                    ?>
                                    <option value="<?php echo $key; ?>" <?php echo (($layer->ffamily == $key) ? 'selected="selected"' : ''); ?>><?php echo $font_family; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                                <div class="spider_description"></div>
                              </td>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_border_width">Border: </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_border_width" class="spider_int_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({borderWidth: jQuery(this).val()})" onkeypress="return spider_check_isnum(event)" value="<?php echo $layer->border_width; ?>" name="<?php echo $prefix; ?>_border_width"> px
                                <select id="<?php echo $prefix; ?>_border_style" onchange="jQuery('#<?php echo $prefix; ?>').css({borderStyle: jQuery(this).val()})" style="width: 80px;" name="<?php echo $prefix; ?>_border_style">
                                  <?php
                                  foreach ($border_styles as $key => $border_style) {
                                    ?>
                                    <option value="<?php echo $key; ?>" <?php echo (($layer->border_style == $key) ? 'selected="selected"' : ''); ?>><?php echo $border_style; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                                <input id="<?php echo $prefix; ?>_border_color" class="color" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({borderColor: '#' + jQuery(this).val()})" value="<?php echo $layer->border_color; ?>" name="<?php echo $prefix; ?>_border_color" />
                                <div class="spider_description"></div>
                              </td>
                            </tr>
                            <tr class="wds_layer_tr" style="display: none;">
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_fweight">Font weight: </label>
                              </td>
                              <td>
                                <select id="<?php echo $prefix; ?>_fweight" onchange="jQuery('#<?php echo $prefix; ?>').css({fontWeight: jQuery(this).val()})" name="<?php echo $prefix; ?>_fweight">
                                  <?php
                                  foreach ($font_weights as $key => $fweight) {
                                    ?>
                                    <option value="<?php echo $key; ?>" <?php echo (($layer->fweight == $key) ? 'selected="selected"' : ''); ?>><?php echo $fweight; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                                <div class="spider_description"></div>
                              </td>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_border_radius">Radius: </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_border_radius" class="spider_char_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({borderRadius: jQuery(this).val()})" value="<?php echo $layer->border_radius; ?>" name="<?php echo $prefix; ?>_border_radius">
                                <div class="spider_description">Use CSS type values.</div>
                              </td>
                            </tr>
                            <tr class="wds_layer_tr" style="display: none;">
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_link">Link: </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_link" type="text" size="39" value="<?php echo $layer->link; ?>" name="<?php echo $prefix; ?>_link" />
                                <input id="<?php echo $prefix; ?>_target_attr_layer" type="checkbox"  name="<?php echo $prefix; ?>_target_attr_layer" <?php echo (($layer->target_attr_layer) ? 'checked="checked"' : ''); ?> value="1" /><label for="<?php echo $prefix; ?>_target_attr_layer"> Open in a new window</label>
                                <div class="spider_description">Use http:// and https:// for external links.</div>
                              </td>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_shadow">Shadow: </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_shadow" class="spider_char_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({boxShadow: jQuery(this).val()})" value="<?php echo $layer->shadow; ?>" name="<?php echo $prefix; ?>_shadow" />
                                <div class="spider_description">Use CSS type values (e.g. 10px 10px 5px #888888).</div>
                              </td>
                            </tr>
                            <tr class="wds_layer_tr" style="display: none;">
                              <td class="spider_label">
                                <label>Published: </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_published1" type="radio" name="<?php echo $prefix; ?>_published" value="1" <?php echo (($layer->published) ? 'checked="checked"' : ''); ?> />
                                <label for="<?php echo $prefix; ?>_published1">Yes</label>
                                <input id="<?php echo $prefix; ?>_published0" type="radio" name="<?php echo $prefix; ?>_published" value="0" <?php echo (($layer->published) ? '' : 'checked="checked"'); ?> />
                                <label for="<?php echo $prefix; ?>_published0">No</label>
                                <div class="spider_description"></div>
                              </td>
                            </tr>
                                <?php
                                break;
                              }
                              /*--------image layer----------*/
                              case 'image': {
                                ?>
                            <tr class="wds_layer_tr" style="display: none;">
                              <td class="spider_label">
                                <label>Dimensions: </label>
                              </td>
                              <td>
                                <input type="hidden" name="<?php echo $prefix; ?>_image_url" id="<?php echo $prefix; ?>_image_url" value="<?php echo $layer->image_url; ?>" />
                                <input id="<?php echo $prefix; ?>_image_width" class="spider_int_input" type="text" onkeyup="wds_scale('#<?php echo $prefix; ?>_image_scale', '<?php echo $prefix; ?>')" value="<?php echo $layer->image_width; ?>" name="<?php echo $prefix; ?>_image_width" /> x 
                                <input id="<?php echo $prefix; ?>_image_height" class="spider_int_input" type="text" onkeyup="wds_scale('#<?php echo $prefix; ?>_image_scale', '<?php echo $prefix; ?>')" value="<?php echo $layer->image_height; ?>" name="<?php echo $prefix; ?>_image_height" /> px 
                                <input id="<?php echo $prefix; ?>_image_scale" type="checkbox" onchange="wds_scale(this, '<?php echo $prefix; ?>')" name="<?php echo $prefix; ?>_image_scale" <?php echo (($layer->image_scale) ? 'checked="checked"' : ''); ?> /><label for="<?php echo $prefix; ?>_image_scale">Scale</label>
                                <input class="button-secondary wds_free_button" type="button" value="Edit Image" onclick="alert('This functionality is disabled in free version.')" />
                                <div class="spider_description">Set width and height of the image.</div>
                              </td>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_layer_effect_in">Effect In:</label>
                              </td>
                              <td>
                                <span style="display: table-cell;">
                                  <input id="<?php echo $prefix; ?>_start" class="spider_int_input" type="text" value="<?php echo $layer->start; ?>" name="<?php echo $prefix; ?>_start" /> ms 
                                  <div class="spider_description">Start</div>
                                </span>
                                <span style="display: table-cell;">
                                  <select name="<?php echo $prefix; ?>_layer_effect_in" id="<?php echo $prefix; ?>_layer_effect_in" style="width:150px;" onchange="wds_trans_effect_in('<?php echo $slide_row->id; ?>', '<?php echo $prefix; ?>', 0); wds_trans_end('<?php echo $prefix; ?>', jQuery(this).val());">
                                  <?php
                                  foreach ($layer_effects_in as $key => $layer_effect_in) {
                                    ?>
                                    <option value="<?php echo $key; ?>" <?php echo (!in_array($key, $free_layer_effects)) ? 'disabled="disabled" title="This effect is disabled in free version."' : ''; ?> <?php if ($layer->layer_effect_in == $key) echo 'selected="selected"'; ?>><?php echo $layer_effect_in; ?></option>
                                    <?php
                                  }
                                  ?>
                                  </select>
                                  <div class="spider_description">Effect</div>
                                </span>
                                <span style="display: table-cell;">
                                  <input id="<?php echo $prefix; ?>_duration_eff_in" class="spider_int_input" type="text" onkeypress="return spider_check_isnum(event)" onchange="wds_trans_effect_in('<?php echo $slide_row->id; ?>', '<?php echo $prefix; ?>', 0); wds_trans_end('<?php echo $prefix; ?>', jQuery('#<?php echo $prefix; ?>_layer_effect_in').val());" value="<?php echo $layer->duration_eff_in; ?>" name="<?php echo $prefix; ?>_duration_eff_in" /> ms
                                  <div class="spider_description">Duration</div>
                                </span>
                                <div class="spider_description spider_free_version">Some effects are disabled in free version.</div>
                              </td>
                            </tr>
                            <tr class="wds_layer_tr" style="display: none;">
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_alt">Alt: </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_alt" type="text" size="39" value="<?php echo $layer->alt; ?>" name="<?php echo $prefix; ?>_alt" />
                                <div class="spider_description">Set the HTML attribute specified in the IMG tag.</div>
                              </td>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_layer_effect_out">Effect Out:</label>
                              </td>
                              <td>
                                <span style="display: table-cell;">
                                  <input id="<?php echo $prefix; ?>_end" class="spider_int_input" type="text" value="<?php echo $layer->end; ?>" name="<?php echo $prefix; ?>_end"> ms
                                  <div class="spider_description">Start</div>
                                </span> 
                                <span style="display: table-cell;">
                                  <select name="<?php echo $prefix; ?>_layer_effect_out" id="<?php echo $prefix; ?>_layer_effect_out" style="width:150px;" onchange="wds_trans_effect_out('<?php echo $slide_row->id; ?>', '<?php echo $prefix; ?>', 0); wds_trans_end('<?php echo $prefix; ?>', jQuery(this).val());">
                                  <?php
                                  foreach ($layer_effects_out as $key => $layer_effect_out) {
                                    ?>
                                    <option value="<?php echo $key; ?>" <?php echo (!in_array($key, $free_layer_effects)) ? 'disabled="disabled" title="This effect is disabled in free version."' : ''; ?> <?php if ($layer->layer_effect_out == $key) echo 'selected="selected"'; ?>><?php echo $layer_effect_out; ?></option>
                                    <?php
                                  }
                                  ?>
                                  </select>
                                  <div class="spider_description">Effect</div>
                                </span> 
                                <span style="display: table-cell;">
                                  <input id="<?php echo $prefix; ?>_duration_eff_out" class="spider_int_input" type="text" onkeypress="return spider_check_isnum(event)" onchange="wds_trans_effect_out('<?php echo $slide_row->id; ?>', '<?php echo $prefix; ?>', 0); wds_trans_end('<?php echo $prefix; ?>', jQuery('#<?php echo $prefix; ?>_layer_effect_out').val());" value="<?php echo $layer->duration_eff_out; ?>" name="<?php echo $prefix; ?>_duration_eff_out"> ms
                                  <div class="spider_description">Duration</div>
                                </span>
                                <div class="spider_description spider_free_version">Some effects are disabled in free version.</div>
                              </td>
                            </tr>
                            <tr class="wds_layer_tr" style="display: none;">
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_link">Link: </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_link" type="text" size="39" value="<?php echo $layer->link; ?>" name="<?php echo $prefix; ?>_link" />
                                <input id="<?php echo $prefix; ?>_target_attr_layer" type="checkbox"  name="<?php echo $prefix; ?>_target_attr_layer" <?php echo (($layer->target_attr_layer) ? 'checked="checked"' : ''); ?> value="1" /><label for="<?php echo $prefix; ?>_target_attr_layer"> Open in a new window</label>
                                <div class="spider_description">Use http:// and https:// for external links.</div>
                              </td>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_border_width">Border: </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_border_width" class="spider_int_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({borderWidth: jQuery(this).val()})" onkeypress="return spider_check_isnum(event)" value="<?php echo $layer->border_width; ?>" name="<?php echo $prefix; ?>_border_width"> px
                                <select id="<?php echo $prefix; ?>_border_style" onchange="jQuery('#<?php echo $prefix; ?>').css({borderStyle: jQuery(this).val()})" style="width: 80px;" name="<?php echo $prefix; ?>_border_style">
                                  <?php
                                  foreach ($border_styles as $key => $border_style) {
                                    ?>
                                    <option value="<?php echo $key; ?>" <?php echo (($layer->border_style == $key) ? 'selected="selected"' : ''); ?>><?php echo $border_style; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                                <input id="<?php echo $prefix; ?>_border_color" class="color" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({borderColor: '#' + jQuery(this).val()})" value="<?php echo $layer->border_color; ?>" name="<?php echo $prefix; ?>_border_color" />
                                <div class="spider_description"></div>
                              </td>
                            </tr>
                            <tr class="wds_layer_tr" style="display: none;">
                              <td class="spider_label">
                                <label>Position: </label>
                              </td>
                              <td>
                                X <input id="<?php echo $prefix; ?>_left" class="spider_int_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({left: jQuery(this).val() + 'px'})" onkeypress="return spider_check_isnum(event)" value="<?php echo $layer->left; ?>" name="<?php echo $prefix; ?>_left" />
                                Y <input id="<?php echo $prefix; ?>_top" class="spider_int_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({top: jQuery(this).val() + 'px'})" onkeypress="return spider_check_isnum(event)" value="<?php echo $layer->top; ?>" name="<?php echo $prefix; ?>_top" />
                                <div class="spider_description">In addition you can drag and drop the layer to a desired position.</div>
                              </td>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_border_radius">Radius: </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_border_radius" class="spider_char_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({borderRadius: jQuery(this).val()})" value="<?php echo $layer->border_radius; ?>" name="<?php echo $prefix; ?>_border_radius">
                                <div class="spider_description">Use CSS type values.</div>
                              </td>
                            </tr>
                            <tr class="wds_layer_tr" style="display: none;">
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_imgtransparent">Transparent: </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_imgtransparent" class="spider_int_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({opacity: (100 - jQuery(this).val()) / 100, filter: 'Alpha(opacity=' + 100 - jQuery(this).val() + ')'})" onkeypress="return spider_check_isnum(event)" value="<?php echo $layer->imgtransparent; ?>" name="<?php echo $prefix; ?>_imgtransparent"> %
                                <div class="spider_description">Value must be between 0 to 100.</div>
                              </td>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_shadow">Shadow: </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_shadow" class="spider_char_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({boxShadow: jQuery(this).val()})" value="<?php echo $layer->shadow; ?>" name="<?php echo $prefix; ?>_shadow" />
                                <div class="spider_description">Use CSS type values.</div>
                              </td>
                            </tr>
                            <tr class="wds_layer_tr" style="display: none;">
                              <td class="spider_label">
                                <label>Published: </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_published1" type="radio" name="<?php echo $prefix; ?>_published" value="1" <?php echo (($layer->published) ? 'checked="checked"' : ''); ?> />
                                <label for="<?php echo $prefix; ?>_published1">Yes</label>
                                <input id="<?php echo $prefix; ?>_published0" type="radio" name="<?php echo $prefix; ?>_published" value="0" <?php echo (($layer->published) ? '' : 'checked="checked"'); ?>/>
                                <label for="<?php echo $prefix; ?>_published0">No</label>
                                <div class="spider_description"></div>
                              </td>
                            </tr>
                            <?php
                                break;
                              }
                              /*--------social button layer----------*/
                              case 'social': {
                                ?>
                            <tr class="wds_layer_tr" style="display: none;">
                              <td class="spider_label">
                                <label>Position: </label>
                              </td>
                              <td>
                                X <input id="<?php echo $prefix; ?>_left" class="spider_int_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({left: jQuery(this).val() + 'px'})" onkeypress="return spider_check_isnum(event)" value="<?php echo $layer->left; ?>" name="<?php echo $prefix; ?>_left" />
                                Y <input id="<?php echo $prefix; ?>_top" class="spider_int_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({top: jQuery(this).val() + 'px'})" onkeypress="return spider_check_isnum(event)" value="<?php echo $layer->top; ?>" name="<?php echo $prefix; ?>_top" />
                                <div class="spider_description">In addition you can drag and drop the layer to a desired position.</div>
                              </td>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_layer_effect_in">Effect In:</label>
                              </td>
                              <td>
                                <span style="display: table-cell;">
                                  <input id="<?php echo $prefix; ?>_start" class="spider_int_input" type="text" value="<?php echo $layer->start; ?>" name="<?php echo $prefix; ?>_start" /> ms 
                                  <div class="spider_description">Start</div>
                                </span>
                                <span style="display: table-cell;">
                                  <select name="<?php echo $prefix; ?>_layer_effect_in" id="<?php echo $prefix; ?>_layer_effect_in" style="width:150px;" onchange="wds_trans_effect_in('<?php echo $slide_row->id; ?>', '<?php echo $prefix; ?>', 1); wds_trans_end('<?php echo $prefix; ?>', jQuery(this).val());">
                                  <?php
                                  foreach ($layer_effects_in as $key => $layer_effect_in) {
                                    ?>
                                    <option value="<?php echo $key; ?>" <?php echo (!in_array($key, $free_layer_effects)) ? 'disabled="disabled" title="This effect is disabled in free version."' : ''; ?> <?php if ($layer->layer_effect_in == $key) echo 'selected="selected"'; ?>><?php echo $layer_effect_in; ?></option>
                                    <?php
                                  }
                                  ?>
                                  </select>
                                  <div class="spider_description">Effect</div>
                                </span>
                                <span style="display: table-cell;">
                                  <input id="<?php echo $prefix; ?>_duration_eff_in" class="spider_int_input" type="text" onkeypress="return spider_check_isnum(event)" onchange="wds_trans_effect_in('<?php echo $slide_row->id; ?>', '<?php echo $prefix; ?>', 1); wds_trans_end('<?php echo $prefix; ?>', jQuery('#<?php echo $prefix; ?>_layer_effect_in').val());" value="<?php echo $layer->duration_eff_in; ?>" name="<?php echo $prefix; ?>_duration_eff_in" /> ms
                                  <div class="spider_description">Duration</div>
                                </span>
                                <div class="spider_description spider_free_version">Some effects are disabled in free version.</div>
                              </td>
                            </tr>
                            <tr class="wds_layer_tr" style="display: none;">
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_social_button">Social button: </label>
                              </td>
                              <td>
                                <select id="<?php echo $prefix; ?>_social_button" onchange="jQuery('#<?php echo $prefix; ?>').attr('class', 'wds_draggable_<?php echo $slide_row->id; ?> wds_draggable fa fa-' + jQuery(this).val())" name="<?php echo $prefix; ?>_social_button" />
                                  <?php
                                  foreach ($social_buttons as $key => $social_button) {
                                    ?>
                                    <option value="<?php echo $key; ?>" <?php echo (($layer->social_button == $key) ? 'selected="selected"' : ''); ?>><?php echo $social_button; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                                <div class="spider_description"></div>
                              </td>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_layer_effect_out">Effect Out:</label>
                              </td>
                              <td>
                                <span style="display: table-cell;">
                                  <input id="<?php echo $prefix; ?>_end" class="spider_int_input" type="text" value="<?php echo $layer->end; ?>" name="<?php echo $prefix; ?>_end"> ms
                                  <div class="spider_description">Start</div>
                                </span> 
                                <span style="display: table-cell;">
                                  <select name="<?php echo $prefix; ?>_layer_effect_out" id="<?php echo $prefix; ?>_layer_effect_out" style="width:150px;" onchange="wds_trans_effect_out('<?php echo $slide_row->id; ?>', '<?php echo $prefix; ?>', 1); wds_trans_end('<?php echo $prefix; ?>', jQuery(this).val());">
                                  <?php
                                  foreach ($layer_effects_out as $key => $layer_effect_out) {
                                    ?>
                                    <option value="<?php echo $key; ?>" <?php echo (!in_array($key, $free_layer_effects)) ? 'disabled="disabled" title="This effect is disabled in free version."' : ''; ?> <?php if ($layer->layer_effect_out == $key) echo 'selected="selected"'; ?>><?php echo $layer_effect_out; ?></option>
                                    <?php
                                  }
                                  ?>
                                  </select>
                                  <div class="spider_description">Effect</div>
                                </span> 
                                <span style="display: table-cell;">
                                  <input id="<?php echo $prefix; ?>_duration_eff_out" class="spider_int_input" type="text" onkeypress="return spider_check_isnum(event)" onchange="wds_trans_effect_out('<?php echo $slide_row->id; ?>', '<?php echo $prefix; ?>', 1); wds_trans_end('<?php echo $prefix; ?>', jQuery('#<?php echo $prefix; ?>_layer_effect_out').val());" value="<?php echo $layer->duration_eff_out; ?>" name="<?php echo $prefix; ?>_duration_eff_out"> ms
                                  <div class="spider_description">Duration</div>
                                </span>
                                <div class="spider_description spider_free_version">Some effects are disabled in free version.</div>
                              </td>
                            </tr>
                            <tr class="wds_layer_tr" style="display: none;">
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_size">Size: </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_size" class="spider_int_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({fontSize: jQuery(this).val() + 'px', lineHeight: jQuery(this).val() + 'px'})" onkeypress="return spider_check_isnum(event)" value="<?php echo $layer->size; ?>" name="<?php echo $prefix; ?>_size" /> px
                                <div class="spider_description"></div>
                              </td>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_color">Color: </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_color" class="color" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({color: '#' + jQuery(this).val()})" value="<?php echo $layer->color; ?>" name="<?php echo $prefix; ?>_color" />
                                <div class="spider_description"></div>
                              </td>
                            </tr>
                            <tr class="wds_layer_tr" style="display: none;">
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_transparent">Transparent: </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_transparent" class="spider_int_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({opacity: (100 - jQuery(this).val()) / 100, filter: 'Alpha(opacity=' + 100 - jQuery(this).val() + ')'})" onkeypress="return spider_check_isnum(event)" value="<?php echo $layer->transparent; ?>" name="<?php echo $prefix; ?>_transparent" /> %
                                <div class="spider_description">Value must be between 0 to 100.</div>
                              </td>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_hover_color">Hover Color: </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_hover_color" class="color" type="text" onchange="jQuery('#<?php echo $prefix; ?>').hover(function() { jQuery(this).css({color: '#' + jQuery('#<?php echo $prefix; ?>_hover_color').val()}); }, function() { jQuery(this).css({color: '#' + jQuery('#<?php echo $prefix; ?>_color').val()}); })" value="<?php echo $layer->hover_color; ?>" name="<?php echo $prefix; ?>_hover_color" />
                                <div class="spider_description"></div>
                              </td>
                            </tr>
                            <tr class="wds_layer_tr" style="display: none;">
                              <td class="spider_label">
                                <label>Published: </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_published1" type="radio" name="<?php echo $prefix; ?>_published" value="1" <?php echo (($layer->published) ? 'checked="checked"' : ''); ?> />
                                <label for="<?php echo $prefix; ?>_published1">Yes</label>
                                <input id="<?php echo $prefix; ?>_published0" type="radio" name="<?php echo $prefix; ?>_published" value="0" <?php echo (($layer->published) ? '' : 'checked="checked"'); ?>/>
                                <label for="<?php echo $prefix; ?>_published0">No</label>
                                <div class="spider_description"></div>
                              </td>                              
                            </tr>
                                <?php
                                break;
                              }
                              default:
                                break;
                            }
                            ?>
                            <input type="hidden" name="<?php echo $prefix; ?>_type" id="<?php echo $prefix; ?>_type" value="<?php echo $layer->type; ?>" />
                          </tbody>
                          <?php
                          $layer_ids_string .= $layer->id . ',';
                        }
                      }
                      ?>
                    </table>
                    <input id="slide<?php echo $slide_row->id; ?>_layer_ids_string" name="slide<?php echo $slide_row->id; ?>_layer_ids_string" type="hidden" value="<?php echo $layer_ids_string; ?>" />
                    <input id="slide<?php echo $slide_row->id; ?>_del_layer_ids_string" name="slide<?php echo $slide_row->id; ?>_del_layer_ids_string" type="hidden" value="" />
                  </div>
                    <script>
                      jQuery(document).ready(function() {
                        image_for_next_prev_butt('<?php echo $row->rl_butt_img_or_not; ?>');
                        image_for_bull_butt('<?php echo $row->bull_butt_img_or_not; ?>');						
                        image_for_play_pause_butt('<?php echo $row->play_paus_butt_img_or_not; ?>');							
                        wds_whr('width');
                        wds_drag_layer('<?php echo $slide_row->id; ?>');
                        wds_layer_weights('<?php echo $slide_row->id; ?>');
                        <?php
                        if ($layers_row) {
                          foreach ($layers_row as $key => $layer) {
                            if ($layer->type == 'image') {
                              $prefix = 'slide' . $slide_row->id . '_layer' . $layer->id;
                              ?>
                          wds_scale('#<?php echo $prefix; ?>_image_scale', '<?php echo $prefix; ?>');
                              <?php
                            }
                          }
                        }
                        ?>
                      });
                    </script>
                    <?php
                    $slide_ids_string .= $slide_row->id . ',';
                  }
                  ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="wds_task_cont">
        <input id="current_id" name="current_id" type="hidden" value="<?php echo $row->id; ?>" />
        <input id="slide_ids_string" name="slide_ids_string" type="hidden" value="<?php echo $slide_ids_string; ?>" />
        <input id="del_slide_ids_string" name="del_slide_ids_string" type="hidden" value="" />
        <input id="nav_tab" name="nav_tab" type="hidden" value="<?php echo WDW_S_Library::get('nav_tab', 'global'); ?>" />
        <input id="tab" name="tab" type="hidden" value="<?php echo WDW_S_Library::get('tab', 'slides'); ?>" />
        <input id="sub_tab" name="sub_tab" type="hidden" value="<?php echo $sub_tab_type; ?>" />
        <script>
          var spider_uploader = <?php echo $row->spider_uploader; ?>;
        </script>
      </div>
      <input id="task" name="task" type="hidden" value="" />
      <script>
        var uploader_href = '<?php echo add_query_arg(array('action' => 'addImage', 'width' => '700', 'height' => '550', 'extensions' => 'jpg,jpeg,png,gif', 'callback' => 'wds_add_image', 'image_for' => 'add_update_slide', 'slide_id' => 'slideID', 'layer_id' => 'layerID', 'TB_iframe' => '1'), admin_url('admin-ajax.php')); ?>';		
        var fv = '<?php echo $fv; ?>';
        jQuery(document).ready(function() {
          wds_onload();
        });
        jQuery("#sliders_form").on("click", "a", function(e) {
          e.preventDefault();
        });
      </script>
      <div class="opacity_add_image_url opacity_add_video wds_opacity_video" onclick="jQuery('.opacity_add_video').hide();jQuery('.opacity_add_image_url').hide();"></div>
      <div class="opacity_add_video wds_add_video">
        <input type="text" id="video_url" name="video_url" value="" />
        <input type="button" id="add_video_button" class="button-primary" value="Add" />
        <input type="button" class="button-secondary" onclick="jQuery('.opacity_add_video').hide(); return false;" value="Cancel" />
        <div class="spider_description">Enter YouTube or Vimeo link here.</div>
      </div>
      <div class="opacity_add_image_url wds_resize_image">
        <input type="text" id="image_url_input" name="image_url_input" value="" />
        <input type="button" id="add_image_url_button" class="button-primary" value="Add" />
        <input type="button" class="button-secondary" onclick="jQuery('.opacity_add_image_url').hide(); return false;" value="Cancel" />
        <div class="spider_description">Enter absolute url of the image.</div>
      </div>
    </form>
    <?php
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Getters & Setters                                                                  //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Private Methods                                                                    //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}