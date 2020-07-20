<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%update}}`.
 */
class m200713_111419_create_update_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%update}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->comment('Заголовок'),
            'text' => $this->text()->notNull()->comment('Текст'),
            'created_at' => $this->integer()->notNull()->comment('Дата создания'),
            'updated_at' => $this->integer()->notNull()->comment('Дата последнего изменения')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%update}}');
    }
}
