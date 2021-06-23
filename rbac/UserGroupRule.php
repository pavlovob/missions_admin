<?php
namespace app\rbac;

use Yii;
// use app\models\History;
use yii\rbac\Rule;
class UserGroupRule extends Rule {

    public $name = 'userGroup';

    public function execute($user, $item, $params)
    {
        if (!Yii::$app->user->isGuest) {
            $group = Yii::$app->user->identity->usertype;
            // History::log($group);
            if ($item->name === 'ASSIGNER') return $group == USERTYPE_ASSIGNER;
            if ($item->name === 'EXECUTER') return $group == USERTYPE_EXECUTER;
            if ($item->name === 'ADMIN') return $group == USERTYPE_ADMIN;
        }
        return false  ;
    }
}
