<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

class UserSearch extends User{

    public $assignername;


    public function rules()    {
      return parent::rules();
    }

      public function scenarios()    {
        return Model::scenarios();
    }

    public function search($params)    {
        $query = User::find();
        $query->joinWith(['assigner']);
        $query->joinWith(['executer']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            // 'key' => $this->tableName() . '.uid',
        ]);
        // $dataProvider->sort->attributes['assigner'] =   [
        //         'asc' => ['assigner.name' => SORT_ASC],
        //         'desc' => ['assigner.name' => SORT_DESC],
        //     ];
        // $dataProvider->sort->attributes['executer'] =   [
        //         'asc' => ['executer.name' => SORT_ASC],
        //         'desc' => ['executer.name' => SORT_DESC],
        //     ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([$this->tableName() .'.uid' => $this->uid])
            ->andFilterWhere(['like', 'login', $this->login])
            ->andFilterWhere(['usertype' => $this->usertype])
            ->andFilterWhere(['assignerid' => $this->assignerid])
            ->andFilterWhere(['executerid' => $this->executerid])
            ->andFilterWhere(['like', 'username', $this->username]);

        return $dataProvider;
    }
}
