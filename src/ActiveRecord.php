<?php

namespace ethercreative\apie;

class ActiveRecord extends \yii\db\ActiveRecord
{
    use \ethercreative\apie\traits\ParentColumn;

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }
}
