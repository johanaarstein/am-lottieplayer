<?php
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'animationDirection' ) ) {
	function animationDirection( $input ) {
		if ( $input === 1 || $input === '1' || $input === '0' ) {
			return 1;
		}
		return -1;
	}
}

if ( ! function_exists( 'amTruish' ) ) {
	function amTruish( $input ) {
		return $input === 'true' || $input === true || $input === 1 || $input === '1';
	}
}

if ( ! function_exists( 'animationMode' ) ) {
	function animationMode( $input ) {
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
}

if ( ! function_exists( 'interactionSelector' ) ) {
	function interactionSelector( $input, $excludeSelector = false ) {
		return wp_json_encode(
			array(
				'id'               => $input ?? null,
				'exclude_selector' => amTruish( $excludeSelector ),
			)
		);
	}
}

if ( ! function_exists( 'am_render_lottieplayer' ) ) {
	function am_render_lottieplayer( $atts ) {
		ob_start(); ?>
	<dotlottie-player <?php echo esc_attr( $atts['animate_on_scroll'] ) && esc_attr( $atts['animate_on_scroll'] ) !== 'false' ? 'animateonscroll' : ''; ?> <?php echo esc_attr( $atts['autoplay'] ) && esc_attr( $atts['autoplay'] ) !== 'false' && ( ! esc_attr( $atts['scroll'] ) || esc_attr( $atts['scroll'] ) !== 'true' ) ? 'autoplay' : ''; ?> background="<?php echo esc_attr( $atts['background'] ) ?? 'transparent'; ?>" <?php echo esc_attr( $atts['controls'] ) && esc_attr( $atts['controls'] ) !== 'false' ? 'controls' : ''; ?> simple description="<?php echo esc_attr( $atts['alt'] ); ?>" <?php echo esc_attr( $atts['loop'] ) && esc_attr( $atts['loop'] ) !== 'false' ? 'loop' : ''; ?> mode="<?php echo esc_attr( animationMode( $atts['mode'] ) ); ?>" objectfit="<?php echo esc_attr( $atts['objectfit'] ); ?>" src="<?php echo esc_url( $atts['src'] ); ?>" renderer="<?php echo esc_attr( $atts['renderer'] ); ?>" segment="
								<?php
									echo esc_attr(
										$atts['segment'] ??
																																																																																																																																																																																																																													( $atts['segment_out'] &&
																																																																																																																																																																																																																														$atts['segment_out'] !== '0' ?
																																																																																																																																																																																																																														'[' . ( intval( $atts['segment_in'] ) ?? 0 ) . ',' . intval( $atts['segment_out'] ) . ']' : '' )
									);
								?>
																																																																																																																																																																																																																														" intermission="<?php echo esc_attr( $atts['intermission'] ); ?>" speed="<?php echo esc_attr( $atts['speed'] ); ?>" <?php echo esc_attr( $atts['subframe'] ) && esc_attr( $atts['subframe'] ) !== 'false' ? 'subframe' : ''; ?> direction="<?php echo esc_attr( animationDirection( $atts['direction'] ) ); ?>" data-direction="<?php echo esc_attr( animationDirection( $atts['direction'] ) ); ?>" data-mouseover="<?php echo esc_attr( $atts['onmouseover'] ); ?>" data-mouseout="<?php echo esc_attr( $atts['onmouseout'] ); ?>" data-click="<?php echo esc_attr( $atts['onclick'] ); ?>" data-selector="<?php echo esc_attr( interactionSelector( $atts['selector'], $atts['exclude_selector'] ) ); ?>" data-scroll="<?php echo esc_attr( $atts['scroll'] ); ?>" data-delay="<?php echo esc_attr( $atts['delay'] ); ?>" data-once="<?php echo esc_attr( $atts['once'] ); ?>">
	</dotlottie-player>
		<?php
		echo ob_get_clean();
	}
}

if ( ! function_exists( 'am_render_lottieplayer_shortcode' ) ) {
	function am_render_lottieplayer_shortcode( $atts ) {
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
				'exclude_selector'  => false,
				'height'            => null,
				'id'                => null,
				'intermission'      => 0,
				'loop'              => false,
				'mode'              => 'normal',
				'objectfit'         => 'contain',
				'renderer'          => 'svg',
				'scroll'            => false,
				'segment'           => null,
				'segment_in'        => null,
				'segment_out'       => null,
				'speed'             => 1,
				'selector'          => null,
				'src'               => esc_url( ! is_wp_error( AM_LottiePlayer_Upload::lottie_asset() ) ? wp_get_attachment_url( AM_LottiePlayer_Upload::lottie_asset() ) : AM_LottiePlayer_Upload::lottie_asset( true ) ),
				'subframe'          => true,
				'width'             => null,
				'onmouseover'       => false,
				'onclick'           => false,
				'onmouseout'        => 'void',
				'once'              => false,
			),
			$atts
		);

		ob_start();
		?>
	<figure class="am-lottieplayer align
		<?php
		echo esc_attr( $atts['align'] ) ?? 'none';
										echo ' ' . esc_attr( $atts['class'] );
		?>
										" style="
		background-color: <?php echo esc_attr( $atts['background'] ); ?>;
		height: <?php echo esc_attr( $atts['height'] ) ? esc_attr( $atts['height'] ) . 'px' : 'auto'; ?>;
		width: <?php echo esc_attr( $atts['width'] ) ? esc_attr( $atts['width'] ) . 'px' : 'auto'; ?>;
		">
		<?php am_render_lottieplayer( $atts ); ?>
	</figure>
		<?php
		return ob_get_clean();
	}
}

/**
 * Returns the plugin path to a specified file.
 *
 * @param string $filename The specified file.
 * @return string
 */
if ( ! function_exists( 'am_get_path' ) ) {
	function am_get_path( $path = '' ) {
		$path = preg_replace( '/\.[^.]*$/', '', ltrim( $path, '/' ) ) . '.php';
		return AM_LOTTIEPLAYER_PATH . $path;
	}
}

if ( ! function_exists( 'am_get_path' ) ) {
	/**
	 * Returns the plugin path to a specified file.
	 *
	 * @param string $filename The specified file.
	 * @return string
	 */
	function am_get_path( $path = '' ) {
		$path = preg_replace( '/\.[^.]*$/', '', ltrim( $path, '/' ) ) . '.php';
		return AM_LOTTIEPLAYER_PATH . $path;
	}
}

if ( ! function_exists( 'am_include' ) ) {
	/**
	 * Includes a file within the plugins includes folder
	 *
	 * @param string $filename The specified file.
	 * @param mixed  $arg (optional)
	 * @return void
	 */
	function am_include( $path = '', $args = null ) {
		$path = am_get_path( 'includes/' . ltrim( $path, '/' ) );
		if ( file_exists( $path ) ) {
			$args;
			include_once $path;
		}
	}
}

if ( ! function_exists( 'am_get_asset' ) ) {
	/**
	 * Get static asset
	 *
	 * @param string $filename Name of file
	 * @return string URL to asset
	 */
	function am_get_asset( $filename = '' ) {
		return AM_LOTTIEPLAYER_URL . 'assets/' . ltrim( $filename, '/' );
	}
}
