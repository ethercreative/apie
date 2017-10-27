<?php

namespace ethercreative\apie\api\controllers\actions;

class IndexWithAction extends \yii\rest\IndexAction
{
    public $with = [];

    protected function prepareDataProvider()
    {
        $dataProvider = parent::prepareDataProvider();

        if ($this->with)
            $dataProvider->query->with($this->with);

        return $dataProvider;
    }
}
