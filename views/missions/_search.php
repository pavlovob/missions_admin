<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MissionsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="missions-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'uid') ?>

    <?= $form->field($model, 'mission_month') ?>

    <?= $form->field($model, 'mission_year') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'locked') ?>

    <?php // echo $form->field($model, 'approve_post') ?>

    <?php // echo $form->field($model, 'approve_fio') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'changed') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
