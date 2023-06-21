<?php
if (!defined('ABSPATH')) exit('New phone, who diz?');

//Adding Lottie mime types to list over accepted uploads
add_filter('upload_mimes', 'am_lottie_mimetypes');
if (!function_exists('am_lottie_mimetypes')) {
  function am_lottie_mimetypes($mimes) {
    $mimes['json'] = 'application/json';
    $mimes['lottie'] = 'application/zip';
    return $mimes;
  }
}

add_filter('wp_check_filetype_and_ext', 'am_lottie_filetypes', 10, 5);
if (!function_exists('am_lottie_filetypes')) {
  function am_lottie_filetypes($data, $file, $filename, $mimes, $real_mime) {
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
}

//Upload lottie-asset to Media Library
if (!function_exists('media_sideload_lottie')) {
  function media_sideload_lottie($file, $post_id = 0, $desc = 'AM Lottie Animation', $return_type = 'id') {
    if (!empty($file) ) {

      $allowed_extensions = array('lottie', 'json');

      $allowed_extensions = apply_filters('image_sideload_extensions', $allowed_extensions, $file );
      $allowed_extensions = array_map('preg_quote', $allowed_extensions);

      // Set variables for storage, fix file filename for query strings.
      preg_match('/[^\?]+\.(' . implode( '|', $allowed_extensions ) . ')\b/i', $file, $matches);

      if (!$matches ) {
        return new WP_Error('image_sideload_failed', __('Invalid Lottie URL.'));
      }

      $file_array = [];
      $file_array['name'] = wp_basename($matches[0]);

      // Download file to temp location.
      $file_array['tmp_name'] = download_url( $file );

      // If error storing temporarily, return the error.
      if (is_wp_error($file_array['tmp_name'])) {
        return $file_array['tmp_name'];
      }

      // Do the validation and storage stuff.
      $id = media_handle_sideload($file_array, $post_id, $desc);

      // If error storing permanently, unlink.
      if (is_wp_error($id)) {
        @unlink($file_array['tmp_name']);
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

      $alt  = isset( $desc ) ? esc_attr( $desc ) : '';
      $html = "<img src='$src' alt='$alt' />";

      return $html;
    } else {
      return new WP_Error('image_sideload_failed');
    }
  }
}

//Get default Lottie animation
if (!function_exists('am_lottie_asset')) {
  function am_lottie_asset($default = false) {
    $url = AM_LOTTIEPLAYER_URL . 'assets/am.lottie';
    if ($default) {
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

      return media_sideload_lottie($url);
    }

    return post_exists('AM Lottie Animation');
  }
}

//Adding icon to Lottie filetype
add_filter('wp_mime_type_icon', 'am_icon_filter', 10, 3);
if (!function_exists('am_icon_filter')) {
  function am_icon_filter($icon, $mime) {
    if ($mime === 'application/zip' || $mime === 'application/json' || $mime === 'text/plain') return AM_LOTTIEPLAYER_URL . 'assets/lottie-icon.svg';
    return $icon;
  }
}

//Adding preview for Media Library
add_action('wp_enqueue_media', 'am_override_media_templates');
if (!function_exists('am_override_media_templates')) {
  function am_override_media_templates() {
    if (!remove_action('admin_footer', 'wp_print_media_templates')) {
      error_log('remove_action fail');
    }
    add_action('admin_footer', 'am_wp_print_media_templates');
  }
}

if (!function_exists('am_wp_print_media_templates')) {
  function am_wp_print_media_templates() {
    $replaces = [
      '/\<\# \} else if \( \'video\' === data.type \) \{/' =>
      '<# } else if ( \'application\' === data.type || \'text\' === data.type ) { #>
        <div class="wp-media-wrapper">
          <dotlottie-player
            class="details-image"
            controls
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
}
