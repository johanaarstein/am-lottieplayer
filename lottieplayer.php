<?php
/**
 * @package LottiePlayer
 */
/**
 * Plugin Name:       LottiePlayer
 * Description:       Lightweight, versatile and easy to use! Upload Lottie animations to WordPress and add them in Gutenberg.
 * Requires at least: 5.9
 * Requires PHP:      7.0
 * Version:           1.0.0
 * Author:            Aarstein Media
 * Author URI:        https://www.aarstein.media
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       lottieplayer
 */

// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
	echo 'New phone, who diz?';
	exit;
}

if (!function_exists('lottie_blocks_init')) {
  add_action('init', 'lottie_blocks_init');
  function lottie_blocks_init() {
    register_block_type(plugin_dir_path(__FILE__) . 'build/lottieplayer');
    register_block_type(plugin_dir_path(__FILE__) . 'build/lottiecover');

    wp_register_script(
      'lottiePlayer',
      plugin_dir_url(__FILE__) . 'scripts/dotlottie-player.min.js',
      null,
      '1.2.18',
      true
    );
    wp_enqueue_script('lottiePlayer');
  }

  include plugin_dir_path(__FILE__) . 'includes/uploadFilter.php';
}

if (!function_exists('initialize_lottie_extension')) {
  add_action('divi_extensions_init', 'initialize_lottie_extension');
  function initialize_lottie_extension() {
    require_once plugin_dir_path(__FILE__) . 'includes/LottieDiviModules.php';
  }
}