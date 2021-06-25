<?php

namespace app\controllers;

use Yii;
use app\models\Missions;
use app\models\MissionsSearch;
use app\models\Missionitems;
use app\models\MissionitemsSearch;
use app\models\Executers;
use app\models\Assigners;
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
        'only' => ['update', 'index','view','create','delete','indexitems','createitem','viewitem','deleteitem','updateitem','updatereport'],
        'rules' => [
          [
            'allow' => true,
            'actions' =>['update', 'index','view','create','delete','indexitems','createitem','viewitem','deleteitem','updateitem','updatereport'],
            'roles' => ['ADMIN'],
          ],
          [
            'allow' => true,
            'actions' =>['index','view','indexitems','createitem','viewitem','deleteitem','updateitem'],
            'roles' => ['ASSIGNER'],
          ],
          [
            'allow' => true,
            'actions' =>['index','view','indexitems','viewitem','updateitem','updatereport'],
            'roles' => ['EXECUTER'],
          ],
        ],
      ],
    ];
  }

  //Отображение списка поручений
  public function actionIndex()    {
    $searchModel = new MissionsSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
      'states'  => Missions::statesDropdown(),
    ]);
  }

  //список пунктов поручений. фильтр по кураторам применяется в модели
  public function actionIndexitems($id)    { //$id - код поручений для фильтра
    $searchModel = new MissionitemsSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);
    return $this->render('indexitems', [
      'searchModel' => $searchModel,
      'model' => Missions::findOne($id),
      'dataProvider' => $dataProvider,
      'assigner'  => Assigners::findOne(Yii::$app->user->identity->assignerid),
    ]);
  }

  //просмотр поручений
  public function actionView($id)    {
    return $this->render('view', [
      'model' => $this->findModel($id),
    ]);
  }

  //просмотр пункта поручений
  public function actionViewitem($id)    {
    return $this->render('viewitem', [
      'model' => $this->findModelitem($id),
    ]);
  }

  //создание поручений
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

  //создание пункта поручений
  public function actionCreateitem($id)    {
    $model = new Missionitems();
    if ($model->load(Yii::$app->request->post())) {
      // $model->executer_name  = ($model->executeruid !== null) ? Executers::findOne($model->assigneruid)->name : "Неопределен";
      $model->missionuid    = $id;
      $model->assigneruid   = Yii::$app->user->identity->assignerid;
      $model->assigner_name = Yii::$app->user->identity->username;
      if ($model->save(false)) {
        $msg = 'Пункт поручений создан';
        Yii::$app->session->setFlash('info', $msg);
        History::Log($msg,implode('|',$model->toArray()));
        return $this->redirect(['indexitems', 'id' => $model->missionuid]);
      }
    }
    // $model->assigner_name = ($model->assigneruid !== null) ? Assigners::findOne($model->assigneruid)->name : "Неопределен";
    // $model->approve_fio   = Inifile::getIni('committee','s1f');
    // $model->approve_post  = Inifile::getIni('committee','s1p');
    return $this->render('createitem', [
      'model' => $model,
      'executers'  => Executers::Dropdown(),
      // 'assigners'  => Assigners::Dropdown(),
    ]);
  }

  //редактирование поручений
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

  //редактирование пункта поручений
  public function actionUpdateitem($id)    {
    $model = $this->findModelitem($id);
    if ($model->load(Yii::$app->request->post()))  {
      $model->date_changed = date('Y-m-d G:i:s', time());
      $model->save();
      History::log('Отредактированы поручения',implode(', ',$model->toArray()));
      return $this->redirect(['viewitem', 'id' => $model->uid]);
    }
    return $this->render('updateitem', [
      'model' => $model,
      'executers'  => Executers::Dropdown(),
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

  protected function findModelitem($id)    {
    if (($model = Missionitems::findOne($id)) !== null) {
      return $model;
    }
    throw new NotFoundHttpException('The requested page does not exist.');
  }

}
