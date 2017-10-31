<?php

return [
    'user' => 'ethercreative\apie\console\controllers\UserController',

    'migrate' => [
        'class' => 'yii\console\controllers\MigrateController',
        'migrationPath' => [
            'database/migrations',
            'vendor/ethercreative/apie/src/database/migrations',
            'vendor/ethercreative/yii2-login-attempts-behavior/src/migrations',
        ],
    ],
];
