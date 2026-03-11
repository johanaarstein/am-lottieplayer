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
			'animateonscroll' => array(),
			'autoplay'        => array(),
			'background'      => array(),
			'class'           => array(),
			'controls'        => array(),
			'count'           => array(),
			'data-*'          => array(),
			'delay'           => array(),
			'description'     => array(),
			'direction'       => array(),
			'hover'           => array(),
			'id'              => array(),
			'intermission'    => array(),
			'loop'            => array(),
			'mode'            => array(),
			'mouseout'        => array(),
			'objectfit'       => array(),
			'once'            => array(),
			'playonclick'     => array(),
			'hover'           => array(),
			'playonclick'     => array(),
			'playonvisible'   => array(),
			'renderer'        => array(),
			'selector'        => array(),
			'simple'          => array(),
			'speed'           => array(),
			'src'             => array(),
			'subframe'        => array(),
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
function include_file( string $path = '', ?object $args = null, string $ext = 'php' ) {
	$path = get_path( 'includes/' . \ltrim( $path, '/' ), $ext );
	if ( \file_exists( $path ) ) {
		$args;
		include_once $path;
	}
}

/**
 * Check if Lottie is valid
 *
 * @param array|null
 */
function is_lottie_valid( $lottie ) {
	if ( $lottie && (
		! array_key_exists( 'v', $lottie ) ||
		! array_key_exists( 'fr', $lottie ) ||
		! array_key_exists( 'ip', $lottie ) ||
		! array_key_exists( 'op', $lottie ) ||
		! array_key_exists( 'w', $lottie ) ||
		! array_key_exists( 'h', $lottie )
	) ) {
		return false;
	}
	return true;
}

/**
 * Covert string booleans to booleans
 *
 * @param bool|string|null
 */
function is_true( $var ) {
	return ( isset( $var ) && $var && $var !== 'false' && $var !== '0' );
}

/**
 * Render dotLottie-player from shortcode
 */
function render_lottieplayer( array $atts ) {

	$animateonscroll = '';
	if ( is_true( $atts['animateonscroll'] ) ) {
		$animateonscroll = "animateonscroll\n";
	}
	$autoplay = '';
	if ( is_true( $atts['autoplay'] ) && ! is_true( $atts['playonvisible'] ) ) {
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

	$hover = '';
	if ( is_true( $atts['hover'] ) ) {
		$hover = "hover\n";
	}

	$once = '';
	if ( is_true( $atts['once'] ) ) {
		$once = "once\n";
	}

	$playonclick = '';
	if ( is_true( $atts['playonclick'] ) ) {
		$playonclick = "playonclick\n";
	}

	$playonvisible = '';
	if ( is_true( $atts['playonvisible'] ) ) {
		$playonvisible = "playonvisible\n";
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

	$multianimationinteractions = null;
	if ( isset( $atts['multianimationinteractions'] ) ) {
		$multianimationinteractions = $atts['multianimationinteractions'];
	}
	$multianimationsettings = null;
	if ( isset( $atts['multianimationsettings'] ) ) {
		$multianimationsettings = $atts['multianimationsettings'];
	}
	$segment = null;
	if ( isset( $atts['segment'] ) ) {
		$segment = $atts['segment'];
	}
	$selector = null;
	if ( isset( $atts['selector'] ) && ! empty( $atts['selector'] ) ) {
		$selector = $atts['selector'];
	}
	$src = '';
	if ( isset( $atts['src'] ) ) {
		if ( is_string( $atts['src'] ) ) {
			$src = $atts['src'];
		}
		if ( isset( $atts['src']['url'] ) ) {
			$src = $atts['src']['url'];
		}

		// Check if thumbnail svg is set by mistake
		if ( str_contains( $src, 'lottie-thumbnail-' ) ) {
			$src = str_replace( 'lottie-thumbnail-', '', $src );

			$path = str_replace( home_url(), untrailingslashit( get_home_path() ), $src );

			if ( file_exists( replace_extension( $path, 'lottie' ) ) ) {
				$src = replace_extension( $src, 'lottie' );
			} else {
				$src = replace_extension( $src, 'json' );
			}
		}
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
			<?php echo esc_attr( $animateonscroll ); ?>
			<?php echo esc_attr( $hover ); ?>
			<?php echo esc_attr( $playonclick ); ?>
			<?php echo esc_attr( $playonvisible ); ?>
			<?php echo esc_attr( $once ); ?>
			description="<?php echo esc_attr( $atts['description'] ); ?>"
			objectfit="<?php echo esc_attr( $atts['objectfit'] ); ?>"
			src="<?php echo esc_url( $src ); ?>"
			intermission="<?php echo esc_attr( $atts['intermission'] ); ?>"
			speed="<?php echo esc_attr( $atts['speed'] ); ?>"
			<?php
			if ( AAMD_LOTTIE_IS_PRO ) {
				?>
			renderer="<?php echo esc_attr( $atts['renderer'] ); ?>"
			mode="<?php echo esc_attr( $atts['mode'] ); ?>"
				<?php
			}
			?>
			direction="<?php echo esc_attr( get_animation_direction( $atts['direction'] ) ); ?>"
			data-direction="<?php echo esc_attr( get_animation_direction( $atts['direction'] ) ); ?>"
			mouseout="<?php echo esc_attr( $atts['mouseout'] ); ?>"
			delay="<?php echo esc_attr( $atts['delay'] ); ?>"></dotlottie-player>
			<script type="application/ld+json">
				{
					"multiAnimationInteractions": <?php echo wp_json_encode( $multianimationinteractions ); ?>,
					"multiAnimationSettings": <?php echo wp_json_encode( $multianimationsettings ); ?>,
					"selector": <?php echo wp_json_encode( $selector ); ?>,
					"segment": <?php echo wp_json_encode( $segment ); ?>
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
			'animateonscroll'            => false,
			'align'                      => 'none',
			'autoplay'                   => false,
			'background'                 => 'transparent',
			'class'                      => '',
			'controls'                   => false,
			'delay'                      => 0,
			'description'                => __( 'AM LottiePlayer animation', 'am-lottieplayer' ),
			'direction'                  => 1,
			'height'                     => null,
			'hover'                      => false,
			'id'                         => null,
			'intermission'               => 0,
			'loop'                       => false,
			'mode'                       => 'normal',
			'mouseout'                   => 'stop',
			'multianimationinteractions' => null,
			'multianimationsettings'     => null,
			'objectfit'                  => 'contain',
			'renderer'                   => 'svg',
			'playonvisible'              => false,
			'segment'                    => null,
			'selector'                   => null,
			'speed'                      => 1,
			'src'                        => $aamd_lottie_media->get_default_file(),
			'subframe'                   => true,
			'url'                        => null,
			'target'                     => '_blank',
			'width'                      => null,
			'playonclick'                => false,
			'once'                       => false,
			'width_unit'                 => 'px',
			'height_unit'                => 'px',
		),
		$atts
	);

	return render_lottieplayer( $atts );
}

function replace_extension( $filename, $new_extension ) {
	$path_parts = pathinfo( $filename );
	return str_replace( $path_parts['extension'], $new_extension, $filename );
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
 * Polyfill for `str_starts_with()` function added in PHP 8.0.
 *
 * Performs a case-sensitive check indicating if
 * the haystack ends with needle.
 *
 * @param string $haystack The string to search in.
 * @param string $needle   The substring to search for in the `$haystack`.
 * @return bool True if `$haystack` ends with `$needle`, otherwise false.
 */
function str_starts_with( $haystack, $needle ) {
	if ( function_exists( 'str_starts_with' ) ) {
		return str_starts_with( $haystack, $needle );
	}

	if ( '' === $haystack && '' !== $needle ) {
		return false;
	}

	$len = strlen( $needle );
	return 0 === substr_compare( $haystack, $needle, 0, $len );
}

/**
 * Creates a random unique temporary directory, with specified parameters,
 * that does not already exist (like tempnam(), but for dirs).
 *
 * Created dir will begin with the specified prefix, followed by random
 * numbers.
 *
 * @link https://php.net/manual/en/function.tempnam.php
 *
 * @param string|null $dir Base directory under which to create temp dir.
 *     If null, the default system temp dir (sys_get_temp_dir()) will be
 *     used.
 * @param string      $prefix String with which to prefix created dirs.
 * @param int         $mode Octal file permission mask for the newly-created dir.
 *             Should begin with a 0.
 * @param int         $maxAttempts Maximum attempts before giving up (to prevent
 *             endless loops).
 * @return string|bool Full path to newly-created dir, or false on failure.
 */
function tempdir( $dir = null, $prefix = 'tmp_', $mode = 0700, $maxAttempts = 1000 ) {
	/* Use the system temp dir by default. */
	if ( is_null( $dir ) ) {
		$dir = sys_get_temp_dir();
	}

	/* Trim trailing slashes from $dir. */
	$dir = rtrim( $dir, DIRECTORY_SEPARATOR );

	/*
	If we don't have permission to create a directory, fail, otherwise we will
	 * be stuck in an endless loop.
	 */
	if ( ! is_dir( $dir ) || ! wp_is_writable( $dir ) ) {
		return false;
	}

	/* Make sure characters in prefix are safe. */
	if ( strpbrk( $prefix, '\\/:*?"<>|' ) !== false ) {
		return false;
	}

	/*
	Attempt to create a random directory until it works. Abort if we reach
	 * $maxAttempts. Something screwy could be happening with the filesystem
	 * and our loop could otherwise become endless.
	 */
	$attempts = 0;
	do {
		$path = sprintf( '%s%s%s%s', $dir, DIRECTORY_SEPARATOR, $prefix, wp_rand( 100000, mt_getrandmax() ) );
	} while (
		! wp_mkdir_p( $path ) &&
		$attempts++ < $maxAttempts
	);

	return $path;
}

function unleadingslashhit( $str ) {
	return ltrim( $str, '/' );
}

/**
 * Get unique id
 */
function use_id() {
	$str = wp_rand();
	return idify( \md5( $str ) );
}
