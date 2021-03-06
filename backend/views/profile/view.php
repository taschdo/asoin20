<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Profile */


$this->title = 'Личная страница пользователя: ' . $model->user->username . ' | ' . Yii::$app->name;
$this->params['h1'] = 'Личная страница пользователя: ' . $model->user->username;
$this->params['breadcrumbs'][] = 'Личная страница пользователя: ' . $model->user->username;
?>


<div class="profile-view">

    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">

                    <?= (Html::img(empty($model->avatar) ? '/admin/images/users/original/ava.jpg' : '/admin/' . $model->avatar, ['class' => 'profile-user-img img-responsive img-circle', 'title' => $model->user->username, 'alt' => $model->user->username])) ?>

                    <div class="main-my"><span class="labels"><i class="fa fa-circle <?=($model->last_visit+3*60)<time() ? 'text-muted' : 'text-bright-green'?>"></i> <?=($model->last_visit+3*60)<time() ? 'Offline' : 'Online'?></span></div>

                    <h3 class="profile-username text-center">
                        <?= (empty($model->name) && empty($model->surname) ? $model->user->username : $model->name . ' ' . $model->surname) ?>
                    </h3>

                    <p class="text-muted text-center">
                        <?= (empty($model->position) ? 'Сотрудник МЧС России' : $model->position) ?>
                    </p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Средняя оценка</b> <a class="pull-right">4,5</a>
                        </li>
                        <li class="list-group-item">
                            <b>Средняя оценка</b> <a class="pull-right">4,5</a>
                        </li>
                        <li class="list-group-item">
                            <b>Средняя оценка</b> <a class="pull-right">4,5</a>
                        </li>
                    </ul>

                    <a href="<?= Yii::$app->getHomeUrl() ?>" class="btn btn-primary btn-block">На главную</a>
                </div>
            </div>

        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Личная информация</a>
                    </li>
                    <li class=""><a href="#params1" data-toggle="tab" aria-expanded="false">Личные параметры 1</a></li>
                    <li class=""><a href="#params2" data-toggle="tab" aria-expanded="false">Личные параметры 1</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="activity">

                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'name',
                                'surname',
                                'middle_name',
                                [
                                    'attribute' => 'userEmail',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return Html::mailto($model->user->email, $model->user->email, ['data-pjax' => 0]);
                                    },
                                ],
                                [
                                    'attribute' => 'date_birth',
                                    'value' => function ($model) {
                                        return empty($model->date_birth) ? 'Не задано' : date('d-m-Y',$model->date_birth).' ( возраст - '.$model->age.')';
                                    },
                                ],
                                [
                                    'attribute' => 'mobile_phone',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return '<a href="tel:'.$model->mobile_phone.'">'.$model->mobile_phone.'</a>';
                                    },
                                ],
                                [
                                    'attribute' => 'work_phone',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return '<a href="tel:'.$model->work_phone.'">'.$model->work_phone.'</a>';
                                    },
                                ],
                                'position',
                            ],
                        ]) ?>

                    </div>

                    <div class="tab-pane" id="params1">
                        <p>
                            Например ЧС, происшествия или мероприятия созданные им!
                        </p>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="params2">
                        <p>
                            Что-нибудь еще!
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
