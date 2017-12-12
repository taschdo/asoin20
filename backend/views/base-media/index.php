<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BaseMediaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'База СМИ | ' . Yii::$app->name;
$this->params['h1'] = Html::a('База СМИ',['base-media/index'], ['data-pjax' => 0]);
$this->params['breadcrumbs'][] = 'База СМИ';
?>
<div class="base-media-index">


    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-th" title="Таблица СМИ"></i>
            <h3 class="box-title">Таблица СМИ</h3>

            <div class="box-tools">
                <?= (\Yii::$app->user->can('moderator') ? Html::a('<span class="glyphicon glyphicon-plus"></span>', ['create'], ['class' => 'btn btn-success btn-sm', 'title' => 'Создать СМИ']) : ''); ?>
                <?= Html::a('<span class="glyphicon glyphicon-repeat"></span>', ['index'], ['class' => 'btn btn-default btn-sm', 'title' => 'Перезагрузить страницу']) ?>
            </div>
        </div>

        <div class="box-body table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'pjax'=>true,
        'pjaxSettings'=>[
            'options'=>['enablePushState'=>false],
        ],

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            \Yii::$app->user->can('base-media/editable') ?
                [
                    'class' => 'kartik\grid\EditableColumn',
                    'attribute' => 'name',
                    'editableOptions' => [
                        'asPopover' => TRUE,
                        'formOptions' => [ 'action' => ['editable'] ],
                    ]
                ] : [
                'attribute' => 'name',
                'headerOptions' => ['class' => 'text-center'],
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->name, ['base-media/view', 'id' => $model->id], ['data-pjax' => 0]);
                },
            ],

            \Yii::$app->user->can('base-media/editable') ?
                [
                    'class' => 'kartik\grid\EditableColumn',
                    'attribute' => 'phone',
                    'editableOptions' => [
                        'asPopover' => TRUE,
                        'formOptions' => ['action' => ['editable']],
                    ],
                ] : [
                'attribute' => 'phone',
                'format' => 'raw',
                'headerOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return '<a href="tel:'.$model->phone.'">'.$model->phone.'</a>';
                },
            ],

            [
                'class'=>'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'update' => function ($model, $key, $index) {
                        return \Yii::$app->user->can('base-media/update') ? true : false;
                    },
                    'delete' => function ($model, $key, $index) {
                        return \Yii::$app->user->can('base-media/delete') ? true : false;
                    },

                ]
            ],
        ],
    ]); ?>
        </div>
    </div>
</div>
