<?php
namespace AAMD_Lottie;

use function AAMD_Lottie\Utility\get_asset;
use function AAMD_Lottie\Utility\get_script;

\defined( 'ABSPATH' ) || exit;

global $aamd_lottie_media;

// This check prevent the function from being loaded more than once
if ( ! function_exists( 'get_ux_template' ) ) {
	function get_ux_template() {
		wp_enqueue_script(
			'am-backend-ux',
			get_script( 'am-backend-ux.min.js' ),
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
	'heading' => esc_html__( 'Position', 'am-lottieplayer' ),
	'require' => array( 'ux_banner' ),
	'options' => array(
		'position_x' => array(
			'type'              => 'slider',
			'heading'           => esc_html__( 'Horizontal', 'am-lottieplayer' ),
			'save_when_default' => true,
			'responsive'        => true,
			'default'           => 50,
			'min'               => 0,
			'max'               => 100,
			'step'              => 5,
		),
		'position_y' => array(
			'type'              => 'slider',
			'heading'           => esc_html__( 'Vertical', 'am-lottieplayer' ),
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
	'am-lottieplayer',
	array(
		'name'              => 'AM LottiePlayer',
		'category'          => esc_html__( 'Content', 'am-lottieplayer' ),
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
				'heading'     => esc_html__( 'Lottie url', 'am-lottieplayer' ),
				'description' => esc_html__( 'Paste in url to Lottie, either from CDN or you local Media Library.', 'am-lottieplayer' ),
			),

			'animation_options' => array(
				'type'    => 'group',
				'heading' => esc_html__( 'Animation Options', 'am-lottieplayer' ),
				'options' => array(
					'controls'          => array(
						'type'    => 'checkbox',
						'heading' => esc_html__( 'Controls', 'am-lottieplayer' ),
					),

					'autoplay'          => array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Autoplay', 'am-lottieplayer' ),
						'conditions' => 'animate_on_scroll !== "true"',
					),

					'loop'              => array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Loop', 'am-lottieplayer' ),
						'conditions' => 'animate_on_scroll !== "true"',
					),

					'mode'              => array(
						'type'        => 'checkbox',
						'heading'     => $pro_feature . esc_html__( 'Boomerang', 'am-lottieplayer' ),
						'description' => $pro_link,
						'conditions'  => 'animate_on_scroll !== "true"',
					),

					'direction'         => array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Reverse', 'am-lottieplayer' ),
						'conditions' => 'animate_on_scroll !== "true"',
					),

					'subframe'          => array(
						'type'    => 'checkbox',
						'heading' => esc_html__( 'Subframe', 'am-lottieplayer' ),
					),

					'speed'             => array(
						'type'       => 'slider',
						'heading'    => esc_html__( 'Speed', 'am-lottieplayer' ),
						'default'    => 1,
						'min'        => 1,
						'max'        => 5,
						'step'       => 1,
						'unit'       => '',
						'conditions' => 'animate_on_scroll !== "true"',
					),

					'intermission'      => array(
						'type'        => 'slider',
						'heading'     => esc_html__( 'Intermission', 'am-lottieplayer' ),
						'description' => esc_html__( 'Pause between loops, in miliseconds. 1s = 1000', 'am-lottieplayer' ),
						'default'     => 0,
						'min'         => 0,
						'max'         => 5000,
						'step'        => 100,
						'unit'        => '',
						'conditions'  => 'loop === "true"',
					),

					'segment_in'        => array(
						'type'        => 'slider',
						'heading'     => $pro_feature . esc_html__( 'Choose where to start', 'am-lottieplayer' ),
						'description' => $pro_link,
						'default'     => null,
						'min'         => 0,
						'step'        => 1,
						'unit'        => '',
					),

					'segment_out'       => array(
						'type'        => 'slider',
						'heading'     => $pro_feature . esc_html__( 'And where to end', 'am-lottieplayer' ),
						'description' => $pro_link,
						'default'     => null,
						'min'         => 0,
						'step'        => 1,
						'unit'        => '',
					),

					'animate_on_scroll' => array(
						'type'        => 'checkbox',
						'heading'     => $pro_feature . esc_html__( 'Animate on scroll', 'am-lottieplayer' ),
						'description' => esc_html__( 'Make the animation play only when scrolling, relative to the speed and direction of the scroll', 'am-lottieplayer' ) . $pro_link,
					),

					'onclick'           => array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Play on click', 'am-lottieplayer' ),
						'conditions' => 'animate_on_scroll !== "true"',
					),

					'onmouseover'       => array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Play on mouseover', 'am-lottieplayer' ),
						'conditions' => 'animate_on_scroll !== "true"',
					),

					'onmouseout'        => array(
						'type'       => 'select',
						'heading'    => esc_html__( 'On mouseout', 'am-lottieplayer' ),
						'conditions' => 'onmouseover === "true"',
						'options'    => array(
							'void'    => esc_html__( 'No event', 'am-lottieplayer' ),
							'stop'    => esc_html__( 'Stop', 'am-lottieplayer' ),
							'pause'   => esc_html__( 'Pause', 'am-lottieplayer' ),
							'reverse' => esc_html__( 'Reverse', 'am-lottieplayer' ),
						),
					),

					'selector'          => array(
						'type'        => 'textfield',
						'heading'     => $pro_feature . esc_html__( 'Trigger element', 'am-lottieplayer' ),
						'description' => esc_html__( 'Anchor tag (id) for an element you want to trigger the animation, either by hover or click.', 'am-lottieplayer' ) . $pro_link,
						'conditions'  => 'onmouseover === "true" || onclick === "true"',
					),

					'exclude_selector'  => array(
						'type'        => 'checkbox',
						'heading'     => $pro_feature . esc_html__( 'Apply interaction only to trigger element', 'am-lottieplayer' ),
						'description' => $pro_link,
						'conditions'  => 'onmouseover === "true" || onclick === "true"',
					),

					'scroll'            => array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Play on scroll, when visible in viewport', 'am-lottieplayer' ),
						'conditions' => 'animate_on_scroll !== "true"',
					),

					'delay'             => array(
						'type'       => 'slider',
						'heading'    => esc_html__( 'Delay, in 10th of a second', 'am-lottieplayer' ),
						'conditions' => 'scroll === "true"',
						'default'    => 1,
						'min'        => 0,
						'max'        => 50,
						'step'       => 1,
					),

					'once'              => array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Play only once', 'am-lottieplayer' ),
						'conditions' => 'scroll === "true"',
					),
				),
			),

			'layout_options'    => array(
				'type'    => 'group',
				'heading' => esc_html__( 'Layout Options', 'am-lottieplayer' ),
				'options' => array(
					'width'     => array(
						'type'       => 'scrubfield',
						'heading'    => esc_html__( 'Width', 'am-lottieplayer' ),
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
						'heading'     => esc_html__( 'Height', 'am-lottieplayer' ),
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
						'heading' => esc_html__( 'Object fit', 'am-lottieplayer' ),
						'default' => 'contain',
						'options' => array(
							'contain' => esc_html__( 'Contain', 'am-lottieplayer' ),
							'cover'   => esc_html__( 'Cover', 'am-lottieplayer' ),
							'fill'    => esc_html__( 'Fill', 'am-lottieplayer' ),
							'none'    => esc_html__( 'None', 'am-lottieplayer' ),
						),
					),
				),
			),

			'position_options'  => $position_options,

			'advanced_options'  => array(
				'type'    => 'group',
				'heading' => esc_html__( 'Advanced Options', 'am-lottieplayer' ),
				'options' => array(

					'renderer'   => array(
						'type'        => 'select',
						'heading'     => $pro_feature . esc_html__( 'Renderer', 'am-lottieplayer' ),
						'description' => $pro_link,
						'default'     => 'svg',
						'options'     => array(
							'svg'    => 'SVG',
							'canvas' => 'Canvas',
							// 'html'   => 'HTML',
						),
					),

					'class'      => array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'CSS-class', 'am-lottieplayer' ),
						'param_name' => 'class',
						'default'    => '',
					),

					'alt'        => array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Description', 'am-lottieplayer' ),
						'description' => esc_html__( 'Helpful for screen readers and search engines', 'am-lottieplayer' ),
					),

					'visibility' => array(
						'type'    => 'select',
						'heading' => esc_html__( 'Visibility', 'am-lottieplayer' ),
						'default' => '',
						'options' => array(
							''                => esc_html__( 'Visible', 'am-lottieplayer' ),
							'hidden'          => esc_html__( 'Hidden', 'am-lottieplayer' ),
							'hide-for-medium' => esc_html__( 'Only for Desktiop', 'am-lottieplayer' ),
							'show-for-small'  => esc_html__( 'Only for Mobile', 'am-lottieplayer' ),
							'show-for-medium hide-for-small' => esc_html__( 'Only for Tablet', 'am-lottieplayer' ),
							'show-for-medium' => esc_html__( 'Hide for Desktop', 'am-lottieplayer' ),
							'hide-for-small'  => esc_html__( 'Hide for Mobile', 'am-lottieplayer' ),
						),
					),
				),
			),
		),
	)
);
