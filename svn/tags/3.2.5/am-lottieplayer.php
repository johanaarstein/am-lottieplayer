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
 * Version:           3.2.5
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

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'AM_LottiePlayer' ) ) {

	class AM_LottiePlayer {

		public $version;

		public function __construct() {
			$this->version = '3.2.5';
		}

		/**
		 * Sets up Am LottiePlayer plugin
		 *
		 * @return void
		 */
		public function initialize() {

			// Define constants
			define( 'AM_LOTTIEPLAYER_PATH', plugin_dir_path( __FILE__ ) );
			define( 'AM_LOTTIEPLAYER_SLUG', plugin_basename( __DIR__ ) );
			define( 'AM_LOTTIEPLAYER_BASENAME', plugin_basename( __FILE__ ) );
			define( 'AM_LOTTIEPLAYER_VERSION', $this->version );
			define( 'AM_LOTTIEPLAYER_URL', plugin_dir_url( __FILE__ ) );

			// Include utility functions
			include_once AM_LOTTIEPLAYER_PATH . 'includes/functions.php';

			am_include( 'upload' );
			am_include( 'builders/builders' );
			if ( is_admin() ) {
				am_include( 'admin' );
			}

			register_activation_hook( __FILE__, array( $this, 'on_activation' ) );

			// Check if other instances are active
			add_action( 'activated_plugin', array( $this, 'deactivate_other_instances' ) );
			add_action( 'pre_current_active_plugins', array( $this, 'plugin_deactivated_notice' ) );
		}

		/**
		 * Initiate download of default asset if missing
		 *
		 * @return void
		 */
		public static function on_activation() {
			if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}

			AM_LottiePlayer_Upload::lottie_asset();
		}

		/**
		 * Checks if another version of AM LottiePlayer/AM LottiePlayer PRO is active and deactivates it.
		 * Hooked on `activated_plugin` so other plugin is deactivated when current plugin is activated.
		 *
		 * @param string $plugin The plugin being activated.
		 * @return void
		 */
		public function deactivate_other_instances( $plugin ) {
			if ( ! in_array( $plugin, array( 'am-lottieplayer/am-lottieplayer.php', 'am-lottieplayer-pro/am-lottieplayer-pro.php' ), true ) ) {
				return;
			}

			$plugin_to_deactivate  = 'am-lottieplayer/am-lottieplayer.php';
			$deactivated_notice_id = '1';

			// If we just activated the free version, deactivate the pro version.
			if ( $plugin === $plugin_to_deactivate ) {
				$plugin_to_deactivate  = 'am-lottieplayer-pro/am-lottieplayer-pro.php';
				$deactivated_notice_id = '2';
			}

			if ( is_multisite() && is_network_admin() ) {
				$active_plugins = (array) get_site_option( 'active_sitewide_plugins', array() );
				$active_plugins = array_keys( $active_plugins );
			} else {
				$active_plugins = (array) get_option( 'active_plugins', array() );
			}

			foreach ( $active_plugins as $plugin_basename ) {
				if ( $plugin_to_deactivate === $plugin_basename ) {
					set_transient( 'am_deactivated_notice_id', $deactivated_notice_id, 1 * HOUR_IN_SECONDS );
					deactivate_plugins( $plugin_basename );
					return;
				}
			}
		}

		/**
		 * Displays a notice when either Am LottiePlayer or Am LottiePlayer PRO is automatically deactivated.
		 *
		 * @return void
		 */
		public function plugin_deactivated_notice() {
			$deactivated_notice_id = (int) get_transient( 'am_deactivated_notice_id' );
			if ( ! in_array( $deactivated_notice_id, array( 1, 2 ), true ) ) {
				return;
			}

			$message = __( 'AM LottiePlayer and AM LottiePlayer  PRO should not be active at the same time. We\'ve automatically deactivated AM LottiePlayer.', 'am-lottieplayer' );
			if ( 2 === $deactivated_notice_id ) {
				$message = __( 'AM LottiePlayer and AM LottiePlayer PRO should not be active at the same time. We\'ve automatically deactivated AM LottiePlayer PRO.', 'am-lottieplayer' );
			}

			?>
		<div class="updated" style="border-left: 4px solid #ffba00;">
		<p><?php echo esc_html( $message ); ?></p>
		</div>
			<?php

			delete_transient( 'am_deactivated_notice_id' );
		}
	}
} // class_exists check end

/**
 * Main function, to initialize plugin
 *
 * @return AM_LottiePlayer
 */
( function () {
	global $am_lottieplayer;

	if ( ! isset( $am_lottieplayer ) ) {
		$am_lottieplayer = new AM_LottiePlayer();
		$am_lottieplayer->initialize();
	}

	return $am_lottieplayer;
} )();
