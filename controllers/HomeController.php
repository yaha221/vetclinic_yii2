<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use app\models\Pet;
use app\models\Vet;
use app\models\Administrator;
use app\models\Client;
use app\models\form\PetForm;


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
            $dataProviderPet = new ActiveDataProvider([
                'query' => Pet::find(),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
            $dataProviderClient = new ActiveDataProvider([
                'query' => Client::find(),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
            $dataProviderVet = new ActiveDataProvider([
                'query' => Vet::find(),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
            $dataProviderAdministrator = new ActiveDataProvider([
                'query' => Administrator::find(),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
            return $this->render('index', [
                'dataProviderPet' => $dataProviderPet,
                'dataProviderClient' => $dataProviderClient,
                'dataProviderVet' => $dataProviderVet,
                'dataProviderAdministrator' => $dataProviderAdministrator,
            ]);
        }
        if (Yii::$app->user->can('administrator')) {
            $dataProviderPet = new ActiveDataProvider([
                'query' => Pet::find(),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
            $dataProviderClient = new ActiveDataProvider([
                'query' => Client::find(),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
            return $this->render('index', [
                'dataProviderPet' => $dataProviderPet,
                'dataProviderClient' => $dataProviderClient,
            ]);
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

    public function actionUpdatepet($id = 0, $pet_id = 0)
    {
        if (Yii::$app->user->can('client')) {
            $fullForm = new PetForm();
            $vet = Vet::find()->all();
            $client = Client::find()->all();
            $vets = [];
            $clients = [];
            foreach ($vet as $value) {
                $vets[$value['id']] = $value['fio'];
            }
            foreach ($client as $value) {
                $clients[$value['id']] = $value['fio'];
            }
            if (Yii::$app->request->isAjax && $fullForm->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($fullForm);
            }
            if ($fullForm->load(Yii::$app->request->post()) && $fullForm->validate()) {
                if ($id === 0) {
                    $object = new Pet();
                    $object['name'] = $fullForm['name'];
                    $object['vet_id'] = $fullForm['vet']['id'];
                    $object['client_id'] = $fullForm['client']['id'];
                    $object->save();
                    return $this->goBack();
                }
                $object = Pet::find()->where(['id' => $id])->one();
                $object['name'] = $fullForm['name'];
                $object['vet_id'] = $fullForm['vet']['id'];
                $object->save();
                return $this->goBack();
            }
            return $this->render('update', [
                'fullForm' => $fullForm,
                'title' => 'Питомец',
                'vets' => $vets,
                'clients' => $clients,
            ]);
        }
        return $this->redirect('/user/security/login');
    }

    public function actionDeletepet($id)
    {
        if (Yii::$app->user->can('client')) {
            Pet::findOne($id)->delete();
            return $this->goBack();
        }
        return $this->redirect('/user/security/login');
    }
}