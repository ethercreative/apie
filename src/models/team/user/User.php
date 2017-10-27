<?php

namespace ethercreative\apie\models\team\user;

use Yii;

class User extends \ethercreative\apie\ActiveRecord
{
    protected $_parentColumn = 'team_id';

    public static function tableName()
    {
        return '{{%team_user}}';
    }

    public function rules()
    {
        return [
            [['team_id', 'user_id'], 'required'],
            ['team_id', 'exist', 'targetClass' => 'ethercreative\apie\models\team\Team', 'targetAttribute' => 'id', 'message' => 'Team does not exist.'],
            ['user_id', 'exist', 'targetClass' => 'ethercreative\apie\models\user\User', 'targetAttribute' => 'id', 'message' => 'User does not exist.'],
            ['role', 'safe'],
            [['team_id', 'user_id'], 'unique', 'targetAttribute' => ['team_id', 'user_id'], 'message' => 'User is already on that team.'],
        ];
    }

    public function getTeam()
    {
        return $this->hasOne(\ethercreative\apie\models\team\Team::className(), ['id' => 'team_id']);
    }

    public function getUser()
    {
        return $this->hasOne(\ethercreative\apie\models\user\User::className(), ['id' => 'user_id']);
    }
}
