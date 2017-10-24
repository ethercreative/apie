<?php

namespace ethercreative\apie\models\team;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class Search extends Model
{
    public
        $userClass = '\ethercreative\apie\models\team\Team',
        $id,
        $name,
        $created_from,
        $created_to;

    public function rules()
    {
        return [
            [['id', 'name', 'created_from', 'created_to'], 'safe'],
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
            ->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['>=', 'created_at', $this->created_from])
            ->andFilterWhere(['<=', 'created_at', $this->created_to]);

        return $dataProvider;
    }
}
