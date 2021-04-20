<?php

namespace app\controllers;

use Yii;
// use \yii\data\ArrayDataProvider;
use app\models\Inifile;
use app\models\InifileSearch;
// use app\models\Settings;
use app\models\History;
// use app\models\Org;
// use app\models\OrgSearch;
// use app\models\Userlogons;
// use app\models\UserlogonsSearch;

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
    $this->checkIntegrity();

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
      History::log('SYSTEM','Отредактирована настройка ('.$model->section.'/'.$model->param.') на '.$model->value,'');
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
      History::log('SYSTEM','Удалена настройка ('.$model->section.'/'.$model->param.')','');
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

  public function checkIntegrity()  {
    $params = [
      // ['section' =>'common',    'param' =>'orgname', 'description' =>'Наименование своей организации'     ,'visible'=>1],
      ['section' =>'committee', 'param' =>'s1f',     'description' =>'Ф.И.О. утверждающего поручения'     ,'visible'=>1],
      ['section' =>'committee', 'param' =>'s1p',     'description' =>'Должность утверждающего поручения'  ,'visible'=>1],
      // ['section' =>'committee', 'param' =>'w1f',     'description' =>'Ф.И.О. 1го согласующего акт ТО'      ,'visible'=>1],
      // ['section' =>'committee', 'param' =>'w1p',     'description' =>'Должность 1го согласующего акт ТО'   ,'visible'=>1],
      // ['section' =>'committee', 'param' =>'w2f',     'description' =>'Ф.И.О. 2го согласующего акт ТО'      ,'visible'=>1],
      // ['section' =>'committee', 'param' =>'w2p',     'description' =>'Должность 2го согласующего акт ТО'   ,'visible'=>1],
      //['section' =>'committee', 'param' =>'w3f', 'description' =>'Ф.И.О. исполнителя работ'      ,'visible'=>1],
      //['section' =>'committee', 'param' =>'w3p', 'description' =>'Должность исполнителя работ'   ,'visible'=>1],
      // ['section' =>'committee', 'param' =>'dsc', 'description' =>'Текст акта выполненных работ по ТО'     ,'visible'=>1],
      // ['section' =>'serviceact','param' =>'autonumber',  'description' =>'Автонумерация актов ТО (пусто - откл.)'   ,'visible'=>1],
      // ['section' =>'serviceact','param' =>'contract',    'description' =>'Номер и дата договора на ремонт' ,'visible'=>1],
      // ['section' =>'reports',   'param' =>'accountcharid',    'description' =>'Код характеристики бух.наименования ' ,'visible'=>1],
    ];

    foreach($params as $param)    {
      $ini = Inifile::findOne(['section'=>$param['section'],'param'=>$param['param']]);
      if (null == $ini)
      {
        $ini = new Inifile();
        $ini->section     = $param['section'];
        $ini->param       = $param['param'];
        $ini->description = $param['description'];
        $ini->visible     = $param['visible'];
        $ini->value       = '';
        $ini->save();
        History::log('Добавлена настройка ('.$ini->section.'/'.$ini->param.')');
        $ini->description   = $param['description'];
      } else {
        $ini->visible       = $param['visible'];
        $ini->save();
      }
    }
  }

  public static function getIni($section,$param){
    $retval = 'Значение не задано';
    if ((null !== $section) && (null !== $param)){
      $ini = Inifile::findOne(['section'=>$section,'param'=>$param]);
      if (null !== $ini){
        $retval = $ini->value;
      }
    }
    return $retval;
  }

  public static function putIni($section,$param,$value){
    $description = 'Внутренняя переменная ПО';
    $ini = Inifile::findOne(['section'=>$section,'param'=>$param]);
    if (null == $ini){
      $ini = new Inifile();
      $ini->section     = $section;
      $ini->param       = $param;
      $ini->value       = $value;
      $ini->description = $description;
      $ini->visible     = 0;
      $ini->save();
    } else {
      $ini->value       = $value;
      $ini->description = $description;
      $ini->visible     = 0;
      $ini->save();
    }
  }

}
