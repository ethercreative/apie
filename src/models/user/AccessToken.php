<?php

namespace ethercreative\apie\models\user;

class AccessToken extends \ethercreative\apie\ActiveRecord
{
    public static function tableName()
    {
        return 'access_token';
    }

    public function behaviors()
    {
        return \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => \ethercreative\apie\behaviors\Token::className(),
                'token_length' => 64,
                'token_life' => '5 minutes',
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

    public function getRefresh()
    {
        return $this->hasOne(RefreshToken::className(), ['id' => 'refresh_id']);
    }
}
