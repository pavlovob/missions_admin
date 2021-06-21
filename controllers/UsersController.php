<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\UserSearch;
use app\models\History;
use app\models\Assigners;
use app\models\Executers;

use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\bootstrap\Alert;

class UsersController extends Controller {

  public function behaviors()  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'only' => ['update', 'index','delete','view','create','pwdchange'],
        'rules' => [
          [
            'allow' => true,
            'actions' => ['update', 'index','delete','view','create','pwdchange'],
            'roles' => ['@'],
          ],
        ],
      ],
    ];
  }

  public function actionIndex()  {
    $searchModel  = new UserSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    // $dataProvider = new ActiveDataProvider([
    //   'query' => User::find(),
    //   'pagination' => [
    //     'pageSize' => 50,
    //   ],
    // ]);
    return $this->render('index', [
      'searchModel'  => $searchModel,
      'dataProvider' => $dataProvider,
      'usertypes'    => User::typesDropdown(),
      'assigners'    => Assigners::dropdown(),
      'executers'    => Executers::dropdown(),
    ]);
  }

  public function actionView($id)  {
    $user = User::findOne($id);
    return $this->render('view', ['model' => $user]);
  }

  public function actionCreate()  {
    $model = new User(['scenario' => 'insert']);
    if ($model->load(Yii::$app->request->post()) && $model->validate())    {
      $model->created = date('Y-m-d G:i:s', time());
      $model->changed = $model->created;
      $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash($model->password);
      $model->save();
      History::log('В справочник пользователей добавлена запись',implode(';',$model->toArray()));
      return $this->redirect(['view', 'id' => $model->id]);
    } else    {
      $model->usertype = 0;
      return $this->render('create', [
        'model'     => $model,
        'assigners' => Assigners::dropdown(),
        'executers' => Executers::dropdown(),
        'usertypes' => User::typesDropdown(),
      ]);
    }
  }

  public function actionUpdate($id)  {
    $model = User::findOne($id);
    $model->scenario = 'update';
    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
      //$model->password_hash = Yii::$app->getSecurity()->generatePasswordHash($model->password);
      $model->changed = date('Y-m-d G:i:s', time());
      $model->save();
      History::log('Отредактирована запись пользователя '.$model->username,implode(';',$model->toArray()));
      return $this->redirect(['view', 'id' => $model->id]);
    } else {
      return $this->render('update', [
        'model' => $model,
        'assigners' => Assigners::dropdown(),
        'executers' => Executers::dropdown(),
        'usertypes' => User::typesDropdown(),
      ]);
    }
  }
  public function actionDelete($id)  {
    $user = User::findOne($id);
    try{
      $user->delete();
      History::log('Удалена запись пользователя',implode(', ',$user->toArray()));
      Yii::$app->session->setFlash('info','Запись удалена!');
      return $this->redirect(['index']);
    } catch (\Exception $e) {
      Yii::$app->session->setFlash('error','Удаление записи невозможно! Нарушение целостности данных! ');
      // echo "Удаление невозможно! Данный расходный материал привязан к модели.";
      return $this->redirect(Yii::$app->request->referrer);
    }
  }

  public function actionPwdchange($id)  {
    $model = User::findOne($id);
    $model->scenario = 'pwd_change';
    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
      $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash($model->password);
      $model->changed = date('Y-m-d G:i:s', time());
      $model->save();
      History::log('Изменен пароль учетной записи пользователя '.$model->username);
      return $this->redirect(['view', 'id' => $model->id]);
    } else    {
      return $this->render('pwdchange', ['model' => $model]);
    }
  }

}
