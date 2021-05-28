<?php

namespace app\controllers;

use Yii;
use app\models\Missions;
use app\models\MissionsSearch;
use app\models\History;
use app\models\Inifile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class MissionsController extends Controller {

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
            'states'  => Missions::stateNames(),
            // 'states'  => Missions::statesDropdown(),
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
            $ts = strtotime($model->mission_date);
            $msg = 'Созданы поручения. ';
            // $msg = 'Созданы поручения на '.date('n',strtotime($model->mission_date));
            Yii::$app->session->setFlash('info', $msg);
            History::Log($msg,implode(';',$model->toArray()));
            return $this->redirect(['view', 'id' => $model->uid]);
        }

        // $model->mission_date = mktime(0, 0, 0, date('m')+1, 1, date('Y'));
        $model->mission_date = date('Y-m-d',time());
        // $model->description   = "Поручения на " . Missions::monthName($model->mission_month) . " " .  $model->mission_year . " года" ;
        $model->description   = "" ;
        $model->approve_fio   = Inifile::getIni('committee','s1f');
        $model->approve_post  = Inifile::getIni('committee','s1p');
        // $model->description = "Тест";
        return $this->render('create', [
            'model' => $model,
            'states'  => Missions::statesDropdown(),
        ]);
    }

    public function actionUpdate($id)    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->uid]);
        }

        return $this->render('update', [
            'model' => $model,
            'months'  => Missions::monthsDropdown(),
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
