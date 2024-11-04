<?php
namespace AAMD_Lottie;

use Error;
use Exception;

if ( ! isset( $_POST['aamd_thumnail_submit'] ) ) {
	exit;
}

try {

	if ( ! \defined( 'ABSPATH' ) ) {
		require_once __DIR__ . '/../../../../wp-load.php';
	}

	\header( 'Content-type: application/json' );

	// $target_dir  = trailingslashit( wp_upload_dir()['basedir'] ) . 'lottie-thumbnails';
	$target_dir  = wp_upload_dir()['path'];
	$target_file = trailingslashit( $target_dir ) . \basename( $_FILES['thumbnail']['name'] );

	$file_type = \pathinfo( $target_file, PATHINFO_EXTENSION );

	if ( $file_type !== 'svg' ) {
		throw new Error( 'Ivalid file type' );
	}

	\move_uploaded_file( $_FILES['thumbnail']['tmp_name'], $target_file );

	echo \json_encode(
		array(
			'status'  => http_response_code(),
			'message' => 'Thumbnail upload was successfull',
		)
	);
} catch ( Exception $e ) {
	echo \json_encode(
		array(
			'status'  => http_response_code( 400 ),
			'message' => $e,
		)
	);
} finally {
	exit;
}
