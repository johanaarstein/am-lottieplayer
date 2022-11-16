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

add_action('init', 'lottie_blocks_init');
function lottie_blocks_init() {
  add_shortcode('lottieplayer', 'render_lottieplayer_shortcode');
	register_block_type(__DIR__ . '/build/lottieplayer');
  register_block_type(__DIR__ . '/build/lottiecover');

  wp_register_script(
    'lottiePlayer',
    __DIR__ . '/scripts/dotlottie-player.js',
    null,
    '1.2.18',
    true
  );
  wp_enqueue_script('lottiePlayer');
}

include __DIR__ . '/includes/shortcodes.php';
include __DIR__ . '/includes/uploadFilter.php';
include __DIR__ . '/includes/diviModules.php';