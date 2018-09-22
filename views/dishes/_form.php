<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<div class="dishes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ingredientsArray')->widget(\kartik\select2\Select2::classname(), [
        'name' => 'ingredients',
        'language' => 'ru',
        'value' => $model->ingredients,
        'data' => $data,
        'maintainOrder' => true,
        'showToggleAll' => false,
        'toggleAllSettings' => [
            'unselectLabel' => '<i class="glyphicon glyphicon-remove-sign"></i> Убрать все',
            'unselectOptions' => ['class' => 'text-danger'],
        ],
        'options' => ['placeholder' => 'Выберите ингредиенты', 'multiple' => true],
        'pluginOptions' => [
            'tags' => false,
            'maximumSelectionLength' => 5,
        ],
    ])->label('Ингредиенты'); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
