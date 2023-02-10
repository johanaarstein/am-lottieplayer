<?php
if (!defined('ABSPATH')) exit('New phone, who diz?');

return [
    'type' => 'select',
    'heading' => 'Visibility',
    'default' => '',
    'options' => [
        ''   => 'Visible',
        'hidden'  => 'Hidden',
        'hide-for-medium'  => 'Only for Desktop',
        'show-for-small'   =>  'Only for Mobile',
        'show-for-medium hide-for-small' =>  'Only for Tablet',
        'show-for-medium'   =>  'Hide for Desktop',
        'hide-for-small'   =>  'Hide for Mobile',
    ],
];
