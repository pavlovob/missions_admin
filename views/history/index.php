<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'История событий';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="history-index">

  <h2><?= Html::encode($this->title) ?></h2>
  <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <div class="w3-row w3-tiny">
    <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'tableOptions' => [
        //'class' => 'table table-striped table-bordered',
        'class' => 'table table-bordered table-condensed ',
        //'style' => ' line-height: 30px',
        // 'style' => 'width: 2500px;',
      ],
      'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
          'attribute' => 'UID',
          'options' => ['width' => '80'],
          //'format' => ['date', 'php:Y-m-d H:i:s'],
        ],
        [
          'attribute' => 'ACTIONDATETIME',
          'options' => ['width' => '150'],
          //'format' => ['date', 'php:Y-m-d H:i:s'],
        ],
        [
          'attribute' => 'DESCRIPTION',
          'format' => 'text',
          // 'options' => ['width' => '700'],
        ],
        [
          'attribute' => 'USERNAME',
          'options' => ['width' => '150'],
          //'format' => ['date', 'php:Y-m-d H:i:s'],
        ],
        [
          'class' => 'yii\grid\ActionColumn',
          'header'=>'Действия',
          'headerOptions' => ['width' => '50'],
          'template' => '{view}',
        ],
      ],
    ]); ?>
  </div>
</div>
