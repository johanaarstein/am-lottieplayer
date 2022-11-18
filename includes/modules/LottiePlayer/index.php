<?php
if (!class_exists('AM_ET_Builder_Module_LottiePlayer')) {
	class AM_ET_Builder_Module_LottiePlayer extends ET_Builder_Module {

		public function init() {
			$this -> name = esc_html__('Lottie', 'am_lottieplayer');
			$this -> plural = esc_html__('Lotties', 'am_lottieplayer');
			$this -> slug = 'et_pb_lottieplayer';
			$this -> vb_support = 'on';
			$this -> icon_path = plugin_dir_path(__FILE__) . 'icon.svg';

			$this -> settings_modal_toggles = [
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

			$this -> advanced_fields = [
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

		function get_fields() {
			$fields = [
				'src' => [
					'label' => esc_html__('Lottie', 'am_lottieplayer'),
					'type' => 'upload',
					'option_category' => 'basic_option',
					'data_type' => ['application/zip', 'application/json', 'text/plain'],
					'upload_button_text' => esc_attr__('Use animation', 'am_lottieplayer'),
					'choose_text' => esc_attr__('Choose a Lottie JSON or a dotLottie', 'am_lottieplayer'),
					'update_text'  => esc_attr__('Set As Lottie', 'am_lottieplayer'),
					'hide_metadata' => true,
					'affects' => ['alt', 'title_text'],
					'description' => esc_html__('Upload your desired animation in Lottie JSON format, dotLottie format, or type in the URL to the Lottie you would like to display', 'am_lottieplayer'),
					'toggle_slug' => 'main_content',
					'mobile_options' => true,
					'hover' => 'tabs',
					'default' => 'https://assets8.lottiefiles.com/packages/lf20_kjclizjz.json',
				],
				'alt' => [
					'label' => esc_html__('Animation Alternative Text', 'am_lottieplayer'),
					'type' => 'text',
					'option_category' => 'basic_option',
					'depends_show_if' => 'on',
					'depends_on' => ['src'],
					'description' => esc_html__('This defines the HTML ALT text. A short description of your animation can be placed here. Helpful for screen readers.', 'am_lottieplayer'),
					'tab_slug' => 'custom_css',
					'toggle_slug' => 'attributes',
					'dynamic_content' => 'text',
				],
				'title_text' => [
					'label' => esc_html__('Animation Title Text', 'am_lottieplayer'),
					'type'  => 'text',
					'option_category' => 'basic_option',
					'depends_show_if' => 'on',
					'depends_on' => ['src'],
					'description' => esc_html__('This defines the HTML Title text.', 'et_builder'),
					'tab_slug' => 'custom_css',
					'toggle_slug' => 'attributes',
					'dynamic_content' => 'text',
				],
				// 'show_in_lightbox' => [
				// 	'label' => esc_html__('Open in Lightbox', 'et_builder'),
				// 	'type'  => 'yes_no_button',
				// 	'option_category'  => 'configuration',
				// 	'options'       => [
				// 		'off' => et_builder_i18n('No'),
				// 		'on'  => et_builder_i18n('Yes'),
				// 	],
				// 	'default_on_front' => 'off',
				// 	'affects'       => [
				// 		'url',
				// 		'url_new_window',
				// 	],
				// 	'toggle_slug'   => 'link',
				// 	'description'   => esc_html__('Here you can choose whether or not the Lottie should open in Lightbox. Note: if you select to open the Lottie in Lightbox, url options below will be ignored.', 'am_lottieplayer'),
				// ],
				'url'      => [
					'label'        => esc_html__('Animation Link URL', 'am_lottieplayer'),
					'type' => 'text',
					'option_category' => 'basic_option',
					'depends_show_if' => 'off',
					'description'  => esc_html__('If you would like your Lottie to be a link, input your destination URL here. No link will be created if this field is left blank.', 'am_lottieplayer'),
					'toggle_slug'  => 'link',
					'dynamic_content' => 'url',
				],
				'url_new_window'   => [
					'label' => esc_html__('Animation Link Target', 'am_lottieplayer'),
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
				// 'use_overlay'      => [
				// 	'label' => esc_html__('Animation Overlay', 'am_lottieplayer'),
				// 	'type'  => 'yes_no_button',
				// 	'option_category'  => 'layout',
				// 	'options'       => [
				// 		'off' => et_builder_i18n('Off'),
				// 		'on'  => et_builder_i18n('On'),
				// 	],
				// 	'default_on_front' => 'off',
				// 	'affects'       => [
				// 		'overlay_icon_color',
				// 		'hover_overlay_color',
				// 		'hover_icon',
				// 	],
				// 	'show_if'       => [
				// 		'function.showLottieUseOverlayField' => 'on',
				// 	],
				// 	'tab_slug'      => 'advanced',
				// 	'toggle_slug'   => 'overlay',
				// 	'description'   => esc_html__('If enabled, an overlay color and icon will be displayed when a visitors hovers over the animation', 'am_lottieplayer'),
				// ],
				// 'overlay_icon_color'  => [
				// 	'label'        => esc_html__('Overlay Icon Color', 'et_builder'),
				// 	'type' => 'color-alpha',
				// 	'custom_color' => true,
				// 	'depends_show_if' => 'on',
				// 	'tab_slug'     => 'advanced',
				// 	'toggle_slug'  => 'overlay',
				// 	'description'  => esc_html__('Here you can define a custom color for the overlay icon', 'et_builder'),
				// 	'mobile_options'  => true,
				// 	'sticky'       => true,
				// ],
				// 'hover_overlay_color' => [
				// 	'label'        => esc_html__('Hover Overlay Color', 'et_builder'),
				// 	'type' => 'color-alpha',
				// 	'custom_color' => true,
				// 	'depends_show_if' => 'on',
				// 	'tab_slug'     => 'advanced',
				// 	'toggle_slug'  => 'overlay',
				// 	'description'  => esc_html__('Here you can define a custom color for the overlay', 'et_builder'),
				// 	'mobile_options'  => true,
				// 	'sticky'       => true,
				// ],
				// 'hover_icon' => [
				// 	'label' => esc_html__('Hover Icon Picker', 'et_builder'),
				// 	'type' => 'select_icon',
				// 	'option_category' => 'configuration',
				// 	'class' => ['et-pb-font-icon'],
				// 	'depends_show_if' => 'on',
				// 	'tab_slug' => 'advanced',
				// 	'toggle_slug' => 'overlay',
				// 	'description' => esc_html__('Here you can define a custom icon for the overlay', 'et_builder'),
				// 	'mobile_options' => true,
				// 	'sticky' => true,
				// ],
				'show_bottom_space'   => [
					'label' => esc_html__('Show Space Below The Animation', 'am_lottieplayer'),
					'type'  => 'yes_no_button',
					'option_category'  => 'layout',
					'options'       => [
						'on'  => et_builder_i18n('Yes'),
						'off' => et_builder_i18n('No'),
					],
					'default_on_front' => 'on',
					'tab_slug'      => 'advanced',
					'toggle_slug'   => 'margin_padding',
					'description'   => esc_html__('Here you can choose whether or not the animation should have a space below it.', 'am_lottieplayer'),
					'mobile_options'   => true,
				],
				// 'align'    => [
				// 	'label' => esc_html__('Lottie Alignment', 'am_lottieplayer'),
				// 	'type'  => 'text_align',
				// 	'option_category'  => 'layout',
				// 	'options'       => et_builder_get_text_orientation_options(['justified']),
				// 	'default_on_front' => 'left',
				// 	'tab_slug'      => 'advanced',
				// 	'toggle_slug'   => 'alignment',
				// 	'description'   => esc_html__('Here you can choose the Lottie alignment.', 'am_lottieplayer'),
				// 	'options_icon'  => 'module_align',
				// 	'mobile_options'   => true,
				// ],
				'force_fullwidth'  => [
					'label' => esc_html__('Force Fullwidth', 'et_builder'),
					'description'   => esc_html__("When enabled, this will force your animation to extend 100% of the width of the column it's in.", 'am_lottieplayer'),
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
				'autoplay' => [
					'label' => esc_html__('Autoplay', 'am_lottieplayer'),
					'description' => esc_html__('Control whether the animation plays on page load or not.', 'am_lottieplayer'),
					'type' => 'yes_no_button',
					'option_category' => 'basic_option',
					'options'  => [
						'off' => et_builder_i18n('No'),
						'on'  => et_builder_i18n('Yes'),
					],
					'default_on_front' => 'on',
					'toggle_slug' => 'main_content',
				],
				'controls' => [
					'label' => esc_html__('Controls', 'am_lottieplayer'),
					'description' => esc_html__('Show or hide controls.', 'am_lottieplayer'),
					'type' => 'yes_no_button',
					'option_category' => 'basic_option',
					'options'  => [
						'off' => et_builder_i18n('No'),
						'on'  => et_builder_i18n('Yes'),
					],
					'default_on_front' => 'on',
					'toggle_slug' => 'main_content',
				],
				'loop' => [
					'label' => esc_html__('Loop', 'am_lottieplayer'),
					'description' => esc_html__('Loop the animation.', 'am_lottieplayer'),
					'type' => 'yes_no_button',
					'option_category' => 'basic_option',
					'options'  => [
						'off' => et_builder_i18n('No'),
						'on'  => et_builder_i18n('Yes'),
					],
					'default_on_front' => 'on',
					'toggle_slug' => 'main_content',
				],
				'object_fit' => [
					'label' => esc_html__('Object Fit', 'am_lottieplayer'),
					'description' => esc_html__('Choose how to scale the animation', 'am_lottieplayer'),
					'type' => 'select',
					'option_category' => 'basic_option',
					'options'  => [
						'contain' => esc_html__('Contain', 'am_lottieplayer'),
						'cover' => esc_html__('Cover', 'am_lottieplayer'),
						'fill' => esc_html__('Fill', 'am_lottieplayer'),
						'none' => esc_html__('None', 'am_lottieplayer'),
					],
					'default' => 'contain',
					'toggle_slug' => 'main_content',
				],
				'renderer' => [
					'label' => esc_html__('Renderer', 'am_lottieplayer'),
					'description' => esc_html__('Choose renderer', 'am_lottieplayer'),
					'type' => 'select',
					'option_category' => 'configuration',
					'options'  => [
						'svg' => esc_html__('SVG', 'am_lottieplayer'),
						'canvas' => esc_html__('Canvas', 'am_lottieplayer'),
					],
					'default' => 'svg',
					// 'tab_slug' => 'advanced',
					'toggle_slug' => 'main_content',
				],
			];

			return $fields;
		}

		public function render($attrs = [], $content = null, $render_slug ) {

			if (!function_exists('aspectRatio')) {
				function aspectRatio($objectFit) {
					switch ($objectFit) {
						case 'contain' || 'scale-down':
							return 'xMidYMid meet';
						case 'cover':
							return 'xMidYMid slice';
						case 'fill':
							return 'none';
						case 'none':
							return 'xMinYMin slice';
						default:
							return 'xMidYMid meet';
					}
				}
			}

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
						preserveaspectratio="%9$s"
					>
					</dotlottie-player>
				</figure>',
				$this -> module_id(), #1
				$this -> module_classname($render_slug), #2
				esc_html($this -> props['src']), #3
				($this -> props['autoplay'] !== 'off' ? 'autoplay' : ''), #4
				($this -> props['loop'] !== 'off' ? 'loop' : ''), #5
				($this -> props['controls'] !== 'off' ? 'controls' : ''), #6
				esc_html($this -> props['alt']), #7
				esc_html($this -> props['renderer']), #8
				aspectRatio(esc_html($this -> props['object_fit'])), #9
			);

			return $output;
		}
	}

	new AM_ET_Builder_Module_LottiePlayer;	
}
