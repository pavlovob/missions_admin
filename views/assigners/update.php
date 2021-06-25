<?php

use yii\helpers\Html;


$this->title = 'Редактирование: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Кураторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->uid]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>

<div class="assigners-update">

    <h3><?= Html::encode($this->title) ?></h3 >

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
