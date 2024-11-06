<?php
namespace AAMD_Lottie;

use Error;
use Exception;

if ( ! isset( $_POST['aamd_thumnail_submit'] ) ) {
	exit;
}

if ( ! \defined( 'ABSPATH' ) ) {
	require_once __DIR__ . '/../../../../wp-load.php';
}

class UploadThumbnail {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->_upload_file();
	}

	public function allow_svg( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}

	private function _upload_file() {
		try {

			$file_name = 'lottie-thumbnail-' . \basename( $_FILES['thumbnail']['name'] );
			$file_type = \pathinfo( $file_name, PATHINFO_EXTENSION );

			if ( $file_type !== 'svg' ) {
				throw new Error( 'Ivalid file type' );
			}

			add_filter( 'upload_mimes', array( $this, 'allow_svg' ) );

			if ( ! \file_exists( trailingslashit( wp_get_upload_dir()['path'] ) . $file_name ) ) {
				wp_upload_bits( $file_name, null, \file_get_contents( $_FILES['thumbnail']['tmp_name'] ) );
			}

			echo wp_json_encode(
				array(
					'status'  => http_response_code(),
					'message' => 'Thumbnail upload was successfull',
				)
			);
		} catch ( Exception $e ) {
			echo wp_json_encode(
				array(
					'status'  => http_response_code( 400 ),
					'message' => $e,
				)
			);
		} finally {
			exit;
		}
	}
}

new UploadThumbnail();
