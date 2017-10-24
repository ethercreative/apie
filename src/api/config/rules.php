<?php

return [
    [
        'class' => 'yii\rest\UrlRule',
        'pluralize' => false,
        'controller' => 'profile',
        'patterns' => [
            'GET,HEAD' => 'index',
            'PUT,PATCH,POST' => 'update',
            'OPTIONS' => 'options',
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
        'controller' => 'user',
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
