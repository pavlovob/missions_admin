<?php
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\widgets\ActiveField;
use app\assets\AppAsset;

?>
<div class="missionreportitems-form">
  <div class="w3-container w3-tiny">


    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
    <!-- <?= $form->field($model, 'num_pp')->textInput(['maxlength' => true]) ?> -->
    <?= $form->field($model, 'task')->textarea(['rows' => 7, 'cols' => 5,'readonly'=>true])?>
      <?= $form->field($model, 'deadline')->textarea(['rows' => 1,'cols' => 1,'readonly'=>true])?>
      <?= $form->field($model, 'report')->textarea(['rows' => 4, 'cols' => 5])?>



      <div class="form-group">
        <!-- <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?> -->
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Записать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
      </div>

      <?php ActiveForm::end(); ?>


    </div>
  </div>
