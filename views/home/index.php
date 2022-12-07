<?php
    $this->title = 'Животные';

    use nkostadinov\user\models\User;
    use yii\grid\GridView;
    use yii\data\ActiveDataProvider;
    use yii\widgets\Pjax;
?>
    <div class="row mt-5 p-5">
    <?php Pjax::begin() ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'emptyText' => 'Ничего не найдено',
            'columns' => [
                'id',
                'name',
                'compaint_id',
                'medication_id',
                'course_of_treatment_id',
                'created_at',
            ],
        ]); ?>
    <?php Pjax::end() ?>
    </div>