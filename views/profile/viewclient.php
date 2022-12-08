<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

$this->title = 'Профиль';
?>

<div class="row mt-5 p-5">
<p>
        <?= Html::a(Yii::t('','Обновить {modelClass}', [
            'modelClass' => 'данные',
        ]), ['update'], ['class' => 'btn btn-success']) ?>
</p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fio',
            'age',
            'phone',
        ],
    ])?>
</div>