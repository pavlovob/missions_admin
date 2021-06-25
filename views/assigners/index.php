<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Кураторы';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="assigners-index">
  <h3><?= Html::encode($this->title) ?></h3>

  <p>
    <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
  </p>

  <?php Pjax::begin(); ?>
  <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <?= GridView::widget([
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
      [
        'attribute' => 'uid',
        'options' => ['width' => '100'],
      ],
      'name',
      [
        'attribute' => 'ordernumber',
        'options' => ['width' => '90'],
      ],
      [
        'class' => 'yii\grid\ActionColumn',
        'options' => ['width' => '90'],
      ],
    ],
  ]); ?>

  <?php Pjax::end(); ?>

</div>
