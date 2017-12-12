<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\Oksion;
use common\models\Helpers;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\models\Subject;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OksionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ОКСИОН | ' . Yii::$app->name;
$this->params['h1'] = Html::a('ОКСИОН',['oksion/index'], ['data-pjax' => 0]);
$this->params['breadcrumbs'][] = 'ОКСИОН';
?>
<div class="oksion-index">

    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-th" title="Таблица ОКСИОН"></i>
            <h3 class="box-title">Карта ОКСИОН</h3>

            <div class="box-tools">
                <?= (\Yii::$app->user->can('moderator') ? Html::a('<span class="glyphicon glyphicon-plus"></span>', ['create'], ['class' => 'btn btn-success btn-sm', 'title' => 'Создать ОКСИОН']) : ''); ?>
                <?= Html::a('<span class="glyphicon glyphicon-repeat"></span>', ['index'], ['class' => 'btn btn-default btn-sm', 'title' => 'Перезагрузить страницу']) ?>
            </div>
        </div>

        <div class="box-body table-responsive">

<?php \yii\widgets\Pjax::begin(); ?>


            <div id="map" style="width:100%; height:500px"></div>
            <br>

            <?php
            $gridColumns = [
                ['class' => 'kartik\grid\SerialColumn'],

                [
                    'attribute' => 'id_subject',
                    'visible' => empty(Yii::$app->user->identity->id_subject) ? true : false,
                    'filterType'=>GridView::FILTER_SELECT2,
                    'filter'=>ArrayHelper::map(Subject::find()
                        ->where(['not',['id_parent'=>NULL]])
                        ->orWhere(['abbreviation_regional_centre'=>'Москва'])
                        ->all(), 'id', 'name'),
                    'filterWidgetOptions'=>[
                        'pluginOptions'=>['allowClear'=>true],
                    ],
                    'filterInputOptions'=>['placeholder'=>'Выберите субъект...'],
                    'value' => function ($model) {
                        return $model->subject->name;
                    },
                ],

                'city',
                'address',

                [
                    'attribute'=>'view',
                    'filter'=>Oksion::$view,
                    'value'=>function($data) {return Oksion::$view[$data->view]; },
                ],
                [
                    'attribute'=>'type',
                    'filter'=>Oksion::$type,
                    'value'=>function($data) {
                        $arrOut = [];
                        foreach(Oksion::$type as $subArr){
                            foreach($subArr as $key => $val){
                                if(isset($arrOut[$key]) && $arrOut[$key] > $val) continue;
                                $arrOut[$key] = $val;
                            }
                        }
                        return $arrOut[$data->type];
                    },
                ],
                [
                    'attribute'=>'working',
                    'format'=>'html',
                    'filter'=>Oksion::$working,
                    'value'=>function($data) {
                        if($data->working) return '<small class="label bg-green">Работает</small></p>';
                        else return '<small class="label bg-red">Не работает</small></p>';
                    },
                ],
//                     'note',
                [
                    'attribute'=>'reason',
                    'filter'=>Oksion::$reason,
                    'value'=>function($data) {return Oksion::$reason[$data->reason]; },
                ],

                [
                    'class' => 'kartik\grid\ActionColumn',
                    'visibleButtons' => [
                        'view' => function ($model, $key, $index) {
                            return \Yii::$app->user->can('oksion/view') ? true : false;
                        },
                        'update' => function ($model, $key, $index) {
                            return \Yii::$app->user->can('oksion/update') ? true : false;
                        },
                        'delete' => function ($model, $key, $index) {
                            return \Yii::$app->user->can('oksion/delete') ? true : false;
                        },

                    ],
                    'headerOptions' => ['width' => '70'],
                ],
            ];

            $gridColumnsExport = [
                ['class' => 'kartik\grid\SerialColumn'],

                [
                    'attribute' => 'id_subject',
                    'filterType'=>GridView::FILTER_SELECT2,
                    'filter'=>ArrayHelper::map(Subject::find()
                        ->where(['not',['id_parent'=>NULL]])
                        ->orWhere(['abbreviation_regional_centre'=>'Москва'])
                        ->all(), 'id', 'name'),
                    'filterWidgetOptions'=>[
                        'pluginOptions'=>['allowClear'=>true],
                    ],
                    'filterInputOptions'=>['placeholder'=>'Выберите субъект...'],
                    'value' => function ($model) {
                        return $model->subject->name;
                    },
                ],

                'city',
                'address',

                [
                    'attribute'=>'view',
                    'filter'=>Oksion::$view,
                    'value'=>function($data) {return Oksion::$view[$data->view]; },
                ],
                [
                    'attribute'=>'type',
                    'filter'=>Oksion::$type,
                    'value'=>function($data) {
                        $arrOut = [];
                        foreach(Oksion::$type as $subArr){
                            foreach($subArr as $key => $val){
                                if(isset($arrOut[$key]) && $arrOut[$key] > $val) continue;
                                $arrOut[$key] = $val;
                            }
                        }
                        return $arrOut[$data->type];
                    },
                ],
                [
                    'attribute'=>'working',
                    'format'=>'html',
                    'filter'=>Oksion::$working,
                    'value'=>function($data) {
                        if($data->working) return '<small class="label bg-green">Работает</small></p>';
                        else return '<small class="label bg-red">Не работает</small></p>';
                    },
                ],
                [
                    'attribute'=>'date_malfunction',
                    'format'=>['date', 'php:d-m-Y'],
                ],
                [
                    'attribute'=>'reason',
                    'filter'=>Oksion::$reason,
                    'value'=>function($data) {return Oksion::$reason[$data->reason]; },
                ],
                [
                    'attribute'=>'date_construction',
                    'format'=>['date', 'php:d-m-Y'],
                ],
                [
                    'attribute'=>'date_modernization',
                    'format'=>['date', 'php:d-m-Y'],
                ],
                [
                    'attribute'=>'date_purchase',
                    'format'=>['date', 'php:d-m-Y'],
                ],
                'base',
                'staffing',
                'note',
            ];


            $fullExportMenu = ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
                'columns' => $gridColumnsExport,
                'target' => ExportMenu::TARGET_BLANK,
                'fontAwesome' => true,
                'styleOptions'=>    [
                    ExportMenu::FORMAT_EXCEL => [
                        'font' => [
                            'bold' => true,
                            'color' => [
                                'argb' => '00000000',
                            ],
                        ],
                        'fill' => [
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => [
                                'argb' => 'FFFFFFFF',
                            ],
                        ],
                    ],
                    ExportMenu::FORMAT_EXCEL_X => [
                        'font' => [
                            'bold' => true,
                            'color' => [
                                'argb' => '00000000',
                            ],
                        ],
                        'fill' => [
                            'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
                            'startcolor' => [
                                'argb' => 'FFFFFFFF',
                            ],
                            'endcolor' => [
                                'argb' => 'FFFFFFFF',
                            ],
                        ],
                    ],
                ],
                'pjaxContainerId' => 'kv-pjax-container',
                'dropdownOptions' => [
                    'label' => 'Экспорт',
                    'class' => 'btn btn-default',
                    'itemsBefore' => [
                        '<li class="dropdown-header">Экспорт всех данных</li>',
                    ],
                ],
            ]);

            ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
                'options'=>['style'=>'white-space: normal;'],
                'containerOptions'=>['style'=>'padding:10px;'],
                'tableOptions'=>['style'=>'border:1px solid #ccc;'],
                'responsiveWrap' => false,
//                'showPageSummary' => true,
//                'pjax' => true,
//                'pjaxSettings' => [
//                    'options' => ['id' => 'kv-pjax-container'],
//                ],
                'panel' => [
                    'type' => GridView::TYPE_DEFAULT,
                    'heading' => '<h4 class="box-title"><i class="fa fa-th" title="Таблица ОКСИОН"></i> Таблица ОКСИОН</h4>',
//                    'footer'=>true,
                    'after'=>false,
                ],

                // set a label for default menu
                'export' => [
                    'label' => Yii::t('kvgrid', 'Page'),
                    'fontAwesome' => true,
                ],

                // your toolbar can include the additional full export menu
                'toolbar' => [
                    '{export}',
                    '{toggleData}',
                    $fullExportMenu,
                    ['content'=>
                        Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['data-pjax'=>0, 'type'=>'button', 'title'=>Yii::t('kvgrid', 'Создать ОКСИОН'), 'class'=>'btn btn-success']) . ' '.
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>Yii::t('kvgrid', 'Перезагрузить страницу')])
                    ],
                ],
                'toggleDataOptions'=>    [
                    'all' => [
                        'icon' => 'resize-full',
                        'label' => Yii::t('kvgrid', 'All'),
                        'class' => 'btn btn-default',
                        'title' => 'Show all data'
                    ],
                    'page' => [
                        'icon' => 'resize-small',
                        'label' => Yii::t('kvgrid', 'Page'),
                        'class' => 'btn btn-default',
                        'title' => 'Show first page data'
                    ],
                ],
            ]); ?>

            <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
            <script type="text/javascript">
                ymaps.ready(function () {
                    var myMap = new ymaps.Map('map', {
                            center: [55.76, 37.64],
                            zoom: 10
                        }, {
                            searchControlProvider: 'yandex#search'
                        }),
                        /**
                         * Создадим кластеризатор, вызвав функцию-конструктор.
                         * Список всех опций доступен в документации.
                         * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/Clusterer.xml#constructor-summary
                         */
                        clusterer = new ymaps.Clusterer({
                            /**
                             * Через кластеризатор можно указать только стили кластеров,
                             * стили для меток нужно назначать каждой метке отдельно.
                             * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/option.presetStorage.xml
                             */
                            preset: 'islands#invertedBlueClusterIcons',
                            /**
                             * Ставим true, если хотим кластеризовать только точки с одинаковыми координатами.
                             */
                            groupByCoordinates: false,
                            /**
                             * Опции кластеров указываем в кластеризаторе с префиксом "cluster".
                             * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/ClusterPlacemark.xml
                             */
                            clusterDisableClickZoom: true,
                            clusterHideIconOnBalloonOpen: false,
                            geoObjectHideIconOnBalloonOpen: false
                        }),
                        /**
                         * Функция возвращает объект, содержащий данные метки.
                         * Поле данных clusterCaption будет отображено в списке геообъектов в балуне кластера.
                         * Поле balloonContentBody - источник данных для контента балуна.
                         * Оба поля поддерживают HTML-разметку.
                         * Список полей данных, которые используют стандартные макеты содержимого иконки метки
                         * и балуна геообъектов, можно посмотреть в документации.
                         * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/GeoObject.xml
                         */
                        getPointData = function (index1, index2, index3, index4, index5, index6, index7, index8, index9, index10, index11, index12) {
                            return {
                                balloonContentBody: '<div align="center" style="margin-bottom: 10px;"><img width="50%" src=' + index3 + '><br>' +
                                index12 + '</div>' + index1 + index2 + index4 + index5 + index6 + index7 + index8 + index9 + index10 + index11,
                                clusterCaption: '<strong>' + index4 + '</strong>',
                                style: "default#redSmallPoint"
                            };
                        },
                        /**
                         * Функция возвращает объект, содержащий опции метки.
                         * Все опции, которые поддерживают геообъекты, можно посмотреть в документации.
                         * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/GeoObject.xml
                         */
                        getPointOptions = function (index1, index2) {
                            if(index1==1) {
                                if(index2==1) return { preset: 'islands#blueVideoIcon' };
                                else return { preset: 'islands#redVideoIcon' };
                            }
                            if(index1==2) {
                                if(index2==1) return { preset: 'islands#blueDeliveryIcon' };
                                else return { preset: 'islands#redDeliveryIcon' };
                            }
                        },

                        geoObjects = [];

                    /**
                     * Данные передаются вторым параметром в конструктор метки, опции - третьим.
                     * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/Placemark.xml#constructor-summary
                     */
                    <?php
                    //                    $events = Event::find()->all();

                    $i=0;
                    foreach($dataProvider->getModels() as $item):
                    ?>
                    geoObjects[<?=$i?>] = new ymaps.Placemark([<?=$item->geometry?>],
                        getPointData('<b>Субъект: </b> <?=$item->subject->name?><br>',
                            '<b>Вид: </b><?=Oksion::$view[$item->view]?> (<?=Helpers::arrayOksionType($item->type)?>)<br>',
                            '<?=empty($item->avatar) ? 'images/oksion/ava.jpg' : $item->avatar?>',
                            '<b>Адрес: </b><?=addslashes($item->address)?><br>',
                            '<b>Работоспособность: </b><?=($item->working) ? 'Работает' : '<span style="color:red">Не работает</span>'?><?=empty($item->date_malfunction && $item->reason) ? '' : ' ('.date('d-m-Y', $item->date_malfunction).', '.Oksion::$reason[$item->reason].')'?> <br>',
                            '<?=empty($item->date_construction) ? '' : '<b>Дата постройки: </b>'.date("d-m-Y", $item->date_construction).'<br>'?>',
                            '<?=empty($item->date_modernization) ? '' : '<b>Дата модернизации: </b>'.date("d-m-Y", $item->date_modernization).'<br>'?>',
                            '<?=empty($item->date_purchase) ? '' : '<b>Дата приобритения: </b>'.date("d-m-Y", $item->date_purchase).'<br>'?>',
                            '<?=empty($item->base) ? '' : '<b>Базовое шасси: </b>'.$item->base.'<br>'?>',
                            '<?=empty($item->staffing) ? '' : '<b>Укомплектованность: </b>'.$item->staffing.'<br>'?>',
                            '<?=empty($item->note) ? '' : '<b>Примечание: </b>'.$item->note?>',
                            '<?= Html::a('<b>Карточка</b>',['oksion/view','id'=>$item->id],['data-pjax'=>0]) ?>',
                        ),
                        getPointOptions('<?=$item->view?>','<?=$item->working?>'));
                    <?php $i++; endforeach; ?>

                    /**
                     * Можно менять опции кластеризатора после создания.
                     */
                    clusterer.options.set({
                        gridSize: 80,
                        clusterDisableClickZoom: true
                    });

                    /**
                     * В кластеризатор можно добавить javascript-массив меток (не геоколлекцию) или одну метку.
                     * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/Clusterer.xml#add
                     */
                    clusterer.add(geoObjects);
                    myMap.geoObjects.add(clusterer);

                    /**
                     * Спозиционируем карту так, чтобы на ней были видны все объекты.
                     */

                    myMap.setBounds(clusterer.getBounds(), {
                        checkZoomRange: true
                    });
                });
            </script>

            <?php \yii\widgets\Pjax::end(); ?>
        </div>
    </div>
</div>
