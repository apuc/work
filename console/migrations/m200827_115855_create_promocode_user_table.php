<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%promocode_user}}`.
 */
class m200827_115855_create_promocode_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%promocode_user}}', [
            'user_id' => $this->integer(),
            'promocode_id' => $this->integer()
        ]);
        $this->addPrimaryKey('promocode_user_PK', 'promocode_user', ['user_id', 'promocode_id']);
        $this->addForeignKey('promocode_user_user', 'promocode_user', 'user_id', 'user', 'id');
        $this->addForeignKey('promocode_user_promocode', 'promocode_user', 'promocode_id', 'promocode', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('promocode_user_user', 'promocode_user');
        $this->dropForeignKey('promocode_user_promocode', 'promocode_user');
        $this->dropTable('{{%promocode_user}}');
    }
}
