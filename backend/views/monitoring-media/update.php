<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MonitoringMedia */

$this->title = 'Изменение мониторинга ИА: '.$model->name.' | ' . Yii::$app->name;
$this->params['h1'] = 'Изменение мониторинга ИА: '.Html::a($model->name,['view','id'=>$model->id], ['data-pjax' => 0]);
$this->params['breadcrumbs'][] = ['label' => 'Мониторинг СМИ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Администраторская часть', 'url' => ['control']];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="monitoring-media-update">

    <div class="box box-primary">

        <div class="box-body table-responsive">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
    </div>
