<?php

return [
    [
        'class' => 'yii\rest\UrlRule',
        'pluralize' => false,
        'controller' => 'profile',
        'only' => [
            'index',
            'update',
            'options',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'pluralize' => false,
        'controller' => [
            'register',
            'auth',
        ],
        'only' => [
            'create',
            'options',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => [
            'users',
        ],
        'only' => [
            'index',
            'view',
            'options',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => [
            'messages',
            'teams',
        ],
    ]
];
