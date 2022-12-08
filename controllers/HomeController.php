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
use app\models\form\ClientForm;
use app\models\form\VetForm;
use app\models\form\AdministratorForm;
use nkostadinov\user\models\User;

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
                'title' => 'Админка',
            ]);
        }
        if (Yii::$app->user->can('administrator')) {
            $dataProviderClient = new ActiveDataProvider([
                'query' => Client::find(),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
            return $this->render('index', [
                'dataProviderClient' => $dataProviderClient,
                'title' => 'Клиенты',
            ]);
        }
        if (Yii::$app->user->can('vet')) {
            $dataProviderPet = new ActiveDataProvider([
                'query' => Pet::find(),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
            return $this->render('index', [
                'dataProviderPet' => $dataProviderPet,
                'title' => 'Животные',
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
                'dataProviderPet' => $dataProvider,
                'title' => 'Животные',
            ]);
        }
        return $this->redirect('/user/security/login');
    }

    public function actionUpdatepet($id = 0, $pet_id = 0)
    {
        if (Yii::$app->user->can('administrator')||Yii::$app->user->can('vet')) {
            $fullForm = new PetForm();
            $vet = Vet::find()->all();
            $client = Client::find()->all();
            $vets = [];
            $clients = [];
            foreach ($vet as $value) {
                $vets[$value['id']] = $value['fio'];
            }
            foreach ($client as $value) {
                $clients[$value['user_id']] = $value['fio'];
            }
            if (Yii::$app->request->isAjax && $fullForm->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($fullForm);
            }
            if ($fullForm->load(Yii::$app->request->post()) && $fullForm->validate()) {
                if ($id === 0) {
                    $object = new Pet();
                    $object['name'] = $fullForm['name'];
                    $object['vet_id'] = $fullForm['vet'];
                    $object['client_id'] = $fullForm['client'];
                    $object->save();
                    return $this->goBack();
                }
                $object = Pet::find()->where(['id' => $id])->one();
                $object['name'] = $fullForm['name'];
                $object['vet_id'] = $fullForm['vet']['id'];
                $object->save();
                return $this->goBack();
            }
            return $this->render('updatepet', [
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
        if (Yii::$app->user->can('administrator')||Yii::$app->user->can('vet')) {
            Pet::findOne($id)->delete();
            return $this->goBack();
        }
        return $this->redirect('/user/security/login');
    }

    public function actionViewpets($id)
    {
        if (Yii::$app->user->can('administrator')) {
            $dataProvider = new ActiveDataProvider([
                'query' => Pet::find()->where(['client_id' => $id]),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
            return $this->render('viewpets', [
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionUpdateclient($id = 0, $pet_id = 0)
    {
        if (Yii::$app->user->can('administrator')) {
            $fullForm = new ClientForm();
            $user = User::find()->all();
            $users = [];
            foreach ($user as $value) {
                $users[$value['id']] = $value['username'];
            }
            if (Yii::$app->request->isAjax && $fullForm->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($fullForm);
            }
            if ($fullForm->load(Yii::$app->request->post()) && $fullForm->validate()) {
                if ($id === 0) {
                    $object = new Client();
                    $object['fio'] = $fullForm['fio'];
                    $object['age'] = $fullForm['age'];
                    $object['phone'] = $fullForm['phone'];
                    $object['user_id'] = $fullForm['user'];
                    $object->save();
                    return $this->goBack();
                }
                $object = Client::find()->where(['id' => $id])->one();
                $object['fio'] = $fullForm['fio'];
                $object['age'] = $fullForm['age'];
                $object['phone'] = $fullForm['phone'];
                $object->save();
                return $this->goBack();
            }
            return $this->render('updateclient', [
                'fullForm' => $fullForm,
                'title' => 'Клиент',
                'users' => $users,
            ]);
        }
        return $this->redirect('/user/security/login');
    }

    public function actionDeleteclient($id)
    {
        if (Yii::$app->user->can('administrator')) {
            Client::findOne($id)->delete();
            return $this->goBack();
        }
        return $this->redirect('/user/security/login');
    }

    public function actionUpdatevet($id = 0, $pet_id = 0)
    {
        if (Yii::$app->user->can('admin')) {
            $fullForm = new VetForm();
            $user = User::find()->all();
            $users = [];
            foreach ($user as $value) {
                $users[$value['id']] = $value['username'];
            }
            if (Yii::$app->request->isAjax && $fullForm->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($fullForm);
            }
            if ($fullForm->load(Yii::$app->request->post()) && $fullForm->validate()) {
                if ($id === 0) {
                    $object = new Vet();
                    $object['fio'] = $fullForm['fio'];
                    $object['age'] = $fullForm['age'];
                    $object['phone'] = $fullForm['phone'];
                    $object['experience'] = $fullForm['experience'];
                    $object['education'] = $fullForm['education'];
                    $object['wage'] = $fullForm['wage'];
                    $object['user_id'] = $fullForm['user'];
                    $object->save();
                    return $this->goBack();
                }
                $object = Vet::find()->where(['id' => $id])->one();
                $object['fio'] = $fullForm['fio'];
                $object['age'] = $fullForm['age'];
                $object['phone'] = $fullForm['phone'];
                $object['experience'] = $fullForm['experience'];
                $object['education'] = $fullForm['education'];
                $object['wage'] = $fullForm['wage'];
                $object->save();
                return $this->goBack();
            }
            return $this->render('updatevet', [
                'fullForm' => $fullForm,
                'title' => 'Ветеринар',
                'users' => $users,
            ]);
        }
        return $this->redirect('/user/security/login');
    }

    public function actionDeletevet($id)
    {
        if (Yii::$app->user->can('admin')) {
            Vet::findOne($id)->delete();
            return $this->goBack();
        }
        return $this->redirect('/user/security/login');
    }

    public function actionUpdateadministrator($id = 0, $pet_id = 0)
    {
        if (Yii::$app->user->can('admin')) {
            $fullForm = new AdministratorForm();
            $user = User::find()->all();
            $users = [];
            foreach ($user as $value) {
                $users[$value['id']] = $value['username'];
            }
            if (Yii::$app->request->isAjax && $fullForm->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($fullForm);
            }
            if ($fullForm->load(Yii::$app->request->post()) && $fullForm->validate()) {
                if ($id === 0) {
                    $object = new Administrator();
                    $object['fio'] = $fullForm['fio'];
                    $object['age'] = $fullForm['age'];
                    $object['phone'] = $fullForm['phone'];
                    $object['experience'] = $fullForm['experience'];
                    $object['wage'] = $fullForm['wage'];
                    $object['user_id'] = $fullForm['user'];
                    $object->save();
                    return $this->goBack();
                }
                $object = Administrator::find()->where(['id' => $id])->one();
                $object['fio'] = $fullForm['fio'];
                $object['age'] = $fullForm['age'];
                $object['phone'] = $fullForm['phone'];
                $object['experience'] = $fullForm['experience'];
                $object['wage'] = $fullForm['wage'];
                $object->save();
                return $this->goBack();
            }
            return $this->render('updateadministrator', [
                'fullForm' => $fullForm,
                'title' => 'Ветеринар',
                'users' => $users,
            ]);
        }
        return $this->redirect('/user/security/login');
    }

    public function actionDeleteadministrator($id)
    {
        if (Yii::$app->user->can('admin')) {
            Administrator::findOne($id)->delete();
            return $this->goBack();
        }
        return $this->redirect('/user/security/login');
    }
}