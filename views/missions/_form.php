<?php
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\widgets\ActiveField;
use app\assets\AppAsset;

?>
<div class="w3-container w3-tiny">
  <div class="missions-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
      <!-- <?= $form->field($model, 'uid')->textInput(['maxlength' => true]) ?> -->
      <!-- <?= $form->field($model, 'mission_date')->textInput(['maxlength' => true]) ?> -->
      <?= $form->field($model, 'mission_name')->textInput(['maxlength' => true]) ?>
      <?= $form->field($model, 'approve_post')->textInput(['maxlength' => true]) ?>
      <?= $form->field($model, 'approve_fio')->textInput(['maxlength' => true]) ?>
      <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
      <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
      <?= $form->field($model, 'status')->dropdownList($states)?>

      <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <!-- <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Записать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?> -->
      </div>

      <?php ActiveForm::end(); ?>


    </div>
  </div>
