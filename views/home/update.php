<?php
    $this->title = $title;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
    <div class="row mt-5 p-5">
        <h1>Обновиться</h1>
        <?php $form = ActiveForm::begin([
            'id' => 'pet-form',
            'enableAjaxValidation' => true,
        ]); ?>
        
        <?= $form->field($fullForm, 'name')->textInput()->label('Имя питомца') ?>

        <?= $form->field($fullForm, 'vet')->dropDownList($vets, ['prompt' => 'Выберите ветеринара'])->label('Ветеринар')?>

        <?= $form->field($fullForm, 'client')->dropDownList($clients, ['prompt' => 'Выберите клиента'])->label('Клиент') ?>
        
        <div class="form-group">
            <?= Html::submitButton('Обновить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>