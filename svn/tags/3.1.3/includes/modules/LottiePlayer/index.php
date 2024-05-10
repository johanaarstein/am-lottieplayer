<?php
defined('ABSPATH') || exit;

if (class_exists('ET_Builder_Module') && !class_exists('AM_ET_Builder_Module_LottiePlayer')) {
	class AM_ET_Builder_Module_LottiePlayer extends ET_Builder_Module
	{

		public function init()
		{
			$this->name = esc_html__('AM Lottie', 'am-lottieplayer');
			$this->plural = esc_html__('AM Lotties', 'am-lottieplayer');
			$this->slug = 'et_pb_lottieplayer';
			$this->vb_support = 'on';
			$this->icon_path = AM_LOTTIEPLAYER_PATH . 'assets/divi-icon.svg';

			$this->settings_modal_toggles = [
				'general' => [
					'toggles' => [
						'main_content' => esc_html__('Animation', 'et_builder'),
						'link' => et_builder_i18n('Link'),
					],
				],
				'advanced' => [
					'toggles' => [
						'overlay' => et_builder_i18n('Overlay'),
						'alignment' => esc_html__('Alignment', 'et_builder'),
						'width' => [
							'title' => et_builder_i18n('Sizing'),
							'priority' => 65,
						],
					],
				],
				'custom_css' => [
					'toggles' => [
						'animation' => [
							'title' => esc_html__('Animation', 'et_builder'),
							'priority' => 90,
						],
						'attributes' => [
							'title' => esc_html__('Attributes', 'et_builder'),
							'priority' => 95,
						],
					],
				],
			];

			$this->advanced_fields = [
				'margin_padding' => [
					'css' => [
						'important' => ['custom_margin'],
					],
				],
				'borders' => [
					'default' => [
						'css' => [
							'main' => [
								'border_radii' => '%%order_class%% .et_pb_image_wrap',
								'border_styles' => '%%order_class%% .et_pb_image_wrap',
							],
						],
					],
				],
				'box_shadow' => [
					'default' => [
						'css' => [
							'main' => '%%order_class%% .et_pb_image_wrap',
							'overlay' => 'inset',
						],
					],
				],
				'max_width' => [
					'options' => [
						'width' => [
							'depends_show_if' => 'off',
						],
						'max_width' => [
							'depends_show_if' => 'off',
						],
					],
				],
				'height' => [
					'css' => [
						'main' => '%%order_class%% .et_pb_image_wrap dotlottie-player',
					],
				],
				'fonts' => false,
				'text' => false,
				'button' => false,
				'link_options' => false,
			];
		}

		function get_fields()
		{
			$fields = [
				'src' => [
					'label' => esc_html__('AM Lottie', 'am-lottieplayer'),
					'type' => 'upload',
					'option_category' => 'basic_option',
					'data_type' => ['application/zip', 'application/json', 'text/plain'],
					'upload_button_text' => esc_attr__('Use animation', 'am-lottieplayer'),
					'choose_text' => esc_attr__('Choose a Lottie JSON or a dotLottie', 'am-lottieplayer'),
					'update_text'  => esc_attr__('Set As Lottie', 'am-lottieplayer'),
					'hide_metadata' => true,
					'affects' => ['alt'],
					'description' => esc_html__('Upload your desired animation in Lottie JSON format, dotLottie format, or type in the URL to the Lottie you would like to display', 'am-lottieplayer'),
					'toggle_slug' => 'main_content',
					'mobile_options' => true,
					'hover' => 'tabs',
					'default' => esc_url(!is_wp_error(am_lottie_asset()) ? wp_get_attachment_url(am_lottie_asset()) : am_lottie_asset(true)),
				],
				'alt' => [
					'label' => esc_html__('Animation Alternative Text', 'am-lottieplayer'),
					'type' => 'text',
					'option_category' => 'basic_option',
					'depends_show_if' => 'on',
					'depends_on' => ['src'],
					'description' => esc_html__('This defines the HTML ALT text. A short description of your animation can be placed here. Helpful for screen readers.', 'am-lottieplayer'),
					'tab_slug' => 'custom_css',
					'toggle_slug' => 'attributes',
					'dynamic_content' => 'text',
				],
				'url'      => [
					'label'        => esc_html__('Animation Link URL', 'am-lottieplayer'),
					'type' => 'text',
					'option_category' => 'basic_option',
					'depends_show_if' => 'off',
					'description'  => esc_html__('If you would like your Lottie to be a link, input your destination URL here. No link will be created if this field is left blank.', 'am-lottieplayer'),
					'toggle_slug'  => 'link',
					'dynamic_content' => 'url',
				],
				'url_new_window'   => [
					'label' => esc_html__('Animation Link Target', 'am-lottieplayer'),
					'type'  => 'select',
					'option_category'  => 'configuration',
					'options'       => [
						'off' => esc_html__('In The Same Window', 'et_builder'),
						'on'  => esc_html__('In The New Tab', 'et_builder'),
					],
					'default_on_front' => 'off',
					'depends_show_if'  => 'off',
					'toggle_slug'   => 'link',
					'description'   => esc_html__('Here you can choose whether or not your link opens in a new window', 'et_builder'),
				],
				'show_bottom_space'   => [
					'label' => esc_html__('Show Space Below The Animation', 'am-lottieplayer'),
					'type'  => 'yes_no_button',
					'option_category'  => 'layout',
					'options'       => [
						'on'  => et_builder_i18n('Yes'),
						'off' => et_builder_i18n('No'),
					],
					'default_on_front' => 'on',
					'tab_slug'      => 'advanced',
					'toggle_slug'   => 'margin_padding',
					'description'   => esc_html__('Here you can choose whether or not the animation should have a space below it.', 'am-lottieplayer'),
					'mobile_options'   => true,
				],
				'force_fullwidth'  => [
					'label' => esc_html__('Force Fullwidth', 'et_builder'),
					'description'   => esc_html__("When enabled, this will force your animation to extend 100% of the width of the column it's in.", 'am-lottieplayer'),
					'type'  => 'yes_no_button',
					'option_category'  => 'layout',
					'options'       => [
						'off' => et_builder_i18n('No'),
						'on'  => et_builder_i18n('Yes'),
					],
					'default_on_front' => 'off',
					'tab_slug'      => 'advanced',
					'toggle_slug'   => 'width',
					'affects'       => [
						'max_width',
						'width',
					],
				],
				'controls' => [
					'label' => esc_html__('Show controls', 'am-lottieplayer'),
					'description' => esc_html__('Show or hide controls.', 'am-lottieplayer'),
					'type' => 'yes_no_button',
					'option_category' => 'basic_option',
					'options'  => [
						'off' => et_builder_i18n('No'),
						'on'  => et_builder_i18n('Yes'),
					],
					'default_on_front' => 'on',
					'toggle_slug' => 'main_content',
				],
				'autoplay' => [
					'label' => esc_html__('Autoplay', 'am-lottieplayer'),
					'description' => esc_html__('Control whether the animation plays on page load or not.', 'am-lottieplayer'),
					'type' => 'yes_no_button',
					'option_category' => 'basic_option',
					'options'  => [
						'off' => et_builder_i18n('No'),
						'on'  => et_builder_i18n('Yes'),
					],
					'default_on_front' => 'off',
					'toggle_slug' => 'main_content',
				],
				'loop' => [
					'label' => esc_html__('Loop', 'am-lottieplayer'),
					'description' => esc_html__('Loop the animation.', 'am-lottieplayer'),
					'type' => 'yes_no_button',
					'option_category' => 'basic_option',
					'options'  => [
						'off' => et_builder_i18n('No'),
						'on'  => et_builder_i18n('Yes'),
					],
					'default_on_front' => 'off',
					'toggle_slug' => 'main_content',
				],
				'mode' => [
					'label' => esc_html__('Boomerang', 'am-lottieplayer'),
					'type' => 'yes_no_button',
					'option_category' => 'basic_option',
					'options'  => [
						'off' => et_builder_i18n('No'),
						'on'  => et_builder_i18n('Yes'),
					],
					'default_on_front' => 'off',
					'toggle_slug' => 'main_content',
				],
				'reverse' => [
					'label' => esc_html__('Reverse', 'am-lottieplayer'),
					'description' => esc_html__('Reverse the animation.', 'am-lottieplayer'),
					'type' => 'yes_no_button',
					'option_category' => 'basic_option',
					'options'  => [
						'off' => et_builder_i18n('No'),
						'on'  => et_builder_i18n('Yes'),
					],
					'default_on_front' => 'off',
					'toggle_slug' => 'main_content',
				],
				'subframe' => [
					'label' => esc_html__('Subframe', 'am-lottieplayer'),
					'description' => esc_html__('Enabling this can sometimes reduce flicker', 'am-lottieplayer'),
					'type' => 'yes_no_button',
					'option_category' => 'basic_option',
					'options'  => [
						'off' => et_builder_i18n('No'),
						'on'  => et_builder_i18n('Yes'),
					],
					'default_on_front' => 'on',
					'toggle_slug' => 'main_content',
				],
				'speed' => [
					'label' => __('Playback speed', 'am-lottieplayer'),
					'type' => 'range',
					'default' => '1',
					'range_settings' => [
						'max' => '10',
						'step' => '0.1',
					],
					'toggle_slug' => 'main_content',
				],
				'segment_in' => [
					'label' => __('Choose where to start', 'am-lottieplayer'),
					'type' => 'range',
					'default' => '1',
					'toggle_slug' => 'main_content',
				],
				'segment_out' => [
					'label' => __('And where to end', 'am-lottieplayer'),
					'type' => 'range',
					'default' => '',
					'toggle_slug' => 'main_content',
				],
				'onclick' => [
					'label' => __('Play on click', 'am-lottieplayer'),
					'type' => 'yes_no_button',
					'option_category' => 'basic_option',
					'options'  => [
						'off' => et_builder_i18n('No'),
						'on'  => et_builder_i18n('Yes'),
					],
					'affects' => [
						'selector',
						'exclude'
					],
					'default_on_front' => 'off',
					'toggle_slug' => 'main_content',
				],
				'onmouseover' => [
					'label' => __('Play on mouseover', 'am-lottieplayer'),
					'type' => 'yes_no_button',
					'option_category' => 'basic_option',
					'options'  => [
						'off' => et_builder_i18n('No'),
						'on'  => et_builder_i18n('Yes'),
					],
					'affects' => [
						'onmouseout',
						'selector',
						'exclude'
					],
					'default_on_front' => 'off',
					'toggle_slug' => 'main_content',
				],
				'onmouseout' => [
					'label' => __('On mouseout', 'am-lottieplayer'),
					'type' => 'select',
					'options' => [
						'void' => __('No event', 'am-lottieplayer'),
						'stop' => __('Stop', 'am-lottieplayer'),
						'pause' => __('Pause', 'am-lottieplayer'),
						'reverse' => __('Reverse', 'am-lottieplayer')
					],
					'default' => 'stop',
					'condition' => [
						'onmouseover' => 'on',
					],
					'toggle_slug' => 'main_content',
				],
				'selector' => [
					'label' => esc_html__('Trigger element', 'am-lottieplayer'),
					'type' => 'text',
					'option_category' => 'basic_option',
					'description' => esc_html__('Anchor tag (id) for an element you want to trigger the animation, either by hover or click.', 'am-lottieplayer'),
					'toggle_slug' => 'main_content',
				],
				'exclude' => [
					'label' => esc_html__('Apply interaction only to trigger element', 'am-lottieplayer'),
					'type' => 'yes_no_button',
					'option_category' => 'basic_option',
					'options'  => [
						'off' => et_builder_i18n('No'),
						'on'  => et_builder_i18n('Yes'),
					],
					'default_on_front' => 'off',
					'toggle_slug' => 'main_content',
				],
				'scroll' => [
					'label' => esc_html__('Play on scroll, when visible in viewport', 'am-lottieplayer'),
					'type' => 'yes_no_button',
					'options_category' => 'basic_option',
					'options'  => [
						'off' => et_builder_i18n('No'),
						'on'  => et_builder_i18n('Yes'),
					],
					'affects' => [
						'delay',
						'once'
					],
					'default_on_front' => 'off',
					'toggle_slug' => 'main_content',
				],
				'delay' => [
					'label' => esc_html__('Delay, in 10th of a second', 'am-lottieplayer'),
					'option_category' => 'basic_option',
					'toggle_slug' => 'main_content',
					'type' => 'range',
					'default' => '1',
					'range_settings' => [
						'max' => '50',
						'step' => '1',
					],
					'condition' => [
						'scroll' => 'on',
					],
				],
				'once' => [
					'label' => esc_html__('Play only once', 'am-lottieplayer'),
					'type' => 'yes_no_button',
					'options_category' => 'basic_option',
					'options'  => [
						'off' => et_builder_i18n('No'),
						'on'  => et_builder_i18n('Yes'),
					],
					'condition' => [
						'scroll' => 'on'
					],
					'default_on_front' => 'off',
				],
				'object_fit' => [
					'label' => esc_html__('Object Fit', 'am-lottieplayer'),
					'description' => esc_html__('Choose how to scale the animation', 'am-lottieplayer'),
					'type' => 'select',
					'option_category' => 'basic_option',
					'options'  => [
						'contain' => esc_html__('Contain', 'am-lottieplayer'),
						'cover' => esc_html__('Cover', 'am-lottieplayer'),
						'fill' => esc_html__('Fill', 'am-lottieplayer'),
						'none' => esc_html__('None', 'am-lottieplayer'),
					],
					'default' => 'contain',
					'toggle_slug' => 'main_content',
				],
				'renderer' => [
					'label' => esc_html__('Renderer', 'am-lottieplayer'),
					'description' => esc_html__('Choose renderer', 'am-lottieplayer'),
					'type' => 'select',
					'option_category' => 'configuration',
					'options'  => [
						'svg' => esc_html__('SVG', 'am-lottieplayer'),
						'canvas' => esc_html__('Canvas', 'am-lottieplayer'),
					],
					'default' => 'svg',
					'toggle_slug' => 'main_content',
				],
			];

			return $fields;
		}

		public function render($attrs = [], $content = null, $render_slug)
		{

			$alt = $this->props['alt'];
			$onmouseover = $this->props['onmouseover'] !== 'off' ? 'true' : 'false';
			$scroll = $this->props['scroll'] !== 'off' ? 'true' : 'false';
			$segment =
				$this->props['segment_out'] &&
				$this->props['segment_out'] !== '0' ?
				'[' .
				(intval($this->props['segment_in']) ?? 0) . ',' .
				intval($this->props['segment_out'])
				. ']' : '';
			$selector =
				json_encode([
					"id" => empty($this->props['selector']) ? null : $this->props['selector'],
					"exclude" => $this->props['exclude'] === 'on',
				]);
			$src = $this->props['src'];
			$subframe = $this->props['subframe'] !== 'off' ? 'subframe' : '';
			$url = $this->props['url'];
			$url_new_window = $this->props['url_new_window'];

			$onclick = $url !== '' &&
				$this->props['onclick'] !== 'off' ? 'true' : 'false';

			$output = sprintf(
				'<figure%1$s class="%2$s">
					<dotlottie-player
						class="lottie-element"
						src="%3$s"
						%4$s
						%5$s
						%6$s
						description="%7$s"
						renderer="%8$s"
						objectfit="%9$s"
						direction="%10$s"
						data-direction="%10$s"
						data-mouseover="%11$s"
						data-mouseout="%12$s"
						data-click="%13$s"
						speed="%14$s"
						data-selector="%15$s"
						mode="%16$s"
						%17$s
						segment="%18$s"
						data-scroll="%19$s"
						data-delay="%20$s"
						data-once="%21$s"
					>
					</dotlottie-player>
				</figure>',
				$this->module_id(), #1
				$this->module_classname($render_slug), #2
				esc_url($src), #3
				esc_attr($this->props['autoplay'] !== 'off' ? 'autoplay' : ''), #4
				esc_attr($this->props['loop'] !== 'off' ? 'loop' : ''), #5
				esc_attr($this->props['controls'] !== 'off' ? 'controls' : ''), #6
				esc_attr($alt), #7
				esc_attr($this->props['renderer']), #8
				esc_attr($this->props['object_fit']), #9
				esc_attr($this->props['reverse'] !== 'off' ? '-1' : '1'), #10
				esc_attr($onmouseover), #11
				esc_attr($this->props['onmouseout']), #12
				esc_attr($onclick), #13
				esc_attr($this->props['speed']), #14
				esc_attr($selector), #15
				esc_attr($this->props['mode'] !== 'off' ? 'bounce' : 'normal'), #16
				esc_attr($subframe), #17,
				esc_attr($segment), #18
				esc_attr($scroll), #19
				esc_attr($this->props['delay']), #20
				esc_attr($this->props['once'] !== 'off' ? 'true' : 'false'), #21
			);

			if ('' !== $url) {
				$output = sprintf(
					'<a href="%1$s"%3$s>%2$s</a>',
					esc_url($url),
					$output,
					('on' === $url_new_window ? ' target="_blank"' : '')
				);
			}

			return $output;
		}
	}

	new AM_ET_Builder_Module_LottiePlayer;
}
