<?php

namespace common\modules\povarenok\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ingredients".
 *
 * @property integer $id
 * @property string $name
 * @property integer $status
 *
 * @property DishesIngredients[] $dishesIngredients
 */
class Ingredients extends ActiveRecord
{
    
    const STATUS_INACTIVE = 0,
          STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ingredients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Код ингредиента',
            'name' => 'Название ингредиента',
            'status' => 'Статус',
        ];
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }
        DishesIngredients::deleteAll(['ingredient_id' => $this->id]);      
        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDishesIngredients()
    {
        return $this->hasMany(DishesIngredients::className(), ['ingredient_id' => 'id']);
    }

    public function getDishes()
    {
        return $this->hasMany(Dishes::className(), ['id' => 'dish_id'])->viaTable('dishes_ingredients', ['ingredient_id' => 'id']);
    }

    /**
     * Получить название статуса по ID
     * @return string
     */
    public function getStatusName($status_id) 
    {
        switch ($status_id) {
            case self::STATUS_INACTIVE:
                return 'Скрыт';
                break;
            case self::STATUS_ACTIVE:
                return 'Отображается';
                break;
            
            default:
                return 'Неизвестный атрибут';
                break;
        }
    }

    public static function getUniqueArray($key, $array){
        $arrayKeys = []; 
        $resultArray = []; 
        foreach($array as $one) { 
            if(!in_array($one[$key], $arrayKeys)){ 
                $arrayKeys[] = $one[$key];
                $resultArray[] = $one;
            }
        }
        return $resultArray;
    }


}
