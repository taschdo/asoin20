<?php
use backend\models\MonitoringMedia;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MonitoringNews */
/* @var $form yii\widgets\ActiveForm */

$title=$model->title;
$description=$model->description;
$text=$model->text;

if(Yii::$app->controller->action->id!='index') {
    foreach (MonitoringMedia::$tagsMchs as $tag) {
        $title = preg_replace('/([\s]*[[:punct:]]*[\s]*)([\w\-]*' . $tag . '[\w\-]*)([\s]*[[:punct:]]*[\s]*)/iu', '\\1<span style="background:#5fc9f6"><b>\\2</b></span>\\3', $title);
        $description = preg_replace('/([\s]*[[:punct:]]*[\s]*)([\w\-]*' . $tag . '[\w\-]*)([\s]*[[:punct:]]*[\s]*)/iu', '\\1<span style="background:#5fc9f6"><b>\\2</b></span>\\3', $description);
        $text = preg_replace('/([\s]*[[:punct:]]*[\s]*)([\w\-]*' . $tag . '[\w\-]*)([\s]*[[:punct:]]*[\s]*)/iu', '\\1<span style="background:#5fc9f6"><b>\\2</b></span>\\3', $text);
    }

//    if (Yii::$app->controller->action->id == 'guide-mchs') {
//        foreach (MonitoringMedia::$guideTags as $tag) {
//            $title = preg_replace('/([\s]*[[:punct:]]*[\s]*)([\w\-]*' . $tag . '[\w\-]*)([\s]*[[:punct:]]*[\s]*)/iu', '\\1<span style="background:#4fc24a"><b>\\2</b></span>\\3', $title);
//            $description = preg_replace('/([\s]*[[:punct:]]*[\s]*)([\w\-]*' . $tag . '[\w\-]*)([\s]*[[:punct:]]*[\s]*)/iu', '\\1<span style="background:#4fc24a"><b>\\2</b></span>\\3', $description);
//            $text = preg_replace('/([\s]*[[:punct:]]*[\s]*)([\w\-]*' . $tag . '[\w\-]*)([\s]*[[:punct:]]*[\s]*)/iu', '\\1<span style="background:#4fc24a"><b>\\2</b></span>\\3', $text);
//        }
//    }

//    if (Yii::$app->controller->action->id == 'positive-mchs') {
//        foreach (MonitoringMedia::$positiveTags as $tag) {
//            $title = preg_replace('/([\s]*[[:punct:]]*[\s]*)([\w\-]*' . $tag . '[\w\-]*)([\s]*[[:punct:]]*[\s]*)/iu', '\\1<span style="background:#4fc24a"><b>\\2</b></span>\\3', $title);
//            $description = preg_replace('/([\s]*[[:punct:]]*[\s]*)([\w\-]*' . $tag . '[\w\-]*)([\s]*[[:punct:]]*[\s]*)/iu', '\\1<span style="background:#4fc24a"><b>\\2</b></span>\\3', $description);
//            $text = preg_replace('/([\s]*[[:punct:]]*[\s]*)([\w\-]*' . $tag . '[\w\-]*)([\s]*[[:punct:]]*[\s]*)/iu', '\\1<span style="background:#4fc24a"><b>\\2</b></span>\\3', $text);
//        }
//    }
//    if (Yii::$app->controller->action->id == 'negative-mchs') {
//        foreach (MonitoringMedia::$negativeTags as $tag) {
//            $title = preg_replace('/([\s]*[[:punct:]]*[\s]*)([\w\-]*' . $tag . '[\w\-]*)([\s]*[[:punct:]]*[\s]*)/iu', '\\1<span style="background:#f32144"><b>\\2</b></span>\\3', $title);
//            $description = preg_replace('/([\s]*[[:punct:]]*[\s]*)([\w\-]*' . $tag . '[\w\-]*)([\s]*[[:punct:]]*[\s]*)/iu', '\\1<span style="background:#f32144"><b>\\2</b></span>\\3', $description);
//            $text = preg_replace('/([\s]*[[:punct:]]*[\s]*)([\w\-]*' . $tag . '[\w\-]*)([\s]*[[:punct:]]*[\s]*)/iu', '\\1<span style="background:#f32144"><b>\\2</b></span>\\3', $text);
//        }
//    }
}

echo $model->idMedia->iconMedia;
echo '<b><a target="_blank" href="'.$model->link.'">' . $title . '</b></a><br>';
if (!empty($description)) echo $description.'<br>';
if (!empty($text)) echo '<div style="display:none" id="block_id_'.$model->id.'"><br>'.$text.'<br><br></div>';
echo '<span class="users-list-date"><i class="fa fa-clock-o"></i> '.date('H:i d-m-Y', $model->date_publication);
echo '&emsp;';
echo '<i class="fa fa-newspaper-o"></i> '.'<a target="_blank" href="'.$model->idMedia->url_news.'">'.$model->idMedia->name.'</a>';
echo '&emsp;';
if(!empty($text)) {
    echo '&nbsp;';
    echo '<a href="#" onclick="diplay_hide_text(\'#block_id_' . $model->id . '\',\'#small_' . $model->id . '\');return false;"><small id="small_' . $model->id . '" class="label bg-aqua">Полный текст</small></a>';
}
echo '</span><br>';

