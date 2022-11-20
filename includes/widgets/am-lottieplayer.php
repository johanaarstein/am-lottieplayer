<?php
class Elementor_AM_LottiePlayer extends \Elementor\Widget_Base {

	public function get_name() {
		return 'am_lottieplayer_widget';
	}

	public function get_title() {
		return esc_html__('Hello World 1', 'am-lottieplayer');
	}

	public function get_icon() {
		return 'eicon-code';
	}

	public function get_categories() {
		return ['basic'];
	}

	public function get_keywords() {
		return ['hello', 'world'];
	}

	protected function render() {
		?>

		<p> Hello World </p>

		<?php
	}
}