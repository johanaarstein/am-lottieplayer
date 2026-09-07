<?php

namespace AAMD_Lottie;

\defined( 'ABSPATH' ) || exit;

use function AAMD_Lottie\Utility\include_file;

// Load Divi 5 module.
include_file( 'builders/divi/module' );

/**
 * Enqueue Divi 5 Visual Builder Assets
 */
function am_lottieplayer_module_enqueue_visual_builder_assets() {
	if ( ! et_core_is_fb_enabled() || ! et_builder_d5_enabled() ) {
		return;
	}

	$player_script_handle = 'dotlottie-player-light';

	if ( AAMD_LOTTIE_IS_PRO ) {
		$player_script_handle = 'dotlottie-player';
	}

	\ET\Builder\VisualBuilder\Assets\PackageBuildManager::register_package_build(
		array(
			'name'    => 'am-lottieplayer-module-visual-builder',
			'version' => '1.0.0',
			'script'  => array(
				'src'                => AAMD_LOTTIE_URL . 'scripts/divi/am-lottieplayer-module.js',
				'deps'               => array(
					'divi-module-library',
					'divi-vendor-wp-hooks',
					$player_script_handle,
				),
				'enqueue_top_window' => false,
				'enqueue_app_window' => true,
			),
		)
	);

	wp_localize_script(
		$player_script_handle,
		'amLottiePlayer',
		wp_json_encode(
			array(
				'isPro' => (bool) AAMD_LOTTIE_IS_PRO,
			)
		)
	);
}

add_action( 'divi_visual_builder_assets_before_enqueue_scripts', 'am_lottieplayer_module_enqueue_visual_builder_assets' );
