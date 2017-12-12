<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;

/**
 * CommonController - common controller.
 */
class CommonController extends Controller
{
    public function beforeAction($action)
    {
        Yii::$app->view->params['h1'];

        if(Yii::$app->user->isGuest){
            return parent::beforeAction($action);
        } else {
            Yii::$app->db->createCommand('Update asoin_profile SET last_visit = '.time().' where id_user=:id_user')
                ->bindValues([':id_user' => Yii::$app->user->id])->execute();
                return parent::beforeAction($action);
        }
    }
}
