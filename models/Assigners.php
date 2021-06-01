<?php

namespace app\models;

use Yii;

class Assigners extends \yii\db\ActiveRecord {
    public static function tableName()    {
        return 'assigners';
    }

    public function rules()    {
        return [
            [['name'], 'required'],
            [['created', 'changed'], 'safe'],
            [['name', 'description'], 'string', 'max' => 100],
            [['name'], 'unique'],
        ];
    }

    public function attributeLabels()    {
        return [
            'uid' => 'Код',
            'name' => 'Наименование',
            'description' => 'Описание',
            'created' => 'Дата создания',
            'changed' => 'Дата изменения',
        ];
    }

    public function getUsers()    {
        return $this->hasMany(User::className(), ['assignerid' => 'uid']);
    }

    public static function find()    {
        return new AssignersQuery(get_called_class());
    }

    public static function dropdown()  {
      $assigners = self::find()->select(['name', 'uid'])->orderBy('name')->indexBy('uid')->column();
      return $assigners;
    }

}
