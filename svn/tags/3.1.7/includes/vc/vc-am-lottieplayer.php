<?php
defined('ABSPATH') || exit;

vc_add_shortcode_param('attach_lottie', 'am_vc_attach_field_settings');
if (!function_exists('am_vc_attach_field_settings')) {
  function am_vc_attach_field_settings($settings)
  {
    return
      '<div class="am-upload">
      <button
        id="' . esc_attr($settings['param_name']) . '-button"
        style="all:unset;cursor:pointer;background:#007cba;color:#fff;font-size:13px;padding:6px 12px;border-radius:2px;height:36px;align-items:center;display:inline-flex;-webkit-appearance:none;-moz-appearance:none;appearance:none;"
        class="' . esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field"
      >' . __('Media Library', 'am-lottieplayer') . '
      </button>
    </div>
    <script src="' . AM_LOTTIEPLAYER_URL . 'scripts/am-backend-vc-options.min.js" defer></script>';
  }
}

vc_map(
  [
    'name' => __('AM LottiePlayer', 'am-lottieplayer'),
    'base' => 'am-lottieplayer',
    'controls' => 'full',
    'icon' => AM_LOTTIEPLAYER_URL . 'assets/vc-icon.svg',
    'category' => __('Animation', 'am-lottieplayer'),
    // 'admin_enqueue_js' => AM_LOTTIEPLAYER_URL . 'scripts/am-backend-vc-editor.min.js',
    // 'front_enqueue_js' => AM_LOTTIEPLAYER_URL . 'scripts/am-frontend-vc-editor.min.js',
    // 'js_view' => 'AMLottiePlayerView',
    'params' => [
      [
        'type' => 'textfield',
        'heading' => __('Lottie url', 'am-lottieplayer'),
        'value' => esc_url(!is_wp_error(am_lottie_asset()) ? wp_get_attachment_url(am_lottie_asset()) : am_lottie_asset(true)),
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
        'heading' => __('Show controls', 'am-lottieplayer'),
        'param_name' => 'controls',
      ],
      [
        'type' => 'checkbox',
        'heading' => __('Autoplay', 'am-lottieplayer'),
        'param_name' => 'autoplay',
      ],
      [
        'type' => 'checkbox',
        'heading' => __('Loop', 'am-lottieplayer'),
        'param_name' => 'loop',
      ],
      [
        'type' => 'checkbox',
        'heading' => __('Boomerang', 'am-lottieplayer'),
        'param_name' => 'mode',
      ],
      [
        'type' => 'checkbox',
        'heading' => __('Reverse', 'am-lottieplayer'),
        'param_name' => 'direction',
      ],
      [
        'type' => 'checkbox',
        'heading' => __('Subframe', 'am-lottieplayer'),
        'param_name' => 'subframe',
        'checked' => 'true',
      ],
      [
        'type' => 'textfield',
        'heading' => __('Speed', 'am-lottieplayer'),
        'param_name' => 'speed',
        'value' => '1',
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
        'heading' => __('Trigger element', 'am-lottieplayer'),
        'description' => __('Anchor tag (id) for an element you want to trigger the animation, either by hover or click.', 'am-lottieplayer'),
        'param_name' => 'selector',
        'value' => '',
      ],
      [
        'type' => 'checkbox',
        'heading' => __('Apply interaction only to trigger element', 'am-lottieplayer'),
        'param_name' => 'exclude',
      ],
      [
        'type' => 'checkbox',
        'heading' => __('Play on scroll, when visible in viewport', 'am-lottieplayer'),
        'param_name' => 'scroll'
      ],
      [
        'type' => 'textfield',
        'heading' => __('Delay, in 10th of a second', 'am-lottieplayer'),
        'param_name' => 'delay',
        'dependency' => [
          'element' => 'scroll',
          'value' => 'true'
        ]
      ],
      [
        'type' => 'checkbox',
        'heading' => __('Play only once', 'am-lottieplayer'),
        'param_name' => 'once',
        'dependency' => [
          'element' => 'scroll',
          'value' => 'true'
        ]
      ],
      [
        'type' => 'textfield',
        'heading' => __('Width', 'am-lottieplayer'),
        'param_name' => 'width',
        'value' => null,
        'group' => __('Layout Options', 'am-lottieplayer'),
      ],
      [
        'type' => 'textfield',
        'heading' => __('Height', 'am-lottieplayer'),
        'param_name' => 'height',
        'value' => null,
        'group' => __('Layout Options', 'am-lottieplayer'),
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
        'group' => __('Layout Options', 'am-lottieplayer'),
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
        'group' => __('Advanced Options', 'am-lottieplayer'),
      ],
      [
        'type' => 'textfield',
        'heading' => __('Description', 'am-lottieplayer'),
        'param_name' => 'alt',
        'description' => __('Helpful for screen readers and search engines', 'am-lottieplayer'),
        'group' => __('Advanced Options', 'am-lottieplayer'),
      ],
    ]
  ]
);
