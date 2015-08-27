<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use app\components\rbac\GroupRule;
use yii\rbac\DbManager;

class RbacController extends Controller
{

    public function actionInit()
    {
        $auth = new DbManager;
        $auth->init();

        $auth->removeAll();
        $groupRule = new GroupRule();

        $auth->add($groupRule);

        $user = $auth->createRole('user');
        $user->description = 'User';
        $user->ruleName = $groupRule->name;
        $auth->add($user);

        $admin = $auth->createRole('admin');
        $admin->description = 'Admin';
        $admin->ruleName = $groupRule->name;
        $auth->add($admin);


        //permissions
        $viewUsers = $auth->createPermission('viewUsers');
        $viewUsers->description = 'View all users';
        $auth->add($viewUsers);

        $addInFavorite = $auth->createPermission('addInFavorite');
        $addInFavorite->description = 'Add song in favorite';
        $auth->add($addInFavorite);



        //children
        $auth->addChild($user, $addInFavorite);
        $auth->addChild($admin, $viewUsers);
        $auth->addChild($admin, $user);


        //assignments
        //$auth->assign($admin, Yii::$app->user->id);
        //$auth->assign($user, 2);
    }
}