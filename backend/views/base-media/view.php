<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\BaseMedia */

$this->title = $model->name.' | ' . Yii::$app->name;
$this->params['h1'] = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'База СМИ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="base-media-view">

    <div class="box box-primary">

        <div class="box-body table-responsive">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'name',
            'phone',
        ],
    ]) ?>

    <br>

            <div class="form-group">
        <?= \Yii::$app->user->can('base-media/update') ? Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) : '' ?>
        <?= \Yii::$app->user->can('base-media/delete') ? Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить это СМИ?',
                'method' => 'post',
            ],
        ]) : '' ?>
            </div>

        </div>
    </div>

</div>
