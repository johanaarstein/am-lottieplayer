<?php

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'AM_LottiePlayer_Admin' ) ) {

	class AM_LottiePlayer_Admin {


		/**
		 * Constructor
		 *
		 * @param void
		 * @return void
		 */
		public function __construct() {
			add_action( 'wp_dashboard_setup', array( $this, 'register_am_lottieplayer_dashboard_widget' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

			add_filter( 'plugin_action_links_' . AM_LOTTIEPLAYER_BASENAME, array( $this, 'add_action_link' ), 10, 2 );
			add_filter( 'network_admin_plugin_action_links_' . AM_LOTTIEPLAYER_BASENAME, array( $this, 'add_action_link' ), 10, 2 );
		}

		/**
		 * Enqueue JavaScript and CSS for backend
		 *
		 * @return void
		 */
		public function admin_enqueue_scripts( $page ) {
			wp_enqueue_style(
				'am-backend-style',
				AM_LOTTIEPLAYER_URL . 'styles/admin.css',
				array(),
				'1.0.0'
			);
			wp_enqueue_script( 'dotlottie-player-light' );

			$widgetAssets = require AM_LOTTIEPLAYER_PATH . 'build/admin.asset.php';

			if ( $page === 'index.php' ) {
				wp_enqueue_script(
					'am-lottieplayer-widget',
					AM_LOTTIEPLAYER_URL . 'build/admin.js',
					$widgetAssets['dependencies'],
					'0.1.0',
					true
				);

				// Add variables to be used inside script
				wp_localize_script(
					'am-lottieplayer-widget',
					'amPhpVars',
					array(
						'pluginUrl' => AM_LOTTIEPLAYER_URL,
					)
				);
			}
		}

		/**
		 * Add dashboard widget
		 */
		public function register_am_lottieplayer_dashboard_widget() {
			wp_add_dashboard_widget(
				'am_lottieplayer_dashboard_widget',
				'AM LottiePlayer',
				array( $this, 'render_am_lottieplayer_dashboard_widget' )
			);
		}

		public function render_am_lottieplayer_dashboard_widget() {
			echo '<div id="am-lottieplayer-widget"></div>';
		}


		/**
		 * Adds links to Premium Support and FAQ under the plugin in the plugin overview page.
		 *
		 * @param array $links Array of links for the plugins, adapted when the current plugin is found.
		 *
		 * @return array
		 */
		public function add_action_link( $links ) {
			// Add link to docs.
			$support_link = '<a href="' . esc_url( 'https://www.aarstein.media/en/account#support' ) . '" target="_blank">' . __( 'Support', 'am-lottieplayer' ) . '</a>';
			array_unshift( $links, $support_link );

			// Add link to premium landing page.
			$premium_link = '<a style="font-weight: bold;" href="' . esc_url( 'https://www.aarstein.media/en/am-lottieplayer/pro' ) . '" target="_blank">' . __( 'Get Premium', 'am-lottieplayer' ) . '</a>';
			array_unshift( $links, $premium_link );

			return $links;
		}
	}

} // class_exists check end

/**
 * Main function, to initialize class
 *
 * @return AM_LottiePlayer_Admin
 */
( function () {
	global $am_lottieplayer_admin;

	if ( ! isset( $am_lottieplayer_admin ) ) {
		$am_lottieplayer_admin = new AM_LottiePlayer_Admin();
	}

	return $am_lottieplayer_admin;
} )();
