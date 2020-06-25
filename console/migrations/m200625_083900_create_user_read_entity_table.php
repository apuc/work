<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_read_entity}}`.
 */
class m200625_083900_create_user_read_entity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_read_entity}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->comment('Пользователь, просмотревший сущность'),
            'subject' => $this->string(50)->notNull()->comment('Сущность'),
            'subject_id' => $this->integer()->notNull()->comment('ID сущности')
        ]);
        $this->addForeignKey(
            'user_read_entity_user',
            'user_read_entity',
            'user_id',
            'user',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'user_read_entity_user',
            'user_read_entity'
        );
        $this->dropTable('{{%user_read_entity}}');
    }
}
