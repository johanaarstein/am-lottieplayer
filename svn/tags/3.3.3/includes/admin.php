<?php
namespace AAMD_Lottie;

use function AAMD_Lottie\Utility\get_build;
use function AAMD_Lottie\Utility\get_build_path;
use function AAMD_Lottie\Utility\get_style;

\defined( 'ABSPATH' ) || exit;

class Admin {

	/**
	 * Constructor
	 *
	 * @param void
	 */
	public function __construct() {
		register_activation_hook(
			AAMD_LOTTIE_FILE,
			array( $this, 'on_activation' )
		);

		// Check if other instances are active
		add_action(
			'activated_plugin',
			array( $this, 'deactivate_other_instances' )
		);
		add_action(
			'pre_current_active_plugins',
			array( $this, 'plugin_deactivated_notice' )
		);

		if ( ! AAMD_LOTTIE_IS_PRO ) {
			add_action(
				'wp_dashboard_setup',
				array( $this, 'register_am_lottieplayer_dashboard_widget' )
			);
		}

		add_action(
			'admin_enqueue_scripts',
			array( $this, 'enqueue_backend_scripts' )
		);

		add_filter(
			'plugin_action_links_' . AAMD_LOTTIE_BASENAME,
			array( $this, 'add_action_link' ),
			10,
			2
		);
		add_filter(
			'network_admin_plugin_action_links_' . AAMD_LOTTIE_BASENAME,
			array( $this, 'add_action_link' ),
			10,
			2
		);
	}

	/**
	 * Initiate download of default asset if missing
	 */
	public static function on_activation() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		global $aamd_lottie_media;

		$aamd_lottie_media->set_default_file();
	}

	/**
	 * Checks if another version of AM LottiePlayer/AM LottiePlayer PRO is active and deactivates it.
	 * Hooked on `activated_plugin` so other plugin is deactivated when current plugin is activated.
	 *
	 * @param string $plugin The plugin being activated.
	 */
	public function deactivate_other_instances( $plugin ) {
		if ( ! \in_array( $plugin, array( 'am-lottieplayer/am-lottieplayer.php', 'am-lottieplayer-pro/am-lottieplayer-pro.php' ), true ) ) {
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
			$active_plugins = \array_keys( $active_plugins );
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
	 */
	public function plugin_deactivated_notice() {
		$deactivated_notice_id = (int) get_transient( 'am_deactivated_notice_id' );
		if ( ! \in_array( $deactivated_notice_id, array( 1, 2 ), true ) ) {
			return;
		}

		$message = __( 'AM LottiePlayer and AM LottiePlayer PRO should not be active at the same time. We\'ve automatically deactivated AM LottiePlayer.', 'am-lottieplayer' );
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

	/**
	 * Enqueue JavaScript and CSS for backend
	 */
	public function enqueue_backend_scripts( $page ) {
		wp_enqueue_style(
			'am-backend-style',
			get_style( 'admin.css' ),
			array(),
			'1.0.0'
		);

		wp_enqueue_script( 'dotlottie-player-light' );

		$assets = require get_build_path( 'admin.asset.php' );

		if ( $page === 'index.php' ) {
			wp_enqueue_script(
				'am-lottieplayer-options',
				get_build( 'admin.js' ),
				$assets['dependencies'],
				'0.1.0',
				true
			);

			// Add variables to be used inside script
			wp_localize_script(
				'am-lottieplayer-options',
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
		echo wp_kses(
			'<div id="am-lottieplayer-widget"></div>',
			array(
				'div' => array(
					'id' => array(),
				),
			),
		);
	}

	/**
	 * Adds links to Premium Support and FAQ under the plugin in the plugin overview page.
	 *
	 * @param array $links Array of links for the plugins, adapted when the current plugin is found.
	 *
	 * @return array
	 */
	public function add_action_link( $links, $_ ) {
		// Add link to docs.
		$support_link = '<a href="' . esc_url( 'https://www.aarstein.media/en/account#support' ) . '" target="_blank">' . __( 'Support', 'am-lottieplayer' ) . '</a>';
		\array_unshift( $links, $support_link );

		// Add link to premium landing page.
		$premium_link = '<a style="font-weight: bold;" href="' . esc_url( AAMD_LOTTIE_HOMEPAGE ) . '" target="_blank">' . __( 'Get Premium', 'am-lottieplayer' ) . '</a>';
		\array_unshift( $links, $premium_link );

		return $links;
	}
}

/**
 * Main function, to initialize class
 *
 * @return Admin
 */
( function () {
	global $aamd_lottie_admin;

	if ( ! isset( $aamd_lottie_admin ) ) {
		$aamd_lottie_admin = new Admin();
	}

	return $aamd_lottie_admin;
} )();
