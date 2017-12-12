<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\date\DatePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Личный состав | ' . Yii::$app->name;
$this->params['h1'] = Html::a('Личный состав',['profile/index'], ['data-pjax' => 0]);
$this->params['breadcrumbs'][] = 'Личный состав';
?>
<div class="profile-index">

    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-th" title="Таблица личного состава"></i>
            <h3 class="box-title">Таблица личного состава</h3>

            <div class="box-tools">
                <?= Html::a('<span class="glyphicon glyphicon-user"></span>', ['view','id'=>Yii::$app->user->id], ['class' => 'btn btn-success btn-sm', 'title' => 'Личный кабинет']) ?>
                <?= Html::a('<span class="glyphicon glyphicon-repeat"></span>', ['index'], ['class' => 'btn btn-default btn-sm', 'title' => 'Перезагрузить страницу']) ?>
            </div>

        </div>
        <!-- /.box-header -->
        <div class="box-body">

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'responsiveWrap' => false,
                'pjax'=>true,
                'pjaxSettings'=>[
                    'options'=>['enablePushState'=>false],
                ],
                'options'=>['style'=>'white-space: normal;'],
                'rowOptions'=>['class' => 'text-center'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//            'id_user',
//            'name',
//            'surname',
//            'middle_name',
                    [
                        'attribute'=>'avatars',
                        'label'=>'Ава',
                        'format' => 'raw',
                        'headerOptions' => ['class' => 'text-center'],
                        'filter'=>false,
                        'value' => function($model) {
                            return '<div class="my-class"><i class="fa fa-circle '. (($model->last_visit+3*60)<time() ? 'text-muted' : 'text-bright-green').'"></i></div>'.Html::a(Html::img($model->avatarUser,['class'=>'img-circle','title'=>$model->user->username,'alt'=>$model->user->username,'width' => '40px']),['profile/view', 'id' => $model->id_user], ['data-pjax' => 0]);
                        },
                    ],
                    [
                        'attribute'=>'fio',
                        'format' => 'raw',
                        'headerOptions' => ['class' => 'text-center'],
                        'value' => function($model) {
                            return Html::a($model->surname." ".$model->name." ".$model->middle_name, ['profile/view', 'id' => $model->id_user], ['data-pjax' => 0]);
                        },
                    ],
                    [
                        'attribute' => 'userName',
                        'headerOptions' => ['class' => 'text-center'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->user->username, ['profile/view', 'id' => $model->id_user], ['data-pjax' => 0]);
                        },
                    ],
                    [
                        'attribute' => 'userEmail',
                        'headerOptions' => ['class' => 'text-center'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::mailto($model->user->email, $model->user->email, ['data-pjax' => 0]);
                        },
                    ],
//                    [
//                        'attribute' => 'date_birth',
//                        'format' => ['date', 'php:d-m-Y'],
//                        'contentOptions' => ['class' => 'text-center'],
//                        'headerOptions' => ['class' => 'text-center']
//                    ],
                    [
                        'attribute' => 'date_birth',
                        'headerOptions' => ['class' => 'text-center'],
                        'format'=>['date', 'php:d-m-Y'],
                        'filter' => DatePicker::widget([
                            'attribute' => 'date_birth',
                            'model' => $searchModel,
                            'pluginOptions' => [
                                'todayHighlight' => true,
                                'format' => 'dd-mm-yyyy',
                            ]
                        ]),
                    ],
                    // 'avatar',
                    [
                        'attribute' => 'mobile_phone',
                        'format' => 'raw',
                        'headerOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            return '<a href="tel:'.$model->mobile_phone.'">'.$model->mobile_phone.'</a>';
                        },
                    ],
                    [
                        'attribute' => 'work_phone',
                        'format' => 'raw',
                        'headerOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            return '<a href="tel:'.$model->work_phone.'">'.$model->work_phone.'</a>';
                        },
                    ],
                    [
                        'attribute' => 'position',
                        'headerOptions' => ['class' => 'text-center'],
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}&nbsp;&nbsp;{permit}',
                        'headerOptions' => ['width' => Yii::$app->user->can('developer') ? '70' : '40','data-pjax'=>0],
                        'visibleButtons' => [
                            'view' => function ($model, $key, $index) {
                                return \Yii::$app->user->can('profile/view') ? true : false;
                            },
                            'permit' => function ($model, $key, $index) {
                                return \Yii::$app->user->can('developer') ? true : false;
                            },
                        ],
                        'buttons' =>
                            [
                                'permit' => function ($url, $model) {
                                    return Html::a('<span class="fa fa-lock"></span>', Url::to(['/permit/user/view', 'id' => $model->id_user]), [
                                        'title' => Yii::t('yii', 'Права доступа'),
//                                        'style'=>Yii::$app->user->can('developer') ? 'visibility: visible' : 'visibility: hidden',
//                                            Yii::$app->user->can('developer') ? true : false,
                                    ]); },
                            ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
