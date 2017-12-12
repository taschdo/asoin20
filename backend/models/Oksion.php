<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "asoin_oksion".
 *
 * @property integer $id
 * @property integer $id_subject
 * @property integer $view
 * @property integer $type
 * @property string $avatar
 * @property string $city
 * @property string $address
 * @property string $geometry
 * @property integer $working
 * @property integer $reason
 * @property integer $date_malfunction
 * @property integer $date_construction
 * @property integer $date_modernization
 * @property integer $date_purchase
 * @property string $base
 * @property string $staffing
 * @property string $note
 *
 * @property Subject $idSubject
 */
class Oksion extends \yii\db\ActiveRecord
{

    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asoin_oksion';
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if(!empty($this->date_construction)) $this->setAttribute('date_construction', strtotime($this->date_construction));
            if(!empty($this->date_modernization)) $this->setAttribute('date_modernization', strtotime($this->date_modernization));
            if(!empty($this->date_purchase)) $this->setAttribute('date_purchase', strtotime($this->date_purchase));
            if(!empty($this->date_malfunction)) $this->setAttribute('date_malfunction', strtotime($this->date_malfunction));

            if($this->working) {
                $this->reason = NULL;
                $this->date_malfunction = NULL;
            }

            if($this->type==1 or $this->type==2) {
                $this->view=1;
                $this->date_purchase=NULL;
                $this->base=NULL;
                $this->staffing=NULL;
            }
            else {
                $this->view=2;
                $this->date_construction=NULL;
                $this->date_modernization=NULL;
            }

            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_subject', 'type', 'city', 'address', 'geometry', 'working'], 'required'],
            [['id_subject', 'view', 'type', 'working', 'reason'], 'integer'],
            [['avatar', 'city', 'address', 'geometry', 'base', 'staffing', 'note'], 'string', 'max' => 255],
            [['date_malfunction','date_construction','date_modernization','date_purchase'], 'string', 'max' => 20],
            [['id_subject'], 'exist', 'skipOnError' => true, 'targetClass' => Subject::className(), 'targetAttribute' => ['id_subject' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_subject' => 'Субъект',
            'view' => 'Вид',
            'type' => 'Тип',
            'avatar' => 'Фотография',
            'city' => 'Город',
            'address' => 'Адрес',
            'geometry' => 'Координаты',
            'working' => 'Работает',
            'reason' => 'Причина',
            'date_malfunction' => 'Дата неисправности',
            'date_construction' => 'Дата постройки',
            'date_modernization' => 'Дата модернизации',
            'date_purchase' => 'Дата приобритения',
            'base' => 'Базовое шасси, гос.номер',
            'staffing' => 'Укомплектованность расчетом, обученность расчета',
            'note' => 'Примечание',
        ];
    }

    public static $view = [
        "1" => "ТК ОКСИОН",
        "2" => "МКИОН",
    ];

    public static $type = [
        "ТК ОКСИОН" => [
            "1" => "ПУОН",
            "2" => "ПИОН",
        ],
        "МКИОН" => [
            "3" => "МКИОН",
            "4" => "МТКИОН",
            "5" => "МТКОН",
            "6" => "МКИОН-5 М",
        ],
    ];

    public static $working = [
        "1" => "Работает",
        "0" => "Не работает",
    ];

    public static $reason = [
        "1" => "Отсутствие связи",
        "2" => "Недоступен управляющий компьютер",
        "3" => "Неисправность оборудования",
        "4" => "Отсутствие договора",
        "5" => "Реконструкция здания",
    ];

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(Subject::className(), ['id' => 'id_subject']);
    }

    public function saveAvatar() {
        $imageName = substr(md5(microtime() . rand(0, 9999)), 0, 20);
        $this->file = UploadedFile::getInstance($this, 'file');
        if ($this->file->extension != null) {
            $this->file->saveAs('images/oksion/' . $imageName . '.' . $this->file->extension);
            // Сохранение в БД URLа аватарки
            $this->avatar = 'images/oksion/' . $imageName . '.' . $this->file->extension;
            return true;
        }
        return true;
    }

}
