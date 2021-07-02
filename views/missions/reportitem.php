<?php

use yii\helpers\Html;

$this->title = 'Отчет о выполнении поручения';
$this->params['breadcrumbs'][] = ['label' => 'Поручения', 'url' => ['indexitems?id='.$model->missionuid]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="missions-update">

    <h3><?= Html::encode($this->title) ?></h3 >

    <?= $this->render('_formreportitem', [
        'model' => $model,
        // 'executers'  => $executers,
        // 'assigners'  => $assigners,
    ]) ?>

</div>
