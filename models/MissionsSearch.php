<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Missions;

/**
 * MissionsSearch represents the model behind the search form of `app\models\Missions`.
 */
class MissionsSearch extends Missions {
      public function rules()
      {
          return [
              [['uid'], 'integer'],
              [['uid','status','mission_name', 'approve_fio'], 'safe'],
          ];
      }


    public function scenarios()    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)    {
        $query = Missions::find()->orderBy('mission_date DESC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['mission_date' => SORT_DESC]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'uid' => $this->uid,
            // 'mission_date' => $this->mission_month,
            // 'mission_year' => $this->mission_year,
            'status' => $this->status,
            'created' => $this->created,
            'changed' => $this->changed,
        ]);

        $query->andFilterWhere(['like', 'mission_name', $this->mission_name])
            ->andFilterWhere(['like', 'approve_fio', $this->approve_fio]);

        return $dataProvider;
    }
}
