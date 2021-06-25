<?php

use yii\helpers\Html;

$this->title = 'Новый пункт поручений';
$this->params['breadcrumbs'][] = ['label' => 'Поручения', 'url' => ['indexitems?id='.$missionuid]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="missions-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_formitem', [
        'model' => $model,
        'missionuid' => $missionuid,
        'title' => $title,
        'executers'  => $executers,
        // 'assigners'  => $assigners,
    ]) ?>

</div>
