<?php

namespace ethercreative\apie\traits;

use ethercreative\apie\models\user\RefreshToken;
use ethercreative\apie\models\user\AccessToken;

trait UserTrait
{
    use \ethercreative\apie\traits\IdentityInterface;
    use \ethercreative\apie\traits\AuthenticatedUser;

    private $_password;

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function afterFind()
    {
        $return = parent::afterFind();

        $this->_password = $this->password;
        $this->password = null;

        return $return;
    }

    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            ['email', 'email'],
            ['email', 'unique'],
            [['name'], 'safe', 'on' => 'update'],

            'password' => ['password', 'required', 'on' => 'default'],
            'password_length' => ['password', 'string', 'min' => 6, 'on' => 'default'],
            'password_pwned' => ['password', '\ethercreative\validators\BeenPwned'],

            ['auth_key', 'default', 'value' => \Yii::$app->security->generateRandomString(32)],
        ];
    }

    public function fields()
    {
        return [
            'id',
            'name',
            'avatar' => function()
            {
                return 'https://www.gravatar.com/avatar/' . md5(strtolower($this->email)) . '.jpg?s=200&d=mm';
            },
            'created_at',
            'updated_at',
        ];
    }

    public function generateApiTokens()
    {
        $refresh = new RefreshToken;
        $access = new AccessToken;

        $refresh->user_id = $access->user_id = $this->id;

        if ($refresh->save())
        {
            $access->refresh_id = $refresh->id;

            if ($access->save())
            {
                return [
                    'refresh' => $refresh,
                    'access' => $access,
                ];
            }
        }

        return false;
    }
}
