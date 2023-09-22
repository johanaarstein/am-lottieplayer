<?php
defined('ABSPATH') || exit;

if (class_exists('DiviExtension') && !class_exists('AM_LottieDiviModules')) {
  class AM_LottieDiviModules extends DiviExtension {
    public $gettext_domain = 'am-lottieplayer';
    public $name = 'am-lottieplayer';
    public $version = AM_LOTTIEPLAYER_VERSION;

    public function __construct($name = 'am-lottieplayer', $args = []) {
      $this -> plugin_dir = plugin_dir_path(__FILE__);
      $this -> plugin_dir_url = plugin_dir_url($this -> plugin_dir);
      parent::__construct($name, $args);
    }
  }

  new AM_LottieDiviModules;

  wp_register_style('am_lottie_et_styles', null);
  wp_enqueue_style('am_lottie_et_styles');

  $customStyle = '
    .et-fb-modules-list ul > li.et-fb-has-svg-icon .et-fb-icon {
      fill: #2b87da !important;
      width: 16px !important;
      min-width: 16px !important;
      height: 16px !important;
      margin: 0 auto 5px !important;
    }';

  wp_add_inline_style('am_lottie_et_styles', $customStyle);

}