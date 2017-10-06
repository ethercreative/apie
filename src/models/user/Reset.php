<?php

namespace ethercreative\apie\models\user;

use Yii;

class Reset extends \ethercreative\apie\ActiveRecord
{
    public static function tableName()
    {
        return 'user_reset';
    }

    public function rules()
    {
        return [
            ['user_id', 'required'],
            ['user_id', 'exist', 'targetClass' => '\ethercreative\apie\models\user\User', 'targetAttribute' => 'id'],
        ];
    }

    public function beforeSave($insert)
    {
        if (!$this->code)
            $this->code = Yii::$app->security->generateRandomString(48);

        if (!$this->expires_at)
            $this->expires_at = date('Y-m-d H:i:s', strtotime('+30 mins'));

        return parent::beforeSave($insert);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
