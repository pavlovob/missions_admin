<?php

namespace app\models;

use Yii;

class Missionitems extends \yii\db\ActiveRecord {
    public static function tableName()
    {
        return 'missionitems';
    }

    public function rules()
    {
        return [
            [['uid'], 'unique'],
            [['uid', 'missionuid', 'num_pp', 'deadline', 'assigneruid', 'assigner_name', 'executeruid', 'executer_name', 'task'], 'required'],
            [['uid', 'missionuid', 'assigneruid', 'executeruid'], 'integer'],
            [['date_created', 'date_changed'], 'safe'],
            [['num_pp'], 'string', 'max' => 10],
            [['assigner_name', 'executer_name'], 'string', 'max' => 45],
            [['deadline'], 'string', 'max' => 100],
            [['task', 'description'], 'string', 'max' => 1000],
            [['missionuid'], 'exist', 'skipOnError' => true, 'targetClass' => Missions::className(), 'targetAttribute' => ['missionuid' => 'uid']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'uid' => 'Код',
            'missionuid' => 'Код поручений',
            'num_pp' => '№ п.п',
            'deadline' => 'Срок исполнения',
            'assigneruid' => 'Куратор',
            'assigner_name' => 'Ф.И.О.',
            'executeruid' => 'Исполнитель',
            'executer_name' => 'Ответственный',
            'task' => 'Поручение',
            'description' => 'Примечание',
            'date_created' => 'Дата создания',
            'date_changed' => 'Дата изменения',
        ];
    }

    public function getMission()
    {
        return $this->hasOne(Missions::className(), ['uid' => 'missionuid']);
    }

    public static function find()
    {
        return new MissionitemsQuery(get_called_class());
    }
}