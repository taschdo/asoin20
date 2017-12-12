<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\Subject;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SubjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пресс-службы ТО | ' . Yii::$app->name;
$this->params['h1'] = Html::a('Пресс-службы ТО',['subject/index'], ['data-pjax' => 0]);
$this->params['breadcrumbs'][] = 'Пресс-службы ТО';
?>
<div class="subject-index">

    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-th" title="Таблица пресс-служб ТО"></i>
            <h3 class="box-title">Таблица пресс-служб ТО</h3>

            <div class="box-tools">
                <?= Html::a('<span class="glyphicon glyphicon-repeat"></span>', ['index'], ['class' => 'btn btn-default btn-sm', 'title' => 'Перезагрузить страницу']) ?>
            </div>
        </div>


        <div class="box-body table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options'=>['style'=>'white-space: normal;'],
        'responsiveWrap' => false,
        'pjax'=>true,
        'pjaxSettings'=>[
            'options'=>['enablePushState'=>false],
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'name',
                'headerOptions' => ['class' => 'text-center'],
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->name, ['subject/view', 'id' => $model->id], ['data-pjax' => 0]);
                },
            ],
            [
                'attribute'=>'id_parent',
                'filter'=>ArrayHelper::map(Subject::find()->where(['id_parent'=>NULL])->asArray()->all(), 'id', 'abbreviation_regional_centre'),
                'value'=>function($data) {return $data->id_parent ? $data->idParent->abbreviation_regional_centre : $data->abbreviation_regional_centre; },
            ],
            [
                'attribute'=>'federal_district',
                'filter'=>Subject::$categoryFederalDistrict,
                'value'=>function($data) {return Subject::$categoryFederalDistrict[$data->federal_district]; },
            ],
             [
                 'attribute'=>'contact',

             ],
             [
                 'attribute'=>'ods',

             ],

            [
                'class'=>'yii\grid\ActionColumn',
                'options'=>['style'=>'width:70px;'],
                'visibleButtons' => [
                    'view' => function ($model, $key, $index) {
                        return \Yii::$app->user->can('subject/view') ? true : false;
                    },
                    'update' => function ($model, $key, $index) {
                        return \Yii::$app->user->can('subject/update') ? true : false;
                    },
                    'delete' => function ($model, $key, $index) {
                        return \Yii::$app->user->can('subject/delete') ? true : false;
                    },

                ]
            ],

        ],


        'rowOptions' => function ($model) {
            if($model->id_parent==NULL) return ['style'=>'background:#8dd5fe'];
            return false;
        }
    ]); ?>
        </div>
    </div>
</div>
