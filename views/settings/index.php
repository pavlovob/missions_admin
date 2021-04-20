<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InifileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Таблица настроек';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inifile-index w3-row w3-tiny">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
              'attribute' => 'uid',
              'options' => ['width' => '50'],
            ],

            // [
            //   'attribute' => 'section',
            //   'options' => ['width' => '180'],
            // ],
            //
            // [
            //   'attribute' => 'param',
            //   'options' => ['width' => '180'],
            // ],
            [
              'attribute' => 'description',
              'options' => ['width' => '300'],
            ],
            [
              'attribute' => 'value',
              'options' => ['width' => '300'],
            ],
            [
               'class' => 'yii\grid\ActionColumn',
               'header'=>'*',
               'headerOptions' => ['width' => '75'],
               'template' => '{view}{update}{delete}',
           ],
        ],
    ]); ?>
</div>
