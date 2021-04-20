<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InifileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Информация о входах пользователей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inifile-index w3-row w3-tiny">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
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
              'attribute' => 'created',
              'options' => ['width' => '150'],
            ],
            [
              'attribute' => 'login',
              'options' => ['width' => '120'],
            ],
            [
              'attribute' => 'username',
              // 'options' => ['width' => '300'],
            ],
            [
              'attribute' => 'computername',
              // 'options' => ['width' => '300'],
            ],
            [
              'class' => 'yii\grid\ActionColumn',
              'template' => '{viewuserlogin}',
              'buttons' => [
                'viewuserlogin' => function ($url,$model) {
                    return Html::a('<span class="glyphicon glyphicon-list-alt"></span>',$url,['title'=>'Просмотр записи']);
                },
              ],
              'options' => ['width' => '75'],
            ],
        ],
    ]); ?>
</div>
