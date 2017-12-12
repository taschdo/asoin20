<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Subject;

/* @var $this yii\web\View */
/* @var $model backend\models\Subject */

$this->title = $model->name.' | ' . Yii::$app->name;
$this->params['h1'] = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Пресс-службы ТО', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="subject-view">

    <div class="box box-primary">

        <div class="box-body table-responsive">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'name',
            [
                'attribute'=>'id_parent',
                'value'=>function($data) {return $data->id_parent ? $data->idParent->abbreviation_regional_centre : $data->abbreviation_regional_centre; },
            ],

//            'name_region',
            [
                'attribute'=>'federal_district',
                'value'=>function($data) {return Subject::$categoryFederalDistrict[$data->federal_district]; },
            ],
            'contact',
            'ods',
        ],
    ]) ?>

            <?= \Yii::$app->user->can('moderator') ? '<br>' : '' ?>

            <div class="form-group">
                <?= \Yii::$app->user->can('moderator') ? Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) : '' ?>
                <?= \Yii::$app->user->can('administrator') ? Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить это СМИ?',
                        'method' => 'post',
                    ],
                ]) : '' ?>
            </div>

        </div>

</div>
