<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="serviceacts-index">
  <div class="w3-container">


<div class="w3-row w3-small">
  <h3><?= Html::encode($this->title) ?></h3>
  <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>

  <?php
  echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
      // ['class' => 'yii\grid\SerialColumn'],
      'id',
      'login',
      'username',

      // [
      //   'attribute' => 'created',
      //   'options' => ['width' => '300'],
      // ],
      // [
      //   'attribute' => 'changed',
      //   'options' => ['width' => '300'],
      // ],
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
          'options' => ['width' => '100'],
      ],
    ]
  ]);
  ?>
</div>
</div>
</div>
