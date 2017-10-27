<?php

namespace ethercreative\apie\console\controllers;

use yii\helpers\Console;
use yii\validators\EmailValidator;

/**
 * Users CRUD
 */
class UserController extends \yii\console\Controller
{
    public $modelClass = 'ethercreative\apie\models\user\User';

    /**
     * Create a new user
     */
    public function actionCreate()
    {
        $name = $this->prompt('Name:', ['required' => true, 'validator' => function($input, &$error)
        {
            $length = strlen($input);
            
            if ($length < 3 || $length > 64)
            {
                $error = 'Name must be between 3 and 64 characters.';

                return false;
            }

            return true;
        }]);

        $email = $this->prompt('Email address:', ['required' => true, 'validator' => function($input, &$error)
        {
            $validator = new EmailValidator;

            if (!$validator->validate($input))
            {
                $error = 'Invalid email';

                return false;
            }

            if (($this->modelClass)::find()->where(['email' => $input])->exists())
            {
                $error = 'Email address already taken.';

                return false;
            }

            return true;
        }]);

        $password = $this->prompt('Password:', ['required' => true, 'validator' => function($input, &$error)
        {
            $length = strlen($input);

            if ($length < 6 || $length > 32)
            {
                $error = 'Password must be between 6 and 32 characters.';

                return false;
            }

            return true;
        }]);

        $admin = $this->confirm('Set as admin?');

        if (!$this->confirm('Are you sure you want to create this user?'))
        {
            Console::clearScreen();
            echo 'Aborted';

            return;
        }

        $user = new $this->modelClass;
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        // $user->admin = $admin;

        Console::clearScreen();

        if ($user->save())
            echo 'User created.';
        else
            echo 'Validation errors.';
    }

    /**
     * Update a users record
     */
    public function actionUpdate($id)
    {

    }

    /**
     * Update a single attribute
     */
    public function actionUpdateAttribute($id, $key, $value)
    {

    }

    /**
     * View a user
     */
    public function actionView($id)
    {

    }

    /**
     * Delete a user
     */
    public function actionDelete($id)
    {

    }
}
