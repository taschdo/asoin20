<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "asoin_cron".
 *
 * @property integer $id
 * @property integer $time_begin
 * @property integer $time_end
 * @property integer $time_run
 * @property integer $number_unit
 * @property integer $number_bd
 */
class Cron extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asoin_cron';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time_begin', 'time_end', 'time_run', 'number_unit', 'number_bd'], 'required'],
            [['time_begin', 'time_end', 'time_run', 'number_unit', 'number_bd'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'time_begin' => 'Tн',
            'time_end' => 'Tк',
            'time_run' => 'Tcron',
            'number_unit' => 'Результат cron',
            'number_bd' => 'Новости в БД',
        ];
    }

    // Разчет размера БД
    public static function formatFileSize($result) {
        $dbsize = 0;
        foreach($result as $row) {
            $dbsize += $row[ "Data_length" ] + $row[ "Index_length" ];
        }
        // bytes
        if( $dbsize < 1024 ) { return $dbsize . " bytes"; }
        // kilobytes
        else if( $dbsize < 1048576 ) { return round( ( $dbsize / 1024 ), 1 ) . "KB"; }
        // megabytes
        else { return round( ( $dbsize / 1048576 ), 1 ) . " MB"; }
    }

}
