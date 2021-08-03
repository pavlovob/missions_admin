<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Поручения';
$this->params['breadcrumbs'][] = $this->title;

// Скрипт обрабатывает клик по строке GridView
$this->registerJs("

$('tbody td').click(function (e) {
  var id = $(this).closest('tr').data('id');
  if(e.target == this)
  location.href = '" . Url::to(['missions/indexitems']) . "?id=' + id;
});
");

// CSS для измнеения курсора над GridView
$this->registerCss("table { cursor: pointer; }");

?>

<div class="missions-index">
  <!-- <div class="w3-row w3-large"> -->
  <h3><?= Html::encode($this->title) ?></h3>

  <p>
    <?= Yii::$app->user->identity->usertype == USERTYPE_ADMIN ? Html::a('Создать поручения', ['create'], ['class' => 'btn btn-success']) : ''?>
    <?= Html::a('Создать поручения', ['export','id'=>56], ['class' => 'btn btn-success'])?>
  </p>

  <!-- <?php Pjax::begin(); ?> -->
  <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <?= GridView::widget([
    'id'  => 'gridWidget',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'tableOptions' => [
      //'class' => 'table table-striped table-bordered',
      'class' => 'table table-bordered table-condensed ',
      'style' => 'font-size:12px;'
      //'style' => ' line-height: 30px',
      // 'style' => 'width: 2500px;',
    ],
    'rowOptions'   => function ($model, $key, $index, $grid) {
      return ['data-id' => $model->uid];
    },
    'columns' => [
      ['class' => 'yii\grid\SerialColumn'],
      [
        'attribute' => 'uid',
        'options' => ['width' => '70'],
      ],
      [
        'attribute' => 'status',
        'format' => 'raw',
        'options' => ['width' => '150'],
        'filter' => $states,
        'value' => function ($model, $key, $index, $column) {
          switch ($model->{$column->attribute}) {
            case STATE_ASSIGN:
            return \yii\helpers\Html::tag('span','Формирование',['class' => 'label label-info']);
            break;
            case STATE_REPORT:
            return \yii\helpers\Html::tag('span','Отчетность',['class' => 'label label-warning']);
            break;
            case STATE_CLOSED:
            return \yii\helpers\Html::tag('span','Закрыто',['class' => 'label label-success']);
            break;
            case STATE_DELETED:
            return \yii\helpers\Html::tag('span','Удалено',['class' => 'label label-default']);
            break;
            default:
            break;
          }
        },
      ],
      'mission_name',
      'approve_fio',
      [
        'attribute' => 'mission_date',
        'options' => ['width' => '70'],
      ],
      [//Элементы управления для администратора
        'class' => 'yii\grid\ActionColumn',
        'options' => ['width' => '70'],
        'visible' => $usertype == USERTYPE_ADMIN,
      ],
      [ //элементы управления для куратора
        'class' => 'yii\grid\ActionColumn',
        'template' => '{export}',
        'buttons' => [
          'export' => function ($url,$model)          {
            return Html::a(
              '<span class="glyphicon glyphicon-export"></span>',
              // $url,
              ['export','id'=>56],
              // ['class' => 'btn btn-success','title' => 'Экспорт в Excel']
            );
          },
        ],
        // 'visible' => $user->usertype !== USERTYPE_EXECUTER,
        // 'visible' => false,
        'options' => ['width' => '30'],
      ],
    ],
  ]); ?>

  <!-- <?php Pjax::end(); ?> -->
  <!-- </div> -->
</div>
