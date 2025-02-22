<?php

return [
    'avatar_column' => 'avatar_url',
    'disk' => env('FILESYSTEM_DISK', 'public'),
    'visibility' => 'public', // or replace by filesystem disk visibility with fallback value

    'show_custom_fields' => true,
    'custom_fields' => [
        'custom_field_1' => [
            'type' => 'text',
            'label' => 'server',
            'placeholder' => 'server',
            'required' => true,
            'rules' => 'required|string|max:255',
        ],
    ]
];
