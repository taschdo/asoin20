<?php

use yii\helpers\Html;
use backend\models\MonitoringMedia;
use yii\widgets\ListView;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Мониторинг СМИ | ' . Yii::$app->name;
$this->params['h1'] = Html::a('Мониторинг СМИ',['monitoring-media/index'], ['data-pjax' => 0]);
$this->params['breadcrumbs'][] = 'Мониторинг СМИ';
?>
<div class="study-index">

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <i class="fa fa-desktop" title="Лента новостей"></i>
                            <h3 class="box-title">Лента новостей - <i>НЕГАТИВ</i></h3>
                            <div class="pull-right box-tools with-border">
                                <?= Html::a('<span class="glyphicon glyphicon-wrench"></span>', ['control'], ['class' => 'btn btn-success btn-sm', 'title' => 'Администраторская часть']) ?>
                                <?= Html::a('<span class="glyphicon glyphicon-repeat"></span>', ['index'], ['class' => 'btn btn-default btn-sm', 'title' => 'Перезагрузить страницу']) ?>
                                <button class="btn btn-box-tool" type="button" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <button class="btn btn-box-tool" type="button" data-widget="remove">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                    <div class="tab-content">

                        <?php
//                                $text = "В этом тексте МЧСник есть нужное взрыве";
//                                preg_match("/(слово|мчс|ололо)/iu", $text, $match);
//                                if($match[1]) echo 'Да';
//                                else echo 'Нет';
                        ?>

                        <script type="text/javascript">
                            function diplay_hide_search (blockId)
                            {
                                if ($(blockId).css('display') == 'none') {
                                    $(blockId).animate({height: 'show'}, 500);
                                    $("#button_search").removeClass('bg-aqua').addClass('bg-blue');
                                    $("#icon_search").removeClass('fa-angle-double-down').addClass('fa-angle-double-up');
                                }
                                else {
                                    $(blockId).animate({height: 'hide'}, 500);
                                    $("#button_search").removeClass('bg-blue').addClass('bg-aqua');
                                    $("#icon_search").removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
                                }
                            }
                        </script>

                        <script type="text/javascript">
                            function diplay_hide_text (blockId,smallId)
                            {
                                if ($(blockId).css('display') == 'none') {
                                    $(blockId).animate({height: 'show'}, 500);
                                    $(smallId).removeClass('bg-aqua').addClass('bg-primary').text('Краткий текст');
                                }
                                else {
                                    $(blockId).animate({height: 'hide'}, 500);
                                    $(smallId).removeClass('bg-primary').addClass('bg-aqua').text('Полный текст');
                                }
                            }
                        </script>


                        <?=Html::a('Картина дня',['index'],['class'=>'btn bg-'.(Yii::$app->controller->action->id=='index'?'blue':'aqua').' btn-flat margin','data-pjax' => 0])?>
                        <?=Html::a('МЧС России',['mchs'],['class'=>'btn bg-'.(Yii::$app->controller->action->id=='mchs'?'blue':'aqua').' btn-flat margin','data-pjax' => 0])?>
<!--                        --><?//=Html::a('Руководство МЧС России',['guide-mchs'],['class'=>'btn bg-'.(Yii::$app->controller->action->id=='guide-mchs'?'blue':'aqua').' btn-flat margin','data-pjax' => 0])?>
<!--                        --><?//=Html::a('Позитив',['positive-mchs'],['class'=>'btn bg-'.(Yii::$app->controller->action->id=='positive-mchs'?'olive':'green').' btn-flat margin','data-pjax' => 0])?>
                        <?=Html::a('НЕГАТИВ',['negative-mchs'],['class'=>'btn bg-'.(Yii::$app->controller->action->id=='negative-mchs'?'maroon':'red').' btn-flat margin','data-pjax' => 0])?>
                        <a href="#" id="button_search" class="btn bg-<?php if(empty($source) and empty($from_date) and empty($to_date) and empty($string)) echo 'aqua'; else echo 'blue';?> btn-flat margin" onclick="diplay_hide_search('#block_id');return false;"><i id="icon_search" class="fa fa-angle-double-<?php if(empty($source) and empty($from_date) and empty($to_date) and empty($string)) echo 'down'; else echo 'up';?>"></i> <i class="fa fa-search"></i></a>

                        <div class="row monitoring-search" id="block_id" style="<?php if(empty($source) and empty($from_date) and empty($to_date) and empty($string)) echo 'display: none;'?>">

                            <hr style="margin: 10px 15px 5px 15px;">

                            <?= Html::beginForm([''], 'get', ['id'=>'filter','data-pjax' => '']); ?>

                            <div class="col-sm-2 padding-10-5-5-20">
                                <div class="input-group input-group-sm" style="width: 100%">
                                    <?= Html::dropDownList('source', $source ? $source : '', ArrayHelper::map(MonitoringMedia::find()->orderBy('name')->all(),'id','name'), ['class' => 'form-control','prompt' => 'Выберите источник...']); ?>

                                </div>
                            </div>

                            <div class="col-sm-3 padding-10-5-5-5">
                                <div class="input-group input-group-sm" style="width: 100%">
                                    <?= DatePicker::widget([
                                        'name' => 'from_date',
                                        'value' => $from_date ? $from_date : null,
                                        'type' => DatePicker::TYPE_RANGE,
                                        'name2' => 'to_date',
                                        'value2' => $to_date ? $to_date : null,
                                        'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
                                        'options' => ['placeholder' => 'Дата с...','style' => 'height:30px;border-radius:0px'],
                                        'options2' => ['placeholder' => 'Дата по...','style' => 'height:30px;border-radius:0px'],
                                        'pluginOptions' => [
                                            'autoclose'=>true,
                                            'format' => 'dd-mm-yyyy',
                                            'todayHighlight' => true,
                                        ]
                                    ]);
                                    ?>
                                </div>
                            </div>

                            <div class="col-sm-6 padding-10-5-5-5">
                                <div class="input-group input-group-sm" style="width: 100%">
                                    <?= Html::input('text', 'string', $string ? $string : '', ['class' => 'form-control','placeholder' => 'Поиск...']) ?>
                                </div>
                            </div>

                            <div class="col-sm-1 padding-10-20-5-5">
                                <div class="input-group input-group-sm">
                                <span class="input-group-btn">
                                    <?= Html::submitButton('<i class="fa fa-search"></i>', ['class' => 'btn btn-info btn-flat', 'title' => 'Поиск', 'style' => 'width: 100%;padding: 0px;']); ?>
                                </span>
                                </div>
                            </div>

                            <?= Html::endForm(); ?>
                        </div>

                        <hr style="margin-top: 10px;">

                        <?php
                        echo ListView::widget([
                            'dataProvider' => $dataProviderMonitoringNews,
                            'itemView' => '_listMonitoringNews',
                            'summaryOptions' => ['style' => 'margin-bottom:15px;'],
                            'pager' => [
                                'firstPageLabel' => '<i class="fa fa-angle-double-left"></i>',
                                'lastPageLabel' => '<i class="fa fa-angle-double-right"></i>',
                                'nextPageLabel' => '<i class="fa fa-angle-right"></i>',
                                'prevPageLabel' => '<i class="fa fa-angle-left"></i>',
                                'maxButtonCount' => 10,
                            ],
                        ]);
                        ?>

                    </div>
                        </div>

                </div>




