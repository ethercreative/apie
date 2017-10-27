<?php

return [
    'user' => 'ethercreative\apie\console\controllers\UserController',

    'migrate' => [
        'class' => 'yii\console\controllers\MigrateController',
        'migrationPath' => [
            'database/migrations',
            'vendor/ethercreative/apie/src/database/migrations',
        ],
    ],
];
