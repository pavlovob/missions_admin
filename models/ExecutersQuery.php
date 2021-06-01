<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Executers]].
 *
 * @see Executers
 */
class ExecutersQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Executers[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Executers|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
