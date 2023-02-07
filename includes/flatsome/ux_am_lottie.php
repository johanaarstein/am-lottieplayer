<?php

function getTemplate() {
  wp_enqueue_script('am-backend');
  ob_start();
  include __DIR__ . '/ux_am_lottie.html';
  return ob_get_clean();
}

$position_options = require __DIR__ . '/position.php';
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
      'type' => 'textfield',
      'full_width' => true,
      'default' => 'https://storage.googleapis.com/aarsteinmedia/am.lottie',
      'heading' => __('Lottie url', 'am-lottieplayer'),
      'description' => __('Paste in url to Lottie, either from CDN or you local Media Library.', 'am-lottieplayer')
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

        'speed' => [
          'type' => 'scrubfield',
          'heading' => __('Speed', 'am-lottieplayer'),
          'default' => 1,
          'min' => 1,
          'max' => 5,
          'step' => 1,
          'unit' => '',
        ],

        'direction' => [
          'type' => 'checkbox',
          'heading' => __('Reverse', 'am-lottieplayer'),
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
          'min' => 0,
        ],

        'objectFit' => [
          'type' => 'select',
          'heading' => __('Object fit', 'am-lottieplayer'),
          'default' => 'xMidYMid meet',
          'options' => [
            'xMidYMid meet' => __('Contain', 'am-lottieplayer'),
            'xMidYMid slice' => __('Cover', 'am-lottieplayer'),
            'none' => __('Fill', 'am-lottieplayer'),
            'xMinYMin slice' => __('None', 'am-lottieplayer')
          ],
        ],
      ],
    ],

    'position_options' => $position_options,

    'advanced_options' => [
      'type' => 'group',
      'heading' => __('Advanced Options', 'am-lottieplayer'),
      'options' => [

        'renderer' => [
          'type' => 'select',
          'heading' => __('Renderer', 'am-lottieplayer'),
          'default' => 'svg',
          'options' => [
            'svg' => 'SVG',
            'canvas' => 'Canvas',
            'html' => 'HTML'
          ]
        ],

        'class' => [
          'type' => 'textfield',
          'heading' => 'Class',
          'param_name' => 'class',
          'default' => '',
        ],

        'visibility'  => require( __DIR__ . '/visibility.php' ),
      ],
    ],
  ]
]);