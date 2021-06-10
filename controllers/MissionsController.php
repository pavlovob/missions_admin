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
            'states'  => Missions::statesDropdown(),
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
        if ($model->load(Yii::$app->request->post())) {
            $model->mission_date  = date('Y-m-d',time());
            if ($model->save()) {
              $msg = 'Поручения созданы';
              Yii::$app->session->setFlash('info', $msg);
              History::Log($msg,implode(',',$model->toArray()));
              return $this->redirect(['view', 'id' => $model->uid]);
            }
        }
        $model->mission_name  = Inifile::getIni('missions','DefaultDescription');
        $model->approve_fio   = Inifile::getIni('committee','s1f');
        $model->approve_post  = Inifile::getIni('committee','s1p');
        return $this->render('create', [
            'model' => $model,
            'states'  => Missions::statesDropdown(),
        ]);
    }

    public function actionUpdate($id)    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()))  {
            $model->changed = date('Y-m-d G:i:s', time());
            $model->save();
            History::log('Отредактированы поручения',implode(', ',$model->toArray()));
            return $this->redirect(['view', 'id' => $model->uid]);
        }

        return $this->render('update', [
            'model' => $model,
            'states'  => Missions::statesDropdown(),
        ]);
    }

    public function actionDelete($id)    {
        $model = $this->findModel($id);
        try{
          $model->delete();
          History::log('Удалены поручения '.$model->mission_name,implode(', ',$model->toArray()));
          Yii::$app->session->setFlash('info','Запись удалена!');
          return $this->redirect(['index']);
        } catch (\Exception $e) {
          History::log('Ошибка удаления поручений! '.$model->name.' из БД',implode(', ',$model->toArray()));
          Yii::$app->session->setFlash('error','Удаление записи невозможно! Нарушение целостности данных! ');
          return $this->redirect(Yii::$app->request->referrer);
        }
    }

    protected function findModel($id)    {
        if (($model = Missions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
