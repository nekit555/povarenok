<?php

use yii\db\Migration;

/**
 * Class m180920_112039_ingredients_dishes
 */
class m180920_112039_ingredients_dishes extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%dishes_ingredients}}', [
            'id' => $this->primaryKey(),
            'dish_id' => $this->integer(),
            'ingredient_id' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('fk_to_dishes', 'dishes_ingredients', 'dish_id', 'dishes', 'id');
        $this->addForeignKey('fk_to_ingredients', 'dishes_ingredients', 'ingredient_id', 'ingredients', 'id');

    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_to_dishes', 'dishes_ingredients');
        $this->dropForeignKey('fk_to_ingredients', 'dishes_ingredients');

        $this->dropTable('dishes_ingredients');
    }

}
