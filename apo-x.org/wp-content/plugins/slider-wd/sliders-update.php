<?php

function wds_update($version) {
  global $wpdb;
  if (version_compare($version, '1.0.2') == -1) {
   // Add spider uploader option.
   $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdsslider ADD `spider_uploader` tinyint(1) NOT NULL DEFAULT 0");
  }
   if (version_compare($version, '1.0.4') == -1) {
    // Add stop animation on hover and link target options.
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdsslider ADD `stop_animation` tinyint(1) NOT NULL DEFAULT 0");
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdsslide ADD `target_attr_slide` tinyint(1) NOT NULL DEFAULT 1");
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdslayer ADD `target_attr_layer` tinyint(1) NOT NULL DEFAULT 1");
  }
  if (version_compare($version, '1.0.5') == -1) {
    // Add right/left button image/hover image url.
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdsslider ADD `right_butt_url` varchar(255) NOT NULL DEFAULT '" . WD_S_URL . '/images/arrow/arrow11/1/2.png' . "'");
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdsslider ADD `left_butt_url` varchar(255) NOT NULL DEFAULT '" . WD_S_URL . '/images/arrow/arrow11/1/1.png' . "'");
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdsslider ADD `right_butt_hov_url` varchar(255) NOT NULL DEFAULT '" . WD_S_URL . '/images/arrow/arrow11/1/4.png' . "'");
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdsslider ADD `left_butt_hov_url` varchar(255) NOT NULL DEFAULT '" . WD_S_URL . '/images/arrow/arrow11/1/3.png' . "'");
    // Whether to display right/left buttons by image or not.
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdsslider ADD `rl_butt_img_or_not` varchar(8) NOT NULL DEFAULT 'style'");
    // Add bullets image/hover image url.
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdsslider ADD `bullets_img_main_url` varchar(255) NOT NULL DEFAULT '" . WD_S_URL . '/images/bullet/bullet1/1/1.png' . "'");
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdsslider ADD `bullets_img_hov_url` varchar(255) NOT NULL DEFAULT '" . WD_S_URL . '/images/bullet/bullet1/1/2.png' . "'");
    // Whether to display bullets by image or not.
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdsslider ADD `bull_butt_img_or_not` varchar(8) NOT NULL DEFAULT 'style'");
  }
  if (version_compare($version, '1.0.6') == -1) {
    // Add play/pause button image/hover image url.
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdsslider ADD `play_butt_url` varchar(255) NOT NULL DEFAULT '" . WD_S_URL . '/images/button/button4/1/1.png' . "'");
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdsslider ADD `paus_butt_url` varchar(255) NOT NULL DEFAULT '" . WD_S_URL . '/images/button/button4/1/3.png' . "'");
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdsslider ADD `play_butt_hov_url` varchar(255) NOT NULL DEFAULT '" . WD_S_URL . '/images/button/button4/1/2.png' . "'");
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdsslider ADD `paus_butt_hov_url` varchar(255) NOT NULL DEFAULT '" . WD_S_URL . '/images/button/button4/1/4.png' . "'");
    // Whether to display play/pause buttons by image or not.
    $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wdsslider ADD `play_paus_butt_img_or_not` varchar(8) NOT NULL DEFAULT 'style'");
  }
  return;
}

?>