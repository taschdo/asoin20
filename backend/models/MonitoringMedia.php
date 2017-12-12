<?php

namespace backend\models;

use Yii;
use common\models\User;
use yii\helpers\Html;

/**
 * This is the model class for table "asoin_monitoring_media".
 *
 * @property integer $id
 * @property string $name
 * @property string $avatar
 * @property string $url_media
 * @property string $encoding
 * @property string $url_news
 * @property string $url_rss
 * @property string $unit_news_all
 * @property string $unit_news_one
 * @property string $unit_remove
 * @property string $unit_title
 * @property string $unit_description
 * @property string $unit_text
 * @property string $unit_date
 * @property string $unit_url
 * @property integer $update_time
 * @property integer $last_update_time
 * @property integer $active
 * @property integer $created
 * @property integer $id_user
 *
 * @property User $idUser
 * @property MonitoringNews[] $monitoringNews
 */
class MonitoringMedia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $file;

    // Тэги, по которым идет поиск МЧС России
    public static $tagsMchs = [
        'МЧС',
        'ЧС',
        'РСЧС',
        'спасател',
        'пожар',
        'взрыв',
        'Пучков',
        'ДТП',
        'авари',
        'павод',
        'землетрясен',
        'обвал',
        'происшестви',
        'восстановительн',
        'угаран',
        'задымлени',
        'термоточк',
        'смерч',
        'метель',
        'тайфун',
        'извержение',
        'цунами',
        'половодье',
        'столкновение',
        'ГИМС',
    ];

    // Тэги, по которым идет поиск руководства МЧС России
//    public static $guideTags = [
//        'Пучков',
//        'Степанов',
//        'Аксенов',
//        'Баженов',
//        'Барышев',
//        'Чуприян',
//        'Поплавская',
//        'Лутошкин',
//        'Мануйло',
//        'Писчурников',
//        'Романов',
//        'Елизаров',
//        'Сандин',
//        'Власов',
//        'Вагутович',
//        'Лаврентьев',
//        'Смирнов',
//        'Крючек',
//        'Яцуценко',
//        'Кутровский',
//        'Диденко',
//        ' Одер',
//        'Кобзев',
//        'Панин',
//        'Денисов',
//    ];

    // Тэги, по которым идет поиск позитива
//    public static $positiveTags = [
//        'награ',
//        'спецборт',
//        'стабилизир',
//        'защитит',
//    ];

    // Тэги, по которым идет поиск негатива
//    public static $negativeTags = [
//        'взяточничест',
//        'наркотик',
//        'скандал',
//        'воровств',
//        'фигурант',
//        'задержен',
//        'присвоении',
//    ];

    // Тэги, но обязательные, по которым идет поиск негатива
//    public static $negativeMandatoryTags = [
//        'МЧС',
//        'Пучков',
//    ];

    // Ошибки если с какой-то лентой во время парсинга неполадки
    public static $error = [
        '1'=>'Недоступна новостная лента',
        '2'=>'Невозможно забрать body',
        '3'=>'Не найден блок новостной ленты',
        '4'=>'Не найден идентификатор одной новости',
        '5'=>'Не найден заголовок',
        '6'=>'Не найдена ссылка новости',
        '7'=>'Не найдена дата',
    ];

//    public static function tags()
//    {
//        $i=1;
//        $lineTags='';
//        foreach(self::$tags as $tag) {
//            $lineTags.=$tag;
//            if($i<count(self::$tags)) $lineTags.='|';
//            $i++;
//        }
//        return $lineTags;
//    }


    public static function tableName()
    {
        return 'asoin_monitoring_media';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'avatar', 'url_media', 'url_news', 'unit_news_all', 'unit_news_one', 'unit_title', 'unit_url', 'update_time', 'created', 'id_user'], 'required'],
            [['unit_text'], 'string'],
            [['update_time', 'last_update_time', 'active', 'created', 'id_user'], 'integer'],
            [['name', 'avatar', 'url_media', 'url_news', 'url_rss', 'unit_news_all', 'unit_news_one', 'unit_remove', 'unit_title', 'unit_description', 'unit_date', 'unit_url'], 'string', 'max' => 255],
            [['encoding'], 'string', 'max' => 50],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'avatar' => 'Логотип',
            'url_media' => 'Адрес СМИ',
            'encoding' => 'Кодировка',
            'url_news' => 'Адрес новостной ленты',
            'url_rss' => 'Адрес RSS',
            'unit_news_all' => 'Идентификатор блока новостной ленты',
            'unit_news_one' => 'Идентификатор одной новости в ленте',
            'unit_remove' => 'Какие элементы удалить (если есть, разделять через |)',
            'unit_title' => 'Идентификатор заголовка',
            'unit_description' => 'Идентификатор описания (если есть)',
            'unit_text' => 'Идентификатор текста (если есть)',
            'unit_date' => 'Идентификатор даты (если есть)',
            'unit_url' => 'Идентификатор ссылки новости',
            'update_time' => 'Время обновления ленты (в секундах)',
            'last_update_time' => 'Последнее время обновления',
            'active'=>'Активно / Не активно',
            'created' => 'Дата создания',
            'id_user' => 'Id User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMonitoringNews()
    {
        return $this->hasMany(MonitoringNews::className(), ['id_media' => 'id']);
    }

    public function getIconMedia()
    {
        return Html::img('/admin/'.$this->avatar,['title'=>$this->name,'alt'=>$this->name,'style'=>'margin-bottom:3px;margin-right:10px;']);
    }
}
