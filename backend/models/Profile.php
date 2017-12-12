<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property integer $id_user
 * @property string $name
 * @property string $surname
 * @property string $middle_name
 * @property integer $date_birth
 * @property string $avatar
 * @property string $mobile_phone
 * @property string $work_phone
 * @property string $position
 * @property string $last_visit
 *
 * @property User $idUser
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user'], 'required'],
            [['id_user','last_visit'], 'integer'],
            [['date_birth'], 'string', 'max' => 20],
            [['name', 'surname', 'middle_name', 'avatar', 'mobile_phone', 'work_phone', 'position'], 'string', 'max' => 255],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'Id User',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'middle_name' => 'Отчество',
            'fio' => 'ФИО',
            'date_birth' => 'Дата рождения',
            'avatar' => 'Аватар',
            'mobile_phone' => 'Мобильный телефон',
            'work_phone' => 'Рабочий телефон',
            'position' => 'Должность',
            'userName' => 'Логин',
            'userEmail' => 'Email',
            'last_visit' => 'Последний визит',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    public function getAge()
    {
        return intval((time()-$this->date_birth)/31556926);
    }

    public function getAvatarUser()
    {
        return empty($this->avatar) ? '/admin/images/users/ava.jpg' : '/admin/'.$this->avatar;
    }
}
