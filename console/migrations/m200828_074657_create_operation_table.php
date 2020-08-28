<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%operation}}`.
 */
class m200828_074657_create_operation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%operation}}', [
            'id' => $this->primaryKey(),
            'service_price_id' => $this->integer(),
            'price' => $this->decimal(10,2),
            'owner' => $this->integer(),
            'created_at' => $this->integer()
        ]);
        $this->addForeignKey('operation_service_price', 'operation', 'service_price_id', 'service_price', 'id');
        $this->addForeignKey('operation_user', 'operation', 'owner', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('operation_user', 'operation');
        $this->dropForeignKey('operation_service_price', 'operation');
        $this->dropTable('{{%operation}}');
    }
}
