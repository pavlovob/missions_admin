<?php

namespace app\models;

use Yii;

class Missions extends \yii\db\ActiveRecord {

  public static function tableName()    {
    return 'missions';
  }

  public function rules()    {
    return [
      [['mission_name','mission_date','status','approve_post', 'approve_fio'], 'required'],
      // [['mission_date', 'status'], 'integer'],
      [[ 'status'], 'integer'],
      [['created', 'changed'], 'safe'],
      [['description', 'approve_post', 'approve_fio'], 'string', 'max' => 100],
      [['mission_name'], 'string', 'max' => 256],
      [['url'], 'string', 'max' => 2048],
    ];
  }

  public function attributeLabels()    {
    return [
      'uid' => 'Код',
      'mission_name' => 'Наименование',
      'mission_date' => 'Дата создания',
      'description' => 'Описание',
      'status' => 'Состояние',
      'approve_post' => 'Должность утверждающего',
      'approve_fio' => 'Ф.И.О. утверждающего',
      'url' => 'URL Ссылка',
      'created' => 'Дата создания',
      'changed' => 'Дата изменения',
    ];
  }
  // public static function monthsDropdown() {
  //   $arr = [
  //     1=>'январь',
  //     2=>'февраль',
  //     3=>'март',
  //     4=>'апрель',
  //     5=>'май',
  //     6=>'июнь',
  //     7=>'июль',
  //     8=>'август',
  //     9=>'сентябрь',
  //     10=>'октябрь',
  //     11=>'ноябрь',
  //     12=>'декабрь',
  //   ];
  //   return $arr;
  // }

  public function getMissionitems()    {
    return $this->hasMany(Missionitems::className(), ['missionuid' => 'uid']);
  }

  public static function monthsDropdown(){
    $arr = [
      1=>'январь',
      2=>'февраль',
      3=>'март',
      4=>'апрель',
      5=>'май',
      6=>'июнь',
      7=>'июль',
      8=>'август',
      9=>'сентябрь',
      10=>'октябрь',
      11=>'ноябрь',
      12=>'декабрь'
    ];
    return $arr;
  }

  public static function statesDropdown(){
    $arr = [
      STATE_OPEN    =>'Открыто',
      STATE_CLOSE   =>'Закрыто',
      STATE_DELETED =>'Удалено',
    ];
    return $arr;
  }

  public static function stateNames(){
    $arr = array("Открыто","Закрыто","Удалено");
    return $arr;
  }

  public static function monthName($month){
    switch ($month) {
      case 1:
      return 'январь';
      break;
      case 2:
      return  'февраль';
      break;
      case 3:
      return 'март';
      break;
      case 4:
      return  'апрель';
      break;
      case 5:
      return  'май';
      break;
      case 6:
      return  'июнь';
      break;
      case 7:
      return  'июль';
      break;
      case 8:
      return  'август';
      break;
      case 9:
      return  'сентябрь';
      break;
      case 10:
      return  'октябрь';
      break;
      case 11:
      return 'ноябрь';
      break;
      case 12:
      return  'декабрь';
      break;
    }
  }
}
