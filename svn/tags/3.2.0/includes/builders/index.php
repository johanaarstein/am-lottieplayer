<?php

defined('ABSPATH') || exit;

if (!class_exists('AM_LottiePlayer_Builders')) {

  /**
   * Check for active builders, and initialize extensions
   * 
   * Supported builders: Gutenberg, Divi, Elementor, WPBakery, Flatsome
   */
  class AM_LottiePlayer_Builders
  {
    public function __construct()
    {
      // Builder initializations
      add_action('init', [$this, 'init_gutenberg']);
      add_action('divi_extensions_init', [$this, 'init_divi']);
      add_action('elementor/widgets/register', [$this, 'init_elementor']);
      add_action('after_setup_theme', [$this, 'init_flatsome']);
      add_action('vc_before_init', [$this, 'init_vc']);

      add_action('wp_enqueue_scripts', [$this, 'frontend_enqueue']);
    }

    /**
     * Initialize Gutenberg Blocks and register JavaScript
     * @return void
     */
    public function init_gutenberg()
    {
      add_shortcode('am-lottieplayer', 'am_render_lottieplayer_shortcode');

      register_block_type(AM_LOTTIEPLAYER_PATH . 'build/lottieplayer');
      register_block_type(AM_LOTTIEPLAYER_PATH . 'build/lottiecover');

      wp_register_script(
        'dotlottie-player',
        AM_LOTTIEPLAYER_URL . 'scripts/dotlottie-player.min.js',
        null,
        '1.4.32',
        true
      );

      wp_register_script(
        'am-frontend',
        AM_LOTTIEPLAYER_URL . 'scripts/am-frontend.min.js',
        ['dotlottie-player'],
        '1.2.1',
        true
      );
    }

    /**
     * Initialize DIVI Extension
     * @return void
     */
    public function init_divi()
    {
      am_include('builders/divi/LottieDiviModules.php');
    }

    /**
     * Initialize Elementor Widget
     * @return void
     */
    public function init_elementor($widgets_manager)
    {
      wp_enqueue_style(
        'elementor-backend-style',
        AM_LOTTIEPLAYER_URL . 'styles/am-font.css'
      );
      am_include('elementor/widgets/elementor-am-lottieplayer.php', $widgets_manager);
    }

    /**
     * Initialize Flatsome Shortcode
     * @return void
     */
    public function init_flatsome()
    {
      if (!function_exists('add_ux_builder_shortcode'))
      return;
      am_include('flatsome/ux-am-lottieplayer.php');
    }

    /**
     * Initialize Visual Composer
     * @return void 
     */
    public function init_vc()
    {
      am_include('vc/vc-am-lottieplayer.php');
    }

    /**
     * Enqueue JavaScript for frontend
     * @return void 
     */
    public function frontend_enqueue()
    {
      global $post;
      $content = '';

      $diviFlag = false;

      //Check if any front-end builders are active
      $isDiviBuilder = isset($_GET['et_fb']) && !empty($_GET['et_fb']);
      $isVCBuilder = function_exists('vc_is_inline') && vc_is_inline();

      if (is_a($post, 'WP_Post')) {
        $content = $post->post_content;
      }

      // Check for Lottie in Divi Templates
      if (function_exists('et_theme_builder_get_template_layouts')) {
        $layouts = et_theme_builder_get_template_layouts();
        if (!empty($layouts)) {
          if ($layouts['et_header_layout']['override']) {
            $header = get_post($layouts['et_header_layout']['id'])->post_content;
            if (has_shortcode($header, 'et_pb_lottieplayer')) {
              $diviFlag = true;
            }
          }
          if (!$diviFlag && $layouts['et_body_layout']['override']) {
            $body = get_post($layouts['et_body_layout']['id'])->post_content;
            if (has_shortcode($body, 'et_pb_lottieplayer')) {
              $diviFlag = true;
            }
          }
          if (!$diviFlag && $layouts['et_footer_layout']['override']) {
            $footer = get_post($layouts['et_footer_layout']['id'])->post_content;
            if (has_shortcode($footer, 'et_pb_lottieplayer')) {
              $diviFlag = true;
            }
          }
        }
      }

      if (!is_admin()) {
        if (
          //Check if post has Gutenberg blocks
          has_block('gb/lottieplayer') ||
          has_block('gb/lottiecover') ||
          (
            (
              //Check if post has general shortcode, and VC frontend builder is not active
              has_shortcode($content, 'am-lottieplayer') &&
              !$isVCBuilder
            ) ||
            (
              //Check if post has Divi shortcode, and Divi Builder is not active
              ($diviFlag || has_shortcode($content, 'et_pb_lottieplayer')) &&
              !$isDiviBuilder
            )
          )
        ) {
          wp_enqueue_script('am-frontend');
        }
        //Add scripts for Divi/VC front-end builder, if either are installed and active
        if ($isDiviBuilder || $isVCBuilder) {
          wp_enqueue_script('dotlottie-player');
        }
      }
    }
  }

  /**
   * Main function, to initialize class
   * @return AM_LottiePlayer_Builders
   */
  function am_lottieplayer_builders()
  {
    global $am_lottieplayer_builders;

    if (!isset($am_lottieplayer_builders)) {
      $am_lottieplayer_builders = new AM_LottiePlayer_Builders();
    }

    return $am_lottieplayer_builders;
  }

  am_lottieplayer_builders();
}
