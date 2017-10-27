<?php

namespace ethercreative\apie\models\team\user;

class Search extends \ethercreative\apie\SearchModel
{
    protected $_parentColumn = 'team_id';
    
    public $modelClass = '\ethercreative\apie\models\team\user\User';

    public $attributes = [
        'id' => '=',
        'team_id' => '=',
        'user_id' => '=',
        'created_from' => '>=',
        'created_to' => '<=',
    ];
}
