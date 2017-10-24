<?php

namespace ethercreative\apie\models\team;

use Yii;

class Team extends \ethercreative\apie\ActiveRecord
{
    public static function tableName()
    {
        return 'team';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
        ];
    }
}
