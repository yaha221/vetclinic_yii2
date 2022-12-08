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
class PetForm extends Model
{
    public $name;
    public $vet;
    public $client;

    /**
     * @return array правила валидации
     */
    public function rules()
    {
        return[
            // type, tonnage и month являются обязательными полями
            [['name', 'vet', 'client',], 'required', 'message' => 'Введите в {attribute} что-нибудь',],
            // type, tonnage и month должны быть безопасными
            [['name', 'vet', 'client',], 'safe',],
        ];
    }

    /**
     * @return array изменнённые атрибуты labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'жалоба',
            'vet' => 'ветеринар',
            'client' => 'клиент',
        ];
    }
}