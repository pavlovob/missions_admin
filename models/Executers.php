<?php

namespace app\models;

use Yii;

class Executers extends \yii\db\ActiveRecord{
    public static function tableName()    {
        return 'executers';
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
          'name' => 'Исполнитель',
          'description' => 'Описание',
          'created' => 'Дата создания',
          'changed' => 'Дата изменения',
        ];
    }

    public function getUsers()    {
        return $this->hasMany(User::className(), ['executerid' => 'uid']);
    }

    public static function find()    {
        return new ExecutersQuery(get_called_class());
    }

    public static function dropdown($mode=null)  {
      if ($mode !== null){
          $executers = self::find()->select(['name', 'name'])->indexBy('name')->column();
      } else {
          $executers = self::find()->select(['name', 'uid'])->orderBy('name')->indexBy('uid')->column();
      }
      if (null !== $executers)    {
        return $executers;
        // return ['1'=>'test'];
      } else {
        throw new NotFoundHttpException('Ошибка запроса списка исполнителей!');
      }
    }
}
