<?php

namespace nkostadinov\user\controllers;

use nkostadinov\user\models\user;
use nkostadinov\user\Module;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * AdminController implements the CRUD actions for user model.
 */
class AdminController extends BaseController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => Yii::$app->user->adminRules,
            ]
        ];
    }

    /**
     * Lists all user models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!\Yii::$app->user->can('viewAdminPage')) {
            throw new ForbiddenHttpException('Access denied');
        }
        Yii::info('Admin ['. Yii::$app->user->identity->email .'] is entering the admin/index page', __CLASS__);

        $dataProvider = new ActiveDataProvider([
            'query' => Yii::$app->user->listUsers(),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        

        return $this->render('index', [
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single user model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (!\Yii::$app->user->can('viewAdminPage')) {
            throw new ForbiddenHttpException('Access denied');
        }
        Yii::info('Admin ['. Yii::$app->user->identity->email ."] is entering the admin/view/$id page", __CLASS__);
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new user model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!\Yii::$app->user->can('viewAdminPage')) {
            throw new ForbiddenHttpException('Access denied');
        }
        Yii::info('Admin ['. Yii::$app->user->identity->email .'] is entering the admin/create page', __CLASS__);
        
        $model = new Yii::$app->user->identityClass();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::info('Admin ['. Yii::$app->user->identity->email ."] successfuly created user [$model->email]", __CLASS__);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing user model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * 
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (!\Yii::$app->user->can('viewAdminPage')) {
            throw new ForbiddenHttpException('Access denied');
        }
        Yii::info('Admin ['. Yii::$app->user->identity->email ."] is entering the admin/update/$id page", __CLASS__);


        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::info('Admin ['. Yii::$app->user->identity->email ."] successfuly updated user [$model->email]", __CLASS__);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    
    /**
     * Deletes an existing user model.
     *
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (!\Yii::$app->user->can('viewAdminPage')) {
            throw new ForbiddenHttpException('Access denied');
        }
        Yii::info('Admin ['. Yii::$app->user->identity->email ."] is deleting user [$id]", __CLASS__);
        call_user_func([Yii::$app->user->identityClass, 'deleteById'], ['id' => $id]);
        Yii::info('Admin ['. Yii::$app->user->identity->email ."] successfuly deleted user [$id]", __CLASS__);
        
        return $this->redirect(['index']);
    }

    /**
     * Finds the user model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return user the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (!\Yii::$app->user->can('viewAdminPage')) {
            throw new ForbiddenHttpException('Access denied');
        }
        if (($model = Yii::$app->user->listUsers()->andWhere(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t(Module::I18N_CATEGORY, 'The requested page does not exist.'));
        }
    }
}
