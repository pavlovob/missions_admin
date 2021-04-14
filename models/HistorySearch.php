<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\History;

class HistorySearch extends History
{
    public function rules()
    {
        return Parent::rules();
    }
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    public function search($params)
    {
        $query = History::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'UID' => $this->UID,
            // 'ACTIONDATE' => $this->ACTIONDATE,
            // 'ACTIONTIME' => $this->ACTIONTIME,
            'ACTIONDATETIME' => $this->ACTIONDATETIME,
        ]);

        $query->andFilterWhere(['like', 'DESCRIPTION', $this->DESCRIPTION])
            ->andFilterWhere(['like', 'USERNAME', $this->USERNAME]);

        $query->orderBy('UID DESC'); //убрать если сортировка мешает другим видам

        return $dataProvider;
    }
}
