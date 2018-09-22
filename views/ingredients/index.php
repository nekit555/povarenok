<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\modules\povarenok\models\IngredientsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ингредиенты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ingredients-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить ингредиент', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name:text:Название ингредиента',
            [
                'attribute'=>'status',
                'filter'=>array("0"=>"Скрыт","1"=>"Отображается"),
                'content'=>function($data) {
                    return $data->getStatusName($data->status);
                },
                'label'=>'Статус',
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Действия', 
                'headerOptions' => ['width' => '80'],
                'template' => '{update} {delete}{link}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>