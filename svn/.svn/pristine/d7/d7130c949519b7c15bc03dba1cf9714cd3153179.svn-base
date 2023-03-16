<?php

function getTemplate() {
  ob_start();
  include __DIR__ . '/ux_am_lottie.html';
  return ob_get_clean();
}

$position_options = require( __DIR__ . '/position.php' );
$position_options['options']['position_x']['on_change'] = array(
  'recompile' => false,
  'class' => 'x{{ value }} md-x{{ value }} lg-x{{ value }}'
);
$position_options['options']['position_y']['on_change'] = array(
  'recompile' => false,
  'class' => 'y{{ value }} md-y{{ value }} lg-y{{ value }}'
);

add_ux_builder_shortcode('ux_am_lottie', [
  'name' => 'LottiePlayer',
  'category' => __('Content'),
  'template' => getTemplate(),
  'toolbar_thumbnail' => 'img',
	'thumbnail'         => AM_LOTTIEPLAYER_URL . '/includes/flatsome/icon.svg',
  'allow_in' => ['text_box'],
  'wrap' => false,
  'options' => [
    'src' => [
      'type' => 'textfield',
      'full_width' => true,
      'default' => 'https://storage.googleapis.com/aarsteinmedia/am.lottie',
      'heading' => 'Lottie url',
      'description' => __('Animation Link URL', 'am-lottieplayer'),
    ],

    'height' => [
      'type' => 'scrubfield',
      'heading' => __('Height'),
      'default' => '56.25%',
      'placeholder' => __('Auto'),
      'min' => 0,
      'max' => 1000,
      'step' => 1,
      'helpers' => require( __DIR__ . '/image-heights.php' ),
        'on_change' => [
          'selector' => '.dotlottie-player',
          'style' => 'padding-top: {{ value }}'
        ]
    ],

    'position_options' => $position_options,
    'advanced_options' => require( __DIR__ . '/advanced.php'),
  ]
]);