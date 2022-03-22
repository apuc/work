<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_device_token}}`.
 */
class m220316_093034_create_user_device_token_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_device_token}}', [
            'user_id' => $this->integer(11)->notNull(),
            'device_id' => $this->string(128)->notNull(),
            'access_token' => $this->string(1024)->unique()->notNull(),  // по требованиям OAuth 2.0
            'access_token_expiration_time' => $this->integer()->notNull(),
            'refresh_token' => $this->string(256)->unique()->notNull(),  // по требованиям OAuth 2.0
            'refresh_token_expiration_time' => $this->integer()->notNull(),
        ]);
        $this->addPrimaryKey('user_device_ids', 'user_device_token', ['user_id', 'device_id']);
        $this->addForeignKey('user_token_device_user', 'user_device_token', 'user_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_device_token}}');
    }
}
