<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%promocode}}`.
 */
class m200813_112717_create_promocode_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%promocode}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(50)->notNull(),
            'active_until' => $this->integer(),
            'created_at' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%promocode}}');
    }
}
