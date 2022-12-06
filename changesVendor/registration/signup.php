<?php

use nkostadinov\user\models\forms\SignupForm;
use nkostadinov\user\Module;
use yii\authclient\widgets\AuthChoice;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $model SignupForm */

$this->title = Yii::t(Module::I18N_CATEGORY, 'Регистрация');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'form-signup',
                    'options' => ['class' => 'form-vertical'],
                ]); ?>
                <?php if(Yii::$app->user->requireUsername === true)
                    echo $form->field($model, 'username')->textInput();
                ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'passwordAgain')->passwordInput()?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t(Module::I18N_CATEGORY, 'Регистрация'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <?php if (Yii::$app->get("authClientCollection", false)): ?>
            <div>
                <?= AuthChoice::widget([
                    'baseAuthUrl' => [ '/'.$this->context->module->id . '/security/auth'],
                    'popupMode' => false,
                ]) ?>
            </div>
        <?php endif; ?>
    </div>
</div>