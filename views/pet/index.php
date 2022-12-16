<?php
    $this->title = $title;
    
    use yii\grid\GridView;
    use yii\widgets\Pjax;
    use yii\helpers\Html;
    ?>
    <div class="row mt-5 p-5">
        <p>
            <?= Html::a(Yii::t('','Добавить {modelClass}', [
                'modelClass' => 'жалобы',
            ]), ['updatecompaint', 'pet_id'=>$pet_id], ['class' => 'btn btn-success']); ?>
    </p>
    <?php Pjax::begin() ?>
        <?= GridView::widget([
            'dataProvider' => $dataProviderCompaint,
            'emptyText' => 'Ничего не найдено',
            'columns' => [
                'name',
                'description',
                'create_at',
                [
                    'class' => \yii\grid\ActionColumn::className(),
                    'header' => 'Действия',
                    'visible' => Yii::$app->user->can('vet') || Yii::$app->user->can('administrator'),
                    'buttons' => [
                        'update-medication' => function ($url, $model) {
                            $customurl=Yii::$app->getUrlManager()->createUrl(['/pet/updatemedication','id'=>$model['id']]); 
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $customurl,
                            ['title' => Yii::t('yii', 'Редактировать препарат'), 'data-pjax' => '0']);
                        },
                        'delete-medication' => function ($url, $model) {
                            $customurl=Yii::$app->getUrlManager()->createUrl(['/pet/deletemedication','id'=>$model['id']]);
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-trash"></span>', $customurl,
                                                    ['title' => Yii::t('yii', 'Удалить препарат'), 'data-pjax' => '0', 
                                                    'data-confirm' => 'Вы уверены что хотите удалить препарат?', 
                                                    'data-method' => 'post']);
                        },
                    ],
                    'template' => '{update-medication} {delete-medication}',
                ],
            ],
        ]); ?>
    <?php Pjax::end() ?>
</div>
<div class="row mt-5 p-5">
            <p><?php 
        if (Yii::$app->user->can('vet')) {
        echo Html::a(Yii::t('','Добавить {modelClass}', [
                'modelClass' => 'ход лечения',
            ]), ['updatecourseoftreatment', 'pet_id'=>$pet_id], ['class' => 'btn btn-success']);
        }
            ?>
    </p>
    <?php Pjax::begin() ?>
    <?= GridView::widget([
            'dataProvider' => $dataProviderCourseoftreatment,
            'emptyText' => 'Ничего не найдено',
            'columns' => [
                'name',
                'description',
                'create_at',
                [
                    'class' => \yii\grid\ActionColumn::className(),
                    'header' => 'Действия',
                    'visible' => Yii::$app->user->can('vet'),
                    'buttons' => [
                        'update-courseoftreatment' => function ($url, $model) {
                            $customurl=Yii::$app->getUrlManager()->createUrl(['/pet/updatecourseoftreatment','id'=>$model['id']]); 
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $customurl,
                            ['title' => Yii::t('yii', 'Редактировать ход лечения'), 'data-pjax' => '0']);
                        },
                        'delete-courseoftreatment' => function ($url, $model) {
                            $customurl=Yii::$app->getUrlManager()->createUrl(['/pet/deletecourseoftreatment','id'=>$model['id']]);
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-trash"></span>', $customurl,
                            ['title' => Yii::t('yii', 'Удалить ход лечения'), 'data-pjax' => '0', 
                            'data-confirm' => 'Вы уверены что хотите удалить ход лечения?', 
                            'data-method' => 'post']);
                        },
                    ],
                    'template' => '{update-courseoftreatment} {delete-courseoftreatment}',
                ],
            ],
        ]); ?>
    <?php Pjax::end() ?>
</div>
<div class="row mt-5 p-5">
    <p><?php 
        if (Yii::$app->user->can('vet')) {
            echo Html::a(Yii::t('','Добавить {modelClass}', [
                'modelClass' => 'препарат',
            ]), ['updatemedication', 'pet_id'=>$pet_id], ['class' => 'btn btn-success']);
        } ?>
</p>
<?php Pjax::begin() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProviderMedication,
        'emptyText' => 'Ничего не найдено',
        'columns' => [
            'name',
            'description',
            'create_at',
            [
                'class' => \yii\grid\ActionColumn::className(),
                'header' => 'Действия',
                'visible' => Yii::$app->user->can('vet'),
                'buttons' => [
                    'update-compaint' => function ($url, $model) {
                        $customurl=Yii::$app->getUrlManager()->createUrl(['/pet/updatecompaint','id'=>$model['id']]); 
                        return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $customurl,
                        ['title' => Yii::t('yii', 'Редактировать жалобу'), 'data-pjax' => '0']);
                    },
                    'delete-compaint' => function ($url, $model) {
                        $customurl=Yii::$app->getUrlManager()->createUrl(['/pet/deletecompaint','id'=>$model['id'],]);
                        return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-trash"></span>', $customurl,
                                                ['title' => Yii::t('yii', 'Удалить жалобу'), 'data-pjax' => '0', 
                                                'data-confirm' => 'Вы уверены что хотите удалить жалобу?', 
                                                'data-method' => 'post']);
                    },
                ],
                'template' => '{update-compaint} {delete-compaint} ',
            ],
        ],
    ]); ?>
<?php Pjax::end() ?>
</div>