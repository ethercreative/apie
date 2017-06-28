<?php

namespace ethercreative\apie\traits;

trait AuthenticatedController
{
    public function behaviors()
    {
        return \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'class' => \yii\filters\auth\CompositeAuth::className(),
                'authMethods' => [
                    \yii\filters\auth\HttpBearerAuth::className(),
                    \yii\filters\auth\QueryParamAuth::className(),
                ],
            ],
        ]);
    }    
}
