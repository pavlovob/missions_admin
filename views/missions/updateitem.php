<?php

use yii\helpers\Html;

$this->title = 'Редактирование поручения';
$this->params['breadcrumbs'][] = ['label' => 'Поручения', 'url' => ['indexitems?id='.$model->missionuid]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="missions-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_formitem', [
        'model' => $model,
        'executers'  => $executers,
        // 'assigners'  => $assigners,
    ]) ?>

</div>
