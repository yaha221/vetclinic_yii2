<?php
    $this->title = 'Животные';

    use yii\grid\GridView;
    use yii\widgets\Pjax;
    use yii\helpers\Html;
?>
    <div class="row mt-5 p-3">
    <p><?php 
    if (Yii::$app->user->can('administrator')) {
        echo Html::a(Yii::t('','Добавить {modelClass}', [
            'modelClass' => 'животное',
        ]), ['updatepet'], ['class' => 'btn btn-success']); 
    }
?>
    </p>
    <?php Pjax::begin() ?>
        <?php if (Yii::$app->user->can('administrator')) {
            echo GridView::widget([
                'dataProvider' => $dataProvider,
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
                    'visible' => Yii::$app->user->can('administrator'),
                    'buttons' => [
                        'update' => function ($url, $model) {
                            $customurl=Yii::$app->getUrlManager()->createUrl(['/home/updatepet','id'=>$model['id']]); 
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $customurl,
                            ['title' => Yii::t('yii', 'Редактировать'), 'data-pjax' => '0']);
                        },
                        'delete' => function ($url, $model) {
                            $customurl=Yii::$app->getUrlManager()->createUrl(['/pet/deletepet','id'=>$model['id']]);
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