<?php

namespace app\models;

use Yii;

class History extends \yii\db\ActiveRecord
{
  public static function tableName()
  {
    return 'history';
  }

  public function rules()
  {
    return [
      //  [['ACTIONDATE', 'ACTIONTIME'], 'integer'],
      //  [['FILECONTENT'], 'string'],
      [['ACTIONDATETIME'], 'safe'],
      [['DESCRIPTION', 'RECORDCONTENT'], 'string', 'max' => 512],
      //  [['DESCRIPTION'], 'string', 'max' => 255],
    ];
  }

  public function attributeLabels()
  {
    return [
      'UID' => 'Код',
      'DESCRIPTION' => 'Событие',
      'USERNAME' => 'Пользователь',
      'ACTIONDATETIME' => 'Дата',
      'RECORDCONTENT' => 'Содержимое',
    ];
  }

  public static function find()
  {
    return new HistoryQuery(get_called_class());
  }

  //custom business logic
  public static function log($message, $content=NULL){
    if ($message!==null) {
      $model = new History();
      if (null !== Yii::$app->user->identity){
        $model->USERNAME = Yii::$app->user->identity->login;
      } else {
        $model->USERNAME = 'Система';
      }

      if (STRLEN($message) > 255){
        $model->DESCRIPTION = SUBSTR($message,1,255);
      } else {
        $model->DESCRIPTION = $message;
      }

      if ($content !== NULL && STRLEN($content) > 1024){
        $model->RECORDCONTENT = SUBSTR($content,1,1024);
      } else {
        $model->RECORDCONTENT = $content;
      }
      $model->ACTIONDATETIME = date('Y-m-d G:i:s', time());
      $model->save();

      // //MAIL!!!!
      // Yii::$app->mailer->compose()
      // ->setTo(\Yii::$app->params['subscribers'])
      // ->setFrom('scanyrnu@yrnu.spb.transneft.ru')
      // ->setSubject('Событие в учете ИТ активов')
      // ->setTextBody($message.':\r\n '.$content)
      // ->send();

    }
  }

}
