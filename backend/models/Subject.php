<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "asoin_subject".
 *
 * @property integer $id
 * @property integer $id_parent
 * @property string $name
 * @property string $abbreviation_regional_centre
 * @property string $name_region
 * @property integer $federal_district
 * @property string $contact
 * @property string $ods
 *
 * @property Subject $idParent
 * @property Subject[] $subjects
 */
class Subject extends \yii\db\ActiveRecord
{
    /**
     * Категория Федеральных округов
     */
    public static $categoryFederalDistrict = [
        "1" => "СФО",
        "2" => "УФО",
        "3" => "ДФО",
        "4" => "ЮФО",
        "5" => "СКФО",
        "6" => "ЦФО",
        "7" => "ПФО",
        "8" => "СЗФО",
        "9" => "Москва",
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asoin_subject';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_parent', 'federal_district'], 'integer'],
            [['name', 'name_region', 'federal_district', 'contact', 'ods'], 'required'],
            [['name', 'contact', 'ods'], 'string', 'max' => 255],
            [['abbreviation_regional_centre'], 'string', 'max' => 10],
            [['name_region'], 'string', 'max' => 50],
            [['id_parent'], 'exist', 'skipOnError' => true, 'targetClass' => Subject::className(), 'targetAttribute' => ['id_parent' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_parent' => 'РЦ',
            'name' => 'Название',
            'abbreviation_regional_centre' => 'РЦ',
            'name_region' => 'Название региона',
            'federal_district' => 'ФО',
            'contact' => 'Контакты',
            'ods' => 'ОДС',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdParent()
    {
        return $this->hasOne(Subject::className(), ['id' => 'id_parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubjects()
    {
        return $this->hasMany(Subject::className(), ['id_parent' => 'id']);
    }
}
