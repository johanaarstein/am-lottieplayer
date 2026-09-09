<?php
\defined( 'ABSPATH' ) || exit;

use function AAMD_Lottie\Utility\get_asset;
use function AAMD_Lottie\Utility\get_script;

/** @var AAMD_Lottie\Media $aamd_lottie_media */
global $aamd_lottie_media;

vc_add_shortcode_param(
	'attach_lottie',
	'am_vc_attach_field_settings',
	get_script( 'vc/am-backend-vc-options.min.js', '1.0.1' )
);

if ( ! function_exists( 'am_vc_attach_field_settings' ) ) {
	function am_vc_attach_field_settings( array $settings ) {
		\ob_start(); ?>
		<div class="am-upload">
			<button
				id="<?php echo esc_attr( $settings['param_name'] ); ?>-button"
				style="all:unset;cursor:pointer;background:#007cba;color:#fff;font-size:13px;padding:6px 12px;border-radius:2px;height:36px;align-items:center;display:inline-flex;-webkit-appearance:none;-moz-appearance:none;appearance:none;"
				class="<?php echo esc_attr( $settings['param_name'] ) . ' ' . esc_attr( $settings['type'] ); ?>_field"
				><?php echo esc_html__( 'Media Library', TEXT_DOMAIN ); ?></button>
		</div>
		<?php
		return \ob_get_clean();
	}
}

global $pro_feature;
global $pro_link;

vc_map(
	array(
		'name'     => __( 'AM LottiePlayer', TEXT_DOMAIN ),
		'base'     => TEXT_DOMAIN,
		'controls' => 'full',
		'icon'     => get_asset( 'vc-icon.svg' ),
		'category' => __( 'Animation', TEXT_DOMAIN ),
		'params'   => array(
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Lottie url', TEXT_DOMAIN ),
				'value'      => $aamd_lottie_media->get_default_file(),
				'param_name' => 'src',
			),
			array(
				'type'       => 'attach_lottie',
				'heading'    => __( 'Choose Lottie', TEXT_DOMAIN ),
				'value'      => '',
				'param_name' => 'attach_src',
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Show controls', TEXT_DOMAIN ),
				'param_name' => 'controls',
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Autoplay', TEXT_DOMAIN ),
				'param_name' => 'autoplay',
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Loop', TEXT_DOMAIN ),
				'param_name' => 'loop',
			),
			array(
				'type'        => 'checkbox',
				'description' => $pro_link,
				'heading'     => $pro_feature . __( 'Boomerang', TEXT_DOMAIN ),
				'param_name'  => 'mode',
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Reverse', TEXT_DOMAIN ),
				'param_name' => 'direction',
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Subframe', TEXT_DOMAIN ),
				'param_name' => 'subframe',
				'checked'    => 'true',
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Speed', TEXT_DOMAIN ),
				'param_name' => 'speed',
				'value'      => '1',
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Intermission', TEXT_DOMAIN ),
				'description' => __( 'Pause between loops, in miliseconds. 1s = 1000', TEXT_DOMAIN ),
				'param_name'  => 'speed',
				'value'       => '0',
			),
			array(
				'type'        => 'checkbox',
				'heading'     => $pro_feature . __( 'Animate on scroll', TEXT_DOMAIN ),
				'description' => AAMD_LOTTIE_IS_PRO ? __( 'Make the animation play only when scrolling, relative to the speed and direction of the scroll', TEXT_DOMAIN ) : $pro_link,
				'param_name'  => AAMD_LOTTIE_IS_PRO ? 'animateonscroll' : 'none',
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Play on click', TEXT_DOMAIN ),
				'param_name' => 'playonclick',
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Play on mouseover', TEXT_DOMAIN ),
				'param_name' => 'hover',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'On mouseout', TEXT_DOMAIN ),
				'param_name' => 'mouseout',
				'value'      => array(
					__( 'No event', TEXT_DOMAIN ) => 'void',
					__( 'Stop', TEXT_DOMAIN )     => 'stop',
					__( 'Pause', TEXT_DOMAIN )    => 'pause',
					__( 'Reverse', TEXT_DOMAIN )  => 'reverse',
				),
				'std'        => 'void',
				'dependency' => array(
					'element' => 'hover',
					'value'   => 'true',
				),
			),
			array(
				'type'        => 'textfield',
				'heading'     => $pro_feature . __( 'Trigger element', TEXT_DOMAIN ),
				'description' => AAMD_LOTTIE_IS_PRO ? __( 'Anchor tag (id) for an element you want to trigger the animation, either by hover or click.', TEXT_DOMAIN ) : $pro_link,
				'param_name'  => 'selector',
				'value'       => '',
			),
			array(
				'type'        => 'checkbox',
				'heading'     => $pro_feature . __( 'Apply interaction only to trigger element', TEXT_DOMAIN ),
				'description' => $pro_link,
				'param_name'  => 'exclude_selector',
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Play on scroll, when visible in viewport', TEXT_DOMAIN ),
				'param_name' => 'playonvisible',
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Delay, in milliseconds', TEXT_DOMAIN ),
				'param_name' => 'delay',
				'dependency' => array(
					'element' => 'playonvisible',
					'value'   => 'true',
				),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => __( 'Play only once', TEXT_DOMAIN ),
				'param_name' => 'once',
				'dependency' => array(
					'element' => 'playonvisible',
					'value'   => 'true',
				),
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Width', TEXT_DOMAIN ),
				'param_name' => 'width',
				'value'      => null,
				'group'      => __( 'Layout Options', TEXT_DOMAIN ),
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Height', TEXT_DOMAIN ),
				'param_name' => 'height',
				'value'      => null,
				'group'      => __( 'Layout Options', TEXT_DOMAIN ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Object fit', TEXT_DOMAIN ),
				'param_name' => 'objectfit',
				'value'      => array(
					__( 'Contain', TEXT_DOMAIN ) => 'contain',
					__( 'Cover', TEXT_DOMAIN )   => 'cover',
					__( 'Fill', TEXT_DOMAIN )    => 'fill',
					__( 'None', TEXT_DOMAIN )    => 'none',
				),
				'std'        => 'contain',
				'group'      => __( 'Layout Options', TEXT_DOMAIN ),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => $pro_feature . __( 'Renderer', TEXT_DOMAIN ),
				'description' => $pro_link,
				'param_name'  => 'renderer',
				'value'       => array(
					__( 'SVG', TEXT_DOMAIN )    => 'svg',
					__( 'Canvas', TEXT_DOMAIN ) => 'canvas',
					// __( 'HTML', TEXT_DOMAIN )   => 'html',
				),
				'std'         => 'svg',
				'group'       => __( 'Advanced Options', TEXT_DOMAIN ),
			),
			array(
				'type'        => 'textfield',
				'heading'     => __( 'Description', TEXT_DOMAIN ),
				'param_name'  => 'description',
				'description' => __( 'Helpful for screen readers and search engines', TEXT_DOMAIN ),
				'group'       => __( 'Advanced Options', TEXT_DOMAIN ),
			),
		),
	)
);
