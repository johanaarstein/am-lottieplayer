<?php
namespace AAMD_Lottie;

use function AAMD_Lottie\Utility\get_allowed_html;
use function AAMD_Lottie\Utility\get_style;
// use function AAMD_Lottie\Utility\render_lottieplayer;
use function AAMD_Lottie\Utility\render_shortcode;
use function AAMD_Lottie\Utility\use_id;

\defined( 'ABSPATH' ) || exit;

class Elementor extends \Elementor\Widget_Base {

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		wp_register_style(
			'elementor-backend-style',
			get_style( 'elementor.css' ),
			array(),
			'1.0.1'
		);

		wp_enqueue_style(
			'am-icon-font',
			get_style( 'am-font.css' ),
			array( 'elementor-backend-style' ),
			'1.0.0'
		);

		$this->_set_preview_id( 'preview-id' );
	}

	private $_preview_id;

	/** This is the limit of how many animations in one file you can control */
	private $_num_of_animaitons = 6;

	private function _set_preview_id() {
		$this->_preview_id = use_id();
	}

	public function get_script_depends() {
		return array( AAMD_LOTTIE_IS_PRO ? 'am-frontend' : 'am-frontend-light' );
	}

	public function get_name() {
		return 'am_lottieplayer_widget';
	}

	public function get_title() {
		return esc_html__( 'AM LottiePlayer', 'am-lottieplayer' );
	}

	public function get_icon() {
		return 'eicon-am-lottie';
	}

	public function get_categories() {
		return array( 'general' );
	}

	public function get_keywords() {
		return array( 'lottie', 'gutenberg', 'animation', 'motion graphic', 'vector', 'svg' );
	}

	protected function register_controls() {
		global $aamd_lottie_media;
		global $pro_link;
		global $pro_feature;

		$this->start_controls_section(
			'animation_section',
			array(
				'label' => esc_html__( 'AM Lottie', 'am-lottieplayer' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'lottie',
			array(
				'label'      => esc_html__( 'Choose animation', 'am-lottieplayer' ),
				'type'       => \Elementor\Controls_Manager::MEDIA,
				'media_type' => array(
					'application/json',
					'application/zip',
				),
				'default'    => array(
					'url' => esc_url( $aamd_lottie_media->get_default_file() ),
				),
			)
		);

		$this->add_control(
			'separator_animation_options',
			array(
				'type'  => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			)
		);

		$this->add_control(
			'num_of_animations',
			array(
				'label'       => $pro_feature . esc_html__( 'Number of animations', 'am-lottieplayer' ),
				'description' => $pro_link,
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'default'     => 1,
				'max'         => $this->_num_of_animaitons,
				'classes'     => AAMD_LOTTIE_IS_PRO ? '' : 'disable',
			)
		);

		$this->add_control(
			'controls',
			array(
				'label'     => esc_html__( 'Controls', 'am-lottieplayer' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'am-lottieplayer' ),
				'label_off' => esc_html__( 'Hide', 'am-lottieplayer' ),
				'default'   => 'yes',
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'      => esc_html__( 'Autoplay', 'am-lottieplayer' ),
				'type'       => \Elementor\Controls_Manager::SWITCHER,
				'label_on'   => esc_html__( 'On', 'am-lottieplayer' ),
				'label_off'  => esc_html__( 'Off', 'am-lottieplayer' ),
				'conditions' => array(
					'terms' => array(
						array(
							'name'     => 'animate_on_scroll',
							'operator' => '!==',
							'value'    => 'yes',
						),
						array(
							'name'     => 'num_of_animations',
							'operator' => '===',
							'value'    => 1,
						),
					),
				),
			)
		);

		// TODO: Make this more elegant
		$this->add_control(
			'autoplay_1',
			array(
				'label'      => esc_html__( 'Autoplay 1', 'am-lottieplayer' ),
				'type'       => \Elementor\Controls_Manager::SWITCHER,
				'label_on'   => esc_html__( 'On', 'am-lottieplayer' ),
				'label_off'  => esc_html__( 'Off', 'am-lottieplayer' ),
				'conditions' => array(
					'terms' => array(
						array(
							'name'     => 'animate_on_scroll',
							'operator' => '!==',
							'value'    => 'yes',
						),
						array(
							'name'     => 'num_of_animations',
							'operator' => '>',
							'value'    => 1,
						),
					),
				),
			)
		);

		for ( $i = 2; $i <= $this->_num_of_animaitons; $i++ ) {
			$this->add_control(
				"autoplay_{$i}",
				array(
					/* translators: %d: animation interation */
					'label'      => \sprintf( esc_html__( 'Autoplay %d', 'am-lottieplayer' ), $i ),
					'type'       => \Elementor\Controls_Manager::SWITCHER,
					'label_on'   => esc_html__( 'On', 'am-lottieplayer' ),
					'label_off'  => esc_html__( 'Off', 'am-lottieplayer' ),
					'conditions' => array(
						'terms' => array(
							array(
								'name'     => 'animate_on_scroll',
								'operator' => '!==',
								'value'    => 'yes',
							),
							array(
								'name'     => 'num_of_animations',
								'operator' => '>=',
								'value'    => $i,
							),
						),
					),
				)
			);
		}

		$this->add_control(
			'loop',
			array(
				'label'      => esc_html__( 'Loop', 'am-lottieplayer' ),
				'type'       => \Elementor\Controls_Manager::SWITCHER,
				'label_on'   => esc_html__( 'On', 'am-lottieplayer' ),
				'label_off'  => esc_html__( 'Off', 'am-lottieplayer' ),
				'conditions' => array(
					'terms' => array(
						array(
							'name'     => 'animate_on_scroll',
							'operator' => '!==',
							'value'    => 'yes',
						),
						array(
							'name'     => 'num_of_animations',
							'operator' => '===',
							'value'    => 1,
						),
					),
				),
			)
		);

		// TODO:
		$this->add_control(
			'loop_1',
			array(
				'label'      => esc_html__( 'Loop 1', 'am-lottieplayer' ),
				'type'       => \Elementor\Controls_Manager::SWITCHER,
				'label_on'   => esc_html__( 'On', 'am-lottieplayer' ),
				'label_off'  => esc_html__( 'Off', 'am-lottieplayer' ),
				'conditions' => array(
					'terms' => array(
						array(
							'name'     => 'animate_on_scroll',
							'operator' => '!==',
							'value'    => 'yes',
						),
						array(
							'name'     => 'num_of_animations',
							'operator' => '>',
							'value'    => 1,
						),
					),
				),
			)
		);

		for ( $i = 2; $i < $this->_num_of_animaitons; $i++ ) {
			$this->add_control(
				"loop_{$i}",
				array(
					/* translators: %d: animation interation */
					'label'      => \sprintf( esc_html__( 'Loop %d', 'am-lottieplayer' ), $i ),
					'type'       => \Elementor\Controls_Manager::SWITCHER,
					'label_on'   => esc_html__( 'On', 'am-lottieplayer' ),
					'label_off'  => esc_html__( 'Off', 'am-lottieplayer' ),
					'conditions' => array(
						'terms' => array(
							array(
								'name'     => 'animate_on_scroll',
								'operator' => '!==',
								'value'    => 'yes',
							),
							array(
								'name'     => 'num_of_animations',
								'operator' => '>=',
								'value'    => $i,
							),
						),
					),
				)
			);
		}

		$this->add_control(
			'mode',
			array(
				'label'       => $pro_feature . esc_html__( 'Boomerang', 'am-lottieplayer' ),
				'description' => $pro_link,
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'label_on'    => esc_html__( 'On', 'am-lottieplayer' ),
				'label_off'   => esc_html__( 'Off', 'am-lottieplayer' ),
				'conditions'  => array(
					'terms' => array(
						array(
							'name'     => 'animate_on_scroll',
							'operator' => '!==',
							'value'    => 'yes',
						),
						array(
							'name'     => 'num_of_animations',
							'operator' => '===',
							'value'    => 1,
						),
					),
				),
				'classes'     => AAMD_LOTTIE_IS_PRO ? '' : 'disable',
			)
		);

		// TODO:
		$this->add_control(
			'mode_1',
			array(
				'label'      => esc_html__( 'Boomerang 1', 'am-lottieplayer' ),
				'type'       => \Elementor\Controls_Manager::SWITCHER,
				'label_on'   => esc_html__( 'On', 'am-lottieplayer' ),
				'label_off'  => esc_html__( 'Off', 'am-lottieplayer' ),
				'conditions' => array(
					'terms' => array(
						array(
							'name'     => 'animate_on_scroll',
							'operator' => '!==',
							'value'    => 'yes',
						),
						array(
							'name'     => 'num_of_animations',
							'operator' => '>',
							'value'    => 1,
						),
					),
				),
			)
		);

		for ( $i = 2; $i < $this->_num_of_animaitons; $i++ ) {
			$this->add_control(
				"mode_{$i}",
				array(
					/* translators: %d: animation interation */
					'label'      => \sprintf( esc_html__( 'Boomerang %d', 'am-lottieplayer' ), $i ),
					'type'       => \Elementor\Controls_Manager::SWITCHER,
					'label_on'   => esc_html__( 'On', 'am-lottieplayer' ),
					'label_off'  => esc_html__( 'Off', 'am-lottieplayer' ),
					'conditions' => array(
						'terms' => array(
							array(
								'name'     => 'animate_on_scroll',
								'operator' => '!==',
								'value'    => 'yes',
							),
							array(
								'name'     => 'num_of_animations',
								'operator' => '>=',
								'value'    => $i,
							),
						),
					),
				)
			);
		}

		$this->add_control(
			'reverse',
			array(
				'label'      => esc_html__( 'Reverse', 'am-lottieplayer' ),
				'type'       => \Elementor\Controls_Manager::SWITCHER,
				'label_on'   => esc_html__( 'Yes', 'am-lottieplayer' ),
				'label_off'  => esc_html__( 'No', 'am-lottieplayer' ),
				'conditions' => array(
					'terms' => array(
						array(
							'name'     => 'animate_on_scroll',
							'operator' => '!==',
							'value'    => 'yes',
						),
						array(
							'name'     => 'num_of_animations',
							'operator' => '===',
							'value'    => 1,
						),
					),
				),
			)
		);

		// TODO:
		$this->add_control(
			'reverse_1',
			array(
				'label'      => esc_html__( 'Reverse 1', 'am-lottieplayer' ),
				'type'       => \Elementor\Controls_Manager::SWITCHER,
				'label_on'   => esc_html__( 'Yes', 'am-lottieplayer' ),
				'label_off'  => esc_html__( 'No', 'am-lottieplayer' ),
				'conditions' => array(
					'terms' => array(
						array(
							'name'     => 'animate_on_scroll',
							'operator' => '!==',
							'value'    => 'yes',
						),
						array(
							'name'     => 'num_of_animations',
							'operator' => '>',
							'value'    => 1,
						),
					),
				),
			)
		);

		for ( $i = 2; $i < $this->_num_of_animaitons; $i++ ) {
			$this->add_control(
				"reverse_{$i}",
				array(
					/* translators: %d: animation interation */
					'label'      => \sprintf( esc_html__( 'Reverse %d', 'am-lottieplayer' ), $i ),
					'type'       => \Elementor\Controls_Manager::SWITCHER,
					'label_on'   => esc_html__( 'Yes', 'am-lottieplayer' ),
					'label_off'  => esc_html__( 'No', 'am-lottieplayer' ),
					'conditions' => array(
						'terms' => array(
							array(
								'name'     => 'animate_on_scroll',
								'operator' => '!==',
								'value'    => 'yes',
							),
							array(
								'name'     => 'num_of_animations',
								'operator' => '>=',
								'value'    => $i,
							),
						),
					),
				)
			);
		}

		$this->add_control(
			'subframe',
			array(
				'label'     => esc_html__( 'Subframe', 'am-lottieplayer' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'am-lottieplayer' ),
				'label_off' => esc_html__( 'No', 'am-lottieplayer' ),
				'default'   => 'yes',
			)
		);

		$this->add_control(
			'speed',
			array(
				'label'       => esc_html__( 'Playback speed', 'am-lottieplayer' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'step'        => 0.1,
				'placeholder' => 1,
				'default'     => 1,
				'conditions'  => array(
					'terms' => array(
						array(
							'name'     => 'animate_on_scroll',
							'operator' => '!==',
							'value'    => 'yes',
						),
						array(
							'name'     => 'num_of_animations',
							'operator' => '===',
							'value'    => 1,
						),
					),
				),
			)
		);

		// TODO:
		$this->add_control(
			'speed_1',
			array(
				'label'       => esc_html__( 'Playback speed 1', 'am-lottieplayer' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'step'        => 0.1,
				'placeholder' => 1,
				'default'     => 1,
				'conditions'  => array(
					'terms' => array(
						array(
							'name'     => 'animate_on_scroll',
							'operator' => '!==',
							'value'    => 'yes',
						),
						array(
							'name'     => 'num_of_animations',
							'operator' => '>',
							'value'    => 1,
						),
					),
				),
			)
		);

		for ( $i = 2; $i < $this->_num_of_animaitons; $i++ ) {
			$this->add_control(
				"speed_{$i}",
				array(
					/* translators: %d: animation interation */
					'label'       => \sprintf( esc_html__( 'Playback speed %d', 'am-lottieplayer' ), $i ),
					'type'        => \Elementor\Controls_Manager::NUMBER,
					'step'        => 0.1,
					'placeholder' => 1,
					'default'     => 1,
					'conditions'  => array(
						'terms' => array(
							array(
								'name'     => 'animate_on_scroll',
								'operator' => '!==',
								'value'    => 'yes',
							),
							array(
								'name'     => 'num_of_animations',
								'operator' => '>=',
								'value'    => $i,
							),
						),
					),
				)
			);
		}

		$this->add_control(
			'intermission',
			array(
				'label'       => esc_html__( 'Intermission', 'am-lottieplayer' ),
				'description' => esc_html__( 'Pause between loops, in miliseconds. 1s = 1000', 'am-lottieplayer' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'step'        => 100,
				'min'         => 0,
				'default'     => null,
				'conditions'  => array(
					'terms' => array(
						array(
							'name'     => 'loop',
							'operator' => '===',
							'value'    => 'yes',
						),
						array(
							'name'     => 'num_of_animations',
							'operator' => '===',
							'value'    => 1,
						),
					),
				),
			),
		);

		$this->add_control(
			'intermission_1',
			array(
				'label'       => esc_html__( 'Intermission 1', 'am-lottieplayer' ),
				'description' => esc_html__( 'Pause between loops, in miliseconds. 1s = 1000', 'am-lottieplayer' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'step'        => 100,
				'min'         => 0,
				'default'     => null,
				'conditions'  => array(
					'terms' => array(
						array(
							'name'     => 'loop',
							'operator' => '===',
							'value'    => 'yes',
						),
						array(
							'name'     => 'num_of_animations',
							'operator' => '>',
							'value'    => 1,
						),
					),
				),
			),
		);

		for ( $i = 2; $i < $this->_num_of_animaitons; $i++ ) {
			$this->add_control(
				"intermisson_{$i}",
				array(
					/* translators: %d: animation interation */
					'label'       => \sprintf( esc_html__( 'Intermission %d', 'am-lottieplayer' ), $i ),
					'description' => esc_html__( 'Pause between loops, in miliseconds. 1s = 1000', 'am-lottieplayer' ),
					'type'        => \Elementor\Controls_Manager::NUMBER,
					'step'        => 100,
					'min'         => 0,
					'default'     => null,
					'conditions'  => array(
						'terms' => array(
							array(
								'name'     => 'loop',
								'operator' => '===',
								'value'    => 'yes',
							),
							array(
								'name'     => 'num_of_animations',
								'operator' => '>=',
								'value'    => $i,
							),
						),
					),
				)
			);
		}

		$this->add_control(
			'segment_in',
			array(
				'label'       => $pro_feature . esc_html__( 'Choose where to start', 'am-lottieplayer' ),
				'description' => $pro_link,
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'step'        => 1,
				'min'         => 0,
				'default'     => null,
				'classes'     => AAMD_LOTTIE_IS_PRO ? '' : 'disable',
			),
		);

		$this->add_control(
			'segment_out',
			array(
				'label'       => $pro_feature . esc_html__( 'And where to end', 'am-lottieplayer' ),
				'description' => $pro_link,
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'step'        => 1,
				'min'         => 0,
				'default'     => null,
				'classes'     => AAMD_LOTTIE_IS_PRO ? '' : 'disable',
			),
		);

		$this->add_control(
			'separator_interaction_options',
			array(
				'type'  => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thin',
			)
		);

		$this->add_control(
			'animate_on_scroll',
			array(
				'label'       => $pro_feature . esc_html__( 'Animate on scroll', 'am-lottieplayer' ),
				'description' => esc_html__( 'Make the animation play only when scrolling, relative to the speed and direction of the scroll', 'am-lottieplayer' ) . $pro_link,
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'label_on'    => esc_html__( 'Yes', 'am-lottieplayer' ),
				'label_off'   => esc_html__( 'No', 'am-lottieplayer' ),
				'classes'     => AAMD_LOTTIE_IS_PRO ? '' : 'disable',
				'default'     => 'no',
			)
		);

		$this->add_control(
			'onclick',
			array(
				'label'     => esc_html__( 'Play on click', 'am-lottieplayer' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'am-lottieplayer' ),
				'label_off' => esc_html__( 'No', 'am-lottieplayer' ),
				'condition' => array(
					'animate_on_scroll!' => 'yes',
				),
			)
		);

		$this->add_control(
			'onmouseover',
			array(
				'label'     => esc_html__( 'Play on mouseover', 'am-lottieplayer' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'am-lottieplayer' ),
				'label_off' => esc_html__( 'No', 'am-lottieplayer' ),
				'condition' => array(
					'animate_on_scroll!' => 'yes',
				),
			)
		);

		$this->add_control(
			'onmouseout',
			array(
				'label'     => esc_html__( 'On mouseout', 'am-lottieplayer' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'options'   => array(
					'void'    => esc_html__( 'No event', 'am-lottieplayer' ),
					'stop'    => esc_html__( 'Stop', 'am-lottieplayer' ),
					'pause'   => esc_html__( 'Pause', 'am-lottieplayer' ),
					'reverse' => esc_html__( 'Reverse', 'am-lottieplayer' ),
				),
				'default'   => 'stop',
				'condition' => array(
					'onmouseover' => 'yes',
				),
			)
		);

		$this->add_control(
			'selector',
			array(
				'label'       => $pro_feature . esc_html__( 'Trigger element', 'am-lottieplayer' ),
				'description' => esc_html__( 'Anchor tag (id) for an element you want to trigger the animation, either by hover or click.', 'am-lottieplayer' ) . $pro_link,
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => '#',
				'classes'     => AAMD_LOTTIE_IS_PRO ? '' : 'disable',
				'conditions'  => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'name'     => 'onclick',
							'operator' => '===',
							'value'    => 'yes',
						),
						array(
							'name'     => 'onmouseover',
							'operator' => '===',
							'value'    => 'yes',
						),
					),
				),
			)
		);

		$this->add_control(
			'exclude_selector',
			array(
				'label'       => $pro_feature . esc_html__( 'Apply interaction only to trigger element', 'am-lottieplayer' ),
				'description' => $pro_link,
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'label_on'    => esc_html__( 'Yes', 'am-lottieplayer' ),
				'label_off'   => esc_html__( 'No', 'am-lottieplayer' ),
				'default'     => 'no',
				'classes'     => AAMD_LOTTIE_IS_PRO ? '' : 'disable',
				'conditions'  => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'name'     => 'onclick',
							'operator' => '===',
							'value'    => 'yes',
						),
						array(
							'name'     => 'onmouseover',
							'operator' => '===',
							'value'    => 'yes',
						),
					),
				),
			)
		);

		$this->add_control(
			'scroll',
			array(
				'label'     => esc_html__( 'Play on scroll, when visible in viewport', 'am-lottieplayer' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'am-lottieplayer' ),
				'label_off' => esc_html__( 'No', 'am-lottieplayer' ),
				'condition' => array(
					'animate_on_scroll!' => 'yes',
				),
			)
		);

		$this->add_control(
			'delay',
			array(
				'label'     => esc_html__( 'Delay, in 10th of a second', 'am-lottieplayer' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'step'      => 1,
				'min'       => 0,
				'max'       => 50,
				'default'   => 0,
				'condition' => array(
					'scroll' => 'yes',
				),
			)
		);

		$this->add_control(
			'once',
			array(
				'label'     => esc_html__( 'Play only once', 'am-lottieplayer' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'am-lottieplayer' ),
				'label_off' => esc_html__( 'No', 'am-lottieplayer' ),
				'condition' => array(
					'scroll' => 'yes',
				),
			)
		);

		$this->add_control(
			'separator_style_options',
			array(
				'type'  => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			)
		);

		$this->add_control(
			'align',
			array(
				'label'   => esc_html__( 'Align', 'am-lottieplayer' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'am-lottieplayer' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'am-lottieplayer' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'am-lottieplayer' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default' => 'center',
			),
		);

		$this->add_responsive_control(
			'width',
			array(
				'label'          => esc_html__( 'Width', 'am-lottieplayer' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
				'default'        => array(
					'unit' => '%',
					'size' => '100',
				),
				'tablet_default' => array(
					'unit' => '%',
				),
				'mobile_default' => array(
					'unit' => '%',
				),
				'size_units'     => array(
					'%',
					'px',
					'vw',
				),
				'range'          => array(
					'%'  => array(
						'min' => 1,
						'max' => 100,
					),
					'px' => array(
						'min' => 1,
						'max' => 1000,
					),
					'vw' => array(
						'min' => 1,
						'max' => 100,
					),
				),
			)
		);

		$this->add_responsive_control(
			'height_auto',
			array(
				'label'     => esc_html__( 'Height', 'am-lottieplayer' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Fixed', 'am-lottieplayer' ),
				'label_off' => esc_html__( 'Auto', 'am-lottieplayer' ),
			)
		);

		$this->add_responsive_control(
			'height_fixed',
			array(
				'type'           => \Elementor\Controls_Manager::SLIDER,
				'default'        => array(
					'unit' => 'px',
				),
				'tablet_default' => array(
					'unit' => 'px',
				),
				'mobile_default' => array(
					'unit' => 'px',
				),
				'size_units'     => array(
					'%',
					'px',
					'vw',
				),
				'range'          => array(
					'%'  => array(
						'min' => 1,
						'max' => 100,
					),
					'px' => array(
						'min' => 1,
						'max' => 1000,
					),
					'vw' => array(
						'min' => 1,
						'max' => 100,
					),
				),
				'condition'      => array(
					'height_auto' => 'yes',
				),
			)
		);

		$this->add_control(
			'object_fit',
			array(
				'label'   => esc_html__( 'Object fit', 'am-lottieplayer' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'contain' => esc_html__( 'Contain', 'am-lottieplayer' ),
					'cover'   => esc_html__( 'Cover', 'am-lottieplayer' ),
					'fill'    => esc_html__( 'Fill', 'am-lottieplayer' ),
					'none'    => esc_html__( 'None', 'am-lottieplayer' ),
				),
				'default' => 'contain',
			)
		);

		$this->add_control(
			'renderer',
			array(
				'label'       => $pro_feature . esc_html__( 'Renderer', 'am-lottieplayer' ),
				'description' => $pro_link,
				'type'        => \Elementor\Controls_Manager::SELECT,
				'options'     => array(
					'svg'    => esc_html__( 'SVG', 'am-lottieplayer' ),
					'canvas' => esc_html__( 'Canvas', 'am-lottieplayer' ),
				),
				'default'     => 'svg',
				'classes'     => AAMD_LOTTIE_IS_PRO ? '' : 'disable',
			)
		);

		$this->add_control(
			'description',
			array(
				'label'   => esc_html__( 'Description', 'am-lottieplayer' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'AM LottiePlayer animation', 'am-lottieplayer' ),
			)
		);

		$this->end_controls_section();
	}

	private function _switcher_value( $setting ): bool {
		return $setting === 'yes';
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if (
			! $settings ||
			! isset( $settings['lottie']['url'] ) ||
			empty( $settings['lottie']['url'] )
		) {
			return;
		}

		$this->_num_of_animaitons = $settings['num_of_animations'];

		$src = $settings['lottie']['url'];
		$ext = \pathinfo( $src, PATHINFO_EXTENSION );

		if ( $ext !== 'json' && $ext !== 'lottie' ) {
			return;
		}

		$multiAnimationSettings = array();

		if ( $this->_num_of_animaitons > 1 ) {
			for ( $i = 1; $i <= $this->_num_of_animaitons; $i++ ) {
				\array_push(
					$multiAnimationSettings,
					(object) array(
						'autoplay'     => $this->_switcher_value( $settings[ "autoplay_{$i}" ] ),
						'loop'         => $this->_switcher_value( $settings[ "loop_{$i}" ] ),
						'mode'         => $this->_switcher_value( $settings[ "mode_{$i}" ] ),
						'speed'        => ! $settings[ "speed_{$i}" ] || empty( $settings[ "speed_{$i}" ] ) ? '1' : $settings[ "speed_{$i}" ],
						'intermission' => ! $settings[ "intermission_{$i}" ] || empty( $settings[ "intermission_{$i}" ] ) ? '0' : $settings[ "intermission_{$i}" ],
					)
				);
			}
		}

		$id = $this->get_id();
		if ( ! $id || empty( $id ) ) {
			$id = $this->_preview_id;
		}

		$attrs = \array_merge(
			$settings,
			array(
				'autoplay'                 => $this->_switcher_value( $settings['scroll'] ) ? false : $this->_switcher_value( $settings['autoplay'] ),
				'align'                    => 'none',
				'animate_on_scroll'        => $this->_switcher_value( $settings['animate_on_scroll'] ),
				'background'               => 'transparent',
				'class'                    => '',
				'controls'                 => $this->_switcher_value( $settings['controls'] ),
				'direction'                => $this->_switcher_value( $settings['reverse'] ) ? -1 : 1,
				'id'                       => $id,
				'subframe'                 => $this->_switcher_value( $settings['subframe'] ),
				'loop'                     => $this->_switcher_value( $settings['loop'] ),
				'multi_animation_settings' => $multiAnimationSettings,
				'objectfit'                => $settings['object_fit'],
				'onClick'                  => $this->_switcher_value( $settings['onclick'] ),
				'onMouseOver'              => $this->_switcher_value( $settings['onmouseover'] ),
				'scroll'                   => $this->_switcher_value( $settings['scroll'] ),
				'once'                     => $this->_switcher_value( $settings['once'] ),
				'height'                   => $settings['height_fixed'] ? $settings['height_fixed']['size'] : null,
				'height_unit'              => $settings['height_fixed'] ? $settings['height_fixed']['unit'] : null,
				'width'                    => $settings['width']['size'],
				'width_unit'               => $settings['width']['unit'],
				'alt'                      => $settings['description'],
				'src'                      => $src,
				'url'                      => null,
				'target'                   => '_blank',
			),
		);

		echo wp_kses(
			render_shortcode( $attrs ),
			get_allowed_html()
		);
	}

	protected function content_template() {
		?>
		<#
			const autoplay = settings.autoplay === 'yes' ? 'autoplay' : '',
				animateOnScroll = settings.animate_on_scroll === 'yes' ? 'animateonscroll' : '',
				controls = settings.controls === 'yes' ? 'controls' : '',
				loop = settings.loop === 'yes' ? 'loop' : '',
				subframe = settings.subframe === 'yes' ? 'subframe' : '',
				mode = settings.mode === 'yes' ? 'bounce' : 'normal',
				{
					height_auto,
					height_fixed,
					lottie,
					object_fit,
					reverse,
					segment_in,
					segment_out,
					speed,
					width
				} = settings,
				direction = reverse === 'yes' ? '-1' : '1',
				height=height_auto !== 'yes' || !height_fixed.size ? 'auto' : height_fixed.size + height_fixed.unit,
				playbackSpeed = !speed || speed === '' ? '1' : speed
		#>
			<figure class="{{{ settings.class }}} align-{{{ settings.align }}}" style="width:{{{ width.size }}}{{{ width.unit }}};height:{{{ height }}}">
				<dotlottie-player
					simple
					{{{ autoplay }}}
					{{{ controls }}}
					{{{ loop }}}
					{{{ subframe }}}
					{{{ animateOnScroll }}}
					description="{{{ settings.description }}}"
					direction="{{{ direction }}}"
					mode="{{{ mode }}}"
					objectfit="{{{ object_fit }}}"
					speed="{{{ playbackSpeed }}}"
					src="{{{ lottie.url }}}"
					intermission="{{{ settings.intermission }}}"
					data-mouseover="{{{ settings.onmouseover }}}"
					date-mouseout="{{{ settings.onmouseout }}}"
					data-click="{{{ settings.click }}}"
					data-scroll="{{{ settings.scroll }}}"
					data-delay="{{{ settings.delay }}}"
					data-once="{{{ settings.once }}}"></dotlottie-player>
			</figure>
		<?php
	}
}

$args->register( new Elementor() );
