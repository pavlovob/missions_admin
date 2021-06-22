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
            [['uid', 'missionuid', 'num_pp', 'deadline', 'assigneruid', 'assigner_name', 'executeruid', 'executer_name', 'task'], 'required'],
            [['uid', 'missionuid', 'num_pp', 'assigneruid', 'executeruid'], 'integer'],
            [['deadline', 'date_created', 'date_changed'], 'safe'],
            [['assigner_name', 'executer_name'], 'string', 'max' => 45],
            [['task', 'description'], 'string', 'max' => 1000],
            [['uid'], 'unique'],
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
            'executer_name' => 'Ф.И.О.',
            'task' => 'Поручение',
            'description' => 'Примечание',
            'date_created' => 'Дата создания',
            'date_changed' => 'Дата изменения',
        ];
    }

    public function getMissionu()
    {
        return $this->hasOne(Missions::className(), ['uid' => 'missionuid']);
    }

    public static function find()
    {
        return new MissionitemsQuery(get_called_class());
    }
}
