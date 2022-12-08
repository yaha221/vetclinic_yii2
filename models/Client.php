<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * This is the model class for table "user_request".
 * 
 * @property integer $id
 * @property string $fio
 * @property integer $age
 * @property string $phone
 * @property integer $user_id
 * @property TimeStamp $updated_ta
 * @property TimeStamp $created_ta
 */
class Client extends ActiveRecord
{
    /**
     * @return array изменнённые атрибуты labels
     */
    public function attributeLabels()
    {
        return [
            'fio' => 'Инициалы',
            'age' => 'Возраст',
            'phone' => 'Номер телефона',
            'create_at' => 'Дата создания',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%client}}';
    }
}