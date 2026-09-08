<?php
namespace AAMD_Lottie;

\defined( 'ABSPATH' ) || exit;

use ET\Builder\Framework\DependencyManagement\Interfaces\DependencyInterface;
// use ET\Builder\Framework\Utility\HTMLUtility;
use ET\Builder\FrontEnd\Module\Style;
use ET\Builder\Packages\Module\Module;
use ET\Builder\Packages\Module\Options\Element\ElementClassnames;
use ET\Builder\Packages\ModuleLibrary\ModuleRegistration;
use function AAMD_Lottie\Utility\render_shortcode;

/**
 * Class that handle "Simple Quick Module" module output in frontend.
 */
class AMLottiePlayerModule implements DependencyInterface {
	/**
	 * Register module.
	 * `DependencyInterface` interface ensures class method name `load()` is executed for initialization.
	 */
	public function load() {
		// Register module.
		add_action( 'init', array( self::class, 'register_module' ) );
	}

	/**
	 * Register module.
	 */
	public static function register_module() {
		// Path to module metadata that is shared between Frontend and Visual Builder.
		// $module_json_folder_path = dirname( __DIR__, 1 ) . '/visual-builder/src';

		ModuleRegistration::register_module(
			__DIR__,
			array(
				'render_callback' => array( self::class, 'render_callback' ),
			)
		);

		$metadata = json_decode(
			file_get_contents( __DIR__ . '/module.json' ),
			true
		);

		ModuleRegistration::process_conversion_outline(
			$metadata,
			__DIR__ . '/conversion-outline.json'
		);
	}

	/**
	 * Render module style.
	 */
	public static function module_styles( array $args ) {
		// $attrs    = $args['attrs'] ?? array();
		$elements = $args['elements'];

		Style::add(
			array(
				'id'            => $args['id'],
				'name'          => $args['name'],
				'orderIndex'    => $args['orderIndex'],
				'storeInstance' => $args['storeInstance'],
				'styles'        => array(
					$elements->style(
						array(
							'attrName'   => 'module',
							'styleProps' => array(
								'disabledOn' => array(
									'disabledModuleVisibility' => $args['settings']['disabledModuleVisibility'] ?? null,
								),
							),
						)
					),
					$elements->style(
						array(
							'attrName' => 'lottie',
						)
					),
				),
			)
		);
	}

	/**
	 * Render module script data.
	 */
	public static function module_script_data( array $args ) {
		$elements = $args['elements'];

		// Element Script Data Options.
		$elements->script_data(
			array(
				'attrName' => 'module',
			)
		);
	}

	/**
	 * Render module classnames.
	 */
	public static function module_classnames( array $args ) {
		$classnames_instance = $args['classnamesInstance'];
		$attrs               = $args['attrs'];

		// Module.
		$classnames_instance->add(
			ElementClassnames::classnames(
				array(
					'attrs' => $attrs['module']['decoration'] ?? array(),
				)
			)
		);
	}

	/**
	 * Render module HTML output.
	 */
	public static function render_callback( array $attrs, $content, \WP_Block $block, object $elements ) {

		// $module_inner = HTMLUtility::render(
		// array(
		// 'tag'               => 'div',
		// 'attributes'        => array(
		// 'class' => 'et_pb_image_wrap',
		// ),
		// 'childrenSanitizer' => 'et_core_esc_previously',
		// 'children'          => '',
		// )
		// );

		// // This are the module elements that will be rendered in the frontend.
		// $module_elements = $elements->style_components(
		// array(
		// 'attrName' => 'module',
		// )
		// );

		$lottie_atts = $attrs['lottie']['innerContent']['desktop']['value'] ?? array();

		$mergedAttrs = \array_merge(
			$lottie_atts,
			array(
				'animateonscroll' => $lottie_atts['animateonscroll'] !== 'off',
				'align'           => 'none', // TODO:
				'autoplay'        => $lottie_atts['autoplay'] !== 'off',
				'background'      => 'transparent', // TODO:
				'controls'        => $lottie_atts['controls'] !== 'off',
				'direction'       => $lottie_atts['reverse'] !== 'off' ? '-1' : '1',
				'id'              => $block->parsed_block['id'],
				'loop'            => $lottie_atts['loop'] !== 'off',
				'mode'            => $lottie_atts['mode'] !== 'off' ? 'bounce' : 'normal',
				'playonvisible'   => $lottie_atts['playonvisible'] !== 'off',
				'subframe'        => $lottie_atts['subframe'] !== 'off',
				'target'          => $lottie_atts['url_new_window'] !== 'off' ? '_blank' : '_self',
				'objectfit'       => $lottie_atts['objectfit'],
				'hover'           => $lottie_atts['hover'] !== 'off',
				'playonclick'     => $lottie_atts['playonclick'] !== 'off' && ! \filter_var( $lottie_atts['url'], FILTER_VALIDATE_URL ),
				'once'            => $lottie_atts['once'] !== 'off',
				'width_unit'      => 'px', // TODO:
				'height_unit'     => 'px', // TODO:
			),
		);

		// This are the children of the module container, which are the module elements and the module inner.
		$module_container_children = render_shortcode( $mergedAttrs ); // $module_elements . $module_inner;

		return Module::render(
			array(
				// FE only.
				'orderIndex'          => $block->parsed_block['orderIndex'],
				'storeInstance'       => $block->parsed_block['storeInstance'],

				// VB equivalent.
				'attrs'               => $attrs,
				'elements'            => $elements,
				'id'                  => $block->parsed_block['id'],
				'moduleClassName'     => 'am-lottieplayer-module',
				'name'                => $block->block_type->name,
				'classnamesFunction'  => array( self::class, 'module_classnames' ),
				'moduleCategory'      => $block->block_type->category,
				'stylesComponent'     => array( self::class, 'module_styles' ),
				'scriptDataComponent' => array( self::class, 'module_script_data' ),
				'children'            => $module_container_children,
			)
		);
	}
}
