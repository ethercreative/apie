<?php

namespace ethercreative\apie\behaviors;

class Token extends \yii\base\Behavior
{
    public $token_length = 32, $token_life = '5 minutes';

    public function events()
    {
        return [
            \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
        ];
    }

    public function beforeInsert($event)
    {
        $this->owner->token = \Yii::$app->security->generateRandomString($this->token_length);
        $this->owner->expire_at = date('r', strtotime('+' . $this->token_life));
    }
}
