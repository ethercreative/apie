<?php

namespace ethercreative\apie\traits;

trait AuthenticatedUser
{
    public function beforeSave($insert)
    {
        if ($this->getDirtyAttributes(['password']))
            $this->password = \Yii::$app->security->generatePasswordHash($this->password);

        return parent::beforeSave($insert);
    }

    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }
}
