<?php
\defined( 'ABSPATH' ) || exit;

use function AAMD_Lottie\Utility\get_asset;
use function AAMD_Lottie\Utility\get_script;

global $aamd_lottie_media;

vc_add_shortcode_param(
	'attach_lottie',
	'am_vc_attach_field_settings',
	get_script( 'am-backend-vc-options.min.js', '1.0.1' )
);

if ( ! function_exists( 'am_vc_attach_field_settings' ) ) {
	function am_vc_attach_field_settings( $settings ) {
		\ob_start(); ?>
		<div class="am-upload">
			<button
				id="<?php echo esc_attr( $settings['param_name'] ); ?>-button"
				style="all:unset;cursor:pointer;background:#007cba;color:#fff;font-size:13px;padding:6px 12px;border-radius:2px;height:36px;align-items:center;display:inline-flex;-webkit-appearance:none;-moz-appearance:none;appearance:none;"
				class="<?php echo esc_attr( $settings['param_name'] ) . ' ' . esc_attr( $settings['type'] ); ?>_field"
				><?php echo esc_html__( 'Media Library', 'am-lottieplayer' ); ?></button>
		</div>
		<?php
		return \ob_get_clean();
	}
}

global $pro_feature;
global $pro_link;

vc_map(
	array(
		'name'     => __( 'AM LottiePlayer', 'am-lottieplayer' ),
		'base'     => 'am-lottieplayer',
		'controls' => 'full',
		'icon'     => get_asset( 'vc-icon.svg' ),
		'category' => __( 'Animation', 'am-lottieplayer' ),
		'params'   => array(
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Lottie url', 'am-lottieplayer' ),
				'value'      => $aamd_lottie_media->get_default_file(),
				'param_name' => 'src',
			),
			array(
				'type'       => 'attach_lottie',
				'heading'    => __( 'Choose Lottie', 'am-lottieplayer' ),
				'value'      => '',
				'param_name' => 'attach_src',
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Show controls', 'am-lottieplayer' ),
				'param_name' => 'controls',
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Autoplay', 'am-lottieplayer' ),
				'param_name' => 'autoplay',
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Loop', 'am-lottieplayer' ),
				'param_name' => 'loop',
			),
			array(
				'type'        => 'checkbox',
				'description' => $pro_link,
				'heading'     => $pro_feature . __( 'Boomerang', 'am-lottieplayer' ),
				'param_name'  => 'mode',
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Reverse', 'am-lottieplayer' ),
				'param_name' => 'direction',
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Subframe', 'am-lottieplayer' ),
				'param_name' => 'subframe',
				'checked'    => 'true',
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Speed', 'am-lottieplayer' ),
				'param_name' => 'speed',
				'value'      => '1',
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Intermission', 'am-lottieplayer' ),
				'description' => __( 'Pause between loops, in miliseconds. 1s = 1000', 'am-lottieplayer' ),
				'param_name'  => 'speed',
				'value'       => '0',
			),
			array(
				'type'        => 'checkbox',
				'heading'     => $pro_feature . __( 'Animate on scroll', 'am-lottieplayer' ),
				'description' => AAMD_LOTTIE_IS_PRO ? __( 'Make the animation play only when scrolling, relative to the speed and direction of the scroll', 'am-lottieplayer' ) : $pro_link,
				'param_name'  => AAMD_LOTTIE_IS_PRO ? 'animate_on_scroll' : 'none',
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Play on click', 'am-lottieplayer' ),
				'param_name' => 'onclick',
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Play on mouseover', 'am-lottieplayer' ),
				'param_name' => 'onmouseover',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'On mouseout', 'am-lottieplayer' ),
				'param_name' => 'onmouseout',
				'value'      => array(
					__( 'No event', 'am-lottieplayer' ) => 'void',
					__( 'Stop', 'am-lottieplayer' )     => 'stop',
					__( 'Pause', 'am-lottieplayer' )    => 'pause',
					__( 'Reverse', 'am-lottieplayer' )  => 'reverse',
				),
				'std'        => 'void',
				'dependency' => array(
					'element' => 'onmouseover',
					'value'   => 'true',
				),
			),
			array(
				'type'        => 'textfield',
				'heading'     => $pro_feature . __( 'Trigger element', 'am-lottieplayer' ),
				'description' => AAMD_LOTTIE_IS_PRO ? __( 'Anchor tag (id) for an element you want to trigger the animation, either by hover or click.', 'am-lottieplayer' ) : $pro_link,
				'param_name'  => 'selector',
				'value'       => '',
			),
			array(
				'type'        => 'checkbox',
				'heading'     => $pro_feature . __( 'Apply interaction only to trigger element', 'am-lottieplayer' ),
				'description' => $pro_link,
				'param_name'  => 'exclude_selector',
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Play on scroll, when visible in viewport', 'am-lottieplayer' ),
				'param_name' => 'scroll',
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Delay, in 10th of a second', 'am-lottieplayer' ),
				'param_name' => 'delay',
				'dependency' => array(
					'element' => 'scroll',
					'value'   => 'true',
				),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Play only once', 'am-lottieplayer' ),
				'param_name' => 'once',
				'dependency' => array(
					'element' => 'scroll',
					'value'   => 'true',
				),
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Width', 'am-lottieplayer' ),
				'param_name' => 'width',
				'value'      => null,
				'group'      => __( 'Layout Options', 'am-lottieplayer' ),
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Height', 'am-lottieplayer' ),
				'param_name' => 'height',
				'value'      => null,
				'group'      => __( 'Layout Options', 'am-lottieplayer' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Object fit', 'am-lottieplayer' ),
				'param_name' => 'objectfit',
				'value'      => array(
					__( 'Contain', 'am-lottieplayer' ) => 'contain',
					__( 'Cover', 'am-lottieplayer' )   => 'cover',
					__( 'Fill', 'am-lottieplayer' )    => 'fill',
					__( 'None', 'am-lottieplayer' )    => 'none',
				),
				'std'        => 'contain',
				'group'      => __( 'Layout Options', 'am-lottieplayer' ),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => $pro_feature . __( 'Renderer', 'am-lottieplayer' ),
				'description' => $pro_link,
				'param_name'  => 'renderer',
				'value'       => array(
					__( 'SVG', 'am-lottieplayer' )    => 'svg',
					__( 'Canvas', 'am-lottieplayer' ) => 'canvas',
					// __( 'HTML', 'am-lottieplayer' )   => 'html',
				),
				'std'         => 'svg',
				'group'       => __( 'Advanced Options', 'am-lottieplayer' ),
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Description', 'am-lottieplayer' ),
				'param_name'  => 'alt',
				'description' => __( 'Helpful for screen readers and search engines', 'am-lottieplayer' ),
				'group'       => __( 'Advanced Options', 'am-lottieplayer' ),
			),
		),
	)
);
