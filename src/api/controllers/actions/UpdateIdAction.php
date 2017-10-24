<?php

namespace ethercreative\apie\api\controllers\actions;

class UpdateIdAction extends \yii\rest\UpdateAction
{
    public $id;

    public function run($id = null)
    {
        return parent::run($this->id);
    }
}
