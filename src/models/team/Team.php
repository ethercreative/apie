<?php

namespace ethercreative\apie\models\team;

use Yii;

class Team extends \ethercreative\apie\ActiveRecord
{
    const SLUG_BLACKLIST = [
        'admin',
        'adminer',
        'backend',
        'download',
        'global',
        'healthcheck',
        'pma',
        'redirect',
        'status',
        'superadmin',
        'support',
    ];

    public static function tableName()
    {
        return '{{%team}}';
    }

    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            ['slug', 'in', 'range' => static::SLUG_BLACKLIST, 'not' => true, 'message' => 'Reserved value. Please choose another.'],
            ['slug', 'match', 'pattern' => '/^([a-z0-9\-\_]+)$/'],
        ];
    }
}
