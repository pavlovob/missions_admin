<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Добавление оборудования';
$this->params['breadcrumbs'][] = ['label' => 'Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="services-create">

    <h1><?= Html::encode($this->title) ?></h1>
<div class="w3-row w3-tiny">
    <div class="services-form">

        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'ACTUID')->textInput() ?>
        <?= $form->field($model, 'DEVICEUID')->textInput() ?>
        <?= $form->field($model, 'STICKERS')->textInput(['maxlength' => true]) ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>
</div>
