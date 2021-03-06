<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php $this->registerCsrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
</head>
<body>
  <?php $this->beginBody() ?>

  <div class="wrap">
    <?php
    //Getting current LDAP username
    if (Yii::$app->user->isGuest){
      $username = "Гость";
    } else {
      //Добавить нормальное имя пользователя
      // $user = Yii::$app->ad->search()->findBy('sAMAccountname', Yii::$app->user->identity->login);
      //$username = $user['displayname'][0];
      $username = Yii::$app->user->identity->username;
    }
    NavBar::begin([
      // 'brandLabel' => Yii::$app->name,
      // 'brandUrl' => Yii::$app->homeUrl,
      'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
      ],
    ]);

    //меню только для залогиненного юзера
    $menuItems[] = ['label' => 'ИС Поручения', 'url' => ['/']];
    if (Yii::$app->user->id !== null) {
      $menuItems[] = ['label' => 'Поручения', 'url' => ['/missions']];
      if(Yii::$app->user->identity->usertype == USERTYPE_ADMIN){
        $menuItems[] = ['label' => 'Настройки', 'items' => [
                ['label' => 'Просмотр истории событий', 'url' => ['/history']],
                ['label' => 'Настройки', 'url' => ['/settings']],
                ['label' => 'Пользователи', 'url' => ['/users']],
                ['label' => 'Исполнители', 'url' => ['/executers']],
                ['label' => 'Кураторы', 'url' => ['/assigners']],
          ]
        ];
      };
    }

    echo Nav::widget([
      'options' => ['class' => 'navbar-nav navbar-left'],
      'items' => $menuItems,
    ]);
    //right menu bar
    echo Nav::widget([
      'options' => ['class' => 'navbar-nav navbar-right'],
      'items' => [
        Yii::$app->user->isGuest ? (
          ['label' => 'Вход', 'url' => ['/site/login']]
          ) : (
            '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
              'Выйти (' .$username . ')',
              // 'Выйти (' . $username . ')',
              ['class' => 'btn btn-link logout']
              )
              . Html::endForm()
              . '</li>'
              )
            ],
          ]);
          NavBar::end();
          ?>

          <div class="container">
            <?= Breadcrumbs::widget([
              'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
              ]) ?>
              <?= Alert::widget() ?>
              <?= $content ?>
            </div>
          </div>

          <footer class="footer">
            <div class="container">
              <!-- <p class="pull-left">&copy; Ярославское РНУ <?= date('Y') ?></p> -->
              <p class="pull-left">&copy; <?=\Yii::$app->params['org_name']?> <?= date('Y') ?></p>

              <!-- <p class="pull-right"><?= Yii::powered() ?></p> -->
            </div>
          </footer>

          <?php $this->endBody() ?>
        </body>
        </html>
        <?php $this->endPage() ?>
