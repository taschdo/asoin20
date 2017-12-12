<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "asoin_monitoring_news".
 *
 * @property integer $id
 * @property integer $id_media
 * @property string $title
 * @property string $description
 * @property string $text
 * @property string $link
 * @property integer $date_publication
 * @property integer $label_mchs
 * @property integer $label_negative
 * @property integer $created
 *
 * @property MonitoringMedia $idMedia
 *
 * Значения у label_mchs:
 *    0 - cron не обработал новость
 *    1 - новость к МЧС не относится
 *    2 - новость относится к МЧС
 *
 * Значения у label_negative:
 *    0 - cron не обработал новость
 *    1 - не негатив
 *    2 - негатив
 *
 */
class MonitoringNews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asoin_monitoring_news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_media', 'title', 'link', 'created'], 'required'],
            [['id_media', 'date_publication', 'label_mchs', 'label_negative', 'created'], 'integer'],
            [['description', 'text'], 'string'],
            [['title', 'link'], 'string', 'max' => 255],
            [['link'], 'unique'],
            [['id_media'], 'exist', 'skipOnError' => true, 'targetClass' => MonitoringMedia::className(), 'targetAttribute' => ['id_media' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_media' => 'Id Media',
            'title' => 'Title',
            'text' => 'Text',
            'description' => 'Description',
            'link' => 'Link',
            'date_publication' => 'Date Publication',
            'label_mchs' => 'Метка МЧС',
            'label_negative' => 'Метка негатив',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMedia()
    {
        return $this->hasOne(MonitoringMedia::className(), ['id' => 'id_media']);
    }
}