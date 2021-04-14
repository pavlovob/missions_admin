<?php

namespace app\controllers;

use Yii;
use app\models\History;
use app\models\HistorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class HistoryController extends Controller
{
  /**
  * @inheritdoc
  */
  public function behaviors()
  {
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
            'actions' => ['view','index'],
            'roles' => ['@'],
          ],
        ],
      ],
    ];
  }

  public function actionIndex()
  {
    $searchModel = new HistorySearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    $dataProvider->pagination->pageSize=100;

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  public function actionView($id)
  {
    return $this->render('view', [
      'model' => $this->findModel($id),
    ]);
  }

  protected function findModel($id)
  {
    if (($model = History::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }


  // MOVED TO MODEL!!!
  // public static function log($passnum, $message, $content=NULL){
  //   if(($passnum!==null) && ($message!==null)){
  //     $model = new History();
  //     if (null !== Yii::$app->user->identity){
  //       $model->USERNAME = Yii::$app->user->identity->username;
  //     } else {
  //       $model->USERNAME = 'Не определен';
  //     }
  //     $model->PASSNUM = $passnum;
  //     //
  //     if (STRLEN($message) > 511){
  //       $model->DESCRIPTION = SUBSTR($message,1,511);
  //     } else {
  //       $model->DESCRIPTION = $message;
  //     }
  //     if (STRLEN($content) > 511){
  //       $model->RECORDCONTENT = $content = SUBSTR($content,1,511);
  //     } else {
  //       $model->RECORDCONTENT = $content;
  //     }
  //     $model->ACTIONDATETIME = date('Y-m-d G:i:s', time());
  //     // $model->RECORDCONTENT = SUBSTR($content,1,512);
  //
  //     //$model->COMPUTERNAME = 'Noname PC';
  //     $model->save();
  //   }
  // }

}
