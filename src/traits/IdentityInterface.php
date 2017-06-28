<?php

namespace ethercreative\apie\traits;

trait IdentityInterface
{
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        switch ($type)
        {
            case 'yii\filters\auth\HttpBearerAuth':
                if ($token = \ethercreative\apie\models\user\AccessToken::find()->with('user')->andWhere(['token' => $token])->andWhere(['>', 'expire_at', 'NOW()'])->one())
                    return $token->user;
            break;

            case 'yii\filters\auth\QueryParamAuth':
                if ($token = \ethercreative\apie\models\user\ApiKey::find()->with('user')->andWhere(['token' => $token])->one())
                    return $token->user;
            break;
        }

        return false;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }
}
