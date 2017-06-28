<?php

namespace ethercreative\apie\models\user;

class Login extends \yii\base\Model
{
    public $email,
           $password,
           $player_id,
           $refresh_token;

    private $user,
            $tokens;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['email', 'exist', 'targetClass' => '\ethercreative\apie\models\user\User', 'message' => 'Email or password incorrect.'],
            [['email', 'password'], 'checkCredentials'],
        ];
    }

    public function checkCredentials()
    {
        if ($this->email && $this->password)
        {
            if ($this->user = User::find()->where(['email' => $this->email])->one())
            {
                if ($this->user->validatePassword($this->password))
                {
                    return true;
                }
            }

            $this->addError('password', 'Email or password incorrect.');
        }

        return false;
    }

    public function save()
    {
        if (!$this->validate())
            return false;

        return $this->generateToken();
    }

    private function generateToken()
    {
        $this->tokens = $this->user->generateApiTokens();

        return !empty($this->tokens);
    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        return [
            'tokens' => $this->tokens,
            'user' => $this->user->toArray($fields, $expand, $recursive),
        ];
    }

    public function getPrimaryKey()
    {
        return [$this->user->id];
    }
}
