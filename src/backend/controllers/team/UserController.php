<?php

namespace ethercreative\apie\backend\controllers\team;

class UserController extends \ethercreative\apie\backend\controllers\CrudController
{
    public
        $name = 'Team User',
        $modelClass = '\ethercreative\apie\models\team\user\User',
        $searchClass = '\ethercreative\apie\models\team\user\Search',
        $columns = [
            'id:integer',
            'user.name',
            'role',
            'team_id',
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
            'user_id' => ['type' => 'textInput', 'options' => ['min-length' => 3, 'max-length' => 64]],
            'role' => ['type' => 'textInput', 'options' => ['min-length' => 3, 'max-length' => 64]],
        ],
        $tabs = [
            'index' => [
                ['label' => 'Profile', 'url' => ['team/{{team_id}}']],
                ['label' => 'Users', 'active' => true],
            ],
        ];
}
