<?php

namespace app\models\form;

use yii\base\Model;

/**
 * CalculatedForm является моделью расчётной формы
 * 
 * @property int $month выбранный месяц
 * @property int $tonnage выбранный тоннаж
 * @property int $type выбранный тип
 */
class CourseoftreatmentForm extends Model
{
    public $name;
    public $description;

    /**
     * @return array правила валидации
     */
    public function rules()
    {
        return[
            // type, tonnage и month являются обязательными полями
            [['name', 'description',], 'required', 'message' => 'Введите в {attribute} что-нибудь',],
            // type, tonnage и month должны быть безопасными
            [['name', 'description',], 'safe',],
        ];
    }

    /**
     * @return array изменнённые атрибуты labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'ход лечения',
            'description' => 'описание',
        ];
    }
}
