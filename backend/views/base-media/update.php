<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BaseMedia */

$this->title = 'Изменение СМИ: '.$model->name.' | ' . Yii::$app->name;
$this->params['h1'] = 'Изменение СМИ: '.Html::a($model->name,['view','id'=>$model->id], ['data-pjax' => 0]);
$this->params['breadcrumbs'][] = ['label' => 'База СМИ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="base-media-update">

    <div class="box box-primary">

        <div class="box-body table-responsive">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

        </div>
    </div>

</div>
