<?php
    $this->title = $title;

    use yii\grid\GridView;
    use yii\widgets\Pjax;
    use yii\helpers\Html;
?>
    <div class="row mt-5 p-3">
    <p><?php 
    if (Yii::$app->user->can('vet')) {
        echo Html::a(Yii::t('','Добавить {modelClass}', [
            'modelClass' => 'животное',
        ]), ['updatepet'], ['class' => 'btn btn-success']); 
    }
?>
    </p>
    <?php Pjax::begin() ?>
        <?php if (Yii::$app->user->can('client') && $is_Administrator === false) {
            echo GridView::widget([
                'dataProvider' => $dataProviderPet,
                'emptyText' => 'Ничего не найдено',
                'columns' => [
                    'id',
                    'name',
                    [
                    'class' => \yii\grid\ActionColumn::className(),
                    'header' => 'Подробности',
                    'visibleButtons' =>[
                        'delete' => \Yii::$app->user->can('admin'),
                    ],
                    'buttons' => [
                        'view' => function ($url, $model) {
                            $customurl=Yii::$app->getUrlManager()->createUrl(['/pet/more','id'=>$model['id']]); 
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-eye-open"></span>', $customurl,
                                                    ['title' => Yii::t('yii', 'Посмотреть'), 'data-pjax' => '0']);
                        },
                    ],
                    'template' => '{view}',
                ],
                'create_at',
                [
                    'class' => \yii\grid\ActionColumn::className(),
                    'header' => 'Действия',
                    'visible' => Yii::$app->user->can('vet'),
                    'buttons' => [
                        'update' => function ($url, $model) {
                            $customurl=Yii::$app->getUrlManager()->createUrl(['/home/updatepet','id'=>$model['id']]); 
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $customurl,
                            ['title' => Yii::t('yii', 'Редактировать'), 'data-pjax' => '0']);
                        },
                        'delete' => function ($url, $model) {
                            $customurl=Yii::$app->getUrlManager()->createUrl(['/home/deletepet','id'=>$model['id']]);
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-trash"></span>', $customurl,
                            ['title' => Yii::t('yii', 'Удалить'), 'data-pjax' => '0', 
                            'data-confirm' => 'Вы уверены что хотите удалить животное?', 
                            'data-method' => 'post']);
                        }
                    ],
                    'template' => '{update} {delete}',
                ],
            ],
        ]);
    }
?>
    <?php Pjax::end() ?>
    </div>
    <div class="row mt-5 p-3">
    <p>
        <?php if (Yii::$app->user->can('administrator')) {
        
        echo Html::a(Yii::t('','Добавить {modelClass}', [
            'modelClass' => 'клиента',
        ]), ['updateclient'], ['class' => 'btn btn-success']);
    }
        ?>
    </p>
    <?php Pjax::begin() ?>
        <?php if (Yii::$app->user->can('administrator')) {
        echo GridView::widget([
            'dataProvider' => $dataProviderClient,
            'filterModel' => $searchClient,
            'emptyText' => 'Ничего не найдено',
            'columns' => [
                'id',
                'fio',
                'age',
                'phone',
                'create_at',
                [
                    'class' => \yii\grid\ActionColumn::className(),
                    'header' => 'Действия',
                    'visible' => Yii::$app->user->can('administrator'),
                    'buttons' => [
                        'view' => function ($url, $model) {
                            $customurl=Yii::$app->getUrlManager()->createUrl(['/home/viewpets','id'=>$model['id']]); 
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-piggy-bank"></span>', $customurl,
                                                    ['title' => Yii::t('yii', 'Животные'), 'data-pjax' => '0']);
                        },
                        'print' => function ($url, $model) {
                            $customurl=Yii::$app->getUrlManager()->createUrl(['/home/print','id'=>$model['id']]); 
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-list-alt"></span>', $customurl,
                                                    ['title' => Yii::t('yii', 'Квитанция'), 'data-pjax' => '0']);
                        },
                        'update' => function ($url, $model) {
                            $customurl=Yii::$app->getUrlManager()->createUrl(['/home/updateclient','id'=>$model['id']]); 
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $customurl,
                                                    ['title' => Yii::t('yii', 'Редактировать'), 'data-pjax' => '0']);
                        },
                        'delete' => function ($url, $model) {
                            $customurl=Yii::$app->getUrlManager()->createUrl(['/home/deleteclient','id'=>$model['id']]);
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-trash"></span>', $customurl,
                                                    ['title' => Yii::t('yii', 'Удалить'), 'data-pjax' => '0', 
                                                    'data-confirm' => 'Вы уверены что хотите удалить запрос?', 
                                                    'data-method' => 'post']);
                        }
                    ],
                    'template' => '{view} {print} {update} {delete}',
                ],
            ],
        ]); 
    }
    ?>
    <?php Pjax::end() ?>
    </div>
    <div class="row mt-5 p-3">
    <p>
        <?php if (Yii::$app->user->can('admin')) {
        
        echo Html::a(Yii::t('','Добавить {modelClass}', [
            'modelClass' => 'ветеринара',
        ]), ['updatevet'], ['class' => 'btn btn-success']);
    }
        ?>
    </p>
    <?php Pjax::begin() ?>
        <?php if (Yii::$app->user->can('admin')) {
        echo GridView::widget([
            'dataProvider' => $dataProviderVet,
            'emptyText' => 'Ничего не найдено',
            'columns' => [
                'id',
                'fio',
                'age',
                'phone',
                'experience',
                'education',
                'wage',
                'create_at',
                [
                    'class' => \yii\grid\ActionColumn::className(),
                    'header' => 'Действия',
                    'visible' => Yii::$app->user->can('admin'),
                    'buttons' => [
                        'update' => function ($url, $model) {
                            $customurl=Yii::$app->getUrlManager()->createUrl(['/home/updatevet','id'=>$model['id']]); 
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $customurl,
                                                    ['title' => Yii::t('yii', 'Редактировать'), 'data-pjax' => '0']);
                        },
                        'delete' => function ($url, $model) {
                            $customurl=Yii::$app->getUrlManager()->createUrl(['/home/deletevet','id'=>$model['id']]);
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-trash"></span>', $customurl,
                                                    ['title' => Yii::t('yii', 'Удалить'), 'data-pjax' => '0', 
                                                    'data-confirm' => 'Вы уверены что хотите удалить запрос?', 
                                                    'data-method' => 'post']);
                        }
                    ],
                    'template' => '{update} {delete}',
                ],
            ],
        ]); 
    }
    ?>
    <?php Pjax::end() ?>
    </div>
    <div class="row mt-5 p-3">
    <p>
        <?php if (Yii::$app->user->can('admin')) {
        
        echo Html::a(Yii::t('','Добавить {modelClass}', [
            'modelClass' => 'администратора',
        ]), ['updateadministrator'], ['class' => 'btn btn-success']);
    }
        ?>
    </p>
    <?php Pjax::begin() ?>
        <?php if (Yii::$app->user->can('admin')) {
        echo GridView::widget([
            'dataProvider' => $dataProviderAdministrator,
            'emptyText' => 'Ничего не найдено',
            'columns' => [
                'id',
                'fio',
                'age',
                'experience',
                'wage',
                'create_at',
                [
                    'class' => \yii\grid\ActionColumn::className(),
                    'header' => 'Действия',
                    'visible' => Yii::$app->user->can('admin'),
                    'buttons' => [
                        'update' => function ($url, $model) {
                            $customurl=Yii::$app->getUrlManager()->createUrl(['/home/updateadministrator','id'=>$model['id']]); 
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $customurl,
                                                    ['title' => Yii::t('yii', 'Редактировать'), 'data-pjax' => '0']);
                        },
                        'delete' => function ($url, $model) {
                            $customurl=Yii::$app->getUrlManager()->createUrl(['/home/deleteadministrator','id'=>$model['id']]);
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-trash"></span>', $customurl,
                                                    ['title' => Yii::t('yii', 'Удалить'), 'data-pjax' => '0', 
                                                    'data-confirm' => 'Вы уверены что хотите удалить запрос?', 
                                                    'data-method' => 'post']);
                        }
                    ],
                    'template' => '{update} {delete}',
                ],
            ],
        ]); 
    }
    ?>
    <?php Pjax::end() ?>
    </div>