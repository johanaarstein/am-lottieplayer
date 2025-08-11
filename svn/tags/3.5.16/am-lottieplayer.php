<?php
/**
 * AM LottiePlayer Plugin
 *
 * @package   AM LottiePlayer
 * @author    Aarstein Media
 * @copyright Copyright (C) 2023-2024, Aarstein Media - support@aarstein.media
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 or higher
 *
 * @wordpress-plugin
 * Plugin Name:       AM LottiePlayer
 * Description:       The most complete, free Lottie Player plugin! It´s lightweight, versatile and easy to use – and has integrations for Gutenberg, Divi, Elementor, Flatsome and WPBakery.
 * Requires at least: 5.9
 * Requires PHP:      7.0
 * Version:           3.5.16
 * Plugin URI:        https://www.aarstein.media/en/am-lottieplayer
 * Author:            Aarstein Media
 * Author URI:        https://www.aarstein.media/en
 * License:           GPL-3.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       am-lottieplayer
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

\defined( 'ABSPATH' ) || exit;

use function AAMD_Lottie\Utility\include_file;

if ( ! \class_exists( 'AAMD_Lottie' ) ) {

	class AAMD_Lottie {

		private const _version = '3.5.16';

		/**
		 * Sets up Am LottiePlayer plugin
		 */
		public function __construct() {

			// Define constants
			define( 'AAMD_LOTTIE_PATH', plugin_dir_path( __FILE__ ) );
			define( 'AAMD_LOTTIE_SLUG', plugin_basename( __DIR__ ) );
			define( 'AAMD_LOTTIE_BASENAME', plugin_basename( __FILE__ ) );
			define( 'AAMD_LOTTIE_VERSION', self::_version );
			define( 'AAMD_LOTTIE_URL', plugin_dir_url( __FILE__ ) );
			/** Path to plugin main file */
			define( 'AAMD_LOTTIE_FILE', AAMD_LOTTIE_PATH . AAMD_LOTTIE_SLUG . '.php' );
			define( 'AAMD_LOTTIE_HOMEPAGE', 'https://www.aarstein.media/en/am-lottieplayer/pro' );
			define( 'AAMD_LOTTIE_IS_PRO', false );

			if ( ! defined( 'WP_ENV' ) ) {
				// Used to check for 'development' or 'production'
				define( 'WP_ENV', 'production' );
			}

			// Include utility functions
			include_once AAMD_LOTTIE_PATH . 'includes/utils.php';

			include_file( 'media' );
			include_file( 'builders/builder' );
			if ( is_admin() ) {
				include_file( 'admin' );
			}
		}
	}
} // class_exists check end

/**
 * Main function, to initialize plugin
 *
 * @return AAMD_Lottie
 */
( function () {
	global $aamd_lottie;

	if ( ! isset( $aamd_lottie ) ) {
		$aamd_lottie = new AAMD_Lottie();
	}

	return $aamd_lottie;
} )();
