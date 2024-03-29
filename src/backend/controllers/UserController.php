<?php

namespace ethercreative\apie\backend\controllers;

class UserController extends CrudController
{
    public
        $name = 'User',
        $modelClass = '\ethercreative\apie\models\user\User',
        $searchClass = '\ethercreative\apie\models\user\Search',
        $columns = [
            'id:integer',
            'name',
            'email:email',
            [
                'class' => 'ethercreative\apie\grid\DateRangeColumn',
                'attribute' => 'created_at',
                'format' => 'datetime',
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
            'email' => ['type' => 'input.email', 'options' => ['max-length' => 128]],
            'password' => ['type' => 'passwordInput', 'options' => [], 'hint' => 'Only enter to change password.'],
        ];
}
