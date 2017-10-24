<?php

namespace ethercreative\apie\models;

class ResetForm extends \yii\base\Model
{
    public
        $new_password,
        $confirm_password,
        $reset;

    private $_user;

    public function rules()
    {
        return [
            [['new_password', 'confirm_password'], 'required'],
            ['new_password', '\ethercreative\apie\validators\BeenPwned'],
        ];
    }

    public function reset()
    {
        if (!$this->validate())
            return false;

        $user = $this->reset->user;
        $user->password = $this->new_password;

        if ($user->save())
        {
            $this->reset->delete();
            return true;
        }

        return false;
    }
}
