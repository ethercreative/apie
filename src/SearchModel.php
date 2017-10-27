<?php

namespace ethercreative\apie;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class SearchModel extends Model
{
    use \ethercreative\apie\traits\ParentColumn;

    public
        $modelClass;

    public $attributes = [
        'id' => '=',
        'created_from' => '>=',
        'created_to' => '<=',
    ];

    public $_values = [];

    public function __get($key)
    {
        if (array_key_exists($key, $this->attributes))
            return ArrayHelper::getValue($this->_values, $key);

        return parent::__get($key);
    }

    public function rules()
    {
        return [
            [array_keys($this->attributes), 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ($this->modelClass)::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        foreach ($params as $key => $value)
            $this->{$key} = $value;

        if (!$this->validate()) {
            return $dataProvider;
        }

        foreach ($this->attributes as $key => $type)
        {
            switch ($type)
            {
                case '=':
                    $query->andFilterWhere([$key => ArrayHelper::getValue($this->_values, $key)]);
                    break;

                default:
                    $query->andFilterWhere([$type, $key, ArrayHelper::getValue($this->_values, $key)]);
                    break;
            }
        }

        return $dataProvider;
    }
}
