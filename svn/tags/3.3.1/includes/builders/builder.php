<?php
namespace AAMD_Lottie;

use function AAMD_Lottie\Utility\include_file;

\defined( 'ABSPATH' ) || exit;

/**
 * Check for active builders, and initialize extensions
 * Supported builders: Gutenberg, Divi, Elementor, WPBakery, Flatsome
 */
class Builder {

	public function __construct() {
		// Builder initializations
		add_action( 'init', array( $this, 'init_plugin' ) );
		add_action( 'divi_extensions_init', array( $this, 'init_divi' ) );
		add_action( 'elementor/widgets/register', array( $this, 'init_elementor' ) );
		add_action( 'after_setup_theme', array( $this, 'init_flatsome' ) );
		add_action( 'vc_before_init', array( $this, 'init_vc' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_enqueue' ) );
	}

	/**
	 * Initialize Gutenberg Blocks, global shortcode and register JavaScript
	 *
	 * @return void
	 */
	public function init_plugin() {
		add_shortcode( 'am-lottieplayer', 'AAMD_Lottie\Utility\render_shortcode' );

		register_block_type( AAMD_LOTTIE_PATH . 'build/lottieplayer' );
		register_block_type( AAMD_LOTTIE_PATH . 'build/lottiecover' );

		wp_register_script(
			'dotlottie-player-light',
			AAMD_LOTTIE_URL . 'scripts/dotlottie-player-light.min.js',
			array(),
			'4.0.1',
			array(
				'strategy'  => 'defer',
				'in_footer' => true,
			)
		);

		wp_register_script(
			'am-frontend',
			AAMD_LOTTIE_URL . 'scripts/am-frontend.min.js',
			array( 'dotlottie-player-light' ),
			'1.2.3',
			array(
				'strategy'  => 'defer',
				'in_footer' => true,
			)
		);
	}

	/**
	 * Initialize DIVI Extension
	 *
	 * @return void
	 */
	public function init_divi() {
		include_file( 'builders/divi/LottieDiviModules' );
	}

	/**
	 * Initialize Elementor Widget
	 *
	 * @return void
	 */
	public function init_elementor( $widgets_manager ) {
		wp_enqueue_style(
			'elementor-backend-style',
			AAMD_LOTTIE_URL . 'styles/am-font.css',
			array(),
			'1.0.0'
		);
		include_file( 'builders/elementor/widgets/elementor-am-lottieplayer', $widgets_manager );
	}

	/**
	 * Initialize Flatsome Shortcode
	 *
	 * @return void
	 */
	public function init_flatsome() {
		if ( ! function_exists( 'add_ux_builder_shortcode' ) ) {
			return;
		}
		include_file( 'builders/flatsome/ux-am-lottieplayer' );
	}

	/**
	 * Initialize Visual Composer
	 *
	 * @return void
	 */
	public function init_vc() {
		include_file( 'builders/vc/vc-am-lottieplayer' );
	}

	/**
	 * Check if Divi shortcode is present in content
	 */
	private function _check_if_divi_shortcode_is_present(
		array $layouts,
		bool $has_divi,
		string $part
	) {
		if ( $has_divi ) {
			return true;
		}
		if ( $layouts[ "et_{$part}_layout" ]['override'] ) {
			$content = null;
			if ( get_post( $layouts[ "et_{$part}_layout" ]['id'] ) ) {
				$content = get_post( $layouts[ "et_{$part}_layout" ]['id'] )->post_content;
			}
			if ( $content && has_shortcode( $content, 'et_pb_lottieplayer' ) ) {
				$has_divi = true;
			}
		}

		return $has_divi;
	}

	/**
	 * Enqueue JavaScript for frontend
	 *
	 * @return void
	 */
	public function frontend_enqueue() {
		global $post;
		$content = '';

		$has_divi = false;

		// Check if any front-end builders are active
		$isDiviBuilder = isset( $_GET['et_fb'] ) && ! empty( $_GET['et_fb'] );

		$isVCBuilder = function_exists( 'vc_is_inline' ) && vc_is_inline();

		if ( is_a( $post, 'WP_Post' ) ) {
			$content = $post->post_content;
		}

		// Check for Lottie in Divi Templates
		if ( function_exists( 'et_theme_builder_get_template_layouts' ) ) {
			$layouts = et_theme_builder_get_template_layouts();
			if ( ! empty( $layouts ) ) {
				foreach ( array( 'header', 'body', 'footer' ) as $part ) {
					$has_divi = $this->_check_if_divi_shortcode_is_present(
						$layouts,
						$has_divi,
						$part
					);
				}
			}
		}

		// Check if post has Gutenberg blocks
		$has_gutenberg = has_block( 'gb/lottieplayer' ) || has_block( 'gb/lottiecover' );

		// Check if post has general shortcode, and VC frontend builder is not active
		$has_shortcode = has_shortcode( $content, 'am-lottieplayer' ) && ! $isVCBuilder;

		// Check if post has Divi shortcode, and Divi Builder is not active
		$has_divi = ! $isDiviBuilder && ( $has_divi || has_shortcode( $content, 'et_pb_lottieplayer' ) );

		if ( ! is_admin() ) {
			if ( $has_gutenberg || $has_shortcode || $has_divi ) {
				wp_enqueue_script( 'am-frontend' );
			}
			// Add scripts for Divi/VC front-end builder, if either are installed and active
			if ( $isDiviBuilder || $isVCBuilder ) {
				wp_enqueue_script( 'dotlottie-player-light' );
			}
		}
	}
}

/**
 * Main function, to initialize class
 *
 * @return Builder
 */
( function () {
	global $aamd_lottie_builder;
	if ( ! isset( $aamd_lottie_builder ) ) {
		$aamd_lottie_builder = new Builder();
	}
	return $aamd_lottie_builder;
} )();
