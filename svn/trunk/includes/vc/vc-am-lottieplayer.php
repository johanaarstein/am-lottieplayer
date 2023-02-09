<?php

vc_map(
  [
    'name' => __('AM LottiePlayer', 'am-lottieplayer'),
    'base' => 'am-lottieplayer',
    'controls' => 'full',
    'icon' => AM_LOTTIEPLAYER_URL . 'includes/vc/icon.svg',
    'category' => __('Animation', 'am-lottieplayer'),
    // 'admin_enqueue_js' => [
    //   AM_LOTTIEPLAYER_URL . 'scripts/dotlottie-player.min.js',
    //   // AM_LOTTIEPLAYER_URL . 'scripts/am-backend.min.js',
    // ],
    // 'custom_markup' => '<a class="gallery_widget_add_images" href="javascript:;" use-single="true" title="Add Lottie"><i class="vc-composer-icon vc-c-icon-add"></i>Add Lottie</a>',
    'params' => [
      // [
      //   'type' => 'dropdown',
      //   'heading' => __('Animation source', 'am-lottieplayer'),
      //   'param_name' => 'source',
      //   'value' => [
      //     esc_html__('Media library', 'js_composer') => 'media_library',
      // 	  esc_html__('External links', 'js_composer') => 'external_link',
      //   ],
      //   'std' => 'media_library'
      // ],
      // [
      //   'heading' => __('Choose animation', 'am-lottieplayer'),
      //   'param_name' => 'src',
      //   'value' => '',
      //   'dependency' => [
      //     'element' => 'source',
      //     'value' => 'media_library',
      //   ],
      // ],
      [
        'type' => 'textfield',
        'heading' => esc_html__('Lottie url', 'am-lottieplayer'),
        'std' => AM_LOTTIEPLAYER_URL . 'includes/am.lottie',
        'param_name' => 'src',
        // 'dependency' => [
        //   'element' => 'source',
        //   'value' => 'external_link',
        // ],
      ],
      [
        'type' => 'checkbox',
        'heading' => __('Autoplay', 'am-lottieplayer'),
        'param_name' => 'autoplay',
      ],
      [
        'type' => 'checkbox',
        'heading' => __('Controls', 'am-lottieplayer'),
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