<?php

return [
    'errors-code' => [
        'E-001' => [
            'type' => 'Auth-Error',
            //'link' => 'url to doc',
            'description' => 'unauthenticated',
            'version' => 'v1'
        ],

        'E-002' => [
            'type' => 'Firebase-Error',
            //'link' => 'url to doc',
            'description' => 'User not found',
            'version' => 'v1'
        ],

        'E-003' => [
            'type' => 'Server-Error',
            //'link' => 'url to doc',
            'description' => 'Server error',
            'version' => 'v1'
        ],

        'E-004' => [
            'type' => 'Unique-Error',
            //'link' => 'url to doc',
            'description' => 'User with this credentials already exists',
            'version' => 'v1'
        ],

        'E-005' => [
            'type' => 'Auth-Error',
            //'link' => 'url to doc',
            'description' => 'These credentials do not match our records.',
            'version' => 'v1'
        ],

        'E-006' => [
            'type' => 'Firebase-Error',
            //'link' => 'url to doc',
            'description' => 'User in firebase do not match our records.',
            'version' => 'v1'
        ],

        'E-007' => [
            'type' => 'Resource-Error',
            //'link' => 'url to doc',
            'description' => 'This resource do not exists in our server',
            'version' => 'v1'
        ],

        'E-008' => [
            'type' => 'Resource-Error',
            //'link' => 'url to doc',
            'description' => 'This action is forbidden, we can not delete cover image',
            'version' => 'v1'
        ],

        'E-009' => [
            'type' => 'Resource-Error',
            //'link' => 'url to doc',
            'description' => 'This ticket was closed',
            'version' => 'v1'
        ],

        'E-010' => [
            'type' => 'Account-Error',
            //'link' => 'url to doc',
            'description' => 'Your account is under verification',
            'version' => 'v1'
        ],

    ]
];
