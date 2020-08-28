<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%service_price}}`.
 */
class m200824_113543_create_service_price_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%service_price}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'alias' => $this->string(),
            'price' => $this->decimal(10,2)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%service_price}}');
    }
}
