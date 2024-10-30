<?php
\defined( 'ABSPATH' ) || exit;

return array(
	'type'    => 'group',
	'heading' => __( 'Position', 'am-lottieplayer' ),
	'require' => array( 'ux_banner' ),
	'options' => array(
		'position_x' => array(
			'type'              => 'slider',
			'heading'           => __( 'Horizontal', 'am-lottieplayer' ),
			'save_when_default' => true,
			'responsive'        => true,
			'default'           => 50,
			'min'               => 0,
			'max'               => 100,
			'step'              => 5,
		),
		'position_y' => array(
			'type'              => 'slider',
			'heading'           => __( 'Vertical', 'am-lottieplayer' ),
			'save_when_default' => true,
			'responsive'        => true,
			'default'           => 50,
			'min'               => 0,
			'max'               => 100,
			'step'              => 5,
		),
	),
);
