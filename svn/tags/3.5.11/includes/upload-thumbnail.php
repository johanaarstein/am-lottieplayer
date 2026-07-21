<?php
namespace AAMD_Lottie;

use Error;

if ( ! isset( $_POST['aamd_thumbnail_submit'] ) ) {
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

	/**
	 * Main function
	 */
	private function _upload_file() {
		try {

			if ( ! current_user_can( 'upload_files' ) ||
				! wp_verify_nonce( $_POST['aamd_thumbnail_submit'], 'wp_rest' )
			) {
				throw new Error( 'Unauthorized' );
			}

			$raw_name = isset( $_FILES['thumbnail']['name'] ) ? $_FILES['thumbnail']['name'] : false;

			if ( ! $raw_name ) {
				throw new Error( 'Invalid file upload' );
			}

			$file_name = 'lottie-thumbnail-' . \basename( $raw_name );
			$file_type = \pathinfo( $file_name, PATHINFO_EXTENSION );

			if ( $file_type !== 'svg' ) {
				throw new Error( 'Invalid file type' );
			}

			$file_url = trailingslashit( wp_get_upload_dir()['url'] ) . $file_name;

			add_filter( 'upload_mimes', array( $this, 'allow_svg' ) );
			if ( ! \file_exists( trailingslashit( wp_get_upload_dir()['path'] ) . $file_name ) ) {

				$raw_tmp_name = isset( $_FILES['thumbnail']['tmp_name'] ) ? $_FILES['thumbnail']['tmp_name'] : false;

				if ( ! $raw_tmp_name ) {
					throw new Error( 'Upload failed' );
				}

				$file_contents = \file_get_contents( $raw_tmp_name );

				if ( ! $file_contents ) {
					throw new Error( 'Upload failed' );
				}

				// Remove inline scripts
				$file_contents = \preg_replace( '#<script(.*?)>(.*?)</script>#is', '', $file_contents );

				// Remove event attributes
				$file_contents = \preg_replace( '/\son\w+\s*=\s*(".*?"|\'.*?\'|[^\s>]+)/i', '', $file_contents );

				$upload = wp_upload_bits( $file_name, null, $file_contents );
				if ( ! $upload['error'] ) {
					$file_url = $upload['url'];
				}
			}

			header( 'Content-Type: application/json' );
			echo wp_json_encode(
				array(
					'status' => http_response_code(),
					'url'    => $file_url,
				)
			);
		} catch ( \Exception $e ) {
			header( 'Content-Type: application/json' );
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
