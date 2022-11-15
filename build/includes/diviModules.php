<?php
add_action('et_builder_ready', 'registerDiviModules');
function registerDiviModules() {
  if (class_exists('ET_Builder_Module')) {
    class ET_Builder_Module_LottiePlayer extends ET_Builder_Module {
      public function init() {
        $this -> name = esc_html__( 'Lottie', 'lottieplayer' );
        $this -> plural = esc_html__( 'Lotties', 'lottieplayer' );
        $this -> slug = 'et_lottieplayer';
        $this -> vb_support = 'on';
      }

      public function get_fields() {
        return [
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
            'affects' => ['__lottie'],
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
            'affects' => ['__lottie'],
            'toggle_slug' => 'main_content',
          ],
          'controls' => [
            'label' => esc_html__('Loop', 'lottieplayer'),
            'description' => esc_html__('Loop the animation.', 'lottieplayer'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'options'  => [
              'off' => et_builder_i18n('No'),
              'on'  => et_builder_i18n('Yes'),
            ],
            'default_on_front' => true,
            'affects' => ['__lottie'],
            'toggle_slug' => 'main_content',
          ],
          'src' => [
            'label' => esc_html__('Lottie JSON or dotLottie', 'lottieplayer'),
            'type' => 'upload',
            'option_category' => 'basic_option',
            'data_type' => 'application',
            'upload_button_text' => esc_attr__('Upload a Lottie JSON or a dotLottie', 'lottieplayer'),
            'choose_text' => esc_attr__('Choose a Lottie JSON or a dotLottie file', 'lottieplayer'),
            'update_text'  => esc_attr__('Set As Lottie', 'lottieplayer'),
            'description' => esc_html__('Upload your desired animation in Lottie JSON format, dotLottie format, or type in the URL to the Lottie you would like to display', 'lottieplayer'),
            'toggle_slug' => 'main_content',
            'computed_affects' => [
              '__lottie',
            ],
            'mobile_options' => true,
            'hover' => 'tabs',
          ],
          '__lottie' => [
            'type' => 'computed',
            'computed_callback' => ['LottiePlayer', 'get_lottie'],
            'computed_depends_on' => ['src'],
            'computed_minimum' => ['src'],
          ],
        ];
      }

      static function get_lottie($args = [], $conditional_tags = [], $current_page = []) {
        $defaults = [
          'alt' => __( 'Lottie animation' ),
          'autoplay' => true,
          'background' => 'transparent',
          'controls' => true,
          'direction' => 1,
          'height' => null,
          // 'id' => null,
          'interactivityType' => 'none',
          'loop' => true,
          'mode' => 'normal',
          'objectFit' => 'contain',
          'renderer' => 'svg',
          'speed' => 1,
          'src' => '',
          'width' => null,
        ];

        $args = wp_parse_args($args, $defaults);
        if (empty($args['src'])) {
          return '';
        }

        ob_start(); ?>
        <dotlottie-player
          <?php echo $args['autoplay'] ? 'autoplay' : ''; ?>
          background="<?php echo $args['background'] ?? 'transparent'; ?>"
          <?php echo $args['controls'] ? 'controls' : ''; ?>
          description="<?php echo $args['alt']; ?>"
          <?php echo $args['loop'] ? 'loop' : ''; ?>
          mode="<?php echo $args['mode']; ?>"
          preserveaspectratio="<?php echo aspectRatio($args['objectFit']); ?>"
          src="<?php echo strip_tags($args['src']); ?>"
        >
        </dotlottie-player>
        <?php
        return ob_get_clean();
      }

      public function render( $attrs, $content, $render_slug ) {
        $multi_view = et_pb_multi_view_options($this);

        $alt = $this -> props['alt'];
        $autoplay = $this -> props['autoplay'];
        $background = $this -> props['background'];
        $controls = $this -> props['controls'];
        $direction = $this -> props['direction'];
        $height = $this -> props['height'];
        // $id = $this -> props['id'];
        $interactivityType = $this -> props['interactivityType'];
        $loop = $this -> props['loop'];
        $mode = $this -> props['mode'];
        $objectFit = $this -> props['objectFit'];
        $renderer = $this -> props['renderer'];
        $speed = $this -> props['speed'];
        $src = $this -> props['src'];
        $width = $this -> props['width'];

        foreach($multi_view -> get_modes() as $modus) {
          $lottie_src[$modus] = self::get_lottie(
            ['src' => $multi_view -> get_inherit_value('src', $modus)]
          );
        }

        $multi_view -> set_custom_prop('lottie_src', $lottie_src);
        $lottie_src = $multi_view -> render_element(
          [
            'tag' => 'figure',
            'content' => '{{lottie_src}}',
            'attrs' => array(
              'class' => 'et_pb_lottie_box'
            )
          ]
        );

        $output = sprintf(
          '<figure%2$ class="%3$s">
            $1$s
          </figure>',
          ('' !== $lottie_src ? $lottie_src : ''),
          $this -> module_id(),
          $this -> module_classname($render_slug)
        );

        return $output;
      }

      public function multi_view_filter_value($raw_value, $args) {
        $name = isset($args['name']) ? $args['name'] : '';

        return $raw_value;
      }
    }

    if (et_builder_should_load_all_module_data()) {
      new ET_Builder_Module_LottiePlayer;
    }
  }
}