<?php

return [
    'auth' => 'ethercreative\apie\controllers\api\AuthController',
    'forgot' => 'ethercreative\apie\controllers\api\RegisterController',
    'messages' => 'ethercreative\apie\controllers\api\MessagesController',
    'profile' => 'ethercreative\apie\controllers\api\ProfileController',
    'register' => 'ethercreative\apie\controllers\api\RegisterController',
    'reset' => 'ethercreative\apie\controllers\api\ResetController',
    'teams' => 'ethercreative\apie\controllers\api\TeamsController',
    // 'users' => 'ethercreative\apie\controllers\api\UsersController',

    'migrate' => [
        'class' => 'yii\console\controllers\MigrateController',
        'migrationNamespaces' => [
            'app\database\migrations',
            'apie\database\migrations',
        ],
    ],
];
