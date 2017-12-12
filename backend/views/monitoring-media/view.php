<?php

use yii\helpers\Html;
use backend\models\MonitoringMedia;
use GuzzleHttp\Client;

/* @var $this yii\web\View */
/* @var $model backend\models\MonitoringMedia */

$this->title = $model->name.' | ' . Yii::$app->name;
$this->params['h1'] = Html::a($model->name,['view','id'=>$model->id],['data-pjax' => 0]);
$this->params['breadcrumbs'][] = ['label' => 'Мониторинг СМИ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Администраторская часть', 'url' => ['control']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="monitoring-media-view">

    <div class="box box-primary">
        <div class="box-header with-border">
            <i class="fa fa-th" title="Мониторинг новостной ленты ИА"></i>
            <h3 class="box-title">Мониторинг новостной ленты ИА</h3>

            <div class="box-tools">
                <?= Html::a('<span class="glyphicon glyphicon-repeat"></span>', ['view','id'=>$model->id], ['class' => 'btn btn-default btn-sm', 'title' => 'Перезагрузить страницу']) ?>
            </div>
        </div>

        <div class="box-body">

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

            <?php

            // Если существует RSS лента, то парсим ее
            if(!empty($model->url_rss)) {

                // Забираем XML и убираем вывод ошибок, поставив @
                $rss = @simplexml_load_file($model->url_rss);

                // Если лента RSS доступна
                if ($rss) {
                    // Если лента RSS до этого была не доступна, а сейчас доступна, обнуляем ошибку
                    if ($model->active == 1) {
                        Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = NULL where `id`=:id')
                            ->bindValues([':id' => $model->id])->execute();
                    }

                    // Проходим циклом по XML документу
                    $i=1;
                    foreach ($rss->channel->item as $item) {

                        // Icon новостной ленты
                        echo $model->iconMedia;

                        // Проверяем ссылку, заголовок и дату размещения
                        $link=$item->link;
                        if ($link == '') {
                            Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = 6 where `id`=:id')
                                ->bindValues([':id' => $model->id])->execute();
                            break;
                        } elseif ($model->active == 6) {
                            Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = NULL where `id`=:id')
                                ->bindValues([':id' => $model->id])->execute();
                        }

                        $title=strip_tags($item->title);
                        if ($title == '') {
                            Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = 5 where `id`=:id')
                                ->bindValues([':id' => $model->id])->execute();
                            break;
                        } elseif ($model->active == 5) {
                            Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = NULL where `id`=:id')
                                ->bindValues([':id' => $model->id])->execute();
                        }

                        $pubDate=$item->pubDate;
                        if ($pubDate == '') {
                            Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = 7 where `id`=:id')
                                ->bindValues([':id' => $model->id])->execute();
                            break;
                        } elseif ($model->active == 7) {
                            Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = NULL where `id`=:id')
                                ->bindValues([':id' => $model->id])->execute();
                        }

                        // Выводим url новости
                        echo '<b><a target="_blank" href="' . $link . '">' . $title . '</b></a>';
                        echo '<br>';
                        // Выводим краткое описание новости
                        echo strip_tags($item->description);
                        // Выводим подробный текст новости
                        if (!empty($model->unit_text)) {
                            if($model->unit_text=='yandex:full-text') {
                                $namespaces = $item->getNameSpaces(true);
                                $yandex = $item->children($namespaces['yandex']);
                                $full_text = (string)$yandex->{'full-text'};
                            }
                            else {
                                $full_text = $item->{$model->unit_text};
                            }
                            echo '<div style="display:none" id="block_id_'.$i.'"><br>'.strip_tags($full_text).'<br><br></div>';
                        }
                        // Выводим дату новости
                        echo '<span class="users-list-date"><i class="fa fa-clock-o"></i> '.date("H:i d-m-Y",strtotime($pubDate));
                        if(!empty($model->unit_text)) {
                            echo '&emsp;';
                            echo '<a href="#" onclick="diplay_hide_text(\'#block_id_' . $i . '\',\'#small_' . $i . '\');return false;"><small id="small_' . $i . '" class="label bg-aqua">Полный текст</small></a>';
                        }
                        echo '</span><br>';
                        $i++;
                    }
                }
                // Если лента RSS недоступна, пишим ошибку в БД
                else {
                    Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = 1 where `id`=:id')
                        ->bindValues([':id' => $model->id])->execute();
                    echo '<h3><small class="label bg-red">Недоступна новостная лента <i>('.date("H:i d-m-Y",$model->last_update_time).')</i></small></h3>';
                }
            }
            // Если RSS ленты в БД нет, то парсим указанную новостную ленты на сайте
            else {

                // Забираем новочтную ленту и убираем вывод ошибок, поставив @
                $res = @file_get_contents($model->url_news);

                if($res) {
                    // Если лента новостей до этого была не доступна, а сейчас доступна, обнуляем ошибку
                    if ($model->active == 1) {
                        Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = NULL where `id`=:id')
                            ->bindValues([':id' => $model->id])->execute();
                    }

                    // Заходим на сайт и забираем всё что между тегом body.
                    $client = new Client();

                    // Парсим страницу
                    $res = $client->request('GET', $model->url_news);
                    $body = $res->getBody();

                    // Перевожу в нужную кодировку. Из CP1251 в UTF-8
                    if ($model->encoding == 'CP1251') $body = iconv($model->encoding, "UTF-8", $body);

                    // Если не смог забрать body, то записывает ошибку или снимает эту ошибку если body найден
                    if ($body == '') {
                        Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = 2 where `id`=:id')
                            ->bindValues([':id' => $model->id])->execute();
                    } elseif ($model->active == 2) {
                        Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = NULL where `id`=:id')
                            ->bindValues([':id' => $model->id])->execute();
                    }

                    // Определяю нужную кодировку. CP1251-RIA это копризная кодировка ria.ru
                    $charset = null;
                    if (!empty($model->encoding)) {
                        if ($model->encoding == 'UTF-8') $charset = 'UTF-8';
                        if ($model->encoding == 'CP1251-RIA') $charset = 'CP1251';
                    }

                    // Привожу всё к указанной кодировке.
                    $document = \phpQuery::newDocumentHTML($body, $charset);
                    $news = $document->find("$model->unit_news_all");

                    // Если не смог забрать news, то записывает ошибку или снимает эту ошибку если news найден
                    if ($news == '') {
                        Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = 3 where `id`=:id')
                            ->bindValues([':id' => $model->id])->execute();
                    } elseif ($model->active == 3) {
                        Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = NULL where `id`=:id')
                            ->bindValues([':id' => $model->id])->execute();
                    }

                    // Чистим новостной блок от лишних символов, указанных в БД исходя из специфики сайта
                    if (!empty($model->unit_remove)) {
                        foreach (explode("|", $model->unit_remove) as $res) $news->find("$res")->remove();
                    }

                    // Выбираем все элементы новостей
                    $elementNews = $news->find("$model->unit_news_one");

                    // Если не смог забрать elementNews, то записывает ошибку или снимает эту ошибку если elementNews найден
                    if ($elementNews == '') {
                        Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = 4 where `id`=:id')
                            ->bindValues([':id' => $model->id])->execute();
                    } elseif ($model->active == 4) {
                        Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = NULL where `id`=:id')
                            ->bindValues([':id' => $model->id])->execute();
                    }

                    // Цикл по новостным элементам в новостной ленте.
                    $i=1;
                    $dates='';
                    foreach ($elementNews as $elem) {
                        $pq = pq($elem);

                        // Определяем title.
                        $title = strip_tags($pq->find("$model->unit_title")->text());

                        // Если не смог забрать title, то записывает ошибку или снимает эту ошибку если title найден
                        if ($title == '') {
                            Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = 5 where `id`=:id')
                                ->bindValues([':id' => $model->id])->execute();
                            break;
                        } elseif ($model->active == 5) {
                            Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = NULL where `id`=:id')
                                ->bindValues([':id' => $model->id])->execute();
                        }

                        // Определяем link.
                        $link = trim($pq->find("$model->unit_url")->attr('href'));

                        // Если не смог забрать link, то записывает ошибку или снимает эту ошибку если link найден
                        if ($link == '') {
                            Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = 6 where `id`=:id')
                                ->bindValues([':id' => $model->id])->execute();
                            break;
                        } elseif ($model->active == 6) {
                            Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = NULL where `id`=:id')
                                ->bindValues([':id' => $model->id])->execute();
                        }

                        // Выводим заголовок.
                        echo $model->iconMedia;
                        echo '<b><a target="_blank" href="';
                        echo $model->url_media . $link;
                        echo '">' . $title . '</b></a>';

                        echo '<br>';

                        // Определяем и выводим описание.
                        if (!empty($model->unit_description)) {
                            $description = strip_tags($pq->find("$model->unit_description")->text());
                            if ($description != '') echo $description . '<br>';
                        }

                        // Определяем и выводим время с датой.
                        echo '<span class="users-list-date"><i class="fa fa-clock-o"></i> ';

                        // Определяем дату
                        if (!empty($model->unit_date)) {
                            $date = $pq->find("$model->unit_date")->text();

                            // Если не смог забрать date, то записывает ошибку или снимает эту ошибку если date найден
                            if ($date == '') {
                                Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = 7 where `id`=:id')
                                    ->bindValues([':id' => $model->id])->execute();
                                break;
                            } elseif ($model->active == 7) {
                                Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = NULL where `id`=:id')
                                    ->bindValues([':id' => $model->id])->execute();
                            }
                        } else {
                            $date = date("H:i d-m-Y");
                        }

                        // Выделяем только время
                        preg_match("/(2[0-3]|[01][0-9]):([0-5][0-9])/", $date, $d);

                        // Вычисляем дату
                        if ($i == 1) {
                            $date=$d[0].' '.date('d-m-Y');
                            $date=strtotime($date);
                            if($date>time()) {
                                $date=$date-24 * 60 * 60;
                            }
                            $dates = $date;
                        }
                        else {
                            $date=$d[0].' '.date('d-m-Y',$dates);
                            $date=strtotime($date);
                            if ($date > $dates) {
                                $date = $d[0].' '.date('d-m-Y',($dates - 24 * 60 * 60));
                                $date = strtotime($date);
                                $dates = $date;
                            } else {
                                $dates = $date;
                            }
                        }

                        // Вывод даты публикации
                        echo date('H:i d-m-Y', $date);

                        echo '</span><br>';

                        $i++;
                    }

                }
                // Если лента новостная недоступна, пишим ошибку в БД
                else {
                    Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = 1 where `id`=:id')
                        ->bindValues([':id' => $model->id])->execute();
                    echo '<h3><small class="label bg-red">Недоступна новостная лента <i>('.date("H:i d-m-Y",$model->last_update_time).')</i></small></h3>';
                }
            }
            ?>
                </div>

        </div>
    </div>
</div>




