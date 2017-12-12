<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\Cron;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CronSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cron | ' . Yii::$app->name;
$this->params['h1'] = Html::a('Cron',['monitoring-media/cron'], ['data-pjax' => 0]);
$this->params['breadcrumbs'][] = ['label' => 'Мониторинг СМИ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Администраторская часть', 'url' => ['control']];
$this->params['breadcrumbs'][] = 'Cron';
?>
<div class="monitoring-media-index">
     <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
            <i class="fa fa-th" title="Таблица работы Cron"></i>
            <h3 class="box-title">Таблица работы Cron</h3>
            <div class="box-tools">
                <?= Html::a('<span class="glyphicon glyphicon-repeat"></span>', ['cron'], ['class' => 'btn btn-default btn-sm', 'title' => 'Перезагрузить страницу']) ?>
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

                    'id',
                    [
                        'attribute' => 'time_begin',
                        'value' => function($model) {
                            return date("H:i:s d-m-Y",$model->time_begin);
                        },
                    ],
                    [
                        'attribute' => 'time_end',
                        'value' => function($model) {
                            return date("H:i:s d-m-Y",$model->time_end);
                        },
                    ],
                    [
                        'attribute' => 'time_run',
                        'value' => function($model) {
                            return date("i:s",$model->time_run);
                        },
                    ],
                    'number_unit',
                    'number_bd',


//                    ['class' => 'yii\grid\ActionColumn', 'template' => false],
                ],
            ]); ?>
        </div>
                </div>
            </div>
         <div class="col-md-4">
             <div class="box box-primary">
                 <div class="box-header with-border">
                     <i class="fa fa-database" title="Общие данные Cron"></i>
                     <h3 class="box-title">Общие данные Cron</h3>
                 </div>
                 <div class="box-body">

                     <?php echo 'Среднее время выполнения cron: <small class="label text-font-size-14 bg-green">'.date("i:s",Yii::$app->db->createCommand('SELECT AVG(time_run) FROM asoin_cron')->queryScalar()).'</small>';?>
                     <br><br>
                     <?php echo 'Максимальное время выполнения cron: <small class="label text-font-size-14 bg-red">'.date("i:s",Yii::$app->db->createCommand('SELECT MAX(time_run) FROM asoin_cron')->queryScalar()).'</small>';?>
                     <br><br>
                     <?php echo 'Среднее кол-во новостей напарсенных cron: <small class="label text-font-size-14 bg-green">'.round(Yii::$app->db->createCommand('SELECT AVG(number_unit) FROM asoin_cron')->queryScalar()).'</small>';?>
                     <br><br>
                     <?php echo 'Максимальное кол-во новостей напарсенных cron: <small class="label text-font-size-14 bg-red">'.Yii::$app->db->createCommand('SELECT MAX(number_unit) FROM asoin_cron')->queryScalar().'</small>';?>
                     <br><br>
                     <?php echo 'Размер БД: <small class="label text-font-size-14 bg-red">'. Cron::formatFileSize(Yii::$app->db->createCommand('SHOW TABLE STATUS')->queryAll()) .'</small>';?>


                 </div>
             </div>
         </div>
    </div>
</div>
