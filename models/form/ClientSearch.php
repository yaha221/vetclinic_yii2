<?php

namespace app\models\form;

use app\models\Client;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CalculatedForm является моделью расчётной формы
 * 
 * @property int $month выбранный месяц
 * @property int $tonnage выбранный тоннаж
 * @property int $type выбранный тип
 */
class ClientSearch extends Client
{
    /**
     * @return array правила валидации
     */
    public function rules()
    {
        return[
            [['fio', 'age', 'phone',], 'safe',],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Client::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if($this->validate() === false) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'fio' => $this->fio,
            'age' => $this->age,
            'phone' => $this->phone,
            ]);

        return $dataProvider;
    }
}
