<?php

namespace app\controllers;

use Yii;
use \yii\data\ArrayDataProvider;
use app\models\Inifile;
use app\models\InifileSearch;
use app\models\Settings;
use app\models\History;
use app\models\Org;
use app\models\OrgSearch;
use app\models\Userlogons;
use app\models\UserlogonsSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

class SettingsController extends Controller {
  public function behaviors()  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'only' => ['update', 'index','view','logonsindex'],
        // 'formats' => ['application/json' => Response::FORMAT_JSON],
        'rules' => [
          [
            'allow' => true,
            'actions' => ['update', 'index','view','logonsindex'],
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
      ['section' =>'common',    'param' =>'orgname', 'description' =>'Наименование своей организации'     ,'visible'=>1],
      ['section' =>'committee', 'param' =>'s1f',     'description' =>'Ф.И.О. утверждающего акт ТО'     ,'visible'=>1],
      ['section' =>'committee', 'param' =>'s1p',     'description' =>'Должность утверждающего акт ТО'  ,'visible'=>1],
      ['section' =>'committee', 'param' =>'w1f',     'description' =>'Ф.И.О. 1го согласующего акт ТО'      ,'visible'=>1],
      ['section' =>'committee', 'param' =>'w1p',     'description' =>'Должность 1го согласующего акт ТО'   ,'visible'=>1],
      ['section' =>'committee', 'param' =>'w2f',     'description' =>'Ф.И.О. 2го согласующего акт ТО'      ,'visible'=>1],
      ['section' =>'committee', 'param' =>'w2p',     'description' =>'Должность 2го согласующего акт ТО'   ,'visible'=>1],
      //['section' =>'committee', 'param' =>'w3f', 'description' =>'Ф.И.О. исполнителя работ'      ,'visible'=>1],
      //['section' =>'committee', 'param' =>'w3p', 'description' =>'Должность исполнителя работ'   ,'visible'=>1],
      ['section' =>'committee', 'param' =>'dsc', 'description' =>'Текст акта выполненных работ по ТО'     ,'visible'=>1],
      ['section' =>'serviceact','param' =>'autonumber',  'description' =>'Автонумерация актов ТО (пусто - откл.)'   ,'visible'=>1],
      ['section' =>'serviceact','param' =>'contract',    'description' =>'Номер и дата договора на ремонт' ,'visible'=>1],
      ['section' =>'reports',   'param' =>'accountcharid',    'description' =>'Код характеристики бух.наименования ' ,'visible'=>1],
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
        History::log('SYSTEM','Добавлена настройка ('.$ini->section.'/'.$ini->param.')','');
      } else {
        $ini->description   = $param['description'];
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

  public static function generateChecksum($length = 8) {
    $characters = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $retString = '';
    for ($i = 0; $i < $length; $i++) {
      $retString .= $characters[rand(0, $charactersLength - 1)];
    }
    return STRTOUPPER($retString);
  }

  //проверки
  public function actionChecks()  {
    return $this->render('checks');
  }

  //Обработка внешнего запроса (API)
  public function actionProcesslogon($login,$username=null,$computername=null,$info=null)  {
    $model = new Userlogons(['scenario'=>'insert']);
    $model->login = $login;
    $model->username = mb_convert_encoding($username, "utf-8", "windows-1251");
    $model->computername = $computername;
    // $model->info = $info;
    $model->info = mb_convert_encoding($info, "utf-8", "windows-1251");
    $model->save();
    //History::log('SYSTEM','Пользователь '.$user.' выполнил вход в ПК','');
  }

  public function actionLogonsindex()  {
      $searchModel = new UserlogonsSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      return $this->render('logonsindex', [
        // 'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        // 'mode' => $mode, //SHOW HIDDEN
      ]);
  }

  public function actionViewuserlogin($id)  {
      $model = UserlogonsSearch::findOne($id);
      $info = $model->info;
      // $model->info = '{
      //   "os_caption":"Майкрософт Windows 10 Корпоративная LTSC",
      //   "os_status":"OK",
      //   "os_installdate":"20190805192549.000000 180",
      //    "os_buildnumber":"17763",
      //    "os_version":"10.0.17763",
      //    "pc_serial":"8CC9193F1F",
      //    "net_adapter_1":"[00000002] Intel(R) Ethernet Connection (7) I219-LM (10.195.70.170)",
      //    "net_adapter_2":"[00000015] VirtualBox Host-Only Ethernet Adapter (192.168.56.1)",
      //    "net_adapter_3":"[00000017] Hyper-V Virtual Ethernet Adapter (172.17.228.193)",
      //    "net_adapter_4":"",
      //    "net_adapter_5":"",
      //    "disk_drive_1":"NVMe SAMSUNG MZVLB256 SCSI Disk Device (0025_3884_9104_47A6.)",
      //    "disk_drive_2":"TOSHIBA MQ01ABD100M (48UUT8KAT)",
      //    "disk_drive_3":"",
      //    "disk_drive_4":"",
      //    "disk_drive_5":"",
      //    "user_login":"PavlovOB",
      //    "user_name":"Павлов Олег Борисович",
      //    "user_logontype":"2"
      //  }';
      // $info = OrgSearch::find()->asArray()->all();
      // $in
      // $info = \yii\helpers\ArrayHelper::toArray($model->info);

      // $info = unserialize($model->info);
      // $info = json_encode($model->info);
      // $info = \yii\helpers\Json::decode($model->info);
      // $model->info = str_replace('\'','"',$model->info);
      // $info = \yii\helpers\ArrayHelper::toArray($model->info,['app\models\Post' => ["os_caption"]]);
      // $info = \yii\helpers\ArrayHelper::toArray($model->info,['app\models\Post' => ["os_caption"]]);
      // $info = $model->info;
      $info = json_decode($info,TRUE);
      // $info = (array) $model->info;
      // $data =    ["os_caption"=>"Майкрософт Windows 10 Корпоративная LTSC",
      //             "os_status"=>"OK",
      //             "os_installdate"=>"20190805192549.000000 180",
      //             "os_buildnumber"=>"17763",
      //             "os_version"=>"10.0.17763",];
      // $data = ""{""osd"":
      //             {""os_caption"":""Майкрософт Windows 10 Корпоративная LTSC"",
      //             ""os_status"":""OK"",
      //             ""os_installdate"":""20190805192549.000000 180"",
      //             ""os_buildnumber"":""17763"",
      //             ""os_version"":""10.0.17763"",
      //           }}"";
      // $info = json_decode($model->info);
      // $ps = new  \yii\web\JsonParser();
      // $ps->throwException = FALSE;
      // $info = $ps->parse($data,true);
      // $dataProvider = new ArrayDataProvider([
      //     "allModels' => $info,
      // ]);
      // $info = array($model->info);
      // $keys = array_keys($info);
      return $this->render('viewuserlogin', [
        // 'dprovider' => $dataProvider,
        'model' => $model,
        // 'keys' => $keys,
        // 'data' => $data,
        'info'=> $info,
    ]);
  }



}
