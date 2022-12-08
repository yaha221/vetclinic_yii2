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
class ClientForm extends Model
{
    public $fio;
    public $age;
    public $phone;

    /**
     * @return array правила валидации
     */
    public function rules()
    {
        return[
            // type, tonnage и month являются обязательными полями
            [['fio', 'age', 'phone',], 'required', 'message' => 'Введите в {attribute} что-нибудь',],
            // type, tonnage и month должны быть безопасными
            [['fio', 'age', 'phone',], 'safe',],
            [[ 'age', 'phone',], 'match', 'pattern' => '/^[0-9]+$/u', 'message'=>'Только цифры'],
            ['fio', 'match', 'pattern' => '/^[A-zА-я-.]+*+[A-zА-я-.]+$/u', 'message'=>'Только буквы'],
        ];
    }

    /**
     * @return array изменнённые атрибуты labels
     */
    public function attributeLabels()
    {
        return [
            'fio' => 'инициалы',
            'age' => 'возраст',
            'phone' => 'номер телефона',
        ];
    }
}
