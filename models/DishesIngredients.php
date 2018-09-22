<?php

namespace common\modules\povarenok\models;

use Yii;

/**
 * This is the model class for table "dishes_ingredients".
 *
 * @property integer $id
 * @property integer $dish_id
 * @property integer $ingredient_id
 *
 * @property Dishes $dish
 * @property Ingredients $ingredient
 */
class DishesIngredients extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dishes_ingredients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dish_id', 'ingredient_id'], 'integer'],
            [['dish_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dishes::className(), 'targetAttribute' => ['dish_id' => 'id']],
            [['ingredient_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ingredients::className(), 'targetAttribute' => ['ingredient_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Код',
            'dish_id' => 'Код блюда',
            'ingredient_id' => 'Код ингредиента',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDish()
    {
        return $this->hasOne(Dishes::className(), ['id' => 'dish_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIngredient()
    {
        return $this->hasOne(Ingredients::className(), ['id' => 'ingredient_id']);
    }


}
