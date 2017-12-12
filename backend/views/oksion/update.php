<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Oksion */

$this->title = 'Изменение данных ОКСИОН | ' . Yii::$app->name;
$this->params['h1'] = 'Изменение данных ОКСИОН: '.Html::a($model->id,['view','id'=>$model->id], ['data-pjax' => 0]);
$this->params['breadcrumbs'][] = ['label' => 'ОКСИОН', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="oksion-update">

    <div class="box box-primary">

        <div class="box-body table-responsive">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>

    </div>
</div>
