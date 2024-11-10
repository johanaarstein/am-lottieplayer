<?php
namespace AAMD_Lottie\Utility;

\defined( 'ABSPATH' ) || exit;

/**
 * Normalize boolean input for string attributes
 */
function boolean_to_string( $input ) {
	if ( $input !== 1 && $input !== '1' && $input !== true && $input !== 'true' ) {
		return 'false';
	}
	return 'true';
}

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
			'autoplay'       => array(),
			'background'     => array(),
			'class'          => array(),
			'controls'       => array(),
			'count'          => array(),
			'data-mouseover' => array(),
			'date-mouseout'  => array(),
			'data-click'     => array(),
			'data-scroll'    => array(),
			'data-delay'     => array(),
			'data-once'      => array(),
			'description'    => array(),
			'direction'      => array(),
			'hover'          => array(),
			'id'             => array(),
			'intermission'   => array(),
			'loop'           => array(),
			'objectfit'      => array(),
			'onclick'        => array(),
			'onmouseover'    => array(),
			'renderer'       => array(),
			'simple'         => array(),
			'speed'          => array(),
			'src'            => array(),
			'subframe'       => array(),
		),
		'script'           => array(
			'type' => array(),
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
 * Get all instances of shortcode in text
 *
 * @param string $content
 * @param string $tag
 * @return string[] | null
 */
function get_shortcode_instances( $content, $tag ) {
	if ( ! \str_contains( $content, '[' ) || ! shortcode_exists( $tag ) ) {
		return null;
	}

	\preg_match_all( '/\[' . $tag . '[^\]]*\]/', $content, $matches, PREG_SET_ORDER );

	if ( empty( $matches ) ) {
		return null;
	}

	$shortcodes = array();

	foreach ( $matches as $match ) {
		\array_push( $shortcodes, $match[0] );
	}

	if ( empty( $shortcodes ) ) {
		return null;
	}

	return $shortcodes;
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
 * Returns an id attribute friendly string
 *
 * @param   string $str The string to convert.
 * @return  string
 */
function idify( $str = '' ) {
	return \str_replace( array( '][', '[', ']' ), array( '-', '-', '' ), strtolower( $str ) );
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
	return ( isset( $var ) && $var !== 'false' && $var !== '0' );
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

	$unit_regex = '/\s*(\d+\s?)(px|em|rem|%)/';

	$height = 'auto';
	if ( is_true( $atts['height'] ) ) {
		// Check if units are already specified
		if ( preg_match( $unit_regex, $atts['height'] ) ) {
			$height = $atts['height'];
		} else {
			$height = $atts['height'] . $atts['height_unit'];
		}
	}
	$width = 'auto';
	if ( is_true( $atts['width'] ) ) {
		if ( preg_match( $unit_regex, $atts['width'] ) ) {
			$height = $atts['width'];
		} else {
			$width = $atts['width'] . $atts['width_unit'];
		}
	}

	$multi_animation_interactions = null;
	if ( isset( $atts['multi_animation_interactions'] ) ) {
		$multi_animation_interactions = $atts['multi_animation_interactions'];
	}
	$multi_animation_settings = null;
	if ( isset( $atts['multi_animation_settings'] ) ) {
		$multi_animation_settings = $atts['multi_animation_settings'];
	}
	$segment = null;
	if ( isset( $atts['segment'] ) ) {
		$segment = $atts['segment'];
	}
	$selector = null;
	if ( isset( $atts['selector'] ) ) {
		$selector = $atts['selector'];
	}

	\ob_start();
	?>
	<figure
		class="am-lottieplayer align-<?php echo esc_attr( $atts['align'] . ' ' . $atts['class'] ); ?>"
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
			<?php
			if ( AAMD_LOTTIE_IS_PRO ) {
				?>
			renderer="<?php echo esc_attr( $atts['renderer'] ); ?>"
				<?php
			}
			?>
			direction="<?php echo esc_attr( get_animation_direction( $atts['direction'] ) ); ?>"
			data-direction="<?php echo esc_attr( get_animation_direction( $atts['direction'] ) ); ?>"
			data-mouseover="<?php echo esc_attr( $atts['onmouseover'] ); ?>"
			data-mouseout="<?php echo esc_attr( $atts['onmouseout'] ); ?>"
			data-click="<?php echo esc_attr( boolean_to_string( $atts['onclick'] ) ); ?>"
			data-scroll="<?php echo esc_attr( boolean_to_string( $atts['scroll'] ) ); ?>"
			data-delay="<?php echo esc_attr( $atts['delay'] ); ?>"
			data-once="<?php echo esc_attr( boolean_to_string( $atts['once'] ) ); ?>"></dotlottie-player>
			<script type="application/ld+json">
				{
					"multiAnimationInteractions": <?php echo json_encode( $multi_animation_interactions ); ?>,
					"multiAnimationSettings": <?php echo json_encode( $multi_animation_settings ); ?>,
					"selector": <?php echo json_encode( $selector ); ?>,
					"segment": <?php echo json_encode( $segment ); ?>
				}
			</script>
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
			'animate_on_scroll'            => false,
			'align'                        => 'none',
			'alt'                          => __( 'AM LottiePlayer animation', 'am-lottieplayer' ),
			'autoplay'                     => false,
			'background'                   => 'transparent',
			'class'                        => '',
			'controls'                     => false,
			'delay'                        => 100,
			'direction'                    => 1,
			'height'                       => null,
			'id'                           => null,
			'intermission'                 => 0,
			'loop'                         => false,
			'mode'                         => 'normal',
			'multi_animation_interactions' => null,
			'multi_animation_settings'     => null,
			'objectfit'                    => 'contain',
			'renderer'                     => 'svg',
			'scroll'                       => false,
			'segment'                      => null,
			'selector'                     => null,
			'speed'                        => 1,
			'src'                          => $aamd_lottie_media->get_default_file(),
			'subframe'                     => true,
			'url'                          => null,
			'target'                       => '_blank',
			'width'                        => null,
			'onmouseover'                  => false,
			'onclick'                      => false,
			'onmouseout'                   => 'void',
			'once'                         => false,
			'width_unit'                   => 'px',
			'height_unit'                  => 'px',
		),
		$atts
	);

	return render_lottieplayer( $atts );
}

/**
 * Polyfill for `str_ends_with()` function added in PHP 8.0.
 *
 * Performs a case-sensitive check indicating if
 * the haystack ends with needle.
 *
 * @param string $haystack The string to search in.
 * @param string $needle   The substring to search for in the `$haystack`.
 * @return bool True if `$haystack` ends with `$needle`, otherwise false.
 */
function str_ends_with( $haystack, $needle ) {
	if ( function_exists( 'str_ends_with' ) ) {
		return str_ends_with( $haystack, $needle );
	}

	if ( '' === $haystack && '' !== $needle ) {
		return false;
	}

	$len = strlen( $needle );
	return 0 === substr_compare( $haystack, $needle, -$len, $len );
}

/**
 * Get unique id
 */
function use_id() {
	$str = wp_rand();
	return idify( \md5( $str ) );
}
