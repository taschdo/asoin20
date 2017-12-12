<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "asoin_base_media".
 *
 * @property integer $id
 * @property string $name
 * @property string $phone
 */
class BaseMedia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asoin_base_media';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone'], 'required'],
            [['name', 'phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название СМИ',
            'phone' => 'Телефон',
        ];
    }
}
