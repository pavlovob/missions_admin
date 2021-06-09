<?php

namespace app\controllers;

use Yii;
use app\models\Executers;
use app\models\ExecutersSearch;
use app\models\History;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ExecutersController extends Controller{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()    {
        $searchModel = new ExecutersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()    {
        $model = new Executers();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            History::log('В справочник добавлен новый исполнитель '.$model->name,implode(', ',$model->toArray()));
            return $this->redirect(['view', 'id' => $model->uid]);
        }

        return $this->render('create', [
            'model' => $model,
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
      $model = $this->findModel($id);
      try{
        $model->delete();
        History::log('Из справочника удален исполнитель '.$model->name,implode(', ',$model->toArray()));
        Yii::$app->session->setFlash('info','Запись удалена!');
        return $this->redirect(['index']);
      } catch (\Exception $e) {
        History::log('Ошибка удаления исполнителя '.$model->name.' из БД',implode(', ',$model->toArray()));
        Yii::$app->session->setFlash('error','Удаление записи невозможно! Нарушение целостности данных! ');
        return $this->redirect(Yii::$app->request->referrer);
      }
    }

    protected function findModel($id)    {
        if (($model = Executers::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
