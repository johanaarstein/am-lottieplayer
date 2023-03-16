<?php

vc_add_shortcode_param('attach_lottie', 'attach_field_settings');
function attach_field_settings($settings) {
  return
  '<div class="am-upload">
    <button
      id="' . esc_attr($settings['param_name']) . '-button"
      style="all:unset;cursor:pointer;background:#007cba;color:#fff;font-size:13px;padding:6px 12px;border-radius:2px;height:36px;align-items:center;display:inline-flex;-webkit-appearance:none;-moz-appearance:none;appearance:none;"
      class="' . esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field"
    >' . __('Media Library', 'am-lottieplayer') . '
    </button>
  </div>
  <script src="' . AM_LOTTIEPLAYER_URL . 'scripts/am-backend-vc.min.js" defer></script>';
}

vc_map(
  [
    'name' => __('AM LottiePlayer', 'am-lottieplayer'),
    'base' => 'am-lottieplayer',
    'controls' => 'full',
    'icon' => AM_LOTTIEPLAYER_URL . 'includes/vc/icon.svg',
    'category' => __('Animation', 'am-lottieplayer'),
    'params' => [
      [
        'type' => 'textfield',
        'heading' => __('Lottie url', 'am-lottieplayer'),
        'value' => AM_LOTTIEPLAYER_URL . 'includes/am.lottie',
        'param_name' => 'src',
      ],
      [
        'type' => 'attach_lottie',
        'heading' => __('Choose Lottie', 'am-lottieplayer'),
        'value' => '',
        'param_name' => 'attach_src'
      ],
      [
        'type' => 'checkbox',
        'heading' => __('Autoplay', 'am-lottieplayer'),
        'param_name' => 'autoplay',
      ],
      [
        'type' => 'checkbox',
        'heading' => __('Show controls', 'am-lottieplayer'),
        'param_name' => 'controls',
      ],
      [
        'type' => 'checkbox',
        'heading' => __('Loop', 'am-lottieplayer'),
        'param_name' => 'loop',
      ],
      [
        'type' => 'textfield',
        'heading' => __('Speed', 'am-lottieplayer'),
        'param_name' => 'speed',
        'value' => '1',
      ],
      [
        'type' => 'checkbox',
        'heading' => __('Reverse', 'am-lottieplayer'),
        'param_name' => 'direction',
      ],
      [
        'type' => 'checkbox',
        'heading' => __('Play on click', 'am-lottieplayer'),
        'param_name' => 'onclick',
      ],
      [
        'type' => 'checkbox',
        'heading' => __('Play on mouseover', 'am-lottieplayer'),
        'param_name' => 'onmouseover',
      ],
      [
        'type' => 'dropdown',
        'heading' => __('On mouseout', 'am-lottieplayer'),
        'param_name' => 'onmouseout',
        'value' => [
          __('No event', 'am-lottieplayer') => 'void',
          __('Stop', 'am-lottieplayer') => 'stop',
          __('Pause', 'am-lottieplayer') => 'pause',
          __('Reverse', 'am-lottieplayer') => 'reverse',
        ],
        'std' => 'void',
        'dependency' => [
          'element' => 'onmouseover',
          'value' => 'true'
        ],
      ],
      [
        'type' => 'textfield',
        'heading' => __('Width', 'am-lottieplayer'),
        'param_name' => 'width',
        'value' => null,
        'group' => __('Layout Options', 'am-lottieplayer' ),
      ],
      [
        'type' => 'textfield',
        'heading' => __('Height', 'am-lottieplayer'),
        'param_name' => 'height',
        'value' => null,
        'group' => __('Layout Options', 'am-lottieplayer' ),
      ],
      [
        'type' => 'dropdown',
        'heading' => __('Object fit', 'am-lottieplayer'),
        'param_name' => 'objectfit',
        'value' => [
          __('Contain', 'am-lottieplayer') => 'contain',
          __('Cover', 'am-lottieplayer') => 'cover',
          __('Fill', 'am-lottieplayer') => 'fill',
          __('None', 'am-lottieplayer') => 'none',
        ],
        'std' => 'contain',
        'group' => __('Layout Options', 'am-lottieplayer' ),
      ],
      [
        'type' => 'dropdown',
        'heading' => __('Renderer', 'am-lottieplayer'),
        'param_name' => 'renderer',
        'value' => [
          __('SVG', 'am-lottieplayer') => 'svg',
          __('Canvas', 'am-lottieplayer') => 'canvas',
          __('HTML', 'am-lottieplayer') => 'html',
        ],
        'std' => 'svg',
        'group' => __('Advanced Options', 'am-lottieplayer' ),
      ],
    ]
  ]
);