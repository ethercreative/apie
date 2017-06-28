<?php

namespace ethercreative\apie\controllers\api;

class ProfileController extends AuthenticatedController
{
    public $modelClass = 'ethercreative\apie\models\user\User';

    public function actions()
    {
        return \yii\helpers\ArrayHelper::merge(parent::actions(), [
            'index' => [
                'prepareDataProvider' => [$this, 'prepareDataProvider'],
            ],
        ]);
    }

    public function prepareDataProvider()
    {
        return \Yii::$app->user->identity;
    }
}
