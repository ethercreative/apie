<?php

namespace ethercreative\apie\api\controllers;

class ProfileController extends AuthenticatedController
{
    public $modelClass = 'ethercreative\apie\models\user\User';

    public function actions()
    {
        $actions = parent::actions();

        return [
            'index' => array_replace_recursive($actions['index'], [
                'prepareDataProvider' => [$this, 'prepareDataProvider'],
            ]),
            'update' => array_replace_recursive($actions['update'], [
                'class' => '\ethercreative\apie\api\controllers\actions\UpdateIdAction',
                'id' => \Yii::$app->user->id,
                'scenario' => 'update',
            ]),
            'options' => $actions['options'],
        ];
    }

    public function verbs()
    {
        return [
            'index' => ['GET', 'PUT', 'PATCH', 'POST', 'OPTIONS'],
        ];
    }

    public function prepareDataProvider()
    {
        return \Yii::$app->user->identity;
    }
}
