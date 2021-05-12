<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Поручения';
$this->params['breadcrumbs'][] = $this->title;
?>
<script>
    $(document).ready(function()
    {
        $('body').on('dblclick', '#files-grid tbody tr', function(event)
        {
            //Do something...
        });
    });
</script>

<div class="missions-index">
  <!-- <div class="w3-row w3-large"> -->
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
      <?= Html::a('Создать поручения', ['create'], ['class' => 'btn btn-success']) ?>
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
      'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
          'attribute' => 'status',
          'format' => 'raw',
          'options' => ['width' => '100'],
          'filter' => [
            $states
          ],
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
        [
          'attribute' => 'mission_date',
          'format' => 'raw',
          'options' => ['width' => '70'],
          'filter' => [
            // $states
          ],
          'value' => function ($model, $key, $index, $column) {
              $ts = strtotime($model->{$column->attribute});
                $month = '';
                switch (date('n',$ts)) {
                  case 1:
                  $month = 'январь';
                  break;
                  case 2:
                  $month = 'февраль';
                  break;
                  case 3:
                  $month = 'март';
                  break;
                  case 4:
                  $month = 'апрель';
                  break;
                  case 5:
                  $month = 'май';
                  break;
                  case 6:
                  $month = 'июнь';
                  break;
                  case 7:
                  $month = 'июль';
                  break;
                  case 8:
                  $month = 'август';
                  break;
                  case 9:
                  $month = 'сентябрь';
                  break;
                  case 10:
                  $month = 'октябрь';
                  break;
                  case 11:
                  $month = 'ноябрь';
                  break;
                  case 12:
                  $month = 'декабрь';
                  break;
                }
                // $dateObj = DateTime::createFromFormat('!m', $model->{$column->attribute});
                // $month = $dateObj->format('F');
                return $month;
          },
        ],
        [
          'attribute' => 'mission_date',
          'options' => ['width' => '70'],
        ],
        // [
        //   'attribute' => 'mission_month',
        //   'format' => 'raw',
        //   'options' => ['width' => '100'],
        //   'filter' => $months,
        //   'value' => function ($model, $key, $index, $column) {
        //     $month = '';
        //     switch ($model->{$column->attribute}) {
        //       case 1:
        //       $month = 'январь';
        //       break;
        //       case 2:
        //       $month = 'февраль';
        //       break;
        //       case 3:
        //       $month = 'март';
        //       break;
        //       case 4:
        //       $month = 'апрель';
        //       break;
        //       case 5:
        //       $month = 'май';
        //       break;
        //       case 6:
        //       $month = 'июнь';
        //       break;
        //       case 7:
        //       $month = 'июль';
        //       break;
        //       case 8:
        //       $month = 'август';
        //       break;
        //       case 9:
        //       $month = 'сентябрь';
        //       break;
        //       case 10:
        //       $month = 'октябрь';
        //       break;
        //       case 11:
        //       $month = 'ноябрь';
        //       break;
        //       case 12:
        //       $month = 'декабрь';
        //       break;
        //     }
        //     // $dateObj = DateTime::createFromFormat('!m', $model->{$column->attribute});
        //     // $month = $dateObj->format('F');
        //     return $month;
        //     // return \yii\helpers\Html::tag(
        //     //   'span',
        //     //   $month,
        //     //   // [
        //     //   //   'class' => 'label label-' . ($active ? 'success' : 'danger'),
        //     //   // ]
        //     // );
        //   },
        // ],
        // 'description',
        'approve_post',
        'approve_fio',
        //'created',
        //'changed',

        [
          'class' => 'yii\grid\ActionColumn',
          'options' => ['width' => '70'],
        ],
      ],
    ]); ?>

    <?php Pjax::end(); ?>
  <!-- </div> -->
</div>
