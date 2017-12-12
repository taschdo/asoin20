<?php

namespace backend\controllers;

use Yii;
use backend\models\Oksion;
use backend\models\OksionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * OksionController implements the CRUD actions for Oksion model.
 */
class OksionController extends CommonController
{
    /**
     * @inheritdoc
     */
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
     * Lists all Oksion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OksionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Oksion model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

//        if ((!empty(Yii::$app->user->identity->id_subject) && $this->findModel($id)->id_subject==Yii::$app->user->identity->id_subject) or empty(Yii::$app->user->identity->id_subject)) {

        if($this->isOksion($id)) {
        return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

    }

    public function isOksion($id) {
        return ((!empty(Yii::$app->user->identity->id_subject) && $this->findModel($id)->id_subject==Yii::$app->user->identity->id_subject) or empty(Yii::$app->user->identity->id_subject)) ? true : false;
    }

    /**
     * Creates a new Oksion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Oksion();

        $model->working=1;

        if(!empty(Yii::$app->user->identity->id_subject)) $model->id_subject=Yii::$app->user->identity->id_subject;

        if ($model->load(Yii::$app->request->post())) {
            if($model->saveAvatar() && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
        else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Oksion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if($this->isOksion($id)) {
            $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->saveAvatar() && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
        else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Deletes an existing Oksion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($this->isOksion($id)) {
            $this->findModel($id)->delete();

        return $this->redirect(['index']);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the Oksion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Oksion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Oksion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
