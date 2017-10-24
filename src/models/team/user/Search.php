<?php

namespace ethercreative\apie\models\team\user;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class Search extends Model
{
    public
        $userClass = '\ethercreative\apie\models\team\user\User',
        $id,
        $team_id,
        $user_id,
        $created_from,
        $created_to;

    public function rules()
    {
        return [
            [['id', 'team_id', 'user_id', 'created_from', 'created_to'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ($this->userClass)::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['team_id' => $this->team_id])
            ->andFilterWhere(['user_id' => $this->user_id])
            ->andFilterWhere(['>=', 'created_at', $this->created_from])
            ->andFilterWhere(['<=', 'created_at', $this->created_to]);

        return $dataProvider;
    }
}
