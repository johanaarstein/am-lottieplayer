<?php
add_filter('upload_mimes', 'lottie_mimetypes');
function lottie_mimetypes($mimes) {
  $mimes['txt'] = 'text/plain';
  $mimes['json'] = 'text/plain';
	$mimes['lottie'] = 'application/zip';
  return $mimes;
}

add_filter('wp_check_filetype_and_ext', 'lottie_filetypes', 10, 5);
function lottie_filetypes($data, $file, $filename, $mimes, $real_mime) {
  if (!empty($data['ext']) && !empty($data['type'])) {
    return $data;
  }
  $wp_file_type = wp_check_filetype($filename, $mimes);

  switch ($wp_file_type['ext']) {
    case 'json':
      $data['ext']  = 'json';
      $data['type'] = 'text/plain';
      break;
    case 'txt':
      $data['ext']  = 'txt';
      $data['type'] = 'text/plain';
      break;
    case 'lottie':
      $data['ext']  = 'lottie';
      $data['type'] = 'application/zip';
  }

  return $data;
}