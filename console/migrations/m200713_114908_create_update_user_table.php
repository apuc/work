<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%update_user}}`.
 */
class m200713_114908_create_update_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%update_user}}', [
            'user_id' => $this->integer()->notNull(),
            'update_id' => $this->integer()->notNull(),
        ]);
        $this->addPrimaryKey('update_user_pk', 'update_user', ['user_id', 'update_id']);
        $this->addForeignKey('update_user_update', 'update_user', 'update_id', 'update', 'id');
        $this->addForeignKey('update_user_user', 'update_user', 'user_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('update_user_update', 'update_user');
        $this->dropForeignKey('update_user_user', 'update_user');
        $this->dropTable('{{%update_user}}');
    }
}
