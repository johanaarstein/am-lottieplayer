<?php
/**
 * @package AM LottiePlayer
 */
/**
 * Plugin Name:       AM LottiePlayer
 * Description:       The most complete Lottie Player plugin! It is lightweight, versatile and easy to use, and it has integrations for Gutenberg, Divi, Elementor, Flatsome and WPBakery.
 * Requires at least: 5.9
 * Requires PHP:      7.0
 * Version:           2.5.7
 * Author:            Aarstein Media
 * Author URI:        https://www.aarstein.media
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       am-lottieplayer
 */

// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) exit('New phone, who diz?');

define('AM_LOTTIEPLAYER_PATH', plugin_dir_path( __FILE__ ));
define('AM_LOTTIEPLAYER_URL', plugin_dir_url( __FILE__ ));
define('AM_LOTTIEPLAYER_BASE', plugin_basename( __FILE__ ));

$version =
  !is_dir(AM_LOTTIEPLAYER_PATH) ?
    get_file_data(
      AM_LOTTIEPLAYER_PATH,
      ['Version' => 'Version'],
      'plugin'
    )['Version'] :
      '0.1.0';

define('AM_LOTTIEPLAYER_VERSION', $version);

add_action('init', 'am_lottie_blocks_init');
if (!function_exists('am_lottie_blocks_init')) {
  function am_lottie_blocks_init() {
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
      'am-backend-ux',
      AM_LOTTIEPLAYER_URL . 'scripts/am-backend-ux.min.js',
      ['dotlottie-player'],
      '1.0.0',
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

  register_activation_hook(
    __FILE__,
    'am_lottie_asset'
  );
}

//Includes
if (file_exists(AM_LOTTIEPLAYER_PATH . 'includes/functions.php')) {
  include AM_LOTTIEPLAYER_PATH . 'includes/functions.php';
}
if (file_exists(AM_LOTTIEPLAYER_PATH . 'includes/upload.php')) {
  include AM_LOTTIEPLAYER_PATH . 'includes/upload.php';
}

//Add scripts and styles for back-end
add_action('admin_enqueue_scripts', 'am_backend_enqeue');
if (!function_exists('am_backend_enqeue')) {
  function am_backend_enqeue() {
    wp_register_style('am-backend-style', null);
    wp_enqueue_style('am-backend-style');
    $style = '
      .attachment-media-view.landscape .thumbnail-text,.attachment-media-view.landscape .thumbnail-application{position:relative;}
      .attachment-media-view.landscape dotlottie-player{position:absolute;height:calc(100% - 42px);width:calc(100% - 42px);}';
    wp_add_inline_style('am-backend-style', $style);
    
    wp_enqueue_script('dotlottie-player');
  }
}

//Add scripts for front-end
add_action('wp_enqueue_scripts', 'am_frontend_enqueue');
if (!function_exists('am_frontend_enqueue')) {
  function am_frontend_enqueue() {
    global $post;
    $content = '';

    $diviFlag = false;

    //Check if any front-end builders are active
    $isDiviBuilder = isset($_GET['et_fb']) && !empty($_GET['et_fb']);
    $isVCBuilder = function_exists('vc_is_inline') && vc_is_inline();
    
    if (is_a($post, 'WP_Post')) {
      $content = $post -> post_content;
    }

    // Check for Lottie in Divi Templates
    if (function_exists('et_theme_builder_get_template_layouts')) {
      $layouts = et_theme_builder_get_template_layouts();
      if (!empty($layouts)) {
        if ($layouts['et_header_layout']['override']) {
          $header = get_post($layouts['et_header_layout']['id']) -> post_content;
          if (has_shortcode($header, 'et_pb_lottieplayer')) {
            $diviFlag = true;
          }
        }
        if (!$diviFlag && $layouts['et_body_layout']['override']) {
          $body = get_post($layouts['et_body_layout']['id']) -> post_content;
          if (has_shortcode($body, 'et_pb_lottieplayer')) {
            $diviFlag = true;
          }
        }
        if (!$diviFlag && $layouts['et_footer_layout']['override']) {
          $footer = get_post($layouts['et_footer_layout']['id']) -> post_content;
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

//DIVI
add_action('divi_extensions_init', 'am_initialize_lottie_extension');
if (!function_exists('am_initialize_lottie_extension')) {
  function am_initialize_lottie_extension() {
    require_once AM_LOTTIEPLAYER_PATH . 'includes/LottieDiviModules.php';
  }
}

//ELEMENTOR
add_action('elementor/widgets/register', 'am_register_lottie_widget');
if (!function_exists('am_register_lottie_widget')) {
  function am_register_lottie_widget($widgets_manager) {
    wp_enqueue_style(
      'elementor-backend-style',
      AM_LOTTIEPLAYER_URL . 'styles/am-font.css'
    );
    require_once AM_LOTTIEPLAYER_PATH . 'includes/widgets/elementor-am-lottieplayer.php';
  }
}

//FLATSOME
add_action('after_setup_theme', 'am_register_lottie_flatsome_shortcode');
if (!function_exists('add_ux_builder_shortcode')) {
  function am_register_lottie_flatsome_shortcode() {
    if (!function_exists('add_ux_builder_shortcode')) return;
    require_once AM_LOTTIEPLAYER_PATH . 'includes/flatsome/ux-am-lottieplayer.php';
  }
}

//WPBakery
add_action('vc_before_init','vc_am_lottieplayer'); 
if (!function_exists('vc_am_lottieplayer')) {
  function vc_am_lottieplayer() {
    require_once AM_LOTTIEPLAYER_PATH . 'includes/vc/vc-am-lottieplayer.php';
  }
}
