<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%dialog_user}}`.
 */
class m190909_114817_create_dialog_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('dialog_user', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'dialog_id' => $this->integer(),
            'created_at' => $this->integer(),
        ]);
        $this->addForeignKey('dialog_user_user', 'dialog_user', 'user_id', 'user', 'id');
        $this->addForeignKey('dialog_user_dialog', 'dialog_user', 'dialog_id', 'dialog', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('dialog_user_user', 'dialog_user');
        $this->dropForeignKey('dialog_user_dialog', 'dialog_user');
        $this->dropTable('dialog_user');
    }
}
