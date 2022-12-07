<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use app\models\CalculatedForm;
use app\models\repositories\DataRepository;
use nkostadinov\user\models\User;
use app\models\UserRequest;
use yii\web\ForbiddenHttpException;

/**
 * HomeController отвечает за работу калькулятором доставки
 */
class HomeController extends Controller
{
    /**
     * Отображение домашней страницы и ajax валидация формы
     * 
     * @return mixed
     */
    public function actionIndex()
    {
        
    }

    
}