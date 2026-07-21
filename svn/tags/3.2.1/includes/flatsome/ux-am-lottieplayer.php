<?php
defined('ABSPATH') || exit;

if (!function_exists('am_ux_get_template')) {
  function am_ux_get_template()
  {
    wp_enqueue_script('am-backend-ux');
    ob_start();
    include __DIR__ . '/ux-am-lottieplayer.html';
    return ob_get_clean();
  }
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
  'template' => am_ux_get_template(),
  'toolbar_thumbnail' => 'img',
  'thumbnail' => AM_LOTTIEPLAYER_URL . 'assets/ux-icon.svg',
  'allow_in' => ['text_box'],
  'wrap' => false,
  'options' => [

    'src' => [
      'type' => 'textfield',
      'full_width' => true,
      'default' => esc_url(!is_wp_error(am_lottie_asset()) ? wp_get_attachment_url(am_lottie_asset()) : am_lottie_asset(true)),
      'heading' => __('Lottie url', 'am-lottieplayer'),
      'description' => __('Paste in url to Lottie, either from CDN or you local Media Library.', 'am-lottieplayer')
    ],

    'animation_options' => [
      'type' => 'group',
      'heading' => __('Animation Options', 'am-lottieplayer'),
      'options' => [
        'controls' => [
          'type' => 'checkbox',
          'heading' => __('Controls', 'am-lottieplayer'),
        ],

        'autoplay' => [
          'type' => 'checkbox',
          'heading' => __('Autoplay', 'am-lottieplayer'),
        ],

        'loop' => [
          'type' => 'checkbox',
          'heading' => __('Loop', 'am-lottieplayer'),
        ],

        'mode' => [
          'type' => 'checkbox',
          'heading' => __('Boomerang', 'am-lottieplayer'),
        ],

        'direction' => [
          'type' => 'checkbox',
          'heading' => __('Reverse', 'am-lottieplayer'),
        ],

        'subframe' => [
          'type' => 'checkbox',
          'heading' => __('Subframe', 'am-lottieplayer'),
        ],

        'speed' => [
          'type' => 'slider',
          'heading' => __('Speed', 'am-lottieplayer'),
          'default' => 1,
          'min' => 1,
          'max' => 5,
          'step' => 1,
          'unit' => '',
        ],

        'segment_in' => [
          'type' => 'slider',
          'heading' => __('Choose where to start', 'am-lottieplayer'),
          'default' => null,
          'min' => 0,
          'step' => 1,
          'unit' => '',
        ],

        'segment_out' => [
          'type' => 'slider',
          'heading' => __('And where to end', 'am-lottieplayer'),
          'default' => null,
          'min' => 0,
          'step' => 1,
          'unit' => '',
        ],

        'onclick' => [
          'type' => 'checkbox',
          'heading' => __('Play on click', 'am-lottieplayer'),
        ],

        'onmouseover' => [
          'type' => 'checkbox',
          'heading' => __('Play on mouseover', 'am-lottieplayer'),
        ],

        'onmouseout' => [
          'type' => 'select',
          'heading' => __('On mouseout', 'am-lottieplayer'),
          'conditions' => 'onmouseover === "true"',
          'options' => [
            'void' => __('No event', 'am-lottieplayer'),
            'stop' => __('Stop', 'am-lottieplayer'),
            'pause' => __('Pause', 'am-lottieplayer'),
            'reverse' => __('Reverse', 'am-lottieplayer')
          ]
        ],

        'selector' => [
          'type' => 'textfield',
          'heading' => __('Trigger element', 'am-lottieplayer'),
          'description' => __('Anchor tag (id) for an element you want to trigger the animation, either by hover or click.', 'am-lottieplayer'),
          'conditions' => 'onmouseover === "true" || onclick === "true"',
        ],

        'exclude' => [
          'type' => 'checkbox',
          'heading' => __('Apply interaction only to trigger element', 'am-lottieplayer'),
          'conditions' => 'onmouseover === "true" || onclick === "true"',
        ],

        'scroll' => [
          'type' => 'checkbox',
          'heading' => __('Play on scroll, when visible in viewport', 'am-lottieplayer'),
        ],

        'delay' => [
          'type' => 'slider',
          'heading' => __('Delay, in 10th of a second', 'am-lottieplayer'),
          'conditions' => 'scroll === "true"',
          'default' => 1,
          'min' => 0,
          'max' => 50,
          'step' => 1,
        ],

        'once' => [
          'type' => 'checkbox',
          'heading' => __('Play only once', 'am-lottieplayer'),
          'conditions' => 'scroll === "true"',
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
          'responsive' => true,
          'default' => null,
          'min' => 10,
          'unit' => '',
          'on_change' => [
            'style' => 'width: {{ value }}px'
          ]
        ],

        'height' => [
          'type' => 'scrubfield',
          'heading' => __('Height', 'am-lottieplayer'),
          'placeholder' => 'auto',
          'default' => null,
          'min' => 10,
          'unit' => '',
          'on_change' => [
            'style' => 'height: {{ value }}px'
          ]
        ],

        'objectfit' => [
          'type' => 'select',
          'heading' => __('Object fit', 'am-lottieplayer'),
          'default' => 'contain',
          'options' => [
            'contain' => __('Contain', 'am-lottieplayer'),
            'cover' => __('Cover', 'am-lottieplayer'),
            'fill' => __('Fill', 'am-lottieplayer'),
            'none' => __('None', 'am-lottieplayer')
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
          'heading' => __('CSS-class', 'am-lottieplayer'),
          'param_name' => 'class',
          'default' => '',
        ],

        'alt' => [
          'type' => 'textfield',
          'heading' => __('Description', 'am-lottieplayer'),
          'description' => __('Helpful for screen readers and search engines', 'am-lottieplayer'),
        ],

        'visibility'  => require(__DIR__ . '/visibility.php'),
      ],
    ],
  ]
]);
