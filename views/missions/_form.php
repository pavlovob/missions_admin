<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
// use yii\jui\DatePicker;
// use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
?>

<div class="w3-container w3-tiny">
<div class="missions-form">

    <!-- <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?> -->
    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'mission_month')->textInput() ?> -->
    <?= $form->field($model, 'mission_month')->dropdownList($months,['style'=>'width:150px'])?>
    <?= $form->field($model, 'mission_year')->textInput(['style'=>'width:60px;text-align:right']) ?>
    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'from_date')->widget(\yii\jui\DatePicker::classname(), [
                        'options' => ['placeholder' => Yii::t('app', 'Starting Date')],
                        'attribute2'=>'to_date',
                        'type' => DatePicker::TYPE_RANGE,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'startView'=>'year',
                            'minViewMode'=>'months',
                            'format' => 'mm-yyyy'
                        ]
                    ]) ?>

    <?= $form->field($model, 'locked')->textInput() ?>

    <?= $form->field($model, 'approve_post')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'approve_fio')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <!-- <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Записать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?> -->
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
