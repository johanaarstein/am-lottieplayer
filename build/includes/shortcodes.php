<?php
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

function render_lottieplayer($atts) {
  ob_start(); ?>
  <dotlottie-player
    <?php echo $atts['autoplay'] ? 'autoplay' : ''; ?>
    background="<?php echo $atts['background'] ?? 'transparent'; ?>"
    <?php echo $atts['controls'] ? 'controls' : ''; ?>
    description="<?php echo $atts['alt']; ?>"
    <?php echo $atts['loop'] ? 'loop' : ''; ?>
    mode="<?php echo $atts['mode']; ?>"
    preserveaspectratio="<?php echo aspectRatio($atts['objectFit']); ?>"
    src="<?php echo strip_tags($atts['src']); ?>"
  >
  </dotlottie-player>
  <?php
  return ob_get_clean();
}

function render_lottieplayer_shortcode($atts) {
  if (empty($atts['src'])) {
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
    class="wp-block-gb-lottieplayer align<?php echo $atts['align'] ?? 'none'; ?>"
    style="
      background-color: <?php echo $atts['background']; ?>;
      height: <?php echo $atts['height'] ? $atts['height'] . 'px' : 'auto'; ?>;
      width: <?php echo $atts['width'] ? $atts['width'] . 'px' : 'auto'; ?>;
    "
  >
    <?php echo render_lottieplayer($atts); ?>
  </figure>
  <?php
  return ob_get_clean();
}