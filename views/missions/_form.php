<?php
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\widgets\ActiveField;
use yii\jui\DatePicker;
use \yii\jui\Spinner;

// $this->registerCss(".ui-datepicker-calendar { display: none; }");
?>

<div class="w3-container w3-tiny">
  <div class="missions-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
    <?= $form->field($model, 'mission_date')->widget(\yii\jui\DatePicker::classname(), [
      'language' => 'ru',
      // 'id' => 'datepicker1',
      'dateFormat' => 'yyyy-MM-dd',
      // 'dateFormat' => 'MM yy',
      'inline' =>'1',
      'clientOptions' => [
        'changeMonth' => true,
        'changeYear' => true,
        'yearRange' => '2020:2030',
        'showButtonPanel' => false,
        // 'style' => ['ui-datepicker-calendar' => ['display' => 'none']],
        // 'style' => ['display' => 'none'],
      ]
      ]) ?>


      <?= $form->field($model, 'approve_post')->textInput(['maxlength' => true]) ?>

      <?= $form->field($model, 'approve_fio')->textInput(['maxlength' => true]) ?>
      <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
      <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
      <?= $form->field($model, 'status')->dropdownList($states)      ?>
      <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <!-- <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Записать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?> -->
      </div>

      <?php ActiveForm::end(); ?>

    </div>
  </div>
