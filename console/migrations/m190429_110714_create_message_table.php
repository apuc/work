<?php

use yii\db\Migration;

/**
 * Handles the creation of table `message`.
 */
class m190429_110714_create_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('message', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'text' => $this->text(),
            'receiver_id' => $this->integer(),
            'sender_id' => $this->integer(),
            'subject' => $this->integer(),
            'subject_id' => $this->integer(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp()
        ]);
        $this->addForeignKey('message_receiver', 'message', 'receiver_id', 'user', 'id');
        $this->addForeignKey('message_sender', 'message', 'sender_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('message_receiver', 'message');
        $this->dropForeignKey('message_sender', 'message');
        $this->dropTable('message');
    }
}
