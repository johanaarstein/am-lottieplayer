<?php
namespace AAMD_Lottie;

use function AAMD_Lottie\Utility\render_lottieplayer;
use function AAMD_Lottie\Utility\get_allowed_html;

\defined( 'ABSPATH' ) || exit;

if ( \class_exists( '\Elementor\Widget_Base' ) ) {
	class Elementor extends \Elementor\Widget_Base {

		public function get_script_depends() {
			return array( 'am-frontend' );
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
			$pro_link = esc_html__( 'This feature will only work in the premium version.', 'am-lottieplayer' ) . ' <a href="' . esc_url( 'https://www.aarstein.media/en/am-lottieplayer/pro', 'am-lottieplayer' ) . '" target="_blank" rel="noreferrer">' . esc_html__( 'Read about additional features in AM LottiePlayer PRO', 'am-lottieplayer' ) . '<span class="dashicons dashicons-external" style="font-size: 1em;"></span></a>';

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
				'controls',
				array(
					'label'     => __( 'Controls', 'am-lottieplayer' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'label_on'  => __( 'Show', 'am-lottieplayer' ),
					'label_off' => __( 'Hide', 'am-lottieplayer' ),
					'default'   => 'yes',
				)
			);

			$this->add_control(
				'autoplay',
				array(
					'label'     => __( 'Autoplay', 'am-lottieplayer' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'label_on'  => __( 'On', 'am-lottieplayer' ),
					'label_off' => __( 'Off', 'am-lottieplayer' ),
				)
			);

			$this->add_control(
				'loop',
				array(
					'label'     => __( 'Loop', 'am-lottieplayer' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'label_on'  => __( 'On', 'am-lottieplayer' ),
					'label_off' => __( 'Off', 'am-lottieplayer' ),
				)
			);

			$this->add_control(
				'mode',
				array(
					'label'       => 'Pro Feature: ' . __( 'Boomerang', 'am-lottieplayer' ),
					'description' => $pro_link,
					'type'        => \Elementor\Controls_Manager::SWITCHER,
					'label_on'    => __( 'On', 'am-lottieplayer' ),
					'label_off'   => __( 'Off', 'am-lottieplayer' ),
				)
			);

			$this->add_control(
				'reverse',
				array(
					'label'     => __( 'Reverse', 'am-lottieplayer' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'label_on'  => __( 'Yes', 'am-lottieplayer' ),
					'label_off' => __( 'No', 'am-lottieplayer' ),
				)
			);

			$this->add_control(
				'subframe',
				array(
					'label'     => __( 'Subframe', 'am-lottieplayer' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'label_on'  => __( 'Yes', 'am-lottieplayer' ),
					'label_off' => __( 'No', 'am-lottieplayer' ),
					'default'   => 'yes',
				)
			);

			$this->add_control(
				'speed',
				array(
					'label'       => __( 'Playback speed', 'am-lottieplayer' ),
					'type'        => \Elementor\Controls_Manager::NUMBER,
					'step'        => '0.1',
					'placeholder' => '1',
					'default'     => '1',
				)
			);

			$this->add_control(
				'intermission',
				array(
					'label'       => __( 'Intermission', 'am-lottieplayer' ),
					'description' => esc_html__( 'Pause between loops, in miliseconds. 1s = 1000', 'am-lottieplayer' ),
					'type'        => \Elementor\Controls_Manager::NUMBER,
					'step'        => '100',
					'min'         => '0',
					'default'     => null,
				),
			);

			$this->add_control(
				'segment_in',
				array(
					'label'       => 'Pro Feature: ' . __( 'Choose where to start', 'am-lottieplayer' ),
					'description' => $pro_link,
					'type'        => \Elementor\Controls_Manager::NUMBER,
					'step'        => '1',
					'min'         => '0',
					'default'     => null,
				),
			);

			$this->add_control(
				'segment_out',
				array(
					'label'       => 'Pro Feature: ' . __( 'And where to end', 'am-lottieplayer' ),
					'description' => $pro_link,
					'type'        => \Elementor\Controls_Manager::NUMBER,
					'step'        => '1',
					'min'         => '0',
					'default'     => null,
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
					'label'       => 'Pro Feature: ' . __( 'Animate on scroll', 'am-lottieplayer' ),
					'description' => $pro_link,
					'type'        => \Elementor\Controls_Manager::SWITCHER,
					'label_on'    => __( 'Yes', 'am-lottieplayer' ),
					'label_off'   => __( 'No', 'am-lottieplayer' ),
				)
			);

			$this->add_control(
				'onclick',
				array(
					'label'     => __( 'Play on click', 'am-lottieplayer' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'label_on'  => __( 'Yes', 'am-lottieplayer' ),
					'label_off' => __( 'No', 'am-lottieplayer' ),
				)
			);

			$this->add_control(
				'onmouseover',
				array(
					'label'     => __( 'Play on mouseover', 'am-lottieplayer' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'label_on'  => __( 'Yes', 'am-lottieplayer' ),
					'label_off' => __( 'No', 'am-lottieplayer' ),
				)
			);

			$this->add_control(
				'onmouseout',
				array(
					'label'     => __( 'On mouseout', 'am-lottieplayer' ),
					'type'      => \Elementor\Controls_Manager::SELECT,
					'options'   => array(
						'void'    => __( 'No event', 'am-lottieplayer' ),
						'stop'    => __( 'Stop', 'am-lottieplayer' ),
						'pause'   => __( 'Pause', 'am-lottieplayer' ),
						'reverse' => __( 'Reverse', 'am-lottieplayer' ),
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
					'label'       => 'Pro Feature: ' . __( 'Trigger element', 'am-lottieplayer' ),
					'description' => __( 'Anchor tag (id) for an element you want to trigger the animation, either by hover or click.', 'am-lottieplayer' ) . $pro_link,
					'type'        => \Elementor\Controls_Manager::TEXT,
					'placeholder' => '#',
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
					'label'       => 'Pro Feature: ' . __( 'Apply interaction only to trigger element', 'am-lottieplayer' ),
					'description' => $pro_link,
					'type'        => \Elementor\Controls_Manager::SWITCHER,
					'label_on'    => __( 'Yes', 'am-lottieplayer' ),
					'label_off'   => __( 'No', 'am-lottieplayer' ),
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
					'label'     => __( 'Play on scroll, when visible in viewport', 'am-lottieplayer' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'label_on'  => __( 'Yes', 'am-lottieplayer' ),
					'label_off' => __( 'No', 'am-lottieplayer' ),
				)
			);

			$this->add_control(
				'delay',
				array(
					'label'     => __( 'Delay, in 10th of a second', 'am-lottieplayer' ),
					'type'      => \Elementor\Controls_Manager::NUMBER,
					'step'      => '1',
					'min'       => '0',
					'max'       => '50',
					'default'   => '1',
					'condition' => array(
						'scroll' => 'yes',
					),
				)
			);

			$this->add_control(
				'once',
				array(
					'label'     => __( 'Play only once', 'am-lottieplayer' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'label_on'  => __( 'Yes', 'am-lottieplayer' ),
					'label_off' => __( 'No', 'am-lottieplayer' ),
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

			$this->add_responsive_control(
				'width',
				array(
					'label'          => __( 'Width', 'am-lottieplayer' ),
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
					'label'     => __( 'Height', 'am-lottieplayer' ),
					'type'      => \Elementor\Controls_Manager::SWITCHER,
					'label_on'  => __( 'Fixed', 'am-lottieplayer' ),
					'label_off' => __( 'Auto', 'am-lottieplayer' ),
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
					'label'   => __( 'Object fit', 'am-lottieplayer' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => array(
						'contain' => __( 'Contain', 'am-lottieplayer' ),
						'cover'   => __( 'Cover', 'am-lottieplayer' ),
						'fill'    => __( 'Fill', 'am-lottieplayer' ),
						'none'    => __( 'None', 'am-lottieplayer' ),
					),
					'default' => 'contain',
				)
			);

			$this->add_control(
				'renderer',
				array(
					'label'       => 'Pro Feature: ' . __( 'Renderer', 'am-lottieplayer' ),
					'description' => $pro_link,
					'type'        => \Elementor\Controls_Manager::SELECT,
					'options'     => array(
						'svg'    => __( 'SVG', 'am-lottieplayer' ),
						'canvas' => __( 'Canvas', 'am-lottieplayer' ),
					),
					'default'     => 'svg',
				)
			);

			$this->add_control(
				'description',
				array(
					'label'   => __( 'Description', 'am-lottieplayer' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => __( 'AM LottiePlayer animation', 'am-lottieplayer' ),
				)
			);

			$this->end_controls_section();
		}

		private function _switcher_value( $setting ): bool {
			return $setting === 'yes';
		}

		protected function render() {
			$settings = $this->get_settings_for_display();

			if ( ! isset( $settings['lottie']['url'] ) || empty( $settings['lottie']['url'] ) ) {
				return;
			}

			$src = $settings['lottie']['url'];
			$ext = \pathinfo( $src, PATHINFO_EXTENSION );

			if ( $ext !== 'json' && $ext !== 'lottie' ) {
				return;
			}

			$attrs = \array_merge(
				$settings,
				array(
					'autoplay'    => $this->_switcher_value( $settings['scroll'] ) ? false : $this->_switcher_value( $settings['autoplay'] ),
					'align'       => 'none',
					'background'  => 'transparent',
					'class'       => '',
					'controls'    => $this->_switcher_value( $settings['controls'] ),
					'direction'   => $this->_switcher_value( $settings['reverse'] ),
					'id'          => $this->get_id(),
					'subframe'    => $this->_switcher_value( $settings['subframe'] ),
					'loop'        => $this->_switcher_value( $settings['loop'] ),
					'objectfit'   => $settings['object_fit'],
					'onClick'     => $this->_switcher_value( $settings['onclick'] ),
					'onMouseOver' => $this->_switcher_value( $settings['onmouseover'] ),
					'scroll'      => $this->_switcher_value( $settings['scroll'] ),
					'once'        => $this->_switcher_value( $settings['once'] ),
					'height'      => $settings['height_fixed'] ? $settings['height_fixed']['size'] : null,
					'height_unit' => $settings['height_fixed'] ? $settings['height_fixed']['unit'] : null,
					'width'       => $settings['width']['size'],
					'width_unit'  => $settings['width']['unit'],
					'alt'         => $settings['description'],
					'src'         => $src,
					'url'         => null,
					'target'      => '_blank',
				),
			);

			echo wp_kses(
				render_lottieplayer( $attrs ),
				get_allowed_html()
			);
		}

		protected function content_template() {
			?>
			<#
				const autoplay = settings.autoplay === 'yes' ? 'autoplay' : '',
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
				<figure style="width:{{{ width.size }}}{{{ width.unit }}};height:{{{ height }}};margin:auto;">
					<dotlottie-player
						simple
						{{{ autoplay }}}
						{{{ controls }}}
						{{{ loop }}}
						{{{ subframe }}}
						direction="{{{ direction }}}"
						objectfit="{{{ object_fit }}}"
						speed="{{{ playbackSpeed }}}"
						src="{{{ lottie.url }}}"
						intermission="{{{ settings.intermission }}}"></dotlottie-player>
				</figure>
			<?php
		}
	}

	$args->register( new Elementor() );
}
