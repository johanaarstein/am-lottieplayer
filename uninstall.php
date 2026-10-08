<?php

\defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

$aamd_uninstall = static function () {
	$attachment_id = (int) get_option( 'aamd_default_lottie_animation' );

	if ( $attachment_id ) {
		wp_delete_attachment( $attachment_id );
	}

	foreach ( array( 'load_light', 'license', 'license_activated' ) as $key ) {
		delete_option( "am_lottieplayer_pro_{$key}" );
	}

	delete_option( 'aamd_default_lottie_animation' );
	delete_transient( 'am_lottieplayer_pro_updates' );
	delete_transient( 'am_lottieplayer_pro_info' );
};

if ( ! is_multisite() ) {
	$aamd_uninstall();

	return;
}

foreach (
	get_sites(
		array(
			'fields' => 'ids',
			'number' => 0,
		)
	) as $site_id
) {
	switch_to_blog( $site_id );
	$aamd_uninstall();
	restore_current_blog();
}
