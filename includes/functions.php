<?php
defined('ABSPATH') || exit;

if (!function_exists('animationDirection')) {
  function animationDirection($input)
  {
    if ($input === 1 || $input === '1' || $input === '0') return 1;
    return -1;
  }
}

if (!function_exists('amTruish')) {
  function amTruish($input)
  {
    return $input === 'true' || $input === true || $input === 1 || $input === '1';
  }
}

if (!function_exists('animationMode')) {
  function animationMode($input)
  {
    if (
      $input === 'bounce' ||
      $input === 1 ||
      $input === '1' ||
      $input === 'true' ||
      $input === true
    ) {
      return 'bounce';
    }
    return 'normal';
  }
}

if (!function_exists('interactionSelector')) {
  function interactionSelector($input, $exclude = false)
  {
    if (!$input || is_object(json_decode($input))) return $input;
    return json_encode([
      "id" => $input,
      "exclude" => amTruish($exclude),
    ]);
  }
}

if (!function_exists('am_render_lottieplayer')) {
  function am_render_lottieplayer($atts)
  {
    ob_start(); ?>
    <dotlottie-player
      <?php echo esc_html($atts['autoplay']) && esc_html($atts['autoplay']) !== 'false' ? 'autoplay' : ''; ?>
      background="<?php echo esc_html($atts['background']) ?? 'transparent'; ?>"
      <?php echo esc_html($atts['controls']) && esc_html($atts['controls']) !== 'false'  ? 'controls' : ''; ?>
      description="<?php echo esc_html($atts['alt']); ?>"
      <?php echo esc_html($atts['loop']) && esc_html($atts['loop']) !== 'false' ? 'loop' : ''; ?>
      mode="<?php echo animationMode(esc_html($atts['mode'])); ?>"
      objectfit="<?php echo esc_html($atts['objectfit']); ?>"
      src="<?php echo esc_url($atts['src']); ?>"
      renderer="<?php echo esc_html($atts['renderer']); ?>"
      segment="<?php echo esc_html($atts['segment'] ??
        ($atts['segment_out'] &&
          $atts['segment_out'] !== '0' ?
          '[' . (intval($atts['segment_in']) ?? 0) . ',' . intval($atts['segment_out']) . ']' : '')); ?>"
      speed="<?php echo esc_html($atts['speed']); ?>"
      <?php echo esc_html($atts['subframe']) && esc_html($atts['subframe']) !== 'false' ? 'subframe' : ''; ?>
      direction="<?php echo animationDirection(esc_html($atts['direction'])); ?>"
      data-direction="<?php echo animationDirection(esc_html($atts['direction'])); ?>"
      data-mouseover="<?php echo esc_html($atts['onmouseover']); ?>"
      data-mouseout="<?php echo esc_html($atts['onmouseout']); ?>"
      data-click="<?php echo esc_html($atts['onclick']); ?>"
      data-selector="<?php echo esc_html(interactionSelector($atts['selector'], $atts['exclude'])); ?>"
      data-scroll="<?php echo esc_html($atts['scroll']); ?>"
      data-delay="<?php echo esc_html($atts['delay']); ?>"
      data-once="<?php echo esc_html($atts['once']); ?>">
    </dotlottie-player>
  <?php
    return ob_get_clean();
  }
}

if (!function_exists('am_render_lottieplayer_shortcode')) {
  function am_render_lottieplayer_shortcode($atts)
  {
    $atts = shortcode_atts([
      'align' => 'none',
      'alt' => __('AM LottiePlayer animation', 'am-lottieplayer'),
      'autoplay' => false,
      'background' => 'transparent',
      'class' => '',
      'controls' => false,
      'delay' => 100,
      'direction' => 1,
      'exclude' => false,
      'height' => null,
      'id' => null,
      'interactivityType' => 'none',
      'loop' => false,
      'mode' => 'normal',
      'objectfit' => 'contain',
      'renderer' => 'svg',
      'scroll' => false,
      'segment' => null,
      'segment_in' => null,
      'segment_out' => null,
      'speed' => 1,
      'selector' => null,
      'src' => esc_url(!is_wp_error(am_lottie_asset()) ? wp_get_attachment_url(am_lottie_asset()) : am_lottie_asset(true)),
      'subframe' => false,
      'width' => null,
      'onmouseover' => false,
      'onclick' => false,
      'onmouseout' => 'void',
      'once' => false,
    ], $atts);

    ob_start(); ?>
    <figure class="am-lottieplayer align<?php echo esc_html($atts['align']) ?? 'none';
                                        echo ' ' . esc_html($atts['class']); ?>" style="
        background-color: <?php echo $atts['background']; ?>;
        height: <?php echo esc_html($atts['height']) ? esc_html($atts['height']) . 'px' : 'auto'; ?>;
        width: <?php echo esc_html($atts['width']) ? esc_html($atts['width']) . 'px' : 'auto'; ?>;
      ">
      <?php echo am_render_lottieplayer($atts); ?>
    </figure>
<?php
    return ob_get_clean();
  }
}

/**
 * am_get_path
 * Returns the plugin path to a specified file.
 *
 * @param   string $filename The specified file.
 * @return  string
 */
function am_get_path($filename = '')
{
  return AM_LOTTIEPLAYER_PATH . ltrim($filename, '/');
}

/**
 * am_include
 * Includes a file within the plugin.
 *
 * @param string $filename The specified file.
 * @param mixed $arg (optional)
 * @return void
 */
function am_include($filename = '', $arg = null)
{
  $file_path = am_get_path($filename);
  if (file_exists($file_path)) {
    $arg;
    include_once $file_path;
  }
}
