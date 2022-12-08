<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use app\models\Client;
use app\models\Vet;
use app\models\Administrator;
use app\models\form\ClientForm;
use app\models\form\VetForm;
use app\models\form\AdministratorForm;

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
            $model = Vet::find()->where(['user_id' => Yii::$app->user->id])->one();
            return $this->render('viewvet', [
                'model' => $model,
            ]);
        }
        if (Yii::$app->user->can('administrator')) {
           $model = Administrator::find()->where(['user_id' => Yii::$app->user->id])->one();
            return $this->render('viewadministrator', [
                'model' => $model,
            ]);
        }
        if (Yii::$app->user->can('client')) {
            $model = Client::find()->where(['user_id' => Yii::$app->user->id])->one();
            return $this->render('viewclient', [
                'model' => $model,
            ]);
        }
        return $this->redirect('/user/security/login');
    }

    public function actionUpdate()
    {
        if (Yii::$app->user->can('vet')) {
            $fullForm = new VetForm();
            if (Yii::$app->request->isAjax && $fullForm->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($fullForm);
            }
            if ($fullForm->load(Yii::$app->request->post()) && $fullForm->validate()) {
                $object = Vet::find()->where(['user_id' => Yii::$app->user->id])->one();
                $object['fio'] = $fullForm['fio'];
                $object['age'] = $fullForm['age'];
                $object['phone'] = $fullForm['phone'];
                $object['experience'] = $fullForm['experience'];
                $object['education'] = $fullForm['education'];
                $object->save();
                return $this->redirect('view');
            }
            return $this->render('updatevet', [
                'fullForm' => $fullForm,
            ]);
        }
        if (Yii::$app->user->can('administrator')) {
            $fullForm = new AdministratorForm();
            if (Yii::$app->request->isAjax && $fullForm->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($fullForm);
            }
            if ($fullForm->load(Yii::$app->request->post()) && $fullForm->validate()) {
                $object = Administrator::find()->where(['user_id' => Yii::$app->user->id])->one();
                $object['fio'] = $fullForm['fio'];
                $object['age'] = $fullForm['age'];
                $object['phone'] = $fullForm['phone'];
                $object['experience'] = $fullForm['experience'];
                $object->save();
                return $this->redirect('view');
            }
            return $this->render('updateadministrator', [
                'fullForm' => $fullForm,
            ]);
        }
        if (Yii::$app->user->can('client')) {
            $fullForm = new ClientForm();
            if (Yii::$app->request->isAjax && $fullForm->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($fullForm);
            }
            if ($fullForm->load(Yii::$app->request->post()) && $fullForm->validate()) {
                $object = Client::find()->where(['user_id' => Yii::$app->user->id])->one();
                $object['fio'] = $fullForm['fio'];
                $object['age'] = $fullForm['age'];
                $object['phone'] = $fullForm['phone'];
                $object->save();
                return $this->redirect('view');
            }
            return $this->render('updateclient', [
                'fullForm' => $fullForm,
            ]);
        }
        return $this->redirect('/user/security/login');
    }

}