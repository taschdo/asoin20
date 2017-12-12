<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sample_ml_tone".
 *
 * @property integer $id
 * @property string $text
 * @property integer $tone
 */
class SampleMlTone extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sample_ml_tone';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'tone'], 'required'],
            [['text'], 'string'],
            [['tone'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'tone' => 'Tone',
        ];
    }
}
