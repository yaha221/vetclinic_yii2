<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * This is the model class for table "user_request".
 * 
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $pet_id
 * @property TimeStamp $updated_ta
 * @property TimeStamp $created_ta
 */
class Courseoftreatment extends ActiveRecord
{
    /**
     * @return array изменнённые атрибуты labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Ход лечения',
            'description' => 'Описание',
            'create_at' => 'Дата назначения',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%course_of_treatment}}';
    }
}