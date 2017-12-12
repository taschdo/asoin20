<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use backend\models\MonitoringMedia;
use backend\models\MonitoringNews;
use GuzzleHttp\Client;

class ParsingController extends Controller
{

    /**
     * Выполнение по cron, команда:
     *
     * - Для yii2 в yutex:
     * /usr/local/php55/bin/php-cgi -c /usr/phpselector/mavens/asoin.maven-site.ru -f /home/mavens/public_html/asoin/yii parsing
     *
     * - Для yii2:
     * /usr/local/bin/php /home/ваш_логин/public_html/папка/yii parsing
     *
     * - Стандартное выполнение команды cron:
     * /usr/local/bin/php /home/ваш_логин/public_html/папка/скрипт.php
     *
     */

    public function actionIndex()
    {
        // Определяем время начала выполнения cron
        $time_begin_cron=time();

        $number_unit=0;

        foreach (MonitoringMedia::find()->all() as $media) {

            // Определяем заходить на сайт роботу или нет из расчета: когда последний раз посещал сайт + через сколько нужно посещать.
            if (($media->last_update_time + $media->update_time) > time()) continue;

            // Обновляем время посещения сайта.
            Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `last_update_time` = ' . time() . ' where `id`=:id_media')
                ->bindValues([':id_media' => $media->id])->execute();

            // Если существует RSS лента, то парсим ее
            if (!empty($media->url_rss)) {
                // Забираем XML и убираем вывод ошибок, поставив @
                $rss = @simplexml_load_file($media->url_rss);

                // Если лента RSS доступна
                if ($rss) {
                    // Если лента RSS до этого была не доступна, а сейчас доступна, обнуляем ошибку
                    if ($media->active == 1) {
                        Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = NULL where `id`=:id')
                            ->bindValues([':id' => $media->id])->execute();
                    }

                    // Проходим циклом по XML документу
                    foreach ($rss->channel->item as $item) {

                        // Определяем и проверяем дату
                        $pubDate=$item->pubDate;
                        if ($pubDate == '') {
                            Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = 7 where `id`=:id')
                                ->bindValues([':id' => $media->id])->execute();
                            continue;
                        } elseif ($media->active == 7) {
                            Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = NULL where `id`=:id')
                                ->bindValues([':id' => $media->id])->execute();
                        }
                        $pubDate=strtotime($pubDate);

                        // Если дата публикации новости меньше даты последнего посещения робота, то дальше не идем
                        // if($media->last_update_time!=NULL and $media->last_update_time>$pubDate) continue;

                        // Определяем id media.
                        $id_media = $media->id;

                        // Определяем и проверяем ссылку
                        $link=$item->link;
                        if ($link == '') {
                            Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = 6 where `id`=:id')
                                ->bindValues([':id' => $media->id])->execute();
                            continue;
                        } elseif ($media->active == 6) {
                            Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = NULL where `id`=:id')
                                ->bindValues([':id' => $media->id])->execute();
                        }

                        // Определяем и проверяем заголовок
                        $title=trim(strip_tags($item->title));
                        if ($title == '') {
                            Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = 5 where `id`=:id')
                                ->bindValues([':id' => $media->id])->execute();
                            continue;
                        } elseif ($media->active == 5) {
                            Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = NULL where `id`=:id')
                                ->bindValues([':id' => $media->id])->execute();
                        }

                        // Выводим краткое описание новости
                        $description = trim(strip_tags($item->description));

                        // Выводим подробный текст новости
                        if (!empty($media->unit_text)) {
                            if($media->unit_text=='yandex:full-text') {
                                $namespaces = $item->getNameSpaces(true);
                                $yandex = $item->children($namespaces['yandex']);
                                $full_text = (string)$yandex->{'full-text'};
                            }
                            else {
                                $full_text = $item->{$media->unit_text};
                            }
                            $text = trim(strip_tags($full_text));
                        }
                        else $text = NULL;

                        // Определяем время сохранения новости в БД.
                        $created = time();

                        // Сохраняем новость в БД.
                        Yii::$app->db->createCommand('INSERT IGNORE INTO `asoin_monitoring_news` (`id_media`,`title`,`description`,`text`,`link`,`date_publication`,`created`) VALUES (:id_media,:title,:description,:text,:link,:date_publication,:created)', [
                            ':id_media' => $id_media,
                            ':title' => $title,
                            ':description' => $description,
                            ':text' => $text,
                            ':link' => $link,
                            ':date_publication' => $pubDate,
                            ':created' => $created,
                        ])->execute();

                        $number_unit++;
                    }
                }
                // Если лента RSS недоступна, пишим ошибку в БД
                else {
                    Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = 1 where `id`=:id')
                        ->bindValues([':id' => $media->id])->execute();
                    continue;
                }

            }
            // Если RSS ленты в БД нет, то парсим указанную новостную ленты на сайте
            else {

                // Забираем новочтную ленту и убираем вывод ошибок, поставив @
                $res = @file_get_contents($media->url_news);

                if($res) {
                    // Если лента новостей до этого была не доступна, а сейчас доступна, обнуляем ошибку
                    if ($media->active == 1) {
                        Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = NULL where `id`=:id')
                            ->bindValues([':id' => $media->id])->execute();
                    }

                    // Заходим на сайт и забираем всё что между тегом body.
                    $client = new Client();

                    // Парсим страницу
                    $res = $client->request('GET', $media->url_news);
                    $body = $res->getBody();

                    // Перевожу в нужную кодировку
                    if ($media->encoding == 'CP1251') $body = iconv($media->encoding, "UTF-8", $body);

                    // Если не смог забрать body, то записывает ошибку или снимает эту ошибку если body найден
                    if ($body == '') {
                        Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = 2 where `id`=:id')
                            ->bindValues([':id' => $media->id])->execute();
                        continue;
                    } elseif ($media->active == 2) {
                        Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = NULL where `id`=:id')
                            ->bindValues([':id' => $media->id])->execute();
                    }

                    // Определяю нужную кодировку. CP1251-RIA это копризная кодировка ria.ru
                    $charset = null;
                    if (!empty($media->encoding)) {
                        if ($media->encoding == 'UTF-8') $charset = 'UTF-8';
                        if ($media->encoding == 'CP1251-RIA') $charset = 'CP1251';
                    }

                    // Привожу всё к указанной кодировке.
                    $document = \phpQuery::newDocumentHTML($body, $charset);
                    $news = $document->find("$media->unit_news_all");

                    // Если не смог забрать news, то записывает ошибку или снимает эту ошибку если news найден
                    if ($news == '') {
                        Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = 3 where `id`=:id')
                            ->bindValues([':id' => $media->id])->execute();
                        continue;
                    } elseif ($media->active == 3) {
                        Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = NULL where `id`=:id')
                            ->bindValues([':id' => $media->id])->execute();
                    }

                    // Чистим новостной блок от лишних символов, указанных в БД исходя из специфики сайта
                    if (!empty($media->unit_remove)) {
                        foreach (explode("|", $media->unit_remove) as $res) $news->find("$res")->remove();
                    }

                    // Выбираем все элементы новостей
                    $elementNews = $news->find("$media->unit_news_one");

                    // Если не смог забрать elementNews, то записывает ошибку или снимает эту ошибку если elementNews найден
                    if ($elementNews == '') {
                        Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = 4 where `id`=:id')
                            ->bindValues([':id' => $media->id])->execute();
                        continue;
                    } elseif ($media->active == 4) {
                        Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = NULL where `id`=:id')
                            ->bindValues([':id' => $media->id])->execute();
                    }

                    // Цикл по новостным элементам в новостной ленте.
                    $i=1;
                    $dates='';
                    foreach ($elementNews as $elem) {
                        $pq = pq($elem);

                        // Определяем дату
                        if (!empty($media->unit_date)) {
                            $date = $pq->find("$media->unit_date")->text();

                            // Если не смог забрать date, то записывает ошибку или снимает эту ошибку если date найден
                            if ($date == '') {
                                Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = 7 where `id`=:id')
                                    ->bindValues([':id' => $media->id])->execute();
                                continue;
                            } elseif ($media->active == 7) {
                                Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = NULL where `id`=:id')
                                    ->bindValues([':id' => $media->id])->execute();
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

                        $i++;

                        // Если дата публикации новости меньше даты последнего посещения робота, то дальше не идем
                        // if($media->last_update_time!=NULL and $media->last_update_time>$date) continue;

                        // Определяем id media.
                        $id_media = $media->id;

                        // Определяем title.
                        $title = trim(strip_tags($pq->find("$media->unit_title")->text()));

                        // Если не смог забрать title, то записывает ошибку или снимает эту ошибку если title найден
                        if ($title == '') {
                            Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = 5 where `id`=:id')
                                ->bindValues([':id' => $media->id])->execute();
                            continue;
                        } elseif ($media->active == 5) {
                            Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = NULL where `id`=:id')
                                ->bindValues([':id' => $media->id])->execute();
                        }

                        // Определяем link.
                        $link = trim($pq->find("$media->unit_url")->attr('href'));

                        // Если не смог забрать link, то записывает ошибку или снимает эту ошибку если link найден
                        if ($link == '') {
                            Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = 6 where `id`=:id')
                                ->bindValues([':id' => $media->id])->execute();
                            continue;
                        } elseif ($media->active == 6) {
                            Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = NULL where `id`=:id')
                                ->bindValues([':id' => $media->id])->execute();
                        }

                        $link=$media->url_media.$link;

                        // Определяем и выводим описание.
                        $description = NULL;
                        if (!empty($media->unit_description)) {
                            $description = trim(strip_tags($pq->find("$media->unit_description")->text()));
                        }

                        // Определяем и выводим текст.
                        $text = NULL;
                        if (!empty($media->unit_text)) {
                            $text = trim(strip_tags($pq->find("$media->unit_text")->text()));
                        }

                        // Определяем время сохранения новости в БД.
                        $created = time();

                        // Сохраняем новость в БД.
                        Yii::$app->db->createCommand('INSERT IGNORE INTO `asoin_monitoring_news` (`id_media`,`title`,`description`,`text`,`link`,`date_publication`,`created`) VALUES (:id_media,:title,:description,:text,:link,:date_publication,:created)', [
                            ':id_media' => $id_media,
                            ':title' => $title,
                            ':description' => $description,
                            ':text' => $text,
                            ':link' => $link,
                            ':date_publication' => $date,
                            ':created' => $created,
                        ])->execute();

                        $number_unit++;


                    }
                }
                // Если лента новостная недоступна, пишим ошибку в БД
                else {
                    Yii::$app->db->createCommand('Update `asoin_monitoring_media` SET `active` = 1 where `id`=:id')
                        ->bindValues([':id' => $media->id])->execute();
                    continue;
                }
            }

        }


        // Сохраняем в БД данные по выполнению cron
        // Количество строк в БД новостей
        $number_bd=Yii::$app->db->createCommand('SELECT COUNT(*) FROM asoin_monitoring_news')->queryScalar();

        // Время завершения cron
        $time_end=time();

        // Сколько времени выполнялся cron
        $time_run=$time_end-$time_begin_cron;

        // Запись в БД выполнение cron
        Yii::$app->db->createCommand('INSERT IGNORE INTO `asoin_cron` (`time_begin`,`time_end`,`time_run`,`number_unit`,`number_bd`) VALUES (:time_begin,:time_end,:time_run,:number_unit,:number_bd)', [
            ':time_begin' => $time_begin_cron,
            ':time_end' => $time_end,
            ':time_run' => $time_run,
            ':number_unit' => $number_unit,
            ':number_bd' => $number_bd,
        ])->execute();

        return 0;
    }

}