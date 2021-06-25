<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Missionitems;
use app\models\User;

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

    public function search($params,$missionid=null,$usertype=null)    {
        //запрос по текущему ИД поручений
        $query = Missionitems::find()->where(['missionuid'=>$missionid]);
        //доп.условие если это куратор - только свой ИД
        if (Yii::$app->user->identity->usertype == USERTYPE_ASSIGNER){
            $query->andWhere(['assigneruid'=>Yii::$app->user->identity->assignerid]);
            $query->join('LEFT JOIN', 'executers', 'executers.uid = executeruid'); //для подгрузки исполнителей
        }
        //доп.условие если это исполнитель - только свой ИД
        if (Yii::$app->user->identity->usertype == USERTYPE_EXECUTER){
            $query->andWhere(['executeruid'=>Yii::$app->user->identity->executerid]);
            $query->join('LEFT JOIN', 'assigners', 'assigners.uid = assigneruid'); //для подгрузки кураторов

        }
        $query->andWhere(['assigneruid'=>Yii::$app->user->identity->assignerid]);
        $query->join('LEFT JOIN', 'executers1', 'executers.uid = executeruid'); //для подгрузки исполнителей
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['num_pp' => SORT_ASC]
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
            'num_pp' => $this->num_pp,
            'executers.name'=> ($this->executer !== null) ? $this->executer->name : "",
            // 'mission_date' => $this->mission_month,
            // 'mission_year' => $this->mission_year,
            // 'status' => $this->status,
            // 'created' => $this->created,
            // 'changed' => $this->changed,
        ]);

        $query->andFilterWhere(['like', 'task', $this->task])
              ->andFilterWhere(['like', 'deadline', $this->deadline]);

        return $dataProvider;
    }
}
