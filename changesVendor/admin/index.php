<?php

use nkostadinov\user\Module;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t(Module::I18N_CATEGORY, 'Пользователи');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t(Module::I18N_CATEGORY, 'Создать {modelClass}', [
            'modelClass' => 'пользователя',
        ]), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t(Module::I18N_CATEGORY, 'Обновить {modelClass}', [
            'modelClass' => 'роли',
        ]), ['/role'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => $this->context->module->adminColumns,
    ]); ?>
    <?php Pjax::end() ?>

</div>
