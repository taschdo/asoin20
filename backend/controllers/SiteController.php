<?php
namespace backend\controllers;

use backend\models\Profile;
use common\models\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use GuzzleHttp\Client;

/**
 * Site controller
 */
class SiteController extends CommonController
{
    /**
     * @inheritdoc
     */
//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [
//                        'actions' => ['login', 'error'],
//                        'allow' => true,
//                    ],
//                    [
//                        'actions' => ['logout', 'index', 'about', 'main'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
//        ];
//    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
//         return [
//                'error' => [
//                    'class' => 'yii\web\ErrorAction',
//                ],
//        ];
    }



    /**
     * Displays homepage.
     *
     * @return string
     */
//    public function actionError()
//    {
//        return $this->render('error');
//    }

    public function actionMain()
    {
        $users = Profile::find()->limit(16)->all();

//        $client = new Client();
//        $res = $client->request('GET', 'http://www.interfax.ru/news/');
//
//        $body = $res->getBody();
//        $document = \phpQuery::newDocumentHTML($body,$charset = 'utf-8');
//        $news = $document->find(".an");

//        foreach ($news->find(".b-list__item-title") as $elem) {
//            $pq = pq($elem);
//            $pq->find('.b-list__item-img')->remove();
//        }

        return $this->render('main',[
            'users' => $users,
//            'body' => $news,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('/admin/main');
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('/admin/main');
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionError()
    {
        if (Yii::$app->user->isGuest) { //return $this->redirect('login');
            return Yii::$app->getResponse()->redirect('/admin')->send();
        }

        $exception = Yii::$app->errorHandler->exception;
        $statusCode = $exception->statusCode;
        $name = $exception->getName();
        $message = $exception->getMessage();
        return $this->render('error', [
            'exception' => $exception,
            'statusCode' => $statusCode,
            'name' => $name,
            'message' => $message
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
