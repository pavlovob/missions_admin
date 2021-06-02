<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
// use app\models\LoginForm;
use app\models\User;
use app\models\History;
// use app\models\ContactForm;

class SiteController extends Controller {
    /**
     * {@inheritdoc}
     */
    public function behaviors()    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    public function actionIndex()    {
        User::checkAdmin(); //Проверка наличия записи администратора в БД (только если там нет пользователей)
        return $this->render('index');
    }

    public function actionLogin()        {
      $model = new User(['scenario' => 'login']);
      if ($model->load(Yii::$app->request->post()) && ($model->validate()))      {
        $error = User::login($model);
        if ($error !== null){
          switch ($error) {
            case 'autherror':
            //Неверное имя пользователя или пароль
            $error = 'Неправильное имя пользователя или пароль';
            break;
            case 'accesserror':
            //Неверное имя пользователя или пароль
            $error = 'Отсутствует доступ к информационной системе. Недостаточно прав.';
            break;
            //Не пользователь но запись есть
            case 'notusererror':
            $error = 'Указанная учетная запись не является пользовательской';
            break;
            default:
            break;
          }
          Yii::$app->session->setFlash('error', $error);
          History::log($error,implode(';',$model->toArray()));
          return $this->render('login', ['model'=>$model]);
        } else {
          History::log('Пользователю предоставлен доступ',$model->username);
          return $this->redirect(['/site']);
          // return $this->redirect(['/workers']);
        }

      } else {
        Yii::$app->session->setFlash('warning', 'Введите данные учетной записи');
        return $this->render('login', ['model'=>$model]);
      }
    }

    public function actionLogin_old()    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }


    public function actionLogout()    {
      History::log('Пользователь завершил работу в ИС');
      Yii::$app->user->logout();
      return $this->goHome();
    }


}
