<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Missionitems;
use app\models\User;

class MissionitemsSearch extends Missionitems {
      public function rules()      {
          // return Parent::rules();
          return [
              [['uid','assigneruid','executeruid'], 'integer'],
                // [['uid','status','mission_name', 'approve_fio'], 'safe'],
              [['uid', 'missionuid', 'status', 'num_pp', 'deadline', 'assigneruid', 'assigner_name', 'executeruid', 'executer_name', 'task'], 'safe'],
              // [['executeruid'], 'exist', 'skipOnError' => true, 'targetClass' => Executers::className(), 'targetAttribute' => ['executeruid' => 'uid']],
              // [['assigneruid'], 'exist', 'skipOnError' => true, 'targetClass' => Assigners::className(), 'targetAttribute' => ['assigneruid' => 'uid']],
          ];
      }


    public function scenarios()    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params,$missionid=null,$usertype=null)    {
        $query = Missionitems::find();
        $query->andWhere(['missionuid'=>$missionid]);  //запрос по текущему ИД поручений
        //доп.условие если это куратор - только свой ИД
        if (Yii::$app->user->identity->usertype == USERTYPE_ASSIGNER){
            $query->andWhere(['assigneruid'=>Yii::$app->user->identity->assignerid]);
            // $query->join('LEFT JOIN', 'executers', 'executers.uid = executeruid'); //для подгрузки исполнителей
        }
        //доп.условие если это исполнитель - только свой ИД
        if (Yii::$app->user->identity->usertype == USERTYPE_EXECUTER){
            $query->andWhere(['executeruid'=>Yii::$app->user->identity->executerid]);
            // $query->join('LEFT JOIN', 'assigners', 'assigners.uid = assigneruid'); //для подгрузки кураторов
        }
        $query->joinWith(['assigner']);
        $query->joinWith(['executer']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  => false,
            // 'sort' => [
            //     'defaultOrder' => ['uid' => SORT_ASC],
            //     'attributes'  => [],
            // ]
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
            'status'  => $this->status,
            'num_pp' => $this->num_pp,
            // 'assigneruid' => $this->assigneruid,
            // 'executeruid' => $this->executeruid,
            // 'mission_date' => $this->mission_month,
            // 'mission_year' => $this->mission_year,
            // 'status' => $this->status,
            // 'created' => $this->created,
            // 'changed' => $this->changed,
        ]);

        $query->andFilterWhere(['assigneruid' => $this->assigneruid])
        ->andFilterWhere(['executeruid' => $this->executeruid]);

        $query->andFilterWhere(['like', 'task', $this->task])
              ->andFilterWhere(['like', 'deadline', $this->deadline])
              ->andFilterWhere(['like', 'executer_name', $this->executer_name])
              ->andFilterWhere(['like', 'assigner_name', $this->assigner_name]);

        return $dataProvider;
    }
}
