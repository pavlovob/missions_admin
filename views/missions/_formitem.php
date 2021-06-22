<?php
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\widgets\ActiveField;
use app\assets\AppAsset;

?>
<div class="w3-container w3-tiny">
  <div class="missionitems-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
      <?= $form->field($model, 'executeruid')->dropdownList($executers)?>
      <?= $form->field($model, 'executer_name')->textInput(['maxlength' => true]) ?>
      <?= $form->field($model, 'task')->textarea(['rows' => 5, 'cols' => 5])?>
      <?= $form->field($model, 'deadline')->textarea(['rows' => 2,'cols' => 1])?>
      <?= $form->field($model, 'description')->textarea(['rows' => 3, 'cols' => 5])?>
      <?= $form->field($model, 'assigneruid')->dropdownList($assigners,['disabled'=>true])?>
      <?= $form->field($model, 'assigner_name')->textInput(['maxlength' => true,'disabled'=>true]) ?>

      <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <!-- <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Записать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?> -->
      </div>

      <?php ActiveForm::end(); ?>


    </div>
  </div>
