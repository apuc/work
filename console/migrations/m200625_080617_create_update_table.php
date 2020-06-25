<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%update}}`.
 */
class m200625_080617_create_update_table extends Migration
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
            'created_at' => $this->integer()->notNull()->comment('Создана'),
            'updated_at' => $this->integer()->notNull()->comment('Изменена'),
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
