<?php
if (!function_exists('aspectRatio')) {
  function aspectRatio($objectFit) {
    switch ($objectFit) {
      case 'contain' || 'scale-down':
        return 'xMidYMid meet';
      case 'cover':
        return 'xMidYMid slice';
      case 'fill':
        return 'none';
      case 'none':
        return 'xMinYMin slice';
      default:
        return 'xMidYMid meet';
    }
  }
}

if (!function_exists('am_render_lottieplayer')) {
  function am_render_lottieplayer($atts) {
    ob_start(); ?>
    <dotlottie-player
      <?php echo esc_html($atts['autoplay']) && esc_html($atts['autoplay']) !== 'false' ? 'autoplay' : ''; ?>
      background="<?php echo esc_html($atts['background']) ?? 'transparent'; ?>"
      <?php echo esc_html($atts['controls']) && esc_html($atts['controls']) !== 'false'  ? 'controls' : ''; ?>
      description="<?php echo esc_html($atts['alt']); ?>"
      <?php echo esc_html($atts['loop']) && esc_html($atts['loop']) !== 'false' ? 'loop' : ''; ?>
      mode="<?php echo esc_html($atts['mode']); ?>"
      preserveaspectratio="<?php echo aspectRatio(esc_html($atts['objectFit'])); ?>"
      src="<?php echo esc_url($atts['src']); ?>"
    >
    </dotlottie-player>
    <?php
    return ob_get_clean();
  }
}

if (!function_exists('am_render_lottieplayer_shortcode')) {
  function am_render_lottieplayer_shortcode($atts) {
    if (empty(esc_url($atts['src']))) {
      return '';
    }

    $atts = shortcode_atts([
      'align' => 'none',
      'alt' => __( 'Lottie animation' ),
      'autoplay' => true,
      'background' => 'transparent',
      'controls' => true,
      'direction' => 1,
      'height' => null,
      'id' => null,
      'interactivityType' => 'none',
      'loop' => true,
      'mode' => 'normal',
      'objectFit' => 'contain',
      'renderer' => 'svg',
      'speed' => 1,
      'src' => '',
      'width' => null,
    ], $atts);

    ob_start(); ?>
    <figure
      class="wp-block-gb-lottieplayer align<?php echo esc_html($atts['align']) ?? 'none'; ?>"
      style="
        background-color: <?php echo $atts['background']; ?>;
        height: <?php echo esc_html($atts['height']) ? esc_html($atts['height']) . 'px' : 'auto'; ?>;
        width: <?php echo esc_html($atts['width']) ? esc_html($atts['width']) . 'px' : 'auto'; ?>;
      "
    >
      <?php echo am_render_lottieplayer($atts); ?>
    </figure>
    <?php
    return ob_get_clean();
  }
}
