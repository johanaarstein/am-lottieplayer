<?php
if (!defined('ABSPATH')) exit('New phone, who diz?');

if (!function_exists('animationDirection')) {
  function animationDirection($input) {
    if ($input === 1 || $input === '1' || $input === '0') return 1;
    return -1;
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
      src="<?php echo esc_url($atts['src']); ?>"
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
    return ob_get_clean();
  }
}

if (!function_exists('am_render_lottieplayer_shortcode')) {
  function am_render_lottieplayer_shortcode($atts) {
    $atts = shortcode_atts([
      'align' => 'none',
      'alt' => __('Lottie animation', 'am-lottieplayer'),
      'autoplay' => false,
      'background' => 'transparent',
      'class' => '',
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
      class="am-lottieplayer align<?php echo esc_html($atts['align']) ?? 'none'; echo ' ' . esc_html($atts['class']); ?>"
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
