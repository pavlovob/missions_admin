<?php

namespace app\controllers;

use Yii;
use app\models\Missions;
use app\models\MissionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class MissionsController extends Controller {
    // public function behaviors()     {
    //     return [
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 'delete' => ['POST'],
    //             ],
    //         ],
    //     ];
    // }

    public function behaviors()     {
      return [
        'access' => [
          'class' => AccessControl::className(),
          'only' => ['update', 'index','view','create','delete'],
          'rules' => [
            [
              'allow' => true,
              'actions' =>['update', 'index','view','create','delete'],
              'roles' => ['@'],
            ],
          ],
        ],
      ];
    }

    public function actionIndex()    {
        $searchModel = new MissionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'months'  => Missions::monthsDropdown(),
        ]);
    }

    public function actionView($id)    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()    {
        $model = new Missions();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->uid]);
        }

        $model->mission_month = date('n') + 1;
        $model->mission_year  = date('o')  ;
        $model->description   = "Поручения на " . Missions::monthName($model->mission_month) . " " .  $model->mission_year . " года" ;
        // $model->description = "Тест";
        return $this->render('create', [
            'model' => $model,
            'months'  => Missions::monthsDropdown(),
        ]);
    }

    public function actionUpdate($id)    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->uid]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)    {
        if (($model = Missions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
