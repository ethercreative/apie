<?php

namespace ethercreative\apie\backend\controllers;

class TeamController extends CrudController
{
    public
        $name = 'Team',
        $modelClass = '\ethercreative\apie\models\team\Team',
        $searchClass = '\ethercreative\apie\models\team\Search',
        $columns = [
            'id:integer',
            'name',
            'slug',
            [
                'class' => 'ethercreative\apie\grid\DateRangeColumn',
                'attribute' => 'created_at',
                'from' => 'created_from',
                'to' => 'created_to',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
        $fields = [
            'name' => ['type' => 'textInput', 'options' => ['min-length' => 3, 'max-length' => 64]],
            'slug' => ['type' => 'textInput', 'options' => ['min-length' => 3, 'max-length' => 64]],
        ],
        $tabs = [
            'update' => [
                ['label' => 'Profile'],
                ['label' => 'Users', 'url' => ['team/{{id}}/user']],
            ]
        ];
}
