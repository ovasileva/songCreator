<?php
namespace app\components\rbac;
use Yii;
use yii\rbac\Rule;
use yii\helpers\ArrayHelper;
use app\models\Users;

class UserRoleRule extends Rule
{
    public $name = 'userRole';
    public function execute($user, $item, $params)
    {
        //Получаем массив пользователя из базы
        $user = ArrayHelper::getValue($params, 'user', Users::findOne($user));
        if ($user) {
            $role = $user->role; //Значение из поля role базы данных
            if ($item->name === 'admin') {
                return $role == Users::ROLE_ADMIN;
            } elseif ($item->name === 'moder') {
                //moder является потомком admin, который получает его права
                return $role == Users::ROLE_ADMIN || $role == Users::ROLE_MODER;
            }
            elseif ($item->name === 'user') {
                return $role == Users::ROLE_ADMIN || $role == Users::ROLE_MODER
                || $role == Users::ROLE_USER;
            }
        }
        return false;
    }
}