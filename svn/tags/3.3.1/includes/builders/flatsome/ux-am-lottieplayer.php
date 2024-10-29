<?php
\defined( 'ABSPATH' ) || exit;

// use function AAMD_Lottie\Utility\include_file;
use function AAMD_Lottie\Utility\get_asset;
use function AAMD_Lottie\Utility\get_script;

global $aamd_lottie_media;

if ( ! function_exists( 'aamd_lottie_get_ux_template' ) ) {
	function aamd_lottie_get_ux_template() {
		wp_enqueue_script(
			'am-backend-ux',
			get_script( 'am-backend-ux.min.js' ),
			array( 'dotlottie-player-light' ),
			'1.0.1',
			true
		);
		// \ob_start();
		// include_file(
		// 	'builders/flatsome/ux-am-lottieplayer-template',
		// 	null,
		// 	'html'
		// );
		// return \ob_get_clean();
	}
}

$position_options                                       = require __DIR__ . '/position.php';
$position_options['options']['position_x']['on_change'] = array(
	'recompile' => false,
	'class'     => 'x{{ value }} md-x{{ value }} lg-x{{ value }}',
);
$position_options['options']['position_y']['on_change'] = array(
	'recompile' => false,
	'class'     => 'y{{ value }} md-y{{ value }} lg-y{{ value }}',
);

$proLink = esc_html__( 'This feature will only work in the premium version. Read about additional features in AM LottiePlayer PRO on www.aarstein.media/am-lottieplayer/pro', 'am-lottieplayer' );

add_ux_builder_shortcode(
	'am-lottieplayer',
	array(
		'name'              => 'AM LottiePlayer',
		'category'          => __( 'Content' ),
		'template'          => aamd_lottie_get_ux_template(),
		'toolbar_thumbnail' => 'img',
		'thumbnail'         => get_asset( 'ux-icon.svg' ),
		'allow_in'          => array( 'text_box' ),
		'wrap'              => false,
		'options'           => array(

			'src'               => array(
				'type'        => 'textfield',
				'full_width'  => true,
				'default'     => esc_url( $aamd_lottie_media->get_default_file() ),
				'heading'     => __( 'Lottie url', 'am-lottieplayer' ),
				'description' => __( 'Paste in url to Lottie, either from CDN or you local Media Library.', 'am-lottieplayer' ),
			),

			'animation_options' => array(
				'type'    => 'group',
				'heading' => __( 'Animation Options', 'am-lottieplayer' ),
				'options' => array(
					'controls'         => array(
						'type'    => 'checkbox',
						'heading' => __( 'Controls', 'am-lottieplayer' ),
					),

					'autoplay'         => array(
						'type'    => 'checkbox',
						'heading' => __( 'Autoplay', 'am-lottieplayer' ),
					),

					'loop'             => array(
						'type'    => 'checkbox',
						'heading' => __( 'Loop', 'am-lottieplayer' ),
					),

					'mode'             => array(
						'type'        => 'checkbox',
						'heading'     => 'Pro Feature: ' . __( 'Boomerang', 'am-lottieplayer' ),
						'description' => $proLink,
					),

					'direction'        => array(
						'type'    => 'checkbox',
						'heading' => __( 'Reverse', 'am-lottieplayer' ),
					),

					'subframe'         => array(
						'type'    => 'checkbox',
						'heading' => __( 'Subframe', 'am-lottieplayer' ),
					),

					'speed'            => array(
						'type'    => 'slider',
						'heading' => __( 'Speed', 'am-lottieplayer' ),
						'default' => 1,
						'min'     => 1,
						'max'     => 5,
						'step'    => 1,
						'unit'    => '',
					),

					'intermission'     => array(
						'type'        => 'slider',
						'heading'     => __( 'Intermission', 'am-lottieplayer' ),
						'description' => esc_html__( 'Pause between loops, in miliseconds. 1s = 1000', 'am-lottieplayer' ),
						'default'     => 0,
						'min'         => 0,
						'max'         => 5000,
						'step'        => 100,
						'unit'        => '',
						'conditions'  => 'loop === "true"',
					),

					'segment_in'       => array(
						'type'        => 'slider',
						'heading'     => 'Pro Feature: ' . __( 'Choose where to start', 'am-lottieplayer' ),
						'description' => $proLink,
						'default'     => null,
						'min'         => 0,
						'step'        => 1,
						'unit'        => '',
					),

					'segment_out'      => array(
						'type'        => 'slider',
						'heading'     => 'Pro Feature: ' . __( 'And where to end', 'am-lottieplayer' ),
						'description' => $proLink,
						'default'     => null,
						'min'         => 0,
						'step'        => 1,
						'unit'        => '',
					),

					'none'             => array(
						'type'        => 'checkbox',
						'description' => $proLink,
						'heading'     => __( 'Animate on scroll', 'am-lottieplayer' ),
					),

					'onclick'          => array(
						'type'    => 'checkbox',
						'heading' => __( 'Play on click', 'am-lottieplayer' ),
					),

					'onmouseover'      => array(
						'type'    => 'checkbox',
						'heading' => __( 'Play on mouseover', 'am-lottieplayer' ),
					),

					'onmouseout'       => array(
						'type'       => 'select',
						'heading'    => __( 'On mouseout', 'am-lottieplayer' ),
						'conditions' => 'onmouseover === "true"',
						'options'    => array(
							'void'    => __( 'No event', 'am-lottieplayer' ),
							'stop'    => __( 'Stop', 'am-lottieplayer' ),
							'pause'   => __( 'Pause', 'am-lottieplayer' ),
							'reverse' => __( 'Reverse', 'am-lottieplayer' ),
						),
					),

					'selector'         => array(
						'type'        => 'textfield',
						'heading'     => 'Pro Feature: ' . __( 'Trigger element', 'am-lottieplayer' ),
						'description' => __( 'Anchor tag (id) for an element you want to trigger the animation, either by hover or click.', 'am-lottieplayer' ) . $proLink,
						'conditions'  => 'onmouseover === "true" || onclick === "true"',
					),

					'exclude_selector' => array(
						'type'        => 'checkbox',
						'heading'     => 'Pro Feature: ' . __( 'Apply interaction only to trigger element', 'am-lottieplayer' ),
						'description' => $proLink,
						'conditions'  => 'onmouseover === "true" || onclick === "true"',
					),

					'scroll'           => array(
						'type'    => 'checkbox',
						'heading' => __( 'Play on scroll, when visible in viewport', 'am-lottieplayer' ),
					),

					'delay'            => array(
						'type'       => 'slider',
						'heading'    => __( 'Delay, in 10th of a second', 'am-lottieplayer' ),
						'conditions' => 'scroll === "true"',
						'default'    => 1,
						'min'        => 0,
						'max'        => 50,
						'step'       => 1,
					),

					'once'             => array(
						'type'       => 'checkbox',
						'heading'    => __( 'Play only once', 'am-lottieplayer' ),
						'conditions' => 'scroll === "true"',
					),
				),
			),

			'layout_options'    => array(
				'type'    => 'group',
				'heading' => __( 'Layout Options', 'am-lottieplayer' ),
				'options' => array(
					'width'     => array(
						'type'       => 'scrubfield',
						'heading'    => __( 'Width', 'am-lottieplayer' ),
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
						'heading'     => __( 'Height', 'am-lottieplayer' ),
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
						'heading' => __( 'Object fit', 'am-lottieplayer' ),
						'default' => 'contain',
						'options' => array(
							'contain' => __( 'Contain', 'am-lottieplayer' ),
							'cover'   => __( 'Cover', 'am-lottieplayer' ),
							'fill'    => __( 'Fill', 'am-lottieplayer' ),
							'none'    => __( 'None', 'am-lottieplayer' ),
						),
					),
				),
			),

			'position_options'  => $position_options,

			'advanced_options'  => array(
				'type'    => 'group',
				'heading' => __( 'Advanced Options', 'am-lottieplayer' ),
				'options' => array(

					'renderer'   => array(
						'type'        => 'select',
						'heading'     => 'Pro Feature: ' . __( 'Renderer', 'am-lottieplayer' ),
						'description' => $proLink,
						'default'     => 'svg',
						'options'     => array(
							'svg'    => 'SVG',
							'canvas' => 'Canvas',
							'html'   => 'HTML',
						),
					),

					'class'      => array(
						'type'       => 'textfield',
						'heading'    => __( 'CSS-class', 'am-lottieplayer' ),
						'param_name' => 'class',
						'default'    => '',
					),

					'alt'        => array(
						'type'        => 'textfield',
						'heading'     => __( 'Description', 'am-lottieplayer' ),
						'description' => __( 'Helpful for screen readers and search engines', 'am-lottieplayer' ),
					),

					'visibility' => require __DIR__ . '/visibility.php',
				),
			),
		),
	)
);
