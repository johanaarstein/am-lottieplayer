<?php
namespace AAMD_Lottie;

\defined( 'ABSPATH' ) || exit;

use ET\Builder\Framework\DependencyManagement\Interfaces\DependencyInterface;
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

		add_filter( 'ajax_query_attachments_args', array( $this, 'expand_lottie_attachment_query' ) );
		add_filter( 'rest_attachment_query', array( $this, 'expand_lottie_attachment_query' ) );
	}

	/**
	 * Register module.
	 */
	public static function register_module() {
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
	 * Normalize a media-library mime query into individual type strings.
	 *
	 * @param mixed $mime Mime query from WP_Query / REST.
	 * @return string[]
	 */
	private function _normalize_mime_query( $mime ) {
		if ( is_array( $mime ) ) {
			$values = array();
			foreach ( $mime as $item ) {
				$values = array_merge( $values, $this->_normalize_mime_query( $item ) );
			}
			return array_values( array_filter( $values ) );
		}

		if ( ! is_string( $mime ) || $mime === '' ) {
			return array();
		}

		return array_values(
			array_filter(
				array_map( 'trim', explode( ',', $mime ) )
			)
		);
	}

	/**
	 * Whether this attachment query is a Lottie / JSON media picker.
	 *
	 * @param mixed $mime Mime query from WP_Query / REST.
	 */
	private function _is_lottie_mime_query( $mime ) {
		foreach ( $this->_normalize_mime_query( $mime ) as $value ) {
			$value = strtolower( $value );
			if (
				$value === 'json' ||
				str_contains( $value, 'json' ) ||
				str_contains( $value, 'lottie' )
			) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Expand Divi 5 JSON media queries so JSON and .lottie files both appear.
	 *
	 * @param array $args Attachment query args.
	 * @return array
	 */
	public function expand_lottie_attachment_query( array $args ) {
		if (
			! $this->_is_lottie_mime_query( $args['post_mime_type'] ?? '' ) ||
			/**
			 * Divi creates as comma separated list of mimetypes.
			 * By checking is_array we don't affect the behavior
			 * of Combine/Convert – which also utilizes wp.media.
			 * */
			is_array( $args['post_mime_type'] )
		) {
			return $args;
		}

		/** @var Media $aamd_lottie_media */
		global $aamd_lottie_media;

		$args['post_mime_type'] = $aamd_lottie_media->lottie_mime_types();

		return $args;
	}

	/**
	 * Render module HTML output.
	 */
	public static function render_callback( array $attrs, $content, \WP_Block $block, object $elements ) {

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

		$dotlottie_player = render_shortcode( $mergedAttrs );

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
				'children'            => $dotlottie_player,
			)
		);
	}
}
