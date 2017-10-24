<?php

namespace ethercreative\apie\models;

class ForgottenForm extends \yii\base\Model
{
    public
        $userClass = '\ethercreative\apie\models\user\User',
        $resetClass = '\ethercreative\apie\models\user\Reset',
        $email;

    private $_user;

    public function rules()
    {
        return [
            [['email'], 'required'],
            ['email', 'email'],
        ];
    }

    public function reset()
    {
        if (!$this->validate())
            return false;

        $user = ($this->userClass)::find()->select(['id', 'email'])->where(['email' => $this->email])->one();

        if (!$user)
            return true;

        $model = new $this->resetClass;
        $model->user_id = $user->id;

        return $model->save();
    }
}
