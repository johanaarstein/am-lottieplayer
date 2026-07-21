<?php
namespace AAMD_Lottie;

\defined( 'ABSPATH' ) || exit;

class Admin {

	/**
	 * Constructor
	 *
	 * @param void
	 * @return void
	 */
	public function __construct() {
		add_action( 'wp_dashboard_setup', array( $this, 'register_am_lottieplayer_dashboard_widget' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

		add_filter( 'plugin_action_links_' . AAMD_LOTTIE_BASENAME, array( $this, 'add_action_link' ), 10, 2 );
		add_filter( 'network_admin_plugin_action_links_' . AAMD_LOTTIE_BASENAME, array( $this, 'add_action_link' ), 10, 2 );
	}

	/**
	 * Enqueue JavaScript and CSS for backend
	 *
	 * @return void
	 */
	public function admin_enqueue_scripts( $page ) {
		wp_enqueue_style(
			'am-backend-style',
			AAMD_LOTTIE_URL . 'styles/admin.css',
			array(),
			'1.0.0'
		);
		wp_enqueue_script( 'dotlottie-player-light' );

		$widgetAssets = require AAMD_LOTTIE_PATH . 'build/admin.asset.php';

		if ( $page === 'index.php' ) {
			wp_enqueue_script(
				'am-lottieplayer-widget',
				AAMD_LOTTIE_URL . 'build/admin.js',
				$widgetAssets['dependencies'],
				'0.1.0',
				true
			);

			// Add variables to be used inside script
			wp_localize_script(
				'am-lottieplayer-widget',
				'amPhpVars',
				array(
					'pluginUrl' => AAMD_LOTTIE_URL,
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
		\array_unshift( $links, $support_link );

		// Add link to premium landing page.
		$premium_link = '<a style="font-weight: bold;" href="' . esc_url( 'https://www.aarstein.media/en/am-lottieplayer/pro' ) . '" target="_blank">' . __( 'Get Premium', 'am-lottieplayer' ) . '</a>';
		\array_unshift( $links, $premium_link );

		return $links;
	}
}

/**
 * Main function, to initialize class
 *
 * @return AAMD_Lottie\Admin
 */
( function () {
	global $aamd_lottie_admin;

	if ( ! isset( $aamd_lottie_admin ) ) {
		$aamd_lottie_admin = new Admin();
	}

	return $aamd_lottie_admin;
} )();
