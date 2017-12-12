<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use backend\models\Oksion;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Oksion */
/* @var $form yii\widgets\ActiveForm */
?>

<script type="text/javascript">
    function showOrHide(working, reason) {
        working = document.getElementById(working);
        reason = document.getElementById(reason);
        if (working.checked) {
            reason.style.display = "none";
        }
        else {
            reason.style.display = "block";
        }
    }

    function showOrHideOksion(type, oksion, mkion) {
        type = document.getElementById(type);
        oksion = document.getElementById(oksion);
        mkion = document.getElementById(mkion);
        if (type.options[type.selectedIndex].value==1 || type.options[type.selectedIndex].value==2) {
            oksion.style.display = "block";
            mkion.style.display = "none";
        }
        else {
            oksion.style.display = "none";
            mkion.style.display = "block";
        }
    }
</script>

<div class="oksion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    if(empty(Yii::$app->user->identity->id_subject))
    echo $form->field($model, 'id_subject')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(\backend\models\Subject::find()
            ->where(['not',['id_parent'=>NULL]])
            ->orWhere(['abbreviation_regional_centre'=>'Москва'])
            ->all(), 'id', 'name'),
        'language' => 'ru-RU',
        'theme' => Select2::THEME_DEFAULT,
        'options' => ['placeholder' => 'Введите субъект ...', 'style'=>'padding: 5px 0 5px 10px;'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'type')->dropDownList(Oksion::$type,['prompt' => 'Выберите тип...','id' => 'type', 'onchange' => 'showOrHideOksion("type", "oksion", "mkion");']); ?>

    <?= $form->field($model, 'file')->fileInput()->label('Выберите фотографию') ?>

      <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'id' => 'address', 'onchange'=>"restart(); return false"]) ?>

        <script src="//api-maps.yandex.ru/2.1/?lang=ru_RU&load=SuggestView&onload=onLoad"></script>
        <script>
            function onLoad(ymaps) {
                var suggestView = new ymaps.SuggestView('address');
            }
        </script>

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
                        draggable: true
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

    <div id="map" style="width:100%; height:300px"></div>
    <br>

    <div id="oksion" style="width: 100%; <?= ($model->view==1) ? 'display:block;' : 'display:none;' ?>">
    <?= $form->field($model, 'date_construction')->widget(DatePicker::className(), [
        'options' => ['value' => $model->date_construction ? date('d-m-Y', $model->date_construction) : null],
        'pluginOptions' => [
            'format' => 'dd-mm-yyyy',
            'autoclose' => true,
            'todayHighlight' => true,
            'weekStart' => 1,
        ],
    ]); ?>

    <?= $form->field($model, 'date_modernization')->widget(DatePicker::className(), [
        'options' => ['value' => $model->date_modernization ? date('d-m-Y', $model->date_modernization) : null],
        'pluginOptions' => [
            'format' => 'dd-mm-yyyy',
            'autoclose' => true,
            'todayHighlight' => true,
            'weekStart' => 1,
        ],
    ]); ?>

    </div>

    <div id="mkion" style="width: 100%; <?= ($model->view==2) ? 'display:block;' : 'display:none;' ?>">
        <?= $form->field($model, 'date_purchase')->widget(DatePicker::className(), [
            'options' => ['value' => $model->date_purchase ? date('d-m-Y', $model->date_purchase) : null],
            'pluginOptions' => [
                'format' => 'dd-mm-yyyy',
                'autoclose' => true,
                'todayHighlight' => true,
                'weekStart' => 1,
            ],
        ]); ?>

        <?= $form->field($model, 'base')->textInput() ?>

        <?= $form->field($model, 'staffing')->textInput() ?>
    </div>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true, 'id' => 'city'])->label('Город *') ?>

    <?= $form->field($model, 'geometry')->textInput(['id'=>'geometry','readonly' => true])->label('Координаты *') ?>

<!--    --><?php //if(empty($model->working)) $model->working=1; ?>

    <?= $form->field($model, 'working')->checkbox(['id' => 'working', 'onchange' => 'showOrHide("working", "reason");']) ?>



    <div id="reason" style="width: 100%; <?= ($model->reason) ? 'display:block;' : 'display:none;' ?>">
        <?= $form->field($model, 'reason')->dropDownList(Oksion::$reason); ?>

        <?= $form->field($model, 'date_malfunction')->widget(DatePicker::className(), [
            'options' => ['value' => $model->date_malfunction ? date('d-m-Y', $model->date_malfunction) : null],
            'pluginOptions' => [
                'format' => 'dd-mm-yyyy',
                'autoclose' => true,
                'todayHighlight' => true,
                'weekStart' => 1,
            ],
        ]); ?>
    </div>

    <?= $form->field($model, 'note')->textarea(['id'=>'no-resize-vertical']) ?>

    <p><i>* - поля которые заполняются автоматически, после заполнения поля "Адрес".
        Поле "Город" возможно изменить при неправильном определении.
        Поле "Координаты" изменению не поддается.</i></p><br>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
