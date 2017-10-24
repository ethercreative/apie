<?php

namespace ethercreative\apie\backend\controllers;

use Yii;
use yii\helpers\Inflector;
use yii\helpers\ArrayHelper;

class Controller extends \yii\web\Controller
{
    use \ethercreative\apie\traits\FindModel;
    use \ethercreative\apie\traits\Breadcrumbs;
    use \ethercreative\apie\traits\CustomViewPath;

    public $name, $subNav, $tabs = [];
    
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => 'yii\filters\AccessControl',
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ]
        ];

        return $behaviors;
    }

    public function getTab($tab)
    {
        $tab = ArrayHelper::getValue($this->tabs, $tab);

        if (is_string($tab))
            $tab = $this->getTab($tab);

        return $tab;
    }
}
