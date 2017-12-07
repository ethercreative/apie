<?php

namespace ethercreative\apie\models\user;

use Yii;

class User extends \ethercreative\apie\ActiveRecord implements \yii\web\IdentityInterface
{
    use \ethercreative\apie\traits\UserTrait;
}
