<?php

namespace ethercreative\apie\models;

use Yii;
use yii\helpers\ArrayHelper;

class LoginForm extends \yii\base\Model
{
    public
        $userClass = '\ethercreative\apie\models\user\User',
        $email,
        $password,
        $rememberMe = false;

    private $_user;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['loginAttempts'] = [
            'class' => '\ethercreative\loginattempts\LoginAttemptBehavior',
        ];

        return $behaviors;
    }

    public function rules()
    {
        return [
            [['email','password'], 'required'],
            ['email', 'email'],
            ['password', 'string', 'min' => 6, 'max' => 32],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password) || ArrayHelper::isIn($this->email, ArrayHelper::getValue(Yii::$app->params, 'admin.emails', [])))
                $this->addError($attribute, 'Incorrect email or password.');
        }
    }

    public function login()
    {
        if ($this->validate())
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);

        return false;
    }

    public function getUser()
    {
        if (!$this->_user)
            $this->_user = ($this->userClass)::findByEmail($this->email);

        return $this->_user;
    }
}
