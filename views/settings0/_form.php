<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
?>

<div class="inifile-form w3-row w3-small">

    <br>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'section',
            'param',
            'description',
        ],
    ]) ?>

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Записать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
