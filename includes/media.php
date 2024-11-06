<?php
namespace AAMD_Lottie;

use function AAMD_Lottie\Utility\get_asset;

\defined( 'ABSPATH' ) || exit;

class Media {

	/**
	 * Constructor
	 */
	public function __construct() {
		if ( is_admin() ) {

			add_action( 'wp_enqueue_media', array( $this, 'override_media_templates' ) );

			add_filter( 'upload_mimes', array( $this, 'mimetypes' ) );
			add_filter( 'wp_check_filetype_and_ext', array( $this, 'lottie_filetypes' ), 10, 4 );
			add_filter( 'wp_mime_type_icon', array( $this, 'icon_filter' ), 10, 2 );
			add_filter( 'wp_generate_attachment_metadata', array( $this, 'generate_lottie_metadata' ), 10, 2 );
			add_filter( 'wp_get_attachment_metadata', array( $this, 'metadata_error_fix' ), 10, 2 );
		}

		// Disable SSL Check on dev
		if ( \getenv( 'SERVER_CONTEXT' ) === 'dev' ) {
			add_filter( 'https_ssl_verify', '__return_false' );
		}
	}

	// Adding Lottie mime types to list over accepted uploads
	public function mimetypes( $mimes ) {
		$mimes['json']   = 'application/json';
		$mimes['lottie'] = 'application/zip';
		return $mimes;
	}

	// Adding preview for Media Library
	public function override_media_templates() {
		if ( ! remove_action( 'admin_footer', 'wp_print_media_templates' ) ) {
			throw new \WP_Error(
				'remove_action_failed',
				esc_html__( 'Could not remove admin footer.', 'am-lottieplayer' ),
				array( 'status' => 400 ),
			);
		}
		add_action( 'admin_footer', array( $this, 'print_media_templates' ) );
	}

	public function print_media_templates() {
		$replaces = array(
			'/\<\# \} else if \( \'video\' === data.type \) \{/' =>
			'<# } else if ( \'application\' === data.type || \'text\' === data.type ) { #>
			<div class="wp-media-wrapper">
				<dotlottie-player
					class="details-image"
					controls
					simple
					src="{{ data.url }}"
				>
				</dotlottie-player>
			</div>
		<# } else if ( \'video\' === data.type ) {',
			'/\( -1 === jQuery.inArray\( data.type, \[ \'audio\', \'video\' \] \) \)/' =>
			'( -1 === jQuery.inArray( data.type, [ \'audio\', \'video\', \'application\', \'text\' ] ) )',
		);

		\ob_start();
		wp_print_media_templates();
		echo \preg_replace(
			\array_keys( $replaces ),
			\array_values( $replaces ),
			\ob_get_clean()
		);
	}

	public function lottie_filetypes( $data, $file, $filename, $mimes ) {
		if ( ! empty( $data['ext'] ) && ! empty( $data['type'] ) ) {
			return $data;
		}
		$wp_file_type = wp_check_filetype( $filename, $mimes );

		switch ( $wp_file_type['ext'] ) {
			case 'json':
				$data['ext']  = 'json';
				$data['type'] = 'application/json';
				break;
			case 'lottie':
				$data['ext']  = 'lottie';
				$data['type'] = 'application/zip';
		}

		return $data;
	}

	/**
	 * Filters the attachment meta data.
	 */
	public function metadata_error_fix( $data, $post_id ) {

		// If it's a WP_Error regenerate metadata and save it
		if ( is_wp_error( $data ) ) {
			$data = wp_generate_attachment_metadata( $post_id, get_attached_file( $post_id ) );
			wp_update_attachment_metadata( $post_id, $data );
		}

		return $data;
	}

	/**
	 * Skip regenerating SVGs
	 */
	public function generate_lottie_metadata( $metadata, $attachment_id ) {
		$mime = get_post_mime_type( $attachment_id );
		if ( $mime !== 'application/zip' ) {
			return $metadata;
		}

		\usleep( 20000 );

		$lottie_path         = get_attached_file( $attachment_id );
		$upload_dir          = wp_upload_dir();
		$relative_path       = \str_replace( trailingslashit( $upload_dir['basedir'] ), '', $lottie_path );
		$filename            = \basename( $lottie_path );
		$thumbnail_file_name = 'lottie-thumbnail-' . \str_ireplace( '.lottie', '.svg', $filename );
		$thumbnail_file      = trailingslashit( $upload_dir['path'] ) . $thumbnail_file_name;
		$thumbnail_file_size = round( $metadata['filesize'] / 60 );

		if ( \file_exists( $thumbnail_file ) ) {
			$thumbnail_file_size = filesize( $thumbnail_file );
		}

		$dimensions = $this->_svg_dimensions( $thumbnail_file );

		if ( ! $dimensions ) {
			return $metadata;
		}

		$srcset = array(
			'file'      => $thumbnail_file_name,
			'width'     => $dimensions['width'],
			'height'    => $dimensions['height'],
			'mime-type' => 'image/svg+xml',
			'filesize'  => $thumbnail_file_size,
		);

		$metadata = array_merge(
			array(
				$metadata,
				'width'      => $dimensions['width'],
				'height'     => $dimensions['height'],
				'file'       => $relative_path,
				'sizes'      => array(
					'medium'       => $srcset,
					'thumbnail'    => $srcset,
					'medium_large' => $srcset,
					'full'         => $srcset,
				),
				'image_meta' => array(
					'aperture'          => 0,
					'credit'            => '',
					'camera'            => '',
					'caption'           => '',
					'created_timestamp' => 0,
					'copyright'         => '',
					'focal_length'      => 0,
					'iso'               => 0,
					'shutter_speed'     => 0,
					'title'             => '',
					'orientation'       => $dimensions['orientation'],
					'keywords'          => array(),
				),
			)
		);

		return $metadata;
	}

	/**
	 * Get SVG size from the width/height or viewport.
	 *
	 * @param string path to svg
	 *
	 * @return array|bool
	 */
	private function _svg_dimensions( string $path ) {

		if ( ! \file_exists( $path ) ) {
			return false;
		}

		$width  = 0;
		$height = 0;

		$svg = \simplexml_load_string( \file_get_contents( $path ) );

		// Ensure the svg could be loaded.
		if ( ! $svg ) {
			return false;
		}

		$attributes = $svg->attributes();

		if ( isset( $attributes->viewBox ) ) {
			$sizes = explode( ' ', $attributes->viewBox );
			if ( isset( $sizes[2], $sizes[3] ) ) {
				$viewbox_width  = \floatval( $sizes[2] );
				$viewbox_height = \floatval( $sizes[3] );
			}
		}

		if (
			isset( $attributes->width, $attributes->height ) &&
			\is_numeric( (float) $attributes->width ) &&
			\is_numeric( (float) $attributes->height ) &&
			! str_ends_with( (string) $attributes->width, '%' ) &&
			! str_ends_with( (string) $attributes->height, '%' )
		) {
			$attr_width  = floatval( $attributes->width );
			$attr_height = floatval( $attributes->height );
		}

		if ( isset( $viewbox_width, $viewbox_height ) ) {
			$width  = $viewbox_width;
			$height = $viewbox_height;
		} elseif ( isset( $attr_width, $attr_height ) ) {
			$width  = $attr_width;
			$height = $attr_height;
		}

		if ( ! $width && ! $height ) {
			return false;
		}

		$dimensions = array(
			'width'       => $width,
			'height'      => $height,
			'orientation' => ( $width > $height ) ? 'landscape' : 'portrait',
		);

		return $dimensions;
	}

	/**
	 * Upload Lottie-asset to Media Library
	 *
	 * @param string     $file URL to default asset
	 * @param int        $post_id ID of attachment
	 * @param string     $desc Description of asset
	 * @param 'id'|'src' $return_type What to return
	 *
	 * @return int|string|WP_Error
	 */
	private static function _media_sideload_lottie( $file, $post_id = 0, $desc = 'AM Lottie Animation', $return_type = 'id' ) {
		try {
			if ( empty( $file ) ) {
				throw new \WP_Error(
					'image_sideload_failed',
					__( 'Invalid Lottie URL.', 'am-lottieplayer' ),
					array( 'status' => 400 ),
				);
			}

			$allowed_extensions = array( 'lottie', 'json' );

			$allowed_extensions = apply_filters( 'image_sideload_extensions', $allowed_extensions, $file );
			$allowed_extensions = \array_map( 'preg_quote', $allowed_extensions );

			// Set variables for storage, fix file filename for query strings.
			\preg_match( '/[^\?]+\.(' . \implode( '|', $allowed_extensions ) . ')\b/i', $file, $matches );

			if ( ! $matches ) {
				throw new \WP_Error(
					'image_sideload_failed',
					__( 'Invalid Lottie URL.', 'am-lottieplayer' ),
					array( 'status' => 400 ),
				);
			}

			$file_array         = array();
			$file_array['name'] = wp_basename( $matches[0] );

			// Download file to temp location.
			$file_array['tmp_name'] = download_url( $file );

			// If error storing temporarily, return the error.
			if ( is_wp_error( $file_array['tmp_name'] ) ) {
				return $file_array['tmp_name'];
			}

			// Do the validation and storage stuff.
			$id = media_handle_sideload( $file_array, $post_id, $desc );

			// If error storing permanently, unlink.
			if ( is_wp_error( $id ) ) {
				wp_delete_file( $file_array['tmp_name'] );
				return $id;
			}

			// Store the original attachment source in meta.
			add_post_meta( $id, '_source_url', $file );

			// If attachment ID was requested, return it.
			if ( 'id' === $return_type ) {
				return $id;
			}

			$src = wp_get_attachment_url( $id );

			// Finally, check to make sure the file has been saved, then return the HTML.
			if ( empty( $src ) ) {
				throw new \WP_Error( 'image_sideload_failed' );
			}
			if ( 'src' === $return_type ) {
				return $src;
			}

			$alt  = isset( $desc ) ? $desc : '';
			$html = '<img src="' . esc_url( $src ) . '" alt="' . esc_attr( $alt ) . '" />';

			return $html;
		} catch ( \Exception $e ) {
			return $e;
		}
	}

	// Adding icon to Lottie filetype
	public function icon_filter( $icon, $mime ) {
		if ( $mime === 'application/zip' || $mime === 'application/json' || $mime === 'text/plain' ) {
			return get_asset( 'lottie-icon.svg' );
		}
		return $icon;
	}

	/**
	 * Save default Lottie animation to Media Library
	 *
	 * @param boolean $default
	 */
	private static function _lottie_asset( $default = false ) {
		$url = get_asset( 'am.lottie' );
		if ( $default && filter_var( $url, FILTER_VALIDATE_URL ) ) {
			return $url;
		}

		if ( ! function_exists( 'post_exists' ) ) {
			require_once ABSPATH . 'wp-admin/includes/post.php';
		}

		$post_id = post_exists( 'AM Lottie Animation' );

		if ( ! $post_id ) {
			if ( ! function_exists( 'media_sideload_image' ) ) {
				require_once ABSPATH . 'wp-admin/includes/media.php';
				require_once ABSPATH . 'wp-admin/includes/file.php';
				require_once ABSPATH . 'wp-admin/includes/image.php';
			}

			return self::_media_sideload_lottie( $url );
		}

		return get_permalink( $post_id );
	}

	/**
	 * URL for placeholder animation
	 *
	 * @var string|false|int|\WP_Error
	 */
	private $_defaultFile = false;

	/**
	 * Set placeholder animation.
	 * This function will download and save file to
	 * Media Library if it doesn't exist.
	 */
	public function set_default_file() {
		if ( $this->_defaultFile && ! is_wp_error( $this->_defaultFile ) ) {
			return;
		}
		if ( is_wp_error( $this->_lottie_asset() ) ) {
			$this->_defaultFile = $this->_lottie_asset( true );
			return;
		}
		$this->_defaultFile = wp_get_attachment_url( $this->_lottie_asset() );
	}

	/**
	 * Get placeholder animation.
	 */
	public function get_default_file() {
		if ( $this->_defaultFile ) {
			return $this->_defaultFile;
		}

		$this->set_default_file();

		return $this->_defaultFile;
	}
}

/**
 * Main function, to initialize class
 *
 * @return Media
 */
( function () {
	global $aamd_lottie_media;

	if ( ! isset( $aamd_lottie_media ) ) {
		$aamd_lottie_media = new Media();
	}

	return $aamd_lottie_media;
} )();
