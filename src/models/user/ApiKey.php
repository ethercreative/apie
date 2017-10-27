<?php

namespace ethercreative\apie\models\user;

class ApiKey extends \ethercreative\apie\ActiveRecord
{
    public static function tableName()
    {
        return '{{%api_key}}';
    }

    public function behaviors()
    {
        return \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => \ethercreative\apie\behaviors\Token::className(),
                'token_length' => 64,
                'token_life' => false,
            ]
        ]);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
