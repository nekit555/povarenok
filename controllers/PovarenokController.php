<?php

namespace common\modules\povarenok\controllers;

use Yii;
use yii\web\Controller;
use common\modules\povarenok\models\DishesIngredients;
use common\modules\povarenok\models\Ingredients;
use yii\helpers\Html;
use yii\web\Response;

/**
 * Povarenok controller for the `povarenok` module
 */
class PovarenokController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $ingredients = Ingredients::find()->select(['name', 'id'])->indexBy('id')->column();
        return $this->render('index', [
            'ingredients' => $ingredients,
        ]);
    }

    /**
     * @return array in json
     */
    public function actionSearch()
    {
        if (Yii::$app->request->isAjax) {

	        Yii::$app->response->format = Response::FORMAT_JSON;

	        $selected = \Yii::$app->request->post('selected');

	        $matches = DishesIngredients::find()
	            ->select(['dishes.name', 'dishes_ingredients.dish_id', 'COUNT(ingredients.id) as MatchCount'])
	            ->leftJoin('ingredients', 'ingredients.id = dishes_ingredients.ingredient_id')
	            ->leftJoin('dishes', 'dishes.id = dishes_ingredients.dish_id')
	            ->andWhere(['in', 'ingredient_id', $selected])
	            ->groupBy('dishes_ingredients.dish_id')
	            ->having('COUNT(ingredient_id)>=2')
	            ->orderBy('MatchCount DESC')
	            ->asArray()
	            ->all();

	        if (sizeof($selected) < 2) {
	            return [
	                'status' => 'ok',
	                'result' => '<p class="text-warning">Выберите больше ингредиентов</p>'
	            ];
	        }

	        if (empty($matches)) {
	            return [
	                'status' => 'ok',
	                'result' => '<p class="text-warning">Ничего не найдено</p>'
	            ];
	        }

					$iterator = 0;

          $someMatches = [];
          $fullMatches = [];

	        foreach ($matches as &$matchElement) {

	        	$dishQuery = Ingredients::find()->joinWith('dishesIngredients')->where(['dish_id' => $matchElement['dish_id']]);
            $dish = $dishQuery->all();
            $count = $dishQuery->count();

            $ingredientsArray = [];

            // Перебираем все игредиенты блюда
            foreach ($dish as $item) {
                if ( ((int)$item->status === (int)Ingredients::STATUS_INACTIVE) && (in_array($item->id, $selected)) ) {
                    $matchElement['status'] = Ingredients::STATUS_INACTIVE; // Если игредиент отключен, ставим неактивный статус блюду
                    break;
                } else {
                		$ingredientsArray[] = in_array($item->id, $selected) ?
                    Html::tag('span', $item->name, ['class' => 'text-success'])
                    :
                    $item->name;
                		$matchElement['status'] = Ingredients::STATUS_ACTIVE;
                }
            }

        		if ($matchElement['status'] === Ingredients::STATUS_ACTIVE) {
	        		
	        		
        			// Если полное совпадение ингредиентов у блюда - создаем массив полных блюд
	        		if ( $matchElement['MatchCount'] == $count && $count == sizeof($selected)) {
	        			$fullMatches[$iterator]['name'] = $matchElement['name'];
	        			$fullMatches[$iterator]['count'] = $matchElement['MatchCount'];
            	} 
            	// Если нет, то добавляем в частичный массив
	            $someMatches[$iterator]['name'] = $matchElement['name'];
	            $someMatches[$iterator]['count'] = $matchElement['MatchCount'];

        		}

        		$iterator++;
            

	        }


	        return [
	        		'result' => $this->renderAjax('_item', [
	        				'dishes' => (!empty($fullMatches)) ? $fullMatches : $someMatches,
	              	'dish' => $dish,
	             ]),
	            'status' => 'ok'
	        ];
	      } else {
	      	die("Ошибка!");
	      }
    }
}
