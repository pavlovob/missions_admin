<?php

namespace app\models;

use Yii;

class Assigners extends \yii\db\ActiveRecord {
    public static function tableName()    {
        return 'assigners';
    }

    public function rules()    {
        return [
            [['name','ordernumber'], 'required'],
            [['created', 'changed'], 'safe'],
            [['name', 'description'], 'string', 'max' => 100],
            [['name','ordernumber'], 'unique'],
        ];
    }

    public function attributeLabels()    {
        return [
            'uid' => 'Код',
            'name' => 'Наименование',
            'ordernumber' => 'Номер раздела',
            'description' => 'Описание',
            'created' => 'Дата создания',
            'changed' => 'Дата изменения',
        ];
    }

    public function getUsers()    {
        return $this->hasMany(User::className(), ['assignerid' => 'uid']);
    }

    public function getMissionitems()    {
        return $this->hasMany(Missionitems::className(), ['assignerid' => 'uid']);
    }

    public static function find()    {
        return new AssignersQuery(get_called_class());
    }

    public static function dropdown()  {
      $assigners = self::find()->select(['name', 'uid'])->orderBy('name')->indexBy('uid')->column();
      return $assigners;
    }

}
