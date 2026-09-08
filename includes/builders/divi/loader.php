<?php

namespace AAMD_Lottie;

\defined( 'ABSPATH' ) || exit;

use function AAMD_Lottie\Utility\include_file;
use ET\Builder\Framework\DependencyManagement\DependencyTree;

// Register module.
add_action(
	'divi_module_library_modules_dependency_tree',
	function ( DependencyTree $dependency_tree ) {
		include_file( 'builders/divi/module' );
		$dependency_tree->add_dependency( new AMLottiePlayerModule() );
	}
);

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
		array(
			'isPRO' => (bool) AAMD_LOTTIE_IS_PRO,
		)
	);
}

add_action(
	'divi_visual_builder_assets_before_enqueue_scripts',
	__NAMESPACE__ . '\am_lottieplayer_module_enqueue_visual_builder_assets'
);
