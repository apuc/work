<?php

use yii\db\Migration;

/**
 * Handles the creation of table `key_value`.
 */
class m190507_143428_create_key_value_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('key_value', [
            'id' => $this->primaryKey(),
            'key' => $this->string(),
            'value' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('key_value');
    }
}
