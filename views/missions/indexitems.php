<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Поручения';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->mission_name];


// Скрипт обрабатывает клик по строке GridView
$this->registerJs("

$('tbody td').click(function (e) {
  var id = $(this).closest('tr').data('id');
  if(e.target == this)
  location.href = '" . Url::to(['missions/viewitem']) . "?id=' + id;
});

");
//CSS для измнеения курсора над GridView
$this->registerCss("table { cursor: pointer; }");
//CSS для многострочного отображения в Gridview
$this->registerCss("grid-view td {white-space: inherit;}");
?>

<div class="missions-index">
  <!-- <div class="w3-row w3-large"> -->
  <h3><?= Html::encode($this->title) ?></h3>

  <p>
    <?= Html::a('Добавить пункт поручений', ['createitem', 'id'=>$model->uid], ['class' => 'btn btn-success']) ?>
  </p>

  <?php Pjax::begin(); ?>
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
        'attribute' => 'num_pp',
        'options' => ['width' => '70'],
      ],
      // [
      //   'attribute' => 'status',
      //   'format' => 'raw',
      //   'options' => ['width' => '100'],
      //   'filter' => $states,
      //   'value' => function ($model, $key, $index, $column) {
      //     $active = $model->{$column->attribute} === STATE_OPEN;
      //     return \yii\helpers\Html::tag(
      //       'span',
      //       $active ? 'Открыто' : 'Закрыто',
      //       [
      //         'class' => 'label label-' . ($active ? 'success' : 'danger'),
      //       ]
      //     );
      //   },
      // ],
      'task',
      [
        'attribute' => 'deadline',
        'options' => ['width' => '70'],
      ],
      [
        'attribute' => 'assigneruid',
        'value' => 'assigner.name',
        'filter'=>$assigners,
        'visible' => $usertype !== USERTYPE_ASSIGNER,
      ],
      [
        'attribute' => 'executeruid',
        'value' => 'executer.name',
        'filter'=>$executers,
        'visible' => $usertype !== USERTYPE_EXECUTER,
      ],
      [
        'attribute' => 'executer_name',
        'visible' => $usertype !== USERTYPE_EXECUTER,
      ],
      [
        'attribute' => 'assigner_name',
        'visible' => $usertype !== USERTYPE_ASSIGNER,
      ],
      [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{viewitem} {updateitem} {deleteitem}',
        'buttons' => [
          'viewitem' => function ($url,$model)
          {
            return Html::a(
              '<span class="glyphicon glyphicon-eye-open"></span>',
              $url,[
                'title' => \Yii::t('yii', 'Просмотр'),]);
              },
          'updateitem' => function ($url,$model) {
            return Html::a(
              '<span class="glyphicon  glyphicon-pencil"></span>',
              $url,[
                'title' => \Yii::t('yii', 'Редактировать'),]);
              },
          'deleteitem' => function ($url,$model) {
            return Html::a(
              '<span class="glyphicon  glyphicon-trash"></span>',
              $url,[
                'title' => \Yii::t('yii', 'Удалить'),]);
              },
            ],
        'options' => ['width' => '90'],
        ],
      ],
    ]); ?>

              <?php Pjax::end(); ?>
              <!-- </div> -->
            </div>
