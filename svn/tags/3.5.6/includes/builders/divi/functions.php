<?php

function et_image_add_srcset_and_sizes( $image, $echo = false ) {
	static $srcset_and_sizes_cached = array();

	error_log( 'foo' );
	// Check if option is enabled.
	if ( ! et_is_responsive_images_enabled() ) {
		if ( $echo ) {
			echo et_core_intentionally_unescaped( $image, 'html' );
		}

		return $image;
	}

	$src = et_get_src_from_img_tag( $image );

	$cache_key = $src ? $src : 'empty-src';

	if ( isset( $srcset_and_sizes_cached[ $cache_key ] ) ) {
		$image = $srcset_and_sizes_cached[ $cache_key ];
	} else {
		// Only process if src attribute is not empty.
		if ( $src ) {
			$attachment_id = et_get_attachment_id_by_url( $src );
			$image_meta    = false;

			if ( $attachment_id ) {
				$image_meta = wp_get_attachment_metadata( $attachment_id );
			}

			if ( $image_meta ) {
				$image = wp_image_add_srcset_and_sizes( $image, $image_meta, $attachment_id );
			}
		}

		$srcset_and_sizes_cached[ $cache_key ] = $image;
	}

	if ( $echo ) {
		echo et_core_intentionally_unescaped( $image, 'html' );
	}

	return $image;
}

// Hook into DIVI attachment handeling to prevent thumbnails from being used
function et_get_image_srcset_sizes( $url ) {

	// START
	$parts = pathinfo( $url );

	switch ( $parts['extension'] ) {
		case 'lottie':
		case 'json': {
			return array();
		}
	}
	// END

	// Normalize image URL.
	$normalized_url = et_attachment_normalize_url( $url );

	// Bail early if URL is invalid.
	if ( ! $normalized_url ) {
		return array();
	}

	$cache = ET_Core_Cache_File::get( 'image_srcset_sizes' );

	if ( isset( $cache[ $normalized_url ] ) ) {
		if ( et_core_is_uploads_dir_url( $normalized_url ) ) {
			return $cache[ $normalized_url ];
		}

		unset( $cache[ $normalized_url ] );
		ET_Core_Cache_File::set( 'image_srcset_sizes', $cache );
	}

	$attachment_id = et_get_attachment_id_by_url( $url );
	if ( ! $attachment_id ) {
		return array();
	}

	$image_size = et_get_attachment_size_by_url( $url );
	if ( ! $image_size ) {
		return array();
	}

	$srcset = wp_get_attachment_image_srcset( $attachment_id, $image_size );
	$sizes  = wp_get_attachment_image_sizes( $attachment_id, $image_size );

	if ( ! $srcset || ! $sizes ) {
		return array();
	}

	$data = array(
		'srcset' => $srcset,
		'sizes'  => $sizes,
	);

	if ( et_core_is_uploads_dir_url( $normalized_url ) ) {
		$cache[ $normalized_url ] = $data;
		ET_Core_Cache_File::set( 'image_srcset_sizes', $cache );
	}

	return $data;
}
