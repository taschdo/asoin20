<?php

namespace backend\controllers;

use backend\models\Cron;
use backend\models\CronSearch;
use Yii;
use backend\models\MonitoringMedia;
use backend\models\MonitoringMediaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use GuzzleHttp\Client;
use yii\filters\AccessControl;
use backend\models\MonitoringNews;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

/**
 * MonitoringMediaController implements the CRUD actions for MonitoringMedia model.
 */
class MonitoringMediaController extends CommonController
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

    public function actionCron()
    {
        $searchModel = new CronSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('cron', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex()
    {
        $query=MonitoringNews::find();

        if(Yii::$app->request->isGet or Yii::$app->request->isPjax) {

            if(Yii::$app->request->get('source')) $query->andFilterWhere(['id_media' => Yii::$app->request->get('source')]);

            if(Yii::$app->request->get('from_date') or Yii::$app->request->get('to_date')) $query->andFilterWhere(['between', 'date_publication', strtotime(Yii::$app->request->get('from_date')), strtotime(Yii::$app->request->get('to_date'))]);

            if(Yii::$app->request->get('string'))
                $query->andFilterWhere(['or',
                    ['like','title',Yii::$app->request->get('string')],
                    ['like','description',Yii::$app->request->get('string')],
                    ['like','text',Yii::$app->request->get('string')]]);
        }

        $dataProviderMonitoringNews = new ActiveDataProvider([
            'query' => $query->orderBy('date_publication DESC'),
            'pagination' => [
                'pageParam'=>'page-news',
                'pageSize' => 30,
            ],
        ]);

        return $this->render('index',[
            'dataProviderMonitoringNews'=>$dataProviderMonitoringNews,
            'source'=>Yii::$app->request->get('source'),
            'from_date'=>Yii::$app->request->get('from_date'),
            'to_date'=>Yii::$app->request->get('to_date'),
            'string'=>Yii::$app->request->get('string'),
        ]);
    }

    public function actionMchs()
    {

        $query=MonitoringNews::find()->where(['label_mchs'=>2]);

//        foreach(MonitoringMedia::$tags as $tag) {
//            $query->orWhere(['or',
//                ['like','title',$tag],
//                ['like','description',$tag],
//                ['like','text',$tag],
//            ]);
//        }

        if(Yii::$app->request->isGet or Yii::$app->request->isPjax) {

            if(Yii::$app->request->get('source')) $query->andFilterWhere(['id_media' => Yii::$app->request->get('source')]);

            if(Yii::$app->request->get('from_date') or Yii::$app->request->get('to_date')) $query->andFilterWhere(['between', 'date_publication', strtotime(Yii::$app->request->get('from_date')), strtotime(Yii::$app->request->get('to_date'))]);

            if(Yii::$app->request->get('string'))
                $query->andFilterWhere(['or',
                    ['like','title',Yii::$app->request->get('string')],
                    ['like','description',Yii::$app->request->get('string')],
                    ['like','text',Yii::$app->request->get('string')]]);
        }



        $dataProviderMonitoringNews = new ActiveDataProvider([
            'query' => $query->orderBy('date_publication DESC'),
            'pagination' => [
                'pageParam'=>'page-news',
                'pageSize' => 30,
            ],
        ]);

        return $this->render('mchs',[
            'dataProviderMonitoringNews'=>$dataProviderMonitoringNews,
            'source'=>Yii::$app->request->get('source'),
            'from_date'=>Yii::$app->request->get('from_date'),
            'to_date'=>Yii::$app->request->get('to_date'),
            'string'=>Yii::$app->request->get('string'),
        ]);
    }

//    public function actionGuideMchs()
//    {
//
//        $query=MonitoringNews::find();
//
//        $query->where(['and',
//            [   'or',
//                ['or like', 'title', MonitoringMedia::$tags],
//                ['or like', 'description', MonitoringMedia::$tags],
//                ['or like', 'text', MonitoringMedia::$tags],
//            ],
//            [
//                'or',
//                ['or like', 'title', MonitoringMedia::$guideTags],
//                ['or like', 'description', MonitoringMedia::$guideTags],
//                ['or like', 'text', MonitoringMedia::$guideTags],
//            ]
//        ]);
//
//        if(Yii::$app->request->isGet or Yii::$app->request->isPjax) {
//
//            if(Yii::$app->request->get('source')) $query->andFilterWhere(['id_media' => Yii::$app->request->get('source')]);
//
//            if(Yii::$app->request->get('from_date') or Yii::$app->request->get('to_date')) $query->andFilterWhere(['between', 'date_publication', strtotime(Yii::$app->request->get('from_date')), strtotime(Yii::$app->request->get('to_date'))]);
//
//            if(Yii::$app->request->get('string'))
//                $query->andFilterWhere(['or',
//                    ['like','title',Yii::$app->request->get('string')],
//                    ['like','description',Yii::$app->request->get('string')],
//                    ['like','text',Yii::$app->request->get('string')]]);
//        }
//
//
//
//        $dataProviderMonitoringNews = new ActiveDataProvider([
//            'query' => $query->orderBy('date_publication DESC'),
//            'pagination' => [
//                'pageParam'=>'page-news',
//                'pageSize' => 30,
//            ],
//        ]);
//
//        return $this->render('guide-mchs',[
//            'dataProviderMonitoringNews'=>$dataProviderMonitoringNews,
//            'source'=>Yii::$app->request->get('source'),
//            'from_date'=>Yii::$app->request->get('from_date'),
//            'to_date'=>Yii::$app->request->get('to_date'),
//            'string'=>Yii::$app->request->get('string'),
//        ]);
//    }

//    public function actionPositiveMchs()
//    {
//
//        $query=MonitoringNews::find();
//
//        $query->where(['and',
//            [   'or',
//                ['or like', 'title', MonitoringMedia::$tags],
//                ['or like', 'description', MonitoringMedia::$tags],
//                ['or like', 'text', MonitoringMedia::$tags],
//            ],
//            [
//                'or',
//                ['or like', 'title', MonitoringMedia::$positiveTags],
//                ['or like', 'description', MonitoringMedia::$positiveTags],
//                ['or like', 'text', MonitoringMedia::$positiveTags],
//            ]
//        ]);
//
//        if(Yii::$app->request->isGet or Yii::$app->request->isPjax) {
//
//            if(Yii::$app->request->get('source')) $query->andFilterWhere(['id_media' => Yii::$app->request->get('source')]);
//
//            if(Yii::$app->request->get('from_date') or Yii::$app->request->get('to_date')) $query->andFilterWhere(['between', 'date_publication', strtotime(Yii::$app->request->get('from_date')), strtotime(Yii::$app->request->get('to_date'))]);
//
//            if(Yii::$app->request->get('string'))
//                $query->andFilterWhere(['or',
//                    ['like','title',Yii::$app->request->get('string')],
//                    ['like','description',Yii::$app->request->get('string')],
//                    ['like','text',Yii::$app->request->get('string')]]);
//        }
//
//
//
//        $dataProviderMonitoringNews = new ActiveDataProvider([
//            'query' => $query->orderBy('date_publication DESC'),
//            'pagination' => [
//                'pageParam'=>'page-news',
//                'pageSize' => 30,
//            ],
//        ]);
//
//        return $this->render('positive-mchs',[
//            'dataProviderMonitoringNews'=>$dataProviderMonitoringNews,
//            'source'=>Yii::$app->request->get('source'),
//            'from_date'=>Yii::$app->request->get('from_date'),
//            'to_date'=>Yii::$app->request->get('to_date'),
//            'string'=>Yii::$app->request->get('string'),
//        ]);
//    }

    public function actionNegativeMchs()
    {

        $query=MonitoringNews::find()->where(['label_mchs'=>2,'label_negative'=>2]);

//        $query->where(['and',
//            [   'or',
//                ['or like', 'title', MonitoringMedia::$negativeMandatoryTags],
//                ['or like', 'description', MonitoringMedia::$negativeMandatoryTags],
//                ['or like', 'text', MonitoringMedia::$negativeMandatoryTags],
//            ],
//            [
//                'or',
//                ['or like', 'title', MonitoringMedia::$negativeTags],
//                ['or like', 'description', MonitoringMedia::$negativeTags],
//                ['or like', 'text', MonitoringMedia::$negativeTags],
//            ]
//        ]);

        if(Yii::$app->request->isGet or Yii::$app->request->isPjax) {

            if(Yii::$app->request->get('source')) $query->andFilterWhere(['id_media' => Yii::$app->request->get('source')]);

            if(Yii::$app->request->get('from_date') or Yii::$app->request->get('to_date')) $query->andFilterWhere(['between', 'date_publication', strtotime(Yii::$app->request->get('from_date')), strtotime(Yii::$app->request->get('to_date'))]);

            if(Yii::$app->request->get('string'))
                $query->andFilterWhere(['or',
                    ['like','title',Yii::$app->request->get('string')],
                    ['like','description',Yii::$app->request->get('string')],
                    ['like','text',Yii::$app->request->get('string')]]);
        }



        $dataProviderMonitoringNews = new ActiveDataProvider([
            'query' => $query->orderBy('date_publication DESC'),
            'pagination' => [
                'pageParam'=>'page-news',
                'pageSize' => 30,
            ],
        ]);

        return $this->render('negative-mchs',[
            'dataProviderMonitoringNews'=>$dataProviderMonitoringNews,
            'source'=>Yii::$app->request->get('source'),
            'from_date'=>Yii::$app->request->get('from_date'),
            'to_date'=>Yii::$app->request->get('to_date'),
            'string'=>Yii::$app->request->get('string'),
        ]);
    }

    /**
     * Lists all MonitoringMedia models.
     * @return mixed
     */
    public function actionControl()
    {
        $searchModel = new MonitoringMediaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('control', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MonitoringMedia model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MonitoringMedia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MonitoringMedia();

        if ($model->load(Yii::$app->request->post())) {

            $imageName = substr(md5(microtime() . rand(0, 9999)), 0, 20);
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file->extension != null) {
                $model->file->saveAs('images/media/' . $imageName . '.' . $model->file->extension);
                // Сохранение в БД URLа аватарки
                $model->avatar = 'images/media/' . $imageName . '.' . $model->file->extension;
            }

            $model->created=time();
            $model->id_user=Yii::$app->user->id;

            if ($model->save()) return $this->redirect(['view', 'id' => $model->id]);
            else return $this->render('create', [
                'model' => $model,
            ]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MonitoringMedia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $imageName = $model->id;
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file->extension != null) {
                $model->file->saveAs('images/media/' . $imageName . '.' . $model->file->extension);
                unlink($model->avatar);
                // Сохранение в БД URLа аватарки
                $model->avatar = 'images/media/' . $imageName . '.' . $model->file->extension;
            }

            if($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MonitoringMedia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model=$this->findModel($id);
        unlink($model->avatar);
        $model->delete();

        return $this->redirect(['control']);
    }

    /**
     * Finds the MonitoringMedia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MonitoringMedia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MonitoringMedia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
