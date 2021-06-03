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
  public $password_check; //runtime for pass check

  public static function tableName()  {
    return 'user';
  }

  public function attributeLabels ()  {
    return [
      'uid'           => 'Код',
      'login'         => 'Логин',
      'password'      => 'Пароль',
      'password_check'=> 'Проверка',
      'password_hash' => 'Пароль',
      'username'      => 'Ф.И.О.',
      'usertype'      => 'Тип записи',
      'assignerid'    => 'Куратор от',
      'executerid'    => 'Исполнитель от',
      'rememberMe'    => 'Запомнить меня',
      'created'       => 'Дата создания',
      'changed'       => 'Дата изменения',
    ];
  }

  public function rules()  {
    return [
      [['login','password'], 'required', 'on' => 'login'],
      [['login','username','password','password_check','usertype'], 'required', 'on' => 'insert'],
      ['login', 'unique', 'on' => 'insert'],
      // [['password_check','password'], 'safe'],
      ['password', 'compare', 'compareAttribute' => 'password_check','on' => ['insert','pwd_change']  ],
      ['login', 'match', 'pattern' => '~^[A-Za-z][A-Za-z0-9]+$~', 'message'=> 'Должны быть только буквы на английском и цифры!', 'on' => ['insert','update']],
      ['rememberMe', 'boolean', 'on' => 'login'],
      // [['workeruid'], 'exist', 'skipOnError' => true, 'targetClass' => Workers::className(), 'targetAttribute' => ['workeruid' => 'UID'], 'on' => 'insert', 'on' => 'update'],
    ];
  }

  public function scenarios()  {
    return [
      'login'  => ['login', 'password'],
      'insert' => ['login','username','password','password_check','usertype','assignerid','executerid'],
      'update' => ['login','username','usertype','assignerid','executerid'],
      'pwd_change' => ['password', 'password_check'],
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

  public function getAssigner()  {
    return $this->hasOne(Assigners::className(), ['uid' => 'assignerid']);
  }
  public function getExecuter()  {
    return $this->hasOne(Executers::className(), ['uid' => 'executerid']);
  }

  //Добавление админа по умолчанию если справочник пуст admin/admin
  public static function checkAdmin(){ // Если в БД пусто, добавить администратора
    if (User::find()->count() == 0){
      $user                 = new User(['scenario' => 'insert']);
      $user->login          = 'admin';
      $user->username       = 'Администратор';
      $user->password       = 'admin';
      $user->password_hash  = Yii::$app->getSecurity()->generatePasswordHash($user->password);
      $user->usertype       = USERTYPE_ADMIN;
      $user->executerid     = null;
      $user->assignerid     = null;
      $user->created        = date('Y-m-d G:i:s', time());
      $user->changed        = date('Y-m-d G:i:s', time());
      $user->save();
      History::log('В справочник пользователей добавлена учетная администратора по умолчанию');
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

      $user = User::findOne(['login' => $model->login]); //Если нет, добавляем пользователя в справочник
      if($user == null){
        $user             = new User(['scenario' => 'insert']);
        $user->login      = $model->login;
        $user->username   = $model->username;
        $user->password   = $model->password;
        $user->password_check = $user->password;
        $user->password_hash  = Yii::$app->getSecurity()->generatePasswordHash($user->password);
        $user->usertype   = USERTYPE_BLOCKED; //по умолчанию при создании запись в БД заблокирована
        $user->executerid = null;
        $user->assignerid = null;
        $user->created = date('Y-m-d G:i:s', time());
        $user->changed = date('Y-m-d G:i:s', time());
        $user->save();
        History::log('В справочник пользователей добавлена учетная запись',implode(';',$user->toArray()));
      }
      // $user = User::findOne(['login' => $model->login]);
      //Проверка на статус записи в БД
      if ($user->usertype == USERTYPE_BLOCKED) return 'accesserror'; //если заблокировано в БД - ошибка
      //логиним пользователя
      Yii::$app->user->login($user);
    }  else { //если нет доменной аутентификации
      $user = User::findOne(['login' => $model->login]);
      if ($user == null || !Yii::$app->getSecurity()->validatePassword($model->password, $user->password_hash)) {  //добавить проверку пароля по хэшу
        return 'autherror'; //нет учетки
      } else {
        if ($user->usertype == USERTYPE_BLOCKED) return 'accesserror'; //Если заблокирована
        Yii::$app->user->login($user); //логин
      }
    }
    return $error;
  }

  //Возвращает массив ролей пользователей. роли фиксированы
  public static function typesDropdown(){
    return  [
      // USERTYPE_NONE     =>'Не задан',
      USERTYPE_BLOCKED  =>'Заблокирован',
      USERTYPE_ASSIGNER =>'Куратор',
      USERTYPE_EXECUTER =>'Исполнитель',
      USERTYPE_ADMIN    =>'Администратор',
    ];
  }

  public static function userTypeName($id){
    $arr  = self::typesDropdown();
    return (array_key_exists($id,$arr)) ? $arr[$id] : 'Не задан';
    // return $id;
  }

}
