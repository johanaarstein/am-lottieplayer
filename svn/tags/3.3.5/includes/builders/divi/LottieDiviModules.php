<?php
namespace AAMD_Lottie;

\defined( 'ABSPATH' ) || exit;

if ( \class_exists( '\DiviExtension' ) ) {
	class DiviModules extends \DiviExtension {

		public $gettext_domain = 'am-lottieplayer';
		public $name           = 'am-lottieplayer';
		public $version        = AAMD_LOTTIE_VERSION;

		public function __construct( $name = 'am-lottieplayer', $args = array() ) {
			$this->plugin_dir     = plugin_dir_path( __FILE__ );
			$this->plugin_dir_url = AAMD_LOTTIE_URL;
			parent::__construct( $name, $args );
		}
	}

	new DiviModules();

	wp_register_style(
		'am_lottie_et_styles',
		false,
		array(),
		'1.0.0'
	);
	wp_enqueue_style( 'am_lottie_et_styles' );

	$custom_style = '
    .et-fb-modules-list ul > li.et-fb-has-svg-icon .et-fb-icon {
      fill: #2b87da !important;
      width: 16px !important;
      min-width: 16px !important;
      height: 16px !important;
      margin: 0 auto 5px !important;
    }';

	wp_add_inline_style( 'am_lottie_et_styles', $custom_style );
}
