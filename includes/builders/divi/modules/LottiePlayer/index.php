<?php
namespace AAMD_Lottie;

\defined( 'ABSPATH' ) || exit;

use function AAMD_Lottie\Utility\render_lottieplayer;

if ( \class_exists( '\ET_Builder_Module' ) ) {

	class ET_Builder_Module_LottiePlayer extends \ET_Builder_Module {

		public function init() {
			$this->name       = esc_html__( 'AM Lottie', 'am-lottieplayer' );
			$this->plural     = esc_html__( 'AM Lotties', 'am-lottieplayer' );
			$this->slug       = 'et_pb_lottieplayer';
			$this->vb_support = 'on';
			$this->icon_path  = AAMD_LOTTIE_PATH . 'assets/divi-icon.svg';

			$this->settings_modal_toggles = array(
				'general'    => array(
					'toggles' => array(
						'main_content' => esc_html__( 'Animation', 'et_builder' ),
						'link'         => et_builder_i18n( 'Link' ),
					),
				),
				'advanced'   => array(
					'toggles' => array(
						'overlay'   => et_builder_i18n( 'Overlay' ),
						'alignment' => esc_html__( 'Alignment', 'et_builder' ),
						'width'     => array(
							'title'    => et_builder_i18n( 'Sizing' ),
							'priority' => 65,
						),
					),
				),
				'custom_css' => array(
					'toggles' => array(
						'animation'  => array(
							'title'    => esc_html__( 'Animation', 'et_builder' ),
							'priority' => 90,
						),
						'attributes' => array(
							'title'    => esc_html__( 'Attributes', 'et_builder' ),
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
			global $aamd_lottie_media;
			$proLink = esc_html__( 'This feature will only work in the premium version.', 'am-lottieplayer' ) . ' <a href="' . esc_url( 'https://www.aarstein.media/en/am-lottieplayer/pro', 'am-lottieplayer' ) . '" target="_blank" rel="noreferrer">' . esc_html__( 'Read about additional features in AM LottiePlayer PRO', 'am-lottieplayer' ) . '<span class="dashicons dashicons-external" style="font-size: 1em;"></span></a>';

			$fields = array(
				'src'               => array(
					'label'              => esc_html__( 'AM Lottie', 'am-lottieplayer' ),
					'type'               => 'upload',
					'option_category'    => 'basic_option',
					'data_type'          => array( 'application/zip', 'application/json', 'text/plain' ),
					'upload_button_text' => esc_attr__( 'Use animation', 'am-lottieplayer' ),
					'choose_text'        => esc_attr__( 'Choose a Lottie JSON or a dotLottie', 'am-lottieplayer' ),
					'update_text'        => esc_attr__( 'Set As Lottie', 'am-lottieplayer' ),
					'hide_metadata'      => true,
					'affects'            => array( 'alt' ),
					'description'        => esc_html__( 'Upload your desired animation in Lottie JSON format, dotLottie format, or type in the URL to the Lottie you would like to display', 'am-lottieplayer' ),
					'toggle_slug'        => 'main_content',
					'mobile_options'     => true,
					'hover'              => 'tabs',
					'default'            => esc_url( $aamd_lottie_media->get_default_file() ),
				),
				'alt'               => array(
					'label'           => esc_html__( 'Animation Alternative Text', 'am-lottieplayer' ),
					'type'            => 'text',
					'option_category' => 'basic_option',
					'depends_show_if' => 'on',
					'depends_on'      => array( 'src' ),
					'description'     => esc_html__( 'This defines the HTML ALT text. A short description of your animation can be placed here. Helpful for screen readers.', 'am-lottieplayer' ),
					'tab_slug'        => 'custom_css',
					'toggle_slug'     => 'attributes',
					'dynamic_content' => 'text',
				),
				'url'               => array(
					'label'           => esc_html__( 'Animation Link URL', 'am-lottieplayer' ),
					'type'            => 'text',
					'option_category' => 'basic_option',
					'depends_show_if' => 'off',
					'description'     => esc_html__( 'If you would like your Lottie to be a link, input your destination URL here. No link will be created if this field is left blank.', 'am-lottieplayer' ),
					'toggle_slug'     => 'link',
					'dynamic_content' => 'url',
				),
				'url_new_window'    => array(
					'label'            => esc_html__( 'Animation Link Target', 'am-lottieplayer' ),
					'type'             => 'select',
					'option_category'  => 'configuration',
					'options'          => array(
						'off' => esc_html__( 'In The Same Window', 'et_builder' ),
						'on'  => esc_html__( 'In The New Tab', 'et_builder' ),
					),
					'default_on_front' => 'off',
					'depends_show_if'  => 'off',
					'toggle_slug'      => 'link',
					'description'      => esc_html__( 'Here you can choose whether or not your link opens in a new window', 'et_builder' ),
				),
				'show_bottom_space' => array(
					'label'            => esc_html__( 'Show Space Below The Animation', 'am-lottieplayer' ),
					'type'             => 'yes_no_button',
					'option_category'  => 'layout',
					'options'          => array(
						'on'  => et_builder_i18n( 'Yes' ),
						'off' => et_builder_i18n( 'No' ),
					),
					'default_on_front' => 'on',
					'tab_slug'         => 'advanced',
					'toggle_slug'      => 'margin_padding',
					'description'      => esc_html__( 'Here you can choose whether or not the animation should have a space below it.', 'am-lottieplayer' ),
					'mobile_options'   => true,
				),
				'force_fullwidth'   => array(
					'label'            => esc_html__( 'Force Fullwidth', 'et_builder' ),
					'description'      => esc_html__( "When enabled, this will force your animation to extend 100% of the width of the column it's in.", 'am-lottieplayer' ),
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
					'label'            => esc_html__( 'Show controls', 'am-lottieplayer' ),
					'description'      => esc_html__( 'Show or hide controls.', 'am-lottieplayer' ),
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
					'label'            => esc_html__( 'Autoplay', 'am-lottieplayer' ),
					'description'      => esc_html__( 'Control whether the animation plays on page load or not.', 'am-lottieplayer' ),
					'type'             => 'yes_no_button',
					'option_category'  => 'basic_option',
					'options'          => array(
						'off' => et_builder_i18n( 'No' ),
						'on'  => et_builder_i18n( 'Yes' ),
					),
					'default_on_front' => 'off',
					'toggle_slug'      => 'main_content',
				),
				'loop'              => array(
					'label'            => esc_html__( 'Loop', 'am-lottieplayer' ),
					'description'      => esc_html__( 'Loop the animation.', 'am-lottieplayer' ),
					'type'             => 'yes_no_button',
					'option_category'  => 'basic_option',
					'options'          => array(
						'off' => et_builder_i18n( 'No' ),
						'on'  => et_builder_i18n( 'Yes' ),
					),
					'default_on_front' => 'off',
					'toggle_slug'      => 'main_content',
				),
				'mode'              => array(
					'label'            => 'Pro Feature: ' . esc_html__( 'Boomerang', 'am-lottieplayer' ),
					'type'             => 'yes_no_button',
					'description'      => $proLink,
					'option_category'  => 'basic_option',
					'options'          => array(
						'off' => et_builder_i18n( 'No' ),
						'on'  => et_builder_i18n( 'Yes' ),
					),
					'default_on_front' => 'off',
					'toggle_slug'      => 'main_content',
				),
				'reverse'           => array(
					'label'            => esc_html__( 'Reverse', 'am-lottieplayer' ),
					'description'      => esc_html__( 'Reverse the animation.', 'am-lottieplayer' ),
					'type'             => 'yes_no_button',
					'option_category'  => 'basic_option',
					'options'          => array(
						'off' => et_builder_i18n( 'No' ),
						'on'  => et_builder_i18n( 'Yes' ),
					),
					'default_on_front' => 'off',
					'toggle_slug'      => 'main_content',
				),
				'subframe'          => array(
					'label'            => esc_html__( 'Subframe', 'am-lottieplayer' ),
					'description'      => esc_html__( 'Enabling this can sometimes reduce flicker', 'am-lottieplayer' ),
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
					'label'          => __( 'Playback speed', 'am-lottieplayer' ),
					'type'           => 'range',
					'default'        => '1',
					'range_settings' => array(
						'max'  => '10',
						'step' => '0.1',
					),
					'toggle_slug'    => 'main_content',
				),
				'intermission'      => array(
					'label'          => __( 'Intermission', 'am-lottieplayer' ),
					'description'    => esc_html__( 'Pause between loops, in miliseconds. 1s = 1000', 'am-lottieplayer' ),
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
					'label'       => 'Pro Feature: ' . __( 'Choose where to start', 'am-lottieplayer' ),
					'description' => $proLink,
					'type'        => 'range',
					'default'     => '1',
					'toggle_slug' => 'main_content',
				),
				'segment_out'       => array(
					'label'       => 'Pro Feature: ' . __( 'And where to end', 'am-lottieplayer' ),
					'description' => $proLink,
					'type'        => 'range',
					'default'     => '',
					'toggle_slug' => 'main_content',
				),
				'animate_on_scroll' => array(
					'label'            => 'Pro Feature: ' . esc_html__( 'Animate on scroll', 'am-lottieplayer' ),
					'description'      => $proLink,
					'type'             => 'yes_no_button',
					'option_category'  => 'basic_option',
					'options'          => array(
						'off' => et_builder_i18n( 'No' ),
						'on'  => et_builder_i18n( 'Yes' ),
					),
					'default_on_front' => 'off',
					'toggle_slug'      => 'main_content',
				),
				'onclick'           => array(
					'label'            => __( 'Play on click', 'am-lottieplayer' ),
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
				'onmouseover'       => array(
					'label'            => __( 'Play on mouseover', 'am-lottieplayer' ),
					'type'             => 'yes_no_button',
					'option_category'  => 'basic_option',
					'options'          => array(
						'off' => et_builder_i18n( 'No' ),
						'on'  => et_builder_i18n( 'Yes' ),
					),
					'affects'          => array(
						'onmouseout',
						'selector',
						'exclude_selector',
					),
					'default_on_front' => 'off',
					'toggle_slug'      => 'main_content',
				),
				'onmouseout'        => array(
					'label'       => __( 'On mouseout', 'am-lottieplayer' ),
					'type'        => 'select',
					'options'     => array(
						'void'    => __( 'No event', 'am-lottieplayer' ),
						'stop'    => __( 'Stop', 'am-lottieplayer' ),
						'pause'   => __( 'Pause', 'am-lottieplayer' ),
						'reverse' => __( 'Reverse', 'am-lottieplayer' ),
					),
					'default'     => 'stop',
					'condition'   => array(
						'onmouseover' => 'on',
					),
					'toggle_slug' => 'main_content',
				),
				'selector'          => array(
					'label'           => 'Pro Feature: ' . esc_html__( 'Trigger element', 'am-lottieplayer' ),
					'type'            => 'text',
					'option_category' => 'basic_option',
					'description'     => $proLink,
					'toggle_slug'     => 'main_content',
				),
				'exclude_selector'  => array(
					'label'            => 'Pro Feature: ' . esc_html__( 'Apply interaction only to trigger element', 'am-lottieplayer' ),
					'type'             => 'yes_no_button',
					'description'      => $proLink,
					'option_category'  => 'basic_option',
					'options'          => array(
						'off' => et_builder_i18n( 'No' ),
						'on'  => et_builder_i18n( 'Yes' ),
					),
					'default_on_front' => 'off',
					'toggle_slug'      => 'main_content',
				),
				'scroll'            => array(
					'label'            => esc_html__( 'Play on scroll, when visible in viewport', 'am-lottieplayer' ),
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
					'label'           => esc_html__( 'Delay, in 10th of a second', 'am-lottieplayer' ),
					'option_category' => 'basic_option',
					'toggle_slug'     => 'main_content',
					'type'            => 'range',
					'default'         => '1',
					'range_settings'  => array(
						'max'  => '50',
						'step' => '1',
					),
					'condition'       => array(
						'scroll' => 'on',
					),
				),
				'once'              => array(
					'label'            => esc_html__( 'Play only once', 'am-lottieplayer' ),
					'type'             => 'yes_no_button',
					'options_category' => 'basic_option',
					'options'          => array(
						'off' => et_builder_i18n( 'No' ),
						'on'  => et_builder_i18n( 'Yes' ),
					),
					'condition'        => array(
						'scroll' => 'on',
					),
					'default_on_front' => 'off',
				),
				'object_fit'        => array(
					'label'           => esc_html__( 'Object Fit', 'am-lottieplayer' ),
					'description'     => esc_html__( 'Choose how to scale the animation', 'am-lottieplayer' ),
					'type'            => 'select',
					'option_category' => 'basic_option',
					'options'         => array(
						'contain' => esc_html__( 'Contain', 'am-lottieplayer' ),
						'cover'   => esc_html__( 'Cover', 'am-lottieplayer' ),
						'fill'    => esc_html__( 'Fill', 'am-lottieplayer' ),
						'none'    => esc_html__( 'None', 'am-lottieplayer' ),
					),
					'default'         => 'contain',
					'toggle_slug'     => 'main_content',
				),
				'renderer'          => array(
					'label'           => 'Pro Feature: ' . esc_html__( 'Renderer', 'am-lottieplayer' ),
					'description'     => $proLink,
					'type'            => 'select',
					'option_category' => 'configuration',
					'options'         => array(
						'svg'    => esc_html__( 'SVG', 'am-lottieplayer' ),
						'canvas' => esc_html__( 'Canvas', 'am-lottieplayer' ),
					),
					'default'         => 'svg',
					'toggle_slug'     => 'main_content',
				),
			);

			return $fields;
		}

		public function render( $attrs = array(), $content = null, $render_slug ) {

			$mergedAttrs = \array_merge(
				$attrs,
				$this->props,
				array(
					'animate_on_scroll' => false, // Pro feature
					'align'             => 'none', // TODO:
					'autoplay'          => $this->props['autoplay'] !== 'off',
					'background'        => 'transparent', // TODO:
					'class'             => $this->module_classname( $render_slug ),
					'controls'          => $this->props['controls'] !== 'off',
					'direction'         => $this->props['reverse'] !== 'off' ? '-1' : '1',
					'id'                => $this->module_id(),
					'loop'              => $this->props['loop'] !== 'off',
					'mode'              => $this->props['mode'] !== 'off' ? 'bounce' : 'normal',
					'scroll'            => $this->props['scroll'] !== 'off',
					'subframe'          => $this->props['subframe'] !== 'off',
					'target'            => $this->props['url_new_window'] !== 'off' ? '_blank' : '_self',
					'objectfit'         => $this->props['object_fit'],
					'onmouseover'       => $this->props['onmouseover'] !== 'off',
					'onclick'           => $this->props['onclick'] !== 'off' && ! \filter_var( $this->props['url'], FILTER_VALIDATE_URL ),
					'once'              => $this->props['once'] !== 'off',
					'width_unit'        => 'px', // TODO:
					'height_unit'       => 'px', // TODO:
				),
			);

			return render_lottieplayer( $mergedAttrs );
		}
	}

	new ET_Builder_Module_LottiePlayer();
}
