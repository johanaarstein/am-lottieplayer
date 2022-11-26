<?php
class Elementor_AM_LottiePlayer extends \Elementor\Widget_Base {

	public function get_name() {
		return 'am_lottieplayer_widget';
	}

	public function get_title() {
		return esc_html__('AM LottiePlayer', 'am-lottieplayer');
	}

	public function get_icon() {
		return 'eicon-lottie';
	}

	public function get_categories() {
		return ['basic'];
	}

	public function get_keywords() {
		return ['lottie', 'gutenberg', 'animation', 'motion graphic', 'vector'];
	}

	protected function register_controls() {

		$this -> start_controls_section(
			'section_title',
			[
				'label' => esc_html__('AM Lottie', 'am-lottieplayer'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this -> add_control(
			'lottie',
			[
				'label' => esc_html__('Choose animation', 'am-lottieplayer'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://storage.googleapis.com/aarsteinmedia/am-lottie.lottie' //\Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$this -> end_controls_section();


		// $this -> start_controls_section(
		// 	'section_title_style',
		// 	[
		// 		'label' => esc_html__( 'Title', 'elementor-addon' ),
		// 		'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		// 	]
		// );

		// $this->add_control(
		// 	'title_color',
		// 	[
		// 		'label' => esc_html__( 'Text Color', 'elementor-addon' ),
		// 		'type' => \Elementor\Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .hello-world' => 'color: {{VALUE}};',
		// 		],
		// 	]
		// );

		// $this->end_controls_section();

	}

	protected function render() {
		$settings = $this -> get_settings_for_display();
		?>

		<dotlottie-player
			autoplay
			loop
			controls
			src="<?php echo esc_url($settings['image']['url']); ?>"
		>
		</dotlottie-player>

		<?php
	}

	protected function content_template() {
		?>
		<dotlottie-player
			autoplay
			loop
			controls
			src="{{{ settings.lottie.url }}}"
		>
		</dotlottie-player>
		<?php
	}
}