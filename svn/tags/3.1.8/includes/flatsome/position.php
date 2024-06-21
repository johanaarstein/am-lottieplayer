<?php
defined('ABSPATH') || exit;

return [
  'type' => 'group',
  'heading' => __('Position'),
  'require' => ['ux_banner'],
  'options' => [
    'position_x' => [
      'type' => 'slider',
      'heading' => __('Horizontal'),
      'save_when_default' => true,
      'responsive' => true,
      'default' => 50,
      'min'  => 0,
      'max'  => 100,
      'step' => 5
    ],
    'position_y' => [
      'type' => 'slider',
      'heading' => __('Vertical'),
      'save_when_default' => true,
      'responsive' => true,
      'default' => 50,
      'min'  => 0,
      'max'  => 100,
      'step' => 5
    ],
  ],
];
