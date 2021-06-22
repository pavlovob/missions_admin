<?php

use yii\helpers\Html;

$this->title = 'Новый пункт поручений';
$this->params['breadcrumbs'][] = ['label' => 'Поручения', 'url' => ['indexitems?id='.$model->missionuid]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="missions-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_formitem', [
        'model' => $model,
        'executers'  => $executers,
        'assigners'  => $assigners,
    ]) ?>

</div>
