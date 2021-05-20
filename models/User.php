<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface {
  public $authKey;
  public $accessToken;
  public $rememberMe;
  public $password; //Runtime var

  public function attributeLabels ()  {
    return [
      'uid'=>'Код',
      'login'=>'Логин',
      'password'=>'Пароль',
      'username'=>'Пользователь',
      'usertype'=>'Тип записи',
      'assignerid'  => 'Куратор от',
      'executerid'  => 'Исполнитель от',
      'password'=>'Пароль',
      'rememberMe'=>'Запомнить меня',
      'created'=>'Дата создания',
      'changed'=>'Дата изменения',
    ];
  }

  public function rules()  {
    return [
      [['login','password'], 'required', 'on' => 'login'],
      // [['login','username','password'], 'required', 'on' => 'insert'],
      //  [['username'], 'required', 'on' => 'insert','on' => 'login'],
      //  [['username', 'password'], 'required','on' => 'insert', 'on' => 'login'],
      ['login', 'unique', 'on' => 'insert'],
      // ['password', 'compare', 'compareAttribute' => 'password_check','on' => 'insert','on' => 'pwd_change'],
      //           ['username', 'match', 'pattern' => '~^[A-Za-z][A-Za-z0-9]+$~', 'message'=> 'Должны быть только буквы на английском и цифры!', 'on' => 'insert', 'on' => 'update', 'on' => 'login'],
      // ['rememberMe', 'boolean', 'on' => 'login'],
      // [['workeruid'], 'exist', 'skipOnError' => true, 'targetClass' => Workers::className(), 'targetAttribute' => ['workeruid' => 'UID'], 'on' => 'insert', 'on' => 'update'],
    ];
  }
  public function scenarios()  {
    return [
      'login' => ['login', 'password'],
      'insert' => ['login', 'username','usertype','assignerid','executerid','created','changed'],
      // 'insert' => ['username', 'password', 'password_check','workeruid'],
      // 'update' => ['username','workeruid'],
      // 'pwd_change' => ['password', 'password_check'],
      // 'register' => ['username'],
    ];
  }
  
  public function getUser()    {
    if ($this->_user === false) {
      $this->_user = User::findByUsername($this->username);
    }
    return $this->_user;
  }

  public static function findIdentity($id)    {
    // return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    return static::findOne($id);
  }

  public static function findIdentityByAccessToken($token, $type = null)    {
    foreach (self::$users as $user) {
      if ($user['accessToken'] === $token) {
        return new static($user);
      }
    }

    return null;
  }

  public static function findByUsername($username)    {
    foreach (self::$users as $user) {
      if (strcasecmp($user['username'], $username) === 0) {
        return new static($user);
      }
    }

    return null;
  }

  public function getId()    {
    return $this->uid;
  }

  public function getAuthKey()    {
    return $this->authKey;
  }

  public function validateAuthKey($authKey)    {
    return $this->authKey === $authKey;
  }

  public function validatePassword($password)    {
    return $this->password === $password;
  }

  public function loginOld()    {
    if ($this->validate()) {
      return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
    }
    return false;
  }

  //Кастомная логика
  public static function checkAdmin(){ // Если в БД пусто, добавить администратора
    if (User::find()->count() == 0){
      $user = new User(['scenario' => 'insert']);
      $user->login      = 'admin';
      $user->username   = 'Администратор';
      $user->usertype   = USERTYPE_ADMIN;
      $user->executerid = 0;
      $user->assignerid = 0;
      $user->created = date('Y-m-d G:i:s', time());
      $user->changed = date('Y-m-d G:i:s', time());
      $user->save();
      Yii::info('В справочник пользователей добавлена учетная запись администратора по умолчанию ');
    }
  }

  public static function login($model)    { //Логиним пользователя по LDAP или БД
    $error = null;
    if (\Yii::$app->params['domain_auth'] == true) { //если включена доменная аутентификация
      $LDAPDomain = \Yii::$app->params['domain_name'];
      //Using LDAP
      if (!Yii::$app->ad->auth()->attempt($LDAPDomain.'\\'.$model->login,$model->password))  return 'autherror';
      //Прошел. Достаем ФИО в модель
      $ADUser = Yii::$app->ad->search()->findBy('sAMAccountname', $model->login);
      if ($ADUser == null) return 'notusererror';
      $model->username = $ADUser['displayname'][0];
      if (!$ADUser->inGroup(Yii::$app->params['domain_group'])) return 'accesserror';
      // $error = 'Пользователю '.$model->fio.' отказано в доступе';
      // Yii::$app->session->setFlash('error', $error);
      // Yii::info($error);
      // return $this->render('login', ['model'=>$model]);

      //Если нет, добавляем пользователя в справочник
      $user = User::findOne(['login' => $model->login]);
      if($user==null){
        $user = new User(['scenario' => 'insert']);
        $user->login      = $model->login;
        $user->username   = $model->username;
        $user->usertype   = 0;
        $user->executerid = 0;
        $user->assignerid = 0;
        $user->created = date('Y-m-d G:i:s', time());
        $user->changed = date('Y-m-d G:i:s', time());
        $user->save();
        Yii::info('В справочник пользователей добавлена учетная запись '.$model->username);
      }
      $user = User::findOne(['login' => $model->login]);
      Yii::$app->user->login($user);
    } else {  //если нет доменной аутентификации
      $user = User::findOne(['login' => $model->login]);
      if($user == null){  //добавить проверку пароля по хэшу
        return 'accesserror'; //нет учетки
      } else {
        Yii::$app->user->login($user); //логин
      }
    }
    return $error;
  }




}
