<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%send_queue}}`.
 */
class m190719_135241_create_send_queue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%send_queue}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string(255)->notNull(),
            'user_id' => $this->integer(11)->null(),
            'template' => $this->string(255)->notNull(),
            'options' => $this->text(),
            'status' => $this->integer(1),
            'dt_send' => $this->integer(11),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%send_queue}}');
    }
}
