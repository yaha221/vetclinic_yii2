<?php
    $this->title = 'Обновить';
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
    <div class="row mt-5 p-5">
        <h1>Обновиться</h1>
        <?php $form = ActiveForm::begin([
            'id' => 'client-form',
            'enableAjaxValidation' => true,
        ]); ?>
        
        <?= $form->field($fullForm, 'fio')->textInput()->label('Инициалы') ?>
        
        <?= $form->field($fullForm, 'age')->textInput()->label('Возраст') ?>
        
        <?= $form->field($fullForm, 'phone')->textInput()->label('Телефон') ?>
        
        <div class="form-group">
            <?= Html::submitButton('Обновить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>