<?php
namespace AAMD_Lottie;

use function AAMD_Lottie\Utility\get_build_path;
use function AAMD_Lottie\Utility\get_script;
use function AAMD_Lottie\Utility\get_shortcode_instances;
use function AAMD_Lottie\Utility\include_file;

\defined( 'ABSPATH' ) || exit;

/**
 * Check for active builders, and initialize extensions
 * Supported builders: Gutenberg, Divi, Elementor, WPBakery, Flatsome
 */
class Builder {

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Builder initializations
		// add_action( 'setup_theme', array( $this, 'override_divi_functions' ) );
		add_action( 'init', array( $this, 'init_plugin' ), 11 );
		add_action( 'divi_extensions_init', array( $this, 'init_divi' ) );
		add_action( 'elementor/widgets/register', array( $this, 'init_elementor' ) );
		add_action( 'vc_before_init', array( $this, 'init_vc' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_enqueue' ) );
	}

	/**
	 * TODO: Find a better hook, so this doesn't fire all the time.
	 */
	// public function override_divi_functions() {
	// include_file( 'builders/divi/functions' );
	// }

	/**
	 * Initialize Gutenberg Blocks, global shortcode and register JavaScript
	 */
	public function init_plugin() {
		add_shortcode( 'am-lottieplayer', 'AAMD_Lottie\Utility\render_shortcode' );

		register_block_type(
			get_build_path( 'lottieplayer' )
		);
		register_block_type(
			get_build_path( 'lottiecover' )
		);

		wp_register_script(
			'dotlottie-player-light',
			get_script( 'dotlottie-player-light.min.js' ),
			array(),
			'6.0.0',
			array(
				'strategy'  => 'defer',
				'in_footer' => true,
			)
		);

		wp_register_script(
			'am-frontend-light',
			get_script( 'am-frontend.min.js' ),
			array( 'dotlottie-player-light' ),
			'1.3.1',
			array(
				'strategy'  => 'defer',
				'in_footer' => true,
			)
		);

		global $pro_feature;
		if ( ! isset( $pro_feature ) ) {
			$pro_feature = AAMD_LOTTIE_IS_PRO ?
			'' : esc_html__( 'Pro Feature: ', 'am-lottieplayer' );
		}

		global $pro_link;
		if ( ! isset( $pro_link ) ) {
			$pro_link = AAMD_LOTTIE_IS_PRO ?
			'' : esc_html__( 'This feature will only work in the premium version.', 'am-lottieplayer' ) . ' <a href="' . esc_url( 'https://www.aarstein.media/en/am-lottieplayer/pro', 'am-lottieplayer' ) . '" target="_blank" rel="noreferrer">' . esc_html__( 'Read about additional features in AM LottiePlayer PRO', 'am-lottieplayer' ) . '<span class="dashicons dashicons-external" style="font-size: 1em;"></span></a>';
		}

		// INIT BRICKS
		$this->init_bricks();

		// INIT FLATSOME
		$this->init_flatsome();
	}

	/**
	 * Initialize Bricks builder
	 */
	public function init_bricks() {
		if ( ! class_exists( '\Bricks\Elements' ) ) {
			return;
		}
		$element_files = array(
			trailingslashit( AAMD_LOTTIE_PATH ) . 'includes/builders/bricks/element.php',
		);

		foreach ( $element_files as $file ) {
			\Bricks\Elements::register_element( $file );
		}
	}

	/**
	 * Initialize DIVI Extension
	 */
	public function init_divi() {
		if (
			! \class_exists( '\DiviExtension' ) ||
			! \class_exists( '\ET_Builder_Module' ) ||
			! \class_exists( '\ET_Builder_Element' )
		) {
			return;
		}
		include_file( 'builders/divi/LottieDiviModules' );
	}

	/**
	 * Initialize Elementor Widget
	 */
	public function init_elementor( $widgets_manager ) {
		if ( ! \class_exists( '\Elementor\Widget_Base' ) ) {
			return;
		}
		include_file( 'builders/elementor/widgets/elementor-am-lottieplayer', $widgets_manager );
	}

	/**
	 * Initialize Flatsome Shortcode
	 */
	public function init_flatsome() {
		if ( ! function_exists( 'add_ux_builder_shortcode' ) ) {
			return;
		}
		include_file( 'builders/flatsome/ux-am-lottieplayer' );
	}

	/**
	 * Initialize Visual Composer
	 */
	public function init_vc() {
		if ( ! function_exists( 'vc_map' ) ) {
			return;
		}
		include_file( 'builders/vc/vc-am-lottieplayer' );
	}

	/**
	 * Enqueue JavaScript for frontend
	 */
	public function frontend_enqueue() {
		global $post;
		$content = '';

		$has_divi        = false;
		$divi_shortcodes = array();

		// Check if any front-end builders are active
		$isDiviBuilder = isset( $_GET['et_fb'] ) && ! empty( $_GET['et_fb'] );
		$isVCBuilder   = function_exists( 'vc_is_inline' ) && vc_is_inline();

		if ( is_a( $post, '\WP_Post' ) ) {
			$content = $post->post_content;
		}

		// Check for Lottie in Divi Templates
		if ( function_exists( 'et_theme_builder_get_template_layouts' ) ) {
			$layouts = et_theme_builder_get_template_layouts();
			if ( ! empty( $layouts ) ) {
				foreach ( array( 'header', 'body', 'footer' ) as $part ) {
					$divi_shortcodes = $this->_get_divi_shortcodes_from_layouts(
						$layouts,
						$divi_shortcodes,
						$part
					);
				}
			}

			$has_divi = count( $divi_shortcodes ) > 0;
		}

		// Check if post has Gutenberg blocks
		$has_gutenberg = has_block( 'gb/lottieplayer' ) || has_block( 'gb/lottiecover' );

		// Check if full version is needed on the front-end
		$is_light = ! AAMD_LOTTIE_IS_PRO || (bool) get_option( 'am_lottieplayer_pro_load_light' );

		if ( AAMD_LOTTIE_IS_PRO && $is_light && $has_gutenberg ) {
			$blocks = parse_blocks( $content );
			foreach ( $blocks as $block ) {
				if ( $block['blockName'] !== 'gb/lottieplayer' && $block['blockName'] !== 'gb/lottiecover' ) {
					continue;
				}
				if ( isset( $block['attrs']['renderer'] ) && $block['attrs']['renderer'] !== 'svg' ) {
					$is_light = false;
				}
			}
		}

		// Check if post has general shortcode, and VC frontend builder is not active
		$has_shortcode = has_shortcode( $content, 'am-lottieplayer' ) && ! $isVCBuilder;

		if ( AAMD_LOTTIE_IS_PRO && $is_light ) {
			$shortcodes = array_merge(
				get_shortcode_instances( $content, 'am-lottieplayer' ) ?? array(),
				get_shortcode_instances( $content, 'et_pb_lottieplayer' ) ?? array()
			);

			foreach ( $shortcodes as $shortcode ) {
				$atts = shortcode_parse_atts( $shortcode );

				$renderer = $atts['renderer'];

				if ( isset( $renderer ) && $renderer !== 'svg' ) {
					$is_light = false;
				}
			}
		}

		// Check if post has Divi shortcode, and Divi Builder is not active
		$has_divi = ! $isDiviBuilder && ( $has_divi || has_shortcode( $content, 'et_pb_lottieplayer' ) );

		if ( ! is_admin() ) {
			if ( $has_gutenberg || $has_shortcode || $has_divi ) {
				wp_enqueue_script(
					$is_light && ! AAMD_LOTTIE_IS_PRO ?
						'am-frontend-light' : 'am-frontend'
				);
				// Add scripts for Divi/VC front-end builder, if either are installed and active
			} elseif ( $isDiviBuilder || $isVCBuilder ) {
				wp_enqueue_script(
					AAMD_LOTTIE_IS_PRO ?
						'dotlottie-player' : 'dotlottie-player-light'
				);
			}
		}
	}

	/**
	 * Check if Divi shortcode is present in content
	 * and return them if they are
	 */
	private function _get_divi_shortcodes_from_layouts(
		array $layouts,
		array $divi_shortcodes,
		string $part
	) {
		if ( $layouts[ "et_{$part}_layout" ]['override'] ) {
			$content = null;
			if ( get_post( $layouts[ "et_{$part}_layout" ]['id'] ) ) {
				$content = get_post( $layouts[ "et_{$part}_layout" ]['id'] )->post_content;
			}
			if ( $content && has_shortcode( $content, 'et_pb_lottieplayer' ) ) {
				// This is used to determine whether to load full or light version
				$divi_shortcodes = array_merge(
					get_shortcode_instances( $content, 'et_pb_lottieplayer' ) ?? array(),
					$divi_shortcodes
				);
			}
		}

		return $divi_shortcodes;
	}
}

/**
 * Main function, to initialize class
 *
 * @return Builder
 */
( function () {
	global $aamd_lottie_builder;
	if ( ! AAMD_LOTTIE_IS_PRO && ! isset( $aamd_lottie_builder ) ) {
		$aamd_lottie_builder = new Builder();
	}

	return $aamd_lottie_builder;
} )();
