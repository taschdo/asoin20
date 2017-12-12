<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\BaseMedia */

$this->title = 'Создание СМИ | ' . Yii::$app->name;
$this->params['h1'] = Html::a('Создание СМИ',['base-media/create'], ['data-pjax' => 0]);
$this->params['breadcrumbs'][] = ['label' => 'База СМИ', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Создание СМИ';
?>
<div class="base-media-create">

    <div class="box box-primary">

        <div class="box-body table-responsive">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

        </div>

    </div>

</div>
