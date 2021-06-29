<?php

namespace app\models;

use Yii;

class Missions extends \yii\db\ActiveRecord {

  // public $approvepostfio  //Runtime property in gridview

  public static function tableName()    {
    return 'missions';
  }

  public function rules()    {
    return [
        [['mission_name', 'mission_date', 'approve_post', 'approve_fio'], 'required'],
        [['mission_date', 'created', 'changed'], 'safe'],
        [['status'], 'integer'],
        [['mission_name'], 'string', 'max' => 256],
        [['description', 'approve_post', 'approve_fio'], 'string', 'max' => 100],
        [['url'], 'string', 'max' => 2048],
        [['mission_name'], 'unique'],
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

  public function getMissionitems()    {
    return $this->hasMany(Missionitems::className(), ['missionuid' => 'uid']);
  }

  public static function find()  {
      return new MissionsQuery(get_called_class());
  }

  //формирует массив сотсояний поручений
  public static function statesDropdown(){
    return [
      STATE_OPEN    =>'Открыто',
      STATE_CLOSE   =>'Закрыто',
      // STATE_DELETED =>'Удалено',
    ];
  }

  //возвращает наименование состояния поручения из массива по ИД
  public static function stateName($id){
    $arr  = self::statesDropdown();
    return (array_key_exists($id,$arr)) ? $arr[$id] : '';
  }

  //Простой массив наименований состояния
  public static function stateNames(){
    $arr = array("Открыто","Закрыто");
    return $arr;
  }

  //Возвращает текущее состояние поручений
  public static function getMissionstate($id){
      return self::findOne($id)->status;
  }

  // public static function monthName($month){
  //   switch ($month) {
  //     case 1:
  //     return 'январь';
  //     break;
  //     case 2:
  //     return  'февраль';
  //     break;
  //     case 3:
  //     return 'март';
  //     break;
  //     case 4:
  //     return  'апрель';
  //     break;
  //     case 5:
  //     return  'май';
  //     break;
  //     case 6:
  //     return  'июнь';
  //     break;  // public static function monthsDropdown(){
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
  //     12=>'декабрь'
  //   ];
  //   return $arr;
  // }
  //     case 7:
  //     return  'июль';
  //     break;
  //     case 8:
  //     return  'август';
  //     break;
  //     case 9:
  //     return  'сентябрь';
  //     break;
  //     case 10:
  //     return  'октябрь';
  //     break;
  //     case 11:
  //     return 'ноябрь';
  //     break;
  //     case 12:
  //     return  'декабрь';
  //     break;
  //   }
  // }

  // public static function monthsDropdown(){
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
  //     12=>'декабрь'
  //   ];
  //   return $arr;
  // }

}
