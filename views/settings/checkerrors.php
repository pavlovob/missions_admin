<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Отчет по операции';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="errors-index">
  <div class="w3-row w3-tiny">
    <h2><?= Html::encode($this->title) ?></h2>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
              'attribute' => 'name',
              'options' => ['width' => '1000'],
            ],
            // 'NAME',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
