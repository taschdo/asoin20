<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Учеба | ' . Yii::$app->name;
$this->params['h1'] = Html::a('Учеба',['study/index'], ['data-pjax' => 0]);
$this->params['breadcrumbs'][] = 'Учеба';
?>
<div class="study-index">

    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="glyphicon glyphicon-education" title="Учеба"></i>
            <h3 class="box-title">Учеба</h3>

            <div class="box-tools">
                <?= Html::a('<span class="glyphicon glyphicon-repeat"></span>', ['index'], ['class' => 'btn btn-default btn-sm', 'title' => 'Перезагрузить страницу']) ?>
            </div>

        </div>
        <!-- /.box-header -->
        <div class="box-body">

                <div class="col-md-12">
                    <h4 class="h4">1. Обучающее видео по работе с АС ОИН:</h4>
                </div>

                <div class="col-md-6">
                    <iframe width="100%" height="300px" src="https://www.youtube.com/embed/Lf9SHCyBoPg" frameborder="0"
                            allowfullscreen></iframe>
                </div>

                <div class="col-md-6 max-width-992">
                    <dl>
                        <dt>Описание</dt>
                        <dd>Краткое обучающее видео о работе с АС ОИН.</dd>
                        <br>
                        <dt>Ссылка</dt>
                        <dd><a href="https://youtu.be/Lf9SHCyBoPg" target="_blank">Видео на YouTube</a></dd>
                    </dl>
                </div>



        </div>
    </div>
</div>
