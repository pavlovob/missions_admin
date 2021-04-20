<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Inifile */

$this->title = 'Редактирование настройки: ' . $model->description;
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '('.$model->section.'/'.$model->param.')', 'url' => ['view', 'id' => $model->uid]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="inifile-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
