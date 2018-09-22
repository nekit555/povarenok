<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\modules\povarenok\models\DishesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список блюд';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dishes-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить блюдо', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name:text:Название блюда',
            [
                'attribute'=>'ingredient_id',
                'label'=>'Ингредиенты',
                'value' =>  function($data) {
                    $str ='';
                    foreach($data['ingredients'] as $item)
                    {
                        $str.=$item['name'].', ';
                    }
                    return $str;
                },
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