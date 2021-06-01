<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Executers */

$this->title = 'Update Executers: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Executers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->uid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="executers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
