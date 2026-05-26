<?php
defined('ABSPATH') || exit;

if (class_exists('\Elementor\Widget_Base') && !class_exists('Elementor_AM_LottiePlayer')) {
	class Elementor_AM_LottiePlayer extends \Elementor\Widget_Base
	{

		public function get_script_depends()
		{
			return ['am-frontend'];
		}

		public function get_name()
		{
			return 'am_lottieplayer_widget';
		}

		public function get_title()
		{
			return esc_html__('AM LottiePlayer', 'am-lottieplayer');
		}

		public function get_icon()
		{
			return 'eicon-am-lottie';
		}

		public function get_categories()
		{
			return ['general'];
		}

		public function get_keywords()
		{
			return ['lottie', 'gutenberg', 'animation', 'motion graphic', 'vector', 'svg'];
		}

		protected function register_controls()
		{

			$this->start_controls_section(
				'animation_section',
				[
					'label' => esc_html__('AM Lottie', 'am-lottieplayer'),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);

			$this->add_control(
				'lottie',
				[
					'label' => esc_html__('Choose animation', 'am-lottieplayer'),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'media_type' => [
						'application/json',
						'application/zip',
					],
					'default' => [
						'url' => esc_url(!is_wp_error(am_lottie_asset()) ? wp_get_attachment_url(am_lottie_asset()) : am_lottie_asset(true)),
					],
				]
			);

			$this->add_control(
				'separator_animation_options',
				[
					'type'  => \Elementor\Controls_Manager::DIVIDER,
					'style' => 'thick',
				]
			);

			$this->add_control(
				'controls',
				[
					'label' => __('Controls', 'am-lottieplayer'),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __('Show', 'am-lottieplayer'),
					'label_off' => __('Hide', 'am-lottieplayer'),
					'default' => 'yes'
				]
			);

			$this->add_control(
				'autoplay',
				[
					'label' => __('Autoplay', 'am-lottieplayer'),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __('On', 'am-lottieplayer'),
					'label_off' => __('Off', 'am-lottieplayer'),
				]
			);

			$this->add_control(
				'loop',
				[
					'label' => __('Loop', 'am-lottieplayer'),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __('On', 'am-lottieplayer'),
					'label_off' => __('Off', 'am-lottieplayer'),
				]
			);

			$this->add_control(
				'mode',
				[
					'label' => __('Boomerang', 'am-lottieplayer'),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __('On', 'am-lottieplayer'),
					'label_off' => __('Off', 'am-lottieplayer'),
				]
			);

			$this->add_control(
				'reverse',
				[
					'label' => __('Reverse', 'am-lottieplayer'),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __('Yes', 'am-lottieplayer'),
					'label_off' => __('No', 'am-lottieplayer')
				]
			);

			$this->add_control(
				'subframe',
				[
					'label' => __('Subframe', 'am-lottieplayer'),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __('Yes', 'am-lottieplayer'),
					'label_off' => __('No', 'am-lottieplayer'),
					'default' => 'yes',
				]
			);

			$this->add_control(
				'speed',
				[
					'label' => __('Playback speed', 'am-lottieplayer'),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'step' => '0.1',
					'placeholder' => '1',
					'default' => '1'
				]
			);

			$this->add_control(
				'segment_in',
				[
					'label' => __('Choose where to start', 'am-lottieplayer'),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'step' => '1',
					'min' => '0',
					'default' => null
				],
			);

			$this->add_control(
				'segment_out',
				[
					'label' => __('And where to end', 'am-lottieplayer'),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'step' => '1',
					'min' => '0',
					'default' => null
				],
			);

			$this->add_control(
				'separator_animation_options',
				[
					'type' => \Elementor\Controls_Manager::DIVIDER,
					'style' => 'thin',
				]
			);

			$this->add_control(
				'onclick',
				[
					'label' => __('Play on click', 'am-lottieplayer'),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __('Yes', 'am-lottieplayer'),
					'label_off' => __('No', 'am-lottieplayer')
				]
			);

			$this->add_control(
				'onmouseover',
				[
					'label' => __('Play on mouseover', 'am-lottieplayer'),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __('Yes', 'am-lottieplayer'),
					'label_off' => __('No', 'am-lottieplayer')
				]
			);

			$this->add_control(
				'onmouseout',
				[
					'label' => __('On mouseout', 'am-lottieplayer'),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'void' => __('No event', 'am-lottieplayer'),
						'stop' => __('Stop', 'am-lottieplayer'),
						'pause' => __('Pause', 'am-lottieplayer'),
						'reverse' => __('Reverse', 'am-lottieplayer')
					],
					'default' => 'stop',
					'condition' => [
						'onmouseover' => 'yes',
					],
				]
			);

			$this->add_control(
				'selector',
				[
					'label' => __('Trigger element', 'am-lottieplayer'),
					'description' => __('Anchor tag (id) for an element you want to trigger the animation, either by hover or click.', 'am-lottieplayer'),
					'type' => \Elementor\Controls_Manager::TEXT,
					'placeholder' => '#',
					'conditions' => [
						'relation' => 'or',
						'terms' => [
							['name' => 'onclick', 'operator' => '===', 'value' => 'yes'],
							['name' => 'onmouseover', 'operator' => '===', 'value' => 'yes'],
						]
					],
				]
			);

			$this->add_control(
				'exclude',
				[
					'label' => __('Apply interaction only to trigger element', 'am-lottieplayer'),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __('Yes', 'am-lottieplayer'),
					'label_off' => __('No', 'am-lottieplayer'),
					'conditions' => [
						'relation' => 'or',
						'terms' => [
							['name' => 'onclick', 'operator' => '===', 'value' => 'yes'],
							['name' => 'onmouseover', 'operator' => '===', 'value' => 'yes'],
						]
					],
				]
			);

			$this->add_control(
				'scroll',
				[
					'label' => __('Play on scroll, when visible in viewport', 'am-lottieplayer'),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __('Yes', 'am-lottieplayer'),
					'label_off' => __('No', 'am-lottieplayer')
				]
			);

			$this->add_control(
				'delay',
				[
					'label' => __('Delay, in 10th of a second', 'am-lottieplayer'),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'step' => '1',
					'min' => '0',
					'max' => '50',
					'default' => '1',
					'condition' => [
						'scroll' => 'yes',
					],
				]
			);

			$this->add_control(
				'once',
				[
					'label' => __('Play only once', 'am-lottieplayer'),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __('Yes', 'am-lottieplayer'),
					'label_off' => __('No', 'am-lottieplayer'),
					'condition' => [
						'scroll' => 'yes',
					],
				]
			);

			$this->add_control(
				'separator_style_options',
				[
					'type'  => \Elementor\Controls_Manager::DIVIDER,
					'style' => 'thick',
				]
			);

			$this->add_responsive_control(
				'width',
				[
					'label' => __('Width', 'am-lottieplayer'),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'default' => [
						'unit' => '%',
						'size' => '100'
					],
					'tablet_default' => [
						'unit' => '%',
					],
					'mobile_default' => [
						'unit' => '%',
					],
					'size_units' => [
						'%',
						'px',
						'vw'
					],
					'range' => [
						'%' => [
							'min' => 1,
							'max' => 100
						],
						'px' => [
							'min' => 1,
							'max' => 1000
						],
						'vw' => [
							'min' => 1,
							'max' => 100
						],
					],
				]
			);

			$this->add_responsive_control(
				'height_auto',
				[
					'label' => __('Height', 'am-lottieplayer'),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __('Fixed', 'am-lottieplayer'),
					'label_off' => __('Auto', 'am-lottieplayer')
				]
			);

			$this->add_responsive_control(
				'height_fixed',
				[
					'type' => \Elementor\Controls_Manager::SLIDER,
					'default' => [
						'unit' => 'px',
					],
					'tablet_default' => [
						'unit' => 'px',
					],
					'mobile_default' => [
						'unit' => 'px',
					],
					'size_units' => [
						'%',
						'px',
						'vw'
					],
					'range' => [
						'%' => [
							'min' => 1,
							'max' => 100
						],
						'px' => [
							'min' => 1,
							'max' => 1000
						],
						'vw' => [
							'min' => 1,
							'max' => 100
						],
					],
					'condition' => [
						'height_auto' => 'yes',
					],
				]
			);

			$this->add_control(
				'object_fit',
				[
					'label' => __('Object fit', 'am-lottieplayer'),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'contain' => __('Contain', 'am-lottieplayer'),
						'cover' => __('Cover', 'am-lottieplayer'),
						'fill' => __('Fill', 'am-lottieplayer'),
						'none' => __('None', 'am-lottieplayer')
					],
					'default' => 'contain',
				]
			);

			$this->add_control(
				'renderer',
				[
					'label' => __('Renderer', 'am-lottieplayer'),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'svg' => __('SVG', 'am-lottieplayer'),
						'canvas' => __('Canvas', 'am-lottieplayer'),
					],
					'default' => 'svg',
				]
			);

			$this->add_control(
				'description',
				[
					'label' => __('Description', 'am-lottieplayer'),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __('AM LottiePlayer animation', 'am-lottieplayer')
				]
			);

			$this->end_controls_section();
		}

		private function switcher_value($setting, $on_val, $off_val)
		{
			return $setting === 'yes' ? $on_val : $off_val;
		}

		protected function render()
		{
			$widget_id = $this->get_id();
			$settings = $this->get_settings_for_display();

			if (!isset($settings['lottie']['url']) || empty($settings['lottie']['url'])) {
				return;
			}

			$src = $settings['lottie']['url'];
			$ext = pathinfo($src, PATHINFO_EXTENSION);

			if ($ext !== 'json' && $ext !== 'lottie') {
				return;
			}

			$autoplay = $this->switcher_value($settings['autoplay'], 'autoplay', '');
			$controls = $this->switcher_value($settings['controls'], 'controls', '');
			$direction = $this->switcher_value($settings['reverse'], '-1', '1');
			$subframe = $this->switcher_value($settings['subframe'], 'subframe', '');
			$loop = $this->switcher_value($settings['loop'], 'loop', '');
			$mode = $this->switcher_value($settings['mode'], 'bounce', 'normal');
			$onClick = $this->switcher_value($settings['onclick'], true, false);
			$onMouseOver = $this->switcher_value($settings['onmouseover'], true, false);
			$scroll = $this->switcher_value($settings['scroll'], true, false);
			$once = $this->switcher_value($settings['once'], true, false);

			$onMouseOut = $settings['onmouseout'];
			$objectFit = $settings['object_fit'];
			$selector = json_encode([
				"id" => $settings['selector'],
				"exclude" => $this->switcher_value($settings['exclude'], true, false),
			]);
			$speed = !$settings['speed'] || empty($settings['speed']) ? '1' : $settings['speed'];
			$heightSize = $settings['height_fixed'] ? $settings['height_fixed']['size'] : 'auto';
			$heightUnit = $settings['height_fixed'] ? $settings['height_fixed']['unit'] : '';
			$height = $this->switcher_value(
				$settings['height_auto'],
				$heightSize . $heightUnit,
				'auto'
			);
			$widthSize = $settings['width']['size'];
			$widthUnit = $settings['width']['unit'];
			$width = $widthSize . $widthUnit;
			$renderer = $settings['renderer'];

			$description = $settings['description'];

			$segment = $settings['segment_out'] &&
				$settings['segment_out'] !== '0' ?
				esc_html('[' .
					(intval($settings['segment_in']) ?? 0) . ',' .
					intval($settings['segment_out'])
					. ']') : ''; ?>

			<figure style="width:<?php echo esc_html($width); ?>;height:<?php echo esc_html($height); ?>;margin:0 auto;">
				<dotlottie-player <?php echo esc_html($autoplay); ?> <?php echo esc_html($controls); ?> <?php echo esc_html($loop); ?> <?php echo esc_html($subframe); ?> mode="<?php echo esc_html($mode); ?>" renderer="<?php echo esc_html($renderer); ?>" direction="<?php echo esc_html($direction); ?>" data-direction="<?php echo esc_html($direction); ?>" data-mouseover="<?php echo esc_html($onMouseOver); ?>" data-mouseout="<?php echo esc_html($onMouseOut); ?>" data-click="<?php echo esc_html($onClick); ?>" data-selector="<?php echo esc_html($selector); ?>" data-scroll="<?php echo esc_html($scroll); ?>" data-delay="<?php echo esc_html($settings['delay']); ?>" data-once="<?php echo esc_html($once); ?>" objectfit="<?php echo esc_html($objectFit); ?>" speed="<?php echo esc_html($speed); ?>" src="<?php echo esc_url($src); ?>" description="<?php echo esc_html($description); ?>" segment="<?php echo esc_html($segment); ?>">
				</dotlottie-player>
			</figure>
		<?php
		}

		protected function content_template()
		{
		?>
			<# const autoplay=settings.autoplay==='yes' ? 'autoplay' : '' , controls=settings.controls==='yes' ? 'controls' : '' , loop=settings.loop==='yes' ? 'loop' : '' , subframe=settings.subframe==='yes' ? 'subframe' : '' , mode=settings.mode==='yes' ? 'bounce' : 'normal' , { height_auto, height_fixed, lottie, object_fit, reverse, segment_in, segment_out, speed, width }=settings, direction=reverse==='yes' ? '-1' : '1' , height=height_auto !=='yes' || !height_fixed.size ? 'auto' : height_fixed.size + height_fixed.unit, playbackSpeed=!speed || speed==='' ? '1' : speed, segment=segment_in && segment_out && segment_out !=='0' ? JSON.stringify([segment_in, segment_out]) : undefined #>
				<figure style="width:{{{ width.size }}}{{{ width.unit }}};height:{{{ height }}};margin:auto;">
					<dotlottie-player {{{ autoplay }}} {{{ controls }}} {{{ loop }}} {{{ subframe }}} direction="{{{ direction }}}" mode="{{{ mode }}}" objectfit="{{{ object_fit }}}" speed="{{{ playbackSpeed }}}" src="{{{ lottie.url }}}" segment="{{{ segment }}}">
					</dotlottie-player>
				</figure>
	<?php
		}
	}

	$arg->register(new \Elementor_AM_LottiePlayer());
}
