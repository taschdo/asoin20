<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use backend\models\MonitoringMedia;
use backend\models\MonitoringNews;
use GuzzleHttp\Client;

class LabelMchsController extends Controller
{

    public function actionIndex()
    {

        $tags='';
        foreach (MonitoringMedia::$tagsMchs as $tagMchs) {
            $tags.='|'.$tagMchs;
        }
        $tags=mb_substr($tags,1);

        foreach (MonitoringNews::find()->where(['label_mchs'=>0])->all() as $news) {

            if(preg_match("/($tags)/i", $news->title) or preg_match("/($tags)/i", $news->description) or preg_match("/($tags)/i", $news->text)) {
                Yii::$app->db->createCommand('Update `asoin_monitoring_news` SET `label_mchs` = 2 where `id`=:id')
                    ->bindValues([':id' => $news->id])->execute();
            }
            else {
                Yii::$app->db->createCommand('Update `asoin_monitoring_news` SET `label_mchs` = 1 where `id`=:id')
                    ->bindValues([':id' => $news->id])->execute();
            }
        }

        return 0;
    }

}