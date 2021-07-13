<?php

namespace app\models;

use Yii;

class Missionitems extends \yii\db\ActiveRecord {
    public $executeruids; //для хранения массива ИД исполнителей для множественного добавления
    public static function tableName()    {
        return 'missionitems';
    }

    public function attributeLabels()    {
        return [
            'uid' => 'Код',
            'missionuid' => 'Код поручений',
            'status'      => 'Статус',
            'num_pp' => '№ п.п',
            'deadline' => 'Срок исполнения',
            'assigneruid' => 'Куратор',
            'assigner_name' => 'Контроль',
            'executeruid' => 'Исполнитель',
            'executeruids' => 'Исполнители',
            'executer_name' => 'Ответственный',
            'task' => 'Поручение',
            'report' => 'Отчет о выполнении',
            'created' => 'Дата создания',
            'changed' => 'Дата изменения',
        ];
    }

    public function rules()    {
        return [
            [['uid'], 'unique'],
            [['num_pp', 'deadline', 'assigner_name', 'executer_name', 'task'], 'required'],
            [['missionuid','assigneruid','status'], 'safe'],
            [['executeruids'], 'required','on'=>'insert'],
            [['executeruid'], 'required','on'=>'update'],
            [['uid', 'status', 'num_pp','missionuid', 'assigneruid', 'executeruid'], 'integer'],

            // [['num_pp'], 'string', 'max' => 10],
            [['assigner_name', 'executer_name'], 'string', 'max' => 45],
            [['deadline'], 'string', 'max' => 100],
            [['task', 'report'], 'string', 'max' => 2048],
            [['missionuid'], 'exist', 'skipOnError' => true, 'targetClass' => Missions::className(), 'targetAttribute' => ['missionuid' => 'uid']],
            [['executeruid'], 'exist', 'skipOnError' => true, 'targetClass' => Executers::className(), 'targetAttribute' => ['executeruid' => 'uid']],
            [['assigneruid'], 'exist', 'skipOnError' => true, 'targetClass' => Assigners::className(), 'targetAttribute' => ['assigneruid' => 'uid']],

        ];
    }

    public function getMission()    {
        return $this->hasOne(Missions::className(), ['uid' => 'missionuid']);
    }

    public function getExecuter()    {
        return $this->hasOne(Executers::className(), ['uid' => 'executeruid']);
    }
    public function getAssigner()    {
        return $this->hasOne(Assigners::className(), ['uid' => 'assigneruid']);
    }
    public static function find()    {
        return new MissionitemsQuery(get_called_class());
    }

    //формирует массив сотсояний
    public static function statesDropdown(){
      return [
        STATE_INWORK  =>'В работе',
        STATE_DONE    =>'Выполнен',
      ];
    }
    //возвращает наименование состояния поручения из массива по ИД
    public static function stateName($id){
      $arr  = self::statesDropdown();
      return (array_key_exists($id,$arr)) ? $arr[$id] : '';
    }
    //Возвращает текущее состояние поручений
    public static function getState($id){
        return self::findOne($id)->status;
    }
}
