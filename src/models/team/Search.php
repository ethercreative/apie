<?php

namespace ethercreative\apie\models\team;

class Search extends \ethercreative\apie\SearchModel
{
    public $modelClass = '\ethercreative\apie\models\team\Team';

    public $attributes = [
        'id' => '=',
        'name' => 'ilike',
        'slug' => 'ilike',
        'created_from' => '>=',
        'created_to' => '<=',
    ];
}
