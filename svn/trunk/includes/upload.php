<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'AAMD_Lottie_Upload' ) ) {

	class AAMD_Lottie_Upload {


		/**
		 * Constructor
		 *
		 * @param   void
		 * @return  void
		 */
		public function __construct() {
			if ( is_admin() ) {
				add_action( 'wp_enqueue_media', array( $this, 'override_media_templates' ) );

				add_filter( 'upload_mimes', array( $this, 'lottie_mimetypes' ) );
				add_filter( 'wp_check_filetype_and_ext', array( $this, 'lottie_filetypes' ), 10, 5 );
				add_filter( 'wp_mime_type_icon', array( $this, 'icon_filter' ), 10, 3 );
			}

			// Disable SSL Check on dev
			if ( getenv( 'SERVER_CONTEXT' ) === 'dev' ) {
				add_filter( 'https_ssl_verify', '__return_false' );
			}
		}

		// Adding Lottie mime types to list over accepted uploads
		public function lottie_mimetypes( $mimes ) {
			$mimes['json']   = 'application/json';
			$mimes['lottie'] = 'application/zip';
			return $mimes;
		}

		// Adding preview for Media Library
		public function override_media_templates() {
			if ( ! remove_action( 'admin_footer', 'wp_print_media_templates' ) ) {
				error_log( 'remove_action fail' );
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

			ob_start();
			wp_print_media_templates();
			echo preg_replace(
				array_keys( $replaces ),
				array_values( $replaces ),
				ob_get_clean()
			);
		}

		public function lottie_filetypes( $data, $file, $filename, $mimes, $real_mime ) {
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
			if ( ! empty( $file ) ) {

				$allowed_extensions = array( 'lottie', 'json' );

				$allowed_extensions = apply_filters( 'image_sideload_extensions', $allowed_extensions, $file );
				$allowed_extensions = array_map( 'preg_quote', $allowed_extensions );

				// Set variables for storage, fix file filename for query strings.
				preg_match( '/[^\?]+\.(' . implode( '|', $allowed_extensions ) . ')\b/i', $file, $matches );

				if ( ! $matches ) {
					return new WP_Error( 'image_sideload_failed', __( 'Invalid Lottie URL.' ) );
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
			}

			// Finally, check to make sure the file has been saved, then return the HTML.
			if ( ! empty( $src ) ) {
				if ( 'src' === $return_type ) {
					return $src;
				}

				$alt  = isset( $desc ) ? $desc : '';
				$html = '<img src="' . esc_url( $src ) . '" alt="' . esc_attr( $alt ) . '" />';

				return $html;
			} else {
				return new WP_Error( 'image_sideload_failed' );
			}
		}

		// Adding icon to Lottie filetype
		public function icon_filter( $icon, $mime ) {
			if ( $mime === 'application/zip' || $mime === 'application/json' || $mime === 'text/plain' ) {
				return AAMD_LOTTIE_URL . 'assets/lottie-icon.svg';
			}
			return $icon;
		}

		/**
		 * Save default Lottie animation to Media Library
		 *
		 * @param boolean $default
		 */
		private static function _lottie_asset( $default = false ) {
			$url = AAMD_LOTTIE_URL . 'assets/am.lottie';
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
}(
	function () {
		global $aamd_lottie_upload;

		if ( ! isset( $aamd_lottie_upload ) ) {
				$aamd_lottie_upload = new AAMD_Lottie_Upload();
		}

		return $aamd_lottie_upload;
	}
)();
