<?php
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\widgets\ActiveField;
use yii\jui\DatePicker;
use \yii\jui\Spinner;
use app\assets\AppAsset;

// AppAsset::register($this);

// $this->registerJsFile(
//   '@web/js/datepicker.js',
//   ['depends' => [\yii\web\JqueryAsset::className()]]
// );
$this->registerCss(".ui-datepicker-calendar { display: none; }");
//

?>


<div class="w3-container w3-tiny">
  <div class="missions-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
    <!-- <?= $form->field($model, 'mission_date')->textInput(['class' => 'date-picker','dateFormat' => 'yyyy-MM-dd']) ?> -->

    <!-- <input name="mission_date" id="mission_date" class="date-picker" /> -->
    <?= $form->field($model, 'mission_date')->widget(\yii\jui\DatePicker::classname(), [
      'language' => 'ru',
      // 'class' => 'date-picker',
      'id' => 'datepicker',
      // 'dateFormat' => 'dd.MM.yyyy',
      'dateFormat' => 'yyyy-MM-dd',
      // 'inline' =>'1',
      // 'dateFormat' => 'MM yy',

      'clientOptions' => [

        'showAnim' => 'fadeIn',
        'changeMonth' => true,
        'changeYear' => true,
        'yearRange' => '2020:2030',
        // 'showButtonPanel' => true,

        // 'onClose' => new yii\web\JsExpression ('showtime'),
        // 'onClose' => new \yii\web\JsExpression('function(dateText,inst){alert(123);}'),
        // 'onSelect' => new \yii\web\JsExpression('function(dateText,inst){alert(123);}'),
        // 'onSelect' => new \yii\web\JsExpression('function(dateText,inst){alert(123);}'),
        'onChangeMonthYear' => new \yii\web\JsExpression('function(year, month, inst) {
            alert(month);
            var dt = new Date(year, month);
            $(this).datepicker("setDate", dt);
            alert(dt);
        }'),

        // 'onClose' => new \yii\web\JsExpression('function(dateText, inst) {
        //     var dt = new Date(inst.selectedYear, inst.selectedMonth);
        //     $(this).datepicker("setDate", dt);
        //     alert(dt);
        // }'),

        // 'onClose' => new \yii\web\JsExpression('function(dateText, inst) {
        //   // alert(month);
        //     // var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
        //     // var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
        //   $(this).datepicker("setDate", new Date(year, month, 1));
        // }'),
      ],
      ])?>

      <?= $form->field($model, 'approve_post')->widget(\yii\jui\DatePicker::classname(), [
        'language' => 'ru',
        // 'class' => 'date-picker',
        'id' => 'datepicker',
        // 'dateFormat' => 'dd.MM.yyyy',
        // 'dateFormat' => 'yyyy-MM-dd',
        // 'inline' =>'1',
        'dateFormat' => 'MM yy',

        'clientOptions' => [

          'showAnim' => 'fadeIn',
          'changeMonth' => true,
          'changeYear' => true,
          'yearRange' => '2020:2030',
          // 'showButtonPanel' => true,

          // 'onClose' => new yii\web\JsExpression ('showtime'),
          // 'onClose' => new \yii\web\JsExpression('function(dateText,inst){alert(123);}'),
          // 'onSelect' => new \yii\web\JsExpression('function(dateText,inst){alert(123);}'),
          // 'onSelect' => new \yii\web\JsExpression('function(dateText,inst){alert(123);}'),
          // 'onChangeMonthYear' => new \yii\web\JsExpression('function(year, month, inst) {
          //     alert(month);
          //     var dt = new Date(year, month);
          //     $(this).datepicker("setDate", dt);
          //     alert(dt);
          // }'),

          // 'onClose' => new \yii\web\JsExpression('function(dateText, inst) {
          //     var dt = new Date(inst.selectedYear, inst.selectedMonth);
          //     $(this).datepicker("setDate", dt);
          //     alert(dt);
          // }'),

          // 'onClose' => new \yii\web\JsExpression('function(dateText, inst) {
          //   // alert(month);
          //     // var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
          //     // var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
          //   $(this).datepicker("setDate", new Date(year, month, 1));
          // }'),
        ],
        ])?>


      <!-- <?= $form->field($model, 'approve_post')->textInput(['maxlength' => true]) ?> -->

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
