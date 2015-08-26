<?php
namespace app\components\rbac;

use Yii;
use yii\rbac\Rule;

class GroupRule extends Rule
{

    public $name = 'group';

    public function execute($user, $item, $params)
    {
        if (!Yii::$app->user->isGuest) {
            //$role = Yii::$app->user->identity->role;
            $role = array_keys(\Yii::$app->authManager->getRolesByUser($user))[0];

            if ($item->name === 'admin') {
                return $role === $item->name;
            } elseif ($item->name === 'user') {
                return $role === $item->name || $role === 'admin';
            }
        }
        return false;
    }
}