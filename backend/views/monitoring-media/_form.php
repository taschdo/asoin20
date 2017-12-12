<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MonitoringMedia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="monitoring-media-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'file')->fileInput()->label('Выберите логотип') ?>

    <?= $form->field($model, 'url_media')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'encoding')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url_news')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url_rss')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unit_news_all')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unit_news_one')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unit_remove')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unit_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unit_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unit_text')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unit_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unit_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

<!--    --><?//= $form->field($model, 'created')->textInput() ?>

<!--    --><?//= $form->field($model, 'id_user')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
