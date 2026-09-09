<?php
namespace AAMD_Lottie;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

use function AAMD_Lottie\Utility\get_allowed_html;
use function AAMD_Lottie\Utility\get_style;
use function AAMD_Lottie\Utility\render_shortcode;
use function AAMD_Lottie\Utility\use_id;

\defined( 'ABSPATH' ) || exit;

class Elementor extends Widget_Base {

	public function __construct( $data = array(), ?array $args = null ) {
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

	private string $_preview_id;

	/** This is the limit of how many animations in one file you can control */
	private $_num_of_animaitons = 6;

	private function _set_preview_id( ?string $id ) {
		$this->_preview_id = use_id() . ( $id ?? '' );
	}

	public function get_script_depends() {
		return array( AAMD_LOTTIE_IS_PRO ? 'dotlottie-player' : 'dotlottie-player-light' );
	}

	public function get_name() {
		return 'am_lottieplayer_widget';
	}

	public function get_title() {
		return esc_html__( 'AM LottiePlayer', TEXT_DOMAIN );
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
				'label' => esc_html__( 'AM Lottie', TEXT_DOMAIN ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'lottie',
			array(
				'label'      => esc_html__( 'Choose animation', TEXT_DOMAIN ),
				'type'       => Controls_Manager::MEDIA,
				'media_type' => array(
					'application/json',
					'application/zip',
					'application/zip+dotlottie',
				),
				'default'    => array(
					'url' => esc_url( $aamd_lottie_media->get_default_file() ),
				),
			)
		);

		$this->add_control(
			'separator_animation_options',
			array(
				'type'  => Controls_Manager::DIVIDER,
				'style' => 'thick',
			)
		);

		$this->add_control(
			'num_of_animations',
			array(
				'label'       => $pro_feature . esc_html__( 'Number of animations', TEXT_DOMAIN ),
				'description' => $pro_link,
				'type'        => Controls_Manager::NUMBER,
				'default'     => 1,
				'max'         => $this->_num_of_animaitons,
				'classes'     => AAMD_LOTTIE_IS_PRO ? '' : 'disable',
			)
		);

		$this->add_control(
			'controls',
			array(
				'label'     => esc_html__( 'Controls', TEXT_DOMAIN ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', TEXT_DOMAIN ),
				'label_off' => esc_html__( 'Hide', TEXT_DOMAIN ),
				'default'   => 'yes',
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'      => esc_html__( 'Autoplay', TEXT_DOMAIN ),
				'type'       => Controls_Manager::SWITCHER,
				'label_on'   => esc_html__( 'On', TEXT_DOMAIN ),
				'label_off'  => esc_html__( 'Off', TEXT_DOMAIN ),
				'conditions' => array(
					'terms' => array(
						array(
							'name'     => 'animateonscroll',
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

		for ( $i = 1; $i <= $this->_num_of_animaitons; $i++ ) {
			$this->add_control(
				"autoplay_{$i}",
				array(
					/* translators: %d: animation interation */
					'label'      => \sprintf( esc_html__( 'Autoplay %d', TEXT_DOMAIN ), $i ),
					'type'       => Controls_Manager::SWITCHER,
					'label_on'   => esc_html__( 'On', TEXT_DOMAIN ),
					'label_off'  => esc_html__( 'Off', TEXT_DOMAIN ),
					'conditions' => array(
						'terms' => array(
							array(
								'name'     => 'animateonscroll',
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
				'label'      => esc_html__( 'Loop', TEXT_DOMAIN ),
				'type'       => Controls_Manager::SWITCHER,
				'label_on'   => esc_html__( 'On', TEXT_DOMAIN ),
				'label_off'  => esc_html__( 'Off', TEXT_DOMAIN ),
				'conditions' => array(
					'terms' => array(
						array(
							'name'     => 'animateonscroll',
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

		for ( $i = 1; $i < $this->_num_of_animaitons; $i++ ) {
			$this->add_control(
				"loop_{$i}",
				array(
					/* translators: %d: animation interation */
					'label'      => \sprintf( esc_html__( 'Loop %d', TEXT_DOMAIN ), $i ),
					'type'       => Controls_Manager::SWITCHER,
					'label_on'   => esc_html__( 'On', TEXT_DOMAIN ),
					'label_off'  => esc_html__( 'Off', TEXT_DOMAIN ),
					'conditions' => array(
						'terms' => array(
							array(
								'name'     => 'animateonscroll',
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
				'label'       => $pro_feature . esc_html__( 'Boomerang', TEXT_DOMAIN ),
				'description' => $pro_link,
				'type'        => Controls_Manager::SWITCHER,
				'label_on'    => esc_html__( 'On', TEXT_DOMAIN ),
				'label_off'   => esc_html__( 'Off', TEXT_DOMAIN ),
				'conditions'  => array(
					'terms' => array(
						array(
							'name'     => 'animateonscroll',
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

		for ( $i = 1; $i < $this->_num_of_animaitons; $i++ ) {
			$this->add_control(
				"mode_{$i}",
				array(
					/* translators: %d: animation interation */
					'label'      => \sprintf( esc_html__( 'Boomerang %d', TEXT_DOMAIN ), $i ),
					'type'       => Controls_Manager::SWITCHER,
					'label_on'   => esc_html__( 'On', TEXT_DOMAIN ),
					'label_off'  => esc_html__( 'Off', TEXT_DOMAIN ),
					'conditions' => array(
						'terms' => array(
							array(
								'name'     => 'animateonscroll',
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
				'label'      => esc_html__( 'Reverse', TEXT_DOMAIN ),
				'type'       => Controls_Manager::SWITCHER,
				'label_on'   => esc_html__( 'Yes', TEXT_DOMAIN ),
				'label_off'  => esc_html__( 'No', TEXT_DOMAIN ),
				'conditions' => array(
					'terms' => array(
						array(
							'name'     => 'animateonscroll',
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

		for ( $i = 1; $i < $this->_num_of_animaitons; $i++ ) {
			$this->add_control(
				"reverse_{$i}",
				array(
					/* translators: %d: animation interation */
					'label'      => \sprintf( esc_html__( 'Reverse %d', TEXT_DOMAIN ), $i ),
					'type'       => Controls_Manager::SWITCHER,
					'label_on'   => esc_html__( 'Yes', TEXT_DOMAIN ),
					'label_off'  => esc_html__( 'No', TEXT_DOMAIN ),
					'conditions' => array(
						'terms' => array(
							array(
								'name'     => 'animateonscroll',
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
				'label'     => esc_html__( 'Subframe', TEXT_DOMAIN ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', TEXT_DOMAIN ),
				'label_off' => esc_html__( 'No', TEXT_DOMAIN ),
				'default'   => 'yes',
			)
		);

		$this->add_control(
			'speed',
			array(
				'label'       => esc_html__( 'Playback speed', TEXT_DOMAIN ),
				'type'        => Controls_Manager::NUMBER,
				'step'        => 0.1,
				'placeholder' => 1,
				'default'     => 1,
				'conditions'  => array(
					'terms' => array(
						array(
							'name'     => 'animateonscroll',
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

		for ( $i = 1; $i < $this->_num_of_animaitons; $i++ ) {
			$this->add_control(
				"speed_{$i}",
				array(
					/* translators: %d: animation interation */
					'label'       => \sprintf( esc_html__( 'Playback speed %d', TEXT_DOMAIN ), $i ),
					'type'        => Controls_Manager::NUMBER,
					'step'        => 0.1,
					'placeholder' => 1,
					'default'     => 1,
					'conditions'  => array(
						'terms' => array(
							array(
								'name'     => 'animateonscroll',
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
				'label'       => esc_html__( 'Intermission', TEXT_DOMAIN ),
				'description' => esc_html__( 'Pause between loops, in miliseconds. 1s = 1000', TEXT_DOMAIN ),
				'type'        => Controls_Manager::NUMBER,
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
				'label'       => esc_html__( 'Intermission 1', TEXT_DOMAIN ),
				'description' => esc_html__( 'Pause between loops, in miliseconds. 1s = 1000', TEXT_DOMAIN ),
				'type'        => Controls_Manager::NUMBER,
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
					'label'       => \sprintf( esc_html__( 'Intermission %d', TEXT_DOMAIN ), $i ),
					'description' => esc_html__( 'Pause between loops, in miliseconds. 1s = 1000', TEXT_DOMAIN ),
					'type'        => Controls_Manager::NUMBER,
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
				'label'       => $pro_feature . esc_html__( 'Choose where to start', TEXT_DOMAIN ),
				'description' => $pro_link,
				'type'        => Controls_Manager::NUMBER,
				'step'        => 1,
				'min'         => 0,
				'default'     => null,
				'classes'     => AAMD_LOTTIE_IS_PRO ? '' : 'disable',
			),
		);

		$this->add_control(
			'segment_out',
			array(
				'label'       => $pro_feature . esc_html__( 'And where to end', TEXT_DOMAIN ),
				'description' => $pro_link,
				'type'        => Controls_Manager::NUMBER,
				'step'        => 1,
				'min'         => 0,
				'default'     => null,
				'classes'     => AAMD_LOTTIE_IS_PRO ? '' : 'disable',
			),
		);

		$this->add_control(
			'separator_interaction_options',
			array(
				'type'  => Controls_Manager::DIVIDER,
				'style' => 'thin',
			)
		);

		$this->add_control(
			'animateonscroll',
			array(
				'label'       => $pro_feature . esc_html__( 'Animate on scroll', TEXT_DOMAIN ),
				'description' => esc_html__( 'Make the animation play only when scrolling, relative to the speed and direction of the scroll', TEXT_DOMAIN ) . $pro_link,
				'type'        => Controls_Manager::SWITCHER,
				'label_on'    => esc_html__( 'Yes', TEXT_DOMAIN ),
				'label_off'   => esc_html__( 'No', TEXT_DOMAIN ),
				'classes'     => AAMD_LOTTIE_IS_PRO ? '' : 'disable',
				'default'     => 'no',
			)
		);

		$this->add_control(
			'playonclick',
			array(
				'label'     => esc_html__( 'Play on click', TEXT_DOMAIN ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', TEXT_DOMAIN ),
				'label_off' => esc_html__( 'No', TEXT_DOMAIN ),
				'condition' => array(
					'animateonscroll!' => 'yes',
				),
			)
		);

		$this->add_control(
			'hover',
			array(
				'label'     => esc_html__( 'Play on mouseover', TEXT_DOMAIN ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', TEXT_DOMAIN ),
				'label_off' => esc_html__( 'No', TEXT_DOMAIN ),
				'condition' => array(
					'animateonscroll!' => 'yes',
				),
			)
		);

		$this->add_control(
			'mouseout',
			array(
				'label'     => esc_html__( 'On mouseout', TEXT_DOMAIN ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'void'    => esc_html__( 'No event', TEXT_DOMAIN ),
					'stop'    => esc_html__( 'Stop', TEXT_DOMAIN ),
					'pause'   => esc_html__( 'Pause', TEXT_DOMAIN ),
					'reverse' => esc_html__( 'Reverse', TEXT_DOMAIN ),
				),
				'default'   => 'stop',
				'condition' => array(
					'hover' => 'yes',
				),
			)
		);

		$this->add_control(
			'selector',
			array(
				'label'       => $pro_feature . esc_html__( 'Trigger element', TEXT_DOMAIN ),
				'description' => esc_html__( 'Anchor tag (id) for an element you want to trigger the animation, either by hover or click.', TEXT_DOMAIN ) . $pro_link,
				'type'        => Controls_Manager::TEXT,
				'placeholder' => '#',
				'classes'     => AAMD_LOTTIE_IS_PRO ? '' : 'disable',
				'conditions'  => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'name'     => 'playonclick',
							'operator' => '===',
							'value'    => 'yes',
						),
						array(
							'name'     => 'hover',
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
				'label'       => $pro_feature . esc_html__( 'Apply interaction only to trigger element', TEXT_DOMAIN ),
				'description' => $pro_link,
				'type'        => Controls_Manager::SWITCHER,
				'label_on'    => esc_html__( 'Yes', TEXT_DOMAIN ),
				'label_off'   => esc_html__( 'No', TEXT_DOMAIN ),
				'default'     => 'no',
				'classes'     => AAMD_LOTTIE_IS_PRO ? '' : 'disable',
				'conditions'  => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'name'     => 'playonclick',
							'operator' => '===',
							'value'    => 'yes',
						),
						array(
							'name'     => 'hover',
							'operator' => '===',
							'value'    => 'yes',
						),
					),
				),
			)
		);

		$this->add_control(
			'playonvisible',
			array(
				'label'     => esc_html__( 'Play on scroll, when visible in viewport', TEXT_DOMAIN ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', TEXT_DOMAIN ),
				'label_off' => esc_html__( 'No', TEXT_DOMAIN ),
				'condition' => array(
					'animateonscroll!' => 'yes',
				),
			)
		);

		$this->add_control(
			'delay',
			array(
				'label'     => esc_html__( 'Delay, in milliseconds', TEXT_DOMAIN ),
				'type'      => Controls_Manager::NUMBER,
				'step'      => 1,
				'min'       => 0,
				'max'       => 5000,
				'default'   => 0,
				'condition' => array(
					'playonvisible' => 'yes',
				),
			)
		);

		$this->add_control(
			'once',
			array(
				'label'     => esc_html__( 'Play only once', TEXT_DOMAIN ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', TEXT_DOMAIN ),
				'label_off' => esc_html__( 'No', TEXT_DOMAIN ),
				'condition' => array(
					'playonvisible' => 'yes',
				),
			)
		);

		$this->add_control(
			'separator_style_options',
			array(
				'type'  => Controls_Manager::DIVIDER,
				'style' => 'thick',
			)
		);

		$this->add_control(
			'align',
			array(
				'label'   => esc_html__( 'Align', TEXT_DOMAIN ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'left'   => array(
						'title' => esc_html__( 'Left', TEXT_DOMAIN ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', TEXT_DOMAIN ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', TEXT_DOMAIN ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default' => 'center',
			),
		);

		$this->add_responsive_control(
			'width',
			array(
				'label'          => esc_html__( 'Width', TEXT_DOMAIN ),
				'type'           => Controls_Manager::SLIDER,
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
				'label'     => esc_html__( 'Height', TEXT_DOMAIN ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Fixed', TEXT_DOMAIN ),
				'label_off' => esc_html__( 'Auto', TEXT_DOMAIN ),
			)
		);

		$this->add_responsive_control(
			'height_fixed',
			array(
				'type'           => Controls_Manager::SLIDER,
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
				'label'   => esc_html__( 'Object fit', TEXT_DOMAIN ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'contain' => esc_html__( 'Contain', TEXT_DOMAIN ),
					'cover'   => esc_html__( 'Cover', TEXT_DOMAIN ),
					'fill'    => esc_html__( 'Fill', TEXT_DOMAIN ),
					'none'    => esc_html__( 'None', TEXT_DOMAIN ),
				),
				'default' => 'contain',
			)
		);

		$this->add_control(
			'renderer',
			array(
				'label'       => $pro_feature . esc_html__( 'Renderer', TEXT_DOMAIN ),
				'description' => $pro_link,
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'svg'    => esc_html__( 'SVG', TEXT_DOMAIN ),
					'canvas' => esc_html__( 'Canvas', TEXT_DOMAIN ),
				),
				'default'     => 'svg',
				'classes'     => AAMD_LOTTIE_IS_PRO ? '' : 'disable',
			)
		);

		$this->add_control(
			'description',
			array(
				'label' => esc_html__( 'Description', TEXT_DOMAIN ),
				'type'  => Controls_Manager::TEXT,
			)
		);

		$this->end_controls_section();
	}

	private function _switcher_value( mixed $setting ): bool {
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
				'autoplay'               => $this->_switcher_value( $settings['playonvisible'] ) ? false : $this->_switcher_value( $settings['autoplay'] ),
				'align'                  => 'none',
				'animateonscroll'        => $this->_switcher_value( $settings['animateonscroll'] ),
				'background'             => 'transparent',
				'class'                  => '',
				'controls'               => $this->_switcher_value( $settings['controls'] ),
				'direction'              => $this->_switcher_value( $settings['reverse'] ) ? -1 : 1,
				'id'                     => $id,
				'subframe'               => $this->_switcher_value( $settings['subframe'] ),
				'loop'                   => $this->_switcher_value( $settings['loop'] ),
				'multianimationsettings' => $multiAnimationSettings,
				'objectfit'              => $settings['object_fit'],
				'playonclick'            => $this->_switcher_value( $settings['playonclick'] ),
				'hover'                  => $this->_switcher_value( $settings['hover'] ),
				'playonvisible'          => $this->_switcher_value( $settings['playonvisible'] ),
				'once'                   => $this->_switcher_value( $settings['once'] ),
				'height'                 => $settings['height_fixed'] ? $settings['height_fixed']['size'] : null,
				'height_unit'            => $settings['height_fixed'] ? $settings['height_fixed']['unit'] : null,
				'width'                  => $settings['width']['size'],
				'width_unit'             => $settings['width']['unit'],
				'description'            => $settings['description'],
				'src'                    => $src,
				'url'                    => null,
				'target'                 => '_blank',
			),
		);

		echo wp_kses(
			render_shortcode( $attrs ),
			get_allowed_html()
		);
	}
}
