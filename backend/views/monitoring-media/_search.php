<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MonitoringMediaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="monitoring-media-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'url_media') ?>

    <?= $form->field($model, 'url_news') ?>

    <?= $form->field($model, 'unit_news_all') ?>

    <?php // echo $form->field($model, 'unit_news_one') ?>

    <?php // echo $form->field($model, 'unit_title') ?>

    <?php // echo $form->field($model, 'unit_text') ?>

    <?php // echo $form->field($model, 'unit_time') ?>

    <?php // echo $form->field($model, 'unit_date') ?>

    <?php // echo $form->field($model, 'unit_url') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'id_user') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
