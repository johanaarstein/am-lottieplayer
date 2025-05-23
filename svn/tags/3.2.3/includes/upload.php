<?php
defined('ABSPATH') || exit;

if (!class_exists('AM_LottiePlayer_Upload')) {

  class AM_LottiePlayer_Upload
  {

    /**
     * Constructor
     *
     * @param   void
     * @return  void
     */
    public function __construct()
    {
      add_action('wp_enqueue_media', [$this, 'override_media_templates']);

      add_filter('upload_mimes', [$this, 'lottie_mimetypes']);
      add_filter('wp_check_filetype_and_ext', [$this, 'lottie_filetypes'], 10, 5);
      add_filter('wp_mime_type_icon', [$this, 'icon_filter'], 10, 3);

      // Disable SSL Check on dev
      if (getenv('SERVER_CONTEXT') === 'dev') {
        add_filter('https_ssl_verify', '__return_false');
      }
    }

    //Adding Lottie mime types to list over accepted uploads
    public function lottie_mimetypes($mimes)
    {
      $mimes['json'] = 'application/json';
      $mimes['lottie'] = 'application/zip';
      return $mimes;
    }

    //Adding preview for Media Library
    public function override_media_templates()
    {
      if (!remove_action('admin_footer', 'wp_print_media_templates')) {
        error_log('remove_action fail');
      }
      add_action('admin_footer', [$this, 'print_media_templates']);
    }

    public function print_media_templates()
    {
      $replaces = [
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
        '( -1 === jQuery.inArray( data.type, [ \'audio\', \'video\', \'application\', \'text\' ] ) )'
      ];

      ob_start();
      wp_print_media_templates();
      echo preg_replace(
        array_keys($replaces),
        array_values($replaces),
        ob_get_clean()
      );
    }

    public function lottie_filetypes($data, $file, $filename, $mimes, $real_mime)
    {
      if (!empty($data['ext']) && !empty($data['type'])) {
        return $data;
      }
      $wp_file_type = wp_check_filetype($filename, $mimes);

      switch ($wp_file_type['ext']) {
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
     * @param string $file URL to default asset
     * @param int $post_id ID of attachment
     * @param string $desc Description of asset
     * @param 'id'|'src' $return_type What to return
     * 
     * @return int|string|WP_Error
     */
    private static function _media_sideload_lottie($file, $post_id = 0, $desc = 'AM Lottie Animation', $return_type = 'id')
    {
      if (!empty($file)) {

        $allowed_extensions = ['lottie', 'json'];

        $allowed_extensions = apply_filters('image_sideload_extensions', $allowed_extensions, $file);
        $allowed_extensions = array_map('preg_quote', $allowed_extensions);

        // Set variables for storage, fix file filename for query strings.
        preg_match('/[^\?]+\.(' . implode('|', $allowed_extensions) . ')\b/i', $file, $matches);

        if (!$matches) {
          return new WP_Error('image_sideload_failed', __('Invalid Lottie URL.'));
        }

        $file_array = [];
        $file_array['name'] = wp_basename($matches[0]);

        // Download file to temp location.
        $file_array['tmp_name'] = download_url($file);

        // If error storing temporarily, return the error.
        if (is_wp_error($file_array['tmp_name'])) {
          return $file_array['tmp_name'];
        }

        // Do the validation and storage stuff.
        $id = media_handle_sideload($file_array, $post_id, $desc);

        // If error storing permanently, unlink.
        if (is_wp_error($id)) {
          wp_delete_file($file_array['tmp_name']);
          return $id;
        }

        // Store the original attachment source in meta.
        add_post_meta($id, '_source_url', $file);

        // If attachment ID was requested, return it.
        if ('id' === $return_type) {
          return $id;
        }

        $src = wp_get_attachment_url($id);
      }

      // Finally, check to make sure the file has been saved, then return the HTML.
      if (!empty($src)) {
        if ('src' === $return_type) {
          return $src;
        }

        $alt  = isset($desc) ? $desc : '';
        $html = '<img src="' . esc_url($src) . '" alt="' . esc_attr($alt) . '" />';

        return $html;
      } else {
        return new WP_Error('image_sideload_failed');
      }
    }

    //Adding icon to Lottie filetype
    public function icon_filter($icon, $mime)
    {
      if ($mime === 'application/zip' || $mime === 'application/json' || $mime === 'text/plain') {
        return AM_LOTTIEPLAYER_URL . 'assets/lottie-icon.svg';
      }
      return $icon;
    }

    /**
     * Save default Lottie animation to Media Library
     * @param boolean $default
     */
    public static function lottie_asset($default = false)
    {
      $url = AM_LOTTIEPLAYER_URL . 'assets/am.lottie';
      if ($default && filter_var($url, FILTER_VALIDATE_URL)) {
        return $url;
      }

      if (!function_exists('post_exists')) {
        require_once(ABSPATH . 'wp-admin/includes/post.php');
      }

      if (!post_exists('AM Lottie Animation')) {
        if (!function_exists('media_sideload_image')) {
          require_once(ABSPATH . 'wp-admin/includes/media.php');
          require_once(ABSPATH . 'wp-admin/includes/file.php');
          require_once(ABSPATH . 'wp-admin/includes/image.php');
        }

        return self::_media_sideload_lottie($url);
      }

      return post_exists('AM Lottie Animation');
    }
  }
}

/**
 * Main function, to initialize class
 * @return AM_LottiePlayer_Upload
 */
(function () {
  global $am_lottieplayer_upload;

  if (!isset($am_lottieplayer_upload)) {
    $am_lottieplayer_upload = new AM_LottiePlayer_Upload();
  }

  return $am_lottieplayer_upload;
})();