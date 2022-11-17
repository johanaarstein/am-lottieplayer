<?php
if (class_exists('DiviExtension')) {
  class LottieDiviModules extends DiviExtension {
    public $gettext_domain = 'lottieplayer';
    public $name = 'lottieplayer';
    public $version = '1.0.0';

    public function __construct($name = 'lottieplayer', $args = []) {
      $this -> plugin_dir = plugin_dir_path(__FILE__);
      $this -> plugin_dir_url = plugin_dir_url($this -> plugin_dir);
      parent::__construct($name, $args);
    }
  }

  new LottieDiviModules;

  wp_register_style('lottie_et_styles', false);
  wp_enqueue_style('lottie_et_styles');

  $customStyle = '
    .et-fb-modules-list ul > li.et-fb-has-svg-icon .et-fb-icon {
      fill: #2b87da !important;
      width: 16px !important;
      min-width: 16px !important;
      height: 16px !important;
      margin: 0 auto 5px !important;
    }';

  wp_add_inline_style('lottie_et_styles', $customStyle);

}