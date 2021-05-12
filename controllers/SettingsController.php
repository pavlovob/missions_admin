<?php

namespace app\controllers;

use Yii;
// use \yii\data\ArrayDataProvider;
use app\models\Inifile;
use app\models\InifileSearch;
// use app\models\Settings;
use app\models\History;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

class SettingsController extends Controller {
  public function behaviors()  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'only' => ['update', 'index','view'],
        // 'formats' => ['application/json' => Response::FORMAT_JSON],
        'rules' => [
          [
            'allow' => true,
            'actions' => ['update', 'index','view'],
            'roles' => ['@'],
          ],
        ],
      ],
    ];
  }
  public function actionIndex()   {
    Inifile::checkIntegrity();

    //$searchModel = new WorkersSearch();
    //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    $searchModel = new InifileSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  public function actionView($id)  {
    return $this->render('view', [
      'model' => $this->findModel($id),
    ]);
  }

  public function actionUpdate($id)  {
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      History::log('Отредактирована настройка ('.$model->section.'/'.$model->param.') на '.$model->value,'');
      return $this->redirect(['index']);
    } else {
      return $this->render('update', [
        'model' => $model,
      ]);
    }
  }
  public function actionDelete($id)  {
    $model = $this->findModel($id);
    if ($model !== null) {
      $model -> delete();
      History::log('Удалена настройка ('.$model->section.'/'.$model->param.')','');
    }
    return $this->redirect(['index']);
  }

  protected function findModel($id)  {
    if (($model = Inifile::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('Модель не найдена');
    }
  }



}
