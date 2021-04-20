<?php

namespace app\models;

use Yii;
class Inifile extends \yii\db\ActiveRecord
{
  public static function tableName()
  {
    return 'inifile';
  }


  public function rules()
  {
    return [
      [['section', 'param'], 'string', 'max' => 45],
      [['value','description'], 'string', 'max' => 250],
      [['section', 'param'], 'unique', 'targetAttribute' => ['section', 'param'], 'message' => 'Пара Секция-Параметр в файле настрек не кникальны!'],
    ];
  }

  public function attributeLabels()
  {
    return [
      'uid' => 'Код',
      'section' => 'Секция',
      'param' => 'Параметр',
      'value' => 'Значение',
      'description' => 'Описание',
      'visible'=>'Видимое',
    ];
  }

  public static function find()
  {
    return new InifileQuery(get_called_class());
  }
}
