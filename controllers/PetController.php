<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use app\models\Medication;
use app\models\Compaint;
use app\models\Courseoftreatment;
use app\models\form\MedicationForm;
use app\models\form\CompaintForm;
use app\models\form\CourseoftreatmentForm;
use Faker\Provider\Medical;

/**
 * HomeController отвечает за работу калькулятором доставки
 */
class PetController extends Controller
{
    /**
     * Отображение домашней страницы и ajax валидация формы
     * 
     * @return mixed
     */
    public function actionMore($id)
    {
        if (Yii::$app->user->can('client')) {
            $dataProviderCompaint = new ActiveDataProvider([
                'query' => Compaint::find()->where(['pet_id' => $id]),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
            $dataProviderCourseoftreatment = new ActiveDataProvider([
                'query' => Courseoftreatment::find()->where(['pet_id' => $id]),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
            $dataProviderMedication = new ActiveDataProvider([
                'query' => Medication::find()->where(['pet_id' => $id]),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
            return $this->render('index', [
                'dataProviderCompaint' => $dataProviderCompaint,
                'dataProviderCourseoftreatment' => $dataProviderCourseoftreatment,
                'dataProviderMedication' => $dataProviderMedication,
                'title' => 'Подробности',
                'pet_id' => $id,
            ]);
        }
        return $this->redirect('/user/security/login');
    }

    public function actionUpdatecompaint($id = 0, $pet_id = 0)
    {
        if (Yii::$app->user->can('client')) {
            $fullForm = new CompaintForm();
            if (Yii::$app->request->isAjax && $fullForm->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($fullForm);
            }
            if ($fullForm->load(Yii::$app->request->post()) && $fullForm->validate()) {
                if ($id === 0) {
                    $compaint = new Compaint();
                    $compaint['name'] = $fullForm['name'];
                    $compaint['description'] = $fullForm['description'];
                    $compaint['pet_id'] = $pet_id;
                    $compaint->save();
                    return $this->goBack();
                }
                $compaint = compaint::find()->where(['id' => $id])->one();
                $compaint['name'] = $fullForm['name'];
                $compaint['description'] = $fullForm['description'];
                $compaint->save();
                return $this->goBack();
            }
            return $this->render('create', [
                'fullForm' => $fullForm,
                'title' => 'Жалоба',
            ]);
        }
        return $this->redirect('/user/security/login');
    }

    public function actionDeletecompaint($id, $pet_id = 0)
    {
        if (Yii::$app->user->can('client')) {
            Compaint::findOne($id)->delete();
            return $this->goBack();
        }
        return $this->redirect('/user/security/login');
    }

    public function actionUpdatecourseoftreatment($id = 0, $pet_id = 0)
    {
        if (Yii::$app->user->can('client')) {
            $fullForm = new CourseoftreatmentForm();
            if (Yii::$app->request->isAjax && $fullForm->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($fullForm);
            }
            if ($fullForm->load(Yii::$app->request->post()) && $fullForm->validate()) {
                if ($id === 0) {
                    $compaint = new Courseoftreatment();
                    $compaint['name'] = $fullForm['name'];
                    $compaint['description'] = $fullForm['description'];
                    $compaint['pet_id'] = $pet_id;
                    $compaint->save();
                    return $this->goBack();
                }
                $compaint = Courseoftreatment::find()->where(['id' => $id])->one();
                $compaint['name'] = $fullForm['name'];
                $compaint['description'] = $fullForm['description'];
                $compaint->save();
                return $this->goBack();
            }
            return $this->render('create', [
                'fullForm' => $fullForm,
                'title' => 'Лечение',
            ]);
        }
        return $this->redirect('/user/security/login');
    }

    public function actionDeletecourseoftreatment($id)
    {
        if (Yii::$app->user->can('client')) {
            Courseoftreatment::findOne($id)->delete();
            return $this->goBack();
        }
        return $this->redirect('/user/security/login');
    }
    
    public function actionUpdatemedication($id = 0, $pet_id = 0)
    {
        if (Yii::$app->user->can('client')) {
            $fullForm = new MedicationForm();
            if (Yii::$app->request->isAjax && $fullForm->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($fullForm);
            }
            if ($fullForm->load(Yii::$app->request->post()) && $fullForm->validate()) {
                if ($id === 0) {
                    $compaint = new Medication();
                    $compaint['name'] = $fullForm['name'];
                    $compaint['description'] = $fullForm['description'];
                    $compaint['pet_id'] = $pet_id;
                    $compaint->save();
                    return $this->goBack();
                }
                $compaint = Medication::find()->where(['id' => $id])->one();
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

    public function actionDeletemedication($id)
    {
        if (Yii::$app->user->can('client')) {
            Medication::findOne($id)->delete();
            return $this->goBack();
        }
        return $this->redirect('/user/security/login');
    }
}