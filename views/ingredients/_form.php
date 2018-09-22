<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="ingredients-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    
    <?php $param = ['options' =>[ '1' => ['Selected' => true]]]; ?>
    <?= $form->field($model, 'status')->dropdownList([
    	'0'=>'Скрыт',
    	'1'=>'Отображается',
    ], $param)

    ?>

    <div class="form-group">
        <?= Html::a('Назад', 'index', ['class' => 'btn btn-default']) ?>
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
