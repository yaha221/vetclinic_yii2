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
                [
                    'class' => \yii\grid\ActionColumn::className(),
                    'header' => 'Жалобы',
                    'visibleButtons' =>[
                        'delete' => \Yii::$app->user->can('admin'),
                    ],
                    'buttons' => [
                        'view' => function ($url, $model) {
                            $customurl=Yii::$app->getUrlManager()->createUrl(['/pet/compaint','id'=>$model['id']]); 
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-eye-open"></span>', $customurl,
                                                    ['title' => Yii::t('yii', 'Посмотреть'), 'data-pjax' => '0']);
                        },
                    ],
                    'template' => '{view}',
                ],
                [
                    'class' => \yii\grid\ActionColumn::className(),
                    'header' => 'Ход лечения',
                    'visibleButtons' =>[
                        'delete' => \Yii::$app->user->can('admin'),
                    ],
                    'buttons' => [
                        'view' => function ($url, $model) {
                            $customurl=Yii::$app->getUrlManager()->createUrl(['/pet/courseoftreatment','id'=>$model['id']]); 
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-eye-open"></span>', $customurl,
                                                    ['title' => Yii::t('yii', 'Посмотреть'), 'data-pjax' => '0']);
                        },
                    ],
                    'template' => '{view}',
                ],
                [
                    'class' => \yii\grid\ActionColumn::className(),
                    'header' => 'Лекарства',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            $customurl=Yii::$app->getUrlManager()->createUrl(['/pet/medication','id'=>$model['id']]); 
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-eye-open"></span>', $customurl,
                                                    ['title' => Yii::t('yii', 'Посмотреть'), 'data-pjax' => '0']);
                        },
                    ],
                    'template' => '{view}',
                ],
                'created_at',
                [
                    'class' => \yii\grid\ActionColumn::className(),
                    'header' => 'Действия',
                    'visible' => Yii::$app->user->can('admin'),
                    'buttons' => [
                        'update' => function ($url, $model) {
                            $customurl=Yii::$app->getUrlManager()->createUrl(['/pet/update','id'=>$model['id']]); 
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $customurl,
                                                    ['title' => Yii::t('yii', 'Редактировать'), 'data-pjax' => '0']);
                        },
                        'delete' => function ($url, $model) {
                            $customurl=Yii::$app->getUrlManager()->createUrl(['/pet/delete','id'=>$model['id']]);
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-trash"></span>', $customurl,
                                                    ['title' => Yii::t('yii', 'Удалить'), 'data-pjax' => '0', 
                                                    'data-confirm' => 'Вы уверены что хотите удалить запрос?', 
                                                    'data-method' => 'post']);
                        }
                    ],
                    'template' => '{update} {delete}',
                ],
            ],
        ]); ?>
    <?php Pjax::end() ?>
    </div>