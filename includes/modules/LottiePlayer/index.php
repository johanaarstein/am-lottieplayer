<?php
if (class_exists('ET_Builder_Module')) {
  class ET_Builder_Module_LottiePlayer extends ET_Builder_Module {
    public function init() {
      $this -> name = esc_html__('Lottie', 'lottieplayer');
      $this -> plural = esc_html__('Lotties', 'lottieplayer');
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
            'animation'  => [
              'title'    => esc_html__('Animation', 'et_builder'),
              'priority' => 90,
            ],
            'attributes' => [
              'title'    => esc_html__('Attributes', 'et_builder'),
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
                'border_radii'  => '%%order_class%% .et_pb_image_wrap',
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
        'fonts'          => false,
        'text'           => false,
        'button'         => false,
        'link_options'   => false,
      ];
    }

    function get_fields() {
      $fields = [
        'src' => [
          'label' => esc_html__('Lottie', 'lottieplayer'),
          'type' => 'upload',
          'option_category' => 'basic_option',
          'data_type' => ['application/zip', 'application/json', 'text/plain'],
          'upload_button_text' => esc_attr__('Use animation', 'lottieplayer'),
          'choose_text' => esc_attr__('Choose a Lottie JSON or a dotLottie', 'lottieplayer'),
          'update_text'  => esc_attr__('Set As Lottie', 'lottieplayer'),
          'hide_metadata' => true,
          'affects' => ['alt', 'title_text'],
          'description' => esc_html__('Upload your desired animation in Lottie JSON format, dotLottie format, or type in the URL to the Lottie you would like to display', 'lottieplayer'),
          'toggle_slug' => 'main_content',
          'mobile_options' => true,
          'hover' => 'tabs',
        ],
        'alt' => [
          'label' => esc_html__('Animation Alternative Text', 'lottieplayer'),
          'type' => 'text',
          'option_category' => 'basic_option',
          'depends_show_if' => 'on',
          'depends_on' => ['src'],
          'description' => esc_html__('This defines the HTML ALT text. A short description of your animation can be placed here. Helpful for screen readers.', 'lottieplayer'),
          'tab_slug' => 'custom_css',
          'toggle_slug' => 'attributes',
          'dynamic_content' => 'text',
        ],
        'title_text' => [
          'label' => esc_html__('Animation Title Text', 'lottieplayer'),
          'type'  => 'text',
          'option_category' => 'basic_option',
          'depends_show_if' => 'on',
          'depends_on' => ['src'],
          'description' => esc_html__('This defines the HTML Title text.', 'et_builder'),
          'tab_slug' => 'custom_css',
          'toggle_slug' => 'attributes',
          'dynamic_content' => 'text',
        ],
        'show_in_lightbox'    => [
          'label'            => esc_html__('Open in Lightbox', 'et_builder'),
          'type'             => 'yes_no_button',
          'option_category'  => 'configuration',
          'options'          => [
            'off' => et_builder_i18n('No'),
            'on'  => et_builder_i18n('Yes'),
          ],
          'default_on_front' => 'off',
          'affects'          => [
            'url',
            'url_new_window',
          ],
          'toggle_slug'      => 'link',
          'description'      => esc_html__('Here you can choose whether or not the Lottie should open in Lightbox. Note: if you select to open the Lottie in Lightbox, url options below will be ignored.', 'lottieplayer'),
        ],
        'url'                 => [
          'label'           => esc_html__('Animation Link URL', 'lottieplayer'),
          'type'            => 'text',
          'option_category' => 'basic_option',
          'depends_show_if' => 'off',
          'description'     => esc_html__('If you would like your Lottie to be a link, input your destination URL here. No link will be created if this field is left blank.', 'lottieplayer'),
          'toggle_slug'     => 'link',
          'dynamic_content' => 'url',
        ],
        'url_new_window'      => [
          'label'            => esc_html__('Animation Link Target', 'lottieplayer'),
          'type'             => 'select',
          'option_category'  => 'configuration',
          'options'          => [
            'off' => esc_html__('In The Same Window', 'et_builder'),
            'on'  => esc_html__('In The New Tab', 'et_builder'),
          ],
          'default_on_front' => 'off',
          'depends_show_if'  => 'off',
          'toggle_slug'      => 'link',
          'description'      => esc_html__('Here you can choose whether or not your link opens in a new window', 'et_builder'),
        ],
        'use_overlay'         => [
          'label'            => esc_html__('Animation Overlay', 'lottieplayer'),
          'type'             => 'yes_no_button',
          'option_category'  => 'layout',
          'options'          => [
            'off' => et_builder_i18n('Off'),
            'on'  => et_builder_i18n('On'),
          ],
          'default_on_front' => 'off',
          'affects'          => [
            'overlay_icon_color',
            'hover_overlay_color',
            'hover_icon',
          ],
          'show_if'          => [
            'function.showLottieUseOverlayField' => 'on',
          ],
          'tab_slug'         => 'advanced',
          'toggle_slug'      => 'overlay',
          'description'      => esc_html__('If enabled, an overlay color and icon will be displayed when a visitors hovers over the animation', 'lottieplayer'),
        ],
        'overlay_icon_color'  => [
          'label'           => esc_html__('Overlay Icon Color', 'et_builder'),
          'type'            => 'color-alpha',
          'custom_color'    => true,
          'depends_show_if' => 'on',
          'tab_slug'        => 'advanced',
          'toggle_slug'     => 'overlay',
          'description'     => esc_html__('Here you can define a custom color for the overlay icon', 'et_builder'),
          'mobile_options'  => true,
          'sticky'          => true,
        ],
        'hover_overlay_color' => [
          'label'           => esc_html__('Hover Overlay Color', 'et_builder'),
          'type'            => 'color-alpha',
          'custom_color'    => true,
          'depends_show_if' => 'on',
          'tab_slug'        => 'advanced',
          'toggle_slug'     => 'overlay',
          'description'     => esc_html__('Here you can define a custom color for the overlay', 'et_builder'),
          'mobile_options'  => true,
          'sticky'          => true,
        ],
        'hover_icon' => [
          'label' => esc_html__('Hover Icon Picker', 'et_builder'),
          'type' => 'select_icon',
          'option_category' => 'configuration',
          'class' => ['et-pb-font-icon'],
          'depends_show_if' => 'on',
          'tab_slug' => 'advanced',
          'toggle_slug' => 'overlay',
          'description' => esc_html__('Here you can define a custom icon for the overlay', 'et_builder'),
          'mobile_options' => true,
          'sticky' => true,
        ],
        'show_bottom_space'   => [
          'label'            => esc_html__('Show Space Below The Animation', 'lottieplayer'),
          'type'             => 'yes_no_button',
          'option_category'  => 'layout',
          'options'          => [
            'on'  => et_builder_i18n('Yes'),
            'off' => et_builder_i18n('No'),
          ],
          'default_on_front' => 'on',
          'tab_slug'         => 'advanced',
          'toggle_slug'      => 'margin_padding',
          'description'      => esc_html__('Here you can choose whether or not the animation should have a space below it.', 'lottieplayer'),
          'mobile_options'   => true,
        ],
        'align'               => [
          'label'            => esc_html__('Lottie Alignment', 'lottieplayer'),
          'type'             => 'text_align',
          'option_category'  => 'layout',
          'options'          => et_builder_get_text_orientation_options(['justified']),
          'default_on_front' => 'left',
          'tab_slug'         => 'advanced',
          'toggle_slug'      => 'alignment',
          'description'      => esc_html__('Here you can choose the Lottie alignment.', 'lottieplayer'),
          'options_icon'     => 'module_align',
          'mobile_options'   => true,
        ],
        'force_fullwidth'     => [
          'label'            => esc_html__('Force Fullwidth', 'et_builder'),
          'description'      => esc_html__("When enabled, this will force your animation to extend 100% of the width of the column it's in.", 'lottieplayer'),
          'type'             => 'yes_no_button',
          'option_category'  => 'layout',
          'options'          => [
            'off' => et_builder_i18n('No'),
            'on'  => et_builder_i18n('Yes'),
          ],
          'default_on_front' => 'off',
          'tab_slug'         => 'advanced',
          'toggle_slug'      => 'width',
          'affects'          => [
            'max_width',
            'width',
          ],
        ],
        'autoplay' => [
          'label' => esc_html__('Autoplay', 'lottieplayer'),
          'description' => esc_html__('Control whether the animation plays on page load or not.', 'lottieplayer'),
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
          'label' => esc_html__('Controls', 'lottieplayer'),
          'description' => esc_html__('Show or hide controls.', 'lottieplayer'),
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
          'label' => esc_html__('Loop', 'lottieplayer'),
          'description' => esc_html__('Loop the animation.', 'lottieplayer'),
          'type' => 'yes_no_button',
          'option_category' => 'basic_option',
          'options'  => [
            'off' => et_builder_i18n('No'),
            'on'  => et_builder_i18n('Yes'),
          ],
          'default_on_front' => 'on',
          'toggle_slug' => 'main_content',
        ],
      ];

      return $fields;
    }

    public function get_alignment($device = 'desktop') {
      $is_desktop = 'desktop' === $device;
      $suffix = !$is_desktop ? "_{$device}" : '';
      $alignment = $is_desktop && isset($this -> props['align']) ? $this -> props['align'] : '';

      if (!$is_desktop && et_pb_responsive_options() -> is_responsive_enabled($this -> props, 'align')) {
        $alignment = et_pb_responsive_options() -> get_any_value($this -> props, "align{$suffix}");
      }

      return et_pb_get_alignment($alignment);
    }

    public function render($attrs = [], $content = null, $render_slug) {

      $align = $this -> get_alignment();
      $align_phone = $this -> get_alignment('phone');
      $align_tablet = $this -> get_alignment('tablet');
      $alt = $this -> props['alt'];
      $animationMode = $this -> props['mode'];
      $animation_style = $this -> props['animation_style'];
      $autoplay = $this -> props['autoplay'];
      $background = $this -> props['background'];
      $box_shadow_style = self::$_ -> array_get($this -> props, 'box_shadow_style', '');
      $controls = $this -> props['controls'];
      $direction = $this -> props['direction'];
      $force_fullwidth = $this -> props['force_fullwidth'];
      $height = $this -> props['height'];
      $hover_icon = $this -> props['hover_icon'];
      $hover_icon_phone = $this -> props['hover_icon_phone'];
      $hover_icon_sticky = $sticky -> get_value('hover_icon', $this -> props);
      $hover_icon_tablet = $this -> props['hover_icon_tablet'];
      $interactivityType = $this -> props['interactivityType'];
      $loop = $this -> props['loop'];
      $max_height = $this -> props['max_height'];
      $multi_view = et_pb_multi_view_options($this);
      $objectFit = $this -> props['objectFit'];
      $renderer = $this -> props['renderer'];
      $show_bottom_space = $this->props['show_bottom_space'];
      $show_bottom_space_values = et_pb_responsive_options() -> get_property_values($this -> props, 'show_bottom_space');
      $show_bottom_space_phone = isset($show_bottom_space_values['phone']) ? $show_bottom_space_values['phone'] : '';
      $show_bottom_space_tablet = isset($show_bottom_space_values['tablet']) ? $show_bottom_space_values['tablet'] : '';
      $show_in_lightbox = $this -> props['show_in_lightbox'];
      $speed = $this -> props['speed'];
      $src = $this -> props['src'];
      $sticky = et_pb_sticky_options();
      $title_text = $this -> props['title_text'];
      $url = $this -> props['url'];
      $url_new_window = $this -> props['url_new_window'];
      $use_overlay = $this -> props['use_overlay'];
      $width = $this -> props['width'];

      // overlay can be applied only if animation has link or if lightbox enabled
      $is_overlay_applied = 'on' === $use_overlay && ('on' === $show_in_lightbox || ('off' === $show_in_lightbox && '' !== $url)) ? 'on' : 'off';

      if ('on' === $force_fullwidth) {
        $el_style = [
          'selector' => '%%order_class%%',
          'declaration' => 'width: 100%; max-width: 100% !important;',
        ];
        ET_Builder_Element::set_style($render_slug, $el_style);

        $el_style = [
          'selector' => '%%order_class%% .et_pb_image_wrap, %%order_class%% dotlottie-player',
          'declaration' => 'width: 100%;',
        ];
        ET_Builder_Element::set_style($render_slug, $el_style);
      }

      // Responsive Animation Alignment.
      // Set CSS properties and values for the animation alignment.
      // 1. Text Align is necessary, just set it from current animation alignment value.
      // 2. Margin {Side} is optional. Used to pull the animation to right/left side.
      // 3. Margin Left and Right are optional. Used by Center to reset custom margin of point 2.
      $align_values = [
        'desktop' => [
          'text-align' => esc_html($align),
          "margin-{$align}" => !empty($align) && 'center' !== $align ? '0' : '',
        ],
      ];

      if (!empty($align_tablet)) {
        $align_values['tablet'] = [
          'text-align' => esc_html($align_tablet),
          'margin-left' => 'left' !== $align_tablet ? 'auto' : '',
          'margin-right' => 'left' !== $align_tablet ? 'auto' : '',
          "margin-{$align_tablet}" => !empty($align_tablet) && 'center' !== $align_tablet ? '0' : '',
        ];
      }

      if (!empty($align_phone)) {
        $align_values['phone'] = [
          'text-align' => esc_html($align_phone),
          'margin-left' => 'left' !== $align_phone ? 'auto' : '',
          'margin-right' => 'left' !== $align_phone ? 'auto' : '',
          "margin-{$align_phone}" => !empty($align_phone) && 'center' !== $align_phone ? '0' : '',
        ];
      }

      et_pb_responsive_options() -> generate_responsive_css($align_values, '%%order_class%%', '', $render_slug, '', 'alignment');

      // Load up Dynamic Content (if needed) to capture Featured Image objects.
      // In this way we can process `alt` and `title` attributes defined in
      // the WP Media Library when they haven't been specified by the user in
      // Module Settings.
      if (empty($alt) || empty($title_text)) {
        $raw_src   = et_() -> array_get($this -> attrs_unprocessed, 'src');
        $src_value = et_builder_parse_dynamic_content($raw_src);

        if ($src_value -> is_dynamic() && $src_value -> get_content() === 'post_featured_image') {
          // If there is no user-specified ALT attribute text, check the WP
          // Media Library entry for text that may have been added there.
          if (empty($alt)) {
            $alt = et_builder_resolve_dynamic_content('post_featured_image_alt_text', [], get_the_ID(), 'display');
          }

          // If there is no user-specified TITLE attribute text, check the WP
          // Media Library entry for text that may have been added there.
          if (empty($title_text)) {
            $title_text = et_builder_resolve_dynamic_content('post_featured_image_title_text', [], get_the_ID(), 'display');
          }
        }
      }

      if ('on' === $is_overlay_applied) {
        $this -> generate_styles(
          [
            'hover'          => false,
            'base_attr_name' => 'overlay_icon_color',
            'selector'       => '%%order_class%% .et_overlay::before',
            'css_property'   => 'color',
            'render_slug'    => $render_slug,
            'important'      => true,
            'type'           => 'color',
          ]
        );

        $this -> generate_styles(
          [
            'hover'          => false,
            'base_attr_name' => 'hover_overlay_color',
            'selector'       => '%%order_class%% .et_overlay',
            'css_property'   => 'background-color',
            'render_slug'    => $render_slug,
            'type'           => 'color',
          ]
        );

        $overlay_output = ET_Builder_Module_Helper_Overlay::render(
          [
            'icon'        => $hover_icon,
            'icon_tablet' => $hover_icon_tablet,
            'icon_phone'  => $hover_icon_phone,
            'icon_sticky' => $hover_icon_sticky,
          ]
        );

        // Overlay Icon Styles.
        $this -> generate_styles(
          [
            'hover'          => false,
            'utility_arg'    => 'icon_font_family',
            'render_slug'    => $render_slug,
            'base_attr_name' => 'hover_icon',
            'important'      => true,
            'selector'       => '%%order_class%% .et_overlay:before',
            'processor'      => [
              'ET_Builder_Module_Helper_Style_Processor',
              'process_extended_icon',
            ],
          ]
        );
      }

      $box_shadow_overlay_wrap_class = 'none' !== $box_shadow_style
        ? 'has-box-shadow-overlay'
        : '';

      $box_shadow_overlay_element = 'none' !== $box_shadow_style
        ? '<div class="box-shadow-overlay"></div>'
        : '';

      $lottie_attrs = [
        'src'   => '{{src}}',
        'alt'   => esc_attr($alt),
        'title' => esc_attr($title_text),
      ];

      // Only if force fullwidth is not set.
      if ('on' !== $force_fullwidth) {
        $responsive_width     = et_pb_responsive_options() -> get_property_values($this -> props, 'width');
        $responsive_height    = et_pb_responsive_options() -> get_property_values($this -> props, 'height');
        $responsive_max_width = et_pb_responsive_options() -> get_property_values($this -> props, 'max_height');
        $lottie_style_width   = [];
        $modes                = [ 'desktop', 'tablet', 'phone' ];

        foreach ($modes as $mode) {
          // Only height or max-height is set, no width set.
          if ('auto' === $responsive_width[ $mode ] && 'auto' !== $responsive_height[$mode] || 'none' !== $responsive_max_width[$mode]) {
            $lottie_style_width[$mode] = [
              'width' => 'auto',
            ];
          }
        }

        et_pb_responsive_options() -> generate_responsive_css($lottie_style_width, '%%order_class%% .et_pb_image_wrap dotlottie-player', '', $render_slug, '', '');

      }

      $lottie_attachment_class = et_pb_media_options() -> get_image_attachment_class($this -> props, 'src');

      if (!empty($lottie_attachment_class)) {
        $lottie_attrs['class'] = esc_attr($lottie_attachment_class);
      }

      $lottie_html = $multi_view -> render_element(
        [
          'tag'      => 'dotlottie-player',
          'attrs'    => $lottie_attrs,
          'required' => 'src',
        ]
      );

      $output = sprintf(
        '<span class="et_pb_image_wrap %3$s">%4$s%1$s%2$s</span>',
        $lottie_html,
        ('on' === $is_overlay_applied ? $overlay_output : ''),
        $box_shadow_overlay_wrap_class,
        $box_shadow_overlay_element
      );

      if ('on' === $show_in_lightbox) {
        $output = sprintf(
          '<a href="%1$s" class="et_pb_lightbox_image" title="%3$s">%2$s</a>',
          esc_attr($src),
          $output,
          esc_attr($alt)
        );
      } elseif ('' !== $url) {
        $output = sprintf(
          '<a href="%1$s"%3$s>%2$s</a>',
          esc_url($url),
          $output,
          ('on' === $url_new_window ? ' target="_blank"' : '')
        );
      }

      // Module classnames
      if (!in_array($animation_style, ['', 'none'])) {
        $this -> add_classname('et-waypoint');
      }

      if ('on' !== $show_bottom_space) {
        $this -> add_classname('et_pb_image_sticky');
      }

      if (!empty( $show_bottom_space_tablet)) {
        if ('on' === $show_bottom_space_tablet) {
          $this -> add_classname('et_pb_image_bottom_space_tablet');
        } elseif ('off' === $show_bottom_space_tablet) {
          $this -> add_classname('et_pb_image_sticky_tablet');
        }
      }

      if (!empty($show_bottom_space_phone)) {
        if ('on' === $show_bottom_space_phone) {
          $this -> add_classname('et_pb_image_bottom_space_phone');
        } elseif ('off' === $show_bottom_space_phone) {
          $this -> add_classname('et_pb_image_sticky_phone');
        }
      }

      if ('on' === $is_overlay_applied) {
        $this -> add_classname('et_pb_has_overlay');
      }

      $output = sprintf(
        '<div%3$s class="%2$s">
          %4$s
          %5$s
          %1$s
        </div>',
        $output,
        $this -> module_classname($render_slug),
        $this -> module_id(),
        et_core_esc_previously($this -> background_pattern()), // #4
        et_core_esc_previously($this -> background_mask()) // #5
      );

      return $output;
    }

  }

  if (et_builder_should_load_all_module_data()) {
    new ET_Builder_Module_LottiePlayer;
  }
}