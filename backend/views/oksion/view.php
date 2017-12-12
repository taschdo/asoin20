<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Oksion;
use common\models\Helpers;

/* @var $this yii\web\View */
/* @var $model backend\models\Oksion */

$this->title = 'Просмотр данных ОКСИОН | ' . Yii::$app->name;
$this->params['h1'] = 'ОКСИОН';
$this->params['breadcrumbs'][] = ['label' => 'ОКСИОН', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
?>
<div class="oksion-view">

    <div class="box box-primary">

        <div class="box-body table-responsive">


            <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
            <script type="text/javascript">

                ymaps.ready(init);
                var myMap;

                function init() {
                    myMap = new ymaps.Map("map", {
                        center: [<?php if ($model->geometry) echo $model->geometry; else echo '55.753994, 37.622093'; ?>],
                        zoom: 9
                    });

                    <?php if($model->geometry): ?>
                    myPlacemark = new ymaps.Placemark([<?=$model->geometry?>], {
                            hintContent: '<?=addslashes($model->address)?>',
                            balloonContent: 'Ваш ОКСИОН'
                        },
                        {
//                            draggable: true
                        });
                    myMap.geoObjects.add(myPlacemark);
                    <?php endif; ?>
                }

                function restart() {

                    ymaps.ready(init);

                    function init() {



                        // Поиск координат центра Нижнего Новгорода.
                        ymaps.geocode(document.getElementById('address').value, {
                            /**
                             * Опции запроса
                             * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/geocode.xml
                             */
                            // Сортировка результатов от центра окна карты.
                            // boundedBy: myMap.getBounds(),
                            // strictBounds: true,
                            // Вместе с опцией boundedBy будет искать строго внутри области, указанной в boundedBy.
                            // Если нужен только один результат, экономим трафик пользователей.
                            results: 1
                        }).then(function (res) {
                            // Выбираем первый результат геокодирования.
                            var firstGeoObject = res.geoObjects.get(0),
                            // Координаты геообъекта.
                                coords = firstGeoObject.geometry.getCoordinates(),
                                city = (firstGeoObject.getLocalities()!=0) ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                            // Область видимости геообъекта.
                                bounds = firstGeoObject.properties.get('boundedBy');

                            // Добавляем первый найденный геообъект на карту.

                            // Масштабируем карту на область видимости геообъекта.
                            myMap.setBounds(bounds, {
                                // Проверяем наличие тайлов на данном масштабе.
                                checkZoomRange: true
                            });

                            /**
                             * Все данные в виде javascript-объекта.
                             */
                            console.log('Все данные геообъекта: ', firstGeoObject.properties.getAll());
                            /**
                             * Метаданные запроса и ответа геокодера.
                             * @see https://api.yandex.ru/maps/doc/geocoder/desc/reference/GeocoderResponseMetaData.xml
                             */
                            console.log('Метаданные ответа геокодера: ', res.metaData);
                            /**
                             * Метаданные геокодера, возвращаемые для найденного объекта.
                             * @see https://api.yandex.ru/maps/doc/geocoder/desc/reference/GeocoderMetaData.xml
                             */
                            console.log('Метаданные геокодера: ', firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData'));
                            /**
                             * Точность ответа (precision) возвращается только для домов.
                             * @see https://api.yandex.ru/maps/doc/geocoder/desc/reference/precision.xml
                             */
                            console.log('precision', firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData.precision'));
                            /**
                             * Тип найденного объекта (kind).
                             * @see https://api.yandex.ru/maps/doc/geocoder/desc/reference/kind.xml
                             */
                            console.log('Тип геообъекта: %s', firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData.kind'));
                            console.log('Название объекта: %s', firstGeoObject.properties.get('name'));
                            console.log('Описание объекта: %s', firstGeoObject.properties.get('description'));
                            console.log('Полное описание объекта: %s', firstGeoObject.properties.get('text'));

                            /**
                             * Если нужно добавить по найденным геокодером координатам метку со своими стилями и контентом балуна, создаем новую метку по координатам найденной и добавляем ее на карту вместо найденной.
                             */
                            /**
                             var myPlacemark = new ymaps.Placemark(coords, {
             iconContent: 'моя метка',
             balloonContent: 'Содержимое балуна <strong>моей метки</strong>'
             }, {
             preset: 'islands#violetStretchyIcon'
             });

                             myMap.geoObjects.add(myPlacemark);
                             */

                            var myPlacemark = new ymaps.Placemark(coords, {
                                balloonContent: '<strong>Ваша точка</strong>: ' + coords
//                            balloonContentBody: coords
                            }, {
                                draggable: true
                            });

                            $('#geometry').val(coords);

                            $('#city').val(city);




                            myPlacemark.events.add('dragend', function (e) {

                                var target = e.get('target');

                                $('#geometry').val(target.geometry.getCoordinates());

                                target.properties.set('balloonContentBody', target.geometry.getCoordinates());


                            });

                            myMap.geoObjects.removeAll();
                            myMap.geoObjects.add(myPlacemark);
                            //  myPlacemark.geometry.getCoordinates();
                        });
                    }
                }
            </script>


                <div class="col-sm-7 oksion-view-map">
                    <div id="map" style="height:300px;"></div>
                </div>
                <div class="col-sm-5 oksion-view-map">
                    <div align="center"><img style="height:300px;" src="<?=(empty($model->avatar) ? '/admin/images/oksion/ava.jpg' : '/admin/'.$model->avatar)?>" class = "img-responsive"></div>
          </div>
            <div style="clear: both"></div>

            <br>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            [
                'attribute'=>'id_subject',
                'value'=>function($data) {return $data->subject->name; },
            ],
            [
                'attribute'=>'view',
                'value'=>function($data) {return Oksion::$view[$data->view].' ('.Helpers::arrayOksionType($data->type).')'; },
            ],
//            'city',
            'address',
            [
                'attribute'=>'working',
                'value'=>function($data) {return ($data->working ? 'Работает' : 'Не работает').(empty($data->date_malfunction && $data->reason) ? '' : ' ('.date('d-m-Y', $data->date_malfunction).', '.Oksion::$reason[$data->reason].')'); },
            ],
            [
                'attribute'=>'date_construction',
                'visible' => !empty($model->date_construction),
                'value'=>date('d-m-Y', $model->date_construction),
            ],
            [
                'attribute'=>'date_modernization',
                'visible' => !empty($model->date_modernization),
                'value'=>date('d-m-Y', $model->date_modernization),
            ],
            [
                'attribute'=>'date_purchase',
                'visible' => !empty($model->date_purchase),
                'value'=>date('d-m-Y', $model->date_purchase),
            ],
            [
                'attribute'=>'base',
                'visible' => !empty($model->base),
            ],
            [
                'attribute'=>'staffing',
                'visible' => !empty($model->staffing),
            ],
            [
                'attribute'=>'note',
                'visible' => !empty($model->note),
            ],
        ],
    ]) ?>

            <?= \Yii::$app->user->can('moderator') ? '<br>' : '' ?>

            <div class="form-group">
                <?= \Yii::$app->user->can('moderator') ? Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) : '' ?>
                <?= \Yii::$app->user->can('administrator') ? Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить этот ОКСИОН?',
                        'method' => 'post',
                    ],
                ]) : '' ?>
            </div>


    </div>
    </div>

</div>
