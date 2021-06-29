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
            'num_pp' => '№ п.п',
            'deadline' => 'Срок исполнения',
            'assigneruid' => 'Куратор',
            'assigner_name' => 'Контроль',
            'executeruid' => 'Исполнитель',
            'executeruids' => 'Исполнители',
            'executer_name' => 'Ответственный',
            'task' => 'Поручение',
            'description' => 'Примечание',
            'date_created' => 'Дата создания',
            'date_changed' => 'Дата изменения',
        ];
    }

    public function rules()    {
        return [
            [['uid'], 'unique'],
            [['uid', 'missionuid', 'num_pp', 'deadline', 'assigneruid', 'assigner_name', 'executeruid', 'executer_name', 'task'], 'required'],
            [['executeruids'], 'required','on'=>'insert'],
            [['uid', 'num_pp','missionuid', 'assigneruid', 'executeruid'], 'integer'],
            [['date_created', 'date_changed'], 'safe'],
            // [['num_pp'], 'string', 'max' => 10],
            [['assigner_name', 'executer_name'], 'string', 'max' => 45],
            [['deadline'], 'string', 'max' => 100],
            [['task', 'description'], 'string', 'max' => 2048],
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
    public static function find()
    {
        return new MissionitemsQuery(get_called_class());
    }
}
