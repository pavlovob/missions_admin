<?php

namespace app\controllers;

use Yii;
use app\models\History;
use app\models\HistorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class HistoryController extends Controller  {
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
        'only' => ['index','view'],
        'rules' => [
          [
            'allow' => true,
            'actions' =>['index','view'],
            'roles' => ['ADMIN'],
          ],
        ],
      ],
    ];
  }

  //Просмотр истории
  public function actionIndex()  {
    $searchModel = new HistorySearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    $dataProvider->pagination->pageSize=100;
    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  //просмотр записи истории
  public function actionView($id)  {
    return $this->render('view', [
      'model' => $this->findModel($id),
    ]);
  }

  protected function findModel($id)  {
    if (($model = History::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('Не найдена запись истории');
    }
  }

}
