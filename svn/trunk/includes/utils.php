<?php
namespace AAMD_Lottie\Utility;

\defined( 'ABSPATH' ) || exit;

/**
 * Get allowed attributes for shortcode
 */
function get_allowed_html() {
	return array(
		'a'                => array(
			'href'   => array(),
			'target' => array(),
			'rel'    => array(),
		),
		'figure'           => array(
			'class' => array(),
			'style' => array(),
		),
		'dotlottie-player' => array(
			'autoplay'     => array(),
			'background'   => array(),
			'class'        => array(),
			'controls'     => array(),
			'count'        => array(),
			'data-*'       => array(),
			'description'  => array(),
			'direction'    => array(),
			'hover'        => array(),
			'id'           => array(),
			'intermission' => array(),
			'loop'         => array(),
			'objectfit'    => array(),
			'onclick'      => array(),
			'onmouseover'  => array(),
			'simple'       => array(),
			'speed'        => array(),
			'src'          => array(),
			'subframe'     => array(),
		),
	);
}

function get_animation_direction( $input ) {
	if ( $input === 1 || $input === '1' || $input === '0' ) {
		return 1;
	}
	return -1;
}

function get_animation_mode( $input ) {
	if (
	$input === 'bounce' ||
	$input === 1 ||
	$input === '1' ||
	$input === 'true' ||
	$input === true
	) {
		return 'bounce';
	}
	return 'normal';
}

/**
 * Get static asset
 *
 * @param string $filename Name of file
 * @return string URL to asset
 */
function get_asset( $filename = '' ) {
	return get_static_url( 'assets', $filename );
}

/**
 * Get URL of build script
 *
 * @param string      $filename Name of file
 * @param string|null $version Version of stylesheet
 * @return string URL to script
 */
function get_build( $filename = '', $version = null ) {
	return get_static_url( 'build', $filename, $version );
}

/**
 * Get path of build script
 *
 * @param string      $filename Name of file
 * @param string|null $version Version of stylesheet
 * @return string URL to script
 */
function get_build_path( $filename = '' ) {
	return AAMD_LOTTIE_PATH . "build/{$filename}";
}

/**
 * Returns the plugin path to a specified file.
 *
 * @param string $filename The specified file.
 * @return string
 */
function get_path( string $path = '', string $ext = 'php' ) {
	$path = \preg_replace( '/\.[^.]*$/', '', \ltrim( $path, '/' ) ) . ".{$ext}";
	return AAMD_LOTTIE_PATH . $path;
}

/**
 * Get script
 *
 * @param string      $filename Name of file
 * @param string|null $version Version of script
 * @return string URL to script
 */
function get_script( $filename = '', $version = null ) {
	return get_static_url( 'scripts', $filename, $version );
}

/**
 * Get url of static file
 *
 * @param string      $type `'assets'|'build'|'scripts'|'styles'`
 * @param string      $filename Name of file
 * @param string|null $version Version of stylesheet
 * @return string URL to script
 */
function get_static_url( $type, $filename = '', $version = null ) {
	return AAMD_LOTTIE_URL . "{$type}/" . \ltrim( $filename, '/' ) . ( $version ? '?ver=' . $version : '' );
}

/**
 * Get style
 *
 * @param string      $filename Name of file
 * @param string|null $version Version of stylesheet
 * @return string URL to script
 */
function get_style( $filename = '', $version = null ) {
	return get_static_url( 'styles', $filename, $version );
}

/**
 * Includes a file within the plugins includes folder
 *
 * @param string $filename The specified file.
 * @param mixed  $arg (optional)
 * @return void
 */
function include_file( string $path = '', object $args = null, string $ext = 'php' ) {
	$path = get_path( 'includes/' . \ltrim( $path, '/' ), $ext );
	if ( \file_exists( $path ) ) {
		$args;
		include_once $path;
	}
}

/**
 * Covert string booleans to booleans
 *
 * @param bool|string|null
 */
function is_true( $var ) {
	return ( $var && $var !== 'false' && $var !== '0' );
}

/**
 * Render dotLottie-player from shortcode
 */
function render_lottieplayer( array $atts ) {

	$animate_on_scroll = '';
	if ( is_true( $atts['animate_on_scroll'] ) ) {
		$animate_on_scroll = "animateonscroll\n";
	}
	$autoplay = '';
	if ( is_true( $atts['autoplay'] ) && ! is_true( $atts['scroll'] ) ) {
		$autoplay = "autoplay\n";
	}
	$background = 'transparent';
	if ( $atts['background'] && $atts['background'] !== $background ) {
		$background = sanitize_hex_color( $atts['background'] );
	}
	$controls = '';
	if ( is_true( $atts['controls'] ) ) {
		$controls = "controls\n";
	}
	$loop = '';
	if ( is_true( $atts['loop'] ) ) {
		$loop = "loop\n";
	}
	$subframe = '';
	if ( is_true( $atts['subframe'] ) ) {
		$subframe = "subframe\n";
	}
	$height = 'auto';
	if ( is_true( $atts['height'] ) ) {
		$height = $atts['height'] . $atts['height_unit'];
	}
	$width = 'auto';
	if ( is_true( $atts['width'] ) ) {
		$width = $atts['width'] . $atts['width_unit'];
	}

	\ob_start();
	?>
	<figure
		class="am-lottieplayer align <?php echo esc_attr( $atts['align'] . ' ' . $atts['class'] ); ?>"
		style="background-color:<?php echo esc_attr( $background ); ?>;height:<?php echo esc_attr( $height ); ?>;width:<?php echo esc_attr( $width ); ?>;">
		<dotlottie-player
			simple
			<?php echo esc_attr( $autoplay ); ?>
			<?php echo esc_attr( $controls ); ?>
			<?php echo esc_attr( $loop ); ?>
			<?php echo esc_attr( $subframe ); ?>
			<?php echo esc_attr( $animate_on_scroll ); ?>
			description="<?php echo esc_attr( $atts['alt'] ); ?>"
			objectfit="<?php echo esc_attr( $atts['objectfit'] ); ?>"
			src="<?php echo esc_url( $atts['src'] ); ?>"
			intermission="<?php echo esc_attr( $atts['intermission'] ); ?>"
			speed="<?php echo esc_attr( $atts['speed'] ); ?>"
			direction="<?php echo esc_attr( get_animation_direction( $atts['direction'] ) ); ?>"
			data-direction="<?php echo esc_attr( get_animation_direction( $atts['direction'] ) ); ?>"
			data-mouseover="<?php echo esc_attr( $atts['onmouseover'] ); ?>"
			data-mouseout="<?php echo esc_attr( $atts['onmouseout'] ); ?>"
			data-click="<?php echo esc_attr( $atts['onclick'] ); ?>"
			data-scroll="<?php echo esc_attr( $atts['scroll'] ); ?>"
			data-delay="<?php echo esc_attr( $atts['delay'] ); ?>"
			data-once="<?php echo esc_attr( $atts['once'] ); ?>"></dotlottie-player>
	</figure>
	<?php

	$player = \ob_get_clean();

	$output = '';
	$hasUrl = filter_var( $atts['url'], FILTER_VALIDATE_URL );

	if ( $hasUrl ) {
		$output .= '<a href="' . esc_url( $atts['url'] ) . '" target="' . esc_attr( $atts['target'] ) . '" rel="noreferrer">';
	}

	$output .= $player;

	if ( $hasUrl ) {
		$output .= '</a>';
	}

	return $output;
}

function render_shortcode( $atts ) {
	global $aamd_lottie_media;
	$atts = shortcode_atts(
		array(
			'animate_on_scroll' => false,
			'align'             => 'none',
			'alt'               => __( 'AM LottiePlayer animation', 'am-lottieplayer' ),
			'autoplay'          => false,
			'background'        => 'transparent',
			'class'             => '',
			'controls'          => false,
			'delay'             => 100,
			'direction'         => 1,
			'height'            => null,
			'id'                => null,
			'intermission'      => 0,
			'loop'              => false,
			'mode'              => 'normal',
			'objectfit'         => 'contain',
			'renderer'          => 'svg',
			'scroll'            => false,
			'speed'             => 1,
			'src'               => $aamd_lottie_media->get_default_file(),
			'subframe'          => true,
			'url'               => null,
			'target'            => '_blank',
			'width'             => null,
			'onmouseover'       => false,
			'onclick'           => false,
			'onmouseout'        => 'void',
			'once'              => false,
			'width_unit'        => 'px',
			'height_unit'       => 'px',
		),
		$atts
	);

	return render_lottieplayer( $atts );
}
