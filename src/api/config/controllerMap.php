<?php

return [
    'auth' => 'ethercreative\apie\api\controllers\AuthController',
    'forgot' => 'ethercreative\apie\api\controllers\RegisterController',
    'messages' => 'ethercreative\apie\api\controllers\MessageController',
    'profile' => 'ethercreative\apie\api\controllers\ProfileController',
    'register' => 'ethercreative\apie\api\controllers\RegisterController',
    'reset' => 'ethercreative\apie\api\controllers\ResetController',
    'teams' => 'ethercreative\apie\api\controllers\TeamController',
    'user' => 'ethercreative\apie\api\controllers\UserController',

    'migrate' => [
        'class' => 'yii\console\controllers\MigrateController',
        'migrationPath' => [
            'database/migrations',
            'vendor/ethercreative/apie/src/database/migrations',
        ],
    ],
];
