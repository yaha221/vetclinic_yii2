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
class AdministratorForm extends Model
{
    public $fio;
    public $age;
    public $phone;
    public $experience;
    public $wage;
    public $user;


    /**
     * @return array правила валидации
     */
    public function rules()
    {
        return[
            // type, tonnage и month являются обязательными полями
            [['fio', 'age', 'phone', 'experience',], 'required', 'message' => 'Введите в {attribute} что-нибудь',],
            // type, tonnage и month должны быть безопасными
            [['fio', 'age', 'phone', 'experience', 'wage', 'user'], 'safe',],

            [[ 'age', 'phone', 'experience', 'wage'], 'match', 'pattern' => '/^[0-9]+$/u', 'message'=>'Только цифры'],            
        ];
    }

    /**
     * @return array изменнённые атрибуты labels
     */
    public function attributeLabels()
    {
        return [
            'fio' => 'имя',
            'age' => 'возраст',
            'phone' => 'телефон',
            'experience' => 'опыт ветеринара',
            'wage' => 'заробатная плата',
            'user' => 'пользователь',
        ];
    }
}
