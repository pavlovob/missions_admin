<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="w3-row w3-small">
  <h3><?= Html::encode($this->title) ?></h3>
  <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>

  <?php
  echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'tableOptions' => [
      'class' => 'table table-striped table-bordered',
      'style' => 'font-size:12px;',
    ],
    'columns' => [
      // ['class' => 'yii\grid\SerialColumn'],
      [
        'attribute' => 'uid',
        'options' => ['width' => '80'],
      ],
      [
        'attribute' => 'login',
        'options' => ['width' => '150'],
      ],
      'username',
      [
        'attribute' => 'usertype',
        'value'     =>  function ($model){
          return $model->userTypeName($model->usertype);
        },
        'options' => ['width' => '150'],
        'filter'=>$usertypes,
      ],
      [
        //'header' => 'Тип',
        'attribute' => 'assignerid',
        'value' => 'assigner.name',
        // 'options' => ['width' => '100'],
        'filter'=>$assigners,
      ],
      [
        //'header' => 'Тип',
        'attribute' => 'executerid',
        'value' => 'executer.name',
        // 'options' => ['width' => '100'],
        'filter'=>$executers,
      ],
      [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{view} {update} {delete} {pwdchange}',
        'buttons' => [
          'pwdchange' => function ($url,$model) {
            return Html::a(
              '<span class="glyphicon  glyphicon-sunglasses"></span>',
              $url,[
                'title' => \Yii::t('yii', 'Смена пароля'),]);
              },
            ],
            'options' => ['width' => '90'],
          ],
        ]
      ]);
      ?>
    </div>
