<?php

return [
    'auth' => 'ethercreative\apie\controllers\api\AuthController',
    'forgot' => 'ethercreative\apie\controllers\api\RegisterController',
    'messages' => 'ethercreative\apie\controllers\api\MessagesController',
    'profile' => 'ethercreative\apie\controllers\api\ProfileController',
    'register' => 'ethercreative\apie\controllers\api\RegisterController',
    'reset' => 'ethercreative\apie\controllers\api\ResetController',
    'teams' => 'ethercreative\apie\controllers\api\TeamsController',

    'migrate' => [
        'class' => 'yii\console\controllers\MigrateController',
        'migrationPath' => [
            'database/migrations',
            'vendor/ethercreative/apie/src/database/migrations',
        ],
    ],
];
