<?php

namespace ethercreative\apie\models\user;

use Yii;

class User extends \ethercreative\apie\ActiveRecord implements \yii\web\IdentityInterface
{
    use \ethercreative\apie\traits\IdentityInterface;
    use \ethercreative\apie\traits\AuthenticatedUser;

    private $_password;

    public static function tableName()
    {
        return 'user';
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

            ['password', 'required', 'on' => 'default'],
            ['password', 'string', 'min' => 6, 'on' => 'default'],
            ['password', '\ethercreative\validators\BeenPwned'],
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
