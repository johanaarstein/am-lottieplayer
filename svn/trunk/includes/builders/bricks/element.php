<?php
namespace AAMD_Lottie;

use function AAMD_Lottie\Utility\get_allowed_html;
use function AAMD_Lottie\Utility\get_style;
use function AAMD_Lottie\Utility\render_shortcode;

(\defined( 'ABSPATH' ) && \class_exists( '\Bricks\Element' )) || exit;

class Element_Lottie_Player extends \Bricks\Element {
	// Element properties
	public $category = 'media';
	public $name     = 'am-lottieplayer';
	public $icon     = 'eicon-am-lottie';
	// public $css_selector = '';
	public $scripts  = AAMD_LOTTIE_IS_PRO ? array( 'am-frontend' ) : array( 'am-frontend-light' );
	public $nestable = false;

	// Methods: Builder-specific
	public function get_label() {
		return esc_html__( 'AM LottiePlayer', 'am-lottieplayer' );
	}
	public function get_keywords() {
		return array(
			'lottie',
			'bodymovin',
			'gutenberg',
			'svg',
			'gif',
		);
	}

	public function set_control_groups() {
		$this->control_groups['animation'] = array(
			'title' => esc_html__( 'Animation', 'am-lottieplayer' ),
			'tab'   => 'content',
		);

		$this->control_groups['interactions'] = array(
			'title' => esc_html__( 'Interactions', 'am-lottieplayer' ),
			'tab'   => 'content',
		);

		$this->control_groups['advanced'] = array(
			'title' => esc_html__( 'Advanced', 'am-lottieplayer' ),
			'tab'   => 'content',
		);

		$this->control_groups['dimensions'] = array(
			'title' => esc_html__( 'Dimensions', 'am-lottieplayer' ),
			'tab'   => 'style',
		);

		$this->control_groups['background'] = array(
			'title' => esc_html__( 'Background', 'am-lottieplayer' ),
			'tab'   => 'style',
		);
	}
	public function set_controls() {

		global $aamd_lottie_media;
		global $pro_link;
		global $pro_feature;

		// File
		$this->controls['source_separator']   = array(
			'tab'   => 'content',
			'group' => 'animation',
			'label' => esc_html__( 'Source', 'am-lottieplayer' ),
			'type'  => 'separator',
		);
		$this->controls['external_url']       = array(
			'tab'         => 'content',
			'group'       => 'animation',
			'label'       => esc_html__( 'Lottie URL', 'am-lottieplayer' ),
			'type'        => 'text',
			'placeholder' => esc_url( $aamd_lottie_media->get_default_file() ),
			'required'    => array( 'source_type', '=', 'url' ),
		);
		$this->controls['media_library_file'] = array(
			'tab'         => 'content',
			'group'       => 'animation',
			'label'       => esc_html__( 'Lottie animation', 'am-lottieplayer' ),
			'type'        => 'file',
			'allowed' => array('application/json', 'application/zip'),
			'pasteStyles' => false,
			'required'    => array( 'source_type', '=', 'media' ),
		);
		$this->controls['source_type']        = array(
			'tab'         => 'content',
			'group'       => 'animation',
			'label'       => esc_html__( 'Source Type', 'am-lottieplayer' ),
			'small'       => true,
			'inline'      => true,
			'type'        => 'select',
			'options'     => array(
				'media' => esc_html__( 'Media Library', 'am-lottieplayer' ),
				'url'   => esc_html__( 'External URL', 'am-lottieplayer' ),
			),
			'default'     => 'media',
			'placeholder' => esc_html__( 'Media Library', 'am-lottieplayer' ),
		);

		// Settings
		$this->controls['settings_separator'] = array(
			'tab'   => 'content',
			'group' => 'animation',
			'label' => esc_html__( 'Animation settings', 'am-lottieplayer' ),
			'type'  => 'separator',
		);
		$this->controls['controls']           = array(
			'tab'     => 'content',
			'group'   => 'animation',
			'label'   => esc_html__( 'Show controls', 'am-lottieplayer' ),
			'type'    => 'checkbox',
			'default' => true,
		);
		$this->controls['autoplay']           = array(
			'tab'      => 'content',
			'group'    => 'animation',
			'label'    => esc_html__( 'Autoplay', 'am-lottieplayer' ),
			'type'     => 'checkbox',
			'default'  => false,
			'required' => array(
				'animate_on_scroll',
				'!=',
				true,
			),
		);
		$this->controls['loop']               = array(
			'tab'      => 'content',
			'group'    => 'animation',
			'label'    => esc_html__( 'Loop', 'am-lottieplayer' ),
			'type'     => 'checkbox',
			'default'  => false,
			'required' => array(
				'animate_on_scroll',
				'!=',
				true,
			),
		);
		$this->controls['mode']               = array(
			'tab'         => 'content',
			'group'       => 'animation',
			'label'       => $pro_feature . esc_html__( 'Boomerang', 'am-lottieplayer' ),
			'description' => $pro_link,
			'type'        => 'checkbox',
			'default'     => false,
			'required'    => array(
				'animate_on_scroll',
				'!=',
				true,
			),
			'inline'      => true,
		);
		$this->controls['reverse']            = array(
			'tab'      => 'content',
			'group'    => 'animation',
			'label'    => esc_html__( 'Reverse', 'am-lottieplayer' ),
			'type'     => 'checkbox',
			'default'  => false,
			'required' => array(
				'animate_on_scroll',
				'!=',
				true,
			),
		);
		$this->controls['subframe']           = array(
			'tab'     => 'content',
			'group'   => 'animation',
			'label'   => esc_html__( 'Subframe', 'am-lottieplayer' ),
			'type'    => 'checkbox',
			'default' => true,
		);
		$this->controls['speed']              = array(
			'tab'      => 'content',
			'group'    => 'animation',
			'label'    => esc_html__( 'Speed', 'am-lottieplayer' ),
			'type'     => 'number',
			'min'      => 1,
			'step'     => 0.5,
			'default'  => 1,
			'required' => array(
				'animate_on_scroll',
				'!=',
				true,
			),
		);
		$this->controls['segment_in']         = array(
			'tab'         => 'content',
			'group'       => 'animation',
			'label'       => $pro_feature . esc_html__( 'Choose where to start', 'am-lottieplayer' ),
			'description' => $pro_link,
			'type'        => 'number',
			'min'         => 0,
			'step'        => 1,
			'default'     => null,
		);
		$this->controls['segment_out']        = array(
			'tab'         => 'content',
			'group'       => 'animation',
			'label'       => $pro_feature . esc_html__( 'And where to end', 'am-lottieplayer' ),
			'description' => $pro_link,
			'type'        => 'number',
			'min'         => 0,
			'step'        => 1,
			'default'     => null,
		);
		$this->controls['intermission']       = array(
			'tab'      => 'content',
			'group'    => 'animation',
			'label'    => esc_html__( 'Pause between loops, in miliseconds. 1s = 1000', 'am-lottieplayer' ),
			'type'     => 'number',
			'min'      => 0,
			'step'     => 1,
			'default'  => 0,
			'required' => array(
				'loop',
				'=',
				true,
			),
		);

		// Interaction
		$this->controls['animate_on_scroll'] = array(
			'tab'         => 'content',
			'group'       => 'interactions',
			'label'       => $pro_feature . esc_html__( 'Animate on scroll', 'am-lottieplayer' ),
			'description' => $pro_link,
			'type'        => 'checkbox',
			'default'     => false,
		);
		$this->controls['onclick']           = array(
			'tab'     => 'content',
			'group'   => 'interactions',
			'label'   => esc_html__( 'Play on click', 'am-lottieplayer' ),
			'type'    => 'checkbox',
			'default' => false,
		);
		$this->controls['onmouseover']       = array(
			'tab'     => 'content',
			'group'   => 'interactions',
			'label'   => esc_html__( 'Play on mouseover', 'am-lottieplayer' ),
			'type'    => 'checkbox',
			'default' => false,
		);
		$this->controls['onmouseout']        = array(
			'tab'      => 'content',
			'group'    => 'interactions',
			'label'    => esc_html__( 'On mouseout', 'am-lottieplayer' ),
			'type'     => 'select',
			'options'  => array(
				'void',
				'stop',
				'pause',
				'reverse',
			),
			'default'  => 'void',
			'required' => array(
				'onmouseover',
				'=',
				true,
			),
		);
		$this->controls['selector']          = array(
			'tab'         => 'content',
			'description' => esc_html__( 'Anchor tag (id) for an element you want to trigger the animation, either by hover or click.', 'am-lottieplayer' ) . $pro_link,
			'group'       => 'interactions',
			'label'       => $pro_feature . esc_html__( 'Trigger element', 'am-lottieplayer' ),
			'type'        => 'text',
			'default'     => '#',
		);
		$this->controls['exclude_selector']  = array(
			'tab'         => 'content',
			'group'       => 'interactions',
			'label'       => $pro_feature . esc_html__( 'Apply interaction only to trigger element', 'am-lottieplayer' ),
			'description' => $pro_link,
			'type'        => 'checkbox',
			'default'     => false,
		);
		$this->controls['scroll']            = array(
			'tab'     => 'content',
			'group'   => 'interactions',
			'label'   => esc_html__(
				'Play on scroll, when visible in viewport',
				'am-lottieplayer'
			),
			'type'    => 'checkbox',
			'default' => false,
		);
		$this->controls['once']              = array(
			'tab'      => 'content',
			'group'    => 'interactions',
			'label'    => esc_html__(
				'Play only once',
				'am-lottieplayer'
			),
			'type'     => 'checkbox',
			'default'  => false,
			'required' => array(
				'scroll',
				'=',
				true,
			),
		);
		$this->controls['delay']             = array(
			'tab'      => 'content',
			'group'    => 'interactions',
			'label'    => esc_html__(
				'Delay, in 10th of a second',
				'am-lottieplayer'
			),
			'type'     => 'number',
			'min'      => 0,
			'max'      => 50,
			'step'     => 1,
			'default'  => 0,
			'required' => array(
				'scroll',
				'=',
				true,
			),
		);

		// Advanced
		$this->controls['renderer']       = array(
			'tab'         => 'content',
			'group'       => 'advanced',
			'label'       => $pro_feature . esc_html__( 'Renderer', 'am-lottieplayer' ),
			'description' => $pro_link,
			'type'        => 'select',
			'options'     => array(
				'SVG'    => 'svg',
				'Canvas' => 'canvas',
				// 'HTML'   => 'html',
			),
			'default'     => 'svg',
		);
		$this->controls['alt']            = array(
			'tab'         => 'content',
			'description' => esc_html__(
				'Describe the animation. This is helpful for screen readers and search engines.',
				'am-lottieplayer'
			),
			'group'       => 'advanced',
			'label'       => esc_html__( 'Description', 'am-lottieplayer' ),
			'type'        => 'text',
			'default'     => '',
		);
		$this->controls['class']          = array(
			'tab'     => 'content',
			'group'   => 'advanced',
			'label'   => esc_html__( 'CSS Class Selector', 'am-lottieplayer' ),
			'type'    => 'text',
			'default' => '',
		);
		$this->controls['url']            = array(
			'tab'         => 'content',
			'group'       => 'advanced',
			'label'       => esc_html__( 'Animation Link URL', 'am-lottieplayer' ),
			'description' => esc_html__( 'If you would like your Lottie to be a link, input your destination URL here. No link will be created if this field is left blank.', 'am-lottieplayer' ),
			'type'        => 'text',
			'default'     => '',
		);
		$this->controls['url_new_window'] = array(
			'label'       => esc_html__( 'Animation Link Target', 'am-lottieplayer' ),
			'description' => esc_html__( 'Here you can choose whether or not your link opens in a new window', 'am-lottieplayer' ),
			'type'        => 'select',
			'options'     => array(
				false => esc_html__( 'In The Same Window', 'am-lottieplayer' ),
				true  => esc_html__( 'In The New Tab', 'am-lottieplayer' ),
			),
		);

		/**
		* Styles
		*/
		// Dimensions
		$this->controls['width']      = array(
			'tab'     => 'style',
			'group'   => 'dimensions',
			'label'   => esc_html__(
				'Width',
				'am-lottieplayer'
			),
			'type'    => 'slider',
			'css'     => array(
				array(
					'property' => 'width',
				),
			),
			'units'   => array(
				'px' => array(
					'min'  => 1,
					'step' => 1,
				),
				'%'  => array(
					'min'  => 1,
					'step' => 0.1,
				),
			),
			'default' => 'auto',
		);
		$this->controls['height']     = array(
			'tab'     => 'style',
			'group'   => 'dimensions',
			'label'   => esc_html__(
				'Height',
				'am-lottieplayer'
			),
			'type'    => 'slider',
			'css'     => array(
				array(
					'property' => 'height',
				),
			),
			'units'   => array(
				'px' => array(
					'min'  => 1,
					'step' => 1,
				),
				'%'  => array(
					'min'  => 1,
					'step' => 0.1,
				),
			),
			'default' => 'auto',
		);
		$this->controls['align']      = array(
			'tab'     => 'style',
			'group'   => 'dimensions',
			'label'   => esc_html__( 'Align', 'am-lottieplayer' ),
			'type'    => 'select',
			'options' => array(
				'Left'   => 'left',
				'Center' => 'center',
				'Right'  => 'right',
				'Full'   => 'full',
				'Wide'   => 'wide',
			),
			'default' => 'svg',
		);
		$this->controls['object_fit'] = array(
			'tab'     => 'style',
			'group'   => 'dimensions',
			'label'   => esc_html__(
				'Object fit',
				'am-lottieplayer'
			),
			'type'    => 'select',
			'options' => array(
				'Contain' => 'contain',
				'Coveer'  => 'cover',
				'Fill'    => 'fill',
				'None'    => 'none',
			),
			'default' => 'contain',
		);
		// Background
		$this->controls['background'] = array(
			'tab'     => 'style',
			'group'   => 'background',
			'label'   => esc_html__(
				'Background Color',
				'am-lottieplayer'
			),
			'type'    => 'color',
			'inline'  => true,
			'css'     => array(
				array(
					'property' => 'background-color',
					'selector' => 'figure.am-lottieplayer',
				),
			),
			'default' => 'transparent',
		);
	}

	public function add_actions() {
		parent::add_actions();

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_backend' ) );
	}

	public function enqueue_backend() {
		wp_register_style(
			'bricks-backend-style',
			get_style( 'bricks.css' ),
			array(),
			'1.0.0'
		);

		if ( \bricks_is_builder() ) {
			wp_enqueue_style(
				'am-icon-font',
				get_style( 'am-font.css' ),
				AAMD_LOTTIE_IS_PRO ? array() : array( 'bricks-backend-style' ),
				'1.0.0'
			);
		}
	}

	// Methods: Frontend-specific
	public function enqueue_scripts() {
		$renderer = 'svg';
		if ( isset( $this->settings['renderer'] ) ) {
			$renderer = $this->settings['renderer'];
		}

		$is_light = ! AAMD_LOTTIE_IS_PRO ||
			( $renderer === 'svg' ) ||
			(bool) get_option( 'am_lottieplayer_pro_load_light' );

		wp_enqueue_script( $is_light ? 'am-frontend-light' : 'am-frontend' );
	}

	public function render() {
		$settings = $this->settings;
		if ( ! $settings ) {
			return;
		}

		global $aamd_lottie_media;

		$source_type = isset( $settings['source_type'] ) ? $settings['source_type'] : false;
		$url         = isset( $settings['external_url'] ) ? $this->render_dynamic_data( $settings['external_url'] ) : esc_url( $aamd_lottie_media->get_default_file() );
		$json_file   = isset( $settings['media_library_file'] ) ? esc_url( $settings['media_library_file']['url'] ) : '';

		$direction = 1;
		if ( isset( $settings['reverse'] ) && $settings['reverse'] ) {
			$direction = -1;
		}

		$mode = 'normal';
		if ( isset( $settings['mode'] ) && $settings['mode'] ) {
			$mode = 'bounce';
		}

		$attrs = \array_merge(
			$settings,
			array(
				'direction'   => $direction,
				'mode'        => $mode,
				'objectfit'   => $settings['object_fit'],
				'width_unit'  => 'px', // TODO:
				'height_unit' => 'px', // TODO:
				'src'         => $source_type === 'url' ? $url : $json_file,
			),
		);

		echo wp_kses(
			render_shortcode( $attrs ),
			get_allowed_html()
		);
	}
}
