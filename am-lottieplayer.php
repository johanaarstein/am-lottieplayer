<?php
/**
 * @package AM LottiePlayer
 */
/**
 * Plugin Name:       AM LottiePlayer
 * Description:       The most complete Lottie Player plugin yet! Lightweight, versatile and easy to use. This plugin contains two Gutenberg blocks, a Divi Builder module, and the shortcode [am-lottieplayer].
 * Requires at least: 5.9
 * Requires PHP:      7.0
 * Version:           1.0.0
 * Author:            Aarstein Media
 * Author URI:        https://www.aarstein.media
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       am-lottieplayer
 * Domain Path:       /languages
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

    wp_register_script(
      'am_lottiePlayer',
      AM_LOTTIEPLAYER_URL . 'scripts/dotlottie-player.min.js',
      null,
      '1.2.18',
      true
    );
    wp_enqueue_script('am_lottiePlayer');
  }

  include AM_LOTTIEPLAYER_PATH . 'includes/shortcodes.php';
  include AM_LOTTIEPLAYER_PATH . 'includes/uploadFilter.php';
}

//DIVI
if (!function_exists('am_initialize_lottie_extension')) {
  add_action('divi_extensions_init', 'am_initialize_lottie_extension');
  function am_initialize_lottie_extension() {
    require_once AM_LOTTIEPLAYER_PATH . 'includes/LottieDiviModules.php';
  }
}

//ELEMENTOR
if (!function_exists('am_register_lottie_widget')) {
  add_action('elementor/widgets/register', 'am_register_lottie_widget');
  function am_register_lottie_widget($widgets_manager) {
    require_once AM_LOTTIEPLAYER_PATH . '/includes/widgets/am-lottieplayer.php';
    $widgets_manager -> register(new \Elementor_AM_LottiePlayer());
  }
}