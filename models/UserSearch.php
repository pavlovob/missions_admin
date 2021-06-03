<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

class UserSearch extends User{
    public function rules()    {
        return Parent::rules();
    }

    public function scenarios()    {
        // bypass scenarios() implementation in the parent class
        return Parent::scenarios();
    }

    public function search($params)    {
        $query = User::find();
        $query->joinWith(['Assigners','Executers']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['assigner'] =   [
                'asc' => ['assigner.name' => SORT_ASC],
                'desc' => ['assigner.name' => SORT_DESC],
            ];
        $dataProvider->sort->attributes['executer'] =   [
                'asc' => ['executer.name' => SORT_ASC],
                'desc' => ['executer.name' => SORT_DESC],
            ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'login', $this->login])
            ->andFilterWhere(['like', 'assigner.name', $this->assigner])
            ->andFilterWhere(['like', 'executer.name', $this->executer])            ;

        return $dataProvider;
    }
}
