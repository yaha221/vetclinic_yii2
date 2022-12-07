<?php
    $this->title = $title;

    use yii\grid\GridView;
    use yii\widgets\Pjax;
    use yii\helpers\Html;
?>
    <div class="row mt-5 p-5">
    <p>
        <?php
        if ($title === 'Жалобы') {
            echo Html::a(Yii::t('','Добавить {modelClass}', [
                'modelClass' => 'жалобы',
            ]), ['updatecompaint', 'pet_id'=>$pet_id], ['class' => 'btn btn-success']);
        }

        if ($title === 'Препараты' && Yii::$app->user->can('vet')) {
            echo Html::a(Yii::t('','Добавить {modelClass}', [
                'modelClass' => 'препарат',
            ]), ['updatemedication', 'pet_id'=>$pet_id], ['class' => 'btn btn-success']);
        }

        if ($title === 'Лечение' && Yii::$app->user->can('vet')) {
            echo  Html::a(Yii::t('','Добавить {modelClass}', [
                'modelClass' => 'ход лечения',
            ]), ['updatecourseoftreatment', 'pet_id'=>$pet_id], ['class' => 'btn btn-success']);
        } 
    ?>
    </p>
    <?php Pjax::begin() ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'emptyText' => 'Ничего не найдено',
            'columns' => [
                'name',
                'description',
                'created_at',
                [
                    'class' => \yii\grid\ActionColumn::className(),
                    'header' => 'Действия',
                    'visible' => Yii::$app->user->can('vet'),
                    'visibleButtons' => [
                        'update-compaint' => $title === 'Жалобы',
                        'delete-compaint' => $title === 'Жалобы',
                        'update-medication' => $title === 'Препараты',
                        'delete-medication' => $title === 'Препараты',
                        'update-courseoftreatment' => $title === 'Лечение',
                        'delete-courseoftreatment' => $title === 'Лечение',
                    ],
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
                        }
                    ],
                    'template' => '{update-compaint} {update-medication} {update-courseoftreatment} {delete-compaint} {delete-medication} {delete-courseoftreatment}',
                ],
            ],
        ]); ?>
    <?php Pjax::end() ?>
    </div>