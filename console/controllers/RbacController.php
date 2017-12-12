<?php
namespace console\controllers;
use Yii;
use yii\console\Controller;
use common\components\rbac\UserRoleRule;
class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll(); //удаляем старые данные
        //Включаем наш обработчик
        $rule = new UserRoleRule();
        $auth->add($rule);
        //Добавляем роли

        $junior = $auth->createRole('junior');
        $junior->description = 'Младший пользователь';
        $junior->ruleName = $rule->name;
        $auth->add($junior);

        $user = $auth->createRole('user');
        $user->description = 'Пользователь';
        $user->ruleName = $rule->name;
        $auth->add($user);
        $auth->addChild($user, $junior);

        $moderator = $auth->createRole('moderator');
        $moderator->description = 'Модератор';
        $moderator->ruleName = $rule->name;
        $auth->add($moderator);
        $auth->addChild($moderator, $user);

        $administrator = $auth->createRole('administrator');
        $administrator->description = 'Администратор';
        $administrator->ruleName = $rule->name;
        $auth->add($administrator);
        $auth->addChild($administrator, $moderator);

        $developer = $auth->createRole('developer');
        $developer->description = 'Разработчик';
        $developer->ruleName = $rule->name;
        $auth->add($developer);
        $auth->addChild($developer, $administrator);
    }
}