<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\MonitoringMedia;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MonitoringMediaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Администраторская часть мониторинга СМИ | ' . Yii::$app->name;
$this->params['h1'] = Html::a('Администраторская часть',['monitoring-media/control'], ['data-pjax' => 0]);
$this->params['breadcrumbs'][] = ['label' => 'Мониторинг СМИ', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Администраторская часть';
?>
<div class="monitoring-media-index">

    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-th" title="Таблица СМИ для мониторинга"></i>
            <h3 class="box-title">Таблица СМИ для мониторинга</h3>

            <div class="box-tools">
                <?= (\Yii::$app->user->can('moderator') ? Html::a('<span class="glyphicon glyphicon-plus"></span>', ['create'], ['class' => 'btn btn-success btn-sm', 'title' => 'Создать СМИ для мониторинга']) : ''); ?>
                <?= (\Yii::$app->user->can('moderator') ? Html::a('<i class="fa fa-gear"></i>', ['cron'], ['class' => 'btn btn-warning btn-sm', 'title' => 'Cron']) : ''); ?>
                <?= Html::a('<span class="glyphicon glyphicon-repeat"></span>', ['control'], ['class' => 'btn btn-default btn-sm', 'title' => 'Перезагрузить страницу']) ?>
            </div>
        </div>

        <div class="box-body">

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

//            'id',
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($model) {
                    return $model->iconMedia.Html::a($model->name, ['view', 'id' => $model->id], ['data-pjax' => 0]);
                },
            ],
            [
                'attribute' => 'url_media',
                'format' => 'raw',
                'value' => function($data) {
                    return Html::a($data->url_media, $data->url_media, ['title' => $data->name, 'target' => '_blank','data-pjax' => 0]);
                }
            ],
            [
                'attribute' => 'url_news',
                'format' => 'raw',
                'value' => function($data) {
                    return Html::a($data->url_news, $data->url_news, ['title' => $data->name, 'target' => '_blank','data-pjax' => 0]);
                }
            ],
            [
                'attribute' => 'url_rss',
                'format' => 'raw',
                'value' => function($data) {
                    return Html::a($data->url_rss, $data->url_rss, ['title' => $data->name, 'target' => '_blank','data-pjax' => 0]);
                }
            ],
//            'unit_news_all',
            // 'unit_news_one',
            // 'unit_title',
            // 'unit_text',
            // 'unit_time',
            // 'unit_date',
            // 'unit_url:url',
            // 'created',
            // 'id_user',

            [
                'attribute' => 'active',
                'format'=>'html',
                'filter'=>MonitoringMedia::$error,
                'value'=>function($data) {
                    if(empty($data->active)) return '<small class="label bg-green">Активно <i>('. ( !empty($data->last_update_time) ? date("H:i:s d-m-Y",$data->last_update_time) : 'Новости еще не забирались' ).')</i></small></p>';
                    else return '<small class="label bg-red" title="'.MonitoringMedia::$error[$data->active].'">Не активно <i>('.date("H:i:s d-m-Y",$data->last_update_time).')</i></small><br><p style="font-size:10px;margin:5px 0px 0px 0px;"><i>('.MonitoringMedia::$error[$data->active].')</i></p>';
                },
                'contentOptions'=>['style'=>'text-align:center'],
            ],

            [
                'class'=>'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'view' => function ($model, $key, $index) {
                        return \Yii::$app->user->can('monitoring-media/view') ? true : false;
                    },
                    'update' => function ($model, $key, $index) {
                        return \Yii::$app->user->can('monitoring-media/update') ? true : false;
                    },
                    'delete' => function ($model, $key, $index) {
                        return \Yii::$app->user->can('monitoring-media/delete') ? true : false;
                    },

                ]
            ],
        ],
    ]); ?>
</div>
    </div>
</div>
