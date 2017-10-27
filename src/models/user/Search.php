<?php

namespace ethercreative\apie\models\user;

class Search extends \ethercreative\apie\SearchModel
{
    public $modelClass = '\ethercreative\apie\models\user\User';

    public $attributes = [
        'id' => '=',
        'name' => 'ilike',
        'email' => 'ilike',
        'created_from' => '>=',
        'created_to' => '<=',
    ];
}
