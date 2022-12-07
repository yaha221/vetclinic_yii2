<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use app\models\Client;
use app\models\form\ClientForm;
use yii\web\ForbiddenHttpException;

/**
 * HomeController отвечает за работу калькулятором доставки
 */
class ProfileController extends Controller
{
    /**
     * Отображение домашней страницы и ajax валидация формы
     * 
     * @return mixed
     */
    public function actionView()
    {
        if (Yii::$app->user->can('vet')) {
            $dataProvider = new ActiveDataProvider([
                'query' => Client::find()->where(['user_id' => Yii::$app->user->id])->one(),
            ]);
            return $this->render('view', [
                'dataProvider' => $dataProvider,
            ]);
        }
        if (Yii::$app->user->can('administrator')) {
            
        }
        if (Yii::$app->user->can('client')) {
            $model = Client::find()->where(['user_id' => Yii::$app->user->id])->one();
            return $this->render('view', [
                'model' => $model,
            ]);
        }
        return $this->redirect('/user/security/login');
    }
    public function actionUpdate()
    {
        if (Yii::$app->user->can('vet')) {
            $dataProvider='';
            return $this->render('view', [
                'dataProvider' => $dataProvider,
            ]);
        }
        if (Yii::$app->user->can('administrator')) {
            
        }
        if (Yii::$app->user->can('client')) {
            $clientForm = new ClientForm();
            if (Yii::$app->request->isAjax && $clientForm->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($clientForm);
            }
            if ($clientForm->load(Yii::$app->request->post()) && $clientForm->validate()) {
                $client = Client::find()->where(['user_id' => Yii::$app->user->id])->one();
                $client['fio'] = $clientForm['fio'];
                $client['age'] = $clientForm['age'];
                $client['phone'] = $clientForm['phone'];
                $client->save();
                return $this->redirect('view');
            }
            return $this->render('update', [
                'clientForm' => $clientForm,
            ]);
        }
        return $this->redirect('/user/security/login');
    }

    public function actionUpdateajax()
    {
        
    }
}