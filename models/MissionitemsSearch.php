<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Missionitems;

class MissionitemsSearch extends Missionitems {
      public function rules()
      {
          // return parent::rules();
          return [
              [['uid'], 'integer'],
                // [['uid','status','mission_name', 'approve_fio'], 'safe'],
              [['uid', 'missionuid', 'num_pp', 'deadline', 'assigneruid', 'assigner_name', 'executeruid', 'executer_name', 'task'], 'safe'],
          ];
      }


    public function scenarios()    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params,$missionid=null)    {
        $query = Missionitems::find()->where(['missionuid'=>$missionid]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['uid' => SORT_DESC,'uid'=>SORT_DESC]
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
            // 'status' => $this->status,
            // 'created' => $this->created,
            // 'changed' => $this->changed,
        ]);

        // $query->andFilterWhere(['like', 'mission_name', $this->mission_name])
        //     ->andFilterWhere(['like', 'approve_fio', $this->approve_fio]);

        return $dataProvider;
    }
}
