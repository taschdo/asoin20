<?php
namespace common\models;

use Yii;
use backend\models\Oksion;


class Helpers extends \yii\db\ActiveRecord
{
   public static function arrayOksionType($typeNumber) {
       $arrOut = [];
       foreach(Oksion::$type as $subArr){
           foreach($subArr as $key => $val){
               if(isset($arrOut[$key]) && $arrOut[$key] > $val) continue;
               $arrOut[$key] = $val;
           }
       }
       return $arrOut[$typeNumber];
   }
}
