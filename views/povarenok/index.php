<?php


use kartik\select2\Select2;
use yii\helpers\Html;


$this->title = 'Поиск блюд';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-dishes">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Select2::widget([
        'name' => 'selected',
        'language' => 'ru',
        'id' => 'ingredient-select',
        'data' => $ingredients,
        'showToggleAll' => false,
        'options' => ['placeholder' => 'Выберите ингредиент ...', 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => true,
            'maximumSelectionLength' => 5,
        ],
    ]); ?>
    <div id="search-result">

    </div>
</div>

<?php
$script = <<< JS
    $(document).ready(function () {
    $(document).on('change', '#ingredient-select', function () {
        $.ajax({
            url: '/povarenok/povarenok/search',
            type: 'post',
            data: {'selected': $(this).val()},
            dataType: 'JSON',
            success: function (res) {
                console.log(res);
                if (res.status === 'ok') {
                    $('#search-result').html(res.result);
                } else {
                    $('#search-result').html('<p class="text-danger">Возникла ошибка</p>');
                }
            },
            error: function (res) {
                console.log(res);
            }
        });
        return false;
    });     
});
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);
?>