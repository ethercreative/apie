<?php

namespace ethercreative\apie\models\user;

class Register extends \yii\base\Model
{
    public $modelClass = '\ethercreative\apie\models\user\User';

    public $name,
           $email,
           $password;

    private $user,
            $tokens;

    public function rules()
    {
        return [
            [['name', 'email', 'password'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => $this->modelClass],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function save()
    {
        if (!$this->validate())
            return false;

        $this->user = new $this->modelClass;
        $this->user->attributes = $this->attributes;
        
        if (!$this->user->save())
            return false;

        $this->tokens = $this->user->generateApiTokens();

        return true;
    }

    public function getPrimaryKey()
    {
        return [$this->user->id];
    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        return [
            'tokens' => $this->tokens,
            'user' => $this->user->toArray($fields, $expand, $recursive),
        ];
    }
}
