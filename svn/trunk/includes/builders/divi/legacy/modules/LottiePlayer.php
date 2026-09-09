<?php
namespace AAMD_Lottie;

\defined( 'ABSPATH' ) || exit;

use function AAMD_Lottie\Utility\get_asset;
use function AAMD_Lottie\Utility\render_shortcode;

class ET_Builder_Module_LottiePlayer extends \ET_Builder_Module {

	/** Load customized svg icon and use it on builder as module icon. */
	public function init() {

		$this->name       = esc_html__( 'AM Lottie', TEXT_DOMAIN );
		$this->plural     = esc_html__( 'AM Lotties', TEXT_DOMAIN );
		$this->slug       = 'et_pb_lottieplayer';
		$this->vb_support = 'on';
		$this->icon_path  = get_asset( 'divi-icon.svg' );

		$this->settings_modal_toggles = array(
			'general'    => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Animation', TEXT_DOMAIN ),
					'link'         => et_builder_i18n( 'Link' ),
				),
			),
			'advanced'   => array(
				'toggles' => array(
					'overlay'   => et_builder_i18n( 'Overlay' ),
					'alignment' => esc_html__( 'Alignment', TEXT_DOMAIN ),
					'width'     => array(
						'title'    => et_builder_i18n( 'Sizing' ),
						'priority' => 65,
					),
				),
			),
			'custom_css' => array(
				'toggles' => array(
					'animation'  => array(
						'title'    => esc_html__( 'Animation', TEXT_DOMAIN ),
						'priority' => 90,
					),
					'attributes' => array(
						'title'    => esc_html__( 'Attributes', TEXT_DOMAIN ),
						'priority' => 95,
					),
				),
			),
		);

		$this->advanced_fields = array(
			'margin_padding' => array(
				'css' => array(
					'important' => array( 'custom_margin' ),
				),
			),
			'borders'        => array(
				'default' => array(
					'css' => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .et_pb_image_wrap',
							'border_styles' => '%%order_class%% .et_pb_image_wrap',
						),
					),
				),
			),
			'box_shadow'     => array(
				'default' => array(
					'css' => array(
						'main'    => '%%order_class%% .et_pb_image_wrap',
						'overlay' => 'inset',
					),
				),
			),
			'max_width'      => array(
				'options' => array(
					'width'     => array(
						'depends_show_if' => 'off',
					),
					'max_width' => array(
						'depends_show_if' => 'off',
					),
				),
			),
			'height'         => array(
				'css' => array(
					'main' => '%%order_class%% .et_pb_image_wrap dotlottie-player',
				),
			),
			'fonts'          => false,
			'text'           => false,
			'button'         => false,
			'link_options'   => false,
		);
	}

	public function get_fields() {
		/** @var Media $aamd_lottie_media */
		global $aamd_lottie_media;
		global $pro_link;
		global $pro_feature;

		$fields = array(
			'src'               => array(
				'label'              => esc_html__( 'AM Lottie', TEXT_DOMAIN ),
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'data_type'          => array( 'application/zip', 'application/zip+dotlottie', 'application/json', 'text/plain' ),
				'upload_button_text' => esc_attr__( 'Use animation', TEXT_DOMAIN ),
				'choose_text'        => esc_attr__( 'Choose a Lottie JSON or a dotLottie', TEXT_DOMAIN ),
				'update_text'        => esc_attr__( 'Set As Lottie', TEXT_DOMAIN ),
				'hide_metadata'      => true,
				'affects'            => array( 'description' ),
				'description'        => esc_html__( 'Upload your desired animation in Lottie JSON format, dotLottie format, or type in the URL to the Lottie you would like to display', TEXT_DOMAIN ),
				'toggle_slug'        => 'main_content',
				'mobile_options'     => true,
				'hover'              => 'tabs',
				'default'            => esc_url( $aamd_lottie_media->get_default_file() ),
			),
			'description'       => array(
				'label'           => esc_html__( 'Animation Alternative Text', TEXT_DOMAIN ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'depends_show_if' => 'on',
				'depends_on'      => array( 'src' ),
				'description'     => esc_html__( 'This defines the HTML ALT text. A short description of your animation can be placed here. Helpful for screen readers.', TEXT_DOMAIN ),
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'attributes',
				'dynamic_content' => 'text',
			),
			'url'               => array(
				'label'           => esc_html__( 'Animation Link URL', TEXT_DOMAIN ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'depends_show_if' => 'off',
				'description'     => esc_html__( 'If you would like your Lottie to be a link, input your destination URL here. No link will be created if this field is left blank.', TEXT_DOMAIN ),
				'toggle_slug'     => 'link',
				'dynamic_content' => 'url',
			),
			'url_new_window'    => array(
				'label'            => esc_html__( 'Animation Link Target', TEXT_DOMAIN ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'In The Same Window', TEXT_DOMAIN ),
					'on'  => esc_html__( 'In The New Tab', TEXT_DOMAIN ),
				),
				'default_on_front' => 'off',
				'depends_show_if'  => 'off',
				'toggle_slug'      => 'link',
				'description'      => esc_html__( 'Here you can choose whether or not your link opens in a new window', TEXT_DOMAIN ),
			),
			'show_bottom_space' => array(
				'label'            => esc_html__( 'Show Space Below The Animation', TEXT_DOMAIN ),
				'type'             => 'yes_no_button',
				'option_category'  => 'layout',
				'options'          => array(
					'on'  => et_builder_i18n( 'Yes' ),
					'off' => et_builder_i18n( 'No' ),
				),
				'default_on_front' => 'on',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'margin_padding',
				'description'      => esc_html__( 'Here you can choose whether or not the animation should have a space below it.', TEXT_DOMAIN ),
				'mobile_options'   => true,
			),
			'force_fullwidth'   => array(
				'label'            => esc_html__( 'Force Fullwidth', TEXT_DOMAIN ),
				'description'      => esc_html__( "When enabled, this will force your animation to extend 100% of the width of the column it's in.", TEXT_DOMAIN ),
				'type'             => 'yes_no_button',
				'option_category'  => 'layout',
				'options'          => array(
					'off' => et_builder_i18n( 'No' ),
					'on'  => et_builder_i18n( 'Yes' ),
				),
				'default_on_front' => 'off',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'width',
				'affects'          => array(
					'max_width',
					'width',
				),
			),
			'controls'          => array(
				'label'            => esc_html__( 'Show controls', TEXT_DOMAIN ),
				'description'      => esc_html__( 'Show or hide controls.', TEXT_DOMAIN ),
				'type'             => 'yes_no_button',
				'option_category'  => 'basic_option',
				'options'          => array(
					'off' => et_builder_i18n( 'No' ),
					'on'  => et_builder_i18n( 'Yes' ),
				),
				'default_on_front' => 'on',
				'toggle_slug'      => 'main_content',
			),
			'autoplay'          => array(
				'label'            => esc_html__( 'Autoplay', TEXT_DOMAIN ),
				'description'      => esc_html__( 'Control whether the animation plays on page load or not.', TEXT_DOMAIN ),
				'type'             => 'yes_no_button',
				'option_category'  => 'basic_option',
				'options'          => array(
					'off' => et_builder_i18n( 'No' ),
					'on'  => et_builder_i18n( 'Yes' ),
				),
				'default_on_front' => 'off',
				'toggle_slug'      => 'main_content',
				'condition'        => array(
					'animateonscroll' => 'off',
				),
			),
			'loop'              => array(
				'label'            => esc_html__( 'Loop', TEXT_DOMAIN ),
				'description'      => esc_html__( 'Loop the animation.', TEXT_DOMAIN ),
				'type'             => 'yes_no_button',
				'option_category'  => 'basic_option',
				'options'          => array(
					'off' => et_builder_i18n( 'No' ),
					'on'  => et_builder_i18n( 'Yes' ),
				),
				'default_on_front' => 'off',
				'toggle_slug'      => 'main_content',
				'condition'        => array(
					'animateonscroll' => 'off',
				),
			),
			'mode'              => array(
				'label'            => $pro_feature . esc_html__( 'Boomerang', TEXT_DOMAIN ),
				'type'             => 'yes_no_button',
				'description'      => $pro_link,
				'option_category'  => 'basic_option',
				'options'          => array(
					'off' => et_builder_i18n( 'No' ),
					'on'  => et_builder_i18n( 'Yes' ),
				),
				'default_on_front' => 'off',
				'toggle_slug'      => 'main_content',
				'condition'        => array(
					'animateonscroll' => 'off',
				),
				'readonly'         => ! AAMD_LOTTIE_IS_PRO,
			),
			'reverse'           => array(
				'label'            => esc_html__( 'Reverse', TEXT_DOMAIN ),
				'description'      => esc_html__( 'Reverse the animation.', TEXT_DOMAIN ),
				'type'             => 'yes_no_button',
				'option_category'  => 'basic_option',
				'options'          => array(
					'off' => et_builder_i18n( 'No' ),
					'on'  => et_builder_i18n( 'Yes' ),
				),
				'default_on_front' => 'off',
				'toggle_slug'      => 'main_content',
				'condition'        => array(
					'animateonscroll' => 'off',
				),
			),
			'subframe'          => array(
				'label'            => esc_html__( 'Subframe', TEXT_DOMAIN ),
				'description'      => esc_html__( 'Enabling this can sometimes reduce flicker', TEXT_DOMAIN ),
				'type'             => 'yes_no_button',
				'option_category'  => 'basic_option',
				'options'          => array(
					'off' => et_builder_i18n( 'No' ),
					'on'  => et_builder_i18n( 'Yes' ),
				),
				'default_on_front' => 'on',
				'toggle_slug'      => 'main_content',
			),
			'speed'             => array(
				'label'          => esc_html__( 'Playback speed', TEXT_DOMAIN ),
				'type'           => 'range',
				'default'        => '1',
				'range_settings' => array(
					'max'  => '10',
					'step' => '0.1',
				),
				'toggle_slug'    => 'main_content',
				'condition'      => array(
					'animateonscroll' => 'off',
				),
			),
			'intermission'      => array(
				'label'          => esc_html__( 'Intermission', TEXT_DOMAIN ),
				'description'    => esc_html__( 'Pause between loops, in miliseconds. 1s = 1000', TEXT_DOMAIN ),
				'type'           => 'range',
				'range_settings' => array(
					'max'  => '5000',
					'step' => '100',
				),
				'toggle_slug'    => 'main_content',
				'condition'      => array(
					'loop' => 'on',
				),
			),
			'segment_in'        => array(
				'label'       => $pro_feature . esc_html__( 'Choose where to start', TEXT_DOMAIN ),
				'description' => $pro_link,
				'type'        => 'range',
				'default'     => '1',
				'toggle_slug' => 'main_content',
				'readonly'    => ! AAMD_LOTTIE_IS_PRO,
			),
			'segment_out'       => array(
				'label'       => $pro_feature . esc_html__( 'And where to end', TEXT_DOMAIN ),
				'description' => $pro_link,
				'type'        => 'range',
				'default'     => '',
				'toggle_slug' => 'main_content',
				'readonly'    => ! AAMD_LOTTIE_IS_PRO,
			),
			'animateonscroll'   => array(
				'label'            => $pro_feature . esc_html__( 'Animate on scroll', TEXT_DOMAIN ),
				'description'      => esc_html__( 'Make the animation play only when scrolling, relative to the speed and direction of the scroll', TEXT_DOMAIN ) . $pro_link,
				'type'             => 'yes_no_button',
				'option_category'  => 'basic_option',
				'options'          => array(
					'off' => et_builder_i18n( 'No' ),
					'on'  => et_builder_i18n( 'Yes' ),
				),
				'default_on_front' => 'off',
				'toggle_slug'      => 'main_content',
				'readonly'         => ! AAMD_LOTTIE_IS_PRO,
			),
			'playonclick'       => array(
				'label'            => esc_html__( 'Play on click', TEXT_DOMAIN ),
				'type'             => 'yes_no_button',
				'option_category'  => 'basic_option',
				'options'          => array(
					'off' => et_builder_i18n( 'No' ),
					'on'  => et_builder_i18n( 'Yes' ),
				),
				'affects'          => array(
					'selector',
					'exclude_selector',
				),
				'default_on_front' => 'off',
				'toggle_slug'      => 'main_content',
			),
			'hover'             => array(
				'label'            => esc_html__( 'Play on mouseover', TEXT_DOMAIN ),
				'type'             => 'yes_no_button',
				'option_category'  => 'basic_option',
				'options'          => array(
					'off' => et_builder_i18n( 'No' ),
					'on'  => et_builder_i18n( 'Yes' ),
				),
				'affects'          => array(
					'mouseout',
					'selector',
					'exclude_selector',
				),
				'default_on_front' => 'off',
				'toggle_slug'      => 'main_content',
			),
			'mouseout'          => array(
				'label'       => esc_html__( 'On mouseout', TEXT_DOMAIN ),
				'type'        => 'select',
				'options'     => array(
					'void'    => esc_html__( 'No event', TEXT_DOMAIN ),
					'stop'    => esc_html__( 'Stop', TEXT_DOMAIN ),
					'pause'   => esc_html__( 'Pause', TEXT_DOMAIN ),
					'reverse' => esc_html__( 'Reverse', TEXT_DOMAIN ),
				),
				'default'     => 'stop',
				'condition'   => array(
					'hover' => 'on',
				),
				'toggle_slug' => 'main_content',
			),
			'selector'          => array(
				'label'           => $pro_feature . esc_html__( 'Trigger element', TEXT_DOMAIN ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Anchor tag (id) for an element you want to trigger the animation, either by hover or click.', TEXT_DOMAIN ) . $pro_link,
				'toggle_slug'     => 'main_content',
				'readonly'        => ! AAMD_LOTTIE_IS_PRO,
			),
			'exclude_selector'  => array(
				'label'            => $pro_feature . esc_html__( 'Apply interaction only to trigger element', TEXT_DOMAIN ),
				'type'             => 'yes_no_button',
				'description'      => $pro_link,
				'option_category'  => 'basic_option',
				'options'          => array(
					'off' => et_builder_i18n( 'No' ),
					'on'  => et_builder_i18n( 'Yes' ),
				),
				'default_on_front' => 'off',
				'toggle_slug'      => 'main_content',
				'readonly'         => ! AAMD_LOTTIE_IS_PRO,
			),
			'playonvisible'     => array(
				'label'            => esc_html__( 'Play on scroll, when visible in viewport', TEXT_DOMAIN ),
				'type'             => 'yes_no_button',
				'options_category' => 'basic_option',
				'options'          => array(
					'off' => et_builder_i18n( 'No' ),
					'on'  => et_builder_i18n( 'Yes' ),
				),
				'affects'          => array(
					'delay',
					'once',
				),
				'default_on_front' => 'off',
				'toggle_slug'      => 'main_content',
			),
			'delay'             => array(
				'label'           => esc_html__( 'Delay, in milliseconds', TEXT_DOMAIN ),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
				'type'            => 'range',
				'default'         => '0',
				'range_settings'  => array(
					'max'  => '5000',
					'step' => '1',
				),
				'condition'       => array(
					'playonvisible' => 'on',
				),
			),
			'once'              => array(
				'label'            => esc_html__( 'Play only once', TEXT_DOMAIN ),
				'type'             => 'yes_no_button',
				'options_category' => 'basic_option',
				'options'          => array(
					'off' => et_builder_i18n( 'No' ),
					'on'  => et_builder_i18n( 'Yes' ),
				),
				'condition'        => array(
					'playonvisible' => 'on',
				),
				'default_on_front' => 'off',
			),
			'object_fit'        => array(
				'label'           => esc_html__( 'Object Fit', TEXT_DOMAIN ),
				'description'     => esc_html__( 'Choose how to scale the animation', TEXT_DOMAIN ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => array(
					'contain' => esc_html__( 'Contain', TEXT_DOMAIN ),
					'cover'   => esc_html__( 'Cover', TEXT_DOMAIN ),
					'fill'    => esc_html__( 'Fill', TEXT_DOMAIN ),
					'none'    => esc_html__( 'None', TEXT_DOMAIN ),
				),
				'default'         => 'contain',
				'toggle_slug'     => 'main_content',
			),
			'renderer'          => array(
				'label'           => $pro_feature . esc_html__( 'Renderer', TEXT_DOMAIN ),
				'description'     => esc_html__( 'Choose renderer', TEXT_DOMAIN ) . $pro_link,
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'svg'    => esc_html__( 'SVG', TEXT_DOMAIN ),
					'canvas' => esc_html__( 'Canvas', TEXT_DOMAIN ),
				),
				'default'         => 'svg',
				'toggle_slug'     => 'main_content',
				'readonly'        => ! AAMD_LOTTIE_IS_PRO,
			),
		);

		return $fields;
	}

	public function render( $attrs = array(), $content = null, $render_slug = '' ) {

		$mergedAttrs = \array_merge(
			$attrs,
			$this->props,
			array(
				'animateonscroll' => $this->props['animateonscroll'] !== 'off',
				'align'           => 'none', // TODO:
				'autoplay'        => $this->props['autoplay'] !== 'off',
				'background'      => 'transparent', // TODO:
				'class'           => $this->module_classname( $render_slug ),
				'controls'        => $this->props['controls'] !== 'off',
				'direction'       => $this->props['reverse'] !== 'off' ? '-1' : '1',
				'id'              => $this->module_id(),
				'loop'            => $this->props['loop'] !== 'off',
				'mode'            => $this->props['mode'] !== 'off' ? 'bounce' : 'normal',
				'playonvisible'   => $this->props['playonvisible'] !== 'off',
				'subframe'        => $this->props['subframe'] !== 'off',
				'target'          => $this->props['url_new_window'] !== 'off' ? '_blank' : '_self',
				'objectfit'       => $this->props['object_fit'],
				'hover'           => $this->props['hover'] !== 'off',
				'playonclick'     => $this->props['playonclick'] !== 'off' && ! \filter_var( $this->props['url'], FILTER_VALIDATE_URL ),
				'once'            => $this->props['once'] !== 'off',
				'width_unit'      => 'px', // TODO:
				'height_unit'     => 'px', // TODO:
			),
		);

		return render_shortcode( $mergedAttrs );
	}
}

new ET_Builder_Module_LottiePlayer();
