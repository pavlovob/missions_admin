<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {

      $auth = Yii::$app->authManager;

      $rule = new \app\rbac\UserGroupRule;
      $auth->add($rule);

      $assigner = $auth->createRole('ASSIGNER');
      $assigner->ruleName = $rule->name;
      $auth->add($assigner);
      // ... add permissions as children of $author ...

      $executer = $auth->createRole('EXECUTER');
      $executer->ruleName = $rule->name;
      $auth->add($executer);

      $admin = $auth->createRole('ADMIN');
      $admin->ruleName = $rule->name;
      $auth->add($admin);
      // ... add permissions as children of $admin ...

        // $auth = Yii::$app->authManager;
        //
        // // добавляем разрешение "createPost"
        // $createPost = $auth->createPermission('createPost');
        // $createPost->description = 'Create a post';
        // $auth->add($createPost);
        //
        // // добавляем разрешение "updatePost"
        // $updatePost = $auth->createPermission('updatePost');
        // $updatePost->description = 'Update post';
        // $auth->add($updatePost);
        //
        // // добавляем роль "author" и даём роли разрешение "createPost"
        // $author = $auth->createRole('author');
        // $auth->add($author);
        // $auth->addChild($author, $createPost);
        //
        // // добавляем роль "admin" и даём роли разрешение "updatePost"
        // // а также все разрешения роли "author"
        // $admin = $auth->createRole('admin');
        // $auth->add($admin);
        // $auth->addChild($admin, $updatePost);
        // $auth->addChild($admin, $author);
        //
        // // Назначение ролей пользователям. 1 и 2 это IDs возвращаемые IdentityInterface::getId()
        // // обычно реализуемый в модели User.
        // $auth->assign($author, 2);
        // $auth->assign($admin, 1);
    }
}
