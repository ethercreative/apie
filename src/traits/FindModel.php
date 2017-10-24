<?php

namespace ethercreative\apie\traits;

use yii\web\NotFoundHttpException;

trait FindModel
{
    public $modelClass;

    public function findModel($search, $options = [])
    {
        if (is_numeric($search))
            $search = ['id' => (int) $search];

        if (!empty($options['modelClass']))
            $modelClass = $options['modelClass'];
        else
            $modelClass = $this->modelClass;

        $model = $modelClass::find()->andWhere($search)->one();

        if (!$model)
            throw new NotFoundHttpException(!empty($options['message']) ? $options['message'] : 'Entity not found.');

        return $model;
    }
}
