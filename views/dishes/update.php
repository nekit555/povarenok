<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\povarenok\models\Dishes */

$this->title = 'Редактировать блюдо: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Блюда', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="dishes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data' => $data
    ]) ?>

</div>