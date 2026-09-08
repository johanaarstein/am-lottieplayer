<?php
namespace AAMD_Lottie;

\defined( 'ABSPATH' ) || exit;

class DiviModules extends \DiviExtension {

	public $gettext_domain = 'am-lottieplayer';
	public $name           = 'am-lottieplayer';
	public $version        = AAMD_LOTTIE_VERSION;

	private function _custom_style() {
		return '.et-fb-modules-list ul > li.et-fb-has-svg-icon .et-fb-icon {
			fill: #2b87da !important;
			width: 16px !important;
			min-width: 16px !important;
			height: 16px !important;
			margin: 0 auto 5px !important;
		}
		.et_fb_lottieplayer::before{
			content: url(' . AAMD_LOTTIE_URL . 'assets/divi-icon.svg)!important;
			width: 16px;
			height: auto;
			margin: auto;
		}';
	}

	public function __construct( $name = 'am-lottieplayer', $args = array() ) {
		parent::__construct( $name, $args );

		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = AAMD_LOTTIE_URL;

		wp_register_style(
			'am_lottie_et_styles',
			false,
			array(),
			'1.0.0'
		);
		wp_enqueue_style( 'am_lottie_et_styles' );
		wp_add_inline_style( 'am_lottie_et_styles', $this->_custom_style() );
	}

	/**
	 * Change default behavior, so we can place scripts where we damned well please!
	 */
	#[\Override]
	protected function _enqueue_bundles() {
		// Frontend Bundle.
		$bundle_url = "{$this->plugin_dir_url}scripts/divi/legacy/frontend-bundle.min.js";

		wp_enqueue_script( "{$this->name}-frontend-bundle", $bundle_url, $this->_bundle_dependencies['frontend'], $this->version, true );

		if ( et_core_is_fb_enabled() ) {
			// Builder Bundle.
			$bundle_url = "{$this->plugin_dir_url}scripts/divi/legacy/builder-bundle.min.js";

			wp_enqueue_script( "{$this->name}-builder-bundle", $bundle_url, $this->_bundle_dependencies['builder'], $this->version, true );
		}
	}
}

new DiviModules();
