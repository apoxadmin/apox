<?php

class WDSViewGoptions_wds {
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
    $register_scripts = get_option("wds_register_scripts", 0);
    $wds_loading_gif = get_option("wds_loading_gif", 0);
    $loading_gifs = array(
      0 => 'Loading default',
      1 => 'Loading1',
      2 => 'Loading2',
      3 => 'Loading3',
      4 => 'Loading4',
      5 => 'Loading5',
    );
    ?>
    <div style="clear: both; float: left; width: 99%;">
      <div style="float: left; font-size: 14px; font-weight: bold;">
        This section allows you to edit global options for sliders.
        <a style="color: blue; text-decoration: none;" target="_blank" href="https://web-dorado.com/wordpress-slider-wd/adding-images.html">Read More in User Manual</a>
      </div>
    </div>
     <div class="clear"></div>
    <form class="wrap wds_form" id="sliders_form" method="post" action="admin.php?page=goptions_wds" style="width: 99%;" enctype="multipart/form-data">
      <?php wp_nonce_field('nonce_wd', 'nonce_wd'); ?>
      <div class="wds-options-page-banner">
        <div class="wds-options-logo"></div>
				<div class="wds-options-logo-title">
					<?php _e('Global Options', 'wds'); ?>
				</div>
        <div class="wds-page-actions">
			   <button class="wds_button-secondary wds_save_slider"  onclick="spider_set_input_value('task', 'save');">
          <span></span>
          <?php _e('Save', 'wds'); ?>
				 </button>
		  	</div>	
      </div>
      <table>
			  <tbody>
          <tr>
            <td class="spider_label"><label><?php _e('Include scripts only on necessary pages', 'wds'); ?>:</label></td>
               <td>
                <input type="radio" id="wds_register_scripts1" name="wds_register_scripts" <?php echo (($register_scripts == 1)? "checked='checked'" : ""); ?> value="1" /><label <?php echo ($register_scripts ? 'class="selected_color"' : ''); ?> for="wds_register_scripts1"><?php _e('Yes', 'wds'); ?></label>
                <input type="radio" id="wds_register_scripts0" name="wds_register_scripts" <?php echo (($register_scripts == 0)? "checked='checked'" : ""); ?> value="0" /><label <?php echo ($register_scripts ? '' : 'class="selected_color"'); ?> for="wds_register_scripts0"><?php _e('No', 'wds'); ?></label>
                <div class="spider_description"><?php _e('Helps to decrease page load time. Might not function with some custom themes.', 'wds'); ?></div>
             </td>
          </tr>
          <tr>
            <td class="spider_label">
              <label for="loading_gif">Loading icon:</label>
            </td>
            <td>
              <select class="select_icon select_icon_320 select_gif" name="loading_gif" id="loading_gif" onchange="wds_loading_gif(jQuery(this).val(), '<?php echo WD_S_URL ?>')">
                <?php
                  foreach ($loading_gifs as $key => $loading_gif) {
                ?>
              <option value="<?php echo $key; ?>" <?php if ($wds_loading_gif == $key) echo 'selected="selected"'; ?>><?php echo $loading_gif; ?></option>
                <?php
                  }
                ?>
              </select>
              <img id="load_gif_img" src="<?php echo WD_S_URL . '/images/loading/' . $wds_loading_gif . '.gif'; ?>"></img>
              <div class="spider_description"></div>
            </td>
          </tr>  
        </tbody>
			</table>
      <input id="task" name="task" type="hidden" value="" />
    </form>
    <?php
  }
}