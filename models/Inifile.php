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

  public static function find()  {
    return new InifileQuery(get_called_class());
  }
  public static function checkIntegrity()  {
    $params = [
      ['section' =>'common',    'param' =>'orgname',            'description' =>'Наименование своей организации'     ,'visible'=>1],
      ['section' =>'committee', 'param' =>'s1f',                'description' =>'Ф.И.О. утверждающего поручения'     ,'visible'=>1],
      ['section' =>'committee', 'param' =>'s1p',                'description' =>'Должность утверждающего поручения'  ,'visible'=>1],
      ['section' =>'missions',  'param' =>'DefaultDescription', 'description' =>'Префикс заголовка поручений по умолчанию'      ,'visible'=>1],
      // ['section' =>'committee', 'param' =>'w1p',     'description' =>'Должность 1го согласующего акт ТО'   ,'visible'=>1],
      // ['section' =>'committee', 'param' =>'w2f',     'description' =>'Ф.И.О. 2го согласующего акт ТО'      ,'visible'=>1],
      // ['section' =>'committee', 'param' =>'w2p',     'description' =>'Должность 2го согласующего акт ТО'   ,'visible'=>1],
      //['section' =>'committee', 'param' =>'w3f', 'description' =>'Ф.И.О. исполнителя работ'      ,'visible'=>1],
      //['section' =>'committee', 'param' =>'w3p', 'description' =>'Должность исполнителя работ'   ,'visible'=>1],
      // ['section' =>'committee', 'param' =>'dsc', 'description' =>'Текст акта выполненных работ по ТО'     ,'visible'=>1],
      // ['section' =>'serviceact','param' =>'autonumber',  'description' =>'Автонумерация актов ТО (пусто - откл.)'   ,'visible'=>1],
      // ['section' =>'serviceact','param' =>'contract',    'description' =>'Номер и дата договора на ремонт' ,'visible'=>1],
      // ['section' =>'reports',   'param' =>'accountcharid',    'description' =>'Код характеристики бух.наименования ' ,'visible'=>1],
    ];

    foreach($params as $param)    {
      $ini = Inifile::findOne(['section'=>$param['section'],'param'=>$param['param']]);
      if (null == $ini)
      {
        $ini = new Inifile();
        $ini->section     = $param['section'];
        $ini->param       = $param['param'];
        $ini->description = $param['description'];
        $ini->visible     = $param['visible'];
        $ini->value       = '';
        $ini->save();
        History::log('Добавлена настройка ('.$ini->section.'/'.$ini->param.')');
        $ini->description   = $param['description'];
      } else {
        $ini->visible       = $param['visible'];
        $ini->save();
      }
    }
  }

  public static function getIni($section,$param){
    $retval = 'Значение не задано';
    if ((null !== $section) && (null !== $param)){
      $ini = Inifile::findOne(['section'=>$section,'param'=>$param]);
      if (null !== $ini){
        $retval = $ini->value;
      }
    }
    return $retval;
  }

  public static function putIni($section,$param,$value){
    $description = 'Внутренняя переменная ПО';
    $ini = Inifile::findOne(['section'=>$section,'param'=>$param]);
    if (null == $ini){
      $ini = new Inifile();
      $ini->section     = $section;
      $ini->param       = $param;
      $ini->value       = $value;
      $ini->description = $description;
      $ini->visible     = 0;
      $ini->save();
    } else {
      $ini->value       = $value;
      $ini->description = $description;
      $ini->visible     = 0;
      $ini->save();
    }
  }

}
