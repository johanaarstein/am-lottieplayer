<?php
namespace AAMD_Lottie;

\defined( 'ABSPATH' ) || exit;

class Utility {
	/**
	 * Get allowed attributes for shortcode
	 */
	public static function get_allowed_html() {
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

	private static function get_animation_direction( int|string $input ) {
		if ( $input === 1 || $input === '1' || $input === '0' ) {
			return 1;
		}
		return -1;
	}

	/**
	 * Get static asset
	 *
	 * @param string $filename Name of file
	 * @return string URL to asset
	 */
	public static function get_asset( $filename = '' ) {
		return self::get_static_url( 'assets', $filename );
	}

	/**
	 * Get URL of build script
	 *
	 * @param string      $filename Name of file
	 * @param string|null $version Version of stylesheet
	 * @return string URL to script
	 */
	public static function get_build( $filename = '', $version = null ) {
		return self::get_static_url( 'build', $filename, $version );
	}

	/**
	 * Get path of build script
	 *
	 * @param string $filename Name of file
	 */
	public static function get_build_path( $filename = '' ) {
		return AAMD_LOTTIE_PATH . "build/{$filename}";
	}

	/**
	 * Array with all options, with default value
	 * and associated methods for sanitizing
	 */
	public static function get_options() {
		return array(
			'am_lottieplayer_pro_load_light'        => array( null, 'rest_sanitize_boolean' ),
			'am_lottieplayer_pro_license'           => array( null, 'sanitize_text_field' ),
			'am_lottieplayer_pro_license_activated' => array( false, 'rest_sanitize_boolean' ),
		);
	}

	/**
	 * Returns the plugin path to a specified file.
	 *
	 * @param string $path The specified file.
	 * @return string $ext Extension
	 */
	public static function get_path( string $path = '', string $ext = 'php' ) {
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
	public static function get_script( $filename = '', $version = null ) {
		return self::get_static_url( 'scripts', $filename, $version );
	}

	/**
	 * Get url of static file
	 *
	 * @param string      $type `'assets'|'build'|'scripts'|'styles'`
	 * @param string      $filename Name of file
	 * @param string|null $version Version of stylesheet
	 * @return string URL to script
	 */
	private static function get_static_url( $type, $filename = '', $version = null ) {
		return AAMD_LOTTIE_URL . "{$type}/" . \ltrim( $filename, '/' ) . ( $version ? '?ver=' . $version : '' );
	}

	/**
	 * Get style
	 *
	 * @param string      $filename Name of file
	 * @param string|null $version Version of stylesheet
	 * @return string URL to script
	 */
	public static function get_style( $filename = '', $version = null ) {
		return self::get_static_url( 'styles', $filename, $version );
	}

	/**
	 * Returns an id attribute friendly string
	 *
	 * @param   string $str The string to convert.
	 * @return  string
	 */
	private static function idify( $str = '' ) {
		return \str_replace( array( '][', '[', ']' ), array( '-', '-', '' ), strtolower( $str ) );
	}

	/**
	 * Includes a file within the plugins includes folder
	 *
	 * @param string $path The specified file.
	 * @param object $args (optional)
	 * @param string $ext
	 * @return void
	 */
	public static function include_file( string $path = '', ?object $args = null, string $ext = 'php' ) {
		$path = self::get_path( 'includes/' . \ltrim( $path, '/' ), $ext );
		if ( \file_exists( $path ) ) {
			$args;
			include_once $path;

			return;
		}

		throw new \Error( 'Could not find path: ' . $path );
	}

	/**
	 * Check if Lottie is valid
	 *
	 * @param array|null $lottie
	 */
	public static function is_lottie_valid( ?array $lottie ) {
		if ( ! $lottie ) {
			return false;
		}

		$mandatory = array(
			'v',
			'ip',
			'op',
			'layers',
			'fr',
			'w',
			'h',
		);

		foreach ( $mandatory as $field ) {
			if ( ! array_key_exists( $field, $lottie ) ) {
				return false;
			}
		}

		return true;
	}

	public static function is_safe_zip( \ZipArchive $zip ): bool {
		// Baseline Security Thresholds
		$max_file_count         = 1000;
		$max_total_uncompressed = 100 * 1024 * 1024; // 100 MB
		$max_single_file_size   = 50 * 1024 * 1024;  // 50 MB
		$max_ratio              = 100;               // 100:1 ratio

		// 1. Check total entry count
		if ( $zip->numFiles > $max_file_count ) {
			return false;
		}

		$total_uncompressed = 0;

		// 2. Iterate through headers without extracting
		for ( $i = 0; $i < $zip->numFiles; $i++ ) {
			$stat = $zip->statIndex( $i );
			if ( ! $stat ) {
				continue;
			}

			$uncompressed = $stat['size'];
			$compressed   = $stat['comp_size'];

			// Single file size limit
			if ( $uncompressed > $max_single_file_size ) {
				return false;
			}

			// Compression ratio check (ignore 0-byte or uncompressed entries)
			if ( $compressed > 0 && ( $uncompressed / $compressed ) > $max_ratio ) {
				return false;
			}

			$total_uncompressed += $uncompressed;

			// Total expanded size limit
			if ( $total_uncompressed > $max_total_uncompressed ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Covert string booleans to booleans
	 *
	 * @param bool|string|null $var
	 */
	private static function is_true( bool|string|null $var ) {
		return ( isset( $var ) && $var && $var !== 'false' && $var !== '0' );
	}

	/**
	 * Converts slug to snake_case
	 *
	 * @param string $str
	 */
	public static function snakeify( $str ) {
		return \strtolower( \preg_replace( '/[\-]/', '_', $str ) );
	}

	/**
	 * Render dotLottie-player from shortcode
	 */
	private static function render_lottieplayer( array $atts ) {

		$animateonscroll = '';
		if ( self::is_true( $atts['animateonscroll'] ) ) {
			$animateonscroll = "animateonscroll\n";
		}
		$autoplay = '';
		if ( self::is_true( $atts['autoplay'] ) && ! self::is_true( $atts['playonvisible'] ) ) {
			$autoplay = "autoplay\n";
		}
		$background = 'transparent';
		if ( $atts['background'] && $atts['background'] !== $background ) {
			$background = sanitize_hex_color( $atts['background'] );
		}
		$controls = '';
		if ( self::is_true( $atts['controls'] ) ) {
			$controls = "controls\n";
		}
		$loop = '';
		if ( self::is_true( $atts['loop'] ) ) {
			$loop = "loop\n";
		}
		$subframe = '';
		if ( self::is_true( $atts['subframe'] ) ) {
			$subframe = "subframe\n";
		}

		$hover = '';
		if ( self::is_true( $atts['hover'] ) ) {
			$hover = "hover\n";
		}

		$once = '';
		if ( self::is_true( $atts['once'] ) ) {
			$once = "once\n";
		}

		$playonclick = '';
		if ( self::is_true( $atts['playonclick'] ) ) {
			$playonclick = "playonclick\n";
		}

		$playonvisible = '';
		if ( self::is_true( $atts['playonvisible'] ) ) {
			$playonvisible = "playonvisible\n";
		}

		$unit_regex = '/^\s*\d*\.?\d+\s?(px|em|rem|vw|vh|%)\s*$/';

		$height = 'auto';
		if ( self::is_true( $atts['height'] ) ) {
			// Check if units are already specified
			if ( preg_match( $unit_regex, $atts['height'] ) ) {
				$height = $atts['height'];
			} else {
				$height = $atts['height'] . $atts['height_unit'];
			}
		}
		$width = 'auto';
		if ( self::is_true( $atts['width'] ) ) {
			if ( preg_match( $unit_regex, $atts['width'] ) ) {
				$width = $atts['width'];
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
			if ( \str_contains( $src, 'lottie-thumbnail-' ) ) {
				$uploads = wp_upload_dir( null, false );
				$baseurl = set_url_scheme( $uploads['baseurl'] );
				$src     = set_url_scheme( \str_replace( 'lottie-thumbnail-', '', $src ) );

				if ( \str_starts_with( $src, $baseurl ) ) {
					$path = $uploads['basedir'] . \substr( $src, \strlen( $baseurl ) );
					$src  = self::replace_extension(
						$src,
						\file_exists( self::replace_extension( $path, 'lottie' ) ) ? 'lottie' : 'json'
					);
				}
			}
		}

		$handle = 'dotlottie-player-light';

		if (
			AAMD_LOTTIE_IS_PRO &&
			( ! (bool) get_option( 'am_lottieplayer_pro_load_light' ) ||
			$atts['renderer'] !== 'svg' )
			) {
			$handle = 'dotlottie-player';
		}

		if ( $handle !== 'dotlottie-player-light' && wp_script_is( 'dotlottie-player-light' ) ) {
			wp_dequeue_script( 'dotlottie-player-light' );
		}

		wp_enqueue_script( $handle );

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
				direction="<?php echo esc_attr( self::get_animation_direction( $atts['direction'] ) ); ?>"
				data-direction="<?php echo esc_attr( self::get_animation_direction( $atts['direction'] ) ); ?>"
				mouseout="<?php echo esc_attr( $atts['mouseout'] ); ?>"
				delay="<?php echo esc_attr( $atts['delay'] ); ?>"></dotlottie-player>
				<script class="aamd_inline_script" type="application/json">
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

	public static function render_shortcode( array $atts ) {
		$atts = shortcode_atts(
			array(
				'animateonscroll'            => false,
				'align'                      => 'none',
				'autoplay'                   => false,
				'background'                 => 'transparent',
				'class'                      => '',
				'controls'                   => false,
				'delay'                      => 0,
				'description'                => null,
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
				'src'                        => self::get_asset( 'am.lottie' ),
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

		return self::render_lottieplayer( $atts );
	}

	private static function replace_extension( string $filename, string $new_extension ) {
		$path_parts = pathinfo( $filename );

		if ( empty( $path_parts['extension'] ) ) {
			return $filename;
		}

		return substr_replace( $filename, $new_extension, -strlen( $path_parts['extension'] ) );
	}

	/**
	 * Get unique id
	 */
	public static function use_id() {
		$str = wp_rand();
		return self::idify( \md5( $str ) );
	}

	// dev-only console bridge
	public static function am_console_log( $data, string $level = 'log' ): void {
		static $queue  = array();
		static $hooked = false;

		if ( 'local' !== wp_get_environment_type() && ! WP_DEBUG ) {
			return;
		}

		$queue[] = array( $level, $data );

		if ( $hooked ) {
			return;
		}
		$hooked = true;

		$flush = static function () use ( &$queue ) {
			foreach ( $queue as [ $lvl, $payload ] ) {
				printf(
					"<script>console.%s(%s);</script>\n",
					esc_js( $lvl ),
					wp_json_encode( $payload, JSON_PARTIAL_OUTPUT_ON_ERROR )
				);
			}
		};
		add_action( 'wp_footer', $flush, PHP_INT_MAX );
		add_action( 'admin_footer', $flush, PHP_INT_MAX );
	}
}