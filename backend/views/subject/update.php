<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Subject */

$this->title = 'Изменение данных пресс-службы: '.$model->name.' | ' . Yii::$app->name;
$this->params['h1'] = 'Изменение данных пресс-службы: '.Html::a($model->name,['view','id'=>$model->id], ['data-pjax' => 0]);
$this->params['breadcrumbs'][] = ['label' => 'Пресс-службы ТО', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="subject-update">

    <div class="box box-primary">

        <div class="box-body table-responsive">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

        </div>
    </div>

</div>
