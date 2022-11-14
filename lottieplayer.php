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
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

add_action('init', 'lottie_blocks_init');
function lottie_blocks_init() {
	register_block_type( __DIR__ . '/build/lottieplayer' );
  register_block_type( __DIR__ . '/build/lottiecover' );

  $version = '1.2.15';

  wp_register_script(
    'lottiePlayer',
    'https://unpkg.com/@johanaarstein/dotlottie-player@' . $version . '/dist/dotlottie-player.js',
    null,
    null,
    true
  );
  wp_enqueue_script('lottiePlayer');
}

add_filter('upload_mimes', 'lottie_mimetypes');
function lottie_mimetypes($mimes) {
  $mimes['txt'] = 'text/plain';
  $mimes['json'] = 'text/plain';
	$mimes['lottie'] = 'application/zip';
  return $mimes;
}

add_filter('wp_check_filetype_and_ext', 'lottie_filetypes', 10, 5);
function lottie_filetypes($data, $file, $filename, $mimes, $real_mime) {
  if (!empty($data['ext']) && !empty($data['type'])) {
    return $data;
  }
  $wp_file_type = wp_check_filetype($filename, $mimes);

  switch ($wp_file_type['ext']) {
    case 'json':
      $data['ext']  = 'json';
      $data['type'] = 'text/plain';
      break;
    case 'txt':
      $data['ext']  = 'txt';
      $data['type'] = 'text/plain';
      break;
    case 'lottie':
      $data['ext']  = 'lottie';
      $data['type'] = 'application/zip';
  }

  return $data;
}