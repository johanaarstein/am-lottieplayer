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

add_ux_builder_shortcode('am-lottieplayer', [
  'name' => 'LottiePlayer',
  'category' => __('Content'),
  'template' => getTemplate(),
  'toolbar_thumbnail' => 'img',
	'thumbnail' => AM_LOTTIEPLAYER_URL . '/includes/flatsome/icon.svg',
  'allow_in' => ['text_box'],
  'wrap' => false,
  'options' => [

    'src' => [
      'type' => 'image',
      'full_width' => true,
      'default' => 'https://storage.googleapis.com/aarsteinmedia/am.lottie',
      'heading' => __('Choose animation', 'am-lottieplayer'),
    ],

    'animation_options' => [
      'type' => 'group',
      'heading' => __('Animation Options', 'am-lottieplayer'),
      'options' => [
        'autoplay' => [
          'type' => 'checkbox',
          'heading' => __('Autoplay', 'am-lottieplayer'),
        ],

        'controls' => [
          'type' => 'checkbox',
          'heading' => __('Controls', 'am-lottieplayer'),
        ],

        'loop' => [
          'type' => 'checkbox',
          'heading' => __('Loop', 'am-lottieplayer'),
        ],

        'reverse' => [
          'type' => 'checkbox',
          'heading' => __('Reverse', 'am-lottieplayer'),
          'description' => __('Reverse the animation.', 'am-lottieplayer')
        ],
      ],
    ],

    'layout_options' => [
      'type' => 'group',
      'heading' => __('Layout Options', 'am-lottieplayer'),
      'options' => [
        'width' => [
          'type' => 'scrubfield',
          'heading' => __('Width', 'am-lottieplayer'),
          'placeholder' => __('Width in px', 'am-lottieplayer'),
          'default' => '',
          'min' => '0',
        ],
      ],
    ],

    'position_options' => $position_options,
    'advanced_options' => require( __DIR__ . '/advanced.php'),
  ]
]);