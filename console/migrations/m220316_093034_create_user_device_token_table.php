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
            'user_id' => $this->integer(11),
            'device_id' => $this->string(256),
            'access_token' => $this->string(512),
            'access_token_expiration_time' => $this->timestamp(),
            'refresh_token' => $this->string(512),
            'refresh_token_expiration_time' => $this->timestamp(),
        ]);
        $this->addPrimaryKey('user_device_token', 'user_device_token', ['user_id', 'device_id']);
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
