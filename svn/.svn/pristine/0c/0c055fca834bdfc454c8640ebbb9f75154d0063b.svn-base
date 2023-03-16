<?php
if (!function_exists('animationDirection')) {
  function animationDirection($input) {
    switch ($input) {
      case 'true':
      case true:
        return -1;
      case '0':
      case 0:
      case false:
        return 1;
      default:
        return $input;
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
      objectfit="<?php echo esc_html($atts['objectfit']); ?>"
      src="<?php
        if (function_exists('vc_build_link')) {
          $src = vc_build_link($atts['src']);
          echo esc_url($src['url']);
        } else {
          echo esc_url($atts['src']);
        } ?>"
      renderer="<?php echo esc_html($atts['renderer']); ?>"
      speed="<?php echo esc_html($atts['speed']); ?>"
      direction="<?php echo animationDirection(esc_html($atts['direction'])); ?>"
      data-direction="<?php echo animationDirection(esc_html($atts['direction'])); ?>"
      data-mouseover="<?php echo esc_html($atts['onmouseover']); ?>"
      data-mouseout="<?php echo esc_html($atts['onmouseout']); ?>"
      data-click="<?php echo esc_html($atts['onclick']); ?>"
    >
    </dotlottie-player>
    <?php
    wp_enqueue_script('am-frontend');
    return ob_get_clean();
  }
}

if (!function_exists('am_render_lottieplayer_shortcode')) {
  function am_render_lottieplayer_shortcode($atts) {
    // if (!esc_url($atts['src']) || empty(esc_url($atts['src']))) {
    //   // error_log('Empty src in AM LottiePlayer');
    //   // return '';
    //   $atts['src'] =
    // }

    $atts = shortcode_atts([
      'align' => 'none',
      'alt' => __( 'Lottie animation' ),
      'autoplay' => false,
      'background' => 'transparent',
      'controls' => false,
      'direction' => 1,
      'height' => null,
      'id' => null,
      'interactivityType' => 'none',
      'loop' => false,
      'mode' => 'normal',
      'objectfit' => 'contain',
      'renderer' => 'svg',
      'speed' => 1,
      'src' => AM_LOTTIEPLAYER_URL . 'includes/am.lottie',
      'width' => null,
      'onmouseover' => false,
      'onclick' => false,
      'onmouseout' => 'void'
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
