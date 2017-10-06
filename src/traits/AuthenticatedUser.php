<?php

namespace ethercreative\apie\traits;

use Yii;

trait AuthenticatedUser
{
    public function beforeSave($insert)
    {
        if ($this->getDirtyAttributes(['password']) && $this->password !== $this->_password)
            $this->password = \Yii::$app->security->generatePasswordHash($this->password);

        if (!$this->auth_key)
            $this->auth_key = Yii::$app->security->generateRandomString(64);

        return parent::beforeSave($insert);
    }

    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->_password ?: $this->password);
    }
}
