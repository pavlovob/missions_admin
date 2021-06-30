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
//CSS для измнеения курсора над GridView
$this->registerCss("table { cursor: pointer; }");

?>

<!-- <script>
    $(document).ready(function()
    {
        $('body').on('dblclick', '#files-grid tbody tr', function(event)
        {
            //Do something...
        });
    });
</script> -->


<div class="missions-index">
  <!-- <div class="w3-row w3-large"> -->
    <h3><?= Html::encode($this->title) ?></h3>

    <p>
      <?= Yii::$app->user->identity->usertype == USERTYPE_ADMIN ? Html::a('Создать поручения', ['create'], ['class' => 'btn btn-success']) : ''?>
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
        // ['class' => 'yii\grid\SerialColumn'],
        // [
        //   'attribute' => 'uid',
        //   'options' => ['width' => '70'],
        // ],
        [
          'attribute' => 'status',
          'format' => 'raw',
          'options' => ['width' => '100'],
          'filter' => $states,
          'value' => function ($model, $key, $index, $column) {
            $active = $model->{$column->attribute} === STATE_OPEN;
            return \yii\helpers\Html::tag(
              'span',
              $active ? 'Открыто' : 'Закрыто',
              [
                'class' => 'label label-' . ($active ? 'success' : 'danger'),
              ]
            );
          },
        ],
        'mission_name',
        'approve_fio',
        [
          'attribute' => 'mission_date',
          'options' => ['width' => '70'],
        ],
        // 'approve_post',
        //'created',
        //'changed',

        [
          'class' => 'yii\grid\ActionColumn',
          'options' => ['width' => '90'],
          'visible' => $usertype == USERTYPE_ADMIN,
        ],
      ],
    ]); ?>

    <?php Pjax::end(); ?>
  <!-- </div> -->
</div>
