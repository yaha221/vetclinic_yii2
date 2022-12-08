<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * This is the model class for table "user_request".
 * 
 * @property integer $id
 * @property string $name
 * @property integer $vet_id
 * @property integer $client_id
 * @property integer $compaint_id
 * @property integer $medication_id
 * @property integer $course_of_treatment_id
 * @property TimeStamp $updated_ta
 * @property TimeStamp $created_ta
 */
class Administrator extends ActiveRecord
{
    /**
     * @return array изменнённые атрибуты labels
     */
    public function attributeLabels()
    {
        return [
            'fio' => 'Имя',
            'age' => 'Возраст',
            'phone' => 'Телефон',
            'experience' => 'Опыт ветеринара',
            'wage' => 'Заробатная плата',
            'created_at' => 'Дата создания',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%administrator}}';
    }
}