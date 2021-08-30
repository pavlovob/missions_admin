<?php

// Testing new vscode features
namespace app\controllers;

use Yii;
use app\models\Assigners;
use app\models\AssignersSearch;
use app\models\History;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class AssignersController extends Controller {
    public function behaviors()     {
      return [
        'verbs' => [
          'class' => VerbFilter::className(),
          'actions' => [
            'delete' => ['POST'],
          ],
        ],
        'access' => [
          'class' => AccessControl::className(),
          'only' => ['update', 'index','view','create','delete'],
          'rules' => [
            [
              'allow' => true,
              'actions' =>['update', 'index','view','create','delete'],
              'roles' => ['ADMIN'],
            ],
          ],
        ],
      ];
    }

    //просмотр списка кураторов
    public function actionIndex()    {
        $searchModel = new AssignersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    //просмотр записи куратора
    public function actionView($id)    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    //создание куратора
    public function actionCreate()    {
        $model = new Assigners();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            History::log('В справочник добавлен новый куратор '.$model->name,implode(', ',$model->toArray()));
            return $this->redirect(['view', 'id' => $model->uid]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    //редактирование куратора
    public function actionUpdate($id)    {
      $model = $this->findModel($id);
      $model->changed = date('Y-m-d G:i:s', time());
      if ($model->load(Yii::$app->request->post()) && $model->save())  {
          History::log('Отредактирован куратор в справочнике',implode(', ',$model->toArray()));
          return $this->redirect(['view', 'id' => $model->uid]);
      }
      return $this->render('update', [
          'model' => $model,
      ]);
    }

    //Удалить куратора
    public function actionDelete($id)    {
      $model = $this->findModel($id);
      try{
        $model->delete();
        History::log('Из справочника удален куратор '.$model->name,implode(', ',$model->toArray()));
        Yii::$app->session->setFlash('info','Запись удалена!');
        return $this->redirect(['index']);
      } catch (\Exception $e) {
        History::log('Ошибка удаления куратора '.$model->name.' из БД',implode(', ',$model->toArray()));
        Yii::$app->session->setFlash('error','Удаление записи невозможно! Нарушение целостности данных! ');
        return $this->redirect(Yii::$app->request->referrer);
      }
    }

    protected function findModel($id)    {
        if (($model = Assigners::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Не найден куратор в справочнике');
    }
}
