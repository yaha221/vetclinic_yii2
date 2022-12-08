<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use app\models\Pet;
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

    public function actionUpdatepet($id = 0, $pet_id = 0)
    {
        if (Yii::$app->user->can('client')) {
            $fullForm = new PetForm();

            if (Yii::$app->request->isAjax && $fullForm->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($fullForm);
            }
            if ($fullForm->load(Yii::$app->request->post()) && $fullForm->validate()) {
                if ($id === 0) {
                    $compaint = new Pet();
                    $compaint['name'] = $fullForm['name'];
                    $compaint['description'] = $fullForm['description'];
                    $compaint['pet_id'] = $pet_id;
                    $compaint->save();
                    return $this->goBack();
                }
                $compaint = Pet::find()->where(['id' => $id])->one();
                $compaint['name'] = $fullForm['name'];
                $compaint['description'] = $fullForm['description'];
                $compaint->save();
                return $this->goBack();
            }
            return $this->render('create', [
                'fullForm' => $fullForm,
                'title' => 'Препарат',
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