<?php

use yii\db\Migration;

/**
 * Class m180918_092907_dishes_menu
 */
class m180918_092907_dishes_menu extends Migration
{

    public function safeUp()
    {     

        $tableOptions = null;
    
        //Опции для mysql
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        //Создать таблицу с ингредиентами
        $this->createTable('{{%ingredients}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'status' => $this->integer(1)->notNull()->defaultValue(1),
        ], $tableOptions);

        //Создать таблицу с блюдами
        $this->createTable('{{%dishes}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ], $tableOptions);

    }

    // Удалить таблицы при откате миграции
    public function safeDown()
    {

        $this->dropTable('{{%ingredients}}');
        $this->dropTable('{{%dishes}}');

        return false;
    }

}
