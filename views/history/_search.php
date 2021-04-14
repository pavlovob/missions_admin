<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\HistorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="history-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'UID') ?>

    <?= $form->field($model, 'PASSNUM') ?>

    <?= $form->field($model, 'DESCRIPTION') ?>

    <?= $form->field($model, 'USERNAME') ?>

    <?= $form->field($model, 'COMPUTERNAME') ?>

    <?php // echo $form->field($model, 'ACTIONDATE') ?>

    <?php // echo $form->field($model, 'ACTIONTIME') ?>

    <?php // echo $form->field($model, 'FILENAME') ?>

    <?php // echo $form->field($model, 'FILECONTENT') ?>

    <?php // echo $form->field($model, 'ACTIONDATETIME') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
