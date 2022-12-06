<?php

use nkostadinov\user\Module;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model nkostadinov\user\models\user */

$this->title = Yii::t(Module::I18N_CATEGORY, 'Обновить {modelClass}: ', [
    'modelClass' => 'Пользователя',
]) . " $model->username #$model->id";
$this->params['breadcrumbs'][] = ['label' => Yii::t(Module::I18N_CATEGORY, 'Пользователи'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "$model->username #$model->id", 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t(Module::I18N_CATEGORY, 'Редактировать');
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
