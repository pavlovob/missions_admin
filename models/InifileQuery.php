<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Inifile]].
 *
 * @see Inifile
 */
class InifileQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Inifile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Inifile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
