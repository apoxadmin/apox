<?php

class WDSControllerGoptions_wds {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function __construct() {
   
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////

  public function execute() {
    $task = WDW_S_Library::get('task');
    $id = WDW_S_Library::get('current_id', 0);
    $message = WDW_S_Library::get('message');
    echo WDW_S_Library::message_id($message);
    if (method_exists($this, $task)) {
      check_admin_referer('nonce_wd', 'nonce_wd');
      $this->$task($id);
    }
    else {
      $this->display();
    }
  }

  public function display() {
    require_once WD_S_DIR . "/admin/models/WDSModelGoptions_wds.php";
    $model = new WDSModelGoptions_wds();

    require_once WD_S_DIR . "/admin/views/WDSViewGoptions_wds.php";
    $view = new WDSViewGoptions_wds($model);
    $view->display();
  }

  public function save() {
    $wds_register_scripts = (isset($_REQUEST['wds_register_scripts']) ? (int) $_REQUEST['wds_register_scripts'] : 0);
    $loading_gif = (isset($_REQUEST['loading_gif']) ? esc_html($_REQUEST['loading_gif']) : 0);
    if (get_option("wds_register_scripts") !== false) {
      update_option("wds_register_scripts", $wds_register_scripts);
      update_option("wds_loading_gif", $loading_gif);
    }
    else {
      add_option("wds_register_scripts", $wds_register_scripts, 0, 'no');
      add_option("wds_loading_gif", $loading_gif, 0, 'no');
    }
    $page = WDW_S_Library::get('page');
    WDW_S_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'display', 'message' => 1), admin_url('admin.php')));
  }
}