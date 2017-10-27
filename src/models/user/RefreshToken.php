<?php

namespace ethercreative\apie\models\user;

class RefreshToken extends \ethercreative\apie\ActiveRecord
{
    public static function tableName()
    {
        return '{{%refresh_token}}';
    }

    public function behaviors()
    {
        return \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => \ethercreative\apie\behaviors\Token::className(),
                'token_length' => 64,
                'token_life' => '14 days',
            ]
        ]);
    }

    public function fields()
    {
        return [
            'token',
            'expire_at',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
