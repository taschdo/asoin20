<?php
namespace common\components\rbac;
use Yii;
use yii\rbac\Rule;
use yii\helpers\ArrayHelper;
use common\models\User;
class UserRoleRule extends Rule
{
    public $name = 'userRole';
    public function execute($user, $item, $params)
    {
        //Получаем массив пользователя из базы
        $user = ArrayHelper::getValue($params, 'user', User::findOne($user));
        if ($user) {
            $role = $user->role; //Значение из поля role базы данных
            if ($item->name === 'developer') {
                return $role == User::ROLE_DEVELOPER;
            } elseif ($item->name === 'administrator') {
                //moder является потомком admin, который получает его права
                return $role == User::ROLE_DEVELOPER || $role == User::ROLE_ADMINISTRATOR;
            }
            elseif ($item->name === 'moderator') {
                return $role == User::ROLE_DEVELOPER || $role == User::ROLE_ADMINISTRATOR || $role == User::ROLE_MODERATOR;
            }
            elseif ($item->name === 'user') {
                return $role == User::ROLE_DEVELOPER || $role == User::ROLE_ADMINISTRATOR || $role == User::ROLE_MODERATOR || $role == User::ROLE_USER;
            }
            elseif ($item->name === 'junior') {
                return $role == User::ROLE_DEVELOPER || $role == User::ROLE_ADMINISTRATOR || $role == User::ROLE_MODERATOR || $role == User::ROLE_USER || $role == User::ROLE_JUNIOR;
            }
        }
        return false;
    }
}