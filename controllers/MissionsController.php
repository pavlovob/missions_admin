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
        'only' => ['update', 'index','view','create','delete','indexitems','createitem','viewitem','deleteitem','updateitem','reportitem','copyitems'],
        'rules' => [
          [
            'allow' => true,
            'actions' =>['update', 'index','view','create','delete','indexitems','createitem','viewitem','deleteitem','updateitem','reportitem','copyitems'],
            'roles' => ['ADMIN'],
          ],
          [
            'allow' => true,
            'actions' =>['index','view','indexitems','createitem','viewitem','deleteitem','updateitem','copyitems'],
            'roles' => ['ASSIGNER'],
          ],
          [
            'allow' => true,
            'actions' =>['index','view','indexitems','reportitem'],
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
      'usertype'  => Yii::$app->user->identity->usertype, //для отображения нужных столбцов
    ]);
  }

  //список пунктов поручений. фильтр по кураторам применяется в модели
  public function actionIndexitems($id)    { //$id - код поручений для фильтра
    $searchModel = new MissionitemsSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);
    // Yii::$app->session->setFlash('info', Yii::$app->user->identity->usertype);
    return $this->render('indexitems', [
      'searchModel' => $searchModel,
      'model' => Missions::findOne($id),// модель поручений
      'dataProvider' => $dataProvider,
      'executers' => Executers::Dropdown(),
      'assigners' => Assigners::Dropdown(),
      // 'usertype'  => Yii::$app->user->identity->usertype, //для отображения нужных столбцов
      'user'  => Yii::$app->user->identity, //для отображения нужных столбцов
      'states'  => Missionitems::statesDropdown(),
      // 'assigner'  => Assigners::findOne(Yii::$app->user->identity->assignerid),
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
    $model->mission_date  = date('Y-m-d',time());
    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        $msg = 'Создана запись "'.$model->mission_name.'"';
        Yii::$app->session->setFlash('info', $msg);
        History::Log($msg,implode(',',$model->toArray()));
        return $this->redirect(['view', 'id' => $model->uid]);
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
    if (!in_array(Missions::getMissionstate($id),[STATE_ASSIGN])) { //Создание только для статуса ASSIGN!
      Yii::$app->session->setFlash('danger','Поручения закрыты для внесения изменений');
      return $this->redirect(['indexitems', 'id' => $id]);
    }
    if (Yii::$app->user->identity->assignerid == null) { //проверка на начличие кода куратора пользователя
      Yii::$app->session->setFlash('danger','В настройках пользователя не указан куратор поручений');
      return $this->redirect(['indexitems', 'id' => $id]);
    }
    // $model = new Missionitems(['scenario'=>'insert']);
    $model = new Missionitems();
    $model->missionuid = $id;
    $model->num_pp = 1;
    $model->assigneruid = Yii::$app->user->identity->assignerid;
    $model->created = date('Y-m-d G:i:s', time());
    $model->changed = date('Y-m-d G:i:s', time());
    $model->status = STATE_INWORK;
    if ($model->load(Yii::$app->request->post())) {
      if ($model->save()) {
        History::Log('Создан пункт поручений',implode('|',$model->toArray()));
        Yii::$app->session->setFlash('info', 'Создано пунктов поручений: '.count($template->executeruids));
        return $this->redirect(['indexitems', 'id' => $model->missionuid]);
      }
    } else {
      $model->assigner_name = Yii::$app->user->identity->username;
    }
    return $this->render('createitem', [
      'model' => $model,
      'missionuid'  => $id,
      'title' => $this->findModel($id)->mission_name,
      'executers'  => Executers::Dropdown(),
    ]);
  }

  //редактирование поручений
  public function actionUpdate($id)    {
    $model = $this->findModel($id);
    $model->changed = date('Y-m-d G:i:s', time());
    if ($model->load(Yii::$app->request->post()) && $model->save())  {
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
    //Добавление только если статус ФОРМИРОВАНИЕ
    if (!in_array(Missions::getMissionstate($model->missionuid),[STATE_ASSIGN])) {
    // if (Missions::getMissionstate($model->missionuid) == STATE_CLOSE) { //проверка на открытость поручений (старое)
      Yii::$app->session->setFlash('danger','Поручения закрыты для внесения изменений');
      // return $this->redirect(['indexitems', 'id' => $model->missionuid]);
      return $this->redirect(Yii::$app->request->referrer);
    }
    $model->changed = date('Y-m-d G:i:s', time());
    if ($model->load(Yii::$app->request->post()) && $model->save())  {
      History::log('Отредактирован пункт поручений',implode(', ',$model->toArray()));
      return $this->redirect(['viewitem', 'id' => $model->uid]);
    }
    return $this->render('updateitem', [
      'model' => $model,
      'executers'  => Executers::Dropdown(),
    ]);
  }

  //копирование поручений
  public function actionCopyitems($id=null)    {
    if ($id !== null){
      Missions::copy($id);
      return $this->redirect(Yii::$app->request->referrer);
    }
    // $model = new Missions();
    // if ($model->load(Yii::$app->request->post())) {
    //   return $this->redirect(Yii::$app->request->referrer);
    // }

    $searchModel = new MissionsSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    return $this->render('selectmission', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
      'states'  => Missions::statesDropdown(),
      // 'usertype'  => Yii::$app->user->identity->usertype, //для отображения нужных столбцов
    ]);
  }

  //редактирование отчета пункта поручений
  public function actionReportitem($id)    {
    $model = $this->findModelitem($id);
    //отчет только для статуса ОТЧЕТНОСТЬ
    // if (Missions::getMissionstate($model->missionuid) == STATE_CLOSE) { //проверка на открытость поручений
    if (!in_array(Missions::getMissionstate($model->missionuid),[STATE_REPORT])) {
      Yii::$app->session->setFlash('warning','Поручения закрыты для внесения изменений');
      return $this->redirect(Yii::$app->request->referrer);
    }
    $model->changed = date('Y-m-d G:i:s', time());
    if ($model->load(Yii::$app->request->post()) && $model->save())  {
      History::log('Отредактирован отчет по пункту поручений',implode(', ',$model->toArray()));
      return $this->redirect(['indexitems', 'id' => $model->missionuid]);
    }

    return $this->render('reportitem', [
      'model' => $model,
      // 'executers'  => Executers::Dropdown(),
    ]);
  }

  public function actionDelete($id)    {
    $model = $this->findModel($id);
    try{
      $model->delete();
      History::log('Удалены поручения: "'.$model->mission_name.'"',implode(', ',$model->toArray()));
      Yii::$app->session->setFlash('info','Запись удалена!');
      return $this->redirect(['index']);
    } catch (\Exception $e) {
      History::log('Ошибка удаления поручений! '.$model->name.' из БД',implode(', ',$model->toArray()));
      Yii::$app->session->setFlash('error','Удаление записи невозможно! Нарушение целостности данных! ');
      return $this->redirect(Yii::$app->request->referrer);
    }
  }

  public function actionDeleteitem($id)    {
    $model = $this->findModelitem($id);
     //Удалять только если статус ФОРМИРОВАНИЕ
     // if (Missions::getMissionstate($model->missionuid) == STATE_CLOSE) {
    if (!in_array(Missions::getMissionstate($model->missionuid),[STATE_ASSIGN])) {
      Yii::$app->session->setFlash('warning','Поручения закрыты для внесения изменений');
      // return $this->redirect(['indexitems', 'id' => $model->missionuid]);
      return $this->redirect(Yii::$app->request->referrer);
    }
    try{
      $model->delete();
      History::log('Удален пункт поручений с кодом '.$id,implode(', ',$model->toArray()));
      Yii::$app->session->setFlash('info','Запись удалена!');
      return $this->redirect(['indexitems','id' => $model->missionuid]);
    } catch (\Exception $e) {
      History::log('Ошибка удаления пункта поручения с кодом '.$id.' из БД',implode(', ',$model->toArray()));
      Yii::$app->session->setFlash('error','Удаление записи невозможно! Нарушение целостности данных! ');
      return $this->redirect(Yii::$app->request->referrer);
    }
  }

  protected function findModel($id)    {
    if (($model = Missions::findOne($id)) !== null) {
      return $model;
    }
    throw new NotFoundHttpException('Не найдена запись поручений');
  }

  protected function findModelitem($id)    {
    if (($model = Missionitems::findOne($id)) !== null) {
      return $model;
    }
    throw new NotFoundHttpException('Не найдена запись пункта поручений');
  }

}
