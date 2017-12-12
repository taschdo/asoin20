<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MonitoringMedia */

$this->title = 'Создать СМИ | ' . Yii::$app->name;
$this->params['h1'] = Html::a('Создание СМИ',['base-media/create'], ['data-pjax' => 0]);
$this->params['breadcrumbs'][] = ['label' => 'Мониторинг СМИ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Администраторская часть', 'url' => ['control']];
$this->params['breadcrumbs'][] = 'Создать СМИ';
?>
<div class="monitoring-media-create">

    <div class="box box-primary">

        <div class="box-body table-responsive">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
