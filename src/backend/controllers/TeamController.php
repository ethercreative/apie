<?php

namespace ethercreative\apie\backend\controllers;

class TeamController extends \ethercreative\apie\backend\controllers\CrudController
{
    public
        $name = 'Team',
        $modelClass = '\ethercreative\apie\models\team\Team',
        $searchClass = '\ethercreative\apie\models\team\Search',
        $columns = [
            'id:integer',
            'name',
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
        ],
        $tabs = [
            'update' => [
                ['label' => 'Profile', 'url' => ['']],
                ['label' => 'Users'],
            ]
        ];
}
