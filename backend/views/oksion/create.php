<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Oksion */

$this->title = 'Создание ОКСИОН | ' . Yii::$app->name;
$this->params['h1'] = Html::a('Создание ОКСИОН',['oksion/create'], ['data-pjax' => 0]);
$this->params['breadcrumbs'][] = ['label' => 'База ОКСИОН', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Создание ОКСИОН';
?>
<div class="oksion-create">

    <div class="box box-primary">

        <div class="box-body table-responsive">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>

    </div>
</div>
