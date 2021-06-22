<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Missionitems]].
 *
 * @see Missionitems
 */
class MissionitemsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Missionitems[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Missionitems|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
