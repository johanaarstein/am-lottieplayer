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
		add_action(
			'after_setup_theme',
			function () {
				$this->_set_version();
				$this->init_divi();
			}
		);
		add_action( 'init', array( $this, 'init_plugin' ), 11 );
		add_action( 'elementor/widgets/register', array( $this, 'init_elementor' ) );
		add_action( 'vc_before_init', array( $this, 'init_vc' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_enqueue' ) );
	}

	private function _set_version() {
		if ( ! defined( 'AAMD_LOTTIE_VERSION' ) ) {
			define( 'AAMD_LOTTIE_VERSION', get_plugin_data( AAMD_LOTTIE_FILE )['Version'] );
		}
	}

	/**
	 * Initialize Gutenberg Blocks, global shortcode and register JavaScript
	 */
	public function init_plugin() {

		// Shortcode is the same as Text Domain.
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
			'6.4.9',
			array(
				'strategy'  => 'defer',
				'in_footer' => true,
			)
		);

		global $aamd_pro_feature;
		if ( ! isset( $aamd_pro_feature ) ) {
			$aamd_pro_feature = AAMD_LOTTIE_IS_PRO ?
			'' : esc_html__( 'Pro Feature: ', 'am-lottieplayer' );
		}

		global $aamd_pro_link;
		if ( ! isset( $aamd_pro_link ) ) {
			$aamd_pro_link = AAMD_LOTTIE_IS_PRO ?
			'' : esc_html__( 'This feature will only work in the premium version.', 'am-lottieplayer' ) . ' <a href="' . esc_url( 'https://www.am-lottieplayer.com', 'am-lottieplayer' ) . '" target="_blank" rel="noreferrer">' . esc_html__( 'Read about additional features in AM LottiePlayer PRO', 'am-lottieplayer' ) . '<span class="dashicons dashicons-external" style="font-size: 1em;"></span></a>';
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
		if ( \function_exists( 'et_builder_d5_enabled' ) && et_builder_d5_enabled() ) {
			include_file( 'builders/divi/loader' );
		}

		// D5 still renders unconverted layouts via the D4 shortcode.
		if ( \function_exists( 'et_setup_builder' ) ) {
			add_action(
				'divi_extensions_init',
				function () {
					include_file( 'builders/divi/legacy/LottieDiviModules' );
				}
			);
		}
	}

	/**
	 * Initialize Elementor Widget
	 */
	public function init_elementor( object $widgets_manager ) {
		if ( ! \class_exists( '\Elementor\Widget_Base' ) ) {
			return;
		}

		include_file( 'builders/elementor/widgets/elementor-am-lottieplayer', $widgets_manager );

		$widgets_manager->register( new Elementor() );
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
		if ( is_admin() ) {
			return;
		}

		$is_divi_builder = ! empty( $_GET['et_fb'] );
		$is_vc_builder   = function_exists( 'vc_is_inline' ) && vc_is_inline();

		global $post;
		$content = is_a( $post, '\WP_Post' ) ? $post->post_content : '';

		$divi_layout_contents = $this->_get_divi_layout_contents();

		$has_gutenberg = has_block( 'gb/lottieplayer' ) || has_block( 'gb/lottiecover' );
		$has_shortcode = has_shortcode( $content, 'am-lottieplayer' ) && ! $is_vc_builder;
		$has_divi      = ! $is_divi_builder && (
			! empty( $divi_layout_contents ) ||
			has_shortcode( $content, 'et_pb_lottieplayer' ) ||
			has_block( 'am/lottieplayer-module' )
		);

		if ( ! $has_gutenberg && ! $has_shortcode && ! $has_divi && ! $is_divi_builder && ! $is_vc_builder ) {
			return;
		}

		$handle = 'dotlottie-player-light';
		if ( AAMD_LOTTIE_IS_PRO ) {
			$load_light = (bool) get_option( 'am_lottieplayer_pro_load_light' );
			if ( ! $load_light || $this->_has_non_svg_renderer( $content, $divi_layout_contents ) ) {
				$handle = 'dotlottie-player';
			}
		}

		// Gutenberg blocks register `dotlottie-player-light` in block.json.
		if ( $has_gutenberg ) {
			if ( $handle === 'dotlottie-player-light' ) {
				wp_enqueue_script( 'dotlottie-player-light' );
				wp_dequeue_script( 'dotlottie-player' );
			}
			return;
		}

		wp_enqueue_script( $handle );
	}

	/**
	 * Flatten a parsed block tree, optionally keeping only given block names.
	 *
	 * @param array<int, array> $blocks Result of parse_blocks().
	 * @param string[]          $names  Empty = keep every named block.
	 * @return array<int, array>
	 */
	private function _flatten_blocks( array $blocks, array $names = array() ) {
		$found = array();
		foreach ( $blocks as $block ) {
			$name = $block['blockName'] ?? null;
			if ( $name && ( empty( $names ) || in_array( $name, $names, true ) ) ) {
				$found[] = $block;
			}
			if ( ! empty( $block['innerBlocks'] ) ) {
				$found = array_merge(
					$found,
					$this->_flatten_blocks( $block['innerBlocks'], $names )
				);
			}
		}
		return $found;
	}

	/**
	 * Content of overridden Divi Theme Builder header/body/footer layouts
	 * that contain a Lottie shortcode.
	 *
	 * TODO: Adjust for DIVI 5 if relevant
	 *
	 * @return string[]
	 */
	private function _get_divi_layout_contents() {
		if ( ! function_exists( 'et_theme_builder_get_template_layouts' ) ) {
			return array();
		}

		$layouts = et_theme_builder_get_template_layouts();
		if ( empty( $layouts ) ) {
			return array();
		}

		$contents = array();

		foreach ( array( 'header', 'body', 'footer' ) as $part ) {
			$layout = $layouts[ "et_{$part}_layout" ] ?? array();
			if ( empty( $layout['override'] ) || empty( $layout['id'] ) ) {
				continue;
			}

			$layout_post = get_post( $layout['id'] );
			if ( $layout_post && has_shortcode( $layout_post->post_content, 'et_pb_lottieplayer' ) ) {
				$contents[] = $layout_post->post_content;
			}
		}

		return $contents;
	}

	/**
	 * Whether any Lottie instance uses a non-SVG renderer (canvas/html).
	 *
	 * @param string   $content          Post content.
	 * @param string[] $layout_contents  Divi layout contents that contain Lottie.
	 */
	private function _has_non_svg_renderer( $content, array $layout_contents ) {
		if ( has_blocks( $content ) ) {
			$blocks = $this->_flatten_blocks(
				parse_blocks( $content ),
				array(
					'gb/lottieplayer',
					'gb/lottiecover',
					'am/lottieplayer-module',
				)
			);

			foreach ( $blocks as $block ) {
				$renderer = $block['attrs']['renderer'] ?? null;

				// Divi 5 stores attrs under the module metadata tree.
				if ( ( $block['blockName'] ?? '' ) === 'am/lottieplayer-module' ) {
					$renderer = $block['attrs']['lottie']['innerContent']['desktop']['value']['renderer'] ?? $renderer;
				}

				if ( $renderer && $renderer !== 'svg' ) {
					return true;
				}
			}
		}

		$shortcodes = array_merge(
			get_shortcode_instances( $content, 'am-lottieplayer' ) ?? array(),
			get_shortcode_instances( $content, 'et_pb_lottieplayer' ) ?? array()
		);

		foreach ( $layout_contents as $layout_content ) {
			$shortcodes = array_merge(
				$shortcodes,
				get_shortcode_instances( $layout_content, 'et_pb_lottieplayer' ) ?? array()
			);
		}

		foreach ( $shortcodes as $shortcode ) {
			$atts     = shortcode_parse_atts( $shortcode );
			$renderer = is_array( $atts ) ? ( $atts['renderer'] ?? false ) : false;

			if ( $renderer && $renderer !== 'svg' ) {
				return true;
			}
		}

		return false;
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
