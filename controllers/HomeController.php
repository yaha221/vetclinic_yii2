<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use app\models\CalculatedForm;
use app\models\Pet;
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
        if (Yii::$app->user->can('admin')) {
            return $this->redirect('/user/admin');
        }
        if (Yii::$app->user->can('vet')) {
            $dataProvider = new ActiveDataProvider([
                'query' => Pet::find(),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
            return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);
        }
        if (Yii::$app->user->can('administrator')) {
            
        }
        if (Yii::$app->user->can('client')) {
            $dataProvider = new ActiveDataProvider([
                'query' => Pet::find()->where(['client_id' => Yii::$app->user->id]),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
            return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);
        }
        return $this->redirect('/user/security/login');
    }

    
}