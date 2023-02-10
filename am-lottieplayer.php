<?php
/**
 * @package AM LottiePlayer
 */
/**
 * Plugin Name:       AM LottiePlayer
 * Description:       The most complete Lottie Player plugin yet! Lightweight, versatile and easy to use. Accepts JSON and dotLottie, and has integrations for Gutenberg, Divi, Elementor and Flatsome UX Builder.
 * Requires at least: 5.9
 * Requires PHP:      7.0
 * Version:           2.1.3
 * Author:            Aarstein Media
 * Author URI:        https://www.aarstein.media
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       am-lottieplayer
 */

// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
	echo 'New phone, who diz?';
	exit;
}

if (!defined('AM_LOTTIEPLAYER_PATH')) {
  define('AM_LOTTIEPLAYER_PATH', plugin_dir_path( __FILE__ ));
}

if (!defined('AM_LOTTIEPLAYER_URL')) {
  define('AM_LOTTIEPLAYER_URL', plugin_dir_url( __FILE__ ));
}

if (!function_exists('am_lottie_blocks_init')) {
  add_action('init', 'am_lottie_blocks_init');
  function am_lottie_blocks_init() {
    add_shortcode('am-lottieplayer', 'am_render_lottieplayer_shortcode');
    register_block_type(AM_LOTTIEPLAYER_PATH . 'build/lottieplayer');
    register_block_type(AM_LOTTIEPLAYER_PATH . 'build/lottiecover');

    if (is_admin()) wp_enqueue_script('dotlottie-player');

    wp_register_script(
      'dotlottie-player',
      AM_LOTTIEPLAYER_URL . 'scripts/dotlottie-player.min.js',
      null,
      '1.4.3',
      true
    );

    wp_register_script(
      'am-backend',
      AM_LOTTIEPLAYER_URL . 'scripts/am-backend.min.js',
      ['dotlottie-player'],
      '1.0.0',
      true
    );

    wp_register_script(
      'am-frontend',
      AM_LOTTIEPLAYER_URL . 'scripts/am-frontend.min.js',
      ['dotlottie-player'],
      '1.2.0',
      true
    );
  }

  include AM_LOTTIEPLAYER_PATH . 'includes/functions.php';
  include AM_LOTTIEPLAYER_PATH . 'includes/upload.php';

  register_activation_hook(
    __FILE__,
    'am_lottie_asset'
  );
}

if (!function_exists('am_lottie_block_enqeue')) {
  add_action('wp_enqueue_scripts', 'am_lottie_block_enqeue');
  function am_lottie_block_enqeue() {
    if (!is_admin() && (has_block('gb/lottieplayer') || has_block('gb/lottiecover'))) {
      wp_enqueue_script('am-frontend');
    }
  }
}

if (!defined('AM_LOTTIEPLAYER_VERSION')) {
  define(
    'AM_LOTTIEPLAYER_VERSION',
    get_file_data(
      AM_LOTTIEPLAYER_PATH,
      ['Version' => 'Version'],
      'plugin'
    )['Version']);
}

//DIVI
if (!function_exists('am_initialize_lottie_extension')) {
  add_action('divi_extensions_init', 'am_initialize_lottie_extension');
  function am_initialize_lottie_extension() {
    require_once AM_LOTTIEPLAYER_PATH . 'includes/LottieDiviModules.php';
    if (!is_admin()) {
      wp_enqueue_script('am-frontend');
    }
  }
}

//ELEMENTOR
if (!function_exists('am_register_lottie_widget')) {
  add_action('elementor/widgets/register', 'am_register_lottie_widget');
  function am_register_lottie_widget($widgets_manager) {
    require_once AM_LOTTIEPLAYER_PATH . '/includes/widgets/elementor-am-lottieplayer.php';
    $widgets_manager -> register(new \Elementor_AM_LottiePlayer());
  }
}

//FLATSOME
if (!function_exists('add_ux_builder_shortcode')) {
  add_action('after_setup_theme', 'am_register_lottie_flatsome_shortcode');
  function am_register_lottie_flatsome_shortcode() {
    if (!function_exists('add_ux_builder_shortcode')) return;
    require_once AM_LOTTIEPLAYER_PATH . '/includes/flatsome/ux-am-lottieplayer.php';
  }
}

//WPBakery
// if (!function_exists('vc_am_lottieplayer')) {
//   add_action('init','vc_am_lottieplayer'); 
//   function vc_am_lottieplayer() {
//     if (!defined('WPB_VC_VERSION')) return;
//     require_once AM_LOTTIEPLAYER_PATH . '/includes/vc/vc-am-lottieplayer.php';
//   }
// }