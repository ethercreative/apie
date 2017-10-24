<?php

namespace ethercreative\apie\backend\controllers;

class UserController extends \ethercreative\apie\backend\controllers\CrudController
{
    public
        $name = 'Team',
        $modelClass = '\ethercreative\apie\models\team\user\User',
        $searchClass = '\ethercreative\apie\models\team\user\Search',
        $columns = [
            'id:integer',
            'team_id',
            'team.name',
            [
                'class' => 'ethercreative\apie\grid\DateRangeColumn',
                'attribute' => 'created_at',
                'from' => 'created_from',
                'to' => 'created_to',
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
        $fields = [
            'name' => ['type' => 'textInput', 'options' => ['min-length' => 3, 'max-length' => 64]],
        ];
}
