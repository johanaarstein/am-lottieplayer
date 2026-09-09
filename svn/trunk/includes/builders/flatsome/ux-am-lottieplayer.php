<?php
namespace AAMD_Lottie;

use function AAMD_Lottie\Utility\get_asset;
use function AAMD_Lottie\Utility\get_script;

\defined( 'ABSPATH' ) || exit;

/** @var Media $aamd_lottie_media */
global $aamd_lottie_media;

// This check prevent the function from being loaded more than once
if ( ! function_exists( 'get_ux_template' ) ) {
	function get_ux_template() {
		wp_enqueue_script(
			'am-backend-ux',
			get_script( 'flatsome/am-backend-ux.min.js' ),
			array( AAMD_LOTTIE_IS_PRO ? 'dotlottie-player' : 'dotlottie-player-light' ),
			'1.0.1',
			true
		);
		// \ob_start();
		// include_file(
		// 'builders/flatsome/ux-am-lottieplayer-template',
		// null,
		// 'html'
		// );
		// return \ob_get_clean();
	}
}

// function enqueue_backend_ux_script() {
// wp_enqueue_script(
// 'am-backend-ux',
// get_script( 'am-backend-ux.min.js' ),
// array( AAMD_LOTTIE_IS_PRO ? 'dotlottie-player' : 'dotlottie-player-light' ),
// '1.0.1',
// true
// );
// }

// add_action(
// 'admin_enqueue_scripts',
// 'AAMD_Lottie\enqueue_backend_ux_script',
// );

$position_options = array(
	'type'    => 'group',
	'heading' => esc_html__( 'Position', TEXT_DOMAIN ),
	'require' => array( 'ux_banner' ),
	'options' => array(
		'position_x' => array(
			'type'              => 'slider',
			'heading'           => esc_html__( 'Horizontal', TEXT_DOMAIN ),
			'save_when_default' => true,
			'responsive'        => true,
			'default'           => 50,
			'min'               => 0,
			'max'               => 100,
			'step'              => 5,
		),
		'position_y' => array(
			'type'              => 'slider',
			'heading'           => esc_html__( 'Vertical', TEXT_DOMAIN ),
			'save_when_default' => true,
			'responsive'        => true,
			'default'           => 50,
			'min'               => 0,
			'max'               => 100,
			'step'              => 5,
		),
	),
);

$position_options['options']['position_x']['on_change'] = array(
	'recompile' => false,
	'class'     => 'x{{ value }} md-x{{ value }} lg-x{{ value }}',
);
$position_options['options']['position_y']['on_change'] = array(
	'recompile' => false,
	'class'     => 'y{{ value }} md-y{{ value }} lg-y{{ value }}',
);

global $pro_feature;
global $pro_link;

add_ux_builder_shortcode(
	TEXT_DOMAIN,
	array(
		'name'              => 'AM LottiePlayer',
		'category'          => esc_html__( 'Content', TEXT_DOMAIN ),
		'template'          => get_ux_template(),
		'toolbar_thumbnail' => 'img',
		'thumbnail'         => get_asset( 'ux-icon.svg' ),
		'allow_in'          => array( 'text_box' ),
		'inline'            => true,
		'wrap'              => false,
		'priority'          => 1,

		'options'           => array(

			'src'               => array(
				'type'        => 'textfield',
				'full_width'  => true,
				'default'     => $aamd_lottie_media->get_default_file(),
				'heading'     => esc_html__( 'Lottie url', TEXT_DOMAIN ),
				'description' => esc_html__( 'Paste in url to Lottie, either from CDN or you local Media Library.', TEXT_DOMAIN ),
			),

			'animation_options' => array(
				'type'    => 'group',
				'heading' => esc_html__( 'Animation Options', TEXT_DOMAIN ),
				'options' => array(
					'controls'         => array(
						'type'    => 'checkbox',
						'heading' => esc_html__( 'Controls', TEXT_DOMAIN ),
					),

					'autoplay'         => array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Autoplay', TEXT_DOMAIN ),
						'conditions' => 'animateonscroll !== "true"',
					),

					'loop'             => array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Loop', TEXT_DOMAIN ),
						'conditions' => 'animateonscroll !== "true"',
					),

					'mode'             => array(
						'type'        => 'checkbox',
						'heading'     => $pro_feature . esc_html__( 'Boomerang', TEXT_DOMAIN ),
						'description' => $pro_link,
						'conditions'  => 'animateonscroll !== "true"',
					),

					'direction'        => array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Reverse', TEXT_DOMAIN ),
						'conditions' => 'animateonscroll !== "true"',
					),

					'subframe'         => array(
						'type'    => 'checkbox',
						'heading' => esc_html__( 'Subframe', TEXT_DOMAIN ),
					),

					'speed'            => array(
						'type'       => 'slider',
						'heading'    => esc_html__( 'Speed', TEXT_DOMAIN ),
						'default'    => 1,
						'min'        => 1,
						'max'        => 5,
						'step'       => 1,
						'unit'       => '',
						'conditions' => 'animateonscroll !== "true"',
					),

					'intermission'     => array(
						'type'        => 'slider',
						'heading'     => esc_html__( 'Intermission', TEXT_DOMAIN ),
						'description' => esc_html__( 'Pause between loops, in miliseconds. 1s = 1000', TEXT_DOMAIN ),
						'default'     => 0,
						'min'         => 0,
						'max'         => 5000,
						'step'        => 100,
						'unit'        => '',
						'conditions'  => 'loop === "true"',
					),

					'segment_in'       => array(
						'type'        => 'slider',
						'heading'     => $pro_feature . esc_html__( 'Choose where to start', TEXT_DOMAIN ),
						'description' => $pro_link,
						'default'     => null,
						'min'         => 0,
						'step'        => 1,
						'unit'        => '',
					),

					'segment_out'      => array(
						'type'        => 'slider',
						'heading'     => $pro_feature . esc_html__( 'And where to end', TEXT_DOMAIN ),
						'description' => $pro_link,
						'default'     => null,
						'min'         => 0,
						'step'        => 1,
						'unit'        => '',
					),

					'animateonscroll'  => array(
						'type'        => 'checkbox',
						'heading'     => $pro_feature . esc_html__( 'Animate on scroll', TEXT_DOMAIN ),
						'description' => esc_html__( 'Make the animation play only when scrolling, relative to the speed and direction of the scroll', TEXT_DOMAIN ) . $pro_link,
					),

					'playonclick'      => array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Play on click', TEXT_DOMAIN ),
						'conditions' => 'animateonscroll !== "true"',
					),

					'hover'            => array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Play on mouseover', TEXT_DOMAIN ),
						'conditions' => 'animateonscroll !== "true"',
					),

					'mouseout'         => array(
						'type'       => 'select',
						'heading'    => esc_html__( 'On mouseout', TEXT_DOMAIN ),
						'conditions' => 'onmouseover === "true"',
						'options'    => array(
							'void'    => esc_html__( 'No event', TEXT_DOMAIN ),
							'stop'    => esc_html__( 'Stop', TEXT_DOMAIN ),
							'pause'   => esc_html__( 'Pause', TEXT_DOMAIN ),
							'reverse' => esc_html__( 'Reverse', TEXT_DOMAIN ),
						),
					),

					'selector'         => array(
						'type'        => 'textfield',
						'heading'     => $pro_feature . esc_html__( 'Trigger element', TEXT_DOMAIN ),
						'description' => esc_html__( 'Anchor tag (id) for an element you want to trigger the animation, either by hover or click.', TEXT_DOMAIN ) . $pro_link,
						'conditions'  => 'onmouseover === "true" || onclick === "true"',
					),

					'exclude_selector' => array(
						'type'        => 'checkbox',
						'heading'     => $pro_feature . esc_html__( 'Apply interaction only to trigger element', TEXT_DOMAIN ),
						'description' => $pro_link,
						'conditions'  => 'onmouseover === "true" || onclick === "true"',
					),

					'playonvisible'    => array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Play on scroll, when visible in viewport', TEXT_DOMAIN ),
						'conditions' => 'animateonscroll !== "true"',
					),

					'delay'            => array(
						'type'       => 'slider',
						'heading'    => esc_html__( 'Delay, in milliseconds', TEXT_DOMAIN ),
						'conditions' => 'scroll === "true"',
						'default'    => 0,
						'min'        => 0,
						'max'        => 5000,
						'step'       => 1,
					),

					'once'             => array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Play only once', TEXT_DOMAIN ),
						'conditions' => 'scroll === "true"',
					),
				),
			),

			'layout_options'    => array(
				'type'    => 'group',
				'heading' => esc_html__( 'Layout Options', TEXT_DOMAIN ),
				'options' => array(
					'width'     => array(
						'type'       => 'scrubfield',
						'heading'    => esc_html__( 'Width', TEXT_DOMAIN ),
						'responsive' => true,
						'default'    => null,
						'min'        => 10,
						'unit'       => '',
						'on_change'  => array(
							'style' => 'width: {{ value }}px',
						),
					),

					'height'    => array(
						'type'        => 'scrubfield',
						'heading'     => esc_html__( 'Height', TEXT_DOMAIN ),
						'placeholder' => 'auto',
						'default'     => null,
						'min'         => 10,
						'unit'        => '',
						'on_change'   => array(
							'style' => 'height: {{ value }}px',
						),
					),

					'objectfit' => array(
						'type'    => 'select',
						'heading' => esc_html__( 'Object fit', TEXT_DOMAIN ),
						'default' => 'contain',
						'options' => array(
							'contain' => esc_html__( 'Contain', TEXT_DOMAIN ),
							'cover'   => esc_html__( 'Cover', TEXT_DOMAIN ),
							'fill'    => esc_html__( 'Fill', TEXT_DOMAIN ),
							'none'    => esc_html__( 'None', TEXT_DOMAIN ),
						),
					),
				),
			),

			'position_options'  => $position_options,

			'advanced_options'  => array(
				'type'    => 'group',
				'heading' => esc_html__( 'Advanced Options', TEXT_DOMAIN ),
				'options' => array(

					'renderer'    => array(
						'type'        => 'select',
						'heading'     => $pro_feature . esc_html__( 'Renderer', TEXT_DOMAIN ),
						'description' => $pro_link,
						'default'     => 'svg',
						'options'     => array(
							'svg'    => 'SVG',
							'canvas' => 'Canvas',
							// 'html'   => 'HTML',
						),
					),

					'class'       => array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'CSS-class', TEXT_DOMAIN ),
						'param_name' => 'class',
						'default'    => '',
					),

					'description' => array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Description', TEXT_DOMAIN ),
						'description' => esc_html__( 'Helpful for screen readers and search engines', TEXT_DOMAIN ),
					),

					'visibility'  => array(
						'type'    => 'select',
						'heading' => esc_html__( 'Visibility', TEXT_DOMAIN ),
						'default' => '',
						'options' => array(
							''                => esc_html__( 'Visible', TEXT_DOMAIN ),
							'hidden'          => esc_html__( 'Hidden', TEXT_DOMAIN ),
							'hide-for-medium' => esc_html__( 'Only for Desktiop', TEXT_DOMAIN ),
							'show-for-small'  => esc_html__( 'Only for Mobile', TEXT_DOMAIN ),
							'show-for-medium hide-for-small' => esc_html__( 'Only for Tablet', TEXT_DOMAIN ),
							'show-for-medium' => esc_html__( 'Hide for Desktop', TEXT_DOMAIN ),
							'hide-for-small'  => esc_html__( 'Hide for Mobile', TEXT_DOMAIN ),
						),
					),
				),
			),
		),
	)
);
